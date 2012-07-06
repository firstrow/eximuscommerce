<?php
	/*** Display list of modules available for installation ***/

	$this->pageHeader = Yii::t('CoreModule.admin', Yii::t('CoreModule.core', 'Список доступных модулей'));

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('CoreModule.admin', Yii::t('CoreModule.core', 'Модули'))=>$this->createUrl('index'),
		Yii::t('CoreModule.admin', Yii::t('CoreModule.core', 'Установка')),
	);

?>
<div class="padding-all">
	<?php if (!empty($modules)): ?>
		<?php foreach ($modules as $module=>$info): ?>
			<div>
				<b><?php echo CHtml::encode($info['name'].' '.$info['version']) ?></b>
				<p>
					<?php echo $info['description'] ?>
				</p>
				<p>
					<?php echo CHtml::link(Yii::t('CoreModule.core', 'Установить'), $this->createUrl('install', array('name'=>$module))) ?>
				</p>

				<br/>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<?php Yii::t('CoreModule.core', 'Нет доступных модулей для установки.') ?>
	<?php endif; ?>
</div>