<?php

require_once '../bootstrap.php';

Yii::import('application.modules.store.models.*');
Yii::import('application.modules.store.models..wishlist.*');
Yii::import('application.modules.orders.models.*');
Yii::import('application.modules.logger.models.*');
Yii::import('application.modules.comments.models.*');
Yii::import('application.modules.discounts.models.*');

$clear=array(
	'StoreProduct',
	'StoreAttribute',
	'StoreManufacturer',
	'Order',
	'ActionLog',
	'StoreWishlist',
	'Comment',
	'StoreProductType',
	'Discount',
);

$truncate = array(
	'accounting1c',
	'grid_view_filter',
);

foreach($clear as $class)
{
	ClearData_objects($class);
	ClearData_truncate($class::model()->tableName());
}

$type=new StoreProductType;
$type->name='Простой продукт';
$type->save();

foreach($truncate as $tblName)
	ClearData_truncate($tblName);

$root=StoreCategory::model()->findByPk(1);
ClearData_deleteCategory(array($root));
ClearData_deleteCategory(array($root));

function ClearData_deleteCategory(array $cats)
{
	foreach($cats as $c)
	{
		if($c->children()->count() > 0)
			ClearData_deleteCategory($c->children()->findAll());
		else
			$c->deleteNode();
	}

}

/**
 * @param $className
 */
function ClearData_objects($className)
{
	foreach($className::model()->findAll() as $p)
		$p->delete();
}

/**
 * @param $tblName
 */
function ClearData_truncate($tblName)
{
	Yii::app()->db->createCommand("TRUNCATE TABLE `$tblName`;")->query();
}