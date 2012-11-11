<html>
<body>

  <p>Здравствуйте, <?=$order->user_name?>.</p>
  <p>Ваш заказ номер <?=$order->id?> принят.</p>

  <p>
    Детали заказа вы можете просмотреть на странице:<br>
    <?= $this->createUrl('view', array('secret_key'=>$order->secret_key)) ?>
  </p>

  <p>
    <ul>
    <?php foreach ($order->products as $product)
        echo '<li>'.$product->getRenderFullName()."</li>";
    ?>
    </ul>
    
    <p>
      <b>Всего к оплате:</b>
      <?=StoreProduct::formatPrice($order->total_price + $order->delivery_price)?> <?=Yii::app()->currency->main->symbol?>
    </p>

    <p>
      <b>Контактные данные:</b><br/>
      <?= implode('<br/>', array($order->user_name, $order->user_phone)) ?> 
    </p>

  </p>
</body>
</html>