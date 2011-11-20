<?php
    // Page create/edit view

    //$this->sidebarContent = ';';

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'form'=>$form,
    ));

    $title = ($model->isNewRecord) ? Yii::t('PagesModule.admin', 'Создание категории') : 
        Yii::t('PagesModule.admin', 'Редактирование категории');
    
    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('PagesModule.admin', 'Категории')=>$this->createUrl('index'),
        ($model->isNewRecord) ? Yii::t('PagesModule.admin', 'Создание категории') : CHtml::encode($model->name),
    );
    
    $this->pageHeader = $title;
?>

<div class="form wide padding-all">
    <?php echo $form->asTabs() ?>
</div>
