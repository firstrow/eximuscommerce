<?php

class SystemSettingsWebTest extends WebTestCase
{
	public function testSystemSettings()
	{
		$siteName=microtime();
		$pp='1,2,'.rand(3,10);
		$ppa=rand(3,10);

		$this->adminLogin();
		$this->open('/admin/core/systemSettings');
		$this->type('id=SystemSettingsForm_core_siteName', $siteName);
		$this->type('id=SystemSettingsForm_core_productsPerPage', $pp);
		$this->type('id=SystemSettingsForm_core_productsPerPageAdmin', $ppa);
		$this->type('id=SystemSettingsForm_core_editorHeight', 150);
		$this->check('id=SystemSettingsForm_images_watermark_active');
		$this->clickAndWait('css=#save_topLink > span.ui-button-text');

		Yii::import('application.modules.core.models.SystemSettingsForm');
		Yii::app()->settings->init();
		$model=new SystemSettingsForm;
		$this->assertEquals($model->core_siteName, $siteName);
		$this->assertEquals($model->core_productsPerPage, $pp);
		$this->assertEquals($model->core_productsPerPageAdmin, $ppa);
		$this->assertEquals(Yii::app()->settings->get('core', 'siteName'), $siteName);
		$this->assertEquals(Yii::app()->settings->get('core', 'editorHeight'), 150);
		$this->assertEquals(Yii::app()->settings->get('images', 'watermark_active'), 1);
	}

	public function testTitle()
	{
		Yii::app()->settings->set('core', array(
			'siteName'=>microtime()
		));
		$this->open('/');
		$this->assertEquals(Yii::app()->settings->get('core','siteName'), $this->getTitle());

		// Find any active product
		$product = StoreProduct::model()->active()->find();
		$this->assertTrue($product instanceof StoreProduct);

		// Open product page
		$this->open(Yii::app()->createUrl('/store/frontProduct/view', array('url'=>$product->url)));

		$this->assertEquals($product->name.' / '.Yii::app()->settings->get('core','siteName'), $this->getTitle());
	}
}
