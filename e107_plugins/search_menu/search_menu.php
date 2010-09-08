<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/search_menu/search_menu.php $
|     $Revision: 11678 $
|     $Id: search_menu.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

@include(e_PLUGIN."search_menu/languages/".e_LANGUAGE.".php");
if (strstr(e_PAGE, "news.php")) {
	 $page = 0;
} elseif(strstr(e_PAGE, "comment.php")) {
	 $page = 1;
} elseif(strstr(e_PAGE, "content.php") && strstr(e_QUERY, "content")) {
	 $page = 2;
} elseif(strstr(e_PAGE, "content.php") && strstr(e_QUERY, "review")) {
	 $page = 3;
} elseif(strstr(e_PAGE, "content.php") && strstr(e_QUERY, "content")) {
	 $page = 4;
} elseif(strstr(e_PAGE, "chat.php")) {
	 $page = 5;
} elseif(strstr(e_PAGE, "links.php")) {
	 $page = 6;
} elseif(strstr(e_PAGE, "forum")) {
	 $page = 7;
} elseif(strstr(e_PAGE, "user.php") || strstr(e_PAGE, "usersettings.php")) {
	 $page = 8;
} elseif(strstr(e_PAGE, "download.php")) {
	 $page = 9;
} else {
	 $page = 99;
}

if (isset($custom_query[1]) && $custom_query[1] != '') {
	$image_file = ($custom_query[1] != 'default') ? $custom_query[1] : e_PLUGIN_ABS.'search_menu/images/search.png';
	$width = (isset($custom_query[2]) && $custom_query[2]) ? $custom_query[2] : '16';
	$height = (isset($custom_query[3]) && $custom_query[3]) ? $custom_query[3] : '16';
		$search_button = "<input type='image' src='".$image_file."' value='".LAN_180."' style='width: ".$width."px; height: ".$height."px; border: 0px; vertical-align: middle' name='s' />";
} else {
	$search_button = "<input class='button search' type='submit' name='s' value='".LAN_180."' />";
}

if (isset($custom_query[5]) && $custom_query[5]) {
	$value_text = "value='".$custom_query[5]."' onclick=\"this.value=''\"";
} else {
	$value_text = "value=''";
}

$text = "<form method='get' action='".e_HTTP."search.php'>
	<div>
	<input class='tbox search' type='text' name='q' size='20' ".$value_text." maxlength='50' />
	<input type='hidden' name='r' value='0' />";
	
	if (isset($custom_query[4]) && $custom_query[4] != '') {
		$text .= "<input type='hidden' name='ref' value='".$custom_query[4]."' />";
	}
	
	$text .= $search_button."
	</div>
	</form>";
if (isset($searchflat) && $searchflat) {
	echo $text;
} else {
	$ns->tablerender(LAN_180." ".SITENAME, "<div style='text-align:center'>".$text."</div>", 'search');
}
?>