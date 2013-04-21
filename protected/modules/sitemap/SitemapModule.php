<?php

/**
 * Class SitemapModule
 */
class SitemapModule extends BaseModule
{

	/**
	 * @var string
	 */
	public $moduleName = 'sitemap';

	/**
	 * @var string
	 */
	public $changeFreq = 'daily';

	/**
	 * @var array
	 */
	public $urls = array();

	/**
	 * @return array
	 */
	public function getUrls()
	{
		$this->loadProducts();
		$this->loadManufacturers();
		$this->loadCategories();

		return $this->urls;
	}

	/**
	 * Load products data
	 */
	public function loadProducts()
	{
		$products = Yii::app()->db->createCommand()
			->from('StoreProduct')
			->select('url, updated as date')
			->queryAll();

		$this->populateUrls('store/frontProduct/view', $products);
	}

	/**
	 * Load manufacturers data
	 */
	public function loadManufacturers()
	{
		$records = Yii::app()->db->createCommand()
			->from('StoreManufacturer')
			->select('url')
			->queryAll();

		$this->populateUrls('store/manufacturer/index', $records);
	}

	/**
	 * Load categories data
	 */
	public function loadCategories()
	{
		$records = Yii::app()->db->createCommand()
			->from('StoreCategory')
			->select('url')
			->where('id > 1')
			->queryAll();

		$this->populateUrls('store/category/view', $records);
	}

	/**
	 * Populate urls data with store records.
	 *
	 * @param $route
	 * @param $records
	 * @param string $changefreq
	 * @param string $priority
	 */
	public function populateUrls($route, $records, $changefreq='daily', $priority='1.0')
	{
		$curdate = date('Y-m-d');

		foreach($records as $p)
		{
			$url = Yii::app()->createAbsoluteUrl($route, array('url'=>$p['url']));

			if(isset($p['date']))
				$date = date('Y-m-d', strtotime($p['date']));
			else
				$date=$curdate;

			$this->urls[$url] = array(
				'changefreq' => $changefreq,
				'lastmod'    => $date,
				'priority'   => $priority
			);
		}
	}
}