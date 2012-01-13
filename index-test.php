<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii1.1.9/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once $yii;
require_once 'protected/components/SWebApplication.php';

// Create application
$app = Yii::createApplication('SWebApplication', $config);
$app->run();