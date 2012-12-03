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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/alt_auth/alt_login_class.php $
|     $Revision: 11678 $
|     $Id: alt_login_class.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

class alt_login{
	function alt_login($method,&$username,&$userpass){
		$newvals=array();
		define("AUTH_SUCCESS",-1);
		define("AUTH_NOUSER",1);
		define("AUTH_BADPASSWORD",2);
		require_once(e_PLUGIN."auth_".$method."/auth_".$method.".php");
		$xx = new auth_login;
		$login_result = $xx -> login($username,$userpass,$newvals);
		
		if($login_result === AUTH_SUCCESS ){
			$sql = new db;
			if(!$sql -> db_Select("user","*","user_loginname='{$username}' ")){
				// User not found in e107 database - add it now.
				$qry = "INSERT INTO ".MPREFIX."user (user_id, user_loginname, user_name, user_join) VALUES ('0', '{$username}', '{$username}', ".time().")";
				$sql -> db_Select_gen($qry);
			}
			// Set password and any other applicable fields
			$qry="user_password='".md5($userpass)."'";
			foreach($newvals as $key => $val){
				$qry .= " ,user_{$key}='{$val}' ";
			}
			$qry.=" WHERE user_loginname='{$username}' ";
			$sql -> db_Update("user",$qry);
		} else {
			switch($login_result){
				case AUTH_NOUSER:
					$username=md5("xx_nouser_xx");
					break;
				case AUTH_BADPASSWORD:
					$userpass=md5("xx_badpassword_xx");
					break;
			}
		} 
	}
}
?>