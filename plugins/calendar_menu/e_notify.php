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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/calendar_menu/e_notify.php $
|     $Revision: 11678 $
|     $Id: e_notify.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

if(defined('ADMIN_PAGE') && ADMIN_PAGE === true)
{
	include_lan(e_PLUGIN."calendar_menu/languages/".e_LANGUAGE.".php");
	$config_category = NT_LAN_EC_1;
	$config_events = array('ecalnew' => NT_LAN_EC_7, 'ecaledit' => NT_LAN_EC_2);
}

if (!function_exists('notify_ecalnew'))
{
	function notify_ecalnew($data) {
		global $nt;
		include_lan(e_PLUGIN."calendar_menu/languages/".e_LANGUAGE.".php");
		$message = NT_LAN_EC_3.': '.USERNAME.' ('.NT_LAN_EC_4.': '.$data['ip'].' )<br />';
		$message .= NT_LAN_EC_5.':<br />'.$data['cmessage'].'<br /><br />';
		$nt -> send('ecaledit', NT_LAN_EC_6, $message);
	}
}

if (!function_exists('notify_ecaledit')) {
	function notify_ecaledit($data) {
		global $nt;
		include_lan(e_PLUGIN."calendar_menu/languages/".e_LANGUAGE.".php");
		$message = NT_LAN_EC_3.': '.USERNAME.' ('.NT_LAN_EC_4.': '.$data['ip'].' )<br />';
		$message .= NT_LAN_EC_5.':<br />'.$data['cmessage'].'<br /><br />';
		$nt -> send('ecaledit', NT_LAN_EC_8, $message);
	}
}




?>