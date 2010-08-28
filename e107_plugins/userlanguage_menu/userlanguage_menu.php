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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/userlanguage_menu/userlanguage_menu.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if ( ! defined('e107_INIT')) { exit(); }

require_once(e_HANDLER.'language_class.php');
$slng = new language;

$languageList = explode(',', e_LANLIST);
sort($languageList);

if(varset($pref['multilanguage_subdomain']))
{
	$action = (e_QUERY) ? e_SELF.'?'.e_QUERY : e_SELF;
	$text = '
	<form method="post" action="'.$action.'">
		<div style="text-align:center">
			<select class="tbox" name="lang_select" style="width:95%" onchange="location.href=this.options[selectedIndex].value">';
	foreach($languageList as $languageFolder)
	{
		$selected = ($languageFolder == e_LANGUAGE) ? ' selected="selected"' : '';
		$urlval   = $slng->subdomainUrl($languageFolder);
		$text .= '
				<option value="'.$urlval.'"'.$selected.'>'.$languageFolder.'</option>';
	}
	$text .= '
			</select>
		</div>
	</form>';
}
else
{
	//FIXME may not work with session
	$action = (e_QUERY && ! $_GET['elan']) ? e_SELF.'?'.e_QUERY : e_SELF;
	$text = '
	<form method="post" action="'.$action.'">
		<div style="text-align:center">
			<select name="sitelanguage" class="tbox">';
	foreach($languageList as $languageFolder)
	{
		$selected = ($languageFolder == e_LANGUAGE) ? ' selected="selected"' : '';
		$text .= '
				<option value="'.$languageFolder.'"'.$selected.'>'.$languageFolder.'</option>';
	}

	$text .= '
			</select>
			<br />
			<br />
			<button class="button" type="submit" name="setlanguage"><span>'.UTHEME_MENU_L1.'</span></button>';
	$text .= '
		</div>
	</form>';
}

$ns->tablerender(UTHEME_MENU_L2, $text, 'user_lan');

?>