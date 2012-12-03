global $sql, $tp, $ns;
$menu = $parm;

$path = $tp -> toDB(dirname($menu));
$name = $tp -> toDB(basename($menu));
$plugin_file = "";
if($path == '.')
{
	$path = $menu;
}
if($sql->db_Select('menus','menu_id, menu_pages',"menu_name = '$name' AND (menu_path = '".$path."/' OR menu_path = '".$path."') AND menu_class IN (".USERCLASS_LIST.")"))
{
	$row = $sql->db_Fetch();
	$show_menu = TRUE;
	if($row['menu_pages']){
		list($listtype,$listpages) = explode("-",$row['menu_pages']);
		$pagelist = explode("|",$listpages);
		$check_url = e_SELF."?".e_QUERY;
		if($listtype == '1')  //show menu
		{
			$show_menu = FALSE;
			foreach($pagelist as $p)
			{
				if(strpos($check_url,$p) !== FALSE)
				{
					$show_menu = TRUE;
				}
			}
		}
		elseif($listtype == '2')  //hide menu
		{
			$show_menu = TRUE;
			foreach($pagelist as $p)
			{
				if(strpos($check_url,$p) !== FALSE)
				{
					$show_menu = FALSE;
				}
			}
		}
	}

	if($show_menu) {
		$sql->db_Mark_Time($name);
		if($path != 'custom')
		{
			if(is_readable(e_PLUGIN.$path."/languages/".e_LANGUAGE.".php")){
				include_once(e_PLUGIN.$path."/languages/".e_LANGUAGE.".php");
			}
			if(e_LANGUAGE != 'English' && is_readable(e_PLUGIN.$path."/languages/English.php")){
				include_once(e_PLUGIN.$path."/languages/English.php");
			}
		}
		$plugin_file = e_PLUGIN.$path."/".$name.".php";
	}
}
else
{
	if(is_readable(e_PLUGIN.$path."/".$name.".php"))
	{
		$sql->db_Mark_Time($name);
		include_lan(e_PLUGIN.$path."/languages/".e_LANGUAGE.".php");
		$plugin_file = e_PLUGIN.$path."/".$name.".php";
	}
}

if($plugin_file != "")
{
	ob_start();
	include(e_PLUGIN.$path."/".$name.".php");
	$buff = ob_get_contents();
	ob_end_clean();
	$sql->db_Mark_Time("(After $name)");
	return $buff;
}
