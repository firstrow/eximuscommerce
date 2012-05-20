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

		// Open product page and post comment
		$this->open(Yii::app()->createUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->type('id=Comment_name','tester');
		$this->type('id=Comment_email','tester@localhost.loc');
		$this->type('id=Comment_text','this is test comment');
		$this->clickAndWait('name=yt1');
		$this->assertTrue($this->isTextPresent('Ваш комментарий успешно добавлен. Он будет опубликован после проверки администратором.'));
	}

}
