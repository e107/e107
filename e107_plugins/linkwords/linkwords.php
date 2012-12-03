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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/linkwords/linkwords.php $
|     $Revision: 12885 $
|     $Id: linkwords.php 12885 2012-07-18 20:41:53Z e107coders $
|     $Author: e107coders $
|
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }


class e_linkwords
{
	var $lw_enabled = FALSE;		// Default to disabled to start
	var $word_list = array();		// List of link words/phrases
	var $link_list = array();		// Corresponding list of links to apply
	var $tip_list  = array();
	var $area_opts = array();		// Process flags for the various contexts
	var $block_list = array();		// Array of 'blocked' pages
	
	function e_linkwords()
	{
	  global $pref;
		/* constructor */
	// See whether they should be active on this page - if not, no point doing anything!
	  if ((strpos(e_SELF, ADMINDIR) !== FALSE) || (strpos(e_PAGE, "admin_") !== FALSE)) return;   // No linkwords on admin directories

// Now see if disabled on specific pages
	  $check_url = e_SELF.(e_QUERY ? "?".e_QUERY : '');
	  $this->block_list = explode("|",substr($pref['lw_page_visibility'],2));    // Knock off the 'show/hide' flag
	  foreach ($this->block_list as $p)
	  {
		if ($p=trim($p))
		{
		  if(substr($p, -1) == '!')
		  {
			$p = substr($p, 0, -1);
			if(substr($check_url, strlen($p)*-1) == $p) return;
		  }
		  else 
		  {
			if(strpos($check_url, $p) !== FALSE) return;
		  }
		}
	  }

	  // Will probably need linkwords on this page - so get the info
	  $this->lw_enabled = TRUE;
	  $link_sql = new db;
	  mb_internal_encoding(CHARSET);
	  if($link_sql -> db_Select("linkwords", "*", "linkword_active=0"))
	  {
		  while ($row = $link_sql->db_Fetch())
		  {
		    $lw = trim(mb_convert_case($row['linkword_word'],MB_CASE_LOWER));
			if (strpos($lw,','))
			{  // Several words to same link
			  $lwlist = explode(',',$lw);
			  foreach ($lwlist as $lw)
			  {
		        $this->word_list[] = trim($lw);
			    $this->link_list[] = $row['linkword_link'];
			  }
			}
			else
			{
		      $this->word_list[] = $lw;
			  $this->link_list[] = $row['linkword_link'];
			}
		  }
	  }
	  $this->area_opts = $pref['lw_context_visibility'];
	}


	function linkwords($text,$area = 'olddefault')
	{
	  if (!$this->lw_enabled || !array_key_exists($area,$this->area_opts) || !$this->area_opts[$area]) return $text;		// No linkwords in disabled areas


// Split up by HTML tags and process the odd bits here
	  $ptext = "";
	  $lflag = FALSE;

	  $content = preg_split('#(<.*?>)#mis', $text, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	  foreach($content as $cont)
	  {
		if (strpos($cont, "<") !== FALSE)
		{  // Its some HTML
			$ptext .= $cont;
			if (strpos($cont,"<a") !== FALSE) $lflag = TRUE;
			if (strpos($cont,"</a") !== FALSE) $lflag = FALSE;
		} 
		else 
		{  // Its the text in between
		  if ($lflag)
		  {  // Its probably within a link - leave unchanged
		    $ptext .= $cont;
		  }
		  else
		  {
			if (trim($cont))
			{  // Some non-white space - worth word matching
			  $ptext .= $this->linksproc($cont,0,count($this->word_list));
			}
			else
			{
			  $ptext .= $cont;
			}
		  }
		}
	  }
	  return $ptext;
	}
	
	function linksproc($text,$first,$limit)
	{  // This function is called recursively - it splits the text up into blocks - some containing a particular linkword
	  while (($first < $limit) && (mb_stripos($text,$this->word_list[$first]) === FALSE))   { $first++; };
	  if ($first == $limit) return $text;		// Return if no linkword found
	  
	  // There's at least one occurrence of the linkword in the text
	  $ret = '';
	  $lw = $this->word_list[$first];
	  // This splits the text into blocks, some of which will precisely contain a linkword
	  $split_line = preg_split('#\b('.$lw.')\b#iu', $text, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
	  //$split_line = mb_split('\b('.$lw.')\b', $text, -1);
	  //mb_eregi('#\b('.$lw.')\b#i', $text , $split_line);
	  foreach ($split_line AS $sl)
	  {
	    if (strcmp(mb_convert_case($sl,MB_CASE_LOWER),mb_convert_case($lw,MB_CASE_LOWER)) == 0)
		{  // Do linkword replace
		  $ret .= " <a href='".$this->link_list[$first]."' rel='external'>{$sl}</a>";
		}
		elseif (trim($sl))
		{  // Something worthwhile left - look for more linkwords in it
		  $ret .= $this->linksproc($sl,$first+1,$limit);
		}
		else
		{
		  $ret .= $sl;   // Probably just some white space
		}
	  }
	  return $ret;
	}
}

?>