<?php 
	$this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        'Права доступа'=>Rights::getBaseUrl(),
		Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
	);

	$this->pageHeader = Rights::t('core', 'Create :type', array(
		':type'=>Rights::getAuthItemTypeName($_GET['type']),
	));
?>

<div class="createAuthItem">
	<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
</div>