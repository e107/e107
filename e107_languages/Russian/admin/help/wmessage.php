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

$text = "Эта страница позволит вам установить сообщение, которое будет появляться наверху вашей главной страницы. Можно установить разные сообщения для гостей, зарегистрированных/вошедших пользователей и администраторов.";
$ns -> tablerender("Приветствие: Справка", $text);
?>