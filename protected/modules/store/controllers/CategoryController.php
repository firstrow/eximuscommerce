<?php

/**
 * Display category products
 */
class CategoryController extends Controller
{

	/**
	 * Display products list
	 * @param string $url category url
	 */
	public function actionView($url)
	{
//		$result = StoreProduct::model()
//			->with(array(
//				'categorization'=>array(
//					'condition'=>'categorization.category=:c',
//					'params'=>array(':c'=>$model->id)
//				),
//			))
//			->findAll($criteria);
//		var_dump($result);

		$model = $this->_loadModel($url);

		$criteria=new CDbCriteria;
		$criteria->with = array(
			'categorization'=>array('together'=>true),
		);
		$criteria->addCondition('categorization.category='.$model->id);
		$criteria->scopes = array('active');

		$provider = new CActiveDataProvider('StoreProduct', array(
			// Set id to false to not display model name in
			// sort and page params
			'id'=>false,
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>20,
			)
		));

		$view = $this->setDesign($model, 'view');
		$this->render($view, array(
			'provider'=>$provider,
			'model'=>$model
		));
	}

	/**
	 * Load category by url
	 * @param $url
	 * @return CActiveRecord
	 * @throws CHttpException
	 */
	public function _loadModel($url)
	{
		// Find category
		$model = StoreCategory::model()
			->withUrl($url)
			->find();

		if (!$model) throw new CHttpException(404, Yii::t('StoreModule.core', 'Категория не найдена.'));

		return $model;
	}
}
