<?php

class CategoryController extends SAdminController {
	
	
	/**
	 * Display pages list.
	 */	
	public function actionIndex()
	{
		$model = new PageCategory('search');

		if (!empty($_GET['PageCategory']))
			$model->attributes = $_GET['PageCategory'];

		$tree = new PageCategoryTree(PageCategory::model()->findAll());
		$tree = new CArrayDataProvider($tree->buildTree());

		$this->render('index', array(
			'model'=>$model,
			'tree'=>$tree,
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
			$model = new PageCategory;
		else
			$model = PageCategory::model()->findByPk($_GET['id']);

		if (!$model)
            throw new CHttpException(400, 'Bad request.');  

		$form = new STabbedForm('application.modules.pages.views.admin.category.categoryForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['PageCategory'];

			if ($model->isNewRecord)
				$model->created = date('Y-m-d H:i:s');
			$model->updated = date('Y-m-d H:i:s');

			if ($model->validate())
			{
				$model->save();

                $this->setFlashMessage(Yii::t('PagesModule.admin', 'Изменения успешно сохранены'));
                
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
            $model = PageCategory::model()->findByPk($_GET['id']);

            if ($model)
                $model->delete();

            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect('index');
        }
    }
}