if(ADMIN){
	global $ns;
	$i=1;
	if (!$handle=opendir(e_DOCS.e_LANGUAGE."/")) {
	 $handle=opendir(e_DOCS."English/");
	}
	while ($file = readdir($handle)){
	        if($file != "." && $file != ".." && $file != "CVS"){
	                $helplist[$i] = $file;
	                $i++;
	        }
	}
	closedir($handle);

	unset($e107_var);
	foreach ($helplist as $key => $value) {
	        $e107_var['x'.$key]['text'] = str_replace("_", " ", $value);
	        $e107_var['x'.$key]['link'] = e_ADMIN."docs.php?".$key;
	}

	$text = show_admin_menu(FOOTLAN_14, $act, $e107_var, FALSE, TRUE, TRUE);
	return $ns -> tablerender(FOOTLAN_14,$text, array('id' => 'admin_docs', 'style' => 'button_menu'), TRUE);
}

