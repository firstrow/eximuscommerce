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

	public function actionSample()
	{
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"sample.csv\"");
		echo '"name";"category";"price";"type"'."\n";
		echo '"Product Name";"Category/Subcategory";"10.99";"Base Product"'."\n";
		exit;
	}
}
