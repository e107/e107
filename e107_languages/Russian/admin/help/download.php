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

$text = "Пожалуйста, загружайте на сервер файлы в папку загрузок ".e_FILE.", ваши изображения в папку ".e_FILE."downloadimages и эскизы в ".e_FILE."downloadthumbs.
</br></br>
Чтобы предложить загрузку, нужно вначале создать родителя, затем создать категорию внутри родителя, затем вы сможете сделать доступной загрузку.";
$ns -> tablerender("Загрузки: Справка", $text);
?>