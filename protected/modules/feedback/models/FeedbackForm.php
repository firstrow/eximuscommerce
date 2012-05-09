<?php

/**
 * Model to handle feedback form
 */
class FeedbackForm extends CFormModel
{

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $message;

	/**
	 * @var string
	 */
	public $code;

	/**
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('name, email, message', 'required'),
			array('email', 'email'),
			array('message', 'length', 'max'=>Yii::app()->settings->get('feedback', 'max_message_length')),
			array('code','captcha','allowEmpty'=>!Yii::app()->settings->get('feedback', 'enable_captcha')),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>Yii::t('FeedbackModule.core', 'Ваше имя'),
			'email'=>Yii::t('FeedbackModule.core', 'Email'),
			'message'=>Yii::t('FeedbackModule.core', 'Сообщение'),
		);
	}

	/**
	 * Send email
	 */
	public function sendMessage()
	{
		$mailer           = Yii::app()->mail;
		$mailer->From     = 'noreply@'.Yii::app()->request->serverName;
		$mailer->FromName = Yii::t('FeedbackModule.core', 'Форма обратной связи');
		$mailer->Subject  = Yii::t('FeedbackModule.core', 'Сообщение от {name}', array('{name}'=>CHtml::encode($this->name)));
		$mailer->Body     = CHtml::encode($this->message);
		$mailer->AddAddress(Yii::app()->settings->get('feedback', 'admin_email'));
		$mailer->AddReplyTo($this->email);
		$mailer->Send();

		Yii::app()->user->setFlash('messages', Yii::t('FeedbackModule', 'Спасибо. Ваше сообщение отправлено.'));
	}

}
