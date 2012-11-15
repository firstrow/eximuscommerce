Here are files to help run tests.
All tests are stored in modules/*/tests/*
To run all tests execute next command:

>>> cd protected/tests
>>> phing


# Environment setup

1. Install phing
	$> pear channel-discover pear.phing.info
	$> pear install phing/phing
2. Install PHPUnit
	$> pear channel-discover pear.phpunit.de
	$> pear channel-discover pear.symfony.com
	$> pear install pear.symfony.com/Yaml
	$> pear install --alldeps pear.phpunit.de/PHPUnit
	$> pear install phpunit/PHPUnit_Selenium