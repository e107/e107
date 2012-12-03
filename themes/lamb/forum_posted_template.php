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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/lamb/forum_posted_template.php $
|     $Revision: 11678 $
|     $Id: forum_posted_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$FORUMPOLLPOSTED =
"<table style='width:100%' class='fborder'>
<tr>
<td class='nforumcaption2' colspan='2'>".LAN_133."</td>
</tr><tr>
<td style='text-align:right; vertical-align:middle; width:20%' class='forumheader2'>".IMAGE_e."&nbsp;</td>
<td style='vertical-align:middle; width:80%' class='forumheader2'>
<br />".LAN_413."<br />
<span class='defaulttext'><a href='".e_PLUGIN."forum/forum_viewtopic.php?".$thread_id."'>".LAN_414."</a><br />
<a href='".e_PLUGIN."forum/forum_viewforum.php?".$forum_id."'>".LAN_326."</a></span><br /><br />
</td></tr></table>";

$FORUMTHREADPOSTED = "
<table style='width:100%' class='fborder'>
<tr>
<td class='nforumcaption2' colspan='2'>".LAN_133."</td>
</tr><tr>
<td style='text-align:right; vertical-align:middle; width:20%' class='forumheader2'>".IMAGE_e."&nbsp;</td>
<td style='vertical-align:middle; width:80%' class='forumheader2'>
<br />".LAN_324."<br />
".(defined("F_MESSAGE") ? F_MESSAGE."<br />" : "")."
<span class='defaulttext'><a href='".e_PLUGIN."forum/forum_viewtopic.php?{$iid}.last'>".LAN_325."</a><br />
<a href='".e_PLUGIN."forum/forum_viewforum.php?".$forum_id."'>".LAN_326."</a></span><br /><br />
</td></tr></table>";


$FORUMREPLYPOSTED = "
<table style='width:100%' class='fborder'>
<tr>
<td class='nforumcaption2' colspan='2'>".LAN_133."</td>
</tr><tr>
<td style='text-align:right; vertical-align:middle; width:20%' class='forumheader2'>".IMAGE_e."&nbsp;</td>
<td style='vertical-align:middle; width:80%' class='forumheader2'>
<br />".LAN_415."<br />
".(defined("F_MESSAGE") ? F_MESSAGE."<br />" : "")."
<span class='defaulttext'><a href='".e_PLUGIN."forum/forum_viewtopic.php?{$iid}.last'>".LAN_325."</a><br />
<a href='".e_PLUGIN."forum/forum_viewforum.php?".$forum_id."'>".LAN_326."</a></span><br /><br />
</td></tr></table>";

?>