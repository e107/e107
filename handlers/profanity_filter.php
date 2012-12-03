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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_handlers/profanity_filter.php $
|     $Revision: 12080 $
|     $Id: profanity_filter.php 12080 2011-02-26 23:07:26Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

class e_profanityFilter 
{
	var $profanityList;

	function e_profanityFilter() 
	{
		global $pref;

		$words = explode(",", $pref['profanity_words']);
        $word_array = array();
		foreach($words as $word) 
		{
			$word = trim($word);
			if($word != "")
			{
				$word_array[] = $word;
				if (strpos($word, '&#036;') !== FALSE)
				{
					$word_array[] = str_replace('&#036;', '\$', $word);		// Special case - '$' may be 'in clear' or as entity
				}
			}
		}
		if(count($word_array))
		{
			$this->profanityList = str_replace('#','\#',implode("\b|\b", $word_array));		// We can get entities in the string - confuse the regex delimiters
		}
		unset($words);
		return TRUE;
	}

	function filterProfanities($text) 
	{
		global $pref;
		if (!$this->profanityList) 
		{
			return $text;
		}
		if ($pref['profanity_replace']) 
		{
			return preg_replace("#\b".$this->profanityList."\b#is", $pref['profanity_replace'], $text);
		} 
		else 
		{
			return preg_replace_callback("#\b".$this->profanityList."\b#is", array($this, 'replaceProfanities'), $text);
		}
	}

	function replaceProfanities($matches) 
	{
		/*!
		@function replaceProfanities callback
		@abstract replaces vowels in profanity words with stars
		@param text string - text string to be filtered
		@result filtered text
		*/

		return preg_replace("#a|e|i|o|u#i", "*" , $matches[0]);
	}
}

?>
