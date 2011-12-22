<?php
    // Language create/edit view

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'form'=>$form,
        'deleteAction'=>$this->createUrl('/pages/admin/default/delete', array('id'=>$model->id))
    ));

    $title = ($model->isNewRecord) ? Yii::t('CoreModule.admin', 'Создание языка') :
        Yii::t('CoreModule.admin', 'Редактирование языка');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('CoreModule.admin', 'Языки')=>$this->createUrl('index'),
        ($model->isNewRecord) ? Yii::t('CoreModule.admin', 'Создание языка') : CHtml::encode($model->name),
    );

    $this->pageHeader = $title;
?>

<div class="form wide padding-all">
    <?php echo $form ?>
</div>

