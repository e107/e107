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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/userinfo.php $
|     $Revision: 11678 $
|     $Id: userinfo.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
require_once("../class2.php");
if (!getperms("4"))
{
	header("location:".e_BASE."index.php");
	 exit;
}
$e_sub_cat = 'users';
require_once("auth.php");

if ( ! e_QUERY)
{
	$text = "<div style=\"text-align:center\">".USFLAN_1."</div>";
	$ns->tablerender(LAN_ERROR, $text);
	require_once("footer.php");
	exit();
}
else
{
	$ipd = e_QUERY;
}

if (isset($ipd))
{
	$bullet = '';
	if(defined('BULLET'))
	{
		$bullet = '<img src="'.THEME.'images/'.BULLET.'" alt="" style="vertical-align: middle;" />';
	}
	elseif(file_exists(THEME.'images/bullet2.gif'))
	{
		$bullet = '<img src="'.THEME.'images/bullet2.gif" alt="" style="vertical-align: middle;" />';
	}

	$obj = new convert;
	$sql->db_Select("chatbox", "*", "cb_ip='$ipd' LIMIT 0,20");
	$host = $e107->get_host_name($ipd);
	$text = USFLAN_3." <b>".$ipd."</b> [ ".USFLAN_4.": $host ]<br />
		<i><a href=\"banlist.php?".$ipd."\">".USFLAN_5."</a></i>

		<br /><br />";
	while (list($cb_id, $cb_nick, $cb_message, $cb_datestamp, $cb_blocked, $cb_ip ) = $sql->db_Fetch())
	{
		$datestamp = $obj->convert_date($cb_datestamp, "short");
		$post_author_id = substr($cb_nick, 0, strpos($cb_nick, "."));
		$post_author_name = substr($cb_nick, (strpos($cb_nick, ".")+1));
		$text .= $bullet."
			<span class=\"defaulttext\"><i>".$post_author_name." (".USFLAN_6.": ".$post_author_id.")</i></span>
			<div class=\"mediumtext\">
			".$datestamp."
			<br />
			". $cb_message."
			</div>
			<br />";
	}

	$text .= "<hr />";

	$sql->db_Select("comments", "*", "comment_ip='$ipd' LIMIT 0,20");
	while (list($comment_id, $comment_item_id, $comment_author, $comment_author_email, $comment_datestamp, $comment_comment, $comment_blocked, $comment_ip) = $sql->db_Fetch())
	{
		$datestamp = $obj->convert_date($comment_datestamp, "short");
		$post_author_id = substr($comment_author, 0, strpos($comment_author, "."));
		$post_author_name = substr($comment_author, (strpos($comment_author, ".")+1));
		$text .= $bullet."
			<span class=\"defaulttext\"><i>".$post_author_name." (".USFLAN_6.": ".$post_author_id.")</i>
			</span>\n<div class=\"mediumtext\">
			".$datestamp."
			<br />
			". $comment_comment."
			</div>
			<br />";
	}

}

$ns->tablerender(USFLAN_7, $text);

require_once("footer.php");
?>