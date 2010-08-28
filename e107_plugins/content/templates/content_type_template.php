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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/content/templates/content_type_template.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

global $sc_style, $content_shortcodes;

$sc_style['CONTENT_TYPE_TABLE_TOTAL']['pre'] = "";
$sc_style['CONTENT_TYPE_TABLE_TOTAL']['post'] = " ";

$sc_style['CONTENT_TYPE_TABLE_HEADING']['pre'] = "";
$sc_style['CONTENT_TYPE_TABLE_HEADING']['post'] = "";

$sc_style['CONTENT_TYPE_TABLE_SUBHEADING']['pre'] = "";
$sc_style['CONTENT_TYPE_TABLE_SUBHEADING']['post'] = "";

$sc_style['CONTENT_TYPE_TABLE_LINK']['pre'] = "<br /><span class='smalltext'>";
$sc_style['CONTENT_TYPE_TABLE_LINK']['post'] = "</span>";

// ##### CONTENT TYPE LIST --------------------------------------------------
if(!isset($CONTENT_TYPE_TABLE_START)){
	$CONTENT_TYPE_TABLE_START = "
	<table class='fborder' style='width:98%; text-align:left;'>\n";
}
if(!isset($CONTENT_TYPE_TABLE)){
	$CONTENT_TYPE_TABLE = "
	<tr>
		<td class='forumheader3' style='width:5%; white-space:nowrap; padding-bottom:5px;' rowspan='2'>{CONTENT_TYPE_TABLE_ICON}</td>
		<td class='fcaption'>{CONTENT_TYPE_TABLE_HEADING}{CONTENT_TYPE_TABLE_LINK}</td>
		<td class='forumheader' style='width:5%; white-space:nowrap; text-align:right;'>{CONTENT_TYPE_TABLE_TOTAL}</td>
	</tr>
	<tr><td class='forumheader2' colspan='2'>{CONTENT_TYPE_TABLE_SUBHEADING}<br /></td></tr>\n";
}
if(!isset($CONTENT_TYPE_TABLE_SUBMIT)){
	$CONTENT_TYPE_TABLE_SUBMIT = "
	<tr>
		<td class='forumheader3' style='width:5%; white-space:nowrap; padding-bottom:5px;' rowspan='2'>{CONTENT_TYPE_TABLE_SUBMIT_ICON}</td>
		<td class='fcaption' colspan='2'>{CONTENT_TYPE_TABLE_SUBMIT_HEADING}</td>
	</tr>
	<tr><td class='forumheader2' colspan='2'>{CONTENT_TYPE_TABLE_SUBMIT_SUBHEADING}</td></tr>\n";
}
if(!isset($CONTENT_TYPE_TABLE_MANAGER)){
	$CONTENT_TYPE_TABLE_MANAGER = "
	<tr>
		<td class='forumheader3' style='width:5%; white-space:nowrap; padding-bottom:5px;' rowspan='2'>{CONTENT_TYPE_TABLE_MANAGER_ICON}</td>
		<td class='fcaption' colspan='2'>{CONTENT_TYPE_TABLE_MANAGER_HEADING}</td>
	</tr>
	<tr><td class='forumheader2' colspan='2'>{CONTENT_TYPE_TABLE_MANAGER_SUBHEADING}</td></tr>\n";
}
if(!isset($CONTENT_TYPE_TABLE_LINE)){
	$CONTENT_TYPE_TABLE_LINE = "";
}
if(!isset($CONTENT_TYPE_TABLE_END)){
	$CONTENT_TYPE_TABLE_END = "
	</table>";
}
// ##### ----------------------------------------------------------------------

?>