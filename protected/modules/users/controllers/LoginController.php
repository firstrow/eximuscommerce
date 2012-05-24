<?php

/**
 * Realize user login
 */
class LoginController extends Controller
{

	public function allowedActions()
	{
		return 'index, logout';
	}

	/**
	 * Display login page and authenticate user.
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest)
			Yii::app()->request->redirect('/');

		Yii::import('application.modules.users.forms.UserLoginForm');
		$model = new UserLoginForm;

		if (Yii::app()->request->getIsPostRequest())
		{
			$model->attributes = $_POST['UserLoginForm'];

			if ($model->validate())
			{
				// Authenticate user and redirect to the dashboard
				if($model->rememberMe)
					$duration = Yii::app()->user->rememberTime; // Remember for one week
				else
					$duration = 0;


				if(Yii::app()->user->returnUrl && Yii::app()->user->returnUrl!=='/index.php')
					$url=Yii::app()->user->returnUrl;
				else
					$url='/';

				Yii::app()->user->login($model->getIdentity(), $duration);
				Yii::app()->request->redirect($url);
			}
		}

		$this->render('login', array(
			'model'=>$model,
		));
	}

	/**
	 * Logout user
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		Yii::app()->request->redirect('/');
	}

}
