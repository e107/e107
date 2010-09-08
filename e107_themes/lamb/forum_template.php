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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/lamb/forum_template.php $
|     $Revision: 11678 $
|     $Id: forum_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

$FORUM_MAIN_START = "<div style='text-align:center'>";

$FORUM_MAIN_PARENT = "<div class='spacer'>\n<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>\n<tr>\n<td colspan='5' class='nforumcaption'>{PARENTNAME} {PARENTSTATUS}</td>\n</tr>
<tr>\n<td colspan='2' style='width:60%; text-align:center' class='nforumcaption2'>{FORUMTITLE}</td>\n<td style='width:10%; text-align:center' class='nforumcaption2'>{THREADTITLE}</td>\n<td style='width:10%; text-align:center' class='nforumcaption2'>{REPLYTITLE}</td>\n<td style='width:20%; text-align:center' class='nforumcaption2'>{LASTPOSTITLE}</td>\n</tr>\n";

//$FORUM_MAIN_PARENT_END = "</table></div>";

$FORUM_MAIN_FORUM = "<tr>\n<td style='width:5%; text-align:center' class='nforumcaption3'>{NEWFLAG}</td>\n<td style='width:55%' class='nforumcaption3'>{FORUMNAME}<br /><span class='smallblacktext'>{FORUMDESCRIPTION}</span>{FORUMSUBFORUMS}</td>\n<td style='width:10%; text-align:center' class='nforumthread'>{THREADS}</td>\n<td style='width:10%; text-align:center' class='nforumthread'>{REPLIES}</td>\n<td style='width:20%; text-align:center' class='nforumthread'><span class='smallblacktext'>{LASTPOST}</span></td>\n</tr>";

$FORUM_MAIN_END = "</table></div>\n<div class='spacer'>\n<table style='width:100%' class='nforumholder' cellspacing='1'>\n<tr>\n<td colspan='2' style='width:60%' class='nforumcaption2'>{INFOTITLE}</td>\n</tr>\n<tr>\n<td rowspan='4' style='width:5%; text-align:center' class='nforumthread'>{LOGO}</td>\n<td style='width:auto' class='nforumthread'>{USERINFO}</td>\n</tr>\n<tr>\n<td style='width:95%' class='nforumthread'>{INFO}</td>\n</tr><tr>\n<td style='width:95%' class='nforumthread'>{FORUMINFO}</td>\n</tr>\n<tr>\n<td style='width:95%' class='nforumthread'>{USERLIST}<br />{STATLINK}</td>\n</tr>\n</table>\n</div>\n<div class='spacer'>\n<table class='fborder' style='width:100%'>\n<tr>\n<td class='nforumthread' style='text-align:center; width:33%'>{ICONKEY}</td>\n<td style='text-align:center; width:33%' class='nforumthread'>{SEARCH}</td>\n<td style='width:33%; text-align:center; vertical-align:middle' class='nforumthread'><span class='smallblacktext'>{PERMS}</span>\n</td>\n</tr>\n</table>\n</div>\n</div>";

 if(!isset($FORUM_NEWPOSTS_START))
 {
         $FORUM_NEWPOSTS_START = "<div style='text-align:center'>\n<div class='spacer'>\n<table style='width:95%' class='fborder'>\n<tr>\n<td style='width:3%' class='fcaption'>&nbsp;</td>\n<td style='width:60%' class='fcaption'>{NEWTHREADTITLE}</td>\n<td style='width:27%; text-align:center' class='fcaption'>{POSTEDTITLE}</td>\n</tr>";
 }

 if(!isset($FORUM_NEWPOSTS_MAIN))
 {
         $FORUM_NEWPOSTS_MAIN = "<tr>\n<td style='width:3%' class='forumheader3'>{NEWIMAGE}</td>\n<td style='width:60%' class='forumheader3'>{NEWSPOSTNAME}</td>\n<td style='width:27%; text-align:center' class='forumheader3'>{STARTERTITLE}</td>\n</tr>";
 }

 if(!isset($FORUM_NEWPOSTS_END))
 {
         $FORUM_NEWPOSTS_END = "</table></div></div>";
 }

 if(!isset($FORUM_TRACK_START))
 {
         $FORUM_TRACK_START = "<div style='text-align:center'>\n<div class='spacer'>\n<table style='width:95%' class='fborder'>\n<tr>\n<td colspan='3' style='width:60%' class='fcaption'>{TRACKTITLE}</td>\n</tr>\n";

 if(!isset($FORUM_TRACK_MAIN))
 {
         $FORUM_TRACK_MAIN = "<tr>
         <td style='text-align:center; vertical-align:middle; width:6%'  class='forumheader3'>{NEWIMAGE}</td>
                         <td style='vertical-align:middle; text-align:left; width:70%'  class='forumheader3'><span class='mediumtext'>{TRACKPOSTNAME}</span></td>
                         <td style='vertical-align:middle; text-align:center; width:24%'  class='forumheader3'><span class='mediumtext'>{UNTRACK}</td>
                         </tr>";
                 }
         }

 if(!isset($FORUM_TRACK_END))
 {
         $FORUM_TRACK_END = "</table>\n</div>\n</div>";
 }


?>