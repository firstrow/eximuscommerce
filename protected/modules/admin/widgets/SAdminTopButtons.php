<?php

/**
 * SAdminTopButtons 
 * Displays base buttons on top to save object.
 */
class SAdminTopButtons extends CWidget {
    
    /**
     * Link to controller actions
     * @var string
     */
    public $listAction = 'index';
    public $createAction = 'create';
    public $updateAction;
    public $deleteAction = 'delete';
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
     * If if new is set to false the `delete` button will not by displayed
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
    
    /**
     * List of buttons to display
     * Example:
     * 
     * 'linkName'=>array(
     *      'link'=>array('controller/action', 'a'=>'b'),
     *      'title'=>'Link Title',
     *      'classes'=>array(),
     *      'htmlOptions'=>array(),
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
        
        $this->registerScripts();
        
        $buttons = CMap::mergeArray($this->default, $this->elements);
        
        if ($this->addNewElements)
            $this->template = array_unique(CMap::mergeArray(array_keys($this->elements), $this->template));
        
        // Remove `delete` button on new record
        if ($this->form !== null)
        {
            $this->formId = $this->form->id;
            if (isset($this->form->model->isNewRecord) && array_search('delete', $this->template))
            {
                $this->isNew = ($this->form->model->isNewRecord) ? true: false;
                if ($this->isNew)
                    unset($this->template[array_search('delete', $this->template)]);
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
    }
    
    /**
     * Load default buttons
     */
    public function getDefault()
    {
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
                        'success'=>"function(){ window.location = '$this->listAction' }"
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
        );
    }
    
    public function registerScripts()
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerScript('topNavigationSubitForm', "
            function submitFormById(form_id, el)
            {
                var submitForm = $('#'+form_id);
                submitForm.append('<input type=hidden name=\'REDIRECT\' value=\''+$(el).attr('href')+'\'>');
                submitForm.submit();
                return false;
            }

            // Dropdrop menu        
            $('#dropDown_topLink').menu({ 
                content: $('#dropDownButtonMenu').html(), 
                showSpeed: 400 
            });
        ", CClientScript::POS_END);

        echo strtr('<div class="hidden" id="dropDownButtonMenu">
                <ul>
                    <li><a href="{createAction}" onClick="{onClick}">{save&create}</a></li>
                    <li><a href="{updateAction}" onClick="{onClick}">{save&edit}</a></li>
                </ul>
            </div>
        ', array(
            '{createAction}'=>$this->createAction,
            '{updateAction}'=>$this->updateAction,
            '{onClick}'=>$this->renderSubmitFormJs(),
            '{save&create}'=>Yii::t('AdminModule.admin', 'Сохранить и создать'),
            '{save&edit}'=>Yii::t('AdminModule.admin', 'Сохранить и редактировать')
        ));
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
        foreach($this->result as $key=>$link)
            $htmlResult .= $link;
        
        return $htmlResult;
    }
}
