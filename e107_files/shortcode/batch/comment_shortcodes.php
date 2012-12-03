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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_files/shortcode/batch/comment_shortcodes.php $
|     $Revision: 12892 $
|     $Id: comment_shortcodes.php 12892 2012-07-21 03:20:42Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }
include_once(e_HANDLER.'shortcode_handler.php');
$comment_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);
/*

SC_BEGIN SUBJECT
global $SUBJECT, $comrow, $pref, $NEWIMAGE, $tp;
if (isset($pref['nested_comments']) && $pref['nested_comments']) {
	$SUBJECT = $NEWIMAGE." ".(empty($comrow['comment_subject']) ? $subject : $tp->toHTML($comrow['comment_subject'], TRUE));
} else {
	$SUBJECT = '';
}
return $SUBJECT;
SC_END

SC_BEGIN USERNAME
global $USERNAME, $comrow;
if (isset($comrow['user_id']) && $comrow['user_id']) 
{
	$USERNAME = "<a href='".SITEURL."user.php?id.".$comrow['user_id']."'>".$comrow['user_name']."</a>\n";
}
else
{
	$comrow['user_id'] = 0;
	$USERNAME = preg_replace("/[0-9]+\./", '', $comrow['comment_author']);
	$USERNAME = str_replace("Anonymous", LAN_ANONYMOUS, $USERNAME);
}
return $USERNAME;
SC_END


SC_BEGIN TIMEDATE
global $TIMEDATE, $comrow, $datestamp, $gen;
$datestamp = $gen->convert_date($comrow['comment_datestamp'], "short");
return $datestamp;
SC_END

SC_BEGIN REPLY
global $REPLY, $comrow, $action, $pref, $table, $id, $thisaction, $thistable, $thisid;
$REPLY = '';
if($comrow['comment_lock'] != "1" && $comrow['comment_blocked'] != "2"){
	if ($thisaction == "comment" && $pref['nested_comments']) {
		$REPLY = "<a href='".SITEURL."comment.php?reply.".$thistable.".".$comrow['comment_id'].".".$thisid."'>".COMLAN_326."</a>";
	}
}
return $REPLY;
SC_END

SC_BEGIN AVATAR
global $AVATAR, $comrow;
if (isset($comrow['user_id']) && $comrow['user_id']) {
	if (isset($comrow['user_image']) && $comrow['user_image']) {
		require_once(e_HANDLER."avatar_handler.php");
		$comrow['user_image'] = avatar($comrow['user_image']);
		$comrow['user_image'] = "<div class='spacer'><img src='".$comrow['user_image']."' alt='' /></div>";
	}else{
		$comrow['user_image'] = '';
	}
}else{
	$comrow['user_image'] = '';
}
return $comrow['user_image'];
SC_END

SC_BEGIN COMMENTS
global $COMMENTS, $comrow;
return (isset($comrow['user_id']) && $comrow['user_id'] ? COMLAN_99.": ".$comrow['user_comments'] : COMLAN_194)."<br />";
SC_END

SC_BEGIN JOINED
global $JOINED, $comrow, $gen;
$JOINED = '';
if ($comrow['user_id'] && !$comrow['user_admin']) {
	$comrow['user_join'] = $gen->convert_date($comrow['user_join'], "short");
	$JOINED = ($comrow['user_join'] ? COMLAN_145." ".$comrow['user_join'] : '');
}
return $JOINED;
SC_END

SC_BEGIN COMMENT
global $COMMENT, $comrow, $tp, $pref;
if(varset($comrow['comment_blocked'])==2)
{
 	return "[".COMLAN_331."]"; // Pending Approval
}
return (isset($comrow['comment_blocked']) && $comrow['comment_blocked'] ? COMLAN_0 : $tp->toHTML($comrow['comment_comment'], TRUE, FALSE, $comrow['user_id']));
SC_END

SC_BEGIN COMMENTEDIT
global $COMMENTEDIT, $pref, $comrow, $comment_edit_query;
if ($pref['allowCommentEdit'] && USER && $comrow['user_id'] == USERID && $comrow['comment_lock'] != "1")
{
	if (!strstr(e_QUERY, "."))
	{
		return "<a href='".e_SELF."?".e_QUERY."&amp;comment=edit&amp;comment_id=".$comrow['comment_id']."'><img src='".e_IMAGE."generic/".IMODE."/newsedit.png' alt='".COMLAN_318."' title='".COMLAN_318."' style='border: 0;' /></a>";
	}
	else
	{
//		return "<a href='".e_SELF."?".$comment_edit_query.".edit.".$comrow['comment_id']."'><img src='".e_IMAGE."generic/".IMODE."/newsedit.png' alt='".COMLAN_318."' title='".COMLAN_318."' style='border: 0;' /></a>";
		return "<a href='".SITEURL."comment.php?".$comment_edit_query.".edit.".$comrow['comment_id']."'><img src='".e_IMAGE."generic/".IMODE."/newsedit.png' alt='".COMLAN_318."' title='".COMLAN_318."' style='border: 0;' /></a>";
	}
}
else
{
	return "";
}
SC_END

SC_BEGIN RATING
global $RATING;
return $RATING;
SC_END

SC_BEGIN IPADDRESS
global $IPADDRESS, $comrow;
require_once(e_HANDLER."encrypt_handler.php");
return (ADMIN ? "<a href='".SITEURL."userposts.php?0.comments.".$comrow['user_id']."'>".COMLAN_330." ".decode_ip($comrow['comment_ip'])."</a>" : "");
SC_END

SC_BEGIN LEVEL
global $LEVEL, $comrow, $pref;
$ldata = get_level($comrow['user_id'], $comrow['user_forums'], $comrow['user_comments'], $comrow['user_chats'], $comrow['user_visits'], $comrow['user_join'], $comrow['user_admin'], $comrow['user_perms'], $pref);
return ($comrow['user_admin'] ? $ldata[0] : $ldata[1]);
SC_END

SC_BEGIN LOCATION
global $LOCATION, $comrow, $tp;
return (isset($comrow['user_location']) && $comrow['user_location'] ? COMLAN_313.": ".$tp->toHTML($comrow['user_location'], TRUE) : '');
SC_END

SC_BEGIN SIGNATURE
global $SIGNATURE, $comrow, $tp;
$SIGNATURE = (isset($comrow['user_signature']) && $comrow['user_signature'] ? $tp->toHTML($comrow['user_signature'], true) : '');
return $SIGNATURE;
SC_END

*/

?>