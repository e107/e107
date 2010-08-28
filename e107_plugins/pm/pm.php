<?php
/*
* e107 website system
*
* Copyright 2008-2010 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Private Messenger plugin - main user interface
*
* $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/pm/pm.php $
* $Id: pm.php 11598 2010-07-13 22:04:29Z e107steved $
*
*/

$retrieve_prefs[] = 'pm_prefs';
require_once('../../class2.php');


if (!isset($pref['plug_installed']['pm']))
{
	header('location:'.e_BASE.'index.php');
	exit;
}


require_once(e_PLUGIN.'pm/pm_class.php');
require_once(e_PLUGIN.'pm/pm_func.php');
include_lan(e_PLUGIN.'pm/languages/'.e_LANGUAGE.'.php');

define('ATTACHMENT_ICON', "<img src='".e_PLUGIN."pm/images/attach.png' alt='' />");

$qs = explode('.', e_QUERY);
$action = varset($qs[0],'inbox');
if (!$action) $action = 'inbox';

$pm_proc_id = intval(varset($qs[1],0));

$pm_prefs = $sysprefs->getArray('pm_prefs');

if(!isset($pm_prefs['pm_class']) || !check_class($pm_prefs['pm_class']))
{
	require_once(HEADERF);
	$ns->tablerender(LAN_PM, LAN_PM_12);
	require_once(FOOTERF);
	exit;
}

$pm = new private_message;
$message = '';
$pm_prefs['perpage'] = intval($pm_prefs['perpage']);
if($pm_prefs['perpage'] == 0)
{
	$pm_prefs['perpage'] = 10;
}
$pmSource = '';
if (isset($_POST['pm_come_from']))
{
	$pmSource = $tp->toDB($_POST['pm_come_from']);
}
elseif (isset($qs[2]))
{
	$pmSource = $tp->toDB($qs[2]);
}



//Auto-delete message, if timeout set in admin
$del_qry = array();
$read_timeout = intval($pm_prefs['read_timeout']);
$unread_timeout = intval($pm_prefs['unread_timeout']);
if($read_timeout > 0)
{
	$timeout = time()-($read_timeout * 86400);
	$del_qry[] = "(pm_sent < {$timeout} AND pm_read > 0)";
}
if($unread_timeout > 0)
{
	$timeout = time()-($unread_timeout * 86400);
	$del_qry[] = "(pm_sent < {$timeout} AND pm_read = 0)";
}
if(count($del_qry) > 0)
{
	$qry = implode(' OR ', $del_qry).' AND (pm_from = '.USERID.' OR pm_to = '.USERID.')';
	if($sql->db_Select('private_msg', 'pm_id', $qry))
	{
		$delList = $sql->db_getList();
		foreach($delList as $p)
		{
			$pm->del($p['pm_id']);
		}
	}
}



if('del' == $action || isset($_POST['pm_delete_selected']))
{
	if(isset($_POST['pm_delete_selected']))
	{
		foreach(array_keys($_POST['selected_pm']) as $id)
		{
			$message .= LAN_PM_24.": {$id} <br />";
			$message .= $pm->del($id);
		}
	}
	if('del' == $action)
	{
		$message = $pm->del($pm_proc_id);
	}
	if ($pmSource)
	{
		$action = $pmSource;
	}
	else
	{
		if(substr($_SERVER['HTTP_REFERER'], -5) == 'inbox')
		{
			$action = 'inbox';
		}
		elseif(substr($_SERVER['HTTP_REFERER'], -6) == 'outbox')
		{
			$action = 'outbox';
		}
	}
	$pm_proc_id = 0;
	unset($qs);
}



if('delblocked' == $action || isset($_POST['pm_delete_blocked_selected']))
{
	if(isset($_POST['pm_delete_blocked_selected']))
	{
		foreach(array_keys($_POST['selected_pm']) as $id)
		{
			$message .= LAN_PM_70.": {$id} <br />";
			$message .= $pm->block_del($id).'<br />';
		}
		}
	elseif('delblocked' == $action)
	{
		$message = $pm->block_del($pm_proc_id);
	}
	$action = 'blocked';
	$pm_proc_id = 0;
	unset($qs);
}


if('block' == $action)
{
	$message = $pm->block_add($pm_proc_id);
	$action = 'inbox';
	$pm_proc_id = 0;
}

if('unblock' == $action)
{
	$message = $pm->block_del($pm_proc_id);
	$action = 'inbox';
	$pm_proc_id = 0;
}

if('get' == $action)
{
	$pm->send_file($pm_proc_id, intval($qs[2]));
	exit;
}


require_once(HEADERF);

if(isset($_POST['postpm']))
{
	$message = post_pm();
	$action = 'outbox';
}



if($message != '')
{
	$ns->tablerender("", $message);
}



switch ($action)
{
	case 'send' :
	$ns->tablerender(LAN_PM, show_send($pm_proc_id));
		break;

	case 'reply' :
	$pmid = $pm_proc_id;
	if($pm_info = $pm->pm_get($pmid))
	{
		if($pm_info['pm_to'] != USERID)
		{
			$ns->tablerender(LAN_PM, LAN_PM_56);
		}
		else
		{
			$ns->tablerender(LAN_PM, show_send());
		}
	}
	else
	{
		$ns->tablerender(LAN_PM, LAN_PM_57);
	}
		break;

	case 'inbox' :
		$ns->tablerender(LAN_PM." - ".LAN_PM_25, show_inbox($pm_proc_id), 'PM');
		break;

	case 'outbox' :
		$ns->tablerender(LAN_PM." - ".LAN_PM_26, show_outbox($pm_proc_id), 'PM');
		break;

	case 'show' :
		show_pm($pm_proc_id, $pmSource);
		break;

	case 'blocked' :
		$ns->tablerender(LAN_PM." - ".LAN_PM_66, showBlocked($pm_proc_id), 'PM');
		break;
}


require_once(FOOTERF);
exit;






function show_send($to_uid)
{
	global $tp, $pm_info, $pm_prefs;
	$pm_outbox = pm_getInfo('outbox');
	if($to_uid)
	{
		$sql2 = new db;
		if($sql2->db_Select('user', 'user_name', "user_id = '".intval($to_uid)."'"))
		{
			$row=$sql2->db_Fetch();
			$pm_info['from_name'] = $row['user_name'];
		}
	}

	if($pm_outbox['outbox']['filled'] >= 100)
	{
		return str_replace('{PERCENT}', $pm_outbox['outbox']['filled'], LAN_PM_13);
	}
	require_once(e_PLUGIN.'pm/pm_shortcodes.php');
	$tpl_file = THEME."pm_template.php";
	include_once(is_readable($tpl_file) ? $tpl_file : e_PLUGIN.'pm/pm_template.php');
	$enc = (check_class($pm_prefs['attach_class']) ? "enctype='multipart/form-data'" : "");
	$text = "<form {$enc} method='post' action='".e_SELF."' id='dataform'>
	<div><input type='hidden' name='numsent' value='{$pm_outbox['outbox']['total']}' />".
	$tp->parseTemplate($PM_SEND_PM, TRUE, $pm_shortcodes).
	"</div></form>";
	return $text;
}



function show_inbox($start = 0)
{
	global $pm, $tp, $pm_shortcodes, $pm_info, $pm_blocks, $pmlist, $pm_start, $pm_prefs;
	$pm_start = $start;
	require_once(e_PLUGIN."pm/pm_shortcodes.php");
	$tpl_file = THEME."pm_template.php";
	include(is_readable($tpl_file) ? $tpl_file : e_PLUGIN."pm/pm_template.php");
	$pm_blocks = $pm->block_get();
	$pmlist = $pm->pm_get_inbox(USERID, $pm_start, $pm_prefs['perpage']);
	$txt = "<form method='post' action='".e_SELF."?".e_QUERY."' id='pm_list_form'>";
	$txt .= $tp->parseTemplate($PM_INBOX_HEADER, true, $pm_shortcodes);
	if($pmlist['total_messages'])
	{
		foreach($pmlist['messages'] as $rec)
		{
			if(trim($rec['pm_subject']) == '') { $rec['pm_subject'] = "[".LAN_PM_61."]"; }
			$pm_info = $rec;
			$txt .= $tp->parseTemplate($PM_INBOX_TABLE, true, $pm_shortcodes);
		}
	}
	else
	{
		$txt .= $tp->parseTemplate($PM_INBOX_EMPTY, true, $pm_shortcodes);
	}
	$txt .= $tp->parseTemplate($PM_INBOX_FOOTER, true, $pm_shortcodes);
	$txt .= "</form>";
	return $txt;
}




function show_outbox($start = 0)
{
	global $pm, $tp, $pm_shortcodes, $pm_info, $pm_start, $pm_prefs, $pmlist;
	$pm_start = $start;
	require_once(e_PLUGIN.'pm/pm_shortcodes.php');
	$tpl_file = THEME.'pm_template.php';
	include(is_readable($tpl_file) ? $tpl_file : e_PLUGIN.'pm/pm_template.php');
	$pmlist = $pm->pm_get_outbox(USERID, $pm_start, $pm_prefs['perpage']);
	$txt = "<form method='post' action='".e_SELF."?".e_QUERY."' id='pm_list_form'>";
	$txt .= $tp->parseTemplate($PM_OUTBOX_HEADER, true, $pm_shortcodes);
	if($pmlist['total_messages'])
	{
		foreach($pmlist['messages'] as $rec)
		{
			if(trim($rec['pm_subject']) == '') { $rec['pm_subject'] = '['.LAN_PM_61.']'; }
			$pm_info = $rec;
			$txt .= $tp->parseTemplate($PM_OUTBOX_TABLE, true, $pm_shortcodes);
		}
	}
	else
	{
		$txt .= $tp->parseTemplate($PM_OUTBOX_EMPTY, true, $pm_shortcodes);
	}
	$txt .= $tp->parseTemplate($PM_OUTBOX_FOOTER, true, $pm_shortcodes);
	$txt .= "</form>";
	return $txt;
}



function show_pm($pmid, $comeFrom = '')
{
	global $pm, $tp, $pm_shortcodes, $pm_info, $ns;
	require_once(e_PLUGIN.'pm/pm_shortcodes.php');
	$tpl_file = THEME.'pm_template.php';
	include_once(is_readable($tpl_file) ? $tpl_file : e_PLUGIN.'pm/pm_template.php');
	$pm_info = $pm->pm_get($pmid);
	if($pm_info['pm_to'] != USERID && $pm_info['pm_from'] != USERID)
	{
		$ns->tablerender(LAN_PM, LAN_PM_60);
		require_once(FOOTERF);
		exit;
	}
	if($pm_info['pm_read'] == 0 && $pm_info['pm_to'] == USERID)
	{	// Inbox
		$now = time();
		$pm_info['pm_read'] = $now;
		$pm->pm_mark_read($pmid, $pm_info);
	}
	$txt .= $tp->parseTemplate($PM_SHOW, true, $pm_shortcodes);
	$ns -> tablerender(LAN_PM, $txt);
	if (!$comeFrom)
	{
		if ($pm_info['pm_from'] == USERID) { $comeFrom = 'outbox'; } 
	}
	if ($comeFrom == 'outbox')
	{	// Show Outbox
		$ns->tablerender(LAN_PM." - ".LAN_PM_26, show_outbox($pm_proc_id), 'PM');
	}
	else
	{	// Show Inbox
		$ns->tablerender(LAN_PM." - ".LAN_PM_25, show_inbox($pm_proc_id), 'PM');
	}
}





function post_pm()
{
	global $pm_prefs, $pm, $pref, $sql, $tp;
	if(!check_class($pm_prefs['pm_class']))
	{
		return LAN_PM_12;
	}

	$pm_info = pm_getInfo('outbox');
	if($pm_info['outbox']['total'] != $_POST['numsent'])
	{
		return LAN_PM_14;
	}

	if(isset($_POST['user']))
	{
		$_POST['pm_to'] = $_POST['user'];
	}
	if(isset($_POST['pm_to']))
	{
		$msg = '';
		if(isset($_POST['to_userclass']) && $_POST['to_userclass'])
		{
			if(!$pm_prefs['allow_userclass'])
			{
				return LAN_PM_15;
			}
			elseif((!check_class($_POST['pm_userclass']) || !check_class($pm_prefs['multi_class'])) && !ADMIN)
			{
				return LAN_PM_16;
			}
		}
		else
		{
			$to_array = explode("\n", trim($_POST['pm_to']));
			foreach($to_array as $k => $v)
			{
				$to_array[$k] = trim($v);
			}
			$to_array = array_unique($to_array);
			if(count($to_array) == 1)
			{
				$_POST['pm_to'] = $to_array[0];
			}
			if(check_class($pm_prefs['multi_class']) && count($to_array) > 1)
			{
				foreach($to_array as $to)
				{
					if($to_info = $pm->pm_getuid($to))
					{
 						if(!$sql->db_Update("private_msg_block","pm_block_count=pm_block_count+1 WHERE pm_block_from = '".USERID."' AND pm_block_to = '".$tp -> toDB($to)."'"))
 						{
 							$_POST['to_array'][] = $to_info;
 						}
					}
				}
			}
			else
			{
				if($to_info = $pm->pm_getuid($_POST['pm_to']))
				{
					$_POST['to_info'] = $to_info;
				}
				else
				{
					return LAN_PM_17;
				}

				if($sql->db_Update("private_msg_block","pm_block_count=pm_block_count+1 WHERE pm_block_from = '".USERID."' AND pm_block_to = '{$to_info['user_id']}'"))
				{
					return LAN_PM_18.$to_info['user_name'];
				}
			}
		}

		if(isset($_POST['receipt']))
		{
			if(!check_class($pm_prefs['receipt_class']))
			{
				unset($_POST['receipt']);
			}
		}
		$totalsize = strlen($_POST['pm_message']);
		$maxsize = intval($pm_prefs['attach_size']) * 1024;
		foreach(array_keys($_FILES['file_userfile']['size']) as $fid)
		{
			if($maxsize > 0 && $_FILES['file_userfile']['size'][$fid] > $maxsize)
			{
				$msg .= str_replace("{FILENAME}", $_FILES['file_userfile']['name'][$fid], LAN_PM_62)."<br />";
				$_FILES['file_userfile']['size'][$fid] = 0;
			}
			$totalsize += $_FILES['file_userfile']['size'][$fid];
		}

		if(intval($pref['pm_limit']) > 0)
		{
			if($pref['pm_limit'] == '1')
			{
				if($pm_info['outbox']['total'] == $pm_info['outbox']['limit'])
				{
					return LAN_PM_19;
				}
			}
			else
			{
				if($pm_info['outbox']['size'] + $totalsize > $pm_info['outbox']['limit'])
				{
					return LAN_PM_21;
				}
			}
		}

		if($_FILES['file_userfile']['name'][0])
		{
			if(check_class($pm_prefs['attach_class']))
			{
				require_once(e_HANDLER."upload_handler.php");
				$randnum = rand(1000, 9999);
				$_POST['uploaded'] = file_upload(e_PLUGIN."pm/attachments", "attachment", $randnum."_");
				if($_POST['uploaded'] == FALSE)
				{
					unset($_POST['uploaded']);
					$msg .= LAN_PM_22."<br />";
				}
			}
			else
			{
				$msg .= LAN_PM_23."<br />";
				unset($_POST['uploaded']);
			}
		}
		$_POST['from_id'] = USERID;
		return $msg.$pm->add($_POST);
	}
}


function pm_user_lookup()
{
	global $sql;


		$query = "SELECT * FROM #user WHERE user_name REGEXP '^".$_POST['keyword']."' ";
	  	if($sql -> db_Select_gen($query))
	  	{
			echo "[";
	        while($row = $sql-> db_Fetch())
	        {
	              $u[] =  "{\"caption\":\"".$row['user_name']."\",\"value\":".$row['user_id']."}";
	         }

			echo implode(",",$u);
	        echo "]";
		}

    	exit;
}


function showBlocked($start = 0)
{
	global $pm, $tp, $pm_shortcodes, $pmBlocked, $pmTotalBlocked, $pm_start, $pm_prefs ;
	$pm_start = $start;
	require_once(e_PLUGIN.'pm/pm_shortcodes.php');
	$tpl_file = THEME.'pm_template.php';
	include(is_readable($tpl_file) ? $tpl_file : e_PLUGIN.'pm/pm_template.php');
	$pmBlocks = $pm->block_get_user();			// TODO - handle pagination, maybe (is it likely to be necessary?)
	$txt = "<form method='post' action='".e_SELF."?".e_QUERY."'>";
	$txt .= $tp->parseTemplate($PM_BLOCKED_HEADER, true, $pm_shortcodes);
	if($pmTotalBlocked = count($pmBlocks))
	{
		foreach($pmBlocks as $pmBlocked)
		{
			$txt .= $tp->parseTemplate($PM_BLOCKED_TABLE, true, $pm_shortcodes);
		}
	}
	else
	{
		$txt .= $tp->parseTemplate($PM_BLOCKED_EMPTY, true, $pm_shortcodes);
	}
	$txt .= $tp->parseTemplate($PM_BLOCKED_FOOTER, true, $pm_shortcodes);
	$txt .= "</form>";
	return $txt;
}



?>