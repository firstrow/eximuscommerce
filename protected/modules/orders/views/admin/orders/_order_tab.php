<style type="text/css">
    div.userData input[type=text] {
        width: 385px;
    }
    div.userData textarea {
        width: 385px;
    }
    #orderedProducts {
        padding: 0 0 5px 0;
    }
    .ui-dialog .ui-dialog-content {
        padding: 0;
    }
    #dialog-modal .grid-view {
        padding: 0;
    }
    #orderSummaryTable tr td {
        padding: 3px;
    }
</style>

<div class="form wide padding-all">
    <?php
    if($model->isNewRecord)
        $action='create';
    else
        $action='update';
    echo CHtml::form($this->createUrl($action, array('id'=>$model->id)), 'post', array('id'=>'orderUpdateForm'));

    if($model->hasErrors())
        echo CHtml::errorSummary($model);
    ?>
    <table width="100%">
        <tr valign="top">
            <td width="50%">
                <!-- User data -->
                <div class="userData">
                    <h4><?php echo Yii::t('OrdersModule.admin', 'Данные пользователя'); ?></h4>
                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'status_id', array('required'=>true)); ?>
                        <?php echo CHtml::activeDropDownList($model, 'status_id', CHtml::listData($statuses, 'id', 'name')); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'delivery_id', array('required'=>true)); ?>
                        <?php echo CHtml::activeDropDownList($model, 'delivery_id', CHtml::listData($deliveryMethods, 'id', 'name'), array(
                            'onChange'=>'recountOrderTotalPrice(this)',
                        )); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'paid'); ?>
                        <?php echo CHtml::activeCheckBox($model, 'paid'); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'discount'); ?>
                        <?php echo CHtml::activeTextField($model,'discount'); ?>
                        <div class="hint"><?php echo Yii::t('OrdersModule.admin', 'Применить скидку для общей суммы заказа'); ?></div>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'user_name', array('required'=>true)); ?>
                        <?php echo CHtml::activeTextField($model,'user_name'); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'user_email', array('required'=>true)); ?>
                        <?php echo CHtml::activeTextField($model,'user_email'); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'user_phone'); ?>
                        <?php echo CHtml::activeTextField($model,'user_phone'); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'user_address'); ?>
                        <?php echo CHtml::activeTextField($model,'user_address'); ?>
                    </div>

                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'user_comment'); ?>
                        <?php echo CHtml::activeTextArea($model,'user_comment'); ?>
                    </div>
                    <div class="row">
                        <?php echo CHtml::activeLabel($model,'admin_comment'); ?>
                        <?php echo CHtml::activeTextArea($model,'admin_comment'); ?>
                        <div class="hint"><?php echo Yii::t('OrdersModule.admin', 'Этот текст не виден для пользователя'); ?></div>
                    </div>
                </div>
            </td>
            <td>
                <!-- Right block -->
                <?php if(!$model->isNewRecord): ?>
                    <div style="float: right;padding-right: 10px">
                        <a href="javascript:openAddProductDialog(<?php echo $model->id ?>);"><?php echo Yii::t('OrdersModule.admin','Добавить продукт') ?></a>
                    </div>
                    <div id="dialog-modal" style="display: none;" title="<?php echo Yii::t('OrdersModule.admin','Добавить продукт') ?>">
                        <?php
                        $this->renderPartial('_addProduct', array(
                            'model'=>$model,
                        ));
                        ?>
                    </div>

                    <h4><?php echo Yii::t('OrdersModule.admin','Продукты') ?></h4>

                    <div id="orderedProducts">
                        <?php
                        $this->renderPartial('_orderedProducts', array(
                            'model'=>$model,
                        ));
                        ?>
                    </div>
                <?php endif;?>

            </td>
        </tr>
    </table>
    <?php echo CHtml::endForm(); ?>
</div>