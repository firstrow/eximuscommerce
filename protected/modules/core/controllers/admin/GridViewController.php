<?php

class GridViewController extends SAdminController
{

	/**
	 * @return array
	 */
	public function filters() {
		return array(
			'rights',
			'ajaxOnly + saveFilterData',
		);
	}

	/**
	 * Save personal user filter.
	 */
	public function actionSaveFilterData()
	{
		Yii::import('application.modules.core.models.GridViewFilter');
		$model = new GridViewFilter;
		$model->user_id = Yii::app()->user->id;
		$model->grid_id = $_POST['gridId'];
		$model->name = $_POST['filterName'];
		$model->data = $_POST['filterJsonData'];

		if ($model->validate())
			$model->save();
		else
			echo 'Error';
	}

	/**
	 * Load filter data
	 * @param type $id Filter id
	 */
	public function actionLoadFilterJsonData($id)
	{
		$model = $this->_loadModel($id);

		if ($model)
			echo $model->data;
	}

	/**
	 * Delete fiter and redirect user back to page.
	 * @param type $idfilter id
	 * @param type $redirect base64 encoded relative site url.
	 */
	public function actionDeleteFilter($id)
	{
		$model = $this->_loadModel($id);

		if ($model)
			$model->delete();
	}

	/**
	 * Load fiter model by PK.
	 * @param type $id
	 * @return GridViewFilter
	 */
	protected function _loadModel($id)
	{
		return GridViewFilter::model()->findByAttributes(array(
			'user_id'=>Yii::app()->user->id,
			'id'=>$id
		));
	}
}