if (ADMIN) {
	global $ns, $pref, $e107_plug, $array_functions;
	if (strstr(e_SELF, "/admin.php")) {
		$active_page = 'x';
	} else {
		$active_page = time();
	}
	$e107_var['x']['text']=ADLAN_52;
	$e107_var['x']['link']=e_ADMIN.'admin.php';
	$e107_var['y']['text']=ADLAN_53;
	$e107_var['y']['link']=e_BASE."index.php";

	$text .= show_admin_menu("",$active_page,$e107_var);

	unset($e107_var);
	foreach ($array_functions as $links_key => $links_value) {
		$e107_var[$links_key]['text'] = $links_value[1];
		$e107_var[$links_key]['link'] = $links_value[0];
	}
	$text .= show_admin_menu(ADLAN_93, time(), $e107_var, FALSE, TRUE, TRUE);
	unset($e107_var);
	// Plugin links menu

	$sql = new db;
	if ($sql -> db_Select("plugin", "*", "plugin_installflag=1")) {
		//Link Plugin Manager
		$e107_var['x']['text'] = "<b>".ADLAN_98."</b>";
		$e107_var['x']['link'] = e_ADMIN."plugin.php";
		$e107_var['x']['perm'] = "P";

		while($rowplug = $sql -> db_Fetch()) {
			extract($rowplug);
			$e107_plug[$rowplug[1]] = $rowplug[3];
			include_once(e_PLUGIN.$plugin_path."/plugin.php");

			// Links Plugins
			if ($eplug_conffile) {
				$e107_var['x'.$plugin_id]['text'] = $eplug_caption;
				$e107_var['x'.$plugin_id]['link'] = e_PLUGIN.$plugin_path."/".$eplug_conffile;
				$e107_var['x'.$plugin_id]['perm'] = "P".$plugin_id;
			}
			unset($eplug_conffile, $eplug_name, $eplug_caption);
		}

		$text .= show_admin_menu(ADLAN_95, time(), $e107_var, FALSE, TRUE, TRUE);
		unset($e107_var);
	}
	unset($e107_var);
	$e107_var['x']['text']=ADLAN_46;
	$e107_var['x']['link']=e_ADMIN."admin.php?logout";
	$text .= show_admin_menu("",$act,$e107_var);
	return $ns -> tablerender(LAN_head_1, $text, array('id' => 'admin_nav', 'style' => 'button_menu'), TRUE);
}

