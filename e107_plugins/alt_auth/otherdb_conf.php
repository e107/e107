<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/alt_auth/otherdb_conf.php $
|     $Revision: 12556 $
|     $Id: otherdb_conf.php 12556 2012-01-15 02:16:00Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

$eplug_admin = true;

require_once '../../class2.php';

include_lan(e_PLUGIN.'alt_auth/languages/'.e_LANGUAGE.'/lan_otherdb_auth.php');
define('ALT_AUTH_ACTION', 'otherdb');

require_once e_PLUGIN.'alt_auth/alt_auth_adminmenu.php';
require_once e_HANDLER.'form_handler.php';
require_once e_ADMIN.'auth.php';

function update_otherdb_prefs()
{
	foreach($_POST as $k=>$v)
	{
		$v = base64_encode(base64_encode($v));
		
		if (preg_match('/otherdb_/', $k))
		{
			if (!$sql)  $sql = new db();
			if ($sql->db_Select('alt_auth', '*', "auth_type='otherdb' AND auth_parmname='{$k}' "))
				$sql->db_Update('alt_auth', "auth_parmval='{$v}' WHERE  auth_type='otherdb' AND auth_parmname='{$k}' ");
			else
				$sql->db_Insert('alt_auth', "'otherdb','{$k}','{$v}' ");
		}
	}
	
	return LAN_UPDATED;
}

function show_otherdb_form()
{
	global $ns, $tp, $sql;
	
	$parm        = array();
	$db_types    = array('e107' => 'mysql - e107 database', 'mysql' => 'mysql - generic database');
	$pwd_methods = array('md5', 'plaintext');
	
	$sql->db_Select('alt_auth', '*', "auth_type = 'otherdb'");
	
	while ($row = $sql->db_Fetch())  $parm[$row['auth_parmname']] = base64_decode(base64_decode($row['auth_parmval']));
	
	$frm  = new form;
	$text = '
	'.$frm->form_open('POST', e_SELF).'
		<table style="width:96%">
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_1.'</td>
				<td class="forumheader3">
					'.$frm->form_select_open('otherdb_dbtype');
	
	foreach($db_types as $k => $v)
	{
		$text.= $frm->form_option($v, ($parm['otherdb_dbtype'] == $k ? 'selected' : ''), $k);		
	}  
	
	$text.= $frm->form_select_close().'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_2.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_server', 35, $parm['otherdb_server'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_3.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_username', 35, $parm['otherdb_username'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_4.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_password', 35, $parm['otherdb_password'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_5.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_database', 35, $parm['otherdb_database'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_6.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_table', 35, $parm['otherdb_table'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader2" colspan="2">
					'.OTHERDB_LAN_11.'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_7.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_user_field', 35, $parm['otherdb_user_field'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_8.'</td>
				<td class="forumheader3">
					'.$frm->form_text('otherdb_password_field', 35, $parm['otherdb_password_field'], 120).'
				</td>
			</tr>
			<tr>
				<td class="forumheader3">'.OTHERDB_LAN_9.'</td>
				<td class="forumheader3">
					'.$frm->form_select_open('otherdb_password_method');
	
	foreach ($pwd_methods as $v)
	{
		$text.= $frm->form_option($v, ($parm['otherdb_password_method'] == $v ? 'selected' : ''), $v);		
	} 
 
	$text .= $frm->form_select_close().'
				</td>
			</tr>
			<tr>
				<td class="forumheader" colspan="2" style="text-align:center;">
					'.$frm->form_button('submit', 'update', LAN_UPDATE).'
				</td>
			</tr>
		</table>
	'.$frm->form_close();
	
	return $text;
}

if (varsettrue($_POST['update']))  $message = update_otherdb_prefs();
if (varsettrue($message))          $ns->tablerender('', '<div style="text-align:center;">'.$message.'</div>');

$ns->tablerender(OTHERDB_LAN_10, show_otherdb_form());

require_once e_ADMIN.'footer.php';

?>