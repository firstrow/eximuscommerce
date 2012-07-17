<?php

/**
 * Super secret license checker.
 */
class SLicenseChecker
{

	/**
	 * @static
	 * @return bool
	 */
	public static function check()
	{
		switch(substr($_SERVER['SERVER_ADDR'], 0, strrpos($_SERVER['SERVER_ADDR'], '.')))
		{
			case '127.0.1':
			case '127.0.0':
			case '172.16.0':
			case '192.168.0':
			case '10.0.0':
				return true;
			break;
		}

		// Check license file.
		$path=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'eximus_license.key';

		if(!file_exists($path) || !is_readable($path))
			return false;

		$serverName=str_replace(array('http://', 'www.'), array('',''), Yii::app()->request->serverName);
		$licenseFileContents=file_get_contents($path);

		if(trim($licenseFileContents)===base64_encode(base64_encode($serverName)))
			return true;

		return false;
	}
}
