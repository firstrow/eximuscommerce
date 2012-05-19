<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
define('TEST_BASE_URL','http://cms-test/');

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase
{
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp()
	{
		$this->setBrowser('*googlechrome');
		$this->setBrowserUrl(TEST_BASE_URL);
		Yii::app()->request->setBaseUrl(TEST_BASE_URL);
		parent::setUp();
	}

	/**
	 * Login as admin
	 */
	public function adminLogin()
	{
		if(Yii::app()->user->isGuest)
			Yii::app()->user->logout();
		$this->open('admin/auth');
		$this->type('id=LoginForm_username', 'admin');
		$this->type('id=LoginForm_password', 'admin');
		$this->clickAndWait('name=login');
	}

}
