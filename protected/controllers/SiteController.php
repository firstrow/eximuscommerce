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
        echo '
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            </head>
            <body>
            іваіваіва ok іваіваіваіваіваіва ok 123123 іваіваіва привет
            </body>
        </html>
        ';
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
