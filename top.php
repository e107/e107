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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/top.php $
|     $Revision: 12223 $
|     $Id: top.php 12223 2011-05-21 08:01:08Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/
require_once("class2.php");
if (!e_QUERY) {
	$action = "top";
	$subaction = "all";
	$from = 0;
	$view = 10;
} else {
	$tmp = explode(".", e_QUERY);
	$from = intval($tmp[0]);
	$action = $tmp[1];
	$subaction = $tmp[2];
	$view = ($tmp[3] ? intval($tmp[3]) : 10);
}
if ($action == "top") {
	define("e_PAGETITLE", ": ".LAN_8);
} elseif($action == "active") {
	define("e_PAGETITLE", ": ".LAN_7);
}
	
	
require_once(HEADERF);
if ($action == "active") {
	require_once(e_HANDLER."userclass_class.php");
	 
	$query = "
			SELECT 
				t.*, f.forum_name, f.forum_class, u.user_name, fp.forum_class FROM #forum_t AS t
			LEFT JOIN #forum AS f 
				ON t.thread_forum_id = f.forum_id 
			LEFT JOIN #user AS u 
				ON SUBSTRING_INDEX(t.thread_user,'.',1) = u.user_id
			LEFT JOIN #forum AS fp 
				ON fp.forum_id = f.forum_parent
			WHERE  
				t.thread_parent = 0
				AND fp.forum_class IN (".USERCLASS_LIST.")
				AND f.forum_class IN (".USERCLASS_LIST.")
			ORDER BY 
				t.thread_views DESC 
			LIMIT 
				{$from}, {$view}";

	if ($sql->db_Select_gen($query)) {
		$text = "<div style='text-align:center'>\n<table style='width:auto' class='fborder'>\n";
		if (!is_object($gen)) {
			$gen = new convert;
		}
		 
		$text .= "<tr>
			<td style='width:5%' class='forumheader'>&nbsp;</td>
			<td style='width:45%' class='forumheader'>".LAN_1."</td>
			<td style='width:15%; text-align:center' class='forumheader'>".LAN_2."</td>
			<td style='width:5%; text-align:center' class='forumheader'>".LAN_3."</td>
			<td style='width:5%; text-align:center' class='forumheader'>".LAN_4."</td>
			<td style='width:25%; text-align:center' class='forumheader'>".LAN_5."</td>
			</tr>\n";
		 
		while ($row = $sql->db_Fetch()) {
			extract($row);
			if (check_class($forum_class)) 
			{
				if($user_name)
				{
					$POSTER = "<a href='".e_HTTP."user.php?id.{$thread_user}'>{$user_name}</a>";
				} else 
				{
					$POSTER = LAN_ANONYMOUS;
				}

				$LINKTOTHREAD = e_PLUGIN_ABS."forum/forum_viewtopic.php?".$thread_id;
				$LINKTOFORUM = e_PLUGIN_ABS."forum/forum_viewforum.php?".$thread_forum_id;
				$lastpost_datestamp = $gen->convert_date($thread_lastpost, "forum");
				list($lastpost_id, $lastpost_name) = explode('.', $thread_lastuser, 2);
				if (!$lastpost_id) {
					$LASTPOST = $lastpost_name.'<br />'.$lastpost_datestamp;
				} else {
					$LASTPOST = "<a href='".e_HTTP."user.php?id.".$lastpost_id."'>".$lastpost_name."</a><br />".$lastpost_datestamp;
				}

				$text .= "<tr>
					<td style='width:5%; text-align:center' class='forumheader3'><img src='".e_PLUGIN_ABS."forum/images/".IMODE."/new_small.png' alt='' /></td>
					<td style='width:45%' class='forumheader3'><b><a href='{$LINKTOTHREAD}'>{$thread_name}</a></b> <span class='smalltext'>(<a href='{$LINKTOFORUM}'>{$forum_name}</a>)</span></td>
					<td style='width:15%; text-align:center' class='forumheader3'>{$POSTER}</td>
					<td style='width:5%; text-align:center' class='forumheader3'>{$thread_views}</td>
					<td style='width:5%; text-align:center' class='forumheader3'>{$thread_total_replies}</td>
					<td style='width:25%; text-align:center' class='forumheader3'>{$LASTPOST}</td>
					</tr>\n";
			}
		}
		 
		$text .= "</table>\n</div>";
		 
		$ns->tablerender(LAN_7, $text, "nfp");
		require_once(e_HANDLER."np_class.php");
		$ftotal = $sql->db_Count("forum_t", "(*)", "WHERE thread_parent = 0");
		$ix = new nextprev("top.php", $from, $view, $ftotal, "", "active.forum.".$view."");
	}
}
if ($action == "top") {
	require_once(e_HANDLER."level_handler.php");
	define("IMAGE_rank_main_admin_image", ($pref['rank_main_admin_image'] && file_exists(THEME."forum/".$pref['rank_main_admin_image']) ? "<img src='".THEME_ABS."forum/".$pref['rank_main_admin_image']."' alt='' />" : "<img src='".e_PLUGIN_ABS."forum/images/".IMODE."/main_admin.png' alt='' />"));
	define("IMAGE_rank_admin_image", ($pref['rank_admin_image'] && file_exists(THEME."forum/".$pref['rank_admin_image']) ? "<img src='".THEME_ABS."forum/".$pref['rank_admin_image']."' alt='' />" : "<img src='".e_PLUGIN_ABS."forum/images/".IMODE."/admin.png' alt='' />"));
	define("IMAGE_rank_moderator_image", ($pref['rank_moderator_image'] && file_exists(THEME."forum/".$pref['rank_moderator_image']) ? "<img src='".THEME_ABS."forum/".$pref['rank_moderator_image']."' alt='' />" : "<img src='".e_PLUGIN_ABS."forum/images/".IMODE."/moderator.png' alt='' />"));
	 
	if ($subaction == "forum" || $subaction == "all") {
		$top_forum_posters = $sql->db_Select("user", "*", "`user_forums` > 0 ORDER BY user_forums DESC LIMIT ".$from.", ".$view."");
		$text = "
			<div style='text-align:center'>
			<table style='width:95%' class='fborder'>
			<tr>
			<td style='width:10%; text-align:center' class='forumheader3'>&nbsp;</td>
			<td style='width:50%' class='forumheader3'>".TOP_LAN_1."</td>
			<td style='width:10%; text-align:center' class='forumheader3'>".TOP_LAN_2."</td>
			<td style='width:30%; text-align:center' class='forumheader3'>".TOP_LAN_6."</td>
			</tr>\n";
		$counter = 1 + $from;
		while ($row = $sql->db_Fetch()) {
			extract($row);
			$ldata = get_level($user_id, $user_forums, $user_comments, $user_chats, $user_visits, $user_join, $user_admin, $user_perms, $pref);
			$text .= "<tr>
				<td style='width:10%; text-align:center' class='forumheader3'>{$counter}</td>
				<td style='width:50%' class='forumheader3'><a href='".e_HTTP."user.php?id.{$user_id}'>{$user_name}</a></td>
				<td style='width:10%; text-align:center' class='forumheader3'>{$user_forums}</td>
				<td style='width:30%; text-align:center' class='forumheader3'>".(strstr($ldata[0], "LAN") ? $ldata[1] : $ldata[0])."</td>
				</tr>";
			$counter++;
		}
		$text .= "</table>\n</div>";
		$ns->tablerender(TOP_LAN_0, $text);
		if ($subaction == "forum") {
			require_once(e_HANDLER."np_class.php");
			$ftotal = $sql->db_Count("user", "(*)", "WHERE `user_forums` > 0");
			$ix = new nextprev("top.php", $from, $view, $ftotal, "Forum Posts", "top.forum.".$view."");
		}
	}
	 
	 
	if ($subaction == "comment" || $subaction == "all") {
		$top_forum_posters = $sql->db_Select("user", "*", "`user_comments` > 0 ORDER BY user_comments DESC LIMIT 0, 10");
		$text = "
			<div style='text-align:center'>
			<table style='width:95%' class='fborder'>
			<tr>
			<td style='width:10%; text-align:center' class='forumheader3'>&nbsp;</td>
			<td style='width:50%' class='forumheader3'>".TOP_LAN_1."</td>
			<td style='width:10%; text-align:center' class='forumheader3'>".TOP_LAN_4."</td>
			<td style='width:30%; text-align:center' class='forumheader3'>".TOP_LAN_6."</td>
			</tr>\n";
		$counter = 1;
		while ($row = $sql->db_Fetch()) {
			extract($row);
			$ldata = get_level($user_id, $user_forums, $user_comments, $user_chats, $user_visits, $user_join, $user_admin, $user_perms, $pref);
			$text .= "<tr>
				<td style='width:10%; text-align:center' class='forumheader3'>{$counter}</td>
				<td style='width:50%' class='forumheader3'><a href='".e_HTTP."user.php?id.{$user_id}'>{$user_name}</a></td>
				<td style='width:10%; text-align:center' class='forumheader3'>{$user_comments}</td>
				<td style='width:30%; text-align:center' class='forumheader3'>".(strstr($ldata[0], "LAN") ? $ldata[1] : $ldata[0])."</td>
				</tr>";
			$counter++;
		}
		$text .= "</table>\n</div>";
		$ns->tablerender(TOP_LAN_3, $text);
	}
	 
	if ($subaction == "chat" || $subaction == "all") {
		$top_forum_posters = $sql->db_Select("user", "*", "`user_chats` > 0 ORDER BY user_chats DESC LIMIT 0, 10");
		$text = "
			<div style='text-align:center'>
			<table style='width:95%' class='fborder'>
			<tr>
			<td style='width:10%; text-align:center' class='forumheader3'>&nbsp;</td>
			<td style='width:20%' class='forumheader3'>".TOP_LAN_1."</td>
			<td style='width:10%; text-align:center' class='forumheader3'>".TOP_LAN_2."</td>
			<td style='width:30%; text-align:center' class='forumheader3'>".TOP_LAN_6."</td>
			</tr>\n";
		$counter = 1;
		while ($row = $sql->db_Fetch()) {
			extract($row);
			$ldata = get_level($user_id, $user_forums, $user_comments, $user_chats, $user_visits, $user_join, $user_admin, $user_perms, $pref);
			$text .= "<tr>
				<td style='width:10%; text-align:center' class='forumheader3'>{$counter}</td>
				<td style='width:50%' class='forumheader3'><a href='".e_HTTP."user.php?id.{$user_id}'>{$user_name}</a></td>
				<td style='width:10%; text-align:center' class='forumheader3'>{$user_chats}</td>
				<td style='width:30%; text-align:center' class='forumheader3'>".(strstr($ldata[0], "LAN") ? $ldata[1] : $ldata[0])."</td>
				</tr>";
			$counter++;
		}
		$text .= "</table>\n</div>";
		$ns->tablerender(TOP_LAN_5, $text);
	}
}
require_once(FOOTERF);
?>