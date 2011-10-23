<?php
	/*** Display list of modules aviable for installation ***/

	$this->pageHeader = Yii::t('CoreModule.admin', 'Список доступных модулей');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('CoreModule.admin', 'Модули')=>$this->createUrl('index'),
        Yii::t('CoreModule.admin', 'Установка'),
    );

?>
<div class="padding-all">
	<?php if (!empty($modules)): ?>
		<?php foreach ($modules as $module=>$info): ?>
			<div>
				<b><?php echo $info['name'].' '.$info['version'] ?></b>
				<p>
					<?php echo $info['description'] ?>
				</p>
				<p>
					<?php echo CHtml::link('Установить', $this->createUrl('install', array('name'=>$module))) ?>
				</p>

				<br/>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		Нет доступных модулей для установки.
	<?php endif; ?>
</div>