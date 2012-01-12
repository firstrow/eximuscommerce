<?php

/**
 * Admin product category controller
 */
class CategoryController extends SAdminController {

	public function filters() {
		return array(
			'ajaxOnly + moveNode',
		);
	}

	public function actionIndex()
	{
		$this->actionUpdate(true);
	}

	public function actionCreate()
	{
		$this->actionUpdate(true);
	}

	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new StoreCategory;
		else
		{
			$model = StoreCategory::model()
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Категория не найдена.'));

		$form = new STabbedForm('application.modules.store.views.admin.category.categoryForm', $model);
		$form->formWidget = 'zii.widgets.jui.CJuiTabs';
		$form->summaryOnEachTab = true;

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreCategory'];

			if ($model->validate())
			{
				$parent=StoreCategory::model()->findByPk(1);
				if($model->getIsNewRecord())
					$model->appendTo($parent);
				else
					$model->saveNode();

				$this->setFlashMessage(Yii::t('StoreModule.admin', 'Изменения успешно сохранены'));

				if (isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect('create');
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'form'=>$form,
		));
	}

	/**
	 * Drag-n-drop nodes
	 */
	public function actionMoveNode()
	{
		$node = StoreCategory::model()->findByPk($_GET['id']);
		$target = StoreCategory::model()->findByPk($_GET['ref']);

		if((int) $_GET['position'] > 0)
		{
			$pos = (int) $_GET['position'];
			$childs = $target->children()->findAll();
			if(isset($childs[$pos-1]) && $childs[$pos-1] instanceof StoreCategory && $childs[$pos-1]['id'] != $node->id)
				$node->moveAfter($childs[$pos-1]);
		}
		else
			$node->moveAsFirst($target);
	}

	/**
	 * Delete category
	 * @param array $id
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StoreCategory::model()->findByPk($id);
			// Delete if not root node
			if ($model && $model->id != 1)
				$model->deleteNode();

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('create');
		}
	}

}
