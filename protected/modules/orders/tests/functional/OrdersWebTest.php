<?php

Yii::import('application.modules.store.models.*');
Yii::import('application.modules.orders.models.*');

/**
 * Functional tests users module
 */
class OrdersWebTest extends WebTestCase
{

	/**
	 * Check creating new orders
	 */
	public function testCreateOrder()
	{
		$microTime=microtime();
		$comment='test comment '.$microTime;

		// Find any active product
		$product = StoreProduct::model()->active()->find();
		$this->assertTrue($product instanceof StoreProduct);

		// Open product page and add to cart
		$this->open(Yii::app()->createUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->click("//input[@id='buyButton']");

		$this->open('cart');
		$this->assertTrue($this->isTextPresent($product->name));
		$this->click('css=label.radio > span');
		$this->type('id=OrderCreateForm_name','Tester Name');
		$this->type('id=OrderCreateForm_email','tester@localhost.loc');
		$this->type('id=OrderCreateForm_phone','0990000000');
		$this->type('id=OrderCreateForm_address','test address');
		$this->type('id=OrderCreateForm_comment',$comment);
		$this->clickAtAndWait('name=create');

		// Check if order successfully saved
		$order = Order::model()->findByAttributes(array(
			'user_comment'=>$comment,
		));

		$this->assertTrue($order instanceof Order);

		// Check of ordered products
		$this->assertTrue($order->getOrderedProducts() instanceof CActiveDataProvider);
		$this->assertTrue($order->getOrderedProducts()->getTotalItemCount()>0);
	}

	/**
	 * Login.
	 * Create order.
	 * Add product to order.
	 */
	public function testCreateOrderFromAdminPanel()
	{
		$this->adminLogin();

		$this->open('admin/orders/orders/index');
		$this->assertTrue($this->isTextPresent('Заказы'));

		// Create new order. Click to Save&Edit
		$this->clickAtAndWait('css=span.ui-button-text');
		$this->assertTrue($this->isTextPresent('Создание заказа'));
		$this->type('id=Order_user_name','tester');
		$this->type('id=Order_user_email','tester@localhost.loc');
		$this->type('id=Order_user_phone','0990000000');
		$this->type('id=Order_user_address','test address');
		$this->type('id=Order_user_comment','test comment');
		$this->clickAndWait("xpath=(//a[contains(text(),'Сохранить и редактировать')])");
		$this->assertTrue($this->isTextPresent('Редактирование заказа'));
		$this->click('link=Добавить продукт');
		sleep(1);
		$this->click('xpath=(//td[@class="addProductToOrder"])[1]'); // Add first product
		sleep(1);
		$this->assertTrue($this->isTextPresent('Продукт успешно добавлен к заказу'));
	}
}
