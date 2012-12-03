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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/newsfeed/newsfeed.php $
|     $Id: newsfeed.php 12040 2011-01-14 18:28:57Z e107steved $
+----------------------------------------------------------------------------+
*/
require_once('../../class2.php');
if (!isset($pref['plug_installed']['newsfeed']))
{
	header('Location: '.e_BASE.'index.php');
	exit;
}

include_lan(e_PLUGIN."newsfeed/languages/".e_LANGUAGE.".php");

if(!function_exists("checkUpdate"))
{
	require(e_PLUGIN."newsfeed/newsfeed_functions.php");
}
require_once(HEADERF);

/* get template */
if (file_exists(THEME."newsfeed_template.php"))
{
	require_once(THEME."newsfeed_template.php");
}
else if(!$NEWSFEED_LIST_START)
{
	require_once(e_PLUGIN."newsfeed/templates/newsfeed_template.php");
}

$action = FALSE;
if(e_QUERY)
{
	list($action, $id) = explode(".", e_QUERY);
	$id = intval($id);
}

if($action == "show")
{
	/* 'show' action - show feed */
	checkUpdate();

	if ($feeds = $sql -> db_Select("newsfeed", "*", "(newsfeed_active=2 OR newsfeed_active=3) AND newsfeed_id=$id"))
	{
		$row = $sql->db_Fetch();
		extract ($row);
		list($newsfeed_image, $newsfeed_showmenu, $newsfeed_showmain) = explode("::", $newsfeed_image);				
		$numtoshow = $newsfeed_showmain;
		$numtoshow = (intval($numtoshow) > 0 ? $numtoshow : 999);

		$rss = unserialize($newsfeed_data);

		if(!is_object($rss))
		{
			$text = NFLAN_49;
			$ns->tablerender(NFLAN_01, $text);
			require_once(FOOTERF);
			exit;
		}

		$FEEDNAME = "<a href='".e_SELF."?show.$newsfeed_id'>$newsfeed_name</a>";
		$FEEDDESCRIPTION = $newsfeed_description;
		if($newsfeed_image == "default")
		{
			if($file = fopen ($rss -> image['url'], "r"))
			{
				/* remote image exists - use it! */
				$FEEDIMAGE = "<a href='".$rss -> image['link']."' rel='external'><img src='".$rss -> image['url']."' alt='".$rss -> image['title']."' style='border: 0; vertical-align: middle;' /></a>";
			}
			else
			{
				/* remote image doesn't exist - ghah! */
				$FEEDIMAGE = "";
			}


		}else if ($newsfeed_image)
		{
			$FEEDIMAGE = "<img src='".$newsfeed_image."' alt='' />";
		}
		else
		{
			$FEEDIMAGE = "";
		}
		$FEEDLANGUAGE = $rss -> channel['language'];

		if($rss -> channel['lastbuilddate'])
		{
			$pubbed = $rss -> channel['lastbuilddate'];
		}
		else if($rss -> channel['dc']['date'])
		{
			$pubbed = $rss -> channel['dc']['date'];
		}
		else
		{
			$pubbed = NFLAN_34;
		}

		$FEEDLASTBUILDDATE = NFLAN_33.$pubbed;
		$FEEDCOPYRIGHT = $tp -> toHTML($rss -> channel['copyright'], TRUE);
		$FEEDDOCS = $rss -> channel['docs'];
		$FEEDTITLE = "<a href='".$rss -> channel['link']."' rel='external'>".$rss -> channel['title']."</a>";
		$FEEDLINK = $rss -> channel['link'];

		$data = "";
		
		$i = 0;
		while($i < $numtoshow && $rss->items[$i])
		{
			$item = $rss->items[$i];
//		foreach ($rss -> items as $item)
//		{
	
			if($NEWSFEED_COLLAPSE)
			{
				$FEEDITEMLINK = "<a href='#' onclick='expandit(this)'>".$tp -> toHTML($item['title'], TRUE)."</a>
				<div style='display:none' >
				";
				$FEEDITEMTEXT = preg_replace("/&#091;.*]/", "", $tp -> toHTML($item['description'], TRUE))."
				<br /><br /><a href='".$item['link']."' rel='external'>".NFLAN_44."</a><br /><br />
				</div>";
			}
			else
			{
				$FEEDITEMLINK = "<a href='".$item['link']."' rel='external'>".$tp -> toHTML($item['title'], TRUE)."</a>\n";
				$FEEDITEMLINK = str_replace('&', '&amp;', $FEEDITEMLINK);
				$feeditemtext = preg_replace("#\[[a-z0-9=]+\]|\[\/[a-z]+\]|\{[A-Z_]+\}#si", "", $item['description']);
				$FEEDITEMTEXT = $tp -> toHTML($feeditemtext, TRUE)."\n";
			}
			$FEEDITEMCREATOR = $tp -> toHTML($item['author'], TRUE);
			$data .= preg_replace("/\{(.*?)\}/e", '$\1', $NEWSFEED_MAIN);
			$i++;
		}
		$BACKLINK = "<a href='".e_SELF."'>".NFLAN_31."</a>";
		$text = preg_replace("/\{(.*?)\}/e", '$\1', $NEWSFEED_MAIN_START) . $data . preg_replace("/\{(.*?)\}/e", '$\1', $NEWSFEED_MAIN_END);
		$ns->tablerender(NFLAN_01, $text);
		require_once(FOOTERF);
		exit;
	}
}
	
/* no action - display feed list ... */
if ($feeds = $sql -> db_Select("newsfeed", "*", "newsfeed_active=2 OR newsfeed_active=3"))
{
	$data = "";
	while ($row = $sql->db_Fetch())
	{
		extract($row);
		$FEEDNAME = "<a href='".e_SELF."?show.$newsfeed_id'>$newsfeed_name</a>";
		$FEEDDESCRIPTION = ((!$newsfeed_description || $newsfeed_description == "default") ? "&nbsp;" : $newsfeed_description);
		$FEEDIMAGE = $newsfeed_image;
		$data .= preg_replace("/\{(.*?)\}/e", '$\1', $NEWSFEED_LIST);
	}
}

$text = $NEWSFEED_LIST_START . $data . $NEWSFEED_LIST_END;
$ns->tablerender(NFLAN_29, $text);
require_once(FOOTERF);

?>
