<?php

// If caching need include behavior classes manual
Yii::import('application.modules.comments.components.CommentBehavior');
Yii::import('ext.behaviors.eav.EEavBehavior');
Yii::import('ext.behaviors.eav.ext.behaviors.STranslateBehavior');
Yii::import('application.modules.discounts.components.DiscountBehavior');


class SiteController extends Controller {


	public function allowedActions()
	{
		return 'login, index, error, contact';
	}

	public function actionLogin()
	{
		$products=Yii::app()->cache->get('t1');
		if($products===false)
		{

			$products = StoreProduct::model()
				->active()
				->byViews()
				->findAll(array('limit'=>20));
			Yii::app()->cache->set('t1',$products);
		}

		foreach($products as $p)
		{
			echo $p->name.'<br/>';
		}
	}

	public function actionIndex()
	{
		echo $this->createUrl('site/index', array('name'=>'sdsd'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$error=Yii::app()->errorHandler->error;
		if($error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				var_dump($error);
		}else{
			echo 'Some error hapenned!';
		}

	}
}
