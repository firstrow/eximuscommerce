<?php

Yii::import('application.modules.store.StoreModule');
Yii::import('application.modules.store.models.*');

/**
 * Import products from csv format
 */
class CsvImporter extends CComponent
{
	/**
	 * @var string column delimiter
	 */
	public $delimiter = ";";

	/**
	 * @var int
	 */
	public $maxRowLength = 10000;

	/**
	 * @var string
	 */
	public $enclosure = '"';

	/**
	 * @var string path to file
	 */
	public $file;

	/**
	 * @var string encoding.
	 */
	public $encoding;

	/**
	 * @var string
	 */
	public $subCategoryPattern = '/\\/((?:[^\\\\\/]|\\\\.)*)/';

	/**
	 * @var resource
	 */
	protected $fileHandler;

	/**
	 * Columns from first line. e.g array(category,price,name,etc...)
	 * @var array
	 */
	protected $csv_columns= array();

	/**
	 * @var null|StoreCategory
	 */
	protected $rootCategory = null;

	/**
	 * @return bool validate csv file
	 */
	public function validate()
	{
		// Check file exists and readable
		// Detect encoding
		// Validate all required fields present
		// Validate columns
		// Check type present
		return true;
	}

	/**
	 * Here we go
	 */
	public function import()
	{
		$file = $this->getFileHandler();

		// Read first line to get attributes
		$line = fgets($file);
		$this->csv_columns = str_getcsv($line, $this->delimiter, $this->enclosure);

		// Process lines
		while(($row = fgetcsv($file, $this->maxRowLength, $this->delimiter, $this->enclosure)) !== false)
		{
			$row = $this->prepareRow($row);
			$this->importRow($row);
		}
	}

	/**
	 * Create/update product from key/value array
	 * @param $data array of product attributes
	 */
	protected function importRow($data)
	{
		$category_id = $this->getCategoryByPath($data['category']);

		// Search product by name, category
		// or create new one
		$cr = new CDbCriteria;
		$cr->with = array('translate');

		// Search by sku or name
		if(isset($data['sku']) && !empty($data['sku']) && $data['sku'] != '')
			$cr->compare('t.sku', $data['sku']);
		else
			$cr->compare('translate.name', $data['name']);

		$cr->limit = 1;
		$model = StoreProduct::model()
			->applyCategories($category_id)
			->find($cr);

		if(!$model)
			$model = new StoreProduct;

		// Update attributes
		foreach($data as $key=>$val)
		{
			try{
				$model->$key = $val;
			}catch(CException $e){

			}
		}

		$model->type_id = 2;

		if($model->validate())
		{
			$model->save();
			$model->setCategories(array($category_id), $category_id);
		}
		else
		{
			var_dump($model->errors);
			var_dump($data);
		}
	}

	/**
	 * Get category id by path. If category not exits it will new one.
	 * @param $path string Main/Music/Rock
	 */
	protected function getCategoryByPath($path)
	{
		if($this->rootCategory===null)
			$this->rootCategory = StoreCategory::model()->findByPk(1);

		$result = preg_split($this->subCategoryPattern, $path, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		$result = array_map('stripcslashes',$result);

		$level = 2; // Level 1 is only root
		foreach($result as $name)
		{
			$cr = new CDbCriteria;
			$cr->with = array('cat_translate');
			$cr->compare('cat_translate.name', $name);
			$cr->limit = 1;
			$model = StoreCategory::model()->find($cr);

			if(!$model)
			{
				$model = new StoreCategory;
				$model->name = $name;
				$model->appendTo($parent);
			}

			$parent = $model;
			$level++;
		}

		if(isset($model))
			return $model->id;
		return 1; // root category
	}

	/**
	 * Apply column key to csv row.
	 * @param $row array
	 * @return array e.g array(key=>value)
	 */
	protected function prepareRow($row)
	{
		$row = array_map('trim',$row);
		$row = array_combine($this->csv_columns, $row);
		$row['created'] = date('Y-m-d H:i:s');
		$row['updated'] = date('Y-m-d H:i:s');
		return array_filter($row); // Remove empty keys and retund result
	}

	/**
	 * Read csv file.
	 * Check encoding. If !utf8 - convert.
	 * @return resource csv file
	 */
	protected function getFileHandler()
	{
		$test_content = file_get_contents($this->file);
		$is_utf8 = mb_detect_encoding($test_content, 'UTF-8', true);

		if ($is_utf8 == false)
		{
			// Convert all file content to utf-8 encoding
			$content = iconv('cp1251', 'utf-8', $test_content);
			$this->fileHandler= tmpfile();
			fwrite($this->fileHandler, $content);
			fseek($this->fileHandler, 0);
		}else
			$this->fileHandler = fopen($this->file, 'r');
		return $this->fileHandler;
	}

	/**
	 * Close file handler
	 */
	public function __destruct()
	{
		if($this->fileHandler!==null)
			fclose($this->fileHandler);
	}
}
