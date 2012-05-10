<?php

Yii::import('application.modules.pages.PagesModule');
Yii::import('application.modules.pages.models.*');

/**
 * Tests for Page module.
 */
class PagesUnitTest extends CDbTestCase
{

	public $fixtures = array(
		'Page'=>'Page',
		'PageTranslate'=>'PageTranslate',
		'PageCategory'=>'PageCategory',
		'PageCategoryTranslate'=>'PageCategoryTranslate'
	);


	public function setUp()
	{
		$this->getFixtureManager()->basePath = Yii::getPathOfAlias('application.modules.pages.tests.fixtures');
		parent::setUp();
	}

	public function testPage()
	{
		// Test page create
		$page = new Page;
		$page->setAttributes(array(
			'category_id'  =>'1',
			'publish_date' =>'2011-12-01 18:55:06',
			'status'       =>'published',
			'layout'       =>'',
			'view'         =>'',
			// Translate able fields
			'title'=>'Page Title',
			'short_description'=>'Short Description',
			'full_description'=>'Full description',
			'meta_title'=>'',
			'meta_keywords'=>'',
			'meta_description'=>''
		));

		$this->assertTrue($page->save(false));
		$page = Page::model()->findByPk($page->id);

		// Test title
		$this->assertEquals('Page Title', $page->title);

		// Test auto-create url
		$this->assertEquals('page-title', $page->url);

		// Test published scope
		$page = Page::model()
			->published()
			->find();
		$this->assertTrue($page instanceof $page);

		// Set published +hours
		$page->publish_date = date('Y-m-d H:i:s', time()+60);
		$page->save(false);

		$page = Page::model()
			->published()
			->findByPk($page->id);
		$this->assertEquals($page, null);

		// Test withUrl scope
		$page = Page::model()
			->withUrl('page-title')
			->find();
		$this->assertTrue($page instanceof Page);
	}

	public function testPageUrlUnique()
	{
		// Create page with url that exists
		$page = new Page;
		$page->setAttributes(array(
			'category_id'  =>'1',
			'publish_date' =>'2011-12-01 18:55:06',
			'status'       =>'published',
			// Translate able fields
			'title'=>'Page Test Urls Unique',
			'url'=>'page-1',
		));
		$this->assertTrue($page->save(false));
		$this->assertEquals('page-1'.'-'.date('YmdHis'), $page->url);
	}

	public function testPageCategory()
	{
		// Test create new category
		$category = new PageCategory;
		$category->setAttributes(array(
			'name' => 'Тест тест',
			'description' => 'Category test desc',
			'layout' => '',
			'view' =>  '',
			'meta_title' => '',
			'meta_description' => '',
			'meta_keywords' =>  '',
		));

		$this->assertTrue($category->save(false));

		// Test category find
		$category = PageCategory::model()->findByPk($category->id);
		$this->assertTrue($category instanceof PageCategory);

		// Test category url
		$this->assertEquals('test-test', $category->url);
	}

	public function testCategoryUrlUnique()
	{
		// Create new category with existing url
		$category = new PageCategory;
		$category->setAttributes(array(
			'name' => 'Тест тест 2',
			'description' => 'Category test desc',
			'parent_id' => $this->PageCategory['PageCategory_2']['parent_id'],
			'url' => $this->PageCategory['PageCategory_2']['url'],
		));

		$this->assertTrue($category->save(false));
		$category = PageCategory::model()->findByPk($category->id);

		$this->assertEquals('fantastika-'.date('YmdHis'), $category->url);
	}

}
