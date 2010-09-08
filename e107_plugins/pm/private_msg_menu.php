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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/pm/private_msg_menu.php $
|     $Revision: 11678 $
|     $Id: private_msg_menu.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

global $sysprefs, $pref, $pm_prefs;
if (!isset($pref['plug_installed']['pm']))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

if(!isset($pm_prefs['perpage']))
{
	$pm_prefs = $sysprefs->getArray('pm_prefs');
}
require_once(e_PLUGIN.'pm/pm_func.php');
pm_getInfo('clear');

define("PM_INBOX_ICON", "<img src='".e_PLUGIN_ABS."pm/images/mail_get.png' style='height:16px; width:16px; border:0px;' alt='".LAN_PM_25."' title='".LAN_PM_25."' />");
define("PM_OUTBOX_ICON", "<img src='".e_PLUGIN_ABS."pm/images/mail_send.png' style='height:16px; width:16px; border:0px;' alt='".LAN_PM_26."' title='".LAN_PM_26."' />");
define("PM_SEND_LINK", LAN_PM_35);
define("NEWPM_ANIMATION", "<img src='".e_PLUGIN_ABS."pm/images/newpm.gif' alt='' style='border:0' />");

$sc_style['SEND_PM_LINK']['pre'] = "<br /><br />[ ";
$sc_style['SEND_PM_LINK']['post'] = " ]";

$sc_style['INBOX_FILLED']['pre'] = "[";
$sc_style['INBOX_FILLED']['post'] = "%]";

$sc_style['OUTBOX_FILLED']['pre'] = "[";
$sc_style['OUTBOX_FILLED']['post'] = "%]";

$sc_style['NEWPM_ANIMATE']['pre'] = "<a href='".e_PLUGIN_ABS."pm/pm.php?inbox'>";
$sc_style['NEWPM_ANIMATE']['post'] = "</a>";

$sc_style['BLOCKED_SENDERS_MANAGE']['pre'] = "<br />[ <a href='".e_PLUGIN_ABS."pm/pm.php?blocked'>";
$sc_style['BLOCKED_SENDERS_MANAGE']['post'] = '</a> ]';


if(!isset($pm_menu_template))
{
	$pm_menu_template = "
	<a href='".e_PLUGIN_ABS."pm/pm.php?inbox'>".PM_INBOX_ICON."</a>
	<a href='".e_PLUGIN_ABS."pm/pm.php?inbox'>".LAN_PM_25."</a>
	{NEWPM_ANIMATE}
	<br />
	{INBOX_TOTAL} ".LAN_PM_36.", {INBOX_UNREAD} ".LAN_PM_37." {INBOX_FILLED}
	<br />
	<a href='".e_PLUGIN_ABS."pm/pm.php?outbox'>".PM_OUTBOX_ICON."</a>
	<a href='".e_PLUGIN_ABS."pm/pm.php?outbox'>".LAN_PM_26."</a><br />
	{OUTBOX_TOTAL} ".LAN_PM_36.", {OUTBOX_UNREAD} ".LAN_PM_37." {OUTBOX_FILLED}
	{SEND_PM_LINK}
	{BLOCKED_SENDERS_MANAGE}
	";
}


if(check_class($pm_prefs['pm_class']))
{
	global $tp, $pm_inbox;
	$pm_inbox = pm_getInfo('inbox');
	require_once(e_PLUGIN."pm/pm_shortcodes.php");
	$txt = $tp->parseTemplate($pm_menu_template, TRUE, $pm_shortcodes);
	if($pm_inbox['inbox']['new'] > 0 && $pm_prefs['popup'] && strpos(e_SELF, "pm.php") === FALSE && $_COOKIE["pm-alert"] != "ON")
	{
		$txt .= pm_show_popup();
	}
	$ns->tablerender(LAN_PM, $txt, 'pm');
}

function pm_show_popup()
{
	global $pm_inbox, $pm_prefs;
	$alertdelay = intval($pm_prefs['popup_delay']);
	if($alertdelay == 0) { $alertdalay = 60; }
	setcookie("pm-alert", "ON", time()+$alertdelay);
	$popuptext = "
	<html>
		<head>
			<title>".$pm_inbox['inbox']['new']." ".LAN_PM_109."</title>
			<link rel=stylesheet href=" . THEME . "style.css>
		</head>
		<body style=\'padding-left:2px;padding-right:2px; padding:2px; padding-bottom:2px; margin:0px; text-align:center\' marginheight=\'0\' marginleft=\'0\' topmargin=\'0\' leftmargin=\'0\'>
		<table style=\'width:100%; text-align:center; height:99%; padding-bottom:2px\' class=\'bodytable\'>
			<tr>
				<td width=100% >
					<center><b>--- ".LAN_PM." ---</b><br />".$pm_inbox['inbox']['new']." ".LAN_PM_109."<br />".$pm_inbox['inbox']['unread']." ".LAN_PM_37."<br /><br />
					<form>
						<input class=\'button\' type=\'submit\' onclick=\'self.close();\' value = \'".LAN_PM_110."\' />
					</form>
					</center>
				</td>
			</tr>
		</table>
		</body>
	</html> ";
	$popuptext = str_replace("\n", "", $popuptext);
	$popuptext = str_replace("\t", "", $popuptext);
	$text .= "
	<script type='text/javascript'>
	winl=(screen.width-200)/2;
	wint = (screen.height-100)/2;
	winProp = 'width=200,height=100,left='+winl+',top='+wint+',scrollbars=no';
	window.open('javascript:document.write(\"".$popuptext."\");', 'pm_popup', winProp);
	</script >";
	return $text;
}
?>