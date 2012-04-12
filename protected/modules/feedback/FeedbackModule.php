<?php

/**
 * Feedback modules
 */
class FeedbackModule extends BaseModule
{
	public $moduleName = 'feedback';

	/**
	 * Install default settings
	 */
	public function afterInstall()
	{
		Yii::app()->settings->set('feedback', array(
			'admin_email'        => 'admin@localhost.local',
			'enable_captcha'     => '0',
			'max_message_length' => 1000
		));
	}

	/**
	 * Remove settings
	 */
	public function afterRemove()
	{
		Yii::app()->settings->clear('feedback');
	}
}
