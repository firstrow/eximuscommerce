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
		$importer = new CsvImporter;

		if(Yii::app()->request->isPostRequest && isset($_FILES['file']))
		{
			$importer->file = $_FILES['file']['tmp_name'];

			if($importer->validate() && !$importer->hasErrors())
				$importer->import();
		}

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
