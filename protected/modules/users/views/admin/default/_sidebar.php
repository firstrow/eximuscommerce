<?php

$orders_msg = Yii::t('UsersModule.admin', 'Заказов: {count} на сумму {sum} {sym}', array(
	'{count}' => sizeof($model->orders),
	'{sum}'   => StoreProduct::formatPrice($model->ordersTotalPrice),
	'{sym}'   => Yii::app()->currency->main->symbol
));

$comments_msg = Yii::t('UsersModule.admin', 'Комментариев: {count}', array(
	'{count}' => $model->commentsCount,
));

?>


<h3><?=Yii::t('UsersModule.admin', 'Дополнительно')?></h3>

<a href="/admin/orders/orders/?Order[user_id]=<?=$model->id?>"><?=$orders_msg?></a><br>
<a href="/admin/comments/index/?Comment[user_id]=<?=$model->id?>"><?=$comments_msg?></a>
