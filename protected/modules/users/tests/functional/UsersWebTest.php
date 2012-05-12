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

}
