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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/list_new/list.php $
|     $Revision: 11678 $
|     $Id: list.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
require_once("../../class2.php");

$listplugindir = e_PLUGIN."list_new/";

//get language file
include_lan($listplugindir."languages/".e_LANGUAGE.".php");

if(!isset($pref['plug_installed']['list_new']))
{
	require_once(HEADERF);
	$ns -> tablerender("", LIST_PLUGIN_6);
	require_once(FOOTERF);
	exit;
}

require_once($listplugindir."list_shortcodes.php");
if (!is_object($rc))
{
    require_once($listplugindir . "list_class.php");
    $rc = new listclass;
}

require_once(e_HANDLER."form_handler.php");
$rs = new form;
e107_require_once(e_HANDLER.'arraystorage_class.php');
$eArrayStorage = new ArrayData();

unset($text);

require_once(HEADERF);

global $tp,$list_pref;

// check query
if(e_QUERY)
{
	$qs = explode(".", e_QUERY);
	if($qs[0] == "new")
	{
		$mode = $qs[0];
	}
}

if(isset($mode) && $mode == "new")
{
	$mode = "new_page";
}
else
{
	$mode = "recent_page";	//default to 'page'
}

if(!isset($list_pref))
{
	$list_pref = $rc->getListPrefs();
}
$sections	= $rc -> prepareSection($mode);
$arr		= $rc -> prepareSectionArray($mode, $sections);

$text = "";
$timelapse = 0;
if(isset($qs[0]) && $qs[0] == "new")
{
	if(isset($list_pref['new_page_timelapse']) && $list_pref['new_page_timelapse']){
		if(isset($list_pref['new_page_timelapse_days']) && is_numeric($list_pref['new_page_timelapse_days'])){
			$days = $list_pref['new_page_timelapse_days'];
		}else{
			$days = "30";
		}
		if(isset($qs[1]) && is_numeric($qs[1]) && $qs[1] <= $days){
			$timelapse = $qs[1];
		}
		$url		= e_PLUGIN."list_new/list.php?new";
		$selectjs	= "onchange=\"if(this.options[this.selectedIndex].value != 'none'){ return document.location=this.options[this.selectedIndex].value; }\"";

		$LIST_TIMELAPSE = LIST_MENU_6;
		$LIST_TIMELAPSE .= $rs -> form_select_open("timelapse", $selectjs).$rs -> form_option(LIST_MENU_5, 0, $url);
		for($a=1; $a<=$days; $a++){
			$LIST_TIMELAPSE .= $rs -> form_option($a, ($timelapse == $a ? "1" : "0"), $url.".".$a);
		}
		$LIST_TIMELAPSE .= $rs -> form_select_close();
		$text .= preg_replace("/\{(.*?)\}/e", '$\1', $LIST_TIMELAPSE_TABLE);
	}
}



//display the sections
$LIST_COL_COLS = $list_pref[$mode."_colomn"];

$LIST_COL_CELLWIDTH = round((100/$list_pref[$mode."_colomn"]),0);
$text .= $LIST_COL_START;

if($list_pref[$mode."_welcometext"])
{
	$LIST_COL_WELCOMETEXT = $tp -> toHTML($list_pref[$mode."_welcometext"]);
	$text .= preg_replace("/\{(.*?)\}/e", '$\1', $LIST_COL_WELCOME);
}
$k=0;
for($i=0;$i<count($arr);$i++)
{
	unset($rowswitch);
	if($arr[$i][1] == "1")
	{
		$sectiontext = $rc -> show_section_list($arr[$i], $mode);
		if($sectiontext != "")
		{
			if( intval($k/$list_pref[$mode."_colomn"]) == $k/$list_pref[$mode."_colomn"] )
			{
				$rowswitch = $LIST_COL_ROWSWITCH;
			}
			$text .= (isset($rowswitch) ? $rowswitch : "");
			$text .= preg_replace("/\{(.*?)\}/e", '$\1', $LIST_COL_CELL_START);
			$text .= $sectiontext;
			$text .= $LIST_COL_CELL_END;
			$k++;
		}
	}
}
$text .= $LIST_COL_END;

$caption = (isset($list_pref[$mode."_caption"]) && $list_pref[$mode."_caption"] ? $list_pref[$mode."_caption"] : LIST_MENU_1);
$ns -> tablerender($caption, $text);
unset($text);

require_once(FOOTERF);

?>