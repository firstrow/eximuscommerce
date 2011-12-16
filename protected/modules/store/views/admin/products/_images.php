<style type="text/css">
    .images li img {
        width: 150px;
        height: 150px;
        background-color: #a0522d;
        border: 1px solid #c0c0c0;
    }
</style>

<ul class="images">
    <li>
        <img src="/uploads/product/1.jpg">
    </li>
</ul>

<?php
/**
 * Images tabs
 */

$this->widget('system.web.widgets.CMultiFileUpload', array(
    'name'=>'StoreProductImages',
    'model'=>$model,
    'attribute'=>'files',
    'accept'=>implode('|', Yii::app()->params['storeImages']['extensions']),
    'options'=>array(
//        'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
//        'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
//        'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
//        'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
//        'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
//        'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
    ),
));
?>