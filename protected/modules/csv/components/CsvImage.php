<?php

Yii::import('system.utils.CFileHelper');

/**
 * Class to make easier importing images
 */
class CsvImage extends CUploadedFile
{

	private $_name;
	private $_tempName;
	private $_type;
	private $_size;
	private $_error;

	public function __construct($name,$tempName,$type,$size,$error)
	{
		$this->_name=$name;
		$this->_tempName=$tempName;
		$this->_type=$type;
		$this->_size=$size;
		$this->_error=$error;
		parent::__construct($name, $tempName, $type, $size, $error);
	}

	/**
	 * @static
	 * @param string $image name in ./uploads/importImages/ e.g. somename.jpg
	 */
	public static function create($image)
	{
		$tmpName=Yii::getPathOfAlias('application.modules.install.importImages').DIRECTORY_SEPARATOR.$image;

		if(!file_exists($tmpName))
			return false;

		return new CsvImage($image, $tmpName, CFileHelper::getMimeType($tmpName),filesize($tmpName), false);
	}

	/**
	 * @param string $file
	 * @param bool $deleteTempFile
	 */
	public function saveAs($file, $deleteTempFile=false)
	{
		return copy($this->_tempName, $file);
	}
}
