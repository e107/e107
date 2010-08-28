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
|     $Source: /cvs_backup/e107_0.7/e107_admin/comment.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/
require_once("../class2.php");
if (!getperms("B")) 
{
	header("location:".e_BASE."index.php");
	exit;
}
	
if (e_QUERY) 
{
	$temp = explode("-", e_QUERY);
	$action = $temp[0];
	$id = intval($temp[1]);
	$item = $temp[2];
	$c_item = $temp[3];
	if ($sql->select('comments','*', 'comment_id='.$id))
	{
		$comment = $sql->db_Fetch();
		if ($action == "block") 
		{
			$sql->db_Update("comments", "comment_blocked='1' WHERE comment_id=".$id);
		}
		if ($action == "unblock") 
		{
			$sql->db_Update("comments", "comment_blocked='0' WHERE comment_id=".$id);
		}
		if ($action == "delete") 
		{
			$sql->db_Delete("comments", "comment_id=".$id);
			switch ($comment['comment_type'])
			{
				case '0' :
				case 'news' :		// Need to update count in news record as well
					$sql2->db_Update('news', 'news_comment_total = CAST(GREATEST(CAST(news_comment_total AS SIGNED) - 1, 0) AS UNSIGNED) WHERE news_id='.$comment['comment_item_id']);
					break;
			}
		}
		if (!$e107cache->clear($item)) 
		{
			$tmp = explode("?", $item);
			$item = $tmp[0]."?news.".$c_item;
			$e107cache->clear($item);
		}
	}
}
echo "<script type='text/javascript'>window.history.go(-1);</script>\n";
?>