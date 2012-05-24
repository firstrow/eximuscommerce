<?php

/**
 * Wish list view
 *
 * @var WishlistController $this
 */

$this->pageTitle = Yii::t('StoreModule.core', 'Список желаний');
?>

<h1 class="has_background"><?php echo Yii::t('StoreModule.core', 'Список желаний') ?>
	<div class="send_wishlist">
		<a href="mailto:?body=<?php echo $this->model->getPublicLink() ?>&subject=<?php echo Yii::t('StoreModule.core', 'Мой список желаний') ?>"><?php echo Yii::t('StoreModule.core', 'Отправить') ?></a>
	</div>
</h1>

<?php if(!empty($this->model->products)): ?>
	<div class="products_list wish_list">
		<?php
		foreach($this->model->products as $p)
		{
			$this->renderPartial('_product', array(
				'data'=>$p,
			));
		}
		?>
	</div>
<?php else: ?>
	<?php echo Yii::t('StoreModule.core', 'Список желаний пустой.'); ?>
<?php endif ?>