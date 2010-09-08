<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/rss_menu/e_meta.php $
|     $Revision: 11678 $
|     $Id: e_meta.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

global $tp,$PLUGINS_DIRECTORY;

	if($sql->db_Select("rss", "*", "rss_class='0' AND rss_limit>0 ORDER BY rss_name"))
	{
   		while($row=$sql->db_Fetch()){
	  		//wildcard topic_id's should not be listed
	   		if(strpos($row['rss_url'], "*")===FALSE){
		  		$url = SITEURL.$PLUGINS_DIRECTORY."rss_menu/rss.php?".$tp->toHTML($row['rss_url'], TRUE, 'constants, no_hook, emotes_off').".2";
				$url .= ($row['rss_topicid']) ? ".".$row['rss_topicid'] : "";
		  		$name = $tp->toHTML($row['rss_name'], TRUE, 'no_hook, emotes_off');
		   		echo "<link rel='alternate' type='application/rss+xml' title='".htmlspecialchars(SITENAME, ENT_QUOTES, CHARSET)." ".htmlspecialchars($name, ENT_QUOTES, CHARSET)."' href='".$url."' />\n";
			}
		}
	}

?>