<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_files/shortcode/batch/sitedown_shortcodes.php $
|     $Revision: 11678 $
|     $Id: sitedown_shortcodes.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit(); }
include_once(e_HANDLER.'shortcode_handler.php');
$sitedown_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);
/*

SC_BEGIN SITEDOWN_TABLE_MAINTAINANCETEXT
global $pref, $tp;
if($pref['maintainance_text'])
{
	return $tp->toHTML($pref['maintainance_text'], TRUE, 'parse_sc', 'admin');
}
else
{
	return "<b>- ".SITENAME." ".LAN_SITEDOWN_00." -</b><br /><br />".LAN_SITEDOWN_01 ;
}
SC_END


SC_BEGIN SITEDOWN_TABLE_PAGENAME
return PAGE_NAME;
SC_END

*/
?>