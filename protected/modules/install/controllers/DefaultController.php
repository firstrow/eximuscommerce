<?php

Yii::import('application.modules.install.forms.*');

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
		'assets/productThumbs',
		'uploads',
		'uploads/product',
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
		$model=new InstallConfigureForm;
        $model->getDefaultConnect();

		if(Yii::app()->request->isPostRequest && isset($_POST['InstallConfigureForm']))
		{
			$model->attributes=$_POST['InstallConfigureForm'];
			if($model->validate())
			{
				$model->install();
				$this->redirect($this->createUrl('finish'));
			}
		}

		$this->render('configure', array(
			'model'=>$model,
		));
	}

	public function actionFinish()
	{
		$model=new InstallFinishForm;

		if(Yii::app()->request->isPostRequest && isset($_POST['InstallFinishForm']))
		{
			$model->attributes=$_POST['InstallFinishForm'];
			if($model->validate())
			{
				$model->install();
				$this->redirect($this->createUrl('completed'));
			}
		}

		$this->render('finish', array(
			'model'=>$model,
		));
	}

	public function actionCompleted()
	{
		$this->render('completed');
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
