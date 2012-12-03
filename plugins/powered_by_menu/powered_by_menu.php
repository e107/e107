<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/powered_by_menu/powered_by_menu.php $
|     $Revision: 11678 $
|     $Id: powered_by_menu.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

$text = "
<div style='text-align: center'>
<div class='spacer'>
<a href='http://www.e107club.ru' rel='external'><img src='".e_IMAGE_ABS."e107club.png' alt='e107 Club' style='border: 0px; width: 88px; height: 31px' /></a>
</div>
<div class='spacer'>
<a href='http://e107.org' rel='external'><img src='".e_IMAGE_ABS."button.png' alt='e107' style='border: 0px; width: 88px; height: 31px' /></a>
</div>
<div class='spacer'>
<a href='http://php.net' rel='external'><img src='".e_IMAGE_ABS."generic/php-small-trans-light.gif' alt='PHP' style='border: 0px; width: 88px; height: 31px' /></a>
</div>
<div class='spacer'>
<a href='http://mysql.com' rel='external'><img src='".e_IMAGE_ABS."generic/poweredbymysql-88.png' alt='MySQL' style='border: 0px; width: 88px; height: 31px' /></a>
</div>
</div>";
$ns -> tablerender(POWEREDBY_L1,  $text, 'powered_by');
?>