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

$text = "DВы можете разделить новости между различными категориями и позволить посетителям смотреть новости только выбранных категорий. <br /><br />Значки для новостей можно загрузить на сервер как в</br>".e_THEME."-yourtheme-/images/ или в themes/shared/newsicons/.";
$ns -> tablerender("Категории новостей: Справка", $text);
?>