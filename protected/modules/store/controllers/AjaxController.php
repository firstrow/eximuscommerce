<?php

/**
 * Handle ajax requests
 */
class AjaxController extends Controller
{

	
	/**
	 * Set currency for user session.
	 */
	public function actionActivateCurrency()
	{
		Yii::app()->currency->setActive(Yii::app()->request->getParam('id'));
	}

	/**
	 * Rate product
	 * @param integer $id product id
	 */
	public function actionRateProduct($id)
	{
		$request = Yii::app()->request;
		if($request->isAjaxRequest)
		{
			$model=StoreProduct::model()->active()->findByPk($id);

			$cookieName='rating_'.$model->id;
			$rating = (int) $_GET['rating'];
			if($model && in_array($rating, array(1,2,3,4,5)))
			{
				$model->saveCounters(array(
					'votes'=>1,
					'rating'=>$rating
				));

				$cookie=new CHttpCookie($cookieName, true);
				$cookie->expire=time()+60*60*24*60;
				Yii::app()->request->cookies[$cookieName]=$cookie;
			}
		}
	}

}