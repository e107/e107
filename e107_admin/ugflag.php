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
 |     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/ugflag.php $
 |     $Revision: 11732 $
 |     $Id: ugflag.php 11732 2010-09-02 07:15:29Z e107steved $
 |     $Author: e107steved $
 +----------------------------------------------------------------------------+
 */

// Experimental e-token
if(!empty($_POST) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

require_once ('../class2.php');
if(!getperms('9'))
{
	header('location:'.e_BASE.'index.php');
	exit();
}

$e_sub_cat = 'maintain';

if(isset($_POST['updatesettings']))
{
	$pref['maintainance_flag'] = intval($_POST['maintainance_flag']);
	$pref['maintainance_text'] = $tp->toDB($_POST['maintainance_text']);
	save_prefs();

	$message = '<div style="text-align:center"><b>'.UGFLAN_1.'.</b></div>';
}
else
{
	if(!isset($pref['maintainance_flag']))
	{
		$pref['maintainance_flag'] = e_UC_PUBLIC;
	}
	if(($pref['maintainance_flag']) == 1)
	{
		$pref['maintainance_flag'] = e_UC_ADMIN;
	}
}
require_once (e_HANDLER.'ren_help.php');

require_once ('auth.php');

if(varset($message))
{
	$ns->tablerender('', $message);
}


$text = '
	<div style="text-align:center">
	<form method="post" action="'.e_SELF.'" id="dataform">
	<table style="'.ADMIN_WIDTH.'" class="fborder">
		<colgroup span="2">
			<col style="width:30%" />
			<col style="width:70%" />
		</colgroup>
';

$text .= '
		<tr>
			<td class="forumheader3">
			'.UGFLAN_2.'
			</td>
			<td class="forumheader3">
';

$text .= '
			<label>
			<input type="radio" name="maintainance_flag" value="'.e_UC_PUBLIC.'"'.
			((varset($pref['maintainance_flag']) == e_UC_PUBLIC) ? ' checked="checked"' : '')
			.' />
			'.LAN_DISABLED.'
			</label>
			<br />
';
$text .= '
			<label>
			<input type="radio" name="maintainance_flag" value="'.e_UC_ADMIN.'"'.
			((varset($pref['maintainance_flag']) == e_UC_ADMIN) ? ' checked="checked"' : '')
			.' />
			'.UGFLAN_8.'
			</label>
			<br />
';
$text .= '
			<label>
			<input type="radio" name="maintainance_flag" value="'.e_UC_MAINADMIN.'"'.
			((varset($pref['maintainance_flag']) == e_UC_MAINADMIN) ? ' checked="checked"' : '')
			.' />
			'.UGFLAN_9.'
			</label>
			<br />
';

$text .= '</td>
		</tr>
';

$text .= '
		<tr>
			<td class="forumheader3">
			'.UGFLAN_5.'<br />
			<span class="smalltext">'.UGFLAN_6.'</span>
		</td>
		<td class="forumheader3">
			<textarea id="maintainance_text" class="tbox" name="maintainance_text"
			 cols="63" style="width:100%" rows="10"
			 onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">'.$pref['maintainance_text'].'</textarea>
			'.display_help('', 'maintenance').'
			</td>
		</tr>
';

$text .= '
			<tr>
			<td colspan="2" style="text-align:center" class="forumheader">
			<input class="button" type="submit" name="updatesettings" value="'.UGFLAN_3.'" />
			<input type="hidden" name="e-token" value="'.e_TOKEN.'" />
			</td>
		</tr>
	</table>
	</form>
	</div>
';

$ns->tablerender(UGFLAN_4, $text);
require_once(e_ADMIN.'footer.php');
