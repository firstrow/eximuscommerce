<?php

Yii::import('application.modules.pages.PagesModule');
Yii::import('application.modules.pages.models.*');

class PagesWebTest extends WebTestCase
{

    public $fixtures = array(
        'Page'=>'Page',
        'PageTranslate'=>'PageTranslate'
    );

	public function testViewPage()
	{
		$this->open('page/page-1');
		$this->assertTextPresent($this->PageTranslate['page1']['title']);
	}

}
