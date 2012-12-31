<?php

Yii::import('csv.components.CsvImporter');
Yii::import('csv.components.CsvExporter');

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
		$importer = new CsvImporter;

		if(Yii::app()->request->isPostRequest && isset($_FILES['file']))
		{
			$importer->file = $_FILES['file']['tmp_name'];

			if($importer->validate() && !$importer->hasErrors())
			{
				// Create db backup
				if(isset($_POST['create_dump']) && $_POST['create_dump'])
				{
					Yii::import('application.components.SDatabaseDumper');
					$dumper = new SDatabaseDumper;

					$file = Yii::getPathOfAlias('webroot.protected.backups').DIRECTORY_SEPARATOR.'dump_'.date('Y-m-d_H_i_s').'.sql';

					if(is_writable(Yii::getPathOfAlias('webroot.protected.backups')))
					{
						if(function_exists('gzencode'))
							file_put_contents($file.'.gz', gzencode($dumper->getDump()));
						else
							file_put_contents($file, $dumper->getDump());
					}else
						throw new CHttpException(503, Yii::t('CsvModule.admin', 'Ошибка. Директория для бэкапов недоступна для записи.'));
				}
				$importer->import();
			}
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
		$exporter = new CsvExporter;
		if(Yii::app()->request->isPostRequest && isset($_POST['attributes']) && !empty($_POST['attributes']))
			$exporter->export($_POST['attributes']);

		$this->render('export', array(
			'exporter'=>$exporter,
			'importer'=>new CsvImporter,
		));
	}

	/**
	 * Sample csv file
	 */
	public function actionSample()
	{
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"sample.csv\"");
		echo '"name";"category";"price";"type"'."\n";
		echo '"Product Name";"Category/Subcategory";"10.99";"Base Product"'."\n";
		Yii::app()->end();
	}
}
