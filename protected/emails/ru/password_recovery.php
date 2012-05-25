<?php

/**
 * @var  $this RemindPasswordForm
 * Message will be sent in text format.
 */
?>

Здравствуйте, <?php echo $this->user->username ?>!

Вы получили это письмо потому, что вы (либо кто-то, выдающий себя за вас)
попросили выслать новый пароль для вашей учётной записи.
Если вы не просили выслать пароль, то не обращайте внимания на
это письмо, если же подобные письма будут продолжать приходить, обратитесь
к администратору сайта.

Перейдите по ссылке для активации нового пароля
<?php echo Yii::app()->createAbsoluteUrl('/users/remind/activatePassword', array('key'=>$this->user->recovery_key)) ?>


Ваш новый пароль:
<?php echo $this->user->recovery_password ?>


