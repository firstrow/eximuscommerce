<?php

Yii::import('application.modules.pages.PagesModule');
Yii::import('application.modules.pages.models.*');

class PagesTest extends WebTestCase
{

    public $fixtures = array(
        'Page'=>'Page',
        'PageTranslate'=>'PageTranslate'
    );

	public function testViewPage()
	{
		$this->open('page/page-1');
		$this->assertTextPresent('Page Title');
	}

}
