<?php

/**
 * Admin attribute controller
 */
class AttributeController extends SAdminController {

	/**
	 * Display attribute list
	 */
	public function actionIndex()
	{
		$model = new StoreAttribute('search');

		if (!empty($_GET['StoreAttribute']))
			$model->attributes = $_GET['StoreAttribute'];

		$this->render('index', array(
			'model'=>$model
		));
	}

	/**
	 * Create new attribute
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update attribute
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new StoreAttribute;
		else
		{
			$model = StoreAttribute::model()
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Атрибут не найден.'));

		$form = new STabbedForm('application.modules.store.views.admin.attribute.attributeForm', $model);
		$form->additionalTabs = array(
			'Опции'=>$this->renderPartial('_options', array(
				'model'=>$model,
			), true),
		);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreAttribute'];

			if ($model->validate())
			{
				$model->save();

				$this->saveOptions($model);

				$this->setFlashMessage(Yii::t('StoreModule.admin', 'Изменения успешно сохранены'));

				if (isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect('create');
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'form'=>$form,
		));
	}

	protected function saveOptions($model)
	{
		$dontDelete = array();
		// Process options
		if(!empty($_POST['options']))
		{
			$position = 0;
			foreach($_POST['options'] as $key=>$val)
			{
				if(isset($val[0]) && $val[0] != '')
				{
					$attributeOption = StoreAttributeOption::model()->findByAttributes(array(
						'id'=>$key,
						'attribute_id'=>$model->id
					));

					if(!$attributeOption)
					{
						$attributeOption = new StoreAttributeOption;
						$attributeOption->attribute_id = $model->id;
					}
					$attributeOption->value = $val[0];
					$attributeOption->position = $position;
					$attributeOption->save(false);

					array_push($dontDelete, $attributeOption->id);
					$position++;
				}
			}
		}

		if(sizeof($dontDelete))
		{
			$cr = new CDbCriteria;
			$cr->addNotInCondition('id', $dontDelete);
			StoreAttributeOption::model()->deleteAllByAttributes(array(
				'attribute_id'=>$model->id
			), $cr);
		}
		else
		{
			// Clear all attribute options
			StoreAttributeOption::model()->deleteAllByAttributes(array(
				'attribute_id'=>$model->id
			));
		}
	}

	/**
	 * Delete attribute
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StoreAttribute::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $m)
					$m->delete();
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}
