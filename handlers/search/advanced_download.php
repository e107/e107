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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_handlers/search/advanced_download.php $
|     $Revision: 11678 $
|     $Id: advanced_download.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$advanced['cat']['type'] = 'dropdown';
$advanced['cat']['text'] = LAN_SEARCH_63.':';
$advanced['cat']['list'][] = array('id' => 'all', 'title' => LAN_SEARCH_51);

$advanced_caption['id'] = 'cat';
$advanced_caption['title']['all'] = LAN_SEARCH_64;

if ($sql -> db_Select_gen("SELECT download_category_id, download_category_name FROM #download_category WHERE download_category_parent != 0 AND download_category_class IN (".USERCLASS_LIST.")")) {
	while ($row = $sql -> db_Fetch()) {
		$advanced['cat']['list'][] = array('id' => $row['download_category_id'], 'title' => $row['download_category_name']);
		$advanced_caption['title'][$row['download_category_id']] = LAN_SEARCH_65.' -> '.$row['download_category_name'];
	}
}

$advanced['date']['type'] = 'date';
$advanced['date']['text'] = LAN_SEARCH_66.':';

$advanced['author']['type'] = 'author';
$advanced['author']['text'] = LAN_SEARCH_61.':';

$advanced['match']['type'] = 'dropdown';
$advanced['match']['text'] = LAN_SEARCH_52.':';
$advanced['match']['list'][] = array('id' => 0, 'title' => LAN_SEARCH_67);
$advanced['match']['list'][] = array('id' => 1, 'title' => LAN_SEARCH_54);

?>