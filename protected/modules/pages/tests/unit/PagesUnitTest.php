<?php

Yii::import('application.modules.pages.PagesModule');
Yii::import('application.modules.pages.models.*');

/**
 * Tests for Page module.
 */
class PagesUnitTest extends CDbTestCase
{

    public $fixtures = array(
        'Page',
        'PageTranslate',
        'PageCategory',
        'PageCategoryTranslate'
    );

    public function testPage()
    {
        $page = new Page;
        $page->setAttributes(array(
            'category_id'  =>'2',
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

    public function testPageCategory()
    {
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

        $category = PageCategory::model()->findByPk($category->id);
        $this->assertTrue($category instanceof PageCategory);

        // Test category url
        $this->assertEquals('test-test', $category->url);
    }

}
