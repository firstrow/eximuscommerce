<?php

/**
 * Admin site comments
 */
class CommentsController extends SAdminController
{

	/**
	 * Display all site comments
	 */
	public function actionIndex()
	{
		$model = new Comment('search');

		if(!empty($_GET['Comment']))
			$model->attributes = $_GET['Comment'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->params['adminPageSize'];

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider
		));
	}

	public function actionUpdate($id)
	{
		$model = Comment::model()->findByPk($id);

		if(!$model)
			throw new CHttpException(404, Yii::t('CommentsModule.admin', 'Комментарий не найден'));

		$form = new CForm('comments.views.admin.comments.commentForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['Comment'];
			if($model->validate())
			{
				$model->save();

				$this->setFlashMessage(Yii::t('CommentsModule.admin', 'Изменения успешно сохранены'));

				if (isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model' => $model,
			'form'  => $form
		));
	}

	public function axctionDelete()
	{

	}

}
