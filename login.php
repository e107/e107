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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/login.php $
|     $Revision: 12296 $
|     $Id: login.php 12296 2011-06-29 05:39:14Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

// Experimental e-token
if(isset($_POST['userlogin']) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

require_once("class2.php");

if (USER || e_LOGIN !='login.php') // Disable page if user logged in, or some custom e_LOGIN value is used. 
{
	header('location:'.e_BASE.'index.php');
	exit();
}

$HEADER = "";
require_once(HEADERF);
$use_imagecode = ($pref['logcode'] && extension_loaded("gd"));
if ($use_imagecode)
{
	require_once(e_HANDLER."secure_img_handler.php");
	$sec_img = new secure_image;
}

if (!USER)
{
	require_once(e_HANDLER."form_handler.php");
	$rs = new form;
	$text = "";

	$LOGIN_TABLE_LOGINMESSAGE = LOGINMESSAGE;
	$LOGIN_TABLE_USERNAME = "<input class='tbox' type='text' name='username' size='40' maxlength='100' />";
	$LOGIN_TABLE_PASSWORD = "<input class='tbox' type='password' name='userpass' size='40' maxlength='100' />";
	if ($use_imagecode)
	{
		$LOGIN_TABLE_SECIMG_LAN = LAN_LOGIN_13;
		$LOGIN_TABLE_SECIMG_HIDDEN = "<input type='hidden' name='rand_num' value='".$sec_img->random_number."' />";
		$LOGIN_TABLE_SECIMG_SECIMG = $sec_img->r_image();
		$LOGIN_TABLE_SECIMG_TEXTBOC = "<input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />";
	}
	$LOGIN_TABLE_AUTOLOGIN = "<input type='checkbox' name='autologin' value='1' />";
	$LOGIN_TABLE_AUTOLOGIN_LAN = LAN_LOGIN_8;
	$LOGIN_TABLE_SUBMIT = "<input class='button' type='submit' name='userlogin' value=\"".LAN_LOGIN_9."\" /><input type='hidden' name='e-token' value='".e_TOKEN."' />";

	$login_message = LAN_LOGIN_3." | ".SITENAME;
	if (!isset($LOGIN_TABLE) || !$LOGIN_TABLE)
	{
		if (file_exists(THEME.'login_template.php'))
		{
			require_once(THEME.'login_template.php');
		}
		else
		{
			require_once(e_BASE.$THEMES_DIRECTORY."templates/login_template.php");
		}
	}
//	$text = preg_replace("/\{(.*?)\}/e", 'varset($\1,"\1")', $LOGIN_TABLE);
	$tVars = false;
	$text = $tp->simpleParse($LOGIN_TABLE, $tVars, false);
	
//	echo preg_replace("/\{(.*?)\}/e", 'varset($\1,"\1")', $LOGIN_TABLE_HEADER);
	echo $tp->simpleParse($LOGIN_TABLE_HEADER, $tVars, false);
	
	$ns->tablerender($login_message, $text, 'login_page');

	$LOGIN_TABLE_FOOTER_USERREG = '&nbsp;';		// In case no registration system enabled
	if ($pref['user_reg'])
	{
		$LOGIN_TABLE_FOOTER_USERREG = "<a href='".e_SIGNUP."'>".LAN_LOGIN_11."</a>";
	}
//	echo preg_replace("/\{([^ ]*?)\}/e", 'varset($\1,"\1")', $LOGIN_TABLE_FOOTER);
	echo $tp->simpleParse($LOGIN_TABLE_FOOTER, $tVars, false);
}

$FOOTER = "";
require_once(FOOTERF);
//echo "</body></html>";

$sql->db_Close();

?>