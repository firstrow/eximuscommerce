<?php

/**
 * Model to handle feedback settings
 */
class FeedbackAdminForm extends CFormModel
{

	/**
	 * @var string admin email where to send messages
	 */
	public $admin_email;

	/**'
	 * @var boolean
	 */
	public $enable_captcha;

	/**
	 * @var integer
	 */
	public $max_message_length;

	public function init()
	{
		$this->attributes = Yii::app()->settings->get('feedback');
	}

	/**
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('admin_email, max_message_length', 'required'),
			array('admin_email', 'email'),
			array('enable_captcha', 'boolean'),
			array('max_message_length', 'numerical'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'admin_email'        => Yii::t('FeedbackModule.core', 'Email'),
			'max_message_length' => Yii::t('FeedbackModule.core', 'Длина сообщения'),
			'enable_captcha'     => Yii::t('FeedbackModule.core', 'Код протекции'),
		);
	}

	/**
	 * Save settings
	 */
	public function save()
	{
		Yii::app()->settings->set('feedback', $this->attributes);
	}

}
