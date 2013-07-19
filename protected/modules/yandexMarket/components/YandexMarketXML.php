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
	public $limit=2;

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
	 * @var integer
	 */
	private $_config;

	/**
	 * Initialize component
	 */
	public function __construct()
	{
		$this->_config=Yii::app()->settings->get('yandexMarket');
	}

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
		$this->write('<name>'.$this->_config['name'].'</name>');
		$this->write('<company>'.$this->_config['company'].'</company>');
		$this->write('<url>'.$this->_config['url'].'</url>');
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
		$limit  = $this->limit;
		$total  = ceil(StoreProduct::model()->active()->count()/$limit);
		$offset = 0;

		$this->write('<offers>');

		for($i=0;$i<=$total;++$i)
		{
			$products=StoreProduct::model()->active()->findAll(array(
				'limit'  => $limit,
				'offset' => $offset,
			));
			$this->renderProducts($products);

			$offset+=$limit;
		}

		$this->write('</offers>');
	}

	/**
	 * @param array $products
	 */
	public function renderProducts(array $products)
	{
		foreach($products as $p)
		{
			if(!count($p->variants))
			{
				$this->renderOffer($p, array(
					'url'         => Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$p->url)),
					'price'       => Yii::app()->currency->convert($p->price, $this->_config['currency_id']),
					'currencyId'  => $this->currencyIso,
					'categoryId'  => $p->mainCategory->id,
					'picture'     => $p->mainImage ? Yii::app()->createAbsoluteUrl($p->mainImage->getUrl()) : null,
					'name'        => CHtml::encode($p->name),
					'description' => $this->clearText($p->short_description),
				));
			}
			else
			{
				foreach($p->variants as $v)
				{
					$name = strtr('{product}({attr} {option})', array(
						'{product}' => $p->name,
						'{attr}'    => $v->attribute->title,
						'{option}'  => $v->option->value
					));

					$hashtag = '#'.$v->attribute->name.':'.$v->option->id;

					$this->renderOffer($p, array(
						'url'         => Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$p->url)).$hashtag,
						'price'       => Yii::app()->currency->convert(StoreProduct::calculatePrices($p, $p->variants, 0), $this->_config['currency_id']),
						'currencyId'  => $this->currencyIso,
						'categoryId'  => $p->mainCategory->id,
						'picture'     => $p->mainImage ? Yii::app()->createAbsoluteUrl($p->mainImage->getUrl()) : null,
						'name'        => CHtml::encode($name),
						'description' => $this->clearText($p->short_description),
					));
				}
			}
		}
	}

	/**
	 * @param StoreProduct $p
	 * @param array $data
	 */
	public function renderOffer(StoreProduct $p, array $data)
	{
		$available = ($p->availability==1) ? 'true' : 'false';
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
