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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_files/shortcode/batch/contact_shortcodes.php $
|     $Revision: 12850 $
|     $Id: contact_shortcodes.php 12850 2012-06-30 08:58:35Z e107coders $
|     $Author: e107coders $
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
$count = $sql -> db_Select("user", "user_id,user_name,user_customtitle", $query . " ORDER BY user_customtitle,user_name");
if($count > 1){
    while($row = $sql-> db_Fetch())
	{
 		$name = ($row['user_customtitle'] !='') ? $row['user_customtitle'] : $row['user_name'];
    	$text .= "<option value='".$row['user_id']."'>".$name."</option>\n";
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