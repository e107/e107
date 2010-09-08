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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/lamb/alt_theme.php $
|     $Revision: 11678 $
|     $Id: alt_theme.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [theme]
$themename = "lamb";
$themeversion = "1.0";
$themeauthor = "Steve Dunstan [jalist]";
$themedate = "29/01/2005";
$themeinfo = "";
define("STANDARDS_MODE", TRUE);

// [layout]

$layout = "_default";

$HEADER = "<div id='header'>
<div id='logo'>&nbsp;</div>
</div>
<div id='banner'>
{BANNER}
</div>
<div id='mainleft'>
<div id='mainright'>
<div id='leftcontent'>
<div class='columnwrap'>
{SITELINKS}
{MENU=1}
</div>
</div>
<div id='rightcontent'>
<div class='columnwrap'>
{MENU=2}
</div>
</div>
<div id='centercontent'>
<div class='menuwrapper'>
<div class='columnwrap'>
";

$FOOTER = "
</div>
</div>
<div class='cleaner'>&nbsp;</div>
</div>
</div>
</div>
<div id='footer'>
<div class='columnwrap'>
<div style='text-align: center;' class='smalltext'>
{SITEDISCLAIMER}
<br />
<img src='".e_IMAGE."generic/php-small-trans-light.gif' alt='' /> <img src='".e_IMAGE."button.png' alt='' /> 
<img src='".e_IMAGE."generic/poweredbymysql-88.png' alt=''  /> &nbsp;&nbsp;&nbsp;&nbsp;
<a href='http://validator.w3.org/check?uri=referer' rel='external'><img src='".e_IMAGE."generic/valid-xhtml11.png' alt='' style='border: 0;' /></a> 
<a href='http://jigsaw.w3.org/css-validator/check/referer' rel='external'><img src='".e_IMAGE."generic/vcss.png' alt='' style='border: 0;' /></a>
</div>
</div>
</div>
";

$NEWSSTYLE = "
<h3>
{STICKY_ICON}
{NEWSTITLE}
</h3>
<div class='bodytable' style='text-align:left'>
{NEWSBODY}
{EXTENDED}
</div>
<div style='text-align:right' class='smalltext'>
{NEWSAUTHOR}
on
{NEWSDATE}
<br />
<img src='".e_IMAGE."admin_images/userclass_16.png' alt='' style='vertical-align: middle;' />
{NEWSCOMMENTS}{TRACKBACK}
<br />
 | <a href='".e_BASE."submitnews.php'>Submit a news item</a>
</div>
<br />";
define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", "Read/Post Comment: ");
define("COMMENTOFFSTRING", "Comments are turned off for this item");
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", "Read the rest ...");
define("POST_EXTENDEDSTRING", " ]<br />");
define("TRACKBACKSTRING", "Trackbacks: ");
define("TRACKBACKBEFORESTRING", " | ");


// [linkstyle]

define('PRELINK', "");
define('POSTLINK', "");
define('LINKSTART', "<img src='".THEME."images/bullet2.gif' alt='' /> ");
define("LINKSTART_HILITE", "<img src='".THEME."images/bluearrow_greybg.png' alt='' /> ");
define('LINKEND', "<br />");
define('LINKDISPLAY', 2);
define('LINKALIGN', "left");


//	[tablestyle]

function tablestyle($caption, $text, $mode)
{
	echo "<h4><img src='".THEME."images/bluearrow_greybg.png' alt='' />  $caption</h4>\n<br />\n$text\n<br /><br />\n";
}

$COMMENTSTYLE = "
<table style='width: 100%;'>
<tr>
<td style='width: 30%; text-align: right;'>{USERNAME} @ <span class='smalltext'>{TIMEDATE}</span><br />{AVATAR}<span class='smalltext'>{REPLY}</span></td>
<td style='width: 70%;'>
<div id='lbqtop'>
<div id='pgFrontUserInner'>
<div id='lbqbottom'>
<div id='bglefright'>
<div id='bqcontent'>
<div id='bqtext'>
{COMMENT} {COMMENTEDIT}
</div>
</div>
</div>
</div>
</div>
</div>
</td>
</tr>
</table>
";

$POLLSTYLE = <<< EOF
<b>Poll:</b> {QUESTION}
<br /><br />
{OPTIONS=OPTION<br />BAR<br /><span class='smalltext'>PERCENTAGE VOTES</span><br />\n}
<br /><div style='text-align:center' class='smalltext'>{AUTHOR}<br />{VOTE_TOTAL} {COMMENTS}
<br />
{OLDPOLLS}
</div>
EOF;

$CHATBOXSTYLE = "
<img src='".e_IMAGE."admin_images/chatbox_16.png' alt='' style='vertical-align: middle;' />
<b>{USERNAME}</b>
<div class='smalltext'>
{MESSAGE}
</div>
<br />";

?>