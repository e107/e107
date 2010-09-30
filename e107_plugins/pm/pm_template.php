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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/pm/pm_template.php $
|     $Revision: 11779 $
|     $Id: pm_template.php 11779 2010-09-11 19:02:46Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

global $sc_style;

define("PM_READ_ICON", "<img src='".e_PLUGIN_ABS."pm/images/read.png' style='height:16px; width:16px; border:0px' alt='".LAN_PM_111."' />");
define("PM_UNREAD_ICON", "<img src='".e_PLUGIN_ABS."pm/images/unread.png' style='height:16px; width:16px; border:0px' alt='".LAN_PM_27."' />");

$sc_style['PM_ATTACHMENT_ICON']['pre'] = " ";

$sc_style['PM_ATTACHMENTS']['pre'] = "<br /><div style='vertical-align:bottom; text-align:left;'>";
$sc_style['PM_ATTACHMENTS']['post'] = "</div>";

$sc_style['PM_NEXTPREV']['pre'] = "<tr><td class='forumheader' colspan='6' style='text-align:left'> ";
$sc_style['PM_NEXTPREV']['post'] = "</td></tr>";

$sc_style['EMOTES']['pre'] = "
<tr>
	<td class='forumheader3'>".LAN_PM_7.": </td>
	<td class='forumheader3'>
";
$sc_style['EMOTES']['post'] = "</td></tr>";

$sc_style['ATTACHMENT']['pre'] = "
<tr>
	<td class='forumheader3'>".LAN_PM_8.": </td>
	<td class='forumheader3'>
";
$sc_style['ATTACHMENT']['post'] = "</td></tr>";

$sc_style['RECEIPT']['pre'] = "
<tr>
	<td class='forumheader3'>".LAN_PM_9.": </td>
	<td class='forumheader3'>
";
$sc_style['RECEIPT']['post'] = "</td></tr>";

$sc_style['PM_REPLY']['pre'] = "<tr>
	<td class='forumheader' style='text-align:center' colspan='2'>
";

$sc_style['PM_REPLY']['post'] = "</td>
	</tr>
";

$PM_SEND_PM = "<div style='text-align: center'>
<table style='width:95%' class='fborder'>
<tr>
	<td colspan='2' class='fcaption'>".LAN_PM_1.": </td>
</tr>
<tr>
	<td class='forumheader3' style='width: 30%'>".LAN_PM_2.": </td>
	<td class='forumheader3' style='width: 70%; text-align:left'>{FORM_TOUSER}<br />{FORM_TOCLASS}</td>
</tr>
<tr>
	<td class='forumheader3'>".LAN_PM_5.": </td>
	<td class='forumheader3'>{FORM_SUBJECT}</td>
</tr>
<tr>
	<td class='forumheader3'>".LAN_PM_6.": </td>
	<td class='forumheader3'>{FORM_MESSAGE}</td>
</tr>
{EMOTES}
{ATTACHMENT}
{RECEIPT}
<tr>
	<td class='forumheader' colspan='2' style='text-align:center;'>{PM_POST_BUTTON}</td>
</tr>
</table>
</div>
";

$PM_INBOX_HEADER = "
<table class='fborder' style='width:95%'>
<tr>
	<td class='fcaption' style='width:1%'>{PM_CHECK_ALL_NONE}</td>
	<td class='fcaption' style='width:1%'>&nbsp;</td>
	<td class='fcaption' style='width:38%'>".LAN_PM_5."</td>
	<td class='fcaption' style='width:22%'>".LAN_PM_31."</td>
	<td class='fcaption' style='width:30%'>".LAN_PM_32."</td>
	<td class='fcaption' style='width:8%'>&nbsp;</td>
</tr>
";

$PM_INBOX_TABLE = "
<tr>
	<td class='forumheader3'>{PM_SELECT}</td>
	<td class='forumheader3'>{PM_READ_ICON}</td>
	<td class='forumheader3'>{PM_SUBJECT=link,inbox}{PM_ATTACHMENT_ICON}</td>
	<td class='forumheader3'>{PM_FROM=link}</td>
	<td class='forumheader3'>{PM_DATE}</td>
	<td class='forumheader3' style='text-align: center; white-space: nowrap'>{PM_DELETE=inbox}&nbsp;{PM_BLOCK_USER}</td>
</tr>
";

$PM_INBOX_EMPTY = "
<tr>
	<td colspan='6' class='forumheader'>".LAN_PM_34."</td>
</tr>
";

$PM_INBOX_FOOTER = "
<tr>
	<td class='forumheader' colspan='6' style='text-align:center'>
	<input type='hidden' name='pm_come_from' value='inbox' />
	{DELETE_SELECTED}
	</td>
</tr>
{PM_NEXTPREV=inbox}
</table>
";

$PM_OUTBOX_HEADER = "
<table class='fborder' style='width:95%'>
<tr>
	<td class='fcaption' style='width:1%'>{PM_CHECK_ALL_NONE}</td>
	<td class='fcaption' style='width:1%'>&nbsp;</td>
	<td class='fcaption' style='width:38%'>".LAN_PM_5."</td>
	<td class='fcaption' style='width:22%'>".LAN_PM_2."</td>
	<td class='fcaption' style='width:30%'>".LAN_PM_33."</td>
	<td class='fcaption' style='width:8%'>&nbsp;</td>
</tr>
";

$PM_OUTBOX_TABLE = "
<tr>
	<td class='forumheader3'>{PM_SELECT}</td>
	<td class='forumheader3'>{PM_READ_ICON}</td>
	<td class='forumheader3'>{PM_SUBJECT=link,outbox}{PM_ATTACHMENT_ICON}</td>
		<td class='forumheader3'>{PM_TO=link}</td>
	<td class='forumheader3'>{PM_DATE}</td>
	<td class='forumheader3' style='text-align: center'>{PM_DELETE=outbox}</td>
</tr>
";

$PM_OUTBOX_EMPTY = "
<tr>
	<td colspan='6' class='forumheader'>".LAN_PM_34."</td>
</tr>
";

$PM_OUTBOX_FOOTER = "
<tr>
	<td class='forumheader' colspan='6' style='text-align:center'>
	<input type='hidden' name='pm_come_from' value='outbox' />
	{DELETE_SELECTED}
	</td>
</tr>
{PM_NEXTPREV=outbox}
</table>
";


$PM_BLOCKED_HEADER = "
<table class='fborder' style='width:95%'>
<tr>
	<td class='fcaption' style='width:5%'>&nbsp;</td>
	<td class='fcaption' style='width:48%'>".LAN_PM_68."</td>
	<td class='fcaption' style='width:42%'>".LAN_PM_69."</td>
	<td class='fcaption' style='width:5%'>&nbsp;</td>
</tr>
";

$PM_BLOCKED_TABLE = "
<tr>
	<td class='forumheader3'>{PM_BLOCKED_SELECT}</td>
	<td class='forumheader3'>{PM_BLOCKED_USER=link}</td>
	<td class='forumheader3'>{PM_BLOCKED_DATE}</td>
	<td class='forumheader3' style='text-align: center'>{PM_BLOCKED_DELETE}</td>
</tr>
";

$PM_BLOCKED_EMPTY = "
<tr>
	<td colspan='4' class='forumheader'>".LAN_PM_67."</td>
</tr>
";

$PM_BLOCKED_FOOTER = "
<tr>
	<td class='forumheader' colspan='4' style='text-align:center'>
	{DELETE_BLOCKED_SELECTED}
	</td>
</tr>
</table>
";



$PM_SHOW =
"<div style='text-align: center'>
<table class='fborder' style='width:95%'>
<tr>
	<td class='fcaption' colspan='2'>{PM_SUBJECT}</td>
</tr>
<tr>
	<td class='forumheader3' style='width:20%; vertical-align:top'>
		{PM_FROM_TO}
		<br />
		<br />
		<span class='smalltext'>".LAN_PM_29.":<br />{PM_DATE}</span>
		<br />
		<br />
		<span class='smalltext'>".LAN_PM_30.":<br />{PM_READ}</span>
		<br />
		<br />
		{PM_DELETE}
	</td>
	<td class='forumheader3' style='width:80%; vertical-align:top'>{PM_MESSAGE}<br /><br />{PM_ATTACHMENTS}</td>
</tr>
{PM_REPLY}
</table>
</div>
";

?>