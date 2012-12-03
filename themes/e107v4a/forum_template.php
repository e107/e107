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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/e107v4a/forum_template.php $
|     $Revision: 11678 $
|     $Id: forum_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$sc_style['LASTEDIT']['pre'] = "<br /><br /><span class='smallblacktext'>[ ".LAN_29." ";
$sc_style['LASTEDIT']['post'] = " ]</span>";

$sc_style['ANON_IP']['pre'] = "<br /><span class='smalltext'>";
$sc_style['ANON_IP']['post'] = "</span>";

$sc_style['USER_EXTENDED']['location.text_value']['mid'] = ": ";
$sc_style['USER_EXTENDED']['location.text_value']['post'] = "<br />";

$FORUMSTART = "
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td  colspan='2' class='nforumcaption'>{BACKLINK}</td>
</tr>
<tr>
<td class='nforumcaption2' colspan='2'>
<table cellspacing='0' cellpadding='0' style='width:100%'>
<tr>
<td>{NEXTPREV}</td>
<td style='text-align:right'>&nbsp;{TRACK}&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<br />

<table style='width:100%'>
<tr>
<td style='width:60%'><div class='mediumtext'><img src='".e_PLUGIN."forum/images/lite/e.png' alt='' style='vertical-align:middle' /> <b>{THREADNAME}</b></div><br />{GOTOPAGES}</td>
<td style='width:40%; text-align: right; vertical-align:bottom;'>{BUTTONS}</td>
</tr>
</table>


<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td style='width:20%; text-align:center' class='nforumcaption2'>\n".LAN_402."\n</td>\n<td style='width:80%; text-align:center' class='nforumcaption2'>\n".LAN_403."\n</td>
</tr>
</table>";

$FORUMTHREADSTYLE = "
<div class='spacer'>
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td class='nforumcaption3' style='vertical-align:middle; width:20%;'>\n{NEWFLAG}\n{POSTER}\n{ANON_IP}</td>
<td class='nforumcaption3' style='vertical-align:middle; width:80%;'>
<table cellspacing='0' cellpadding='0' style='width:100%'>
<tr>
<td class='smallblacktext'>\n{THREADDATESTAMP}\n</td>
<td style='text-align:right'>\n{EMAILITEM} {PRINTITEM} {REPORTIMG}\n{EDITIMG}\n{QUOTEIMG}\n</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class='nforumthread' style='vertical-align:top'>\n{AVATAR}\n<div class='smalltext'>\n{CUSTOMTITLE}\n{LEVEL}\n{MEMBERID}\n{JOINED}\n{USER_EXTENDED=location.text_value}\n{POSTS}\n</div>\n</td>
<td class='nforumthread' style='vertical-align:top'>{POLL}\n{POST}\n{LASTEDIT}\n{SIGNATURE}\n</td>
</tr>
<tr>
<td class='nforumthread2'>\n<span class='smallblacktext'>\n{TOP}\n</span>\n</td>
<td class='nforumthread2' style='vertical-align:top'>
<table cellspacing='0' cellpadding='0' style='width:100%'>
<tr>
<td>\n{PROFILEIMG}\n {EMAILIMG}\n {WEBSITEIMG}\n {PRIVMESSAGE}\n</td>
<td style='text-align:right'>\n{MODOPTIONS}\n</td>
</tr>
</table>
</td>
</tr>
</table>
</div>";

$FORUMREPLYSTYLE = "
<div class='spacer'>
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td class='nforumcaption3' style='vertical-align:middle; width:20%;'>\n{NEWFLAG}\n{POSTER}\n{ANON_IP}</td>
<td class='nforumcaption3' style='vertical-align:middle; width:80%;'>
<table cellspacing='0' cellpadding='0' style='width:100%'>
<tr>
<td class='smallblacktext'>\n{THREADDATESTAMP}\n</td>
<td style='text-align:right'>\n{EMAILITEM} {PRINTITEM} {REPORTIMG}\n{EDITIMG}\n{QUOTEIMG}\n</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class='nforumthread' style='vertical-align:top'>\n{AVATAR}\n<span class='smalltext'>\n{CUSTOMTITLE}\n{LEVEL}\n{MEMBERID}\n{JOINED}\n{USER_EXTENDED=location.text_value}\n{POSTS}\n</span>\n</td>
<td class='nforumthread' style='vertical-align:top'>\n{POST}\n{LASTEDIT}\n{SIGNATURE}\n</td>
</tr>
<tr>
<td class='nforumthread2'>\n<span class='smallblacktext'>\n{TOP}\n</span>\n</td>
<td class='nforumthread2' style='vertical-align:top'>
<table cellspacing='0' cellpadding='0' style='width:100%'>
<tr>
<td>\n{PROFILEIMG}\n {EMAILIMG}\n {WEBSITEIMG}\n {PRIVMESSAGE}\n</td>
<td style='text-align:right'>\n{MODOPTIONS}\n</td>
</tr>
</table>
</td>
</tr>
</table>
</div>";

$FORUMEND = "
<div class='spacer'>
<div class='forumheader'>
{GOTOPAGES}
</div>
<br />
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td style='width:50%; text-align:left; vertical-align:top' class='nforumthread'><b>{MODERATORS}</b><br />{FORUMJUMP}</td>
<td style='width:50%; text-align:right; vertical-align:top' class='nforumthread'>{BUTTONS}</td>
</tr>
</table>
</div>
<div class='spacer'>
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td style='text-align:center' class='nforumthread2'>
{QUICKREPLY}
</td>
</tr>
</table>
<div class='nforumdisclaimer' style='text-align:center'>Powered by <b>e107 Forum System</b></div>
</div>";


$FORUM_MAIN_START = "<div style='text-align:center'>";

$FORUM_MAIN_PARENT = "<div class='spacer'>\n<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>\n<tr>\n<td colspan='5' class='nforumcaption'>{PARENTNAME} {PARENTSTATUS}</td>\n</tr>
<tr>\n<td colspan='2' style='width:60%; text-align:center' class='nforumcaption2'>{FORUMTITLE}</td>\n<td style='width:10%; text-align:center' class='nforumcaption2'>{THREADTITLE}</td>\n<td style='width:10%; text-align:center' class='nforumcaption2'>{REPLYTITLE}</td>\n<td style='width:20%; text-align:center' class='nforumcaption2'>{LASTPOSTITLE}</td>\n</tr>\n";

$FORUM_MAIN_PARENT_END = "</table></div>";

$FORUM_MAIN_FORUM = "<tr>\n<td style='width:5%; text-align:center' class='nforumcaption3'>{NEWFLAG}</td>\n<td style='width:55%' class='nforumcaption3'>{FORUMNAME}<br /><span class='smallblacktext'>{FORUMDESCRIPTION}</span>{FORUMSUBFORUMS}</td>\n<td style='width:10%; text-align:center' class='nforumthread'>{THREADS}</td>\n<td style='width:10%; text-align:center' class='nforumthread'>{REPLIES}</td>\n<td style='width:20%; text-align:center' class='nforumthread'><span class='smallblacktext'>{LASTPOST}</span></td>\n</tr>";

$FORUM_MAIN_END = "<div class='spacer'>\n<table style='width:100%' class='fborder'>\n<tr>\n<td colspan='2' style='width:60%' class='nforumcaption2'>{INFOTITLE}</td>\n</tr>\n<tr>\n<td rowspan='4' style='width:5%; text-align:center' class='forumheader3'>{LOGO}</td>\n<td style='width:100%' class='forumheader3'>{USERINFO}</td>\n</tr>\n<tr>\n<td style='width:auto' class='forumheader3'>{INFO}</td>\n</tr>\n<tr>\n<td style='width:100%' class='forumheader3'>{FORUMINFO}</td>\n</tr>\n<tr>\n<td style='width:100%' class='forumheader3'>{USERLIST}</td>\n</tr>\n</table>\n</div>\n<div class='spacer'>\n<table class='fborder' style='width:100%'>\n<tr>\n<td class='forumheader3' style='text-align:center; width:33%'>{ICONKEY}</td>\n<td style='text-align:center; width:33%' class='forumheader3'>{SEARCH}</td>\n<td style='width:33%; text-align:center; vertical-align:middle' class='forumheader3'><span class='smallblacktext'>{PERMS}</span>\n</td>\n</tr>\n</table>\n</div>\n<div class='nforumdisclaimer' style='text-align:center'>Powered by <b>e107 Forum System</b></div></div>";



$FORUM_VIEW_START = "
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td  colspan='2' class='nforumcaption'>{BREADCRUMB}</td>
</tr>
{SUBFORUMS}
</table>

<table style='width:100%'><tr>
<td style='width:80%'><div class='mediumtext'><img src='".e_PLUGIN."forum/images/lite/e.png' style='vertical-align:middle' alt='' /> <b>{FORUMTITLE} Forum</b></div>{THREADPAGES}</td>
<td style='width:20%; text-align:right; vertical-align:bottom;'>
{NEWTHREADBUTTON}
</td>
</tr>
</table>

<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td style='width:3%' class='nforumcaption2'>&nbsp;</td>
<td style='width:47%' class='nforumcaption2'>{THREADTITLE}</td>
<td style='width:20%; text-align:center' class='nforumcaption2'>{STARTERTITLE}</td>
<td style='width:5%; text-align:center' class='nforumcaption2'>{REPLYTITLE}</td>
<td style='width:5%; text-align:center' class='nforumcaption2'>{VIEWTITLE}</td>
<td style='width:20%; text-align:center' class='nforumcaption2'>{LASTPOSTITLE}</td>
</tr>";


$FORUM_VIEW_START_CONTAINER = "
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td  colspan='2' class='nforumcaption'>{BREADCRUMB}</td>
</tr>
{SUBFORUMS}
</table>
";

$sc_style['PAGES']['pre'] = "<span class='smalltext'>";
$sc_style['PAGES']['post'] = "</span>";

$FORUM_VIEW_FORUM = "
<tr>
<td style='vertical-align:middle; text-align:center; width:3%' class='nforumview1'>{ICON}</td>
<td style='vertical-align:middle; text-align:left; width:47%'  class='nforumview1'>

<table style='width:100%'>
<tr>
<td style='width:90%'><span class='mediumtext'><b>{THREADNAME}</b></span> {PAGES}</td>
<td style='width:10%; white-space:nowrap;'>{ADMIN_ICONS}</td>
</tr>
</table>
</td>

<td style='vertical-align:top; text-align:center; width:20%' class='nforumview2'><span class='smalltext'><b>{POSTER}</b><br />{THREADDATE}</span></td>
<td style='vertical-align:middle; text-align:center; width:5%' class='nforumview2'><span class='smalltext'>{REPLIES}</span></td>
<td style='vertical-align:middle; text-align:center; width:5%' class='nforumview2'><span class='smalltext'>{VIEWS}</span></td>
<td style='vertical-align:top; text-align:center; width:20%' class='nforumview2'><span class='smalltext'>{LASTPOST}</span></td>
</tr>";

$sc_style['THREADPAGES']['pre'] = "<span class='mediumtext'>";
$sc_style['THREADPAGES']['post'] = "</span>";

$FORUM_VIEW_END = "
</table>
<table style='width:100%'>
<tr>
<td style='width:80%'>{THREADPAGES}
{FORUMJUMP}
</td>
<td style='width:20%; text-align:right'>
{NEWTHREADBUTTON}
</td>
</tr>
</table>


<div class='spacer'>
<table style='width:100%' class='nforumholder' cellpadding='0' cellspacing='0'>
<tr>
<td style='vertical-align:middle; width:50%' class='nforumview3'><span class='smalltext'>{MODERATORS}</span></td>
<td style='text-align:right; vertical-align:middle; width:50%' class='nforumview3'><span class='smalltext'>{BROWSERS}</span></td>
</tr>

<tr>
<td style='vertical-align:middle; width:50%' class='nforumview4'>{ICONKEY}</td>
<td style='vertical-align:middle; text-align:center; width:50%' class='nforumview4'>{PERMS}<br /><br />{SEARCH}
</td>
</tr>
</table>
</div>

<div class='nforumdisclaimer' style='text-align:center'>Powered by <b>e107 Forum System</b></div>";



$FORUM_VIEW_END_CONTAINER = "
<table style='width:100%'>
<tr>
<td style='width:100%; text-align:left'>
<br />{FORUMJUMP}
</td>
</tr>
</table>
<br /><div class='nforumdisclaimer' style='text-align:center'>Powered by <b>e107 Forum System</b></div>
";



$FORUM_VIEW_SUB_START = "
<tr>
<td colspan='2'>
<table style='width:100%'  cellpadding='0' cellspacing='0'>
<tr>
<td class='nforumcaption2' style='width: 50%'>".FORLAN_20."</td>
<td class='nforumcaption2' style='width: 10%; text-align: center;'>".FORLAN_21."</td>
<td class='nforumcaption2' style='width: 10%; text-align: center;'>".LAN_55."</td>
<td class='nforumcaption2' style='width: 30%; text-align: center;'>".FORLAN_22."</td>
</tr>
";

$FORUM_VIEW_SUB = "
<tr>
<td class='nforumview2' style='text-align:left'><b>{SUB_FORUMTITLE}</b><br />{SUB_DESCRIPTION}</td>
<td class='nforumview2' style='text-align:center'>{SUB_THREADS}</td>
<td class='nforumview2' style='text-align:center'>{SUB_REPLIES}</td>
<td class='nforumview2' style='text-align:center'>{SUB_LASTPOST}</td>
</tr>
";

$FORUM_VIEW_SUB_END = "
</table>
</td>
</tr>
";


?>