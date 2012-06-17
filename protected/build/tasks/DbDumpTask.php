<?php

require_once '../bootstrap.php';

Yii::import('application.components.SDatabaseDumper');

$dumper=new SDatabaseDumper;

file_put_contents(Yii::getPathOfAlias('application.modules.install').'/data/dump.sql', $dumper->getDump());

