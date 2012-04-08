<?php

class SiteController extends Controller {

    public function filters()
    {
        return array(
            'rights',
        );
    }

    public function allowedActions()
    {
        return 'login, index, error, contact';
    }


    public function actionLogin()
    {

    }

    public function actionContact()
    {
	    Yii::import('store.models.*');
		$product = StoreProduct::model()->findByPk(56);
	    var_dump($product->name);
	    $category = $product->mainCategory;
	    var_dump($category->name);
	    var_dump($product->name);
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
