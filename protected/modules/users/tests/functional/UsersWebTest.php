<?php

/**
 * Functional tests users module
 */
class UsersWebTest extends WebTestCase
{

	/**
	 * Test if user can register account from site front
	 */
	public function testRegister()
	{
		if(Yii::app()->user->isGuest)
			Yii::app()->user->logout();

		$random = time()+rand(0,1000);
		$this->open('users/register');
		$this->type('User[username]', 'phpunit'.$random);
		$this->type('User[password]','phpunit');
		$this->type('User[email]', $random.'phpunit@localhost.loc');
		$this->type('UserProfile[full_name]','first second');
		$this->clickAtAndWait("//input[@type='submit' and @value='Отправить']");
		$this->assertTrue($this->isTextPresent('Спасибо за регистрацию на нашем сайте.'));

		// Logout
		$this->open('users/logout');

		// Check if username and email is unique
		$this->open('users/register');
		$this->type('User[username]', 'phpunit'.$random);
		$this->type('User[password]','phpunit');
		$this->type('User[email]', $random.'phpunit@localhost.loc');
		$this->type('UserProfile[full_name]','first second');
		$this->clickAtAndWait("//input[@type='submit' and @value='Отправить']");
		$this->assertTrue($this->isTextPresent('Логин уже занят другим пользователем.'));
	}

	public function testPasswordRecovery()
	{
		$user=User::model()->find();
		$originalPassword=$user->password;

		// Remind user password
		$this->open('users/remind');
		// Remind wrong
		$this->type('RemindPasswordForm[email]', 'somewrongemail@localhost.loc');
		$this->clickAtAndWait("//input[@type='submit' and @value='Напомнить']");
		$this->assertTrue($this->isTextPresent('Ошибка. Пользователь не найден.'));
		// Remind true
		$this->type('RemindPasswordForm[email]', $user->email);
		$this->clickAtAndWait("//input[@type='submit' and @value='Напомнить']");
		$this->assertTrue($this->isTextPresent('На вашу почту отправлены инструкции по активации нового пароля.'));

		// Reload model
		$user=User::model()->findByPk($user->id);

		$activateUrl=Yii::app()->createAbsoluteUrl('/users/remind/activatePassword', array('key'=>$user->recovery_key));
		$this->open($activateUrl);
		$this->assertTrue($this->isTextPresent('Ваш новый пароль успешно активирован.'));

		// Login using new password
		$this->open('users/login');
		$this->type('UserLoginForm[username]', $user->username);
		$this->type('UserLoginForm[password]', $user->recovery_password);
		$this->clickAtAndWait("//input[@type='submit' and @value='Вход']");
		$this->assertTrue($this->isTextPresent('Личный кабинет'));

		$user=User::model()->findByPk($user->id);
		$this->assertTrue($user->recovery_key=='');
		$this->assertTrue($user->recovery_password=='');

		// Recovery user password back again
		$user->password=$originalPassword;
		$user->save(false);
	}

	public function testProfileChange()
	{
		Yii::import('application.modules.users.models.*');
		$this->adminLogin();
		// Set empty profile data
		$this->open('users/profile');
		$this->type('UserProfile[full_name]', '');
		$this->type('User[email]', '');
		$this->clickAtAndWait("//input[@type='submit' and @value='Сохранить']");
		$this->assertTrue($this->isTextPresent('Необходимо заполнить поле Полное Имя.'));
		$this->assertTrue($this->isTextPresent('Необходимо заполнить поле Email.'));

		// Set normal random data
		$time=time();
		$this->type('UserProfile[full_name]', 'fullname'.$time);
		$this->type('User[email]', 'admin.'.$time.'@localhost.loc');
		$this->clickAtAndWait("//input[@type='submit' and @value='Сохранить']");
		$this->assertTrue($this->isTextPresent('Изменения успешно сохранены.'));

		// Check if data really saved
		$profile=UserProfile::model()->findByAttributes(array('user_id'=>1));
		$user=User::model()->findByAttributes(array('id'=>1));
		$this->assertTrue($profile->full_name=='fullname'.$time);
		$this->assertTrue($user->email=='admin.'.$time.'@localhost.loc');

		// Change password
		$this->type('ChangePasswordForm[current_password]', 'admin');
		$this->type('ChangePasswordForm[new_password]', 'admin');
		$this->clickAtAndWait("//input[@type='submit' and @value='Изменить']");
		$this->assertTrue($this->isTextPresent('Пароль успешно изменен.'));

		// Try to set wrong password
		$this->type('ChangePasswordForm[current_password]', mt_rand(1,10));
		$this->clickAtAndWait("//input[@type='submit' and @value='Изменить']");
		$this->assertTrue($this->isTextPresent('Ошибка проверки текущего пароля'));
	}

}
