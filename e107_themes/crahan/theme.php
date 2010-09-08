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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/crahan/theme.php $
|     $Revision: 11678 $
|     $Id: theme.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [multilanguage]
include_lan(e_THEME."crahan/languages/".e_LANGUAGE.".php");

// [theme]
$themename = "CraHan";
$themeversion = "1.0";
$themeauthor = "Steve Dunstan [jalist]";
$themeemail = "jalist@e107.org";
$themewebsite = "http://e107.org";
$themedate = "29/01/2005";
$themeinfo = "Based on the theme by CraHan at his homepage <a href='http://n00.be' rel='external'>n00.be</a>, design used with permission.";
define("STANDARDS_MODE", TRUE);
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;
define("IMODE", "lite");
define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_1."</i>");

$logo = "logo".rand(1, 4);

// [layout]

$layout = "_default";

$HEADER = "
<div id='wrapper'>
<div id='menu'>
<div class='content'>
<div class='fixfuckedie'>
{MENU=1}
</div>
</div>
</div>
<div id='main'>
<div id='sitebanner'>
<div id='{$logo}'><div class='smalltext' style='text-align: right; vertical-align: bottom;'>{SITENAME}&nbsp;</div></div>
<div id='navbar'>
{SITELINKS}
</div>
</div>
<div class='content'>
<div class='fixfuckedie'>
";

$FOOTER = "
</div>
</div>
<br />
<br />
<div class='smalltext' style='text-align: center;'>{SITEDISCLAIMER}</div>
</div>
</div>
";

$NEWSSTYLE = "
<div class='header'>
<div class='left'>{STICKY_ICON} {NEWSTITLE}</div>
<div class='right'>{NEWSDATE}</div>
</div>
<div class='bodytable' style='text-align:left'>
{NEWSBODY}
{EXTENDED}
</div>
<br />
<div class='newssmalltext'>[ {NEWSAUTHOR} :: {NEWSCOMMENTS}{TRACKBACK} ]</div>
<br />
<br />";

define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", LAN_THEME_3);
define("COMMENTOFFSTRING", LAN_THEME_2);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_4);
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", LAN_THEME_5);
define("TRACKBACKBEFORESTRING", " :: ");


// [linkstyle]

define('PRELINK', "");
define('POSTLINK', " ::");
define('LINKSTART', ":: ");
define('LINKSTART_HILITE', ":: ");
define('LINKEND', "");
define('LINKDISPLAY', 1);
define('LINKALIGN', "left");


//	[tablestyle]

function tablestyle($caption, $text, $mode)
{
	echo "<div class='header'>{$caption}</div>\n{$text}\n<br /><br />\n";
}

$COMMENTSTYLE = "
<div style='padding-left: 25px;'>{COMMENT} {COMMENTEDIT}<br /><br />
<div class='newssmalltext'>[ ".LAN_THEME_6." {USERNAME} :: {TIMEDATE} ]</div>
</div>
<br /><br />
";


$CHATBOXSTYLE = "
<img src='".e_IMAGE_ABS."admin_images/chatbox_16.png' alt='' style='vertical-align: middle;' />
<b>{USERNAME}</b>
<div class='smalltext'>
{MESSAGE}
</div>
<br />";

?>