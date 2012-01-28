<?php

/**
 * SAdminTopButtons
 * Displays buttons on top to save object.
 */
class SAdminTopButtons extends CWidget {

	/**
	 * Links to controller actions
	 * @var string
	 */
	public $listAction = 'index';
	public $createAction = 'create';
	public $deleteAction = 'delete';
	public $defaultUpdateAction = 'update';
	public $updateAction;
	public $result = array();

	/**
	 * List of default css classes to append to each link
	 * @var array
	 */
	public $defaultLinkClasses = array();

	/**
	 * Default links templates.
	 * @var array
	 */
	public $template = array('history_back','save','dropDown','delete');

	/**
	 * Default links
	 * @var array
	 */
	private $_default = array();

	/**
	 * Form object
	 * @var CForm
	 */
	public $form = null;

	/**
	 * If isNew is set to false the `delete` button will not by displayed
	 * @var boolean
	 */
	public $isNew = false;

	/**
	 * From id to be submitted
	 * @var string
	 */
	public $formId;

	/**
	 * Add new elements to template if set to true.
	 * If set to false, need to configure $template array manually.
	 * @var boolen
	 */
	public $addNewElements = true;

	public $langSwitcher = false;

	/**
	 * List of buttons to display
	 * Example:
	 *
	 * 'linkName'=>array(
	 *      'link'=>array('controller/action', 'a'=>'b'),
	 *      'title'=>'Link Title',
	 *      'classes'=>array(),
	 *      'htmlOptions'=>array(),
	 *      ...
	 * )
	 *
	 * @var type array
	 */
	public $elements = array();

	public function run()
	{
		Yii::import('application.modules.admin.AdminModule');

		// Set update action from current url
		if (!$this->updateAction)
			$this->updateAction = Yii::app()->request->requestUri;

		if ($this->form)
			$this->formId = $this->form->id;

		$buttons = CMap::mergeArray($this->default, $this->elements);

		if ($this->addNewElements)
			$this->template = array_unique(CMap::mergeArray(array_keys($this->elements), $this->template));

		if ($this->langSwitcher)
			array_unshift($this->template, 'langSwitch');

		// Remove `delete` button on new record
		if ($this->form !== null)
		{
			$this->formId = $this->form->id;
			if ($this->form->model instanceof CActiveRecord)
			{
				// New record
				if (isset($this->form->model->isNewRecord) && $this->form->model->isNewRecord === true)
				{
					$this->isNew = ($this->form->model->isNewRecord) ? true: false;

					if ($this->isNew && array_search('delete', $this->template))
						unset($this->template[array_search('delete', $this->template)]);

					$this->updateAction = $this->defaultUpdateAction;
				}
			}
		}

		$n=0;
		foreach($this->template as $key)
		{
			$item = $buttons[$key];

			if (!isset($item['classes']))
				$item['classes'] = array();
			if (!isset($item['htmlOptions']))
				$item['htmlOptions'] = array();
			if (!isset($item['options']))
				$item['options'] = array();

			// Set link ID
			if (!isset($item['htmlOptions']['id']))
				$item['htmlOptions']['id'] = $key.'_topLink';

			$linkClasses = CMap::mergeArray($item['classes'], $this->defaultLinkClasses);

			$this->result[$key] = $this->widget('zii.widgets.jui.CJuiButton',
				array(
					'id'=> $item['htmlOptions']['id'],
					'name'=>$item['htmlOptions']['id'],
					'url'=>$item['link'],
					'buttonType'=>'link',
					'caption'=>$item['title'],
					'htmlOptions'=>CMap::mergeArray($item['htmlOptions'], array('class'=>implode(' ', $linkClasses))),
					'options'=>$item['options']
					)
			, true);
			$n++;
		}

		$this->registerScripts();
	}

	/**
	 * Load default buttons
	 * @return array
	 */
	public function getDefault()
	{
		$fullUrlToListAction = $this->getOwner()->createUrl($this->listAction);
		return array(
			'history_back'=>array(
				'link'=>'#',
				'title'=>Yii::t('AdminModule.admin', 'Назад'),
				'classes'=>array(''),
				'htmlOptions'=>array(
					'onClick'=>'history.back(-1); return false;',
					'title'=>Yii::t('AdminModule.admin', 'Назад'),
				),
				'options'=>array(
					'icons'=>array('primary'=>'ui-icon-arrow-1-w')
				)
			),
			'save'=>array(
				'link'=>$this->listAction,
				'title'=>Yii::t('AdminModule.admin', 'Сохранить'),
				'classes'=>array(),
				'htmlOptions'=>array(
					'onClick'=>$this->renderSubmitFormJs(),
				),
				'options'=>array(
					'icons'=>array('primary'=>'ui-icon-circle-check')
				)
			),
			'delete'=>array(
				'link'=>$this->deleteAction,
				'title'=>Yii::t('AdminModule.admin', 'Удалить'),
				'classes'=>array(),
				'htmlOptions'=>array(
					'title'=>Yii::t('AdminModule.admin', 'Удалить'),
					'confirm'=>Yii::t('AdminModule.admin', 'Удалить?'),
					'csrf'=>true,
					'ajax'=>array(
						'url'=>$this->deleteAction,
						'type'=>'POST',
						'data'=>array(
							Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
						),
						'success'=>"function(){ window.location = '$fullUrlToListAction' }",
						'error'=>"function(jqXHR, textStatus, errorThrown){ alert(jqXHR.responseText); }"
					),
				),
				'options'=>array(
					'icons'=>array('primary'=>'ui-icon-trash')
				)
			),
			'dropDown'=>array(
				'link'=>'#',
				'title'=>Yii::t('AdminModule.admin', 'Ещё'),
				 'options'=>array(
					'icons'=>array('primary'=>'ui-icon-triangle-1-s')
				)
			),
			'langSwitch'=>$this->getLangSwitchButton(),
		);
	}

	/**
	 * Create language switch button.
	 * @return array
	 */
	public function getLangSwitchButton()
	{
		$currentLang = Yii::app()->languageManager->default;

		if (isset($_GET['lang_id']))
			$currentId = $_GET['lang_id'];
		else
			$currentId = $currentLang->id;

		if (count(Yii::app()->languageManager->languages) > 1)
		{
			$langs = array();
			foreach(Yii::app()->languageManager->languages as $lang)
			{
				if($currentId != $lang->id)
				{
					$langs[] = array(
						'label'=>$this->getFlagImage($lang).CHtml::encode($lang['name']),
						'url'=>'#',
						'linkOptions'=>array(
							'onClick'=>"window.location = jQuery.param.querystring(window.location.href,{lang_id:$lang->id});",
						),
					);
				}
				else
					$currentLang = $lang;
			}

			Yii::app()->clientScript->registerScript('langSwithMenu', "
				$('#langSwitch_topLink').menu({
					content: $('#langSwitchButtonMenu').html(),
					showSpeed: 400
				});
			", CClientScript::POS_END);

			echo CHtml::openTag('div', array(
				'id'=>'langSwitchButtonMenu',
				'style'=>'display:none'
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$langs,
				'encodeLabel'=>false
			));
			echo CHtml::closeTag('div');
		}

		return array(
			'link'=>'#',
			'title'=>$this->getFlagImage($currentLang).CHtml::encode($currentLang->name),
			'options'=>array(
				'icons'=>array(
					'secondary'=>(count(Yii::app()->languageManager->languages) > 1) ? 'ui-icon-triangle-1-s' : null
				)
			)
		);
	}

	/**
	 * Create flag image for lang
	 * @param SSystemLanguage $lang
	 * @return string
	 */
	public function getFlagImage(SSystemLanguage $lang)
	{
		$adminAssetsUrl = Yii::app()->getModule('admin')->assetsUrl;
		if($lang->flag_name)
		{
			return CHtml::image($adminAssetsUrl.'/images/flags/png/'.$lang->flag_name, null, array(
				'width'=>16,
				'height'=>11,
				'align'=>'absmiddle',
				'style'=>'margin-bottom:2px',
			)).' ';
		}
	}

	public function registerScripts()
	{
		$cs = Yii::app()->getClientScript();
		// Submit form by id script.
		$cs->registerScript('topNavigationSubitForm', "
			function submitFormById(form_id, el)
			{
				var submitForm = $('#'+form_id);
				submitForm.append('<input type=hidden name=\'REDIRECT\' value=\''+$(el).attr('href')+'\'>');
				submitForm.submit();
				return false;
			}
		", CClientScript::POS_END);

		// Register stuff dropDown button scripts
		if (in_array('dropDown', $this->template))
		{
			$this->registerFgMenu();
			Yii::app()->clientScript->registerScript('dropDownButtonMenu', "
				$('#dropDown_topLink').menu({
					content: $('#dropDownButtonMenu').html(),
					showSpeed: 400
				});
			", CClientScript::POS_END);

			echo CHtml::openTag('div', array(
				'id'=>'dropDownButtonMenu',
				'style'=>'display:none'
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>array(
					array(
						'label'=>Yii::t('AdminModule.admin', 'Сохранить и создать'),
						'url'=>$this->createAction,
						'linkOptions'=>array(
							'onClick'=>$this->renderSubmitFormJs()
						),
					),
					array(
						'label'=>Yii::t('AdminModule.admin', 'Сохранить и редактировать'),
						'url'=>$this->updateAction,
						'linkOptions'=>array(
							'onClick'=>$this->renderSubmitFormJs()
						),
					),
				),
			));
			echo CHtml::closeTag('div');
		}

		if(in_array('langSwitch', $this->template))
			$this->registerFgMenu();
	}

	/**
	 * Register fg.menu scripts
	 */
	public function registerFgMenu()
	{
		$adminAssetsUrl = Yii::app()->getModule('admin')->assetsUrl;
		$cs = Yii::app()->clientScript;
		$cs->registerCssFile($adminAssetsUrl.'/vendors/fg.menu/fg.menu.css');
		$cs->registerScriptFile($adminAssetsUrl.'/vendors/fg.menu/fg.menu.js');
	}

	public function renderSubmitFormJs()
	{
		return  'return submitFormById(\''.$this->formId.'\', this);';
	}

	/**
	 * Display buttons
	 * @return string
	 */
	public function __toString()
	{
		$htmlResult = '';
		foreach($this->result as $link)
			$htmlResult .= $link;
		return $htmlResult;
	}
}
