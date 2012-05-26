<?php

/**
 * Test add/removing products to compare
 */
class CompareControllerWebTest extends WebTestCase
{
	public function testCompareIsWorkingOk()
	{
		$product = StoreProduct::model()->active()->find();
		$this->assertTrue($product instanceof StoreProduct);
		var_dump($product->name);
		$this->open(Yii::app()->createUrl('/store/frontProduct/view', array('url'=>$product->url)));
		$this->clickAndWait('css=div.silver_clean.silver_button > button');
		$this->assertTrue($this->isTextPresent('Продукт успешно добавлен в список сравнения'));
		$this->clickAndWait('xpath=//a[contains(.,"Товары на сравнение")]');
		$this->assertTrue($this->isTextPresent(str_replace('  ',' ',$product->name)));
		$this->clickAndWait('link=Удалить');
		$this->assertTrue($this->isTextPresent('Нет результатов'));
	}
}
