<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system  �Steve Dunstan 2001-2002
|     http://e107.org jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvs_backup/e107_0.7/e107_files/shortcode/batch/contact_shortcodes.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }
include_once(e_HANDLER.'shortcode_handler.php');
$contact_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);
/*
SC_BEGIN CONTACT_EMAIL_COPY
global $pref;
if(!isset($pref['contact_emailcopy']) || !$pref['contact_emailcopy'])
{
	return;
}
return "<input type='checkbox' name='email_copy'  value='1'  />";
SC_END

SC_BEGIN CONTACT_PERSON
global $sql,$tp,$pref;
if($pref['sitecontacts'] == e_UC_ADMIN){
	$query = "user_admin =1";
}elseif($pref['sitecontacts'] == e_UC_MAINADMIN){
    $query = "user_admin = 1 AND (user_perms = '0' OR user_perms = '0.') ";
}else{
	$query = "FIND_IN_SET(".$pref['sitecontacts'].",user_class) ";
}

$text = "<select name='contact_person' class='tbox contact_person'>\n";
$count = $sql -> db_Select("user", "user_id,user_name", $query . " ORDER BY user_name");
if($count > 1){
    while($row = $sql-> db_Fetch())
	{
    	$text .= "<option value='".$row['user_id']."'>".$row['user_name']."</option>\n";
    }
}else{
	return;
}
$text .= "</select>";
return $text;
SC_END


SC_BEGIN CONTACT_IMAGECODE
global $sec_img;
return "<input type='hidden' name='rand_num' value='".$sec_img->random_number."' />".$sec_img->r_image();
SC_END

SC_BEGIN CONTACT_IMAGECODE_INPUT
return "<input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />";
SC_END

*/

?>