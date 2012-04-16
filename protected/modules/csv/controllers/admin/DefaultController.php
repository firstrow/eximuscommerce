<?php

/**
 * DefaultController
 */
class DefaultController extends SAdminController
{

	/**
	 * Import products
	 */
	public function actionImport()
	{
		Yii::import('csv.components.CsvImporter');

		$importer = new CsvImporter();
		$importer->file = '/var/www/cms/protected/data/testNoDesc.csv';

		if($importer->validate())
			$importer->import();

		$this->render('import', array(
			'importer'=>$importer
		));
	}

	/**
	 * Export products
	 */
	public function actionExport()
	{
		$this->render('export');
	}
}
