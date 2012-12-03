<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/forum_conf.php $
|     $Id: forum_conf.php 12100 2011-03-13 14:15:43Z e107steved $
+----------------------------------------------------------------------------+
*/

if(!empty($_POST) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

require_once("../../class2.php");
if (!isset($pref['plug_installed']['forum']))
{
	header('Location: '.e_BASE.'index.php');
	exit;
}
include_lan(e_PLUGIN.'forum/languages/'.e_LANGUAGE.'/lan_forum_conf.php');

$e_sub_cat = 'forum';
	
$qs = explode(".", e_QUERY);
$action = $qs[0];
$thread_id = intval($qs[1]);

$qry = "
SELECT t.*, f.*, fp.forum_id AS forum_parent_id FROM #forum_t as t
LEFT JOIN #forum AS f ON t.thread_forum_id = f.forum_id
LEFT JOIN #forum AS fp ON fp.forum_id = f.forum_parent
WHERE t.thread_id = {$thread_id}
";

if($sql->db_Select_gen($qry))
{
	$info=$sql->db_Fetch();
	if(!check_class($info['forum_moderators']))
	{
		header("location:".e_BASE."index.php");
		exit;
	}
}
else
{
	header("location:".e_BASE."index.php");
	exit;
}

require_once(HEADERF);

if (isset($_POST['deletepollconfirm'])) {
	$sql->db_Delete("poll", "poll_id='".intval($thread_parent)."' ");
	$sql->db_Select("forum_t", "*", "thread_id='".$thread_id."' ");
	$row = $sql->db_Fetch();
	 extract($row);
	$thread_name = str_replace("[poll] ", "", $thread_name);
	$sql->db_Update("forum_t", "thread_name='$thread_name' WHERE thread_id='$thread_id' ");
	$message = FORLAN_5;
	$url = e_PLUGIN."forum/forum_viewtopic.php?".$thread_id;
}
	
if (isset($_POST['move']))
{
	require_once(e_PLUGIN."forum/forum_class.php");
	$forum = new e107forum;
	$new_forum = intval($_POST['forum_move']);
	$replies = $sql->db_Select("forum_t", "*", "thread_parent='$thread_id' ");
	$sql->db_Select("forum_t", "thread_name, thread_user, thread_forum_id", "thread_id ='".$thread_id."' ");
	$row = $sql->db_Fetch();
	$old_forum = $row['thread_forum_id'];
	$new_thread_name = $row['thread_name'];

	if($_POST['rename_thread'] == 'add')
	{
		$new_thread_name = "[".FORLAN_27."] ".$new_thread_name;
	}
	elseif($_POST['rename_thread'] == 'rename' && trim($_POST['newtitle']) != "")
	{
		$new_thread_name = $tp->toDB($_POST['newtitle']);
	}

	$sql->db_Update("forum_t", "thread_forum_id='$new_forum', thread_name='{$new_thread_name}' WHERE thread_id='$thread_id' ");
	$sql->db_Update("forum_t", "thread_forum_id='$new_forum' WHERE thread_parent='$thread_id' ");
	$sql->db_Update("forum", "forum_threads=forum_threads-1, forum_replies=forum_replies-$replies WHERE forum_id='$old_forum' ");
	$sql->db_Update("forum", "forum_threads=forum_threads+1, forum_replies=forum_replies+$replies WHERE forum_id='$new_forum' ");
	 
	// update lastposts

	$forum->update_lastpost('forum', $old_forum, FALSE);
	$forum->update_lastpost('forum', $new_forum, FALSE);
	
	// fire event 'forumthreadmove'
	$tmp = explode(".", $row['thread_user']);
	$sql->db_Select("forum", "forum_name", "forum_id='$old_forum' ");
	$forum_old_row = 	$sql->db_Fetch();
	$sql->db_Select("forum", "forum_name", "forum_id='$new_forum' ");
	$forum_new_row = 	$sql->db_Fetch();
	$edata_fo = array(
		"old_thread_name"	=> $row['thread_name'],
		"new_thread_name"	=> $new_thread_name,
		"old_forum"				=> $forum_old_row['forum_name'],
		"new_forum"				=> $forum_new_row['forum_name'],
		"poster"			=> (intval($tmp[0]) ? $tmp[1] : "Anonymous"),
		"mover"			=> USERNAME);
	$e_event -> trigger("forumthreadmove", $edata_fo);
	 
	$message = FORLAN_9;
	$url = e_PLUGIN."forum/forum_viewforum.php?".$new_forum;
}
	
if (isset($_POST['movecancel']))
{
	$message = FORLAN_10;
	$url = e_PLUGIN."forum/forum_viewforum.php?".$info['forum_id'];
}
	
if ($message)
{
	$text = "<div style='text-align:center'>".$message."
		<br />
		<a href='$url'>".FORLAN_11."</a>
		</div>";
	$ns->tablerender(FORLAN_12, $text);
	require_once(FOOTERF);
	exit;
}
	
if ($action == "delete_poll")
{
	$text = "<div style='text-align:center'>
		".FORLAN_13."
		<br /><br />
		<form method='post' action='".e_SELF."?".e_QUERY."'>
		<input type='hidden' name='e-token' value='".e_TOKEN."' />
		<input class='button' type='submit' name='deletecancel' value='".FORLAN_14."' />
		<input class='button' type='submit' name='deletepollconfirm' value='".FORLAN_15."' />
		</form>
		</div>";
	$ns->tablerender(FORLAN_16, $text);
	require_once(FOOTERF);
	exit;
}
	
if ($action == "move")
{
	$text = "
		<form method='post' action='".e_SELF."?".e_QUERY."'>
		<div style='text-align:center'>
		<table style='".ADMIN_WIDTH."'>
		<tr>
		<td style='text-align:right'>".FORLAN_24.": </td>
		<td style='text-align:left'>
		<select name='forum_move' class='tbox'>";
	$qry = "
	SELECT f.forum_id, f.forum_name, fp.forum_name AS forum_parent, sp.forum_name AS sub_parent
	FROM #forum AS f
	LEFT JOIN #forum AS fp ON f.forum_parent = fp.forum_id
	LEFT JOIN #forum AS sp ON f.forum_sub = sp.forum_id
	WHERE f.forum_parent != 0
	AND f.forum_id != ".intval($info['forum_id'])."	
	AND f.forum_class IN (".USERCLASS_LIST.")
	AND fp.forum_class IN (".USERCLASS_LIST.")
	ORDER BY f.forum_parent ASC, f.forum_sub, f.forum_order ASC
	";
	$sql->db_Select_gen($qry);
	$fList = $sql->db_getList();

	foreach($fList as $f)
	{
		if($f['forum_sub'] > 0)
		{
			$f['forum_name'] = "subforum -> ".$f['forum_name'];
		}
		$for_name = $f['forum_parent']." -> ";
		$for_name .= ($f['sub_parent'] ? $f['sub_parent']." -> " : "");
		$for_name .= $f['forum_name'];

		$text .= "<option value='{$f['forum_id']}'>".$for_name."</option>";
	}
	$text .= "</select>
		</td>
		</tr>
		<tr>
		<td colspan='2'><br />
		<b>".FORLAN_32."</b><br />
		<input type='radio' name='rename_thread' checked='checked' value='none' /> ".FORLAN_28."<br />
		<input type='radio' name='rename_thread' value='add' /> ".FORLAN_29." [".FORLAN_27."] ".FORLAN_30."<br />
		<input type='radio' name='rename_thread' value='rename' /> ".FORLAN_31." <input type='text' class='tbox' name='newtitle' size='60' maxlength='250' value='".$tp->toForm($info['thread_name'])."'/>
		</td>
		</tr>
		<tr style='vertical-align: top;'>
		<td colspan='2'  style='text-align:center'><br />
		<input type='hidden' name='e-token' value='".e_TOKEN."' />
		<input class='button' type='submit' name='move' value='".FORLAN_25."' />
		<input class='button' type='submit' name='movecancel' value='".FORLAN_14."' />
		</td>
		</tr>
		</table>
		</div>
		</form><br />";
	$text = $ns->tablerender($tp->toHTML($info['thread_name']), $tp->toHTML($info['thread_thread']), '', TRUE).$ns->tablerender("", $text, '', true);
	$ns->tablerender(FORLAN_25, $text);
	
}
require_once(FOOTERF);
?>