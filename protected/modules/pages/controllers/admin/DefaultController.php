<?php

class DefaultController extends SAdminController {
	
	
	/**
	 * Display pages list.
	 */	
	public function actionIndex()
	{
		$model = new Page('search');

		if (!empty($_GET['Page']))
			$model->attributes = $_GET['Page'];

		$this->render('index', array(
			'model'=>$model
		));
	}

	public function actionCreate()
	{
		$this->actionUpdate(true);
	}

	/**
	 * Create or update new page
	 * @param boolean $new
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
		{
			$model = new Page;
			$model->publish_date = date('Y-m-d H:i:s');
		}
		else
		{
			$model = Page::model()
				->language($_GET)
				->findByPk($_GET['id']);
		}

		if (!$model)
            throw new CHttpException(404, Yii::t('PagesModule.core', 'Страница не найдена.'));

		$form = new STabbedForm('application.modules.pages.views.admin.default.pageForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['Page'];

			if ($model->isNewRecord)
				$model->created = date('Y-m-d H:i:s');
			$model->updated = date('Y-m-d H:i:s');

			if ($model->validate())
			{
				$model->save();

                $this->setFlashMessage(Yii::t('PagesModule.core', 'Изменения успешно сохранены'));
                
                if (isset($_POST['REDIRECT']))
                    $this->smartRedirect($model);
                else
                    $this->redirect(array('index'));
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'form'=>$form,
		));
	}

    /**
     * Delete page by Pk
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $model = Page::model()->findByPk($_GET['id']);

            if ($model)
                $model->delete();

            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect('index');
        }
    }
}