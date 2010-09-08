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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/online_menu/online_menu.php $
|     $Revision: 11678 $
|     $Id: online_menu.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$caption = (file_exists(THEME."images/online_menu.png") ? "<img src='".THEME_ABS."images/online_menu.png' alt='' /> ".ONLINE_L4 : ONLINE_L4);

if(!defined("e_TRACKING_DISABLED") && (isset($pref['track_online']) && $pref['track_online'])) {
	$text = ONLINE_L1.GUESTS_ONLINE."<br />";
	//if($pref['user_reg'] == 1){
	$text .= ONLINE_L2.MEMBERS_ONLINE.(MEMBERS_ONLINE ? ", ": "").MEMBER_LIST."<br />";
	//}
	$text .= ONLINE_L3.ON_PAGE;

	global $e107cache;
	$members_totals = $e107cache->retrieve("online_menu_totals", 120);
	if($members_totals == false) 
	{
	  $total_members = $sql->db_Count("user","(*)","where user_ban = 0");
	  $newest_member = $sql->db_Select("user", "user_id, user_name", "user_ban='0' ORDER BY user_join DESC LIMIT 0,1");
	  $row = $sql->db_Fetch();
	  extract($row);
	  $members_totals = "<br />".ONLINE_L5.": ".$total_members.", ".ONLINE_L6.": <a href='".e_HTTP."user.php?id.{$user_id}'>{$user_name}</a>";
	  $e107cache->set("online_menu_totals", $members_totals);
	}
	$text .= $members_totals;

} else {
	if(ADMIN) {
		global $tp;  
		$text = $tp->toHtml(TRACKING_MESSAGE,TRUE);
	} else {
		return;
	}
}

$ns->tablerender($caption, $text, 'online');

?>
