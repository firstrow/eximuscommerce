<?php
/**
 * User controller
 */
class DefaultController extends SAdminController
{ 

	/**
	 * Display users list
	 */
	public function actionIndex()
	{
		$model = new User('search');
		$model->unsetAttributes();

		if (!empty($_GET['User']))
			$model->attributes = $_GET['User'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('list', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new user
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}

	/**
	 * Create/update user
	 * @param boolean $new
	 */
	public function actionUpdate($new = false)
	{
		if($new === true)
		{
			$model = new User;
			$model->profile = new UserProfile;
		}
		else
			$model = User::model()->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(400, 'Bad request.');

		$form = new SAdminForm('application.modules.users.views.admin.default.userForm', $model);

		$form['user']->model = $model;
		$form['profile']->model = $model->profile;

		if(Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['User'];
			$model->profile->attributes = $_POST['UserProfile'];

			$valid = $model->validate() && $model->profile->validate();

			if($valid)
			{
				$model->save();
				if(!$model->profile->user_id)
					$model->profile->user_id=$model->id;
				$model->profile->save();

				$this->setFlashMessage(Yii::t('UsersModule.core', 'Изменения успешно сохранены'));

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
	 * Delete user by Pk
	 */
	public function actionDelete()
	{
		if (Yii::app()->request->isPostRequest)
		{
			$ids    = $_POST['id'];
			$models = User::model()->findAllByPk($ids);

			if(!empty($models))
			{
				foreach ($models as $user)
				{
					if ($user && ($user->id != Yii::app()->user->id))
						$user->delete();
				}
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}
