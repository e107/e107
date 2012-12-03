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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/administrator.php $
|     $Revision: 12903 $
|     $Id: administrator.php 12903 2012-07-23 07:37:12Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

// Experimental e-token
if(!empty($_POST) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

require_once('../class2.php');
if (!getperms('3'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}
$e_sub_cat = 'admin';
require_once('auth.php');

$action = '';

if (e_QUERY)
{
	$tmp = explode(".", e_QUERY);
	$action = $tmp[0];
	$sub_action = $tmp[1];
	unset($tmp);
}

if (isset($_POST['update_admin']))
{
	$sql->db_Select("user", "*", "user_id='".$_POST['a_id']."' ");
	$row = $sql->db_Fetch();
	$a_name = $row['user_name'];

	$perm = "";

	foreach($_POST['perms'] as $value)
	{
      if ($value == "0")
      {
        if (!getperms('0')) { $value = ""; break; }

        $perm = "0."; break;
      }

      if ($value)
      {
        $perm .= $value.".";
      }
    }

	admin_update($sql -> db_Update("user", "user_perms='$perm' WHERE user_name='$a_name' "), 'update', ADMSLAN_56." ".$_POST['ad_name']." ".ADMSLAN_2."<br />");
	unset($ad_name, $a_perms);
}

if (isset($_POST['edit_admin']) || $action == "edit")
{
	$edid = array_keys($_POST['edit_admin']);
    $theid = ($edid[0]) ? $edid[0] : $sub_action;
	$sql->db_Select("user", "*", "user_id=".$theid);
	$row = $sql->db_Fetch();

	if ($a_perms == "0")
	{
		$text = "<div style='text-align:center'>$ad_name ".ADMSLAN_3."
		<br /><br />
		<a href='administrator.php'>".ADMSLAN_4."</a></div>";
		$ns->tablerender(LAN_ERROR, $text);
		require_once("footer.php");
		exit;
	}
}

if (isset($_POST['del_admin']))
{
	$delid = array_keys($_POST['del_admin']);
	$sql->db_Select("user", "*", "user_id= ".$delid[0]);
	$row = $sql->db_Fetch();

	if ($row['user_id'] == 1)
	{
		$text = "<div style='text-align:center'>".$row['user_name']." ".ADMSLAN_6."
		<br /><br />
		<a href='administrator.php'>".ADMSLAN_4."</a>";
		$ns->tablerender(ADMSLAN_5, $text);
		require_once("footer.php");
		exit;
	}

	admin_update($sql -> db_Update("user", "user_admin=0, user_perms='' WHERE user_id= ".$delid[0]), 'update', ADMSLAN_61, LAN_DELETED_FAILED);
}

if(isset($_POST['edit_admin']) || $action == "edit")
{
	edit_administrator($row);
}
else
{
   show_admins();
}

function show_admins(){
    global $sql,$tp,$ns,$pref;

	$sql->db_Select("user", "*", "user_admin='1'");

	$text = "<div style='text-align:center'><div style='padding: 1px; ".ADMIN_WIDTH."; margin-left: auto; margin-right: auto;'>
	<form action='".e_SELF."' method='post' id='del_administrator'>
	<div>
	<input type='hidden' name='del_administrator_confirm' id='del_administrator_confirm' value='1' />
	<input type='hidden' name='e-token' value='".e_TOKEN."' />
	<table class='fborder' style='width:99%'>
	<tr>
	<td style='width:5%' class='fcaption'>ID</td>
	<td style='width:20%' class='fcaption'>".ADMSLAN_56."</td>
	<td style='width:65%' class='fcaption'>".ADMSLAN_18."</td>
	<td style='width:10%' class='fcaption'>".LAN_OPTIONS."</td>
	</tr>";

	while ($row = $sql->db_Fetch())
	{

		$text .= "<tr>
		<td style='width:5%' class='forumheader3'>".$row['user_id']."</td>
		<td style='width:20%' class='forumheader3'><a href='".e_BASE."user.php?id.".$row['user_id']."'>".$row['user_name']."</a></td>
		<td style='width:65%' class='forumheader3'>";

		$permtxt = "";
        $text .= renderperms($row['user_perms'],$row['user_id'],"words");
   		$text .= "</td>

		<td style='width:10%; text-align:center' class='forumheader3'>";
		if($row['user_id'] != "1")
		{
    		$text .= "
			<input type='image' name='edit_admin[{$row['user_id']}]' value='edit' src='".e_IMAGE."admin_images/edit_16.png' title='".LAN_EDIT."' />
			<input type='image' name='del_admin[{$row['user_id']}]' value='del' src='".e_IMAGE."admin_images/delete_16.png' onclick=\"return jsconfirm('".$tp->toJS(ADMSLAN_59."? [".$row['user_name']."]")."') \"  title='".ADMSLAN_59."' style='border:0px' />";
    	}
		$text .= "&nbsp;</td>

		</tr>";
	}
	$text .= "</table></div>\n</form></div>\n</div>";

	$ns->tablerender(ADMSLAN_13, $text);

}




function edit_administrator($row){
    global $sql,$tp,$ns,$pref;
	$lanlist = explode(",",e_LANLIST);

	$a_id = $row['user_id'];
	$ad_name = $row['user_name'];
	$a_perms = $row['user_perms'];

	$text = "<div style='text-align:center'>
	<form method='post' action='".e_SELF."' id='myform' >
	<table style='".ADMIN_WIDTH."' class='fborder'>
	<tr>
	<td style='width:25%' class='forumheader3'>".ADMSLAN_16.": </td>
	<td style='width:75%' class='forumheader3'>
	";

	$text .= $ad_name;
	$text .= "<input type='hidden' name='ad_name' size='60' value='$ad_name' />";

	$text .= "
	</td>
	</tr>";

	$text .="
	<tr>
	<td style='width:25%;vertical-align:top' class='forumheader3'>".ADMSLAN_18.": <br /></td>
	<td style='width:75%' class='forumheader3'>";
	
	$text .= "<div class='fcaption'>".ADLAN_CL_1."</div><br />"; // Settings
	$text .= checkb("C", $a_perms).ADMSLAN_64."<br />";			// Clear Cache - Previously moderate chatbox
	$text .= checkb("F", $a_perms).ADMSLAN_31."<br />";			// Configure emoticons
	$text .= checkb("G", $a_perms).ADMSLAN_32."<br />";			// Configure front page content	
	$text .= checkb("A", $a_perms).ADMSLAN_36."<br />";			// Configure Image Settings (Previously Moderate forums - NOW PLUGIN)
	$text .= checkb("L", $a_perms).ADMSLAN_76."<br />";			// Language-Pack Area. 
	$text .= checkb("T", $a_perms).ADMSLAN_34."<br />";			// Configure meta tags
	$text .= checkb("1", $a_perms).ADMSLAN_19."<br />";			// Alter site preferences		
	$text .= checkb("X", $a_perms).ADMSLAN_66."<br />";			// Configure Search
	$text .= checkb("I", $a_perms).ADMSLAN_40."<br />";			// Post links
	
	$text .= "<br /><div class='fcaption'>".ADLAN_CL_2."</div><br />"; // Users
	$text .= checkb("3", $a_perms).ADMSLAN_21."<br />";			// Modify administrator permissions		
	$text .= checkb("4", $a_perms).ADMSLAN_22."<br />";			// Moderate users/bans etc
	$text .= checkb("W", $a_perms).ADMSLAN_65."<br />";	// Configure mail settings and mailout
	
	$text .= "<br /><div class='fcaption'>".ADLAN_CL_3."</div><br />"; // Content
	$text .= checkb("D", $a_perms).ADMSLAN_29."<br />";			// Manage banners	
	$text .= checkb("5", $a_perms).ADMSLAN_23."<br />";			// create/edit custom pages/menus
	$text .= checkb("R", $a_perms).ADMSLAN_44."<br />";			// Post downloads
	$text .= checkb("Q", $a_perms).ADMSLAN_24."<br />";			// Manage download categories			
	$text .= checkb("2", $a_perms).ADMSLAN_20."<br />";			// Alter Menus
	$text .= checkb("H", $a_perms).ADMSLAN_39."<br />";			// Post news
	$text .= checkb("7", $a_perms).ADMSLAN_26."<br />";			// Oversee news categories
	$text .= checkb("N", $a_perms).ADMSLAN_47."<br />";	// Moderate submitted news
	$text .= checkb("6", $a_perms).ADMSLAN_25."<br />";			// Upload /manage files
	$text .= checkb("V", $a_perms).ADMSLAN_35."<br />";			// Configure public file uploads
	$text .= checkb("M", $a_perms).ADMSLAN_46."<br />";			// Welcome message

	$text .= "<br /><div class='fcaption'>".ADLAN_CL_6."</div><br />"; // Tools
	$text .= checkb("B", $a_perms).ADMSLAN_37."<br />";			// Moderate comments
	$text .= checkb("Y", $a_perms).ADMSLAN_67."<br />";			// file inspector
	$text .= checkb("9", $a_perms).ADMSLAN_28."<br />";			// Take site down for maintenance
	
	$text .= checkb("O", $a_perms).ADMSLAN_68."<br />";			// notify

 //	$text .= checkb("8", $a_perms).ADMSLAN_27."<br />";			// Oversee link categories - NOWPLUGIN
//	$text .= checkb("E", $a_perms).ADMSLAN_30."<br />";			// Configure news feed headlines - now plugin
//	$text .= checkb("S", $a_perms).ADMSLAN_33."<br />";			// Configure log/stats - now plugin (used for system logs in 0.8)

//	$text .= checkb("J", $a_perms).ADMSLAN_41."<br />";			// Post articles   - NOW PLUGIN
//	$text .= checkb("K", $a_perms).ADMSLAN_42."<br />";			// Post reviews    - NOW PLUGIN
//	$text .= checkb("U", $a_perms).ADMSLAN_45."<br />";			// Post polls  - NOW PLUGIN.
	
	$text .= "<br /><div class='fcaption'>".ADLAN_CL_7."</div><br />";
	$text .= checkb("Z", $a_perms).ADMSLAN_62."<br /><br />";	// Plugin Manager

	$sql->db_Select("plugin", "*", "plugin_installflag='1'");
	while ($row = $sql->db_Fetch())
	{
		$text .= checkb("P".$row['plugin_id'], $a_perms).LAN_PLUGIN." - ".$tp->toHTML($row['plugin_name'],FALSE,'RAWTEXT,defs')."<br />";
	}

// Language Rights.. --------------
	if($pref['multilanguage'])
	{
		sort($lanlist);
		$text .= "<br /><div class='fcaption'>".ADLAN_132."</div><br />\n";
		$text .= checkb($pref['sitelanguage'], $a_perms).$pref['sitelanguage']."<br />\n";
		foreach($lanlist as $langval)
		{
			$langname = $langval;
			$langval = ($langval == $pref['sitelanguage']) ? "" : $langval;
			if ($langval)
	   		{
				$text .= checkb($langval, $a_perms).$langval."<br />\n";
			}
		}
	}
	// -------------------------

	if (getperms('0'))
	{
		$text .= "<br /><br /><div class='fcaption'>".ADMSLAN_58."</div><br />";
		$text .= checkb("0", $a_perms).ADMSLAN_58."<br />";
	}

	$text .= "<br /><br />
	<a href='".e_SELF."?checkall=1' onclick=\"setCheckboxes('myform', true, 'perms[]'); return false;\">".ADMSLAN_49."</a> -
	<a href='".e_SELF."' onclick=\"setCheckboxes('myform', false, 'perms[]'); return false;\">".ADMSLAN_51."</a><br />
	<br />
	</td>
	</tr>";

	$text .= "<tr style='vertical-align:top'>
	<td colspan='2' style='text-align:center' class='forumheader'>";

	$text .= "<input class='button' type='submit' name='update_admin' value='".ADMSLAN_52."' />
	<input type='hidden' name='a_id' value='$a_id' />
	<input type='hidden' name='e-token' value='".e_TOKEN."' />";

	$text .= "</td>
	</tr>
	</table>
	</form>
	</div>";

    $text .= "<div style='text-align:center'><br /><a href='".e_SELF."'>".ADMSLAN_70."</a></div>";
	$ns->tablerender(ADMSLAN_52, $text);
}



require_once("footer.php");






function checkb($arg, $perms)
{
	if (getperms($arg, $perms))
	{
		$par = "<input type='checkbox' name='perms[]' value='$arg' checked='checked' />\n";
	}
	else
	{
		$par = "<input type='checkbox' name='perms[]' value='$arg' />\n";
	}
	return $par;
}


function renderperms($perm,$id){
	global $pref,$sql,$pt;
	if($perm == "0"){
   		return ADMSLAN_58;
	}
    $sql2 = new db;
	$lanlist = explode(",",e_LANLIST);


	if(!$pt){
    	$pt["1"] = ADMSLAN_19;
		$pt["2"] = ADMSLAN_20;
		$pt["3"] = ADMSLAN_21;
		$pt["4"] = ADMSLAN_22;	// Moderate users/bans etc
		$pt["5"] = ADMSLAN_23;	// create/edit custom pages/menus
		$pt["Q"] = ADMSLAN_24;	// Manage download categories
		$pt["6"] = ADMSLAN_25;	// Upload /manage files
		$pt["Y"] = ADMSLAN_67;	// file inspector
		$pt["L"] = ADMSLAN_76; // Language Pack Access. 
		$pt["O"] = ADMSLAN_68;	// notify
		$pt["7"] = ADMSLAN_26;
		$pt["8"] = ADMSLAN_27;
		$pt["C"] = ADMSLAN_64;
		$pt["9"] = ADMSLAN_28;
		$pt["W"] = ADMSLAN_65;
    	$pt["D"] = ADMSLAN_29;
		$pt["E"] = ADMSLAN_30;
		$pt["F"] = ADMSLAN_31;
		$pt["G"] = ADMSLAN_32;
		$pt["S"] = ADMSLAN_33;
		$pt["T"] = ADMSLAN_34;
		$pt["V"] = ADMSLAN_35;
		$pt["X"] = ADMSLAN_66;
		$pt["A"] = ADMSLAN_36;	// Configure Image Settings
		$pt["B"] = ADMSLAN_37;
		$pt["H"] = ADMSLAN_39;
		$pt["I"] = ADMSLAN_40;

		$pt["R"] = ADMSLAN_44;
		$pt["U"] = ADMSLAN_45;
		$pt["M"] = ADMSLAN_46;
		$pt["N"] = ADMSLAN_47;
		$pt["Z"] = ADMSLAN_62;
		

  //		foreach($lanlist as $lan){
  //      	$pt[$lan] = $lan;
  //		}

		$sql2->db_Select("plugin", "*", "plugin_installflag='1'");
		while ($row2 = $sql2->db_Fetch()){
			$pt[("P".$row2['plugin_id'])] = LAN_PLUGIN." - ".$row2['plugin_name'];
		}
	}

	$tmp = explode(".", $perm);
		$langperm = "";
		foreach($tmp as $pms){
			if(in_array($pms, $lanlist)){
				$langperm .= $pms."&nbsp;";
			}else{
				$permtxt[] = $pms;
                if($pt[$pms]){
		   			$ptext[] = $pt[$pms];
				}
			}
		}

	$ret = implode(" ",$permtxt);
	if($pref['multilanguage']){
		$ret .= ",&nbsp;". $langperm;
	}

	$text = "<div onclick=\"expandit('id_$id')\" style='cursor:pointer' title='".ADMSLAN_71."'>$ret</div>
	<div id='id_$id' style='display:none'><br />".implode("<br />",$ptext)."</div>";
    return $text;


}

?>
