<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     (C)Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvs_backup/e107_0.7/e107_plugins/newforumposts_main/admin_config.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/
require_once("../../class2.php");

if (!getperms("1")) {
	header("location:".e_BASE."index.php");
	 exit ;
}
require_once(e_HANDLER."userclass_class.php");
	
include_lan(e_PLUGIN."newforumposts_main/languages/".e_LANGUAGE.".php");
require_once(e_ADMIN."auth.php");
	
if (isset($_POST['updatesettings'])) {
	$pref['nfp_display'] = $_POST['nfp_display'];
	$pref['nfp_caption'] = $_POST['nfp_caption'];
	$pref['nfp_amount'] = $_POST['nfp_amount'];
	$pref['nfp_layer'] = $_POST['nfp_layer'];
	$pref['nfp_posts'] = $_POST['nfp_posts'];
	$pref['nfp_layer_height'] = ($_POST['nfp_layer_height'] ? $_POST['nfp_layer_height'] : 200);
	save_prefs();
	$message = "".NFPM_L14."";
}
	
if ($message) {
	$ns->tablerender("", "<div style='text-align:center'><b>$message</b></div>");
}
	
	
	
$text = "<div style='text-align:center'>
	<form method='post' action='".e_SELF."?".e_QUERY."' id='menu_conf_form'>
	<table style='width:85%' class='fborder'>
	 
	<tr>
	<td style='width:40%' class='forumheader3'>".NFPM_L4."</td>
	<td style='width:60%' class='forumheader3'>
	<select class='tbox' name='nfp_display'>" .($pref['nfp_display'] == "0" ? "<option value='0' selected='selected'>".NFPM_L5."</option>" : "<option value='0'>".NFPM_L5."</option>")
.($pref['nfp_display'] == "1" ? "<option value='1' selected='selected'>".NFPM_L6."</option>" : "<option value='1'>".NFPM_L6."</option>")
.($pref['nfp_display'] == "2" ? "<option value='2' selected='selected'>".NFPM_L7."</option>" : "<option value='2'>".NFPM_L7."</option>")
."</select>
	</td>
	</tr>
	 
	<tr>
	<td style='width:40%' class='forumheader3'>".NFPM_L8.": </td>
	<td style='width:60%' class='forumheader3'>
	<input class='tbox' type='text' name='nfp_caption' size='20' value='".$pref['nfp_caption']."' maxlength='100' />
	</td>
	</tr>
	 
	<tr>
	<td style='width:40%' class='forumheader3'>".NFPM_L9.": </td>
	<td style='width:60%' class='forumheader3'>
	<input class='tbox' type='text' name='nfp_amount' size='6' value='".$pref['nfp_amount']."' maxlength='3' />
	</td>
	</tr>
	 
	<tr>
	<td class='forumheader3' style='width:40%'>".NFPM_L15." </td>
	<td class='forumheader3' style='width:60%'>". ($pref['nfp_posts'] ? "<input type='checkbox' name='nfp_posts' value='1' checked='checked' />" : "<input type='checkbox' name='nfp_posts' value='1' />")."
	</td>
	</tr>
	 
	<tr>
	<td class='forumheader3' style='width:40%'>".NFPM_L10.": </td>
	<td class='forumheader3' style='width:60%'>". ($pref['nfp_layer'] ? "<input type='checkbox' name='nfp_layer' value='1' checked='checked' />" : "<input type='checkbox' name='nfp_layer' value='1' />")."&nbsp;&nbsp;".NFPM_L11.": <input class='tbox' type='text' name='nfp_layer_height' size='8' value='".$pref['nfp_layer_height']."' maxlength='3' />
	</td>
	</tr>
	 
	<tr>
	<td colspan='2' class='forumheader' style='text-align:center'><input class='button' type='submit' name='updatesettings' value='".NFPM_L13."' /></td>
	</tr>
	</table>
	</form>
	</div>";
$ns->tablerender(NFPM_L12, $text);
	
require_once(e_ADMIN."footer.php");
?>