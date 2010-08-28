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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/usertheme_menu/usertheme_menu.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

if ((USER == TRUE) && check_class(varset($pref['allow_theme_select'],FALSE)))
{
	$allThemes = TRUE;
	if (isset($pref['allowed_themes']))
	{
		$allThemes = FALSE;
		$themeList = explode(',',$pref['allowed_themes']);
	}
	$handle = opendir(e_THEME);
	while ($file = readdir($handle)) 
	{
		if ($file != "." && $file != ".." && $file != "templates" && $file != "" && $file != "CVS") 
		{
			if (is_readable(e_THEME.$file."/theme.php") && is_readable(e_THEME.$file."/style.css") && ($allThemes || in_Array($file, $themeList))) 
			{
				$themelist[] = $file;
				$themecount[$file] = 0;
			}
		}
	}
	closedir($handle);

	if (count($themelist))
	{
		$defaulttheme = $pref['sitetheme'];
		$count = 0;

		$totalct = $sql->db_Select("user", "user_prefs", "user_prefs REGEXP('sitetheme') ");
 
		while ($row = $sql->db_Fetch()) 
		{
			$up = unserialize($row['user_prefs']);
			if (isset($themecount[$up['sitetheme']])) { $themecount[$up['sitetheme']]++; }
		}
 
		$defaultusers = $sql->db_Count("user") - $totalct;
		$themecount[$defaulttheme] += $defaultusers;
	 
		$text = "<form method='post' action='".e_SELF."'>
			<div style='text-align:center'>
			<select name='sitetheme' class='tbox' style='width: 95%;'>";
		$counter = 0;

		while (isset($themelist[$counter]) && $themelist[$counter]) 
		{
			$text .= "<option value='".$themelist[$counter]."' ";
			if (($themelist[$counter] == USERTHEME) || (USERTHEME == FALSE && $themelist[$counter] == $defaulttheme)) 
			{
				$text .= "selected='selected'";
			}
			$text .= ">".($themelist[$counter] == $defaulttheme ? "[ ".$themelist[$counter]." ]" : $themelist[$counter]).' ('.LAN_UMENU_THEME_3.' '.$themecount[$themelist[$counter]].")</option>\n";
			$counter++;
		}
		$text .= "</select>
			<br /><br />
			<input class='button' type='submit' name='settheme' value='".LAN_UMENU_THEME_1."' />
			</div></form>";

		$ns->tablerender(LAN_UMENU_THEME_2, $text, 'usertheme');
	}
}
?>