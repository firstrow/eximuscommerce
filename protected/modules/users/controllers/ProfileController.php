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
		Yii::import('application.modules.users.forms.ChangePasswordForm');
		$request=Yii::app()->request;


		$user=Yii::app()->user->getModel();
		$profile=$user->profile;
		$changePasswordForm=new ChangePasswordForm();
		$changePasswordForm->user=$user;

		if(Yii::app()->request->isPostRequest)
		{
			if($request->getPost('UserProfile') || $request->getPost('User'))
			{
				$profile->attributes=$request->getPost('UserProfile');
				$user->email=isset($_POST['User']['email']) ? $_POST['User']['email'] : null;

				$valid=$profile->validate();
				$valid=$user->validate() && $valid;

				if($valid)
				{
					$user->save();
					$profile->save();

					$this->addFlashMessage(Yii::t('UsersModule.core', 'Изменения успешно сохранены.'));
					$this->refresh();
				}
			}

			if($request->getPost('ChangePasswordForm'))
			{
				$changePasswordForm->attributes=$request->getPost('ChangePasswordForm');
				if($changePasswordForm->validate())
				{
					$user->password=User::encodePassword($changePasswordForm->new_password);
					$user->save(false);
					$this->addFlashMessage(Yii::t('UsersModule.core', 'Пароль успешно изменен.'));
					$this->refresh();
				}
			}
		}

		$this->render('index', array(
			'user'=>$user,
			'profile'=>$profile,
			'changePasswordForm'=>$changePasswordForm
		));
	}

	/**
	 * Display user orders
	 */
	public function actionOrders()
	{
		Yii::import('application.modules.orders.models.*');
		Yii::import('application.modules.store.models.*');

		$orders=new Order('search');
		$orders->user_id=Yii::app()->user->getId();

		$this->render('orders', array(
			'orders'=>$orders,
		));
	}

}
