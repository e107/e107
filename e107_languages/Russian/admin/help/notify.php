<?php
/*
+ ----------------------------------------------------------------------------+
|     Russian Language Pack for e107 0.7
|     $Revision: 183 $
|     $Date: 2008-08-30 21:41:13 +0600 (Сб, 30 авг 2008) $
|     $Author: yarodin $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "<b>Рассылка посылает email-уведомления о происходящих е107-событиях.<br /><br />
Поставьте, например, 'IP запрещен за флуд сайта' для класса 'Администратор' и все администраторы будут получать сообщения о том, что 
сайт подвергался флуду.<br /><br />



Если вы хотите, чтобы уведомления были отправлены по альтернативному адресу электронной почты - выберите опцию 'Email' и введите email-адрес в поле.";

$ns -> tablerender("Уведомления: Справка", $text);
?>