<?php

class AttributesControllerWebTest extends WebTestCase
{
	public function testAdminCreateDropDownAttribute()
	{
		$this->adminLogin();
		$this->open('/admin/store/attribute/create');
		$this->type('id=StoreAttribute_title','name'.time());
		$this->type('id=StoreAttribute_name','name'.time());
		$this->select('id=StoreAttribute_type','label=Dropdown');

		$this->click('link=Опции');
		$this->click('link=Добавить');
		$this->click('link=Добавить');

		$m=microtime();

		$this->type("xpath=(//input[contains(@name,'options')])[1]", '1'.$m);
		$this->type("xpath=(//input[contains(@name,'options')])[2]", '2'.$m);
		$this->type("xpath=(//input[contains(@name,'options')])[3]", '3'.$m);
		$this->type("xpath=(//input[contains(@name,'options')])[4]", '4'.$m);

		//$this->clickAndWait('css=#save_topLink');
		$this->clickAndWait('xpath=//a[contains(.,"Сохранить и редактировать")]');
		$this->assertTrue($this->isTextPresent('Изменения успешно сохранены'));

		$this->assertTrue($this->getXpathCount("//input[contains(@value,'2$m') and contains(@name,'options')]")==='1');
		$this->assertTrue($this->getXpathCount("//input[contains(@value,'2$m') and contains(@name,'options')]")==='1');
		$this->assertTrue($this->getXpathCount("//input[contains(@value,'3$m') and contains(@name,'options')]")==='1');
		$this->assertTrue($this->getXpathCount("//input[contains(@value,'4$m') and contains(@name,'options')]")==='1');
	}

}
