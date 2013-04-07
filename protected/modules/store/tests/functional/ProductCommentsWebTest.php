<?php

Yii::import('application.modules.store.models.*');
Yii::import('application.modules.comments.models.*');

/**
 * Test adding comment to products
 */
class ProductCommentsWebTest extends WebTestCase
{

	/**
	 * Check creating new comment
	 */
	public function testCreateComment()
	{
		// Find any active product
		$product = StoreProduct::model()->active()->find();
		$this->assertTrue($product instanceof StoreProduct);

		$email='tester@localhost.loc';
		$text='this is test comment'.microtime();

		// Open product page and post comment
		$this->open(Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->type('id=Comment_name','tester');
		$this->type('id=Comment_email',$email);
		$this->type('id=Comment_text',$text);
		$this->clickAndWait("//input[@value='Отправить']");

		$this->open(Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->assertTrue($this->isTextPresent('Ваш комментарий успешно добавлен. Он будет опубликован после проверки администратором.'));

		$this->adminLogin();
		$this->open('/admin/store/products/update?id='.$product->id);
		$this->click('xpath=//a[contains(.,"Отзывы")]');
		$this->assertTrue($this->isTextPresent($email));
		$this->assertTrue($this->isTextPresent($text));
	}

}
