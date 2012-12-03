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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/templates/sitedown_template.php $
|     $Revision: 11678 $
|     $Id: sitedown_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// ##### SITEDOWN TABLE -----------------------------------------------------------------
if(!isset($SITEDOWN_TABLE))
{
	$SITEDOWN_TABLE = (defined("STANDARDS_MODE") ? "" : "<?xml version='1.0' encoding='".CHARSET."' "."?".">")."<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
	";
	$SITEDOWN_TABLE .= "
    <html xmlns='http://www.w3.org/1999/xhtml'".(defined("TEXTDIRECTION") ? " dir='".TEXTDIRECTION."'" : "").(defined("CORE_LC") ? " xml:lang=\"".CORE_LC."\"" : "").">
	<head>
		<meta http-equiv='content-type' content='text/html; charset=".CHARSET."' />
		<meta http-equiv='content-style-type' content='text/css' />\n
		<link rel='stylesheet' href='".THEME_ABS."style.css' type='text/css' media='all' />
		<title>{SITEDOWN_TABLE_PAGENAME}</title>
	</head>
	<body>
		<div style='text-align:center;font-size: 14px; color: black; font-family: Tahoma, Verdana, Arial, Helvetica; text-decoration: none'>
		<div style='text-align:center'>{LOGO}</div>
		<hr />
		<br />
		{SITEDOWN_TABLE_MAINTAINANCETEXT}
		</div>
	</body>
	</html>";
}
// ##### ------------------------------------------------------------------------------------------

?>
