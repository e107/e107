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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/content/templates/default/content_searchresult_template.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

global $sc_style, $content_shortcodes;

$sc_style['CONTENT_SEARCHRESULT_TABLE_ICON']['pre'] = "<td class='forumheader3'>";
$sc_style['CONTENT_SEARCHRESULT_TABLE_ICON']['post'] = "</td>";

$sc_style['CONTENT_SEARCHRESULT_TABLE_HEADING']['pre'] = "<tr><td class='fcaption'>";
$sc_style['CONTENT_SEARCHRESULT_TABLE_HEADING']['post'] = "</td></tr>";

$sc_style['CONTENT_SEARCHRESULT_TABLE_SUBHEADING']['pre'] = "<tr><td class='forumheader3'>";
$sc_style['CONTENT_SEARCHRESULT_TABLE_SUBHEADING']['post'] = "</td></tr>";

$sc_style['CONTENT_SEARCHRESULT_TABLE_DATE']['pre'] = CONTENT_LAN_10." ";
$sc_style['CONTENT_SEARCHRESULT_TABLE_DATE']['post'] = "";

$sc_style['CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS']['pre'] = CONTENT_LAN_11." ";
$sc_style['CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS']['post'] = "";

$sc_style['CONTENT_SEARCHRESULT_TABLE_TEXT']['pre'] = "<tr><td class='forumheader3'>";
$sc_style['CONTENT_SEARCHRESULT_TABLE_TEXT']['post'] = "</td></tr>";

// ##### CONTENT SEARCHRESULT LIST --------------------------------------------------
if(!isset($CONTENT_SEARCHRESULT_TABLE_START)){
	$CONTENT_SEARCHRESULT_TABLE_START = "";
}
if(!isset($CONTENT_SEARCHRESULT_TABLE)){
	$CONTENT_SEARCHRESULT_TABLE .= "
	<table class='fborder' style='width:98%; text-align:left;margin-bottom:5px;'>
		<tr>
			{CONTENT_SEARCHRESULT_TABLE_ICON}
			<td>
				<table style='width:100%;' cellpadding='0' cellspacing='0'>
					{CONTENT_SEARCHRESULT_TABLE_HEADING}
					{CONTENT_SEARCHRESULT_TABLE_SUBHEADING}
					<tr><td class='forumheader3'>{CONTENT_SEARCHRESULT_TABLE_AUTHORDETAILS} {CONTENT_SEARCHRESULT_TABLE_DATE}</td></tr>
					{CONTENT_SEARCHRESULT_TABLE_TEXT}
				</table>
			</td>
		</tr>
	</table>\n";
}
if(!isset($CONTENT_SEARCHRESULT_TABLE_END)){
	$CONTENT_SEARCHRESULT_TABLE_END .= "";
}
// ##### ----------------------------------------------------------------------

?>