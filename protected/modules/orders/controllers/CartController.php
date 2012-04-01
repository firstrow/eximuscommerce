<?php

Yii::import('orders.models.*');
Yii::import('store.models.*');

/**
 * Cart controller
 *
 */
class CartController extends Controller
{

	/**
	 * @var OrderCreateForm
	 */
	public $form;

	protected $_errors = false;

	/**
	 * Display list of product added to cart
	 */
	public function actionIndex()
	{
		// Recount
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('recount') && !empty($_POST['quantities']))
			$this->processRecount();

		$this->form = new OrderCreateForm;

		// Make order
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('create'))
		{
			if(isset($_POST['OrderCreateForm']))
			{
				$this->form->attributes = $_POST['OrderCreateForm'];

				if($this->form->validate())
					$this->createOrder();
			}
		}

		$this->render('index');
	}

	/**
	 * Validate POST data and add product to cart
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

			if($configurable_id && !in_array($configurable_id , $model->configurations))
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
	 * Remove product from cart and redirect
	 */
	public function actionRemove($index)
	{
		Yii::app()->cart->remove($index);

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Clear cart
	 */
	public function actionClear()
	{
		Yii::app()->cart->clear();

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Create new order
	 * @return Order
	 */
	public function createOrder()
	{
		if(Yii::app()->cart->countItems() == 0)
			return false;

		$order = new Order;

		// Set main data
		$order->user_name    = $this->form->name;
		$order->user_email   = $this->form->email;
		$order->user_phone   = $this->form->phone;
		$order->user_address = $this->form->address;
		$order->user_comment = $this->form->comment;
		$order->delivery_id  = $this->form->delivery_id;

		if($order->validate())
			$order->save();
		else
			exit;

		// Process products
		foreach(Yii::app()->cart->getDataWithModels() as $item)
		{
			$ordered_product = new OrderProduct;
			$ordered_product->order_id        = $order->id;
			$ordered_product->product_id      = $item['model']->id;
			$ordered_product->configurable_id = $item['configurable_id'];
			$ordered_product->name            = $item['model']->name;
			$ordered_product->quantity        = $item['quantity'];
			$ordered_product->sku             = $item['model']->sku;
			$ordered_product->price           = StoreProduct::calculatePrices($item['model'], $item['variant_models'], $item['configurable_id']);

			// Process configurable product
			if(isset($item['configurable_model']) && $item['configurable_model'] instanceof StoreProduct)
			{
				$ordered_product->configurable_name = $item['configurable_model']->name;
				// Use configurable product sku
				$ordered_product->sku = $item['configurable_model']->sku;
			}

			// Save selected variants as key/value array
			if(!empty($item['variant_models']))
			{
				$variants = array();
				foreach($item['variant_models'] as $variant)
					$variants[$variant->attribute->title] = $variant->option->value;
				$ordered_product->variants = serialize($variants);
			}

			$ordered_product->save();
		}

		// All products added. Update delivery price
		$order->updateDeliveryPrice();

		return $order;
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
	 * Recount product quantity and redirect
	 */
	public function processRecount()
	{
		Yii::app()->cart->recount(Yii::app()->request->getPost('quantities'));

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
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
}
