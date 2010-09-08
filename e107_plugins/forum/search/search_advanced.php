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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/search/search_advanced.php $
|     $Revision: 11678 $
|     $Id: search_advanced.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$advanced['forum']['type'] = 'dropdown';
$advanced['forum']['text'] = FOR_SCH_LAN_2.':';
$advanced['forum']['list'][] = array('id' => 'all', 'title' => FOR_SCH_LAN_3);

$advanced_caption['id'] = 'forum';
$advanced_caption['title']['all'] = FOR_SCH_LAN_3;

if ($sql -> db_Select_gen("SELECT f.forum_id, f.forum_name FROM #forum AS f LEFT JOIN #forum AS fp ON fp.forum_id = f.forum_parent WHERE f.forum_parent != 0 AND fp.forum_class IN (".USERCLASS_LIST.") AND f.forum_class IN (".USERCLASS_LIST.")")) {
	while ($row = $sql -> db_Fetch()) {
		$advanced['forum']['list'][] = array('id' => $row['forum_id'], 'title' => $row['forum_name']);
		$advanced_caption['title'][$row['forum_id']] = FOR_SCH_LAN_1.' -> '.$row['forum_name'];
	}
}

$advanced['date']['type'] = 'date';
$advanced['date']['text'] = LAN_SEARCH_50.':';

$advanced['author']['type'] = 'author';
$advanced['author']['text'] = LAN_SEARCH_61.':';

$advanced['match']['type'] = 'dropdown';
$advanced['match']['text'] = LAN_SEARCH_52.':';
$advanced['match']['list'][] = array('id' => 0, 'title' => FOR_SCH_LAN_4);
$advanced['match']['list'][] = array('id' => 1, 'title' => LAN_SEARCH_54);

?>