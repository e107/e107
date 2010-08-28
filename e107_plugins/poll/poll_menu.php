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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/poll/poll_menu.php,v $
|     $Revision: 11606 $
|     $Date: 2010-07-19 04:22:39 -0500 (Mon, 19 Jul 2010) $
|     $Author: nlstart $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

global $e107;

if(defined("POLLRENDERED"))
{
//	return;
}
if(!defined("POLLCLASS"))
{
	require(e_PLUGIN."poll/poll_class.php");
}
if(!isset($poll) || !is_object($poll))
{
	$poll = new poll;
}

if(!defined("POLL_1"))
{
	/* if menu is being called from comments, lan files have to be included manually ... */
	include_lan(e_PLUGIN."poll/languages/".e_LANGUAGE.".php");
}

if (empty($poll_to_show))
{
  $poll_to_show = ' AND p.`poll_vote_userclass`!=255';
  $pollType = 'menu';
  $pollMode = 'query';
}
else
{
  $poll_to_show = ' AND p.`poll_id`='.$poll_to_show;
  $pollType = 'menu';
  $pollMode = 'results';
}

$query = "SELECT p.*, u.user_name FROM #polls AS p 
LEFT JOIN #user AS u ON p.poll_admin_id = u.user_id
WHERE  p.poll_type=1{$poll_to_show}
ORDER BY p.poll_datestamp DESC LIMIT 0,1
";

$poll->remove_poll_cookies();

$poll->render_poll($query, $pollType, $pollMode);
?>