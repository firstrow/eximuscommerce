<?php

/**
 * Remind pass form
 */
class RemindPasswordForm extends CFormModel
{

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('email', 'email'),
			array('email', 'validateEmail'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'email' => Yii::t('UsersModule.core', 'E-Mail'),
		);
	}

	/**
	 * Validate user email and send email message
	 */
	public function validateEmail()
	{
		$this->user = User::model()->findByAttributes(array(
			'email'=>$this->email
		));

		if($this->user)
			return true;
		else
			$this->addError('email', 'Ошибка. Пользователь не найден.');
	}

	/**
	 * Send recovery email
	 */
	public function sendRecoveryMessage()
	{
		$this->user->recovery_key=$this->generateKey(10);
		$this->user->recovery_password=$this->generateKey(15);
		$this->user->save(false);

		$mailer           = Yii::app()->mail;
		$mailer->From     = Yii::app()->params['adminEmail'];
		$mailer->FromName = Yii::app()->params['adminEmail'];
		$mailer->Subject  = Yii::t('UsersModule.core', 'Восстановление пароля');
		$mailer->Body     = $this->body;
		$mailer->AddReplyTo(Yii::app()->params['adminEmail']);
		$mailer->isHtml(false);
		$mailer->AddAddress($this->email);
		$mailer->Send();
	}


	/**
	 * Get email message body
	 */
	public function getBody()
	{
		$lang=Yii::app()->language;
		$emailBodyFile=Yii::getPathOfAlias("application.emails.$lang").DIRECTORY_SEPARATOR.'password_recovery.php';
		// If template file does not exists use default russian translation
		if(!file_exists($emailBodyFile))
			$emailBodyFile=Yii::getPathOfAlias("application.emails.ru").DIRECTORY_SEPARATOR.'password_recovery.php';
		ob_start();
		include $emailBodyFile;
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * Generate key and password
	 * @return string
	 */
	public function generateKey($size)
	{
		$result = '';
		$chars = '1234567890qweasdzxcrtyfghvbnuioplkjnm';
		while(mb_strlen($result,'utf8') < $size)
			$result .= mb_substr($chars, rand(0, mb_strlen($chars,'utf8')), 1);

		if(User::model()->countByAttributes(array('recovery_key'=>$result))>0)
			$this->generateKey($size);

		return strtoupper($result);
	}

}
