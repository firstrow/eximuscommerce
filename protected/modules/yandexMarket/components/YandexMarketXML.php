<?php

Yii::import('application.modules.store.models.StoreCategory');

/**
 * Exports products catalog to YML format.
 */
class YandexMarketXML
{
	/**
	 * @var int Maximum loaded products per one query
	 */
	public $limit=50;

	/**
	 * @var string Default currency
	 */
	public $currencyIso = 'RUR';

	/**
	 * @var string
	 */
	public $cacheFileName = 'yandex.market.xml';

	/**
	 * @var string
	 */
	public $cacheDir = 'application.runtime';

	/**
	 * @var int
	 */
	public $cacheTimeout = 86400;

	/**
	 * @var resource
	 */
	private $fileHandler;

	/**
	 * Display xml file
	 */
	public function processRequest()
	{
		$cache=Yii::app()->cache;
		$check = $cache->get($this->cacheFileName);
		if($check===false)
		{
			$this->createXmlFile();
			if(!YII_DEBUG)
				$cache->set($this->cacheFileName, true, $this->cacheTimeout);
		}
		header ("content-type: text/xml");
		echo file_get_contents($this->getXmlFileFullPath());
		exit;
	}

	/**
	 * Create and write xml to file
	 */
	public function createXmlFile()
	{
		$filePath=$this->getXmlFileFullPath();
		$this->fileHandler=fopen($filePath, 'w');
		$this->write("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
		$this->write("<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");
		$this->write('<yml_catalog date="'.date('Y-m-d H:i').'">');
		$this->write('<shop>');
		$this->renderShopData();
		$this->renderCurrencies();
		$this->renderCategories();
		$this->loadProducts();
		$this->write('</shop>');
		$this->write('</yml_catalog>');
		fclose($this->fileHandler);
	}

	/**
	 * Write shop info
	 */
	public function renderShopData()
	{
		$url=Yii::app()->request->getBaseUrl(true);
		$this->write("<name>Demo</name>");
		$this->write("<company>Demo Company</company>");
		$this->write("<url>{$url}</url>");
	}

	/**
	 * Write list of available currencies
	 */
	public function renderCurrencies()
	{
		$this->write('<currencies>');
		$this->write('<currency id="'.$this->currencyIso.'" rate="1"/>');
		$this->write('</currencies>');
	}

	/**
	 * Write categories to xm file
	 */
	public function renderCategories()
	{
		$categories=StoreCategory::model()->excludeRoot()->findAll();
		$this->write('<categories>');
		foreach ($categories as $c)
		{
			$parentId=null;
			$parent=$c->getParent();
			if($parent && $parent->id != 1)
				$parentId='parentId="'.$parent->id.'"';
			$this->write('<category id="'.$c->id.'" '.$parentId.'>'.CHtml::encode($c->name).'</category>');
		}
		$this->write('</categories>');
	}

	/**
	 * Write offers to xml file
	 */
	public function loadProducts()
	{
		$limit=$this->limit;
		$total=ceil(StoreProduct::model()->active()->count()/$limit);
		for($i=0;$i<=$total;++$i)
		{
			$products=StoreProduct::model()->active()->findAll(array(
				'limit'=>$limit,
				'offset'=>$limit*$i,
			));
			$this->renderProducts($products);
			unset($products);
			$i+=$limit;
		}
	}

	/**
	 * @param array $products
	 */
	public function renderProducts(array $products)
	{
		$products=StoreProduct::model()->active()->findAll();
		$this->write('<offers>');
		foreach($products as $p)
		{
			$this->renderOffer($p, array(
				'url'         => Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$p->url)),
				'price'       => $p->price,
				'currencyId'  => $this->currencyIso,
				'categoryId'  => $p->mainCategory->id,
				'picture'     => $p->mainImage ? $p->mainImage->getUrl() : null,
				'name'        => CHtml::encode($p->name),
				'description' => $this->clearText($p->short_description),
			));
		}
		$this->write('</offers>');
	}

	/**
	 * @param StoreProduct $p
	 * @param array $data
	 */
	public function renderOffer(StoreProduct $p, array $data)
	{
		$available=($p->availability==1) ? 'true' : 'false';
		$this->write('<offer id="'.$p->id.'" available="'.$available.'">');
		foreach($data as $key=>$val)
			$this->write("<$key>".$val."</$key>\n");
		$this->write('</offer>'."\n");
	}

	/**
	 * @param $text
	 * @return string
	 */
	public function clearText($text)
	{
		return CHtml::encode(strip_tags($text));
	}

	/**
	 * @return string
	 */
	public function getXmlFileFullPath()
	{
		return Yii::getPathOfAlias($this->cacheDir).DIRECTORY_SEPARATOR.$this->cacheFileName;
	}

	/**
	 * Write part of xml to file
	 * @param $string
	 */
	private function write($string)
	{
		fwrite($this->fileHandler, $string);
	}

}
