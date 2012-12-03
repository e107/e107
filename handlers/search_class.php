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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_handlers/search_class.php $
|     $Revision: 11678 $
|     $Id: search_class.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if ( ! defined('e107_INIT')) { exit(); }

class e_search
{
	
	var $query;
	var $text;
	var $pos;
	var $bullet;
	var $keywords;
	var $stopwords_php = "|a|about|an|and|are|as|at|be|by|com|edu|for|from|how|i|in|is|it|of|on|or|that|the|this|to|was|what|when|where|who|will|with|the|www|";
	var $stopwords_mysql = "|a|a's|able|about|above|according|accordingly|across|actually|after|afterwards|again|against|ain't|all|allow|allows|almost|alone|along|already|also|although|always|am|among|amongst|an|and|another|any|anybody|anyhow|anyone|anything|anyway|anyways|anywhere|apart|appear|appreciate|appropriate|are|aren't|around|as|aside|ask|asking|associated|at|available|away|awfully|be|became|because|become|becomes|becoming|been|before|beforehand|behind|being|believe|below|beside|besides|best|better|between|beyond|both|brief|but|by|c'mon|c's|came|can|can't|cannot|cant|cause|causes|certain|certainly|changes|clearly|co|com|come|comes|concerning|consequently|consider|considering|contain|containing|contains|corresponding|could|couldn't|course|currently|definitely|described|despite|did|didn't|different|do|does|doesn't|doing|don't|done|down|downwards|during|each|edu|eg|eight|either|else|elsewhere|enough|entirely|especially|et|etc|even|ever|every|everybody|everyone|everything|everywhere|ex|exactly|example|except|far|few|fifth|first|five|followed|following|follows|for|former|formerly|forth|four|from|further|furthermore|get|gets|getting|given|gives|go|goes|going|gone|got|gotten|greetings|had|hadn't|happens|hardly|has|hasn't|have|haven't|having|he|he's|hello|help|hence|her|here|here's|hereafter|hereby|herein|hereupon|hers|herself|hi|him|himself|his|hither|hopefully|how|howbeit|however|i|i'd|i'll|i'm|i've|ie|if|ignored|immediate|in|inasmuch|inc|indeed|indicate|indicated|indicates|inner|insofar|instead|into|inward|is|isn't|it|it'd|it'll|it's|its|itself|just|keep|keeps|kept|know|knows|known|last|lately|later|latter|latterly|least|less|lest|let|let's|like|liked|likely|little|look|looking|looks|ltd|mainly|many|may|maybe|me|mean|meanwhile|merely|might|more|moreover|most|mostly|much|must|my|myself|name|namely|nd|near|nearly|necessary|need|needs|neither|never|nevertheless|new|next|nine|no|nobody|non|none|noone|nor|normally|not|nothing|novel|now|nowhere|obviously|of|off|often|oh|ok|okay|old|on|once|one|ones|only|onto|or|other|others|otherwise|ought|our|ours|ourselves|out|outside|over|overall|own|particular|particularly|per|perhaps|php|placed|please|plus|possible|presumably|probably|provides|que|quite|qv|rather|rd|re|really|reasonably|regarding|regardless|regards|relatively|respectively|right|said|same|saw|say|saying|says|second|secondly|see|seeing|seem|seemed|seeming|seems|seen|self|selves|sensible|sent|serious|seriously|seven|several|shall|she|should|shouldn't|since|six|so|some|somebody|somehow|someone|something|sometime|sometimes|somewhat|somewhere|soon|sorry|specified|specify|specifying|still|sub|such|sup|sure|t's|take|taken|tell|tends|th|than|thank|thanks|thanx|that|that's|thats|the|their|theirs|them|themselves|then|thence|there|there's|thereafter|thereby|therefore|therein|theres|thereupon|these|they|they'd|they'll|they're|they've|think|third|this|thorough|thoroughly|those|though|three|through|throughout|thru|thus|to|together|too|took|toward|towards|tried|tries|truly|try|trying|twice|two|un|under|unfortunately|unless|unlikely|until|unto|up|upon|us|use|used|useful|uses|using|usually|value|various|very|via|viz|vs|want|wants|was|wasn't|way|we|we'd|we'll|we're|we've|welcome|well|went|were|weren't|what|what's|whatever|when|whence|whenever|where|where's|whereafter|whereas|whereby|wherein|whereupon|wherever|whether|which|while|whither|who|who's|whoever|whole|whom|whose|why|will|willing|wish|with|within|without|won't|wonder|would|would|wouldn't|yes|yet|you|you'd|you'll|you're|you've|your|yours|yourself|yourselves|zero|";
	
	function e_search()
	{
		global $query, $tp;
		$this->query = $query;
		$this->bullet = '';
		if(defined('BULLET'))
		{
			$this->bullet = '<img src="'.THEME.'images/'.BULLET.'" alt="" style="vertical-align: middle;" />';
		}
		elseif(file_exists(THEME.'images/bullet2.gif'))
		{
			$this->bullet = '<img src="'.THEME.'images/bullet2.gif" alt="bullet" style="vertical-align: middle;" />';
		}

		preg_match_all('/(\W?".*?")|(.*?)(\s|$)/', $this -> query, $boolean_keys);
		sort($this -> keywords['split'] = array_unique(array_filter(str_replace('"', '', array_merge($boolean_keys[1], $boolean_keys[2])))));
		foreach ($this -> keywords['split'] as $k_key => $key) {
			if (!$this -> stopword($key)) {
				if ($key{(strlen($key) - 1)} == '*') {
					$this -> keywords['wildcard'][$k_key] = TRUE;
					$key = substr($key, 0, -1);
				} else {
					$this -> keywords['wildcard'][$k_key] = FALSE;
				}
				if ($key{0} == '+') {
					$this -> keywords['boolean'][$k_key] = '+';
					$this -> keywords['match'][$k_key] = substr($key, 1);
				} else if ($key{0} == '-') {
					$this -> keywords['boolean'][$k_key] = '-';
					$this -> keywords['match'][$k_key] = substr($key, 1);
				} else {
					$this -> keywords['boolean'][$k_key] = FALSE;
					$this -> keywords['match'][$k_key] = $key;
				}
				$this -> keywords['exact'][$k_key] = (strpos($key, ' ') !== FALSE) ? TRUE : FALSE;
				$this -> keywords['match'][$k_key] = $tp -> toDB($this -> keywords['match'][$k_key]);
			} else {
				unset ($this -> keywords['split'][$k_key]);
			}
		}
	}

	function parsesearch($table, $return_fields, $search_fields, $weights, $handler, $no_results, $where, $order) {
		global $sql, $query, $tp, $search_prefs, $pre_title, $search_chars, $search_res, $result_flag;
		$this -> query = $tp -> toDB($query);
		if (!$search_prefs['mysql_sort']) {
			$field_operator = 'AND ';
			foreach ($this -> keywords['match'] as $k_key => $key) {
				$boolean_regex = '';
				if ($this -> keywords['boolean'][$k_key] == '+') {
					$key_operator = 'OR ';
					$break = TRUE;
					$no_exact = TRUE;
				} else if ($this -> keywords['boolean'][$k_key] == '-') {
					foreach ($this -> keywords as $unset_key => $unset_value) {
						unset($this -> keywords[$unset_key][$k_key]);
					}
					$key_operator = 'AND ';
					$boolean_regex = 'NOT';
					$no_exact = TRUE;
				} else if (!isset($break)) {
					$key_operator = 'OR ';
					if (isset($switch)) {
						$field_operator = 'OR ';
					}
					$switch = TRUE;
				} else {
					break;
				}
				$match_query .= isset($uninitial_field) ? " ".$field_operator." (" : "(";
				$uninitial_field = TRUE;
				if ($this -> keywords['wildcard'][$k_key] || !$search_prefs['boundary']) {
					$wildcard = '';
				} else {
					$wildcard = '[[:>:]]';
				}
				$key_count = 1;
				foreach ($search_fields as $field) {
					$regexp = $search_prefs['boundary'] ? "[[:<:]]".$key.$wildcard : $key;
					$match_query .= " ".$field." ".$boolean_regex." REGEXP '".$regexp."' ";
					if ($key_count != count($search_fields)) {
						$match_query .= $key_operator;
					}
					$key_count++;
				}
				$match_query .= ")";
			}
			if ($order) {
				$sql_order = 'ORDER BY ';
				$order_count = count($order);
				$i = 1;
				foreach ($order as $sort_key => $sort_value) {
					$sql_order .= $sort_key.' '.$sort_value;
					if ($i != $order_count) {
						$sql_order .= ', ';
					}
					$i++;
				}
			} else {
				$sql_order = '';
			}
			$limit = $search_prefs['php_limit'] ? ' LIMIT 0,'.$search_prefs['php_limit'] : '';
			$sql_query = "SELECT ".$return_fields." FROM #".$table." WHERE ".$where." (".$match_query.") ".$sql_order.$limit.";";
			if ((($keycount = count($this -> keywords['split'])) > 1) && (strpos($query, '"') === FALSE) && (!isset($no_exact))) {
				$exact_query[] = $query;
				$this -> keywords['split'] = array_merge($exact_query, $this -> keywords['split']);
			}
		} else {
			$this -> query = str_replace('&quot;', '"', $this -> query);
			$field_query = implode(',', $search_fields);
			foreach ($search_fields as $field_key => $field) {
				$search_query[] = "(".$weights[$field_key]." * (MATCH(".$field.") AGAINST ('".$this -> query."' IN BOOLEAN MODE)))";
			}
			$match_query = implode(' + ', $search_query);
			$sql_order = '';
			foreach ($order as $sort_key => $sort_value) {
				$sql_order .= ', '.$sort_key.' '.$sort_value;
			}
			$limit = " LIMIT ".$result_flag.",".$search_res;
			$sql_query = "SELECT SQL_CALC_FOUND_ROWS ".$return_fields.", (".$match_query.") AS relevance FROM #".$table." WHERE ".$where." ( MATCH(".$field_query.") AGAINST ('".$this -> query."' IN BOOLEAN MODE) ) HAVING relevance > 0 ORDER BY relevance DESC ".$sql_order.$limit.";";
		}

		if ($ps['results'] = $sql -> db_Select_gen($sql_query)) {
			if (!$search_prefs['mysql_sort']) {
				$x = 0;
				foreach ($search_fields as $field_key => $field) {
					$crop_fields[] = preg_replace('/(.*?)\./', '', $field);
				}
				while ($row = $sql -> db_Fetch()) {
					$weight = 0;
					foreach ($crop_fields as $field_key => $field) {
						$this -> text = $row[$field];
						foreach ($this -> keywords['match'] as $k_key => $this -> query) {
							if (stristr($this -> text, $this -> query) !== FALSE) {
								if ($this -> keywords['exact'][$k_key] || $this -> keywords['boolean'][$k_key]) {
									$weight += (($weights[$field_key] * 2) * ($keycount));
									$endweight = TRUE;
								} else if (!$endweight) {
									$weight += $weights[$field_key];
								}
							}
						}
						$endweight = FALSE;
						
					}
					foreach ($row as $r_key => $r_value) {
						$qrow[$x][$r_key] = $r_value;
						$qrow[$x]['relevance'] = $weight;
						$qrow[$x]['search_id'] = $x;
					}
					$x++;
				}
	
				foreach($qrow as $info) {
					$sortarr[] = $info['relevance'];
				}
				array_multisort($sortarr, SORT_DESC, $qrow, SORT_DESC);
				
				$result_number = ($x < ($result_flag + $search_res)) ? $x : $result_flag + $search_res;
				for ($i = $result_flag; $i < $result_number; $i++) {
					$display_row[] = $qrow[$i];
				}

			} else {
				$x = 0;
				while ($row = $sql -> db_Fetch()) {
					$display_row[] = $row;
					$x++;
				}
			}

			foreach ($display_row as $row) {
				$res = call_user_func($handler, $row);
				if (!$res['omit_result']) {
					$matches = array($res['title'], $res['summary']);
					$endcrop = FALSE;
					$output = '';
					$title = TRUE;
					foreach ($matches as $this -> text) {
						$this -> text = nl2br($this -> text);
						$t_search = $tp -> search;
						$t_replace = $tp -> replace;
						$s_search = array('<br />', '[', ']');
						$s_replace = array(' ', '<', '>');
						$search = array_merge($t_search, $s_search);
						$replace = array_merge($t_replace, $s_replace);
						$this -> text = strip_tags(str_replace($search, $replace, $this -> text));
						foreach ($this -> keywords['match'] as $match_id => $this -> query) {
							$boundary = $search_prefs['boundary'] ? '\b' : '';
							if ($this -> keywords['wildcard'][$match_id]) {
								$regex_append = ".*?".$boundary.")";
							} else {
								$regex_append = $boundary.")";	
							}
							if (($match_start = stristr($this -> text, $this -> query)) !== FALSE) {
								$this -> pos = strlen($this -> text) - strlen($match_start);
								if (!$endcrop && !$title) {
									$this -> parsesearch_crop();
									$endcrop = TRUE;
								}
								$key = substr($this -> text, $this -> pos, strlen($this -> query));
								$this -> text = preg_replace("#(".$boundary.$this -> query.$regex_append."#i", "<span class='searchhighlight'>\\1</span>", $this -> text);
							}
						}
						if ($title) {
							if ($pre_title == 0) {
								$pre_title_output = "";
							} else if ($pre_title == 1) {
								$pre_title_output = $res['pre_title'];
							} else if ($pre_title == 2) {
								$pre_title_output = $pre_title;
							}
							$this -> text = $this -> bullet." <b><a class='visit' href='".$res['link']."'>".$pre_title_output.$this -> text."</a></b><br />".$res['pre_summary'];
						} else if (!$endcrop) {
							$this -> parsesearch_crop();
						}
						$output .= $this -> text;
						$title = FALSE;
					}
					$display_rel = $search_prefs['relevance'] ? " | ".LAN_SEARCH_69.": ".round($row['relevance'], 1) : "";
					$output_array['text'][] = $output.$res['post_summary']."<br /><span class='smalltext'>".$res['detail'].$display_rel."</span><br /><br />";
				} else {
					$ps['results']--;
					$res['omit_result'] = FALSE;
				}
			}
			$ps_limit = $output_array['text'];
			$result_number = ($x < $search_res) ? $x : $search_res;
			for ($i = 0; $i < $result_number; $i++) {
				$ps['text'] .= $ps_limit[$i];
			}
		} else {
			$ps['text'] = $no_results;
		}
		if ($search_prefs['mysql_sort']) {
			$sql -> db_Query("SELECT FOUND_ROWS()");
			$frows = $sql -> db_Fetch();
			$ps['results'] = $frows[0];
		}
		return $ps;
	}
	
	function parsesearch_crop() {
		global $search_chars;
		if (strlen($this -> text) > $search_chars) {
			if ($this -> pos < ($search_chars - strlen($this -> query))) {
				$this -> text = substr($this -> text, 0, $search_chars)."...";
			} else if ($this -> pos > (strlen($this -> text) - ($search_chars - strlen($this -> query)))) {
				$this -> text = "...".substr($this -> text, (strlen($this -> text) - ($search_chars - strlen($this -> query))));
			} else {
				$this -> text = "...".substr($this -> text, ($this -> pos - round(($search_chars / 3))), $search_chars)."...";
			}
			$match_start = stristr($this -> text, $this -> query);
			$this -> pos = strlen($this -> text) - strlen($match_start);
		}
	}
	
	function stopword($key) {
		global $search_prefs;
		if ($search_prefs['mysql_sort'] && ($key{0} == '+')) {
			$key = substr($key, 1);
		}
		if (($key{(strlen($key) - 1)} != '*') && ($key{0} != '+')) {
			if (strlen($key) > 2) {
				if ($search_prefs['mysql_sort']) {
					$stopword_list = $this -> stopwords_mysql;
				} else {
					$stopword_list = $this -> stopwords_php;
				}
				if (strpos($stopword_list, '|'.$key.'|') !== FALSE) {
					$this -> stop_keys[] = $key;
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				$this -> stop_keys[] = $key;
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}
}

?>