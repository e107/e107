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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/newsfeed/templates/newsfeed_template.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$NEWSFEED_MAIN_CAPTION = NFLAN_38;

$NEWSFEED_LIST_START = "
<table style='width: 100%;' class='fborder'>\n";

$NEWSFEED_LIST = "
<tr>
<td style='width: 30%;' class='forumheader3'>{FEEDNAME}</td>
<td style='width: 70%;' class='forumheader3'>{FEEDDESCRIPTION}</td>
</tr>\n";

$NEWSFEED_LIST_END = "
</table>\n";

$NEWSFEED_MAIN_START = "
<table style='width: 100%;' class='fborder'>
<tr>
<td class='forumheader'>{FEEDIMAGE} {FEEDTITLE}</td>
</tr>
<tr>
<td class='forumheader3'>
<ul>\n";

$NEWSFEED_MAIN = "
<li><b>{FEEDITEMLINK}</b> <span class='smalltext'>{FEEDITEMCREATOR}</span><br />{FEEDITEMTEXT}<br /><br /></li>\n";


$NEWSFEED_MAIN_END = "
</ul>
</td>
</tr>

<tr>
<td class='forumheader3' style='text-align: right;'><span class='smalltext'>{FEEDCOPYRIGHT} | {FEEDLASTBUILDDATE}</span></td>
</tr>

<tr>
<td class='forumheader3' style='text-align: center;'><span class='smalltext'>{BACKLINK}</span></td>
</tr>
</table>\n";


?>
