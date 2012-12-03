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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/interfectus/theme.php $
|     $Revision: 11678 $
|     $Id: theme.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [multilanguage]
include_lan(e_THEME."interfectus/languages/".e_LANGUAGE.".php");

// [theme]
$themename = "interfectus";
$themeversion = "1.0";
$themeauthor = "Steve Dunstan [jalist]";
$themeemail = "jalist@e107.org";
$themewebsite = "http://e107.org";
$themedate = "16/03/2005";
$themeinfo = "Dark theme suitable for gaming / clan sites.";
define("STANDARDS_MODE", TRUE);
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;

define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");
define("IMODE", "dark");

// [layout]

$layout = "_default";

$HEADER = "
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='logo'><div id='sitename'>[ <a href='".e_HTTP."index.php'>{SITENAME}</a> ]</div></td>
</tr>
</table>
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='collefttop'></td>
<td id='infoleft'>
<div class='padder'>
{CUSTOM=search+".THEME_ABS."images/search.png}
</div>
</td>
<td id='inforight'>
<div class='padder'>
{CUSTOM=clock}
</div>
</td>
<td id='colrighttop'></td>
</tr>
</table>
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='colleft'></td>
<td>
<table class='tablewrapper' cellpadding='0' cellspacing='0'>
<tr>
<td id='contentarea'>
<div class='padder'>
<table class='tablewrapper' cellpadding='0' cellspacing='0'>
<tr><td class='pageheader'></td></tr>
<tr><td class='pagebody'>
{SETSTYLE=main}

";

$FOOTER = "
</td></tr>
<tr><td class='pagefooter'></td></tr>
</table>
</div>
</td>
<td id='menuarea'>
<table class='menutable' cellpadding='0' cellspacing='0'>
<tr>
<td class='menutop'></td>
</tr>
<tr>
<td class='menubody'>
<div class='menuwrapper'>
{SETSTYLE=menu1}
{SITELINKS}
{MENU=1}
</div>
</td>
</tr>
<tr>
<td class='menubottom'></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td id='colright'></td>
</tr>
</table>
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='colbotleft'><img src='".THEME_ABS."images/blank.gif' width='14' height='14' alt='' style='display: block;' /></td>
<td id='colbot'></td>
<td id='colbotright'><img src='".THEME_ABS."images/blank.gif' width='14' height='14' alt='' style='display: block;' /></td>
</tr>
</table>

<div class='smalltext' style='text-align: center;'>{SITEDISCLAIMER}<br />{THEME_DISCLAIMER}</div>

";


/*
<table class='menutable' cellpadding='0' cellspacing='0'>
<tr>
<td class='menutop2'></td>
</tr>
<tr>
<td class='menubody2'>
<div class='menuwrapper'>
{PLUGIN=other_news_menu/other_news2_menu}
</div>
</td>
</tr>
<tr>
<td class='menubottom2'></td>
</tr>
</table>
*/


$CUSTOMHEADER = "
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='logo'><div id='sitename'>[ <a href='".e_HTTP."index.php'>{SITENAME}</a> ]</div></td>
</tr>
</table>
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='collefttop'></td>
<td id='infoleft'>
<div class='padder'>
{CUSTOM=search+".THEME_ABS."images/search.png}
</div>
</td>
<td id='inforight'>
<div class='padder'>
{CUSTOM=clock}
</div>
</td>
<td id='colrighttop'></td>
</tr>
</table>
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='colleft'></td>
<td>
<table class='tablewrapper' cellpadding='0' cellspacing='0'>
<tr>
<td id='fullcontentarea'>
<div class='padder'>
<table class='tablewrapper' cellpadding='0' cellspacing='0'>
<tr><td class='pageheader'></td></tr>
<tr><td class='pagebody'>
{SETSTYLE=main}

";

$CUSTOMFOOTER = "

</td></tr>
<tr><td class='pagefooter'></td></tr>
</table>
</div>
</td>
</tr>
</table>
</td>
<td id='colright'></td>
</tr>
</table>
<table class='maintable' cellpadding='0' cellspacing='0'>
<tr>
<td id='colbotleft'><img src='".THEME_ABS."images/blank.gif' width='14' height='14' alt='' style='display: block;' /></td>
<td id='colbot'></td>
<td id='colbotright'><img src='".THEME_ABS."images/blank.gif' width='14' height='14' alt='' style='display: block;' /></td>
</tr>
</table>

";


$CUSTOMPAGES = "forum.php forum_post.php forum_viewforum.php forum_viewtopic.php user.php submitnews.php download.php links.php stats.php usersettings.php signup.php";




$NEWSSTYLE = "
<div class='captiontext'>{NEWSTITLE}</div>
{NEWSBODY}
{EXTENDED}
<div style='text-align:right' class='smalltext'>
{NEWSAUTHOR}
on
{NEWSDATE}
<br />
{NEWSCOMMENTS}{TRACKBACK}
</div>
<br />";

define("ICONSTYLE", "");
define("COMMENTLINK", LAN_THEME_2);
define("COMMENTOFFSTRING", LAN_THEME_3);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " | ");


// [linkstyle]

define('PRELINK', "");
define('POSTLINK', "");
define('LINKSTART', "<div class='link1' onmouseover=\"this.className='link2';\" onmouseout=\"this.className='link1';\"><div class='linktext'><img src='".THEME_ABS."images/bullet1.gif' alt='' />&nbsp;&nbsp;");
define("LINKSTART_HILITE", "<div class='link2' onmouseover=\"this.className='link1';\" onmouseout=\"this.className='link2';\"><div class='linktext'><img src='".THEME_ABS."images/bullet1.gif' alt='' />&nbsp;&nbsp;");
define('LINKEND', "</div></div>");
define('LINKDISPLAY', 1);
define('LINKALIGN', "left");




//	[tablestyle]

function tablestyle($caption, $text)
{
	global $style;

	if($style == "menu1")
	{
		echo "<div class='caption'><div class='captionpadder'>$caption</div></div><br /><div class='padder'>$text</div><br />";
	}
	else if($style == "menu2")
	{
		echo "<table class='menutable' cellpadding='0' cellspacing='0'>
<tr><td class='menutop2'></td></tr>
<tr><td class='menubody2'><div class='menuwrapper'>$caption<br /><br />$text</div></td></tr>
<tr><td class='menubottom2'></td></tr>
</table>";
	}
	else
	{
		echo "<div class='captiontext'>$caption</div>$text<br />";
	}
}

$COMMENTSTYLE = "<br /><br />
<div class='captiontext'><img src='".THEME_ABS."images/bullet1.gif' alt='' style='vertical-align: middle;' /> {USERNAME} | {TIMEDATE}</div>
{COMMENT} {COMMENTEDIT}<br />
<span class='smalltext'>{REPLY}{IPADDRESS}</span>
";



$CHATBOXSTYLE = "
<div class='link2'><div class='linktext'><img src='".THEME_ABS."images/bullet1.gif' alt='' style='vertical-align: middle;' /> {USERNAME} | <span class='cbdate'>{TIMEDATE}</span></div></div>
<div class='smalltext'>
{MESSAGE}
</div>
<br />";











?>