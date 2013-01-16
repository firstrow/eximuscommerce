<?php
	/** var StoreProduct $model **/
?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#notify_me .cancel").click(function(){
			$("#notify_me").hide();
			$("#notify_overlay").hide();
		});
	});

	function showNotifierPopup()
	{
		$("#notify_me").show(500);
		$("#notify_overlay").show(500);
	}
</script>

<div id="notify_overlay"></div>

<!-- Begin notify product form-->
<div id="notify_me">
	<div class="form wide">
		<form action="#">
			<div class="row">
				<label>Ваш Email:</label>
				<input type="text">
			</div>
			<div class="row buttons">
				<input type="submit" value="Отправить">
				<a href="#" style="margin-left: 10px;" class="cancel">Отмена</a>
			</div>
		</form>
	</div>
</div>
<!-- End notify product form-->