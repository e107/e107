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
|     $Source: /cvs_backup/e107_0.7/e107_plugins/admin_menu/admin_menu.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }
global $tp;
if (ADMIN == TRUE)
{
	// We're not in admin - load generic admin phrases
	include_lan(e_LANGUAGEDIR.e_LANGUAGE.'/admin/lan_admin.php');

	require_once(e_HANDLER."userclass_class.php");
	require_once(e_ADMIN."ad_links.php");
	require_once(e_HANDLER.'admin_handler.php');

	$array_functions[] = array(e_ADMIN."plugin.php", ADLAN_98, "Z");

	if ($sql->db_Select("plugin", "*", "plugin_installflag=1")) {
		while ($row = $sql->db_Fetch()) {
			include(e_PLUGIN.$row['plugin_path']."/plugin.php");
			if ($eplug_conffile) {
				$array_functions[] = array(e_PLUGIN.$row['plugin_path']."/".$eplug_conffile, $tp->toHtml($eplug_name,"","defs,emotes_off, no_make_clickable"), "P".$row['plugin_id']);
			}
			unset($eplug_conffile, $eplug_name, $eplug_caption, $eplug_icon_small);
		}
	}

	$array_functions = asortbyindex($array_functions, 1);

	$amtext = "<div style='text-align:center'>
	<select name='activate' onchange='urljump(this.options[selectedIndex].value)' class='tbox'>
	<option>".LAN_SELECT."</option>\n";
	foreach ($array_functions as $link_value) {
		$amtext .= render_admin_links($link_value[0], $link_value[1], $link_value[2]);
	}

	$amtext .= "</select>
	</div>";
	$ns->tablerender(LAN_ADMIN, $amtext, 'admin_menu');
}

function render_admin_links($link, $title, $perms)
{
	if (getperms($perms))
	{
		return "<option value='".$link."'>".$title."</option>";
	}
}
?>