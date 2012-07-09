<?php

/**
 * Admin attribute controller
 */
class AttributeController extends SAdminController
{

	/**
	 * Display attribute list
	 */
	public function actionIndex()
	{
		$model = new StoreAttribute('search');

		// By default position is 0, we set it to null to display all results
		$model->position = null;

		if (!empty($_GET['StoreAttribute']))
			$model->attributes = $_GET['StoreAttribute'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
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
				->language($_GET)
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Атрибут не найден.'));

		$form = new STabbedForm('application.modules.store.views.admin.attribute.attributeForm', $model);
		$form->additionalTabs = array(
			Yii::t('StoreModule.admin', 'Опции')=>$this->renderPartial('_options', array(
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

	/**
	 * Save attribute options
	 * @param StoreAttribute $model
	 */
	protected function saveOptions($model)
	{
		$dontDelete = array();
		if(!empty($_POST['options']))
		{
			$position = 0;
			foreach($_POST['options'] as $key=>$val)
			{
				if(isset($val[0]) && $val[0] != '')
				{
					$index = 0;

					$attributeOption = StoreAttributeOption::model()
						->findByAttributes(array(
							'id'=>$key,
							'attribute_id'=>$model->id
						));

					if(!$attributeOption)
					{
						$attributeOption = new StoreAttributeOption;
						$attributeOption->attribute_id = $model->id;
					}
					$attributeOption->position = $position;
					$attributeOption->save(false);

					foreach(Yii::app()->languageManager->languages as $lang)
					{
						$attributeOption = StoreAttributeOption::model()
							->language($lang->id)
							->findByAttributes(array(
								'id'=>$attributeOption->id
							));
						$attributeOption->value = $val[$index];
						$attributeOption->save(false);

						++$index;
					}

					array_push($dontDelete, $attributeOption->id);

					$position++;
				}
			}
		}

		if(sizeof($dontDelete))
		{
			$cr = new CDbCriteria;
			$cr->addNotInCondition('t.id', $dontDelete);
			$optionsToDelete = StoreAttributeOption::model()->findAllByAttributes(array(
				'attribute_id'=>$model->id
			), $cr);
		}
		else
		{
			// Clear all attribute options
			$optionsToDelete = StoreAttributeOption::model()->findAllByAttributes(array(
				'attribute_id'=>$model->id
			));
		}

		if(!empty($optionsToDelete))
		{
			foreach($optionsToDelete as $o)
				$o->delete();
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
				{
					$count = StoreProduct::model()->withEavAttributes(array($m->name))->count();
					if($count)
						throw new CHttpException(503, Yii::t('StoreModule.admin', 'Ошибка удаления атрибута - он используется продуктами.'));
					$m->delete();
				}
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}
