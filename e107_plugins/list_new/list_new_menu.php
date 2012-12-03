<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/list_new/list_new_menu.php $
|     $Revision: 12126 $
|     $Id: list_new_menu.php 12126 2011-04-10 21:27:12Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

if (!isset($pref['plug_installed']['list_new']))
{
    return;
}

global $sysprefs, $tp, $eArrayStorage, $list_pref, $rc;
$listplugindir = e_PLUGIN . "list_new/";
unset($text);
require_once($listplugindir."list_shortcodes.php");

// get language file
include_lan($listplugindir . "languages/" . e_LANGUAGE . ".php");

if (!is_object($rc))
{
    require_once($listplugindir . "list_class.php");
    $rc = new listclass;
}

if(!isset($list_pref))
{
	$list_pref = $rc->getListPrefs();
}

$mode = "new_menu";
$sections = $rc->prepareSection($mode);
$arr = $rc->prepareSectionArray($mode, $sections);
// display the sections
$text = "";
for($i = 0;$i < count($arr);$i++)
{
    if ($arr[$i][1] == "1")
    {
        $sectiontext = $rc->show_section_list($arr[$i], $mode);
        if ($sectiontext != "")
        {
            $text .= $sectiontext;
        }
    }
}

$caption = (isset($list_pref[$mode."_caption"]) && $list_pref[$mode."_caption"] ? $list_pref[$mode."_caption"] : LIST_MENU_1);
$caption = $tp->toHtml($caption, FALSE, 'USER_TITLE');
$text = $tp->toHtml($text, TRUE, 'USER_BODY');
$ns->tablerender($caption, $text, 'list_new');
unset($caption);
unset($text);

?>