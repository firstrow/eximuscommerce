<?php
/**
 * Images tabs
 */

$this->widget('CMultiFileUpload', array(
    'model'=>$model,
    'attribute'=>'files',
    'accept'=>'jpg|gif',
    'options'=>array(
//        'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
//        'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
//        'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
//        'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
//        'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
//        'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
    ),
));