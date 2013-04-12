<?php
	/** var StoreProduct $model **/
?>

<script type="text/javascript">
	function sendNotifyRequest()
	{
		var form = $("#notify_me form");
		$.ajax({
			type: 'post',
			url: form.attr("action"),
			data: form.serialize()
		}).done(function() {
			$("#notify_me").dialog("close");
				$.jGrowl("Спасибо. Мы сообщим вам когда товар появится в наличии.", {position:"bottom-right"});
		});
		return false;
	}

	function showNotifierPopup(product_id)
	{
		$("#notify_me").find("input[name=product_id]").val(product_id);
		$("#notify_me").dialog("open");
		return false;
	}
</script>

<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id' => 'notify_me',
		'options' => array(
			'title'    => Yii::t('core', 'Сообщить о появлении'),
			'autoOpen' => false,
			'modal'    => true,
			'width'    => '470px',
			'buttons'  => array(
				array('text'=>'Отправить', 'click'=>'js:function(){ return sendNotifyRequest() }'),
				array('text'=>'Отмена', 'click'=>'js:function(){ $("#notify_me").dialog("close") }'),
			),
		)
	));
?>
	<div class="form wide">
		<?= CHtml::form('/notifyRequest/index', 'post', array('onSubmit'=>'return sendNotifyRequest()')) ?>
			<input type="hidden" name="product_id" class="product_id">
			<div class="row">
				<label>Ваш Email:</label>
				<input type="text" name="email">
			</div>
		<?= CHtml::endForm() ?>
	</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
