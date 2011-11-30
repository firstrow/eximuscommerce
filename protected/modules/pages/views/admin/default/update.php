<?php
    // Page create/edit view
    
    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'form'=>$form,
        'langSwitcher'=>!$model->isNewRecord,
        'deleteAction'=>$this->createUrl('/pages/admin/default/delete', array('id'=>$model->id))
    ));

    $title = ($model->isNewRecord) ? Yii::t('PagesModule.admin', 'Создание страницы') : 
        Yii::t('PagesModule.admin', 'Редактирование страницы');
    
    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('PagesModule.admin', 'Страницы')=>$this->createUrl('index'),
        ($model->isNewRecord) ? Yii::t('PagesModule.admin', 'Создание страницы') : CHtml::encode($model->title),
    );

    $this->widget('application.modules.admin.widgets.schosen.SChosen', array(
        'elements'=>array('Page_category_id')
    ));
    
    $this->pageHeader = $title;
?>

<!-- Use padding-all class with SidebarAdminTabs -->
<div class="form wide padding-all">
    <?php echo $form->asTabs(); ?>
</div>

