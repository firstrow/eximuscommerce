<?php


class SCompareProducts extends CComponent
{

	/**
	 * @var string
	 */
	public $sessionKey = 'SCompareProducts';

	/**
	 * @var CHttpSession
	 */
	public $session;

	/**
	 * @var array
	 */
	private $_products;

	/**
	 * @var array
	 */
	private $_attributes;

	/**
	 * Initialize component
	 */
	public function __construct()
	{
		$this->session = Yii::app()->session;

		if(!isset($this->session[$this->sessionKey]) || !is_array($this->session[$this->sessionKey]))
			$this->session[$this->sessionKey] = array();
	}

	/**
	 * Check if product exists add to list
	 * @param string $id product id
	 */
	public function add($id)
	{
		if(StoreProduct::model()->active()->countByAttributes(array('id'=>$id))>0)
		{
			$current=$this->getIds();
			$current[(int)$id]=(int)$id;
			$this->setIds($current);
		}
	}

	/**
	 * Remove product from list
	 * @param $id
	 */
	public function remove($id)
	{
		$current=$this->getIds();
		if(isset($current[$id]))
			unset($current[$id]);
		$this->setIds($current);
	}

	/**
	 * @return array of product id added to compare
	 */
	public function getIds()
	{
		return $this->session[$this->sessionKey];
	}

	/**
	 * @param array $ids
	 */
	public function setIds(array $ids)
	{
		$this->session[$this->sessionKey]=array_unique($ids);
	}

	/**
	 * Clear compare list
	 */
	public function clear()
	{
		$this->setIds(array());
	}

	/**
	 * @return array of StoreProduct models to compare
	 */
	public function getProducts()
	{
		if($this->_products===null)
			$this->_products=StoreProduct::model()->findAllByPk(array_values($this->getIds()));
		return $this->_products;
	}

	/**
	 * Load StoreAttribute models by names
	 * @return array of StoreAttribute models
	 */
	public function getAttributes()
	{
		if($this->_attributes===null)
		{
			$names=array();
			foreach($this->getProducts() as $p)
				$names=array_merge($names,array_keys($p->getEavAttributes()));

			$cr = new CDbCriteria;
			$cr->addInCondition('StoreAttribute.name', $names);
			$query = StoreAttribute::model()
				->displayOnFront()
				->useInCompare()
				->findAll($cr);

			foreach($query as $m)
				$this->_attributes[$m->name] = $m;
		}
		return $this->_attributes;
	}
}
