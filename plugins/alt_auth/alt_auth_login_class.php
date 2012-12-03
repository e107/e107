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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/alt_auth/alt_auth_login_class.php $
|     $Revision: 11678 $
|     $Id: alt_auth_login_class.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
class alt_login
{
	function alt_login($method, &$username, &$userpass)
	{
		global $pref;
		$newvals=array();
		define("AUTH_SUCCESS", -1);
		define("AUTH_NOUSER", 1);
		define("AUTH_BADPASSWORD", 2);
		define("AUTH_NOCONNECT", 3);
		require_once(e_PLUGIN."alt_auth/".$method."_auth.php");
		$_login = new auth_login;

		if($_login->Available === FALSE)
		{
			return false;
		}

		$login_result = $_login -> login($username, $userpass, $newvals);
		
		if($login_result === AUTH_SUCCESS )
		{
			$sql = new db;
			if (MAGIC_QUOTES_GPC == FALSE)
			{
				$username = mysql_real_escape_string($username);
			}
			$username = preg_replace("/\sOR\s|\=|\#/", "", $username);
			$username = substr($username, 0, 30);
			
			if(!$sql -> db_Select("user", "user_id", "user_loginname='{$username}' "))
			{
				// User not found in e107 database - add it now.
				$qry = "INSERT INTO #user (user_id, user_loginname, user_name, user_join) VALUES ('0','{$username}','{$username}',".time().")";
				$sql -> db_Select_gen($qry);
			}
			// Set password and any other applicable fields
			$qry="user_password='".md5($userpass)."'";
			foreach($newvals as $key => $val)
			{
				$qry .= " ,user_{$key}='{$val}' ";
			}
			$qry.=" WHERE user_loginname='{$username}' ";
			$sql->db_Update("user", $qry);
		}
		else
		{
			switch($login_result)
			{
				case AUTH_NOUSER:
					if(!isset($pref['auth_nouser']) || !$pref['auth_nouser'])
					{
						$username=md5("xx_nouser_xx");
					}
					break;
				case AUTH_NOCONNECT:
					if(!isset($pref['auth_noconn']) || !$pref['auth_noconn'])
					{
						$username=md5("xx_noconn_xx");
					}
					break;
				case AUTH_BADPASSWORD:
					$userpass=md5("xx_badpassword_xx");
					break;
			}
		} 
	}
}
?>