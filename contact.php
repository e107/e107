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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/contact.php $
|     $Revision: 12098 $
|     $Id: contact.php 12098 2011-03-12 12:38:17Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

// Experimental e-token
if(isset($_POST['send-contactus']) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

require_once("class2.php");

    // security image may be disabled by removing the appropriate shortcodes from the template.
	require_once(e_HANDLER."secure_img_handler.php");
	$sec_img = new secure_image;

if (!isset($CONTACT_FORM) || !$CONTACT_FORM)
{
	if (file_exists(THEME."contact_template.php"))
	{
		require_once(THEME."contact_template.php");
	}
	else
	{		
		// Redirect Page if no contact-form or contact-info is available. 
		if(($pref['sitecontacts']== e_UC_NOBODY) && trim(SITECONTACTINFO) == "")
		{
				header("location:".e_BASE."index.php");
				exit;
		}
		
		require_once(e_THEME."templates/contact_template.php");
	}
}

require_once(HEADERF);

if(isset($_POST['send-contactus'])/* && isset($_POST['e-token'])*/)
{

	$error = "";

	$sender_name = $tp->toEmail($_POST['author_name'],TRUE,"rawtext");
	$sender = check_email($_POST['email_send']);
	$subject = $tp->toEmail($_POST['subject'],TRUE,"rawtext");
	$body = $tp->toEmail($_POST['body'],TRUE,"rawtext");


// Check Image-Code
    if (isset($_POST['rand_num']) && !$sec_img->verify_code($_POST['rand_num'], $_POST['code_verify']))
	{
		$error .= LANCONTACT_15."\\n";
	}

// Check message body.
	if(strlen(trim($_POST['body'])) < 15)
	{
		$error .= LANCONTACT_12."\\n";
    }

// Check subject line.
	if(strlen(trim($_POST['subject'])) < 2)
	{
		$error .= LANCONTACT_13."\\n";
    }

	if(!strpos(trim($_POST['email_send']),"@"))
	{
		$error .= LANCONTACT_11."\\n";
    }



// Check email address on remote server (if enabled).
	if ($pref['signup_remote_emailcheck'] && $error == "")
	{
		require_once(e_HANDLER."mail_validation_class.php");
		list($adminuser,$adminhost) = split ("@", SITEADMINEMAIL);
		$validator = new email_validation_class;
		$validator->localuser= $adminuser;
		$validator->localhost= $adminhost;
		$validator->timeout=3;
		//	$validator->debug=1;
		//	$validator->html_debug=1;
		if($validator->ValidateEmailBox($sender) != 1)
		{
			$error .= LANCONTACT_11."\\n";
		}

	}



// No errors - so proceed to email the admin and the user (if selected).
    if(!$error)
	{
		$body .= "\n\nIP:\t".USERIP."\n";
		if(USER)
		{
			$body .= "User:\t#".USERID." ".USERNAME."\n";
		}

		if(!$_POST['contact_person'] && isset($pref['sitecontacts'])) // only 1 person, so contact_person not posted.
		{
    		if($pref['sitecontacts'] == e_UC_MAINADMIN)
			{
        		$query = "user_perms = '0' OR user_perms = '0.' ";
			}
			elseif($pref['sitecontacts'] == e_UC_ADMIN)
			{
				$query = "user_admin = 1 ";
			}
			else
			{
				$query = "FIND_IN_SET(".$pref['sitecontacts'].",user_class) ";
			}
		}
		else
		{
      		$query = "user_id = ".intval($_POST['contact_person']);
		}

    	if($sql -> db_Select("user", "user_name,user_email",$query." LIMIT 1"))
		{
    		$row = $sql -> db_Fetch();
    		$send_to = $row['user_email'];
			$send_to_name = $row['user_name'];
		}
    	else
		{
		    $send_to = SITEADMINEMAIL;
			$send_to_name = ADMIN;
		}

    	require_once(e_HANDLER."mail.php");
 		$message =  (sendemail($send_to,"[".SITENAME."] ".$subject, $body,$send_to_name,$sender,$sender_name)) ? LANCONTACT_09 : LANCONTACT_10;
    	if(isset($pref['contact_emailcopy']) && $pref['contact_emailcopy'] && $_POST['email_copy'] == 1){
			sendemail($sender,"[".SITENAME."] ".$subject, $body,ADMIN,$sender,$sender_name);
    	}
    	$ns -> tablerender('', $message);
		require_once(FOOTERF);
		exit;
    }
	else
	{
		require_once(e_HANDLER."message_handler.php");
		message_handler("P_ALERT", $error);
	}

}

if(SITECONTACTINFO && $CONTACT_INFO)
{
	require_once(e_FILE."shortcode/batch/contact_shortcodes.php");
	$text = $tp->parseTemplate($CONTACT_INFO, TRUE, $contact_shortcodes);
	$ns -> tablerender(LANCONTACT_01, $text,"contact");
}

if(isset($pref['sitecontacts']) && $pref['sitecontacts'] != 255)
{
	require_once(e_FILE."shortcode/batch/contact_shortcodes.php");
	$text = $tp->parseTemplate($CONTACT_FORM, TRUE, $contact_shortcodes);

	if(trim($text) != "")
	{
		$ns -> tablerender(LANCONTACT_02, $text, "contact");
	}
}
require_once(FOOTERF);
exit;
?>
