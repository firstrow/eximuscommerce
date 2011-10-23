<?php
    // User create/edit view

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'form'=>$form,
    ));

    $title = ($model->isNewRecord) ? Yii::t('UsersModule.admin', 'Создание пользователя') : Yii::t('UsersModule.admin', 'Редактирование пользователя');
    
    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('UsersModule.admin', 'Пользователи')=>$this->createUrl('index'),
        ($model->isNewRecord) ? Yii::t('UsersModule.admin', 'Создание пользователя') : CHtml::encode($model->username),
    );
    
    $this->pageHeader = $title;
?>

<div class="form wide padding-all">
    <?php echo $form; ?>
</div>

