<?php

/**
 * Model to send emails
 */
class NewsletterAdminForm extends CFormModel
{

	public $subject;
	public $sender_name;
	public $sender_email;
	public $body;

	public function rules()
	{
		return array(
			array('subject, sender_name, sender_email, body', 'required'),
			array('sender_email', 'email'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'subject'      => Yii::t('NewsletterModule.admin', 'Тема'),
			'sender_name'  => Yii::t('NewsletterModule.admin', 'Имя отправителя'),
			'sender_email' => Yii::t('NewsletterModule.admin', 'Email отправителя'),
			'body'         => Yii::t('NewsletterModule.admin', 'Сообщение'),
		);
	}

	/**
	 * Send message to users
	 * @return bool
	 */
	public function send()
	{
		Yii::import('application.modules.users.models.User');
		$users = User::model()->findAll();

		$mailer           = Yii::app()->mail;
		$mailer->From     = $this->sender_email;
		$mailer->FromName = $this->sender_name;
		$mailer->Subject  = $this->subject;
		$mailer->Body     = $this->body;
		$mailer->AddReplyTo($this->sender_email);
		$mailer->isHtml(true);

		foreach($users as $user)
		{
			$mailer->ClearAllRecipients();
			$mailer->AddAddress($user->email);
			$mailer->Send();
		}
		return true;
	}

}
