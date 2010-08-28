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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/calendar_menu/e_notify.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
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