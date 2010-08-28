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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/content/templates/default/content_score_template.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

global $sc_style, $content_shortcodes;

$sc_style['CONTENT_SCORE_TABLE_ICON']['pre'] = "<td class='forumheader3' rowspan='3' style='width:5%; white-space:nowrap;'>";
$sc_style['CONTENT_SCORE_TABLE_ICON']['post'] = "</td>";

$sc_style['CONTENT_SCORE_TABLE_HEADING']['pre'] = "";
$sc_style['CONTENT_SCORE_TABLE_HEADING']['post'] = "";

$sc_style['CONTENT_SCORE_TABLE_AUTHOR']['pre'] = "<tr><td class='forumheader3' colspan='2'>".CONTENT_LAN_11." ";
$sc_style['CONTENT_SCORE_TABLE_AUTHOR']['post'] = "</td></tr>";

$sc_style['CONTENT_SCORE_TABLE_SCORE']['pre'] = "<td class='fcaption' style='width:20%; white-space:nowrap; text-align:right;'>";
$sc_style['CONTENT_SCORE_TABLE_SCORE']['post'] = "</td>";

// ##### CONTENT TOP --------------------------------------------------
if(!isset($CONTENT_SCORE_TABLE_START)){
	$CONTENT_SCORE_TABLE_START = "";
}
if(!isset($CONTENT_SCORE_TABLE)){
	$CONTENT_SCORE_TABLE = "
	<table class='fborder' style='width:98%; text-align:left; margin-bottom:5px;'>
	<tr>
		{CONTENT_SCORE_TABLE_ICON}
		<td class='fcaption'>{CONTENT_SCORE_TABLE_HEADING}</td>
		{CONTENT_SCORE_TABLE_SCORE}
	</tr>
	{CONTENT_SCORE_TABLE_AUTHOR}
	</table>\n";
}
if(!isset($CONTENT_SCORE_TABLE_END)){
	$CONTENT_SCORE_TABLE_END = "";
}
// ##### ----------------------------------------------------------------------

?>