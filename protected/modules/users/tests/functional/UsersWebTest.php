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

}
