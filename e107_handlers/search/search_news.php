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
|     $Source: /cvs_backup/e107_0.7/e107_handlers/search/search_news.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// advanced 
$advanced_where = "";
if (isset($_GET['cat']) && $_GET['cat'] != 'all') {
	$advanced_where .= " c.category_id='".intval($_GET['cat'])."' AND";
}

if (isset($_GET['time']) && is_numeric($_GET['time'])) {
	$advanced_where .= " n.news_datestamp ".($_GET['on'] == 'new' ? '>=' : '<=')." '".(time() - $_GET['time'])."' AND";
}

if (isset($_GET['match']) && $_GET['match']) {
	$search_fields = array('news_title');
} else {
	$search_fields = array('news_title', 'news_body', 'news_extended');
}

// basic
$return_fields = 'n.news_id, n.news_title, n.news_body, n.news_extended, n.news_allow_comments, n.news_datestamp, n.news_category, c.category_name';
$weights = array('1.2', '0.6', '0.6');
$no_results = LAN_198;
$time = time();

$where = "(news_start < ".$time.") AND (news_end=0 OR news_end > ".$time.") AND news_class IN (".USERCLASS_LIST.") AND".$advanced_where;
$order = array('news_datestamp' => DESC);
$table = "news AS n LEFT JOIN #news_category AS c ON n.news_category = c.category_id";

$ps = $sch -> parsesearch($table, $return_fields, $search_fields, $weights, 'search_news', $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_news($row) {
	global $con;
	$res['link'] = $row['news_allow_comments'] ? "news.php?item.".$row['news_id'] : "comment.php?comment.news.".$row['news_id'];
	$res['pre_title'] = $row['category_name']." | ";
	$res['title'] = $row['news_title'];
	$res['summary'] = $row['news_body'].' '.$row['news_extended'];
	$res['detail'] = LAN_SEARCH_3.$con -> convert_date($row['news_datestamp'], "long");
	return $res;
}

?>