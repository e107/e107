// $Id: admin_preset.sc 11836 2010-09-30 21:43:10Z e107coders $
//<?
if(ADMIN && getperms("0"))
{
	global $sql,$pst,$ns,$tp,$e_wysiwyg,$pref;
	if(isset($pst) && $pst->form && $pst->page){
		$thispage = urlencode(e_SELF."?".e_QUERY);
		if(is_array($pst->page)){
		for ($i=0; $i<count($pst->page); $i++) {
			if (strpos($thispage, urlencode($pst->page[$i])) !== FALSE){
				$query = urlencode($pst->page[$i]);
				$theform = $pst->form[$i];
				$pid = $i;
				}
			}
		}else{
			$query = urlencode($pst->page);
			$theform = $pst->form;
			$pid = 0;
		}

		$existing = is_array($pst->id) ? $pst->id[$pid] : $pst->id;
        $trigger = ($e_wysiwyg && $pref['wysiwyg']) ? "tinyMCE.triggerSave();" : "";


		 if (strpos($thispage, $query) !== FALSE) {
			$pst_text = "
			<form method='post' action='".e_SELF."?clr_preset' id='e_preset' >
			<div style='text-align:center'>";
			if(!$sql->db_Count("preset", "(*)", " WHERE preset_name='".$tp -> toDB($existing, true)."'  ")){
				$pst_text .= "<input type='button' class='button' name='save_preset' value='".LAN_SAVE."' onclick=\"$trigger savepreset('".$theform."',$pid)\" />";
			}else{
				$pst_text .= "<input type='button' class='button' name='save_preset' value='".LAN_UPDATE."' onclick=\"$trigger savepreset('".$theform."',$pid)\" />";
				$pst_text .= "<input type='hidden' name='del_id' value='$pid' />
				<input type='submit' class='button' name='delete_preset' value='".LAN_DELETE."' onclick=\"return jsconfirm('".$tp->toJS(LAN_PRESET_CONFIRMDEL." [".$existing."]")."')\" />";
			}
			$pst_text .= "</div></form>";
			return $ns -> tablerender(LAN_PRESET, $pst_text, 'admin_preset', TRUE);
		}
	}
}