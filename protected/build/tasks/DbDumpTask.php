<?php

require_once '../bootstrap.php';

Yii::import('application.components.SDatabaseDumper');

$dumper=new SDatabaseDumper;

$content = "\nSET sql_mode = '';\n";
$content .= $dumper->getDump();

file_put_contents(Yii::getPathOfAlias('application.modules.install').'/data/dump.sql', $content);

