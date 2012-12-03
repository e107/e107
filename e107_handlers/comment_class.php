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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_handlers/comment_class.php $
|     $Revision: 12974 $
|     $Id: comment_class.php 12974 2012-08-23 14:02:02Z secretr $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_comment.php");

global $comment_shortcodes;
require_once(e_FILE."shortcode/batch/comment_shortcodes.php");

/**
 * Enter description here...
 *
 */
class comment {

	/**
	 * Display the comment editing form
	 *
	 * @param unknown_type $action
	 * @param unknown_type $table
	 * @param unknown_type $id
	 * @param unknown_type $subject
	 * @param unknown_type $content_type
	 * @param unknown_type $return
	 * @param unknown_type $rating
	 * @return unknown
	 */
	 
	var $known_types = array(
			0	=> "news",
			1	=> 'content',
			2	=> 'download',
			3	=> 'faq',
			4	=> 'poll',
			5	=> 'docs',
			6	=> 'bugtrack'
	);
	 	 
	var $moderator = false;
	
	function comment() // __construct
	{
		if ((ADMIN && getperms("B")) || getperms('0')) // moderator perms. 
		{
			$this->moderator = true;	
		}	
		
	}
	 
	function form_comment($action, $table, $id, $subject, $content_type, $return = FALSE, $rating = FALSE, $tablerender = TRUE)
	{
		//rating	: boolean, to show rating system in comment
		global $pref, $sql, $tp;
		if(isset($pref['comments_disabled']) && $pref['comments_disabled'] == TRUE)
		{
			return;
		}

		require_once(e_HANDLER."ren_help.php");
		if ($this->getCommentPermissions() == 'rw')
		{
			$itemid = $id;
			$ns = new e107table;
			if ($action == "reply" && substr($subject, 0, 4) != "Re: ")
			{
				$subject = COMLAN_325.' '.$subject;
			}

			$text = "\n<div style='text-align:center'><form method='post' action='".e_SELF."?".e_QUERY."' id='dataform' >\n<table style='width:100%'>";

			if ($pref['nested_comments'])
			{
				$text .= "<tr>\n<td style='width:20%'>".COMLAN_324."</td>\n<td style='width:80%'>\n
				<input class='tbox comment subject' type='text' name='subject' size='61' value='".$tp->toForm($subject)."' maxlength='100' />\n</td>\n</tr>";
				$text2 = "";
			}
			else
			{
				$text2 = "<input type='hidden' name='subject' value='".$tp->toForm($subject)."'  />\n";
			}

			if (isset($_GET['comment']) && $_GET['comment'] == 'edit')
			{
				$eaction = 'edit';
				$id = $_GET['comment_id'];
			}
			elseif (strpos(e_QUERY, 'edit.') !== FALSE)
			{
				$eaction = 'edit';
				$tmp = explode(".", e_QUERY);
				$count = 0;

				foreach ($tmp as $t)
				{
					if ($t == "edit")
					{
						$id = $tmp[($count + 1)];
						break;
					}
					$count++;
				}
			}
			if (isset($eaction) && $eaction == "edit")
			{ // Get existing comment
				$id = intval($id);
				$sql->db_Select("comments", "*", "comment_id='{$id}' ");
				$ecom = $sql->db_Fetch();
				list($prid, $pname) = explode(".", $ecom['comment_author']);

				if ($prid != USERID || !USER)
				{ // Editing not allowed
					echo "<div style='text-align: center;'>".COMLAN_329."</div>";
					require_once(FOOTERF);
					exit;
				}

				$caption = COMLAN_318;
				$comval = $tp->toForm($ecom['comment_comment']);
				$comval = preg_replace("#\[ ".COMLAN_319.".*\]#si", "", $comval);
			}
			else
			{ // New comment - blank form
				$caption = COMLAN_9;
				$comval = "";
			}

			//add the rating select box/result ?
			$rate = "";
			if ($rating == TRUE && !(ANON == TRUE && USER == FALSE))
			{
				global $rater;
				require_once(e_HANDLER."rate_class.php");
				if (!is_object($rater))
				{
					$rater = new rater;
				}
				$rate = $rater->composerating($table, $itemid, $enter = TRUE, USERID, TRUE);
				$rate = "<tr><td style='width:20%; vertical-align:top;'>".COMLAN_327.":</td>\n<td style='width:80%;'>".$rate."</td></tr>\n";
			} //end rating area

			if (ANON == TRUE && USER == FALSE)
			{ // Box for author name (anonymous comments - if allowed)
				$text .= "<tr>\n<td style='width:20%; vertical-align:top;'>".COMLAN_16."</td>\n<td style='width:80%'>\n<input class='tbox comment author' type='text' name='author_name' size='61' value='{$author_name}' maxlength='100' />\n</td>\n</tr>";
			}
			$text .= $rate."<tr> \n
			<td style='width:20%; vertical-align:top;'>".COMLAN_8.":</td>\n<td id='commentform' style='width:80%;'>\n<textarea class='tbox comment' id='comment' name='comment' cols='62' rows='7' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'>$comval</textarea>\n<br />
			".display_help('helpb',"comment")."</td></tr>\n<tr style='vertical-align:top'> \n<td style='width:20%'>".$text2."</td>\n
			<td id='commentformbutton' style='width:80%;'>
			<input type='hidden' name='e-token' value='".e_TOKEN."' />\n
			". (isset($action) && $action == "reply" ? "<input type='hidden' name='pid' value='{$id}' />" : '').(isset($eaction) && $eaction == "edit" ? "<input type='hidden' name='editpid' value='{$id}' />" : "").(isset($content_type) && $content_type ? "<input type='hidden' name='content_type' value='{$content_type}' />" : ''). "<input class='button' type='submit' name='".$action."submit' value='".(isset($eaction) && $eaction == "edit" ? COMLAN_320 : COMLAN_9)."' />\n</td>\n</tr>\n</table>\n</form></div>";

			if ($tablerender)
			{
				$text = $ns->tablerender($caption, $text, '', TRUE);
			}
		}
		else
		{ // Comment entry not allowed - point to signup link
			$text = "<br /><div style='text-align:center'><b>".COMLAN_6." <a href='".e_SIGNUP."'>".COMLAN_321."</a> ".COMLAN_322."</b></div>";
		}
		if ($return)
		{
			return $text;
		}
		else
		{
			echo $text;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $row
	 * @param unknown_type $table
	 * @param unknown_type $action
	 * @param unknown_type $id
	 * @param unknown_type $width
	 * @param unknown_type $subject
	 * @param unknown_type $addrating
	 * @return unknown
	 */
	function render_comment($row, $table, $action, $id, $width, $subject, $addrating = FALSE)
	{
		//addrating	: boolean, to show rating system in rendered comment
		global $sql, $sc_style, $comment_shortcodes, $COMMENTSTYLE, $rater, $gen;
		global $pref, $comrow, $tp, $NEWIMAGE, $USERNAME, $RATING, $datestamp;
		global $thisaction, $thistable, $thisid;

		if (isset($pref['comments_disabled']) && $pref['comments_disabled'] == TRUE)
		{
			return;
		}


		$comrow		= $row;
		$thistable	= $table;
		$thisid		= $id;
		$thisaction	= $action;

		if ($addrating === TRUE)
		{
			require_once(e_HANDLER."rate_class.php");
			if (!$rater || !is_object($rater)){ $rater = new rater; }
		}

		require_once(e_HANDLER."level_handler.php");
		if (!$width) 
		{
			$width = 0;
		}
		if (!defined("IMAGE_nonew_comments"))
		{
			define("IMAGE_nonew_comments", (file_exists(THEME."images/nonew_comments.png") ? "<img src='".THEME_ABS."images/nonew_comments.png' alt=''  /> " : "<img src='".e_IMAGE_ABS."generic/".IMODE."/nonew_comments.png' alt=''  />"));
		}
		if (!defined("IMAGE_new_comments"))
		{
			define("IMAGE_new_comments", (file_exists(THEME."images/new_comments.png") ? "<img src='".THEME_ABS."images/new_comments.png' alt=''  /> " : "<img src='".e_IMAGE_ABS."generic/".IMODE."/new_comments.png' alt=''  /> "));
		}
		$ns	= new e107table;
		if (!$gen || !is_object($gen)){ $gen = new convert; }
		$url		= e_PAGE."?".e_QUERY;
		$unblock	= "[<a href='".e_ADMIN_ABS."comment.php?unblock-".$comrow['comment_id']."-$url-".$comrow['comment_item_id']."'>".COMLAN_1."</a>] ";
		$block		= "[<a href='".e_ADMIN_ABS."comment.php?block-".$comrow['comment_id']."-$url-".$comrow['comment_item_id']."'>".COMLAN_2."</a>] ";
		$delete		= "[<a href='".e_ADMIN_ABS."comment.php?delete-".$comrow['comment_id']."-$url-".$comrow['comment_item_id']."'>".COMLAN_3."</a>] ";
		$userinfo	= "[<a href='".e_ADMIN_ABS."userinfo.php?".$comrow['comment_ip']."'>".COMLAN_4."</a>]";

		if (!$COMMENTSTYLE) 
		{
			global $THEMES_DIRECTORY;
			$COMMENTSTYLE = "";
			if (file_exists(THEME."comment_template.php")) {
				require_once(THEME."comment_template.php");
			} else {
				require_once(e_BASE.$THEMES_DIRECTORY."templates/comment_template.php");
			}
		}
		if ($pref['nested_comments']) 
		{
			$width2 = 100 - $width;
			$total_width = (isset($pref['standards_mode']) && $pref['standards_mode'] ? "98%" : "95%");
			if($width)
			{
				$renderstyle = "
				<table style='width:".$total_width."' border='0'>
				<tr>
				<td style='width:".$width."%' ></td>
				<td style='width:".$width2."%'>" .$COMMENTSTYLE. "
				</td>
				</tr>
				</table>";
			}else{
				$renderstyle = $COMMENTSTYLE;
			}
			if($pref['comments_icon']) {
				if ($comrow['comment_datestamp'] > USERLV ) {
					$NEWIMAGE = IMAGE_new_comments;
				} else {
					$NEWIMAGE = IMAGE_nonew_comments;
				}
			} else {
				$NEWIMAGE = "";
			}
		} else {
			$renderstyle = $COMMENTSTYLE;
		}

		$highlight_search = FALSE;
		if (isset($_POST['highlight_search'])) 
		{
			$highlight_search = TRUE;
		}

		if(!defined("IMAGE_rank_main_admin_image")){
			define("IMAGE_rank_main_admin_image", (isset($pref['rank_main_admin_image']) && $pref['rank_main_admin_image'] && file_exists(THEME."forum/".$pref['rank_main_admin_image']) ? "<img src='".THEME_ABS."forum/".$pref['rank_main_admin_image']."' alt='' />" : "<img src='".e_PLUGIN_ABS."forum/images/".IMODE."/main_admin.png' alt='' />"));
		}
		if(!defined("IMAGE_rank_moderator_image")){
			define("IMAGE_rank_moderator_image", (isset($pref['rank_moderator_image']) && $pref['rank_moderator_image'] && file_exists(THEME."forum/".$pref['rank_moderator_image']) ? "<img src='".THEME_ABS."forum/".$pref['rank_moderator_image']."' alt='' />" : "<img src='".e_PLUGIN_ABS."forum/images/".IMODE."/admin.png' alt='' />"));
		}
		if(!defined("IMAGE_rank_admin_image")){
			define("IMAGE_rank_admin_image", (isset($pref['rank_admin_image']) && $pref['rank_admin_image'] && file_exists(THEME."forum/".$pref['rank_admin_image']) ? "<img src='".THEME_ABS."forum/".$pref['rank_admin_image']."' alt='' />" : "<img src='".e_PLUGIN_ABS."forum/images/".IMODE."/admin.png' alt='' />"));
		}

		$RATING = ($addrating==TRUE && $comrow['user_id'] ? $rater->composerating($thistable, $thisid, FALSE, $comrow['user_id']) : "");

		$text = $tp -> parseTemplate($renderstyle, TRUE, $comment_shortcodes);

		if ($action == "comment" && $pref['nested_comments']) 
		{
			$type = $this -> getCommentType($thistable);
			$sub_query = "
			SELECT c.*, u.*, ue.*
			FROM #comments AS c
			LEFT JOIN #user AS u ON SUBSTRING_INDEX(c.comment_author,'.',1) = u.user_id
			LEFT JOIN #user_extended AS ue ON SUBSTRING_INDEX(c.comment_author,'.',1) = ue.user_extended_id
			WHERE comment_item_id='".intval($thisid)."' AND comment_type='".$tp -> toDB($type, true)."' AND comment_pid='".intval($comrow['comment_id'])."'
			ORDER BY comment_datestamp
			";

			$sql_nc = new db;	/* a new db must be created here, for nested comment  */
			if ($sub_total = $sql_nc->db_Select_gen($sub_query)) 
			{
			  while ($row1 = $sql_nc->db_Fetch()) 
			  {
			  	if($this->isPending($row1))
				{
					$sub_total = $sub_total - 1;
					continue;	
				}	
				
				if ($pref['nested_comments']) 
				{
				  $width = min($width + 3, 80);
				}
				$text .= $this->render_comment($row1, $table, $action, $id, $width, $subject, $addrating);
				unset($width);
			  }
			}
		}		// End (nested comment handling)
		return $text;
	}

	/**
	 * Add a comment to an item
	 *
	 * @param unknown_type $author_name
	 * @param unknown_type $comment
	 * @param unknown_type $table
	 * @param integer $id - reference of item in source table to which comment is linked
	 * @param unknown_type $pid
	 * @param unknown_type $subject
	 * @param unknown_type $rateindex
	 */


	function enter_comment($author_name, $comment, $table, $id, $pid, $subject, $rateindex = FALSE)
	{
		//rateindex	: the posted value from the rateselect box (without the urljump) (see function rateselect())
		global $sql, $sql2, $tp, $e107cache, $e_event, $e107, $rater, $pref;


		if ($this->getCommentPermissions() != 'rw') return;

		if(e_SECURITY_LEVEL > 0 && session_id() && !isset($_POST['e-token']))
		{
			return;		// Security issue - e-token should match
		}

		if (isset($_GET['comment']) && $_GET['comment'] == 'edit')
		{
			$eaction = 'edit';
			$editpid = $_GET['comment_id'];
		}
		elseif (strstr(e_QUERY, "edit"))
		{
			$eaction = "edit";
			$tmp = explode(".", e_QUERY);
			$count = 0;
			foreach ($tmp as $t)
			{
				if ($t == "edit")
				{
					$editpid = $tmp[($count + 1)];
					break;
				}
				$count++;
			}
		}

		$type = $this->getCommentType($table);

		$comment = $tp->toDB($comment);
		$subject = $tp->toDB($subject);
		// Check for duplicate comment
		if (!$sql->db_Select("comments", "*", "comment_comment='".$comment."' AND comment_item_id='".intval($id)."' AND comment_type='".$tp -> toDB($type, true)."' ")) 
		{
			if ($_POST['comment']) 
			{
				if (USER == TRUE) 
				{
					$nick = USERID.".".USERNAME;
				} 
				else if($_POST['author_name'] == '') 
				{
					$nick = "0.Anonymous";
				} 
				else 
				{
					if ($sql2->db_Select("user", "*", "user_name='".$tp -> toDB($_POST['author_name'])."' ")) 
					{
						if ($sql2->db_Select("user", "*", "user_name='".$tp -> toDB($_POST['author_name'])."' AND user_ip='".$tp -> toDB($ip, true)."' ")) {
							list($cuser_id, $cuser_name) = $sql2->db_Fetch();
							$nick = $cuser_id.".".$cuser_name;
						} 
						else 
						{
							define("emessage", COMLAN_310);
						}
					} 
					else 
					{
						$nick = "0.".$tp->toDB($author_name);
					}
				}

				if (!defined("emessage"))
				{
					$ip = $e107->getip();
					require_once(e_HANDLER."encrypt_handler.php");
					$ip = encode_ip($ip);
					$_t = time();

					if($editpid)
					{
						$comment .= "\n[ ".COMLAN_319." [time=short]".time()."[/time] ]";
						$sql -> db_Update("comments", "comment_comment='{$comment}' WHERE comment_id='".intval($editpid)."' ");
						$e107cache->clear("comment");
						return;
					}
					
					$moderate = ($this->moderateComment($pref['comments_moderate'])) ? 2 : '0';
					
					if (!$sql->db_Insert("comments", "0, '".intval($pid)."', '".intval($id)."', '$subject', '$nick', '', '".$_t."', '$comment', $moderate, '$ip', '".$tp -> toDB($type, true)."', '0' "))
					{
						echo "<b>".COMLAN_323."</b> ".COMLAN_11;
					}
					else
					{
						if (USER == TRUE) 
						{
							$sql -> db_Update("user", "user_comments=user_comments+1, user_lastpost='".time()."' WHERE user_id='".USERID."' ");
						}
						$edata_li = array("comment_type" => $type, "comment_subject" => $subject, "comment_item_id" => $id, "comment_nick" => $nick, "comment_time" => $_t, "comment_comment" => $comment);
						
						if($moderate == 2)
						{
							$e_event->trigger("commentpending", $edata_li);	
						}
						else
						{
							$e_event->trigger("postcomment", $edata_li);		
						}
											
						$e107cache->clear("comment");
						if(!$type || $type == "news")
						{
							$sql->db_Update("news", "news_comment_total=news_comment_total+1 WHERE news_id=".intval($id));
						}
					}
				}
			}
		}
		else
		{
			define("emessage", COMLAN_312);
		}
		//if rateindex is posted, enter the rating from this user
		if($rateindex){
			$rater -> enterrating($rateindex);
		}

		if(defined("emessage"))
		{
			message_handler("ALERT", emessage);
		}
	}

	/** Check if comment should be moderated
	 * 
	 * @param $var = pref value of userclass. 
	 * @return boolean true if it should be moderated. 
	 */	
	function moderateComment($var)
	{	
		if ($var == e_UC_MEMBER) // different behavior to check_class();
		{
			return (USER == TRUE && ADMIN == FALSE) ? TRUE : FALSE;
		}
		
		return check_class($var);
	}	
	
	function isPending($row)
	{
		list($comment_author_id,$comment_author_name) = explode(".", $row['comment_author'],2);	
		
		if($row['comment_blocked'] > 0 && ($comment_author_id != USERID ) && $this->moderator == false)
		{
			return true;
		}
		
		return false;		
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $table
	 * @return unknown
	 */
	function getCommentType($table)
	{
		if (is_numeric($table)) { return $table;	}

		switch($table)
		{
			case "news"		: $type = 0; break;
			case "content"	: $type = 1; break;
			case "download"	: $type = 2; break;
			case "faq"		: $type = 3; break;
			case "poll"		: $type = 4; break;
			case "docs"		: $type = 5; break;
			case "bugtrack"	: $type = 6; break;
			default	: 
				$type = $table;
				break;
				/****************************************
				Add your comment type here in same format as above, ie ...
				case "your_comment_type"; $type = your_type_id; break;
				****************************************/
		}
		return $type;
	}
	
	
	/**
	 * Convert type number to (core) table string
	 * @param integer|string $type
	 * @return string
	 */
	public function getTable($type)
	{
		if (!is_numeric($type))
		{
			return $type;
		}
		else
		{
			if(varset($this->known_types[$type]))
			{
				return $this->known_types[$type];
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $table
	 * @param unknown_type $id
	 * @return unknown
	 */
	function count_comments($table, $id)
	{
		global $sql, $tp;
		$type = $this->getCommentType($table);
		$count_comments = $sql->db_Count("comments", "(*)", "WHERE comment_item_id='".intval($id)."' AND comment_type='".$tp -> toDB($type, true)."' ");
		return $count_comments;
	}


	/**
	 *	Get comment permissions; may be:
	 *		- FALSE - no permission
	 *		- 'ro' - read-only (Can't create)
	 *		- 'rw' - can create and see
	 *
	 *	This is an embryonic routine which is expected to evolve
	 */
	function getCommentPermissions()
	{
		global $pref;

		if(isset($pref['comments_disabled']) && $pref['comments_disabled'] == TRUE)
		{
        	return FALSE;
		}
		if (isset($pref['comments_class']))
		{
			if (!check_class($pref['comments_class']))
			{
				return FALSE;
			}
			return 'rw';
		}
		else
		{
			if (USER) return 'rw';			// Only allow anonymous comments if specifically enabled.
			if (ANON) return 'rw';
		}
		return 'ro';
	}



	/**
	 * Displays existing comments, and a comment entry form
	 *
	 * @param unknown_type $table - the source table for the associated item
	 * @param unknown_type $action - usually 'comment' or 'reply'
	 * @param unknown_type $id - ID of item associated with comments (e.g. news ID)
	 * @param unknown_type $width - appears to not be used
	 * @param unknown_type $subject
	 * @param unknown_type $rate
	 */
	function compose_comment($table, $action, $id, $width, $subject, $rate = FALSE, $return = FALSE, $tablerender = TRUE)
	{
		//compose comment	: single call function will render the existing comments and show the form_comment
		//rate				: boolean, to show/hide rating system in comment, default FALSE
		global $pref, $sql, $ns, $e107cache, $tp, $totcc;

		if ($this->getCommentPermissions() === FALSE) return;


		$type = $this -> getCommentType($table);

		$query = $pref['nested_comments'] ?
		"SELECT c.*, u.*, ue.* FROM #comments AS c
		LEFT JOIN #user AS u ON SUBSTRING_INDEX(c.comment_author,'.',1) = u.user_id
		LEFT JOIN #user_extended AS ue ON SUBSTRING_INDEX(c.comment_author,'.',1) = ue.user_extended_id
		WHERE c.comment_item_id='".intval($id)."' AND c.comment_type='".$tp -> toDB($type, true)."' AND c.comment_pid='0' ORDER BY c.comment_datestamp"
		:
		"SELECT c.*, u.*, ue.* FROM #comments AS c
		LEFT JOIN #user AS u ON SUBSTRING_INDEX(c.comment_author,'.',1) = u.user_id
		LEFT JOIN #user_extended AS ue ON SUBSTRING_INDEX(c.comment_author,'.',1) = ue.user_extended_id
		WHERE c.comment_item_id='".intval($id)."' AND c.comment_type='".$tp -> toDB($type, true)."' ORDER BY c.comment_datestamp";

		$text = "";
		$comment = '';
		$modcomment = '';
		$lock = '';
		$ret['comment'] = '';

		if ($comment_total = $sql->db_Select_gen($query))
		{
			$width = 0;
			while ($row = $sql->db_Fetch())
			{
				if($this->isPending($row))
				{
					$comment_total = $comment_total - 1;
					continue;	
				}	
				$lock = $row['comment_lock'];
				// $subject = $tp->toHTML($subject);
				if($action != "reply") 
				{
					if ($pref['nested_comments'])
					{
						$text .= $this->render_comment($row, $table , $action, $id, $width, $tp->toHTML($subject), $rate);
					}
					else
					{
						$text .= $this->render_comment($row, $table , $action, $id, $width, $tp->toHTML($subject), $rate);
					}
				}
			}

			if ($tablerender && !empty($text))
			{
				$text = $ns->tablerender(COMLAN_99, $text, '', TRUE);
			}

			if (!$return)
			{
				echo $text;
			}
			else
			{
				$ret['comment'] = $text;
			}

			if (ADMIN && getperms("B") && !empty($text))
			{
				$modcomment = "<div style='text-align:right'><a href='".e_ADMIN_ABS."modcomment.php?$table.$id'>".COMLAN_314."</a></div><br />";
			}
		}
		
		if ($lock != '1')
		{
			$comment = $this->form_comment($action, $table, $id, $subject, "", TRUE, $rate, $tablerender);
		}
		else
		{
			$comment = "<br /><div style='text-align:center'><b>".COMLAN_328."</b></div>";
		}

		if (!$return)
		{
			echo $modcomment.$comment;
		}

		$ret['comment'] .= $modcomment;
		$ret['comment_form'] = $comment;
		$ret['caption'] = COMLAN_99;

		return (!$return) ? "" : $ret;
	}




	function recalc_user_comments($id)
	{
	  global $sql;
	
	  if(is_array($id))
	  {
		foreach($id as $_id)
		{
		  $this->recalc_user_comments($_id);
		}
		return;
	  }
	  $qry = "
		SELECT COUNT(*) AS count
		FROM #comments
		WHERE SUBSTRING_INDEX(comment_author,'.',1) = '{$id}'
		";
	  if($sql->db_Select_gen($qry))
	  {
		$row = $sql->db_Fetch();
		$sql->db_Update("user","user_comments = '{$row['count']}' WHERE user_id = '{$id}'");
	  }
	}
	
	
	function get_author_list($id, $comment_type)
	{
		global $sql;
		$authors = array();
		$qry = "
		SELECT DISTINCT(SUBSTRING_INDEX(comment_author,'.',1)) AS author 
		FROM #comments
		WHERE comment_item_id='{$id}' AND comment_type='{$comment_type}' 
		GROUP BY author
		";
		if($sql->db_Select_gen($qry))
		{
			while($row = $sql->db_Fetch())
			{
				$authors[] = $row['author'];
			}
		}
		return $authors;
	}



	function delete_comments($table, $id)
	{
		global $sql, $tp;

		$type = $this -> getCommentType($table);
		$type = $tp -> toDB($type, true);
		$id = intval($id);
		$author_list = $this->get_author_list($id, $type);
		$num_deleted = $sql -> db_Delete("comments", "comment_item_id='{$id}' AND comment_type='{$type}'");
		$this->recalc_user_comments($author_list);
		return $num_deleted;
	}


	//1) call function getCommentData(); from file
	//2) function-> get number of records from comments db
	//3) get all e_comment.php files and collect the variables
	//4) interchange the db rows and the e_ vars
	//5) return the interchanged data in array
	//6) from file: render the returned data

	//get all e_comment.php files and collect the variables
	function get_e_comment()
	{
		$data = getcachedvars('e_comment');
		if($data!==FALSE)
		{
			return $data;
		}

		require_once(e_HANDLER."file_class.php");
		$fl = new e_file;

		$omit = array('^\.$','^\.\.$','^\/$','^CVS$','thumbs\.db','.*\._$','.bak$');
		$files = $fl->get_files(e_PLUGIN, 'e_comment.php', $omit, 1, 0);

		foreach($files as $file)
		{
			unset($e_comment, $key);
			include($file['path'].$file['fname']);
			if(isset($e_comment) && is_array($e_comment))
			{
				$key = $e_comment['eplug_comment_ids'];
				if(isset($key) && $key!='')
				{
					$data[$key] = $e_comment;
				}
			}
			else
			{
				//convert old method variables into the same array method
				$key = $e_plug_table;
				if(isset($key) && $key!='')
				{
					$e_comment['eplug_comment_ids']	= $e_plug_table;
					$e_comment['plugin_name']		= $plugin_name;
					$e_comment['plugin_path']		= $plugin_path;
					$e_comment['reply_location']	= $reply_location;
					$e_comment['db_title']			= $link_name;
					$e_comment['db_id']				= $db_id;
					$e_comment['db_table']			= $db_table;
					$e_comment['qry']				= '';
					$data[$key] = $e_comment;
				}
			}
		}
		cachevars('e_comment', $data);
		return $data;
	}


	/*
	* get number of records from comments db
	* interchange the db rows and the e_comment vars
	* return the interchanged data in array
	*
	* @param int $amount : holds numeric value for number of comments to ge
	* @param int $from : holds numeric value from where to start retrieving
	* @param string $qry : holds custom query to add in the comment retrieval
	* next two parms are only used in iterating loop if less valid records are found
	* @param int $cdvalid : number of valid records found
	* @param array $cdreta : current data set
	*/

	function getCommentData($amount='', $from='', $qry='', $cdvalid=FALSE, $cdreta=FALSE)
	{
		global $pref, $menu_pref, $sql, $sql2, $tp;

		$from1 = ($from ? $from : '0');
		$amount1 = ($amount ? $amount : '10');
		$valid = ($cdvalid ? $cdvalid : '0');
		$reta = ($cdreta ? $cdreta : array());

		//get all e_comment data
		$e_comment = $this->get_e_comment();

		$qry1 = ($qry ? " AND ".$qry : "");

		//get 'amount' of records from comment db

/*
		$query = "
		SELECT c.*, u.*, ue.* FROM #comments AS c
		LEFT JOIN #user AS u ON SUBSTRING_INDEX(c.comment_author,'.',1) = u.user_id
		LEFT JOIN #user_extended AS ue ON SUBSTRING_INDEX(c.comment_author,'.',1) = ue.user_extended_id
		WHERE c.comment_id!='' AND c.comment_blocked = 0 ".$qry1." ORDER BY c.comment_datestamp DESC LIMIT ".intval($from1).",".intval($amount1)." ";
//		WHERE c.comment_id!='' ".$qry1." ORDER BY c.comment_datestamp DESC LIMIT ".intval($from1).",".intval($amount1)." ";
*/
		$query = "
		SELECT c.*  FROM #comments AS c
		WHERE c.comment_id!='' AND c.comment_blocked = 0 ".$qry1." ORDER BY c.comment_datestamp DESC LIMIT ".intval($from1).",".intval($amount1)." ";

		if ($comment_total = $sql->db_Select_gen($query))
		{
			$width = 0;
			while ($row = $sql->db_Fetch())
			{
				$ret = array();

				//date
				$ret['comment_datestamp'] = $row['comment_datestamp'];

				//author
				$comment_author_id = substr($row['comment_author'] , 0, strpos($row['comment_author'] , "."));
				$comment_author_name = substr($row['comment_author'] , (strpos($row['comment_author'] , ".")+1));
				$ret['comment_author_id'] = $comment_author_id;
				$ret['comment_author_name'] = $comment_author_name;
				$ret['comment_author'] = (USERID ? "<a href='".e_HTTP."user.php?id.".$comment_author_id."'>".$comment_author_name."</a>" : $comment_author_name);

				//comment text
				$comment = strip_tags(preg_replace("/\[.*?\]/", "", $row['comment_comment'])); // remove bbcode - but leave text in between
				$ret['comment_comment'] = $tp->toHTML($comment, FALSE, "", "", $pref['main_wordwrap']);

				//subject
				$ret['comment_subject'] = $tp->toHTML($row['comment_subject'], TRUE);

				switch ($row['comment_type'])
				{
				  case '0' :	// news
					if($sql2 -> db_Select("news", "*", "news_id='".$row['comment_item_id']."' AND news_class REGEXP '".e_CLASS_REGEXP."' "))
					{
						$row2 = $sql2 -> db_Fetch();

						$ret['comment_type']				= COMLAN_TYPE_1;
						$ret['comment_title']				= $tp -> toHTML($row2['news_title'], TRUE,'emotes_off, no_make_clickable');
						$ret['comment_url']					= e_HTTP."comment.php?comment.news.".$row['comment_item_id'];
						$ret['comment_category_heading']	= COMLAN_TYPE_1;
						$ret['comment_category_url']		= e_HTTP."news.php";
					}
					break;
					
				  case '1' :	//	article, review or content page - defunct category, but filter them out
					break;
					
				  case '2' :	//	downloads
					$qryd = "SELECT d.download_name, dc.download_category_class, dc.download_category_id, dc.download_category_name FROM #download AS d LEFT JOIN #download_category AS dc ON d.download_category=dc.download_category_id WHERE d.download_id={$row['comment_item_id']} AND dc.download_category_class REGEXP '".e_CLASS_REGEXP."' ";
					if($sql2->db_Select_gen($qryd))
					{
						$row2 = $sql2->db_Fetch();

						$ret['comment_type']				= COMLAN_TYPE_2;
						$ret['comment_title']				= $tp -> toHTML($row2['download_name'], TRUE,'emotes_off, no_make_clickable');
						$ret['comment_url']					= e_HTTP."download.php?view.".$row['comment_item_id'];
						$ret['comment_category_heading']	= $row2['download_category_name'];
						$ret['comment_category_url']		= e_HTTP."download.php?list.".$row2['download_category_id'];
					}
					break;
						// '3' was FAQ
				  case '4' :	//	poll
					if($sql2 -> db_Select("polls", "*", "poll_id='".$row['comment_item_id']."' "))
					{
						$row2 = $sql2 -> db_Fetch();

						$ret['comment_type']				= COMLAN_TYPE_4;
						$ret['comment_title']				= $tp -> toHTML($row2['poll_title'], TRUE,'emotes_off, no_make_clickable');
						$ret['comment_url']					= e_HTTP."comment.php?comment.poll.".$row['comment_item_id'];
						$ret['comment_category_url']		= e_PLUGIN_ABS.'poll/poll.php';
					}
					break;
					
					// '5' was docs
					// '6' was bugtracker
					// 'ideas' was implemented
			
				  case 'profile' :		//	userprofile
					if(USER)
					{
						$ret['comment_type']				= COMLAN_TYPE_8;
						$ret['comment_title']				= $comment_author_name;
						$ret['comment_url']					= e_HTTP."user.php?id.".$row['comment_item_id'];
					}
					break;

				  case 'page' :		//	Custom Page
					$ret['comment_type']				= COMLAN_TYPE_PAGE;
					$ret['comment_title']				= $ret['comment_subject'] ? $ret['comment_subject'] : $ret['comment_comment'];
					$ret['comment_url']					= e_HTTP."page.php?".$row['comment_item_id'];
					break;

				  default :
					if(isset($e_comment[$row['comment_type']]) && is_array($e_comment[$row['comment_type']]))
					{
					  $var = $e_comment[$row['comment_type']];
					  $qryp='';
						//new method must use the 'qry' variable
					  if(isset($var) && $var['qry']!='')
					  {
						if ($installed = isset($pref['plug_installed'][$var['plugin_path']]))
						{
							$qryp = str_replace("{NID}", $row['comment_item_id'], $var['qry']);
							if($sql2 -> db_Select_gen($qryp))
							{
								// SecretR - comment_itemurl, comment_category options added, see list_new/sections/list_comment.php 
								$row2 = $sql2 -> db_Fetch();
								$ret['comment_type']				= $var['plugin_name'];
								$ret['comment_title']				= $tp -> toHTML($row2[$var['db_title']], TRUE,'emotes_off, no_make_clickable');
								$ret['comment_itemurl']				= varset($var['comment_location']) ? str_replace(array('{NID}', '{TTL}'), array($row['comment_item_id'], rawurlencode($row2[$var['db_title']])), $var['comment_location']) : str_replace(array('{NID}', '{TTL}'), array($row['comment_item_id'], rawurlencode($row2[$var['db_title']])), $var['reply_location']);
								$ret['comment_url']					= str_replace(array('{NID}', '{TTL}'), array($row['comment_item_id'], rawurlencode($row2[$var['db_title']])), $var['reply_location']);
								$ret['comment_category_heading']	= $var['plugin_name'];
								$ret['comment_category_url']		= varset($var['comment_category']) ? $var['comment_category'] : e_PLUGIN_ABS.$var['plugin_name'].'/'.$var['plugin_name'].'.php';

							}
						}
					//old method
					  }
					  else
					  {
						if($sql2 -> db_Select($var['db_table'], $var['db_title'], $var['db_id']." = '".$row['comment_item_id']."' "))
						{
							$row2 = $sql2 -> db_Fetch();
							$ret['comment_type']				= $var['plugin_name'];
							$ret['comment_title']				= $tp -> toHTML($row2[$var['db_title']], TRUE,'emotes_off, no_make_clickable');
							$ret['comment_url']					= str_replace("{NID}", $row['comment_item_id'], $var['reply_location']);
							$ret['comment_category_heading']	= $var['plugin_name'];
							$ret['comment_category_url']		= e_PLUGIN_ABS.$var['plugin_name'].'/'.$var['plugin_name'].'.php';
						}
					  }
					}
				  }		// End Switch
				if (varset($ret['comment_title']))
				{
					$reta[] = $ret;
					$valid++;
				}
				if ($amount && $valid >= $amount)
				{
					return $reta;
				}
			}
			//loop if less records found than given $amount - probably because we discarded some
			if ($amount && ($valid < $amount))
			{
				$reta = $this->getCommentData($amount, $from + $amount, $qry, $valid, $reta);
			}
		}
		return $reta;
	}
} //end class

?>