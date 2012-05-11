<?php

/**
 * Profile, order and other user data.
 */
class ProfileController extends Controller
{

	/**
	 * Check if user is authenticated
	 * @return bool
	 * @throws CHttpException
	 */
	public function beforeAction()
	{
		if(Yii::app()->user->isGuest)
			throw new CHttpException(404, Yii::t('UsersModule.core', 'Ошибка доступа.'));
		return true;
	}

	/**
	 * Display profile start page
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

}
