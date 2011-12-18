<?php

    /**
     * Create/update category
     */

    $descendants=$model->ancestors()->findAll();
    var_dump($descendants);

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'form'=>$form,
        //'langSwitcher'=>!$model->isNewRecord,
        'deleteAction'=>$this->createUrl('/store/admin/products/delete', array('id'=>$model->id))
    ));

    $title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание категории') :
        Yii::t('StoreModule.admin', 'Редактирование категории');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('StoreModule.admin', 'Категории')=>$this->createUrl('index'),
        ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание категории') : CHtml::encode($model->name),
    );

    $this->pageHeader = $title;

    $this->widget('application.modules.admin.widgets.schosen.SChosen', array(
        'elements'=>array('StoreCategory_parent_id')
    ));

?>

<div class="form wide padding-all">
    <?php echo $form->asTabs(); ?>
</div>
