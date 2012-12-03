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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/search/search_parser.php $
|     $Revision: 11678 $
|     $Id: search_parser.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// advanced
$advanced_where = "";
if (isset($_GET['forum']) && is_numeric($_GET['forum'])) {
	$advanced_where .= " f.forum_id='".$_GET['forum']."' AND";
}

if (isset($_GET['time']) && is_numeric($_GET['time'])) {
	$advanced_where .= " t.thread_datestamp ".($_GET['on'] == 'new' ? '>=' : '<=')." '".(time() - $_GET['time'])."' AND";
}

if (isset($_GET['author']) && $_GET['author'] != '') {
	$advanced_where .= " (u.user_id = '".$tp -> toDB($_GET['author'])."' OR u.user_name = '".$tp -> toDB($_GET['author'])."') AND";
}

if (isset($_GET['match']) && $_GET['match']) {
	$search_fields = array('t.thread_name');
} else {
	$search_fields = array('t.thread_name', 't.thread_thread');
}

// basic
$return_fields = 'tp.thread_name AS parent_name, t.thread_id, t.thread_name, t.thread_thread, t.thread_forum_id, t.thread_parent, t.thread_datestamp, t.thread_user, u.user_id, u.user_name, f.forum_class, f.forum_id, f.forum_name';
$weights = array('1.2', '0.6');
$no_results = LAN_198;

$where = "f.forum_class REGEXP '".e_CLASS_REGEXP."' AND fp.forum_class REGEXP '".e_CLASS_REGEXP."' AND".$advanced_where;
$order = array('thread_datestamp' => DESC);
$table = "forum_t AS t LEFT JOIN #user AS u ON SUBSTRING_INDEX(t.thread_user,'.',1) = u.user_id
		LEFT JOIN #forum AS f ON t.thread_forum_id = f.forum_id
		LEFT JOIN #forum AS fp ON f.forum_parent = fp.forum_id
		LEFT JOIN #forum_t AS tp ON t.thread_parent = tp.thread_id";

$ps = $sch -> parsesearch($table, $return_fields, $search_fields, $weights, 'search_forum', $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_forum($row) {
	global $con;
	$datestamp = $con -> convert_date($row['thread_datestamp'], "long");
	if ($row['thread_parent']) {
		$title = $row['parent_name'];
	} else {
		$title = $row['thread_name'];
	}

	$link_id = $row['thread_id'];

	$res['link'] = e_PLUGIN."forum/forum_viewtopic.php?".$link_id.".post";
	$res['pre_title'] = $title ? FOR_SCH_LAN_5.": " : "";
	$res['title'] = $title ? $title : LAN_SEARCH_9;
	$res['pre_summary'] = "<div class='smalltext' style='padding: 2px 0px'><a href='".e_PLUGIN."forum/forum.php'>".FOR_SCH_LAN_1."</a> -> <a href='".e_PLUGIN."forum/forum_viewforum.php?".$row['forum_id']."'>".$row['forum_name']."</a></div>";
	$res['summary'] = $row['thread_thread'];
	$res['detail'] = LAN_SEARCH_7."<a href='user.php?id.".$row['user_id']."'>".$row['user_name']."</a>".LAN_SEARCH_8.$datestamp;
	return $res;
}

?>