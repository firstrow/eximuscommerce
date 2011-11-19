<?php

/**
 * SAdminTopButtons 
 * Displays base buttons on top to save object data.
 * Usage:
 * 
 * Yii::import('application.modules.admin.widgets.SAdminTopButtons');
 * $this->topButtons = $this->widget('SAdminTopButtons', array(
 *      'form'=>$form, // CForm object
 *      'template'=>array('save','delete', 'anyLinkName'),
 *      'elemnts'=>array(...),//Additional buttons. See SAdminTopbutton::$elements.
 *      'icon'='pen',
 *   ));
 * 
 */
class SAdminTopButtons extends CWidget {
    
    /**
     * Link to controller delete actions
     * @var string
     */
    public $listAction = 'index';
    public $createAction = 'create';
    public $updateAction = 'update';
    public $deleteAction = 'delete';
    public $result = array();
    
    /**
     * List of default css classes to append to each link
     * @var array
     */
    public $defaultLinkClasses = array('pill', 'button');
    
    /**
     * Default links templates. 
     * @var array
     */
    //public $template = array('history_back','save','saveCreate','saveEdit','delete');
    public $template = array('history_back','save','delete','dropDown');
    
    /**
     * Default links
     * @var array
     */
    public $default = array();
    
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
     *      'icon'=>'plus',
     * )
     * 
     * @var type array
     */
    public $elements = array();
    
    public function run()
    {
        Yii::import('application.modules.admin.AdminModule');

        if ($this->form)
            $this->formId = $this->form->id;
        
        $this->setDefault();        
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
        foreach ($this->template as $key)
        {
            $item = $buttons[$key];
            
            if (!isset($item['classes']))
                $item['classes'] = array();
            if (!isset($item['htmlOptions']))
                $item['htmlOptions'] = array();
            
            // Set link ID
            if (!isset($item['htmlOptions']['id']))
                $item['htmlOptions']['id'] = $key.'_topLink';
            
            $linkClasses = CMap::mergeArray($item['classes'], $this->defaultLinkClasses);
            
            if (sizeof($this->template) > 1)
            {
                if ($n===0 && sizeof($this->template) > 1)
                    $linkClasses[] = 'left';
                elseif ($n == sizeof($this->template) - 1)
                    $linkClasses[] = 'right';
                else
                    $linkClasses[] = 'middle';
            }
            
            $item['htmlOptions'] = CMap::mergeArray($item['htmlOptions'], array('class'=>implode(' ', $linkClasses)));
            
            $this->result[$key] = CHtml::link($this->renderLinkIcon($item).$item['title'], $item['link'], $item['htmlOptions']);
            $n++;
        }
    }
    
    /**
     * Load default buttons
     */
    protected function setDefault()
    {
        $this->default = array(
            'history_back'=>array(
                'link'=>'#',
                'title'=>Yii::t('AdminModule.admin', 'Назад'),
                'classes'=>array(''),
                'htmlOptions'=>array(
                    'onClick'=>'history.back(-1); return false;',
                    'title'=>Yii::t('AdminModule.admin', 'Назад'),
                ),
                'icon'=>'leftarrow notext',
            ),            
            'save'=>array(
                'link'=>$this->listAction,
                'title'=>Yii::t('AdminModule.admin', 'Сохранить'),
                'classes'=>array('primary'),
                'htmlOptions'=>array(
                    'onClick'=>$this->renderSubmitFormJs(),
                ),
                'icon'=>'check',
            ),
            'saveCreate'=>array(
                'link'=>$this->createAction,
                'title'=>Yii::t('AdminModule.admin', 'Сохранить и создать'),
                'classes'=>array(),
                'htmlOptions'=>array(
                    'onClick'=>$this->renderSubmitFormJs(),
                    'title'=>Yii::t('AdminModule.admin', 'Сохранить и создать'),
                ),
                'icon'=>'plus',
            ),
            'saveEdit'=>array(
                'link'=>$this->updateAction,
                'title'=>Yii::t('AdminModule.admin', 'Сохранить и редактировать'),
                'classes'=>array(),
                'htmlOptions'=>array(
                    'onClick'=>$this->renderSubmitFormJs(),
                    'title'=>Yii::t('AdminModule.admin', 'Сохранить и редактировать'),
                ),
                'icon'=>'pen',
            ),
            'dropDown'=>array(
                'link'=>'#',
                'title'=>'Ещё',
                'icon'=>'downarrow',
            ),
            'delete'=>array(
                'link'=>$this->deleteAction,
                'title'=>Yii::t('AdminModule.admin', 'Удалить'),
                'classes'=>array('negative'),
                'htmlOptions'=>array(
                    'onClick'=>$this->renderSubmitFormJs(),
                    'title'=>Yii::t('AdminModule.admin', 'Удалить'),
                ),
                'icon'=>'cross',
            ),
        );
    }
    
    /**
     * Generate code to display icon
     * 
     * @param array $item Item properties
     * @return string 
     */
    public function renderLinkIcon($item)
    {
        if (isset($item['icon']) && !empty($item['icon']))
            return '<span class="'.$item['icon'].' icon"></span>';         
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
                    <li><a href="{createAction}" onClick="{onClick}">Сохранить и создать</a></li>
                    <li><a href="{updateAction}" onClick="{onClick}">Сохранить и редактировать</a></li>
                </ul>
            </div>
        ', array(
            '{createAction}'=>$this->createAction,
            '{updateAction}'=>$this->updateAction,
            '{onClick}'=>$this->renderSubmitFormJs()
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
