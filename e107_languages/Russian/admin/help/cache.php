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

$caption = "Кеширование";
$text = "Если вы включите кеширование, это значительно увеличит скорость вашего сайта и минимизирует количество вызовов к базе данных SQL.<br /><br /><b>ВАЖНО! Если вы создаете собственную тему - выключите кеширование, т. к. в противном случае изменения, которые вы сделаете, не будут отражены.</b>";
$ns -> tablerender($caption, $text);
?>