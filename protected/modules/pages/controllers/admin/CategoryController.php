<?php

class CategoryController extends SAdminController
{

	/**
	 * Display category tree.
	 */
	public function actionIndex()
	{
		$model = new PageCategory('search');

		if (!empty($_GET['PageCategory']))
			$model->attributes = $_GET['PageCategory'];

		$tree = new PageCategoryTree(PageCategory::model()->findAll());
		$tree = new CArrayDataProvider($tree->buildTree(), array(
			'pagination'=>array(
				'pageSize'=>100,
			),
		));

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
	 * Create or update new category
	 * @param boolean $new
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new PageCategory;
		else
        {
			$model = PageCategory::model()
                ->language($_GET)
                ->findByPk($_GET['id']);
        }

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

				$tree = new PageCategoryTree();
				$tree->rebuildFullUrl();

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
     * Delete category by Pk
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $model = PageCategory::model()->findAllByPk($_REQUEST['id']);

            if (!empty($model))
            {
                foreach($model as $category)
                    $category->delete();
            }

            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect('index');
        }
    }
}