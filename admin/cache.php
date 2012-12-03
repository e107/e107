<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/cache.php $
|     $Revision: 11678 $
|     $Id: cache.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
require_once("../class2.php");
if (!getperms("C")) {
	header("location:".e_BASE."index.php");
	exit;
}
$e_sub_cat = 'cache';
require_once("auth.php");
require_once(e_HANDLER."cache_handler.php");
$ec = new ecache;
if ($pref['cachestatus'] == '2') {
	$pref['cachestatus'] = '1';
}
if (isset($_POST['submit_cache'])) {
	if ($pref['cachestatus'] != $_POST['cachestatus']) {
		$pref['cachestatus'] = $_POST['cachestatus'];
		save_prefs();
		$ec->clear();
		$update = true;
	}
	admin_update($update, 'update', CACLAN_4);
}
	
if (isset($_POST['empty_cache'])) {
	$ec->clear();
	$ns->tablerender(LAN_UPDATE, "<div style='text-align:center'><b>".CACLAN_6."</b></div>");
}
	
$text = "<div style='text-align:center'>
	<form method='post' action='".e_SELF."'>
	<table style='".ADMIN_WIDTH."' class='fborder'>
	<tr>
	<td class='fcaption'>".CACLAN_1."</td>
	</tr>
	<tr>
	<td class='forumheader3'>";
$text .= (!$pref['cachestatus']) ? "<input type='radio' name='cachestatus' value='0' checked='checked' />" :
 "<input type='radio' name='cachestatus' value='0' />";
$text .= CACLAN_7."
	</td>
	</tr>
	 
	<tr>
	<td class='forumheader3'>";
if (is_writable(e_FILE."cache")) {
	$text .= ('1' == $pref['cachestatus']) ? "<input type='radio' name='cachestatus' value='1' checked='checked' />" :
	 "<input type='radio' name='cachestatus' value='1' />";
	$text .= CACLAN_9;
} else {
	$text .= CACLAN_9."<br /><br /><b>".CACLAN_10."</b>";
}
$text .= "</td>
	</tr>
	 
	<tr style='vertical-align:top'>
	<td style='text-align:center' class='forumheader'>
	 
	<input class='button' type='submit' name='submit_cache' value='".CACLAN_2."' />
	<input class='button' type='submit' name='empty_cache' value='".CACLAN_5."' />
	 
	</td>
	</tr>
	</table>
	</form>
	</div>";
	
$ns->tablerender(CACLAN_3, $text);
	
require_once("footer.php");
?>