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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/forum/e_linkgen.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// Usage: sublink_type[x]['title'].
//  x should be the same as the plugin folder.

include_lan(e_PLUGIN."forum/languages/".e_LANGUAGE."/lan_forum_admin.php");

	$sublink_type['forum']['title'] = FORLAN_155; // "News Categories";
	$sublink_type['forum']['table'] = "forum";
	$sublink_type['forum']['query'] = "forum_parent !='0' ORDER BY forum_order ASC";
    $sublink_type['forum']['url'] = "{e_PLUGIN}forum/forum_viewforum.php?#";
	$sublink_type['forum']['fieldid'] = "forum_id";
	$sublink_type['forum']['fieldname'] = "forum_name";
	$sublink_type['forum']['fielddiz'] = "forum_description";


?>