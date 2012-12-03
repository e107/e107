<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2012 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/alt_auth/alt_auth_conf.php $
|     $Revision: 12556 $
|     $Id: alt_auth_conf.php 12556 2012-01-15 02:16:00Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

$eplug_admin = true;

require_once '../../class2.php';

if (!getperms('P'))  { header('Location:'.e_BASE.'index.php'); exit; }


include_lan(e_PLUGIN.'alt_auth/languages/'.e_LANGUAGE.'/lan_alt_auth_conf.php');
define('ALT_AUTH_ACTION', 'main');

require_once e_PLUGIN.'alt_auth/alt_auth_adminmenu.php';
require_once e_HANDLER.'form_handler.php';
require_once e_ADMIN.'auth.php';

if (isset($_POST['updateprefs']))
{
	$pref['auth_method'] = $_POST['auth_method'];
	$pref['auth_noconn'] = intval($_POST['auth_noconn']);
	$pref['auth_nouser'] = intval($_POST['auth_nouser']);
	
	save_prefs();
	
	$_POST   = array();
	$message = LAN_UPDATED;
}

$auth_dropdown = '';

foreach (alt_auth_get_authlist() as $a)
{
	$auth_dropdown.= '
									<option value="'.$a.'"'.($pref['auth_method'] == $a ? ' selected="selected"' : '').'>'.$a.'</option>';
}

if (varsettrue($message))  $ns->tablerender('', '<div style="text-align:center"><strong>'.$message.'</strong></div>');

$text = '	<div style="text-align:center">
				<form method="post" action="'.e_SELF.'">
					<table class="fborder" style="'.ADMIN_WIDTH.'" cellspacing="1" cellpadding="0">
						<tr>
							<td style="width:70%" class="forumheader3">
								'.LAN_ALT_2.':
							</td>
							<td style="width:30%; text-align:right;" class="forumheader3">
								<select class="tbox" name="auth_method">'.
									$auth_dropdown.'
								</select>
							</td>
						</tr>
						<tr>
							<td class="forumheader3">
								'.LAN_ALT_6.':<br />
								<div class="smalltext">
									'.LAN_ALT_7.'
								</div>
							</td>
							<td style="text-align:right;" class="forumheader3">
								<select class="tbox" name="auth_noconn">
									<option value="0"'.(varsettrue($pref['auth_noconn']) ? '' : ' selected="selected"').'>'.LAN_ALT_10.'</option>
									<option value="1"'.(varsettrue($pref['auth_noconn']) ? ' selected="selected"' : '').'>'.LAN_ALT_11.'</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="forumheader3">
								'.LAN_ALT_8.':<br />
								<div class="smalltext">
									'.LAN_ALT_9.'
								</div>
							</td>
							<td style="text-align:right;" class="forumheader3">
								<select class="tbox" name="auth_nouser">
									<option value="0"'.(varsettrue($pref['auth_nouser']) ? '' : ' selected="selected"').'>'.LAN_ALT_10.'</option>
									<option value="1"'.(varsettrue($pref['auth_nouser']) ? ' selected="selected"' : '').'>'.LAN_ALT_11.'</option>
								</select>
							</td>
						</tr>
						<tr style="vertical-align:top"> 
							<td colspan="2"  style="text-align:center" class="forumheader3">
								<br />
								<input class="button" type="submit" name="updateprefs" value="'.LAN_UPDATE.'" />
							</td>
						</tr>
					</table>
				</form>
			</div>';


$ns->tablerender(LAN_ALT_3,$text);

require_once e_ADMIN.'footer.php';


?>