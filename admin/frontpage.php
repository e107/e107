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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/frontpage.php $
|     $Revision: 11678 $
|     $Id: frontpage.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

require_once('../class2.php');
if (!getperms('G')) {
	header('location:'.e_BASE.'index.php');
	exit;
}
$e_sub_cat = 'frontpage';
require_once('auth.php');
require_once(e_HANDLER.'form_handler.php');
$rs = new form;
require_once(e_HANDLER.'userclass_class.php');

$front_page['news'] = array('page' => 'news.php', 'title' => ADLAN_0);
$front_page['download'] = array('page' => 'download.php', 'title' => ADLAN_24);
$front_page['wmessage'] = array('page' => 'index.php', 'title' => ADLAN_28);

if ($sql -> db_Select("page", "*", "page_theme=''")) {
	$front_page['custom']['title'] = 'Custom Page';
	while ($row = $sql -> db_Fetch()) {
		$front_page['custom']['page'][] = array('page' => 'page.php?'.$row['page_id'], 'title' => $row['page_title']);
	}
}


foreach($pref['e_frontpage_list'] as $val)
{
	if (is_readable(e_PLUGIN.$val."/e_frontpage.php"))
	{
		require_once(e_PLUGIN.$val."/e_frontpage.php");
	}
}



if (isset($_POST['edit'])) {
	$_POST['type'] = (isset($_POST['edit']['all'])) ? 'all_users' : 'user_class';
	$_POST['class'] = key($_POST['edit']);
}

if (isset($_POST['updatesettings'])) {
	if ($_POST['frontpage'] == 'other') {
		$_POST['other_page'] = $tp -> toForm($_POST['other_page']);
		$frontpage_value = $_POST['other_page'] ? $_POST['other_page'] : 'news.php';
	} else {
		if (is_array($front_page[$_POST['frontpage']]['page'])) {
			$frontpage_value = $front_page[$_POST['frontpage']]['page'][$_POST['multipage'][$_POST['frontpage']]]['page'];
		} else {
			$frontpage_value = $front_page[$_POST['frontpage']]['page'];
		}
	}

	if ($_POST['type'] == 'all_users') {
		unset($pref['frontpage']);
		$pref['frontpage']['all'] = $frontpage_value;
	} else {
		if (isset($pref['frontpage']['all'])) {
			$pref['frontpage']['252'] = ($_POST['class'] == '252') ? $frontpage_value : $pref['frontpage']['all'];
			$pref['frontpage']['253'] = ($_POST['class'] == '253') ? $frontpage_value : $pref['frontpage']['all'];
			$pref['frontpage']['254'] = ($_POST['class'] == '254') ? $frontpage_value : $pref['frontpage']['all'];
			$class_list = get_userclass_list();
			foreach ($class_list as $fp_class) {
				$pref['frontpage'][$fp_class['userclass_id']] = ($_POST['class'] == $fp_class['userclass_id']) ? $frontpage_value : $pref['frontpage']['all'];
			}
			unset($pref['frontpage']['all']);
		}
		$pref['frontpage'][$_POST['class']] = $frontpage_value;
	}

	save_prefs();
	$ns -> tablerender(LAN_UPDATED, "<div style='text-align:center'><b>".FRTLAN_1."</b></div>");
}

$fp = new frontpage;

if (isset($_POST['select']) || isset($_POST['edit'])) {
	$fp -> select_page();
} else {
	$fp -> select_class();
}

class frontpage {
	function select_class() {
		global $rs, $pref, $ns, $front_page;
		$text = "<div style='text-align:center'>
		<form method='post' action='".e_SELF."'>
		<table style='".ADMIN_WIDTH."' class='fborder'>";

		$text .= "<tr>
		<td style='width: 50%' class='forumheader3'>".FRTLAN_2.":</td>
		<td style='width: 50%' class='forumheader3'>
		".$rs -> form_radio('type', 'all_users', (isset($pref['frontpage']['all']) ? TRUE : FALSE))." ".FRTLAN_31."&nbsp;
		".$rs -> form_radio('type', 'user_class', (isset($pref['frontpage']['all']) ? FALSE : TRUE))." ".FRTLAN_32.":
		".r_userclass('class', '', 'off', 'guest,member,admin, main, classes')."</td>
		</tr>";

		$text .= "<tr style='vertical-align:top'>
		<td colspan='2' style='text-align: center' class='forumheader'>
		".$rs -> form_button('submit', 'select', LAN_SELECT)."
		</td>
		</tr>
		</table>
		</form>
		</div>";

		$ns -> tablerender(FRTLAN_13, $text);

		$text = "<div style='text-align:center'>
		<form method='post' action='".e_SELF."'>
		<table style='".ADMIN_WIDTH."' class='fborder'><tr>
		<td style='width: 25%' class='fcaption'>".FRTLAN_32."</td>
		<td style='width: 65%' class='fcaption'>".FRTLAN_34."</td>
		<td style='width: 10%' class='fcaption'>".LAN_EDIT."</td>
		</tr>";

		if (isset($pref['frontpage']['all'])) {
			$text .= "<tr>
			<td class='forumheader3'>".FRTLAN_31."</td>
			<td class='forumheader3'>".$pref['frontpage']['all']."</td>
			<td class='forumheader3' style='text-align:center'>
			<input type='image' title='".LAN_EDIT."' name='edit[all]' src='".ADMIN_EDIT_ICON_PATH."' />
			</td>
			</tr>";
		} else {
			foreach ($pref['frontpage'] as $current_key => $current_value) {
				if ($current_key == 252) {
					$title = FRTLAN_27;
				} else if ($current_key == 253) {
					$title = FRTLAN_28;
				} else if ($current_key == 254) {
					$title = FRTLAN_29;
				} else {
					$class_list = get_userclass_list();
					foreach ($class_list as $fp_class) {
						if ($current_key == $fp_class['userclass_id']) {
							$title = $fp_class['userclass_name'];
						}
					}
				}
				$text .= "<tr>
				<td class='forumheader3'>".$title."</td>
				<td class='forumheader3'>".$current_value."</td>
				<td class='forumheader3' style='text-align:center'>
				<input type='image' title='".LAN_EDIT."' name='edit[".$current_key."]' src='".ADMIN_EDIT_ICON_PATH."' />
				</td>
				</tr>";
			}
		}
		$text .= "</table>
		</form>
		</div>";

		$ns -> tablerender(FRTLAN_33, $text);

	}

	function select_page() {
		global $rs, $pref, $ns, $front_page;

		if ($_POST['type'] == 'all_users') {
			$title = FRTLAN_26;
		} else {
			if ($_POST['class'] == 252) {
				$title = FRTLAN_27;
			} else if ($_POST['class'] == 253) {
				$title = FRTLAN_28;
			} else if ($_POST['class'] == 254) {
				$title = FRTLAN_29;
			} else {
				$class_list = get_userclass_list();
				foreach ($class_list as $fp_class) {
					if ($_POST['class'] == $fp_class['userclass_id']) {
						$title = $fp_class['userclass_name'];
					}
				}
			}
		}

		$text = "<div style='text-align:center'>
		<form method='post' action='".e_SELF."'>
		<table style='".ADMIN_WIDTH."' class='fborder'>
		<tr>
		<td colspan='3' class='fcaption'>".FRTLAN_2." ".$title.": </td>
		</tr>";

		foreach ($front_page as $front_key => $front_value) {
			$type_selected = FALSE;
			$current_setting = (isset($pref['frontpage']['all'])) ? $pref['frontpage']['all'] : $pref['frontpage'][$_POST['class']];
			if (is_array($front_value['page'])) {
				foreach ($front_value['page'] as $multipage) {
					if ($current_setting == $multipage['page']) {
						$type_selected = TRUE;
						$not_other = TRUE;
					}
				}
			} else {
				if ($current_setting == $front_value['page']) {
					$type_selected = TRUE;
					$not_other = TRUE;
				}
			}

			$text .= "<tr><td class='forumheader3'>";
			$text .= $rs -> form_radio('frontpage', $front_key, $type_selected);
			$text .= "</td>";

			if (is_array($front_value['page'])) {
				$text .= "<td style='width: 50%' class='forumheader3'>".$front_value['title']."</td>";
				$text .= "<td style='width: 50%' class='forumheader3'>";
				$text .= $rs -> form_select_open('multipage['.$front_key.']');
				$type = isset($pref['frontpage']['all']) ? 'all' : $_POST['class'];
				foreach ($front_value['page'] as $multipage_key => $multipage_value) {
					$sub_selected = ($pref['frontpage'][$type] == $multipage_value['page']) ? TRUE : FALSE;
					$text .= $rs -> form_option($multipage_value['title'], $sub_selected, $multipage_key);
				}
				$text .= $rs -> form_select_close();
				$text .= "</td>";
			} else {
				$text .= "<td style='width: 100%' colspan='2' class='forumheader3'>".$front_value['title']."</td>";
			}
			$text .= "</tr>";
		}

		$text .= "<tr>
		<td class='forumheader3'>".$rs -> form_radio('frontpage', 'other', (!$not_other ? TRUE : FALSE))."</td>
		<td style='width: 50%' class='forumheader3'>".FRTLAN_15."</td>
		<td style='width: 50%' class='forumheader3'>
		".$rs -> form_text('other_page', 50, (!$not_other ? $current_setting : ''), 150)."
		</td>
		</tr>";

		$text .= "<tr style='vertical-align:top'>
		<td colspan='3' style='text-align: center' class='forumheader'>";
		$text .= $rs -> form_hidden('type', $_POST['type']);
		$text .= $rs -> form_hidden('class', $_POST['class']);
		$text .= $rs -> form_button('submit', 'updatesettings', FRTLAN_12);
		$text .= "</td>
		</tr>
		</table>
		</form>
		</div>";

		$ns -> tablerender(FRTLAN_13, $text);
	}
}

require_once(e_ADMIN.'footer.php');

?>