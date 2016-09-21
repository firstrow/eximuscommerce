<?php

Yii::import('application.modules.csv.components.CsvImage');
Yii::import('application.modules.store.StoreModule');
Yii::import('application.modules.store.models.*');

/**
 * Import products from csv format
 * Images must be located at ./uploads/importImages
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
	 * @var array
	 */
	protected $categoriesPathCache = array();

	/**
	 * @var array
	 */
	protected $productTypeCache = array();

	/**
	 * @var array
	 */
	protected $manufacturerCache = array();

	/**
	 * @var array
	 */
	protected $attributesCache = array();

	/**
	 * @var int
	 */
	protected $line = 1;

	/**
	 * @var array
	 */
	protected $errors = array();

	/**
	 * @var array
	 */
	public $stats = array(
		'created'=>0,
		'updated'=>0,
	);

	/**
	 * @return bool validate csv file
	 */
	public function validate()
	{
		// Check file exists and readable
		if(is_uploaded_file($this->file))
		{
			$newDir = Yii::getPathOfAlias('application.runtime').'/tmp.csv';
			move_uploaded_file($this->file, $newDir);
			$this->file = $newDir;
		}elseif(file_exists($this->file))
		{
			// ok. file exists.
		}
		else
		{
			$this->errors[]= array('line'=>0,'error'=>Yii::t('CsvModule.admin', 'Файл недоступен.'));
			return false;
		}

		$file = $this->getFileHandler();

		// Read first line to get attributes
		$line = fgets($file);
		$this->csv_columns = str_getcsv($line, $this->delimiter, $this->enclosure);

		foreach(array('category','name','type','price') as $column)
		{
			if(!in_array($column, $this->csv_columns))
				$this->errors[]=array('line'=>0, 'error'=>Yii::t('CsvModule.admin', 'Укажите обязательную колонку {column}.',array('{column}'=>$column)));
		}

		return !$this->hasErrors();
	}

	/**
	 * Here we go
	 */
	public function import()
	{
		$file = $this->getFileHandler();
		$line = fgets($file); // Skip first
		// Process lines
		$this->line = 1;
		while(($row = fgetcsv($file, $this->maxRowLength, $this->delimiter, $this->enclosure)) !== false)
		{
			$row = $this->prepareRow($row);
			$this->importRow($row);
			$this->line++;
		}
	}

	/**
	 * Create/update product from key=>value array
	 * @param $data array of product attributes
	 */
	protected function importRow($data)
	{
		if(!isset($data['category']) || empty($data['category']))
			$data['category'] = 'root';

		$newProduct = false;
		$category_id = $this->getCategoryByPath($data['category']);

		// Search product by name, category
		// or create new one
		$cr = new CDbCriteria;
		$cr->with = array('translate');

		if(isset($data['url']) && !empty($data['url']) && $data['url'] != '')
			$cr->compare('t.url', $data['url']);

		if(isset($data['sku']) && !empty($data['sku']) && $data['sku'] != '')
			$cr->compare('t.sku', $data['sku']);
		else
			$cr->compare('translate.name', $data['name']);

		$model = StoreProduct::model()
			->applyCategories($category_id)
			->find($cr);

		if(!$model)
		{
			$newProduct=true;
			$model = new StoreProduct;
			$this->stats['created']++;
		}else{
			$this->stats['updated']++;
		}

		// Process product type
		$model->type_id = $this->getTypeIdByName($data['type']);
		// Manufacturer
		if(isset($data['manufacturer']) && !empty($data['manufacturer']))
			$model->manufacturer_id = $this->getManufacturerIdByName($data['manufacturer']);

		// Update attributes
		$eav = array();
		foreach($data as $key=>$val)
		{
			try{
				$model->$key = $val;
			}catch(CException $e){
				// Process eav
				if(!in_array($key, array('category','type','manufacturer', 'image', 'additionalCategories')) && !empty($val))
					$eav[$key] = $this->processEavData($model->type_id, $key, $val);
			}
		}

		if($model->validate())
		{
			$categories=array($category_id);

			if(isset($data['additionalCategories']))
				 $categories=array_merge($categories, $this->getAdditionalCategories($data['additionalCategories']));

			if(!$newProduct)
			{
				foreach($model->categorization as $c)
					$categories[]=$c->category;
				$categories=array_unique($categories);
			}

			// Save product
			$model->save();
			// Update EAV data
			if(!empty($eav))
				$model->setEavAttributes($eav, true);
			// Update categories
			$model->setCategories($categories, $category_id);
			// Process product main image if product doesn't have one
			if(isset($data['image']) && !empty($data['image']))
			{
				$image=CsvImage::create($data['image']);
				if($image)
                    $model->mainImage = $model->addImage($image);
			}
            $model->save();
		}
		else
		{
			$errors = $model->getErrors();
			$error  = array_shift($errors);

			$this->errors[] = array(
				'line'  => $this->line,
				'error '=> $error[0],
			);
		}
	}

	/**
	 * Get additional categories array from string separated by ";"
	 * E.g. Video/cat1;Video/cat2
	 * @param $str
	 * @return array
	 */
	public function getAdditionalCategories($str)
	{
		$result=array();
		$parts=explode(';', $str);
		foreach($parts as $path)
			$result[]=$this->getCategoryByPath(trim($path));
		return $result;
	}
	
	/**
	 * @param $type_id
	 * @param $attribute_name
	 * @param $attribute_value
	 * @return mixed
	 */
	public function processEavData($type_id, $attribute_name, $attribute_value)
	{
		$attribute = $this->getAttributeByName($attribute_name);
		if(!$attribute)
		{
			// Create new attribute
			$attribute = new StoreAttribute;
			$attribute->name  = $attribute_name;
			$attribute->title = ucfirst(str_replace('_',' ',$attribute_name));
			$attribute->type  = StoreAttribute::TYPE_DROPDOWN;
			$attribute->display_on_front = true;
			$attribute->save();
			$this->attributesCache[$attribute_name]=$attribute;

			// Add to type
			$typeAttribute = new StoreTypeAttribute;
			$typeAttribute->type_id = $type_id;
			$typeAttribute->attribute_id = $attribute->id;
			$typeAttribute->save();

			// Create new option
			$option = $this->addOptionToAttribute($attribute->id, $attribute_value);
		}
		else
		{
			$cr = new CDbCriteria;
			$cr->with = 'option_translate';
			$cr->compare('option_translate.value', $attribute_value);
			$cr->compare('t.attribute_id', $attribute->id);
			$option = StoreAttributeOption::model()->find($cr);

			if(!$option)
				$option = $this->addOptionToAttribute($attribute->id, $attribute_value);
		}

		return $option->id;
	}

	/**
	 * @param $name
	 * @return CActiveRecord
	 */
	public function getAttributeByName($name)
	{
		if(isset($this->attributesCache[$name]))
			return $this->attributesCache[$name];

		$this->attributesCache[$name]=StoreAttribute::model()->findByAttributes(array('name'=>$name));
		return $this->attributesCache[$name];
	}

	/**
	 * @param $attribute_id
	 * @param $value
	 * @return StoreAttributeOption
	 */
	public function addOptionToAttribute($attribute_id, $value)
	{
		// Add option
		$option = new StoreAttributeOption;
		$option->attribute_id = $attribute_id;
		$option->value = $value;
		$option->save();
		return $option;
	}

	/**
	 * Find or create manufacturer
	 * @param $name
	 * @return integer
	 */
	public function getManufacturerIdByName($name)
	{
		if(isset($this->manufacturerCache[$name]))
			return $this->manufacturerCache[$name];

		$cr = new CDbCriteria;
		$cr->with = array('man_translate');
		$cr->compare('man_translate.name', $name);
		$model = StoreManufacturer::model()->find($cr);

		if(!$model)
		{
			$model = new StoreManufacturer;
			$model->name = $name;
			$model->save();
		}

		$this->manufacturerCache[$name] = $model->id;
		return $model->id;
	}

	/**
	 * Get product type by name. If type not exists - create new one.
	 * @param $name
	 * @return int
	 */
	public function getTypeIdByName($name)
	{
		if(isset($this->productTypeCache[$name]))
			return $this->productTypeCache[$name];

		$model = StoreProductType::model()->findByAttributes(array(
			'name'=>$name,
		));

		if(!$model)
		{
			$model = new StoreProductType;
			$model->name = $name;
			$model->save();
		}

		$this->productTypeCache[$name] = $model->id;

		return $model->id;
	}

	/**
	 * Get category id by path. If category not exits it will new one.
	 * @param $path string Main/Music/Rock
	 * @return integer category id
	 */
	protected function getCategoryByPath($path)
	{
		if(isset($this->categoriesPathCache[$path]))
			return $this->categoriesPathCache[$path];

		if($this->rootCategory===null)
			$this->rootCategory = StoreCategory::model()->findByPk(1);

		$result = preg_split($this->subCategoryPattern, $path, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		$result = array_map('stripcslashes',$result);

		$parent = $this->rootCategory;

		$level = 2; // Level 1 is only root
		foreach($result as $name)
		{
			$cr = new CDbCriteria;
			$cr->with = array('cat_translate');
			$cr->compare('cat_translate.name', $name);
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

		// Cache category id
		$this->categoriesPathCache[$path] = $model->id;

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
		return array_filter($row); // Remove empty keys and return result
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
	 * @return bool
	 */
	public function hasErrors()
	{
		return !empty($this->errors);
	}

	/**
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * @param string $eav_prefix
	 * @return array
	 */
	public function getImportableAttributes($eav_prefix='')
	{
		$attributes = array(
			'type'                   => Yii::t('StoreModule.core', 'Тип'),
			'name'                   => Yii::t('StoreModule.core', 'Название'),
			'category'               => Yii::t('StoreModule.core', 'Категория'),
			'additionalCategories'   => Yii::t('StoreModule.core', 'Доп. Категории'),
			'manufacturer'           => Yii::t('StoreModule.core', 'Производитель'),
			'sku'                    => Yii::t('StoreModule.core', 'Артикул'),
			'url'                    => Yii::t('StoreModule.core', 'URL'),
			'price'                  => Yii::t('StoreModule.core', 'Цена'),
			'is_active'              => Yii::t('StoreModule.core', 'Активен'),
			'image'                  => Yii::t('StoreModule.core', 'Главное изображение'),
			'short_description'      => Yii::t('StoreModule.core', 'Краткое описание'),
			'full_description'       => Yii::t('StoreModule.core', 'Полное описание'),
			'meta_title'             => Yii::t('StoreModule.core', 'Meta Title'),
			'meta_keywords'          => Yii::t('StoreModule.core', 'Meta Keywords'),
			'meta_description'       => Yii::t('StoreModule.core', 'Meta Description'),
			'layout'                 => Yii::t('StoreModule.core', 'Макет'),
			'view'                   => Yii::t('StoreModule.core', 'Шаблон'),
			'quantity'               => Yii::t('StoreModule.core', 'Количество'),
			'availability'           => Yii::t('StoreModule.core', 'Доступность'),
			'created'                => Yii::t('StoreModule.core', 'Дата создания'),
			'updated'                => Yii::t('StoreModule.core', 'Дата обновления'),
		);

		foreach(StoreAttribute::model()->findAll() as $attr)
			$attributes[$eav_prefix.$attr->name] = $attr->title;

		return $attributes;
	}

	/**
	 * Close file handler
	 */
	public function __destruct()
	{
		if($this->fileHandler!==null)
		{
			fclose($this->fileHandler);
			//unlink($this->file);
		}
	}
}
