<?php
/*
+ ----------------------------------------------------------------------------+
e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_handlers/message_handler.php $
|     $Revision: 11678 $
|     $Id: message_handler.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

function show_emessage($mode, $message, $line = 0, $file = "") {
	global $tp;
	if(is_numeric($message))
	{
    	include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_error.php");
	$emessage[1] = "<b>".LAN_ERROR_25."</b>";
	$emessage[2] = "<b>".LAN_ERROR_26."</b>";
	$emessage[3] = "<b>".LAN_ERROR_27."</b>";
	$emessage[4] = "<b>".LAN_ERROR_28."</b>";
	$emessage[5] = LAN_ERROR_29;
	$emessage[6] = "<b>".LAN_ERROR_30."</b>";
	$emessage[7] = "<b>".LAN_ERROR_31."</b>";
	$emessage[8] = "
		<div style='text-align:center; font: 12px Verdana, Tahoma'><b>".LAN_ERROR_32." </b><br /><br />
		".chr(36)."ADMIN_DIRECTORY = \"e107_admin/\";<br />
		".chr(36)."FILES_DIRECTORY = \"e107_files/\";<br />
		".chr(36)."IMAGES_DIRECTORY = \"e107_images/\"; <br />
		".chr(36)."THEMES_DIRECTORY = \"e107_themes/\"; <br />
		".chr(36)."PLUGINS_DIRECTORY = \"e107_plugins/\"; <br />
		".chr(36)."HANDLERS_DIRECTORY = \"e107_handlers/\"; <br />
		".chr(36)."LANGUAGES_DIRECTORY = \"e107_languages/\"; <br />
		".chr(36)."HELP_DIRECTORY = \"e107_docs/help/\";  <br />
		".chr(36)."DOWNLOADS_DIRECTORY =  \"e107_files/downloads/\";\n
		</div>";
	}

	if (class_exists('e107table')) {
		$ns = new e107table;
	}
	switch($mode) {
		case "CRITICAL_ERROR":
		$message = $emessage[$message] ? $emessage[$message] : $message;
		echo "<div style='text-align:center; font: 11px verdana, tahoma, arial, helvetica, sans-serif;'><b>CRITICAL_ERROR: </b><br />Line $line $file<br /><br />Error reported as: ".$message."</div>";
		break;

		case "MESSAGE":
		if(strstr(e_SELF, "forum_post.php"))
		{
			return;
		}
		$ns->tablerender("", "<div style='text-align:center'><b>{$message}</b></div>");
		break;

		case "ADMIN_MESSAGE":
		$ns->tablerender("Admin Message", "<div style='text-align:center'><b>{$message}</b></div>");
		break;

		case "ALERT":
		$message = $emessage[$message] ? $emessage[$message] : $message;
		echo "<noscript>$message</noscript><script type='text/javascript'>alert(\"".$tp->toJS($message)."\"); window.history.go(-1); </script>\n"; exit;
		break;

		case "P_ALERT":
		echo "<script type='text/javascript'>alert(\"".$tp->toJS($message)."\"); </script>\n";
		break;

		case "POPUP":

		$mtext = "<html><head><title>Message</title><link rel=stylesheet href=" . THEME . "style.css></head><body style=padding-left:2px;padding-right:2px;padding:2px;padding-bottom:2px;margin:0px;align;center marginheight=0 marginleft=0 topmargin=0 leftmargin=0><table width=100% align=center style=width:100%;height:99%padding-bottom:2px class=bodytable height=99% ><tr><td width=100% ><center><b>--- Message ---</b><br /><br />".$message."<br /><br /><form><input class=button type=submit onclick=self.close() value = ok /></form></center></td></tr></table></body></html> ";

		echo "
		<script type='text/javascript'>
		winl=(screen.width-200)/2;
		wint = (screen.height-100)/2;
		winProp = 'width=200,height=100,left='+winl+',top='+wint+',scrollbars=no';
		window.open('javascript:document.write(\"".$mtext."\");', \"message\", winProp);
		</script >";

		break;

	}
}

?>
