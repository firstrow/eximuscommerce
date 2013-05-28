<?php

/**
 * Wishlist controller test
 */
class WishlistControllerWebTest extends WebTestCase
{

	public function testWishlist()
	{
		Yii::import('application.modules.store.models.wishlist.*');
		$wishlist = StoreWishlist::model()->find();
		$product  = StoreProduct::model()->active()->find();
		$this->assertTrue($product instanceof StoreProduct);

		$this->open(Yii::app()->createUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->clickAndWait('xpath=//button[contains(.,"Список желаний")]');
		$this->assertTrue($this->isTextPresent('Авторизация'));
		$this->type('id=UserLoginForm_username', 'admin');
		$this->type('id=UserLoginForm_password', 'admin');

		// Click on login button
		$this->clickAndWait('css=input.blue_button');

		$this->open(Yii::app()->createUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->assertTrue($this->isTextPresent('Список желаний'));
		$this->clickAndWait('xpath=//button[contains(.,"Список желаний")]');
		$this->assertTrue($this->isTextPresent('Продукт успешно добавлен в список желаний.'));
		$this->assertTrue($this->isTextPresent(str_replace('  ',' ',$product->name)));

		// View wishlist view
		$this->open(Yii::app()->createAbsoluteUrl('/store/wishlist/view', array('key'=>$wishlist->key)));
		$this->assertTrue($this->isTextPresent('Список желаний'));
		$this->assertTrue($this->isTextPresent($product->name));
	}
}
