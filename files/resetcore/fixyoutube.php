<?php

require_once('./../../class2.php');

if (!ADMIN)
{
	echo 'Not allowed!';
	exit();
}

// Comment out whichever isn't required
define('YT_TEST_MODE', FALSE);
//define('YT_TEST_MODE', TRUE);


echo "Youtube tag conversion<br /><br />";


$ytChanged = FALSE;

/**
 *	Check selected fields in a table for youtube tags to convert
 *
 *	@param string $tableName
 *	@param string $idField - the field which identifies a particular record in the table (usually the autoincrement field)
 *	@param string $fieldList - comma separated list of fields to check
 */
function checkTable($tableName, $idField, $fieldList,$test = TRUE)
{
	global $sql, $sql2, $ytChanged;
	echo 'Checking table: '.$tableName.'...';
	$temp = $sql->db_Select($tableName, $idField.','.$fieldList);
	if ($temp === FALSE)
	{
		echo 'not present/error.<br /><br />';
		return;
	}
	elseif ($temp = 0)
	{
		echo 'No data found.<br /><br />';
		return;
	}
	$fieldArray = explode(',', $fieldList);
	foreach ($fieldArray as $k => $v)
	{
		$fieldArray[$k] = trim($v);
	}
	while ($row = $sql->db_Fetch(MYSQL_ASSOC))
	{
		$ytChanged = FALSE;
		unset($temp);
		
		foreach ($fieldArray as $f)
		{
			$temp[$f] = preg_replace_callback('#<object(?:.*?)</object>#i', 'youtubeConvert', $row[$f]);
		}
		if ($ytChanged)
		{
			$spacer = '';
			$new_data = '';
			foreach ($temp as $fn => $fv)
			{
				$new_data .= $spacer."`{$fn}`='{$fv}'";
				$spacer = ', ';
			}
			if($test == FALSE)
			{
				$sql2->db_Update($tableName,  $new_data." WHERE `{$idField}`='{$row[$idField]}'");
				echo '<br />'.$tableName.": Row ID {$row[$idField]} changed";	
			}
			else
			{
				echo "<br />Test: ".$new_data;
			}
			
		}
	}
	echo '...Done<br />';
}


function youtubeConvert($matches)
{
	global $tp, $ytChanged;

	// Need to handle some legacy formats, else the xml parser gets indigestion
	$t = preg_replace_callback('#(\.com/v/.{7,12})(\&)#', 'quoteQuery', $matches[0]);
	$t = str_replace('&&quot;', '&quot;', $t);
	$t = str_replace('&quot;', '"', $t);
	$t = str_replace('&', '&amp;', $t);

	$passInfo = array(0 => '', 1 => 'youtube', 2 => '', 3 => '', 4 => $t, 5 => '');
	$temp = $tp->checkYoutube($passInfo);		// Sufficient to fool the youtube code parser
	if (strpos($temp, '[youtube') === 0)
	{
		$ytChanged = TRUE;
		return $temp;			// Successful conversion
	}
	return $matches[0];			// Else don't change anything
}



function quoteQuery($matches)
{
	return $matches[1].'?';
}


checkTable('forum_t', 'thread_id', 'thread_thread', YT_TEST_MODE);
checkTable('submitnews', 'submitnews_id', 'submitnews_item', YT_TEST_MODE);
checkTable('news', 'news_id', 'news_body,news_extended', YT_TEST_MODE);
checkTable('pcontent', 'content_id', 'content_text', YT_TEST_MODE);
checkTable('faq', 'faq_id', 'faq_answer', YT_TEST_MODE);

echo 'Complete<br />';

?>
