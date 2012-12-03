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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_languages/English/admin/help/banlist.php $
|     $Revision: 11678 $
|     $Id: banlist.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$caption = "Banning users from your site";
$text = "You can ban users from your site at this screen.<br />
Either enter their full IP address or use a wildcard to ban a range of IP addresses. You can also enter an email address to stop a user registering as a member on your site.<br /><br />
<b>Banning by IP address:</b><br />
Entering the IP address 123.123.123.123 will stop the user with that address visiting your site.<br />
Entering an IP address with one or more wildcards in the end blocks, such as 123.123.123.* or 214.098.*.*, will stop anyone in that IP range from visiting your 
site. (Note that there must be exactly four groups of digits or asterisks)<br /><br />
<b>Banning by email address</b><br />
Entering the email address foo@bar.com will stop anyone using that email address from registering as a member on your site.<br />
Entering the email address *@bar.com will stop anyone using that email domain from registering as a member on your site.<br /><br />
<b>Banning by user name</b><br />
This is done from the user administration page.";
$ns -> tablerender($caption, $text);
?>