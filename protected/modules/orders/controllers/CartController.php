<?php

/**
 * Cart controller
 */
class CartController extends Controller
{

	protected $_errors = false;

	public function beforeAction()
	{
		Yii::import('application.modules.store.models.*');
		return true;
	}

	/**
	 * Display list of product added to cart
	 */
	public function actionIndex()
	{
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('recount') && !empty($_POST['quantities']))
			Yii::app()->cart->recount(Yii::app()->request->getPost('quantities'));

		$this->render('index');
	}

	/**
	 * Add new product to cart
	 */
	public function actionAdd()
	{
		$variants = array();

		// Load product model
		$model = StoreProduct::model()
			->active()
			->findByPk(Yii::app()->request->getPost('product_id', 0));

		// Check product
		if(!isset($model))
			$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Продукт не найден'), true);

		// Proccess variants
		if(!empty($_POST['eav']))
		{
			foreach($_POST['eav'] as $attribute_id=>$variant_id)
			{
				// Check if attribute/option exists
				if(!$this->_checkVariantExists($_POST['product_id'], $attribute_id, $variant_id) && $variant_id != '0')
					$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Вариант продукта не найден.'));
				else
					array_push($variants, $variant_id);
			}
		}

		// Process configurables
		if($model->use_configurations)
		{
			// Get last conf item
			$configurable_id  = Yii::app()->request->getPost('configurable_id', 0);

			if(!in_array($configurable_id , $model->configurations))
				$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Выберите вариант продукта.'), true);
		}else
			$configurable_id  = 0;

		Yii::app()->cart->add(array(
			'product_id'      => $model->id,
			'variants'        => $variants,
			'configurable_id' => $configurable_id,
			'quantity'        => (int) Yii::app()->request->getPost('quantity', 1),
			'price'           => $model->price,
		));

		$this->_finish();
	}

	/**
	 * Check if product variantion exists
	 * @param $product_id
	 * @param $attribute_id
	 * @param $variant_id
	 * @return string
	 */
	protected function _checkVariantExists($product_id, $attribute_id, $variant_id)
	{
		return StoreProductVariant::model()->countByAttributes(array(
			'id'           => $variant_id,
			'product_id'   => $product_id,
			'attribute_id' => $attribute_id
		));
	}

	/**
	 * Remove product from cart
	 */
	public function actionRemove($index)
	{
		Yii::app()->cart->remove($index);

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Create new order
	 */
	public function actionCreate()
	{
	}

	/**
	 * View created order
	 */
	public function actionView()
	{
	}

	/**
	 * Process result and exit!
	 */
	protected function _finish()
	{
		echo CJSON::encode(array(
			'errors'=>$this->_errors,
			'message'=>Yii::t('OrdersModule.core','Продукт успешно добавлен в корзину'),
		));
		exit;
	}

	/**
	 * Add message to errors array.
	 * @param string $message
	 * @param bool $fatal finish request
	 */
	protected function _addError($message, $fatal = false)
	{
		if($this->_errors === false)
			$this->_errors = array();

		array_push($this->_errors, $message);

		if($fatal === true)
			$this->_finish();
	}
}
