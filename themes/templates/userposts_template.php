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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/templates/userposts_template.php $
|     $Revision: 11678 $
|     $Id: userposts_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }
if (!defined("USER_WIDTH")){ define("USER_WIDTH","width:95%"); }

if(!isset($USERPOSTS_NP_TABLE))
{
  $USERPOSTS_NP_TABLE = "<div class='nextprev'>{USERPOSTS_NEXTPREV}</div>";
}

// ##### USERPOSTS_COMMENTS TABLE -----------------------------------------------------------------
if(!isset($USERPOSTS_COMMENTS_TABLE_START))
{
	$USERPOSTS_COMMENTS_TABLE_START = "
	<div style='text-align:center'>
	<table class='fborder' style='".USER_WIDTH."'>\n";
}
if(!isset($USERPOSTS_COMMENTS_TABLE))
{
	$USERPOSTS_COMMENTS_TABLE = "
	<tr>
	<td class='fcaption'>
	{USERPOSTS_COMMENTS_HREF_PRE}<b>{USERPOSTS_COMMENTS_HEADING}</b></a>
	<span class='smalltext'>{USERPOSTS_COMMENTS_DATESTAMP} ({USERPOSTS_COMMENTS_TYPE})</span>
	</td>
	</tr>
	<tr>
	<td class='forumheader3'>
	{USERPOSTS_COMMENTS_COMMENT}&nbsp;
	</td>
	</tr>
	";
}
if(!isset($USERPOSTS_COMMENTS_TABLE_END))
{
	 $USERPOSTS_COMMENTS_TABLE_END = "
	</table>
	</div>";
}
// ##### ------------------------------------------------------------------------------------------

// ##### USERPOSTS FORUM TABLE --------------------------------------------------------------------
if(!isset($USERPOSTS_FORUM_TABLE_START))
{
	$USERPOSTS_FORUM_TABLE_START = "
	<div style='text-align:center'>
	<form method='post' action='".e_SELF."?".e_QUERY."'>
	<table class='fborder' style='".USER_WIDTH."'>";
}
if(!isset($USERPOSTS_FORUM_TABLE))
{
	$USERPOSTS_FORUM_TABLE .= "
	<tr>
	<td class='fcaption'>
	{USERPOSTS_FORUM_TOPIC_HREF_PRE}<b>{USERPOSTS_FORUM_TOPIC_PRE} {USERPOSTS_FORUM_TOPIC}</b></a>
	<span class='smalltext'>({USERPOSTS_FORUM_NAME_HREF_PRE}<b>{USERPOSTS_FORUM_NAME}</b></a>)</span>
	<span class='smalltext'>{USERPOSTS_FORUM_DATESTAMP}</span>
	</td>
	</tr>
	<tr>
	<td class='forumheader3'>
	{USERPOSTS_FORUM_THREAD}
	</td>
	</tr>
	";
}
if(!isset($USERPOSTS_FORUM_TABLE_END))
{
	$USERPOSTS_FORUM_TABLE_END = "
	<tr>
	<td class='forumheader' style='text-align:right'>
	{USERPOSTS_FORUM_SEARCH}
	</td>
	</tr>
	</table>
	</form>
	</div>";
}
// ##### ------------------------------------------------------------------------------------------


?>