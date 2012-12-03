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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_handlers/override_class.php $
|     $Revision: 11678 $
|     $Id: override_class.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
	
if (!defined('e107_INIT')) { exit; }

/*
 * USAGE
 * In user code, to override an existing function...
 *
 * $override->override_function('original_func_name','mynew_function_name',['optional_include_file_from_root']);
 *
 * In e107 code...
 * if ($over_func_name = $override->override_check('original_func_name')) {
 *	$result=call_user_func($over_func_name, params...);
 * }
 *
 */
 
class override {
	var $functions = array();
	var $includes = array();
	 
	function override_function($override, $function, $include) {
		if ($include) {
			$this->includes[$override] = $include;
		}
		else if (isset($this->includes[$override])) {
			unset($this->includes[$override]);
		}
		$this->functions[$override] = $function;
	}
	 
	function override_check($override) {
		if (isset($this->includes[$override])) {
			if (file_exists($this->includes[$override])) {
				include_once($this->includes[$override]);
			}
			if (function_exists($this->functions[$override])) {
				return $this->functions[$override];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
	
?>