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
|     $Source: /cvs_backup/e107_0.7/e107_themes/templates/comment_template.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }
if (!defined("USER_WIDTH")){ define("USER_WIDTH","width:100%"); }

global $sc_style, $comment_shortcodes;
global $pref, $comrow, $row2, $tp, $NEWIMAGE, $USERNAME, $RATING;

$sc_style['SUBJECT']['pre'] = "<b>";
$sc_style['SUBJECT']['post'] = "</b>";

$sc_style['USERNAME']['pre'] = "<b>";
$sc_style['USERNAME']['post'] = "</b>";

$sc_style['TIMEDATE']['pre'] = "";
$sc_style['TIMEDATE']['post'] = "";

$sc_style['REPLY']['pre'] = "";
$sc_style['REPLY']['post'] = "";

$sc_style['AVATAR']['pre'] = "<div class='spacer'>";
$sc_style['AVATAR']['post'] = "</div>";

$sc_style['COMMENTS']['pre'] = "";
$sc_style['COMMENTS']['post'] = "<br />";

$sc_style['JOINED']['pre'] = "";
$sc_style['JOINED']['post'] = "<br />";

$sc_style['COMMENT']['pre'] = "";
$sc_style['COMMENT']['post'] = "<br />";

$sc_style['RATING']['pre'] = "";
$sc_style['RATING']['post'] = "<br />";

$sc_style['IPADDRESS']['pre'] = "";
$sc_style['IPADDRESS']['post'] = "<br />";

$sc_style['LEVEL']['pre'] = "";
$sc_style['LEVEL']['post'] = "<br />";

$sc_style['LOCATION']['pre'] = "";
$sc_style['LOCATION']['post'] = "<br />";

$sc_style['SIGNATURE']['pre'] = "";
$sc_style['SIGNATURE']['post'] = "<br />";


$COMMENTSTYLE = "
<table class='fborder' style='".USER_WIDTH."'>
<tr>
	<td colspan='2' class='forumheader'>
		{SUBJECT} {USERNAME} {TIMEDATE} {REPLY} {COMMENTEDIT}
	</td>
</tr>
<tr>
	<td style='width:30%; vertical-align:top;'>
		{AVATAR}<span class='smalltext'>{COMMENTS}{JOINED}</span>
	</td>
	<td style='width:70%; vertical-align:top;'>
		{COMMENT}
		{RATING}
		{IPADDRESS}
		{LEVEL}
		{LOCATION}
		{SIGNATURE}
	</td>
</tr>
</table>
<br />";


?>