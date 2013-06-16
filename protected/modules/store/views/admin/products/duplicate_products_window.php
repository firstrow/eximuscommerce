
<form action="">
	<ul>
		<li><label><input type="checkbox" name="copy[]" value="images"/> <?php echo Yii::t('StoreModule.admin', 'Изображения') ?></label></li>
		<li><label><input type="checkbox" name="copy[]" value="attributes"/> <?php echo Yii::t('StoreModule.admin', 'Характеристики') ?></label></li>
		<li><label><input type="checkbox" name="copy[]" value="variants" /> <?php echo Yii::t('StoreModule.admin', 'Варианты') ?></label></li>
		<li><label><input type="checkbox" name="copy[]" value="related_products"/> <?php echo Yii::t('StoreModule.admin', 'Сопутствующие продукты') ?></label></li>
	</ul>

	<div style="padding: 5px 0px 0px 0px;">
		<a href="#" style="color: #309bbf" onclick="return checkAllDuplicateAttributes();">Отметить все</a>
	</div>
</form>