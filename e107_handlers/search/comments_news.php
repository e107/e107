<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvs_backup/e107_0.7/e107_handlers/search/comments_news.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$comments_title = LAN_SEARCH_98;
$comments_type_id = 0;
$comments_return['news'] = "n.news_title";
$comments_table['news'] = "LEFT JOIN #news AS n ON c.comment_type=0 AND n.news_id = c.comment_item_id";
function com_search_0($row) {
	global $con;
	$datestamp = $con -> convert_date($row['comment_datestamp'], "long");
	$res['link'] = "comment.php?comment.news.".$row['comment_item_id'];
	$res['pre_title'] = $row['news_title'] ? LAN_SEARCH_71.": " : "";
	$res['title'] = $row['news_title'] ? $row['news_title'] : LAN_SEARCH_9;
	$res['summary'] = $row['comment_comment'];
	preg_match("/([0-9]+)\.(.*)/", $row['comment_author'], $user);
	$res['detail'] = LAN_SEARCH_7."<a href='user.php?id.".$user[1]."'>".$user[2]."</a>".LAN_SEARCH_8.$datestamp;
	return $res;
}

?>