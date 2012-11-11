<?php

class FileManagerController extends SAdminController
{
	
	public function actionIndex()
	{
		$elFinderPath = Yii::getPathOfAlias('ext.elrte.lib.elfinder.php');

		include $elFinderPath.'/elFinderConnector.class.php';
		include $elFinderPath.'/elFinder.class.php';
		include $elFinderPath.'/elFinderVolumeDriver.class.php';
		include $elFinderPath.'/elFinderVolumeLocalFileSystem.class.php';

		function access($attr, $path, $data, $volume) {
			return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
				? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
				:  null;                                    // else elFinder decide it itself
		}

		$opts = array(
			// 'debug' => true,
			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
					'path'          => Yii::getPathOfAlias('webroot.uploads'),         // path to files (REQUIRED)
					'URL'           => '/uploads/', // URL to files (REQUIRED)
					'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
				)
			)
		);

		// run elFinder
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
		exit;
	}

}