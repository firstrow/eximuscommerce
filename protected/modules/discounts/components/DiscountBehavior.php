<?php

Yii::import('application.modules.discounts.models.Discount');

/**
 * Product discount behavior
 *
 * @var $owner StoreProduct
 */
class DiscountBehavior extends CActiveRecordBehavior
{

	/**
	 * @var mixed|null|Discount
	 */
	public $appliedDiscount = null;

	/**
	 * @var float product price before discount applied
	 */
	public $originalPrice;

	/**
	 * @var null
	 */
	public static $discounts = null;

	/**
	 * Attach behavior to model
	 * @param $owner
	 */
	public function attach($owner)
	{
		if(!$owner->isNewRecord && Yii::app()->controller instanceof Controller)
		{
			if(DiscountBehavior::$discounts === null)
			{
				DiscountBehavior::$discounts = Discount::model()
					->activeOnly()
					->applyDate()
					->findAll();
			}

			parent::attach($owner);
		}
	}

	/**
	 * After find event
	 */
	public function afterFind()
	{
		if($this->appliedDiscount!==null)
			return;

		// Process discount rules
		foreach(DiscountBehavior::$discounts as $discount)
		{
			$apply = false;
			// Validate category
			if($this->searchArray($discount->categories, CHtml::listData($this->owner->categories, 'id', 'id')))
			{
				$apply=true;

				// Validate manufacturer
				if(!empty($discount->manufacturers))
					$apply = in_array($this->owner->manufacturer_id,$discount->manufacturers);

				if($apply===true)
					$this->applyDiscount($discount);
			}
		}
	}

	/**
	 * Apply discount to product and decrease its price
	 * @param Discount $discount
	 */
	protected function applyDiscount(Discount $discount)
	{
		if($this->appliedDiscount===null)
		{
			$sum = $discount->sum;
			if('%'===substr($discount->sum,-1,1))
				$sum=$this->owner->price * (int)$sum / 100;

			$this->originalPrice = $this->owner->price;
			$this->owner->price -= $sum;
			$this->appliedDiscount = $discount;
		}
	}

	/**
	 * Search value from $a in $b
	 * @param array $a
	 * @param array $b
	 */
	protected function searchArray(array $a, array $b)
	{
		foreach($a as $v)
			if(in_array($v, $b)) return true;
		return false;
	}
}
