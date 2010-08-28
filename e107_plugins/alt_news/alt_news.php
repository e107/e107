<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvs_backup/e107_0.7/e107_plugins/alt_news/alt_news.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

require_once(e_HANDLER."news_class.php");

function alt_news($news_category) {
	global $sql, $aj, $ns;
	$ix = new news;
	if (strstr(e_QUERY, "cat")) {
		$category = $news_category;
		if ($category != 0) {
			$gen = new convert;
			$sql2 = new db;
			$sql->db_Select("news_category", "*", "category_id='".intval($category)."'");
			list($category_id, $category_name, $category_icon) = $sql->db_Fetch();
			$category_name = $aj->tpa($category_name);
			if (strstr($category_icon, "../")) {
				$category_icon = str_replace("../", "", e_BASE.$category_icon);
			} else {
				$category_icon = THEME.$category_icon;
			}

			if ($count = $sql->db_Select("news", "*", "news_category='".intval($category)."' ORDER BY news_datestamp DESC")) {
				while ($row = $sql->db_Fetch()) {
					extract($row);
					if ($news_title == "") {
						$news_title = "Untitled";
					}
					$datestamp = $gen->convert_date($news_datestamp, "short");
					$news_body = strip_tags(substr($news_body, 0, 100))." ...";
					$comment_total = $sql2->db_Count("comments", "(*)", "WHERE comment_item_id='".intval($news_id)."' AND comment_type='0' ");
					$bullet = '';
					if(defined('BULLET'))
					{
						$bullet = '<img src="'.THEME.'images/'.BULLET.'" alt="" style="vertical-align: middle;" />';
					}
					elseif(file_exists(THEME.'images/bullet2.gif'))
					{
						$bullet = '<img src="'.THEME.'images/bullet2.gif" alt="" style="vertical-align: middle;" />';
					}
					$text .= "
						<div class='mediumtext'>
						".$bullet;

					if ($news_allow_comments)
					{
						$text .= "
						<a href='news.php?extend.".$news_id."'>".$news_title."</a>";
					}
					else
					{
						$text .= "
						<a href='comment.php?comment.news.".$news_id."'>".$news_title."</a>";
					}
					$text .= "<br />
						".LAN_NEWS_100." ".$datestamp." (".LAN_NEWS_99.": ";
					if ($news_allow_comments) {
						$text .= COMMENTOFFSTRING.")";
					} else {
						$text .= $comment_total.")";
					}
					$text .= "</div>
						".$news_body."
						<br /><br />\n";
				}
				$text = "<img src='$category_icon' alt='' /><br />". LAN_NEWS_307.$count."
					<br /><br />".$text;
				$ns->tablerender(LAN_NEWS_82." '".$category_name."'", $text, 'alt_news');
			}
		}
		return TRUE;
	}

	if ($sql->db_Select("news", "*", "news_class<255 AND (news_start=0 || news_start < ".time().") AND (news_end=0 || news_end>".time().") AND news_category='".intval($news_category)."' ORDER BY news_datestamp DESC LIMIT 0,".ITEMVIEW)) {
		$sql2 = new db;
		while (list($news['news_id'], $news['news_title'], $news['data'], $news['news_extended'], $news['news_datestamp'], $news['admin_id'], $news_category, $news['news_allow_comments'], $news['news_start'], $news['news_end'], $news['news_class']) = $sql->db_Fetch()) {

			if (check_class($news['news_class']) || !$news['news_class']) {

				if ($news['admin_id'] == 1 && $pref['siteadmin']) {
					$news['admin_name'] = $pref['siteadmin'];
				}
				else if(!$news['admin_name'] = getcachedvars($news['admin_id'])) {
					$sql2->db_Select("user", "user_name", "user_id='".intval($news['admin_id'])."' ");
					list($news['admin_name']) = $sql2->db_Fetch();
					cachevars($news['admin_id'], $news['admin_name']);
				}

					$sql2->db_Select("news_category", "*", "category_id='".intval($news_category)."' ");

				list($news['category_id'], $news['category_name'], $news['category_icon']) = $sql2->db_Fetch();
				$news['comment_total'] = $sql2->db_Count("comments", "(*)", "WHERE comment_item_id='".intval($news['news_id'])."' AND comment_type='0' ");
				$ix->render_newsitem($news);
			} else {
				if ($pref['subnews_hide_news'] == 1) {
					if ($news['admin_id'] == 1 && $pref['siteadmin']) {
						$news['admin_name'] = $pref['siteadmin'];
					}
					else if(!$news['admin_name'] = getcachedvars($news['admin_id'])) {
						$sql2->db_Select("user", "user_name", "user_id='".intval($news['admin_id'])."' ");
						list($news['admin_name']) = $sql2->db_Fetch();
						cachevars($news['admin_id'], $news['admin_name']);
					}

					$sql2->db_Select("news_category", "*", "category_id='".intval($news_category)."' ");

					list($news['category_id'], $news['category_name'], $news['category_icon']) = $sql2->db_Fetch();
					$ix->render_newsitem($news, "", "userclass");
				}
			}
		}
	}
}

?>