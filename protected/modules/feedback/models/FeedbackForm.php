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
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('name, email, message', 'required'),
			array('email', 'email'),
			array('message', 'length', 'max'=>'1000'),
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
		$mailer->FromName = 'Feedback Form';
		$mailer->Subject  = 'Message from '.CHtml::encode($this->name);
		$mailer->Body     = CHtml::encode($this->message);
		$mailer->AddAddress('qiang@example.com');
		$mailer->AddReplyTo($this->email);
		$mailer->Send();

		Yii::app()->user->setFlash('feedback_send', true);
	}

}
