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
|     $Source: /cvs_backup/e107_0.7/e107_themes/e107v4a/theme.php,v $
|     $Revision: 11623 $
|     $Date: 2010-07-26 05:08:09 -0500 (Mon, 26 Jul 2010) $
|     $Author: nlstart $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// [multilanguage]
include_lan(e_THEME."e107v4a/languages/".e_LANGUAGE.".php");


// [theme]

$themename = "e107.v4";
$themeversion = "2.01";
$themeauthor = "Steve Dunstan [jalist]";
$themeemail = "jalist@e107.org";
$themewebsite = "http://e107.org";
$themedate = "11/06/2003";
$themeinfo = "";
$xhtmlcompliant = TRUE;
$csscompliant = TRUE;
define("IMODE", "lite");
define("THEME_DISCLAIMER", "<br /><i>".LAN_THEME_6."</i>");

// [layout]

$layout = "_default";
$logo = THEME_ABS."images/bullet3.gif";


$HEADER =
"
<table style='width:100%; background-color:#E4E0E0' cellspacing='3' class='topborder'>
<tr>
<td style='text-align:left; vertical-align:bottom'>
{CUSTOM=clock}
</td>
<td style='text-align:right'>
{CUSTOM=search+".THEME_ABS."images/search.png+18+19}
</td>
</tr>
</table>
<table style='width:100%;' cellspacing='3' id='header'>
<tr>
<td colspan='2' style='text-align:left; vertical-align: middle;'>
<img src='".THEME_ABS."images/logo.png' alt='' /> [ {SITENAME} ]
</td>
<td style='text-align:right'>
{BANNER}
</td>
</tr>
</table>
<table style='width:100%' cellspacing='3'>
<tr>
<td style='width:20%;'></td>
<td style='width:60%;'><img src='".THEME_ABS."images/blank.gif' width='1' height='1' alt='' /></td>
<td style='width:20%;'></td>
</tr>
<tr>
<td style='width:20%; vertical-align: top;'>
{SITELINKS=menu}
{MENU=1}
</td><td style='width:60%; vertical-align: top;'>";

$FOOTER =
"</td><td style='width:20%; vertical-align:top'>
{MENU=2}
</td></tr>
<tr>
<td colspan='3' style='text-align:center' class='smalltext'>

{SITEDISCLAIMER}
<br />
{THEME_DISCLAIMER}
</td>
</tr>
</table>
<div style='text-align:center'>
<table style='width:100%'>
<tr>
<td style='width:30%; vertical-align:top'>
&nbsp;
{MENU=3}
</td>
<td style='width:40%; vertical-align:top'>
{MENU=4}
</td>
<td style='width:30%; vertical-align:top'>
&nbsp;
{MENU=5}
</td>
</tr>
</table>
</div>";



function rand_tag(){
        $tags = file(e_BASE."files/taglines.txt");
        return stripslashes(htmlspecialchars($tags[rand(0, count($tags))]));
}

//        [newsstyle]

$NEWSSTYLE = "
<div class='spacer'>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='captiontopleft'><img src='".THEME_ABS."images/blank.gif' width='24' height='3' alt='' style='display: block;' /></td>
<td class='captiontopmiddle'><img src='".THEME_ABS."images/blank.gif' width='1' height='3' alt='' style='display: block;' /></td>
<td class='captiontopright'><img src='".THEME_ABS."images/blank.gif' width='11' height='3' alt='' style='display: block;' /></td>
</tr>
</table>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='captionleft'><img src='".THEME_ABS."images/blank.gif' width='24' height='18' alt='' style='display: block;' /></td>
<td class='captionbar' style='white-space:nowrap'>
{STICKY_ICON}{NEWSTITLE}
</td>
<td class='captionend'><img src='".THEME_ABS."images/blank.gif' width='12' height='18' alt='' style='display: block;' /></td>
<td class='captionmain'><img src='".THEME_ABS."images/blank.gif' width='1' height='18' alt='' style='display: block;' /></td>
<td class='captionright'><img src='".THEME_ABS."images/blank.gif' width='11' height='18' alt='' style='display: block;' /></td>
</tr>
</table>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='bodyleft'><img src='".THEME_ABS."images/blank.gif' width='3' height='1' alt='' style='display: block;' /></td>
<td class='bodymain'>
{NEWSBODY}
{EXTENDED}
<div class='alttd' style='text-align:right'>
".LAN_THEME_4." {NEWSAUTHOR} ".LAN_THEME_5." {NEWSDATE}
 |
{NEWSCOMMENTS}
 |
{EMAILICON}
{PRINTICON}
{PDFICON}
</div>
</td>
<td class='bodyright'><img src='".THEME_ABS."images/blank.gif' width='3' height='1' alt='' style='display: block;' /></td>
</tr>
</table>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='bottomleft'><img src='".THEME_ABS."images/blank.gif' width='10' height='9' alt='' style='display: block;' /></td>
<td class='bottommain'><img src='".THEME_ABS."images/blank.gif' width='1' height='9' alt='' style='display: block;' /></td>
<td class='bottomright'><img src='".THEME_ABS."images/blank.gif' width='10' height='9' alt='' style='display: block;' /></td>
</tr>
</table>
</div>";



define("ICONSTYLE", "float: left; border:0");
define("COMMENTLINK", LAN_THEME_1);
define("COMMENTOFFSTRING", LAN_THEME_2);
define("PRE_EXTENDEDSTRING", "<br /><br />[ ");
define("EXTENDEDSTRING", LAN_THEME_3);
define("POST_EXTENDEDSTRING", " ]<br />");



// [linkstyle]

define(PRELINK, "");
define(POSTLINK, "");
define(LINKSTART, "<span><img src='".THEME_ABS."images/bullet2.gif' alt='bullet' /> ");
define(LINKSTART_HILITE, "<span style='font-weight:bold'><img src='".THEME_ABS."images/bullet3.png' alt='bullet' /> ");
define(LINKEND, "</span><br />");
define(LINKDISPLAY, 2);
define(LINKALIGN, "left");


//        [tablestyle]

function tablestyle($caption, $text){
        global $style;


        echo "
<div class='spacer'>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='captiontopleft'><img src='".THEME_ABS."images/blank.gif' width='24' height='3' alt='' style='display: block;' /></td>
<td class='captiontopmiddle'><img src='".THEME_ABS."images/blank.gif' width='1' height='3' alt='' style='display: block;' /></td>
<td class='captiontopright'><img src='".THEME_ABS."images/blank.gif' width='11' height='3' alt='' style='display: block;' /></td>
</tr>
</table>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='captionleft'><img src='".THEME_ABS."images/blank.gif' width='24' height='18' alt='' style='display: block;' /></td>
<td class='captionbar' style='white-space:nowrap'>".$caption."</td>
<td class='captionend'><img src='".THEME_ABS."images/blank.gif' width='12' height='18' alt='' style='display: block;' /></td>
<td class='captionmain'><img src='".THEME_ABS."images/blank.gif' width='1' height='18' alt='' style='display: block;' /></td>
<td class='captionright'><img src='".THEME_ABS."images/blank.gif' width='11' height='18' alt='' style='display: block;' /></td>
</tr>
</table>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='bodyleft'><img src='".THEME_ABS."images/blank.gif' width='3' height='1' alt='' style='display: block;' /></td>
<td class='bodymain'>".$text."</td>
<td class='bodyright'><img src='".THEME_ABS."images/blank.gif' width='3' height='1' alt='' style='display: block;' /></td>
</tr>
</table>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='bottomleft'><img src='".THEME_ABS."images/blank.gif' width='10' height='9' alt='' style='display: block;' /></td>
<td class='bottommain'><img src='".THEME_ABS."images/blank.gif' width='1' height='9' alt='' style='display: block;' /></td>
<td class='bottomright'><img src='".THEME_ABS."images/blank.gif' width='10' height='9' alt='' style='display: block;' /></td>
</tr>
</table>
</div>
";

}


$COMMENTSTYLE = "
<div style='text-align:center'>
<table style='width:100%'>
<tr>
<td colspan='2' class='alttd'>
{SUBJECT}&nbsp;
<b>
{USERNAME}
</b>
 |
 {TIMEDATE}
</td>
</tr>
<tr>
<td style='width:30%; vertical-align:top'>
<div class='spacer'>
{AVATAR}
</div>
<span class='smalltext'>
{LEVEL}
{COMMENTS}
<br />
{JOINED}
<br />
{REPLY}
</span>
</td>
<td style='width:70%; vertical-align:top'>
{COMMENT} {COMMENTEDIT}
</td>
</tr>
</table>
</div>
<br />";



?>