<?php

Yii::import('application.modules.users.forms.RemindPasswordForm');

/**
 * Remind/activate user password
 */
class RemindController extends Controller
{

	/**
	 * @param CAction $action
	 * @return bool
	 */
	public function beforeAction($action)
	{
		// Allow only gues access
		if(Yii::app()->user->isGuest)
			return true;
		else
			$this->redirect('/');
	}

	public function actionIndex()
	{
		$model=new RemindPasswordForm;

		if(Yii::app()->request->isPostRequest)
		{
			$model->attributes=$_POST['RemindPasswordForm'];
			if($model->validate())
			{
				$model->sendRecoveryMessage();
				$this->addFlashMessage(Yii::t('UsersModule.core','На вашу почту отправлены инструкции по активации нового пароля.'));
				$this->refresh();
			}
		}

		$this->render('index', array(
			'model'=>$model
		));
	}

	/**
	 * @param $key
	 */
	public function actionActivatePassword($key)
	{
		if(User::activeNewPassword($key)===true)
		{
			$this->addFlashMessage(Yii::t('UsersModule.core', 'Ваш новый пароль успешно активирован.'));
			$this->redirect(array('/users/login/login'));
		}else{
			$this->addFlashMessage(Yii::t('UsersModule.core', 'Ошибка активации пароля.'));
			$this->redirect(array('/users/remind'));
		}
	}
}
