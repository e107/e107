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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/forum_stats.php $
|     $Revision: 12100 $
|     $Id: forum_stats.php 12100 2011-03-13 14:15:43Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

require_once('../../class2.php');
if (!isset($pref['plug_installed']['forum']))
{
	header('Location: '.e_BASE.'index.php');
	exit;
}

include_lan(e_PLUGIN.'forum/languages/'.e_LANGUAGE.'/lan_forum_stats.php');
@require_once(e_PLUGIN.'forum/forum_class.php');
$gen = new convert;

$barl = (file_exists(THEME."images/barl.png") ? THEME."images/barl.png" : e_PLUGIN."poll/images/barl.png");
$barr = (file_exists(THEME."images/barr.png") ? THEME."images/barr.png" : e_PLUGIN."poll/images/barr.png");
$bar  = (file_exists(THEME."images/bar.png") ? THEME."images/bar.png" : e_PLUGIN."poll/images/bar.png");

require_once(HEADERF);

$total_posts = $sql -> db_Count("forum_t");
$total_topics = $sql -> db_Count("forum_t", "(*)", "WHERE thread_parent=0");
$total_replies = $sql -> db_Count("forum_t", "(*)", "WHERE thread_parent!=0");
$total_views = 0;
$query = "SELECT sum(thread_views) AS total FROM #forum_t ";		// Try this way - original way didn't work for some users
if ($sql -> db_Select_gen($query))
//if($sql->db_Select("forum_t", "sum(thread_views) AS total", '', 'nowhere'))
{
  $row = $sql->db_Fetch();
  $total_views = $row['total'];
}

$firstpost = $sql -> db_Select("forum_t", "thread_datestamp", "thread_datestamp > 0 ORDER BY thread_datestamp ASC LIMIT 0,1");
$fp = $sql -> db_Fetch();

$open_ds = $fp['thread_datestamp'];
$open_date = $gen->convert_date($open_ds, "long");
$open_since = $gen -> computeLapse($open_ds);
$open_days = floor((time()-$open_ds) / 86400);
$postsperday = ($open_days < 1 ? $total_posts : round($total_posts / $open_days));


//$query = "SHOW TABLE STATUS FROM {$mySQLdefaultdb}";		// Original line - doesn't like DB names with a '-' - enclose in backticks
//$query = "SHOW TABLE STATUS FROM `{$sql->mySQLdefaultdb}` LIKE '".MPREFIX."forum_t"."' ";	// This selects the one table we want (but didn't always work)
$query = "SHOW TABLE STATUS FROM `{$mySQLdefaultdb}`";		// Original line with backticks added
$sql -> db_Select_gen($query);
$array = $sql -> db_getList();
//$table = $sql -> db_Fetch();
//echo $query."<br />Elements: ".count($array)."<br />";
foreach($array as $table)
{
	if($table['Name'] == MPREFIX."forum_t")
	{
		$db_size = parsesize($table['Data_length']);
		$avg_row_len = parsesize($table['Avg_row_length']);
		break;
	}
}


$query = "
SELECT ft.thread_id, ft.thread_user, ft.thread_name, ft.thread_total_replies, ft.thread_datestamp, f.forum_class, u.user_name, u.user_id FROM #forum_t as ft
LEFT JOIN #user AS u ON SUBSTRING_INDEX(ft.thread_user,'.',1) = u.user_id
LEFT JOIN #forum AS f ON f.forum_id = ft.thread_forum_id
WHERE ft.thread_parent = 0
AND ft.thread_active != 0
AND f.forum_class IN (".USERCLASS_LIST.")
ORDER BY thread_total_replies DESC LIMIT 0,10";
$sql -> db_Select_gen($query);
$most_activeArray = $sql -> db_getList();

$query = "
SELECT ft.*, f.forum_class, u.user_name, u.user_id FROM #forum_t as ft
LEFT JOIN #user AS u ON SUBSTRING_INDEX(ft.thread_user,'.',1) = u.user_id
LEFT JOIN #forum AS f ON f.forum_id = ft.thread_forum_id
WHERE ft.thread_parent=0
AND f.forum_class IN (".USERCLASS_LIST.")
ORDER BY thread_views DESC LIMIT 0,10";

$sql -> db_Select_gen($query);
$most_viewedArray = $sql -> db_getList();

$sql->db_Select("user", "user_id, user_name, user_forums", "ORDER BY user_forums DESC LIMIT 0, 10", "no_where");
$posters = $sql -> db_getList();
$top_posters = array();
foreach($posters as $poster)
{
	$percen = round(($poster['user_forums'] / $total_posts) * 100, 2);
	$top_posters[] = array("user_id" => $poster['user_id'], "user_name" => $poster['user_name'], "user_forums" => $poster['user_forums'], "percentage" => $percen);
}

$query = "
SELECT SUBSTRING_INDEX(thread_user,'.',1) AS t_user, COUNT(SUBSTRING_INDEX(ft.thread_user,'.',1)) AS ucount, u.user_name, u.user_id FROM #forum_t as ft
LEFT JOIN #user AS u ON SUBSTRING_INDEX(ft.thread_user,'.',1) = u.user_id
WHERE ft.thread_parent=0
GROUP BY t_user
ORDER BY ucount DESC
LIMIT 0,10";
$sql -> db_Select_gen($query);
$posters = $sql -> db_getList();
$top_topic_starters = array();
foreach($posters as $poster)
{
	$percen = round(($poster['ucount'] / $total_topics) * 100, 2);
	$top_topic_starters[] = array("user_id" => $poster['user_id'], "user_name" => $poster['user_name'], "user_forums" => $poster['ucount'], "percentage" => $percen);
}

$query = "
SELECT SUBSTRING_INDEX(thread_user,'.',1) AS t_user, COUNT(SUBSTRING_INDEX(ft.thread_user,'.',1)) AS ucount, u.user_name, u.user_id FROM #forum_t as ft
LEFT JOIN #user AS u ON SUBSTRING_INDEX(ft.thread_user,'.',1) = u.user_id
WHERE ft.thread_parent!=0
GROUP BY t_user
ORDER BY ucount DESC
LIMIT 0,10";
$sql -> db_Select_gen($query);
$posters = $sql -> db_getList();

$top_repliers = array();
foreach($posters as $poster)
{
	$percen = round(($poster['ucount'] / $total_replies) * 100, 2);
	$top_repliers[] = array("user_id" => $poster['user_id'], "user_name" => $poster['user_name'], "user_forums" => $poster['ucount'], "percentage" => $percen);
}



$text = "
<div class='spacer'>
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader'>".FSLAN_1."</td>
</tr>

<tr>
<td class='forumheader3'>
	<table style='width: 100%;'>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_2.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$open_date}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_3.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$open_since}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_4.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$total_posts}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_5.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$total_topics}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_6.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$total_replies}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_7.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$total_views}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_24.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$postsperday}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_8.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$db_size}</td></tr>
	<tr><td style='width: 50%; text-align: right;'><b>".FSLAN_9.":</b>&nbsp;&nbsp;</td><td style='width: 50%;'>{$avg_row_len}</td></tr>

	</table>
</td>
</tr>
</table>
</div>

<div class='spacer'>
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader' colspan='5'>".FSLAN_10."</td>
</tr>
<tr>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_11."</td>
<td style='width: 40%;' class='fcaption'>".FSLAN_12."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_13."</td>
<td style='width: 20%; text-align: center;' class='fcaption'>".FSLAN_14."</td>
<td style='width: 20%; text-align: center;' class='fcaption'>".FSLAN_15."</td>
</tr>
";

$count=1;
foreach($most_activeArray as $ma)
{
	if($ma['user_name'])
	{
		$uinfo = "<a href='".e_BASE."user.php?id.{$ma['user_id']}'>{$ma['user_name']}</a>";
	}
	else
	{
		$tmp = explode(chr(1), $ma['thread_anon']);
		$uinfo = $tp->toHTML($tmp[0]);
	}

	$text .= "<tr>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$count</td>
	<td style='width: 40%;' class='forumheader3'><a href='".e_PLUGIN."forum/forum_viewtopic.php?{$ma['thread_id']}'>{$ma['thread_name']}</a></td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>{$ma['thread_total_replies']}</td>
	<td style='width: 20%; text-align: center;' class='forumheader3'>{$uinfo}</td>
	<td style='width: 20%; text-align: center;' class='forumheader3'>".$gen->convert_date($ma['thread_datestamp'], "forum")."</td>
	</tr>
	";
	$count++;
}
$text .= "</table>
</div>

<div class='spacer'>
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader' colspan='5'>".FSLAN_16."</td>
</tr>
<tr>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_11."</td>
<td style='width: 40%;' class='fcaption'>".FSLAN_12."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_17."</td>
<td style='width: 20%; text-align: center;' class='fcaption'>".FSLAN_14."</td>
<td style='width: 20%; text-align: center;' class='fcaption'>".FSLAN_15."</td>
</tr>
";

$count=1;
foreach($most_viewedArray as $ma)
{
	if($ma['user_name'])
	{
		$uinfo = "<a href='".e_BASE."user.php?id.{$ma['user_id']}'>{$ma['user_name']}</a>";
	}
	else
	{
		$tmp = explode(chr(1), $ma['thread_anon']);
		$uinfo = $tp->toHTML($tmp[0]);
	}

	$text .= "<tr>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$count</td>
	<td style='width: 40%;' class='forumheader3'><a href='".e_PLUGIN."forum/forum_viewtopic.php?{$ma['thread_id']}'>{$ma['thread_name']}</a></td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>{$ma['thread_views']}</td>
	<td style='width: 20%; text-align: center;' class='forumheader3'>{$uinfo}</td>
	<td style='width: 20%; text-align: center;' class='forumheader3'>".$gen->convert_date($ma['thread_datestamp'], "forum")."</td>
	</tr>
	";
	$count++;
}
$text .= "</table>
</div>

<div class='spacer'>
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader' colspan='5'>".FSLAN_18."</td>
</tr>
<tr>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_11."</td>
<td style='width: 20%;' class='fcaption'>".FSLAN_19."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_20."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>%</td>
<td style='width: 50%; text-align: center;' class='fcaption'>&nbsp;</td>
</tr>
";

$count=1;
foreach($top_posters as $ma)
{
	extract($ma);
	$text .= "<tr>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$count</td>
	<td style='width: 20%;' class='forumheader3'><a href='".e_BASE."user.php?id.$user_id'>$user_name</a></td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$user_forums</td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$percentage%</td>
	<td style='width: 50%;' class='forumheader3'>

	<div style='background-image: url($barl); width: 5px; height: 14px; float: left;'></div>
	<div style='background-image: url($bar); width: ".intval($percentage)."%; height: 14px; float: left;'></div>
	<div style='background-image: url($barr); width: 5px; height: 14px; float: left;'></div>

	</td>
	</tr>
	";
	$count++;
}
$text .= "
</table>
</div>

<div class='spacer'>
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader' colspan='5'>".FSLAN_21."</td>
</tr>
<tr>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_11."</td>
<td style='width: 20%;' class='fcaption'>".FSLAN_19."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_20."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>%</td>
<td style='width: 50%; text-align: center;' class='fcaption'>&nbsp;</td>
</tr>
";

$count=1;
foreach($top_topic_starters as $ma)
{
	extract($ma);
	$text .= "<tr>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$count</td>
	<td style='width: 20%;' class='forumheader3'><a href='".e_BASE."user.php?id.$user_id'>$user_name</a></td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$user_forums</td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$percentage%</td>
	<td style='width: 50%; text-align: center;' class='forumheader3'>

	<div style='background-image: url($barl); width: 5px; height: 14px; float: left;'></div>
	<div style='background-image: url($bar); width: ".intval($percentage)."%; height: 14px; float: left;'></div>
	<div style='background-image: url($barr); width: 5px; height: 14px; float: left;'></div>

	</td>
	</tr>
	";
	$count++;
}
$text .= "</table>
</div>


<div class='spacer'>
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader' colspan='5'>".FSLAN_22."</td>
</tr>
<tr>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_11."</td>
<td style='width: 20%;' class='fcaption'>".FSLAN_19."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>".FSLAN_20."</td>
<td style='width: 10%; text-align: center;' class='fcaption'>%</td>
<td style='width: 50%; text-align: center;' class='fcaption'>&nbsp;</td>
</tr>
";

$count=1;
foreach($top_repliers as $ma)
{
	extract($ma);
	$text .= "<tr>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$count</td>
	<td style='width: 20%;' class='forumheader3'><a href='".e_BASE."user.php?id.$user_id'>$user_name</a></td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$user_forums</td>
	<td style='width: 10%; text-align: center;' class='forumheader3'>$percentage%</td>
	<td style='width: 50%; text-align: center;' class='forumheader3'>

	<div style='background-image: url($barl); width: 5px; height: 14px; float: left;'></div>
	<div style='background-image: url($bar); width: ".intval($percentage)."%; height: 14px; float: left;'></div>
	<div style='background-image: url($barr); width: 5px; height: 14px; float: left;'></div>

	</td>
	</tr>
	";
	$count++;
}
$text .= "</table>
</div>
";


$ns -> tablerender(FSLAN_23, $text);


require_once(FOOTERF);

function parsesize($size) {
	$kb = 1024;
	$mb = 1024 * $kb;
	$gb = 1024 * $mb;
	$tb = 1024 * $gb;
	if(!$size)
	{
		return '0';
	}
	if ($size < $kb) {
		return $size." b";
	}
	else if($size < $mb) {
		return round($size/$kb, 2)." kb";
	}
	else if($size < $gb) {
		return round($size/$mb, 2)." mb";
	}
	else if($size < $tb) {
		return round($size/$gb, 2)." gb";
	} else {
		return round($size/$tb, 2)." tb";
	}
}


?>