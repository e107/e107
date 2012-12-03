<?php
/*
+ ------------------------------------------------------------------------------+
|	Русский языковой пакет для e107 0.7.26										|
|	Сайт: http://www.e107club.ru												|
|	Почта: translate@e107club.ru												|
|	Ревизия: 1.0																|
|	Кодировка: utf-8															|
|	Дата: 25.09.2011 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
|	© е107 Клуб 2010-2011. Все права защищены.									|
|																				|
|	Russian Language Pack for e107 0.7.26										|
|	Site: http://www.e107club.ru												|
|	Email: translate@e107club.ru												|
|	Revision: 1.0																|
|	Charset: utf-8																|
|	Date: 25.09.2011 05:05:05													|
|	Author: © Alexander Kadnikov [Predator]										|
|	© е107 Club 2010-2011. All Rights Reserved.									|
+-------------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$text = "<b>Рассылка посылает email-уведомления о происходящих событиях.<br /><br />
Поставьте, например, 'IP запрещен за флуд сайта' для класса 'Администратор' и все Администраторы будут получать сообщения о том, что 
сайт подвергался флуду с определённого IP.<br /><br />
Если вы хотите, чтобы уведомления были отправлены по альтернативному адресу электронной почты - выберите опцию 'Email' и введите email-адрес в поле.";

$ns -> tablerender("Уведомления: Справка", $text);
?>