<?php

/**
 * Installation controller
 */
class DefaultController extends CController
{

	/**
	 * @var string
	 */
	public $layout='install';

	/**
	 * @var array
	 */
	public $writeAble = array(
		'protected/config/main.php',
		'protected/runtime',
		'assets',
		'uploads',
	);

	/**
	 * First step.
	 */
	public function actionIndex()
	{
		if(Yii::app()->request->getPost('ok'))
			$this->redirect($this->createUrl('configure'));
		$this->render('index');
	}

	/**
	 * Second step
	 */
	public function actionConfigure()
	{
		Yii::import('application.modules.install.forms.InstallConfigureForm');
		$model=new InstallConfigureForm;

		if(Yii::app()->request->isPostRequest && isset($_POST['InstallConfigureForm']))
		{
			$model->attributes=$_POST['InstallConfigureForm'];
			if($model->validate())
			{
				$model->install();
			}
		}

		$this->render('configure', array(
			'model'=>$model,
		));
	}

	/**
	 * Check if path is writeable
	 * @param $path
	 * @return bool
	 */
	public function isWritable($path)
	{
		$fullPath=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$path;
		return is_writable($fullPath);
	}

}
