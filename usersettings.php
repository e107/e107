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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/usersettings.php $
|     $Revision: 12188 $
|     $Id: usersettings.php 12188 2011-05-04 20:38:01Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

// Experimental e-token
if(!empty($_POST) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}
define("e_NOCACHE",TRUE);
require_once("class2.php");
require_once(e_HANDLER."ren_help.php");
require_once(e_HANDLER."user_extended_class.php");
$ue = new e107_user_extended;

//define("US_DEBUG",TRUE);
define("US_DEBUG",FALSE);


if (!USER) {
    header("location:".e_BASE."index.php");
    exit;
}

if ((!ADMIN || !getperms('4')) && e_QUERY && e_QUERY != 'update' )
{
    header("location:".e_BASE."usersettings.php");
    exit;
}

require_once(e_HANDLER."ren_help.php");

if(is_readable(THEME."usersettings_template.php"))
{
	include_once(THEME."usersettings_template.php");
}
else
{
	include_once(e_THEME."templates/usersettings_template.php");
}
include_once(e_FILE."shortcode/batch/usersettings_shortcodes.php");

require_once(e_HANDLER."calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
$sesschange = '';						// Notice removal
$photo_to_delete = '';
$avatar_to_delete = '';

$inp = USERID;
$_uid = false;
if(is_numeric(e_QUERY))
{
	if(ADMIN)
	{
		$inp = (int)e_QUERY;
		$_uid = $inp;
		$info = get_user_data($inp);
		//Only site admin is able to change setting for other admins
		if(!is_array($info) || ($info['user_admin'] == 1 && (!defined('ADMINPERMS') || ADMINPERMS !== '0')))
		{
			header('location:'.e_BASE.'index.php');
  		exit;
		}
	}
	else
	{
		//Non admin attempting to edit another user's ID
		header('location:'.e_BASE.'index.php');
	  exit;
	}
}

require_once(HEADERF);

// Given an array of user data, return a comma separated string which includes public, admin, member classes etc as appropriate.
function addCommonClasses($udata)
{
	$tmp = array();
	if ($udata['user_class'] != "") $tmp = explode(",", $udata['user_class']);
	$tmp[] = e_UC_MEMBER;
	$tmp[] = e_UC_READONLY;
	$tmp[] = e_UC_PUBLIC;
	if (($udata['user_admin'] == 1) || ADMIN)
	{
		$tmp[] = e_UC_ADMIN;
	}
	if ((strpos($udata['user_perms'],'0') === 0) || getperms('0'))
	{
		$tmp[] = e_UC_MAINADMIN;
	}
	return implode(",", $tmp);
}



/**
 *	Does some basic checks on a string claiming to represent an off-site image
 *
 *	@param string $imageName
 *
 *	@return boolean|string FALSE for unacceptable, potentially modified string if acceptable
 */
function checkRemoteImage($imageName)
{
	$newImageName = trim(str_replace(array('\'', '"', '(', ')'), '', $imageName));		// Strip invalid characters
	if ($imageName != $newImageName)
	{
		return FALSE;
	}
	if (!preg_match('#(?:localhost|\..{2,6})\/.+\.(?:jpg|jpeg|png|svg|gif)$#i', $newImageName))
	{
		return FALSE;
	}
	return $newImageName;
}



// Save user settings (whether or not changed)
//---------------------------------------------
$error = "";

if (isset($_POST['updatesettings']) && varset($_POST['e-token']))
{	
	if(!varsettrue($pref['auth_method']) || $pref['auth_method'] == '>e107')
	{
		$pref['auth_method'] = 'e107';
	}

	if($pref['auth_method'] != 'e107')
	{
		$_POST['password1'] = '';
		$_POST['password2'] = '';
	}

/*
	if ($_uid && ADMIN)
	{	// Admin logged in and editing another user's settings - so editing a different ID
	  $inp = $_uid;
	  $remflag = TRUE;
	}
	else
	{	// Current user logged in - use their ID
	  $inp = USERID;
	}
*/

//	echo "inp = $inp <br />";
	$udata = get_user_data($inp);				// Get all the user data, including any extended fields
	$peer = ($inp == USERID ? false : true);
	$udata['user_classlist'] = addCommonClasses($udata);


	// Check external avatar
	$avName = varset($_POST['image'], '');
	$avmsg = '';
	$_POST['image'] = '';
	if ($avName)
	{
		$avName = strip_if_magic($avName);
		$avName = str_replace(array('\'', '"', '(', ')'), '', $avName);   // these are invalid anyway, so why allow them? (XSS Fix)
		if (strpos($avName, '/') !== FALSE)
		{	// Assume an off-site image
			$avName = checkRemoteImage($avName);
			if ($avName === FALSE)
			{
				$avmsg = LAN_USET_18;
			}
			$avFullName = $avName;
		}
		else
		{	// Its one of the standard choices
			$avName = $tp -> toDB($avName);
			if (strpos($avName, '-upload-') === 0)
			{	// Uploaded avatar
				$avFullName = e_FILE.'public/avatars/'.str_replace('-upload-', '', $avName);
			}
			else
			{	// Site-provided avatar
				$avFullName = e_IMAGE.'avatars/'.$avName;
			}
			if (!is_readable($avFullName))
			{
				$avmsg = LAN_USET_19.': '.$avFullName;			// Error accessing avatar
				$avName = FALSE;
			}
		}
		if ($avmsg)
		{
			$error = $avmsg;
		}
		elseif (FALSE !== ($size = getimagesize($avFullName)))
		{
			$avwidth = $size[0];
			$avheight = $size[1];
			$avmsg = '';

			$pref['im_width'] = ($pref['im_width']) ? $pref['im_width'] : 120;
			$pref['im_height'] = ($pref['im_height']) ? $pref['im_height'] : 100;
			if ($avwidth > $pref['im_width']) 
			{
				$avmsg .= LAN_USET_1." ($avwidth)<br />".LAN_USET_2.": {$pref['im_width']}<br /><br />";
			}
			if ($avheight > $pref['im_height']) 
			{
				$avmsg .= LAN_USET_3." ($avheight)<br />".LAN_USET_4.": {$pref['im_height']}";
			}
			if ($avmsg) 
			{
				$error = $avmsg;
				$avName = '';
			}
			else
			{
				$_POST['image'] = $avName;
			}
		}
		else
		{
			$error = LAN_USET_20.': '.$avFullName;
			$avName = FALSE;
		}
	}

	$signup_option_title = array(LAN_308, LAN_120, LAN_121, LAN_122, LAN_USET_6);
	$signup_option_names = array("realname", "signature", "image", "timezone", "class");

	foreach($signup_option_names as $key => $value)
	{  // Check required signup fields
		if ($pref['signup_option_'.$value] == 2 && !$_POST[$value] && !$_uid)
		{
			$error .= LAN_SIGNUP_6.$signup_option_title[$key].LAN_SIGNUP_7."\\n";
		}
    }


// Login Name checks
	if (isset($_POST['loginname']))
	{  // Only check if its been edited %*|/|&nbsp;|\#|\=|\$%
		// another option would be /[^\w\pL\.]/u (non latin words)
	//	$temp_name = trim(preg_replace('#[^a-z0-9_\.]#i', "", strip_tags($_POST['loginname'])));
	// The above preg_replace will break any non-latin login and should not be used. 
	
		$temp_name = str_replace('--', '', trim(preg_replace("/[\^\*\|\/;:#=\$'\"!#`\s\(\)%\?<>\\{}]/", '', strip_tags($_POST['loginname']))));
		if ($temp_name != $_POST['loginname'])
		{
			$error .= LAN_USET_13."\\n";
		}
		// Check if login name exceeds maximum allowed length
		if (strlen($temp_name) > varset($pref['loginname_maxlength'],30))
		{
			$error .= LAN_USET_14."\\n";
		}
		if ((strcasecmp($_POST['loginname'],"Anonymous") == 0) || (strcasecmp($_POST['loginname'],LAN_ANONYMOUS) == 0))
		{
			$error .= LAN_USET_11."\\n";
		}
		$_POST['loginname'] = $temp_name;
	}


// Password checks
	$pwreset = '';
	if ($_POST['password1'] != $_POST['password2']) {
		$error .= LAN_105."\\n";
	}
	else
	{
		if(trim($_POST['password1']) != "")
		{
			$pwreset = "user_password = '".md5(trim($_POST['password1']))."', ";
		}
	}

	if(isset($pref['signup_disallow_text']))
	{
	  $tmp = explode(",", $pref['signup_disallow_text']);
	  foreach($tmp as $disallow)
	  {
		if (($disallow != '') && strstr($_POST['username'], $disallow))
		{
		  $error .= LAN_USET_11."\\n";
		}
	  }
	}

	if (strlen(trim($_POST['password1'])) < $pref['signup_pass_len'] && trim($_POST['password1']) != "") {
		$error .= LAN_SIGNUP_4.$pref['signup_pass_len'].LAN_SIGNUP_5."\\n";
		$password1 = "";
		$password2 = "";
	}



//--------------------------------------------
//		Email address checks
//--------------------------------------------
// Split up an email address to check for banned domains.
// Return false if invalid address
function make_email_query($email, $fieldname = 'banlist_ip')
{
  global $tp;
  $tmp = strtolower($tp -> toDB(trim(substr($email, strrpos($email, "@")+1))));
  if ($tmp == '') return FALSE;
  if (strpos($tmp,'.') === FALSE) return FALSE;
  $em = array_reverse(explode('.',$tmp));
  $line = '';
  $out = array($fieldname."='*@{$tmp}'");		// First element looks for domain as email address
  foreach ($em as $e)
  {
    $line = '.'.$e.$line;
	$out[] = $fieldname."='*{$line}'";
  }
  return implode(' OR ',$out);
}


	// Always validate an email address if entered. If its blank, that's OK if checking disabled
	$_POST['email'] = $tp->toDB(trim(varset($_POST['email'],'')));
	$do_email_validate = (!varset($pref['disable_emailcheck'],FALSE)) || ($_POST['email'] !='');
	if ($do_email_validate)
	{
		if  (!check_email($_POST['email']))
		{
			$error .= LAN_106."\\n";
		}

		// Check Email address against banlist.
		$wc = make_email_query($_POST['email']);
		if ($wc) $wc = ' OR '.$wc;

		if (($wc === FALSE) || ($do_email_validate && $sql->db_Select("banlist", "*", "banlist_ip='".$_POST['email']."'".$wc)))
		{
			$error .= LAN_106."\\n";
		}


		// Check for duplicate of email address (always)
		if ($sql->db_Select("user", "user_name, user_email", "user_email='".$_POST['email']."' AND user_id !='".intval($inp)."' "))
		{
			$error .= LAN_408."\\n";
		}
	}




// Display name checks
	if (check_class($pref['displayname_class']) && isset($_POST['username']))
	{
	  // Impose a minimum length on display name
	  $username = trim(strip_tags($_POST['username']));
	  if (strlen($username) < 2)
	  {
		$error .= LAN_USET_12."\\n";
	  }
	  if (strlen($username) > varset($pref['displayname_maxlength'],15))
	  {
		$error .= LAN_USET_15."\\n";
	  }

	// Display Name exists.
	  if ($sql->db_Count("user", "(*)", "WHERE `user_name`='".$username."' AND `user_id` != '".intval($inp)."' "))
	  {
		$error .= LAN_USET_17;
	  }
	}


// Uploaded avatar and/or photo
	$user_sess = "";
	if ($file_userfile['error'] != 4)
	{
		require_once(e_HANDLER."upload_handler.php");
		require_once(e_HANDLER."resize_handler.php");

		if ($uploaded = file_upload(e_FILE."public/avatars/", "avatar=".$udata['user_id']))
		{
		  foreach ($uploaded as $upload)
		  {	// Needs the latest upload handler (with legacy and 'future' interfaces) to work
			if ($upload['name'] && ($upload['index'] == 'avatar') && $pref['avatar_upload'])
			{
				// avatar uploaded - give it a reference which identifies it as server-stored
				$_POST['image'] = "-upload-".$upload['name'];
				if ($_POST['image'] != $udata['user_image'])
				{
				  $avatar_to_delete = str_replace("-upload-", "", $udata['user_image']);
//				  echo "Avatar change; deleting {$avatar_to_delete}<br />";
				}
				if (!resize_image(e_FILE."public/avatars/".$upload['name'], e_FILE."public/avatars/".$upload['name'], "avatar"))
				{
					unset($message);
					$error .= RESIZE_NOT_SUPPORTED."\\n";
					@unlink(e_FILE."public/avatars/".$upload['name']);
					$_POST['image'] = '';
				}
			}

			if ($upload['name'] && ($upload['index'] == 'photo') && $pref['photo_upload'] )
			{
				// photograph uploaded
				$user_sess = $upload['name'];
				if (!resize_image(e_FILE."public/avatars/".$user_sess, e_FILE."public/avatars/".$user_sess, 180))
				{
					unset($message);
					$error .= RESIZE_NOT_SUPPORTED."\\n";
					@unlink(e_FILE."public/avatars/".$user_sess);
					$user_sess = '';
				}
			}
		  }
		}
	}

// See if user just wants to delete existing photo
	if (isset($_POST['user_delete_photo']))
	{
	  $photo_to_delete = $udata['user_sess'];
	  $sesschange = "user_sess = '', ";
//	  echo "Just delete old photo: {$photo_to_delete}<br />";
	}
	elseif ($user_sess != "")
	{	// Update DB with photo
	  $sesschange = "user_sess = '".$tp->toDB($user_sess)."', ";
	  if ($udata['user_sess'] == $tp->toDB($user_sess))
	  {
		$sesschange = '';			// Same photo - do nothing
//		echo "Photo not changed<br />";
	  }
	  else
	  {
		$photo_to_delete = $udata['user_sess'];
//		echo "New photo: {$user_sess} Delete old photo: {$photo_to_delete}<br />";
	  }
	}


    // Validate Extended User Fields.
	$ue_fields = "";
	if($_POST['ue'])
	{
		if ($sql->db_Select('user_extended_struct', '*', 'order by user_extended_struct_type', 'order'))		// Get both field and category definitions
		{
			$skipCat = array();
			while($row = $sql->db_Fetch())
			{
				if($row['user_extended_struct_type']) 
				{	// Its a field
					$extList["user_".$row['user_extended_struct_name']] = $row;
				}
				// else its a category
				elseif(!check_class($row['user_extended_struct_applicable']) || !check_class($row['user_extended_struct_write'])) 
				{
					$skipCat[] = $row['user_extended_struct_id'];
				}
			}
		}

		foreach ($extList as $key => $settings)
		{	// Only process field if its in a category relevant to this user, and this user should be able to change it
			if (!in_array($settings['user_extended_struct_parent'],$skipCat) && check_class($settings['user_extended_struct_applicable']) && check_class($settings['user_extended_struct_write']))
			{
				$val = '';
				if (isset($_POST['ue'][$key])) $val = $_POST['ue'][$key]; 
				$err = $ue->user_extended_validate_entry($val,$settings);
				if($err === TRUE && !$_uid)
				{  // General error - usually empty field; could be unacceptable value, or regex fail and no error message defined
					$error .= LAN_SIGNUP_6.($tp->toHtml($settings['user_extended_struct_text'],FALSE,'defs')).' '.LAN_SIGNUP_7."\\n";
				}
				elseif ($err)
				{	// Specific error message returned - usually regex fail
					$error .= $err."\\n";
					$err = TRUE;
				}
				if(!$err)
				{
					$val = $tp->toDB($val);
					$ue_fields .= ($ue_fields) ? ", " : "";
					$ue_fields .= $key."='".$val."'";
				}
			}
		}

		$ueHide = array();
		foreach (array_keys($_POST['hide']) as $key)
		{
			if (isset($extList[$key]))
			{
				$ueHide[] = $tp->toDB($key);
			}
		}
    }


// All validated here
// ------------------

// $inp - UID of user whose data is being changed (may not be the currently logged in user)
	if (!$error)
	{
	  unset($_POST['password1']);
	  unset($_POST['password2']);


      $_POST['user_id'] = intval($inp);


	  $ret = $e_event->trigger("preuserset", $_POST);

	  if(trim($_POST['user_xup']) != "")
	  {
		if($sql->db_Select('user', 'user_xup', "user_id = '".intval($inp)."'"))
		{
		  $row = $sql->db_Fetch();
		  $update_xup = ($row['user_xup'] != $_POST['user_xup']) ? TRUE : FALSE;
		}
	  }

	  if ($ret == '')
	  {
		$loginname = strip_tags($_POST['loginname']);
		if (!$loginname)
		{
		  $loginname = $udata['user_loginname'];
		}
		else
		{
		  if(!check_class($pref['displayname_class'], $udata['user_classlist'], $peer))
		  {
			$new_username = "user_name = '{$loginname}', ";
			$username = $loginname;
		  }
		}

//			if (isset($_POST['username']) && check_class($pref['displayname_class']))
		if (isset($_POST['username']) && check_class($pref['displayname_class'], $udata['user_classlist'], $peer))
		{	// Allow change of display name if in right class
		  $username = trim(strip_tags($_POST['username']));
		  $username = $tp->toDB(substr($username, 0, $pref['displayname_maxlength']));
		  $new_username = "user_name = '{$username}', ";
		}


		$_POST['signature'] = $tp->toDB($_POST['signature']);
		$_POST['realname'] = $tp->toDB($_POST['realname']);

		$new_customtitle = "";
		if(isset($_POST['customtitle']) && ($pref['forum_user_customtitle'] || ADMIN))
		{
			$new_customtitle = ", user_customtitle = '".$tp->toDB($_POST['customtitle'])."' ";
		}


		// Extended fields - handle any hidden fields
		if($ue_fields)
		{
			$hiddenFields = implode("^", $ueHide);
			if($hiddenFields != "")
			{
				$hiddenFields = "^".$hiddenFields."^";
			}
			$ue_fields .= ", user_hidden_fields = '".$hiddenFields."'";
		}


		// We can update the basic user record now
		$sql->db_Update("user", "{$new_username} {$pwreset} {$sesschange} user_email='".$tp -> toDB($_POST['email'])."', user_signature='".$_POST['signature']."', user_image='".$tp -> toDB($_POST['image'])."', user_timezone='".$tp -> toDB($_POST['timezone'])."', user_hideemail='".intval($tp -> toDB($_POST['hideemail']))."', user_login='".$_POST['realname']."' {$new_customtitle}, user_xup='".$tp -> toDB($_POST['user_xup'])."' WHERE user_id='".intval($inp)."' ");
		if ($photo_to_delete)
		{	// Photo may be a flat file, or in the database
		  delete_file($photo_to_delete);
		}
		if ($avatar_to_delete)
		{	// Avatar may be a flat file, or in the database
		  delete_file($avatar_to_delete);
		}


		// If user has changed display name, update the record in the online table
		if(isset($username) && ($username != USERNAME) && !$_uid)
		{
		  $sql->db_Update("online", "online_user_id = '".USERID.".".$username."' WHERE online_user_id = '".USERID.".".USERNAME."'");
		}


		// Only admins can update login name
		if(ADMIN && getperms("4"))
		{
		  $sql -> db_Update("user", "user_loginname='".$tp -> toDB($loginname)."' WHERE user_id='".intval($inp)."' ");
		}


		// Save extended field values
		if($ue_fields)
		{
// ***** Next line creates a record which presumably should be there anyway, so could generate an error
		  $sql->db_Select_gen("INSERT INTO #user_extended (user_extended_id, user_hidden_fields) values ('".intval($inp)."', '')");
		  $sql->db_Update("user_extended", $ue_fields." WHERE user_extended_id = '".intval($inp)."'");
		}


		// Update Userclass - only if its the user changing their own data (admins can do it another way)
		if (!$_uid && $sql->db_Select("userclass_classes", "userclass_id", "userclass_editclass IN (".USERCLASS_LIST.")"))
		{
		  $ucList = $sql->db_getList();			// List of classes which this user can edit
		  if (US_DEBUG) $admin_log->e_log_event(10,debug_backtrace(),"DEBUG","Usersettings test","Read editable list. Current user classes: ".$udata['user_class'],FALSE,LOG_TO_ROLLING);
			$cur_classes = explode(",", $udata['user_class']);			// Current class membership
			$newclist = array_flip($cur_classes);						// Array keys are now the class IDs

			// Update class list - we must take care to only change those classes a user can edit themselves
			foreach ($ucList as $c)
			{
			  $cid = $c['userclass_id'];
			  if(!in_array($cid, $_POST['class']))
			  {
				unset($newclist[$cid]);
			  }
			  else
			  {
				$newclist[$cid] = 1;
			  }
			}
			$newclist = array_keys($newclist);
			$nid = implode(',', array_diff($newclist, array('')));
			if ($nid != $udata['user_class'])
			{
			  if (US_DEBUG) $admin_log->e_log_event(10,debug_backtrace(),"DEBUG","Usersettings test","Write back classes; new list: ".$nid,FALSE,LOG_TO_ROLLING);
			  $sql->db_Update("user", "user_class='".$nid."' WHERE user_id=".intval($inp));
			}
		}


		if($update_xup == TRUE)
		{
		  require_once(e_HANDLER."login.php");
		  userlogin::update_xup($inp, $_POST['user_xup']);
		}

		$e_event->trigger("postuserset", $_POST);


		if(e_QUERY == "update")
		{
          header("Location: index.php");
		}
		$message = "<div style='text-align:center'>".LAN_150."</div>";
		$caption = LAN_151;
	  }
	  else
	  {	// Invalid data
		$message = "<div style='text-align:center'>".$ret."</div>";
		$caption = LAN_151;
	  }
	  unset($_POST);
	}
}

if ($error)
{
	require_once(e_HANDLER."message_handler.php");
	message_handler("P_ALERT", $error);
	$adref = $_POST['adminreturn'];
}

// --- User data has been update here if appropriate ---

if(isset($message))
{
	$ns->tablerender($caption, $message);
}

// ---------------------


$uuid = ($_uid) ? $_uid : USERID;

$qry = "
SELECT u.*, ue.* FROM #user AS u
LEFT JOIN #user_extended AS ue ON ue.user_extended_id = u.user_id
WHERE u.user_id='".intval($uuid)."'
";

$sql->db_Select_gen($qry);
$curVal=$sql->db_Fetch();
$curVal['userclass_list'] = addCommonClasses($curVal);

if($_POST && $error)
{     // Fix for all the values being lost when an error occurred.
	foreach($_POST as $key => $val)
	{
		$curVal["user_".$key] = $tp->post_toForm($val);
	}
	foreach($_POST['ue'] as $key => $val)
	{
		$curVal[$key] = $tp->post_toForm($val);
	}
}

require_once(e_HANDLER."form_handler.php");
$rs = new form;

$text = (e_QUERY ? $rs->form_open("post", e_SELF."?".e_QUERY, "dataform", "", " enctype='multipart/form-data'") : $rs->form_open("post", e_SELF, "dataform", "", " enctype='multipart/form-data'"));

if(e_QUERY == "update")
{
	$text .= "<div class='fborder' style='text-align:center'><br />".str_replace("*","<span style='color:red'>*</span>",LAN_USET_9)."<br />".LAN_USET_10."<br /><br /></div>";
}

$text .= $tp->parseTemplate($USERSETTINGS_EDIT, TRUE, $usersettings_shortcodes);
$text .= "<div>";

$text .= "
	<input type='hidden' name='_uid' value='{$uuid}' />
	<input type='hidden' name='e-token' value='".e_TOKEN."' style='width:100%' />
	</div>
	</form>
	";

$ns->tablerender(LAN_155, $text);

deleteExpired(ADMIN);			// This will clean up the user and user_extended databases

require_once(FOOTERF);



// Delete 'expired' user records, clean up user_extended DB
function deleteExpired($force = FALSE)
{
	global $pref, $sql;
	$temp1 = 0;
	if (isset($pref['del_unv']) && $pref['del_unv'] && $pref['user_reg_veri'] != 2)
	{
		$threshold= intval(time() - ($pref['del_unv'] * 60));
		if (($temp1 = $sql->db_Delete('user', 'user_ban = 2 AND user_join < '.$threshold)) > 0) { $force = TRUE; }
	}
	if ($force)
	{	// Remove 'orphaned' extended user field records
		$sql->db_Select_gen("DELETE `#user_extended` FROM `#user_extended` LEFT JOIN `#user` ON `#user_extended`.`user_extended_id` = `#user`.`user_id`
				WHERE `#user`.`user_id` IS NULL");
	}
	return $temp1;
}


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

function req($field) {
	global $pref;
	if ($field == 2)
	{
		$ret = "<span style='text-align:right;font-size:15px; color:red'> *</span>";
	}
	else
	{
		$ret = "";
	}
	return $ret;
}
//---------------------------------------------------------------------------------

// Delete a file from the public directories. Return TRUE on success, FALSE on failure.
// Also deletes from database if appropriate.
function delete_file($fname, $dir = 'avatars/')
{
  global $sql;
  if (!$fname) return FALSE;

  if (preg_match("#Binary (.*?)/#", $fname, $match))
  {
	return $sql -> db_Delete("rbinary", "binary_id='".$tp -> toDB($match[1])."'");
  }
  elseif (file_exists(e_FILE."public/".$dir.$fname))
  {
	unlink(e_FILE."public/".$dir.$fname);
	return TRUE;
  }
  return FALSE;
}


function headerjs() {
	global $cal;
	$script = "<script type=\"text/javascript\">
		function addtext_us(sc){
		document.getElementById('dataform').image.value = sc;
		}

		</script>\n";

	$script .= $cal->load_files();
	return $script;
}
?>
