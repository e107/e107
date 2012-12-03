<?php

/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (c) e107 Inc. 2008-2010
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/request.php $
|     $Revision: 12327 $
|     $Id: request.php 12327 2011-07-29 19:48:09Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

// ********************************** SEE HIGHLIGHTED AND NUMBERED QUERIES *****************************

// Prevent token re-generation
define('e_TOKEN_FREEZE', true);
if($_SESSION['download_splash'])
{
	define('e_NOCACHE',TRUE);
}

require_once("class2.php");
include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_download.php");

if (!e_QUERY || isset($_POST['userlogin'])) 
{
	header("location: {$e107->base_path}");
	exit();
}

// ---------------------- Experimental ----------


$req_cookie = 'e-request_'.md5($_SERVER['SERVER_ADDR']);

if(isset($_COOKIE[$req_cookie]) && ($_COOKIE[$req_cookie]!= intval(e_QUERY)) && $_SESSION['download_splash'] !==TRUE) // if cookie found, suggest to try later
{
	$_SESSION['download_splash'] = FALSE;
	require_once(HEADERF);
	$srch = array("[", "]");
	$repl = array("<a href='".$_SERVER['REQUEST_URI']."'>", "</a>");
	$text = str_replace($srch,$repl,LAN_dl_79);
	
	$ns->tablerender(LAN_dl_82,$text);
	require_once(FOOTERF);
	
	exit();
}

if(varset($pref['download_nomultiple'])==1 )
{
	if(!setcookie($req_cookie, intval(e_QUERY), time() + 30, "/")) // set the cookie and if it fails, request cookies be enabled
	{
		$_SESSION['download_splash'] = FALSE;
		require_once(HEADERF);
		$srch = array("]","[");
		$repl = array("</a>","<a href='".$_SERVER['REQUEST_URI']."'>");
		$text = str_replace($srch,$repl,LAN_dl_80);
		$ns->tablerender(LAN_dl_81, $text);
		require_once(FOOTERF);
		exit();
	}
}

// ----------------------




$id = FALSE;
if (!is_numeric(e_QUERY)) 
{
	if ($sql->db_Select('download', 'download_id', "download_url='".$tp -> toDB(e_QUERY)."'")) 
	{
		$row = $sql->db_Fetch();
		$type = 'file';
		$id = $row['download_id'];
	} 
	elseif((strpos(e_QUERY, "http://") === 0) || (strpos(e_QUERY, "ftp://") === 0) || (strpos(e_QUERY, "https://") === 0)) 
	{
		header("location: ".e_QUERY);
		exit();
	} 
	elseif(file_exists($DOWNLOADS_DIRECTORY.e_QUERY)) 		// 1 - should we allow this?
	{
		send_file($DOWNLOADS_DIRECTORY.e_QUERY);
		exit();
	}
}


if(strstr(e_QUERY, "mirror")) 
{	// Download from mirror
	list($action, $download_id, $mirror_id) = explode(".", e_QUERY);
	$download_id = intval($download_id);
	$mirror_id = intval($mirror_id);
	$qry = "SELECT d.*, dc.download_category_class FROM #download as d LEFT JOIN #download_category AS dc ON dc.download_category_id = d.download_category WHERE d.download_id = {$download_id}";
	if ($sql->db_Select_gen($qry)) 
	{
		$row = $sql->db_Fetch();
		extract($row);
		if (check_class($download_category_class) && check_class($download_class)) 
		{
			if($pref['download_limits'] && $download_active == 1) 
			{
				check_download_limits();
			}
			$mirrorList = explode(chr(1), $download_mirror);
			$mstr = "";
			foreach($mirrorList as $mirror) 
			{
				if($mirror) 
				{
					$tmp = explode(",", $mirror);
					$mid = intval($tmp[0]);
					$address = $tmp[1];
					$requests = $tmp[2];
					if($tmp[0] == $mirror_id) 
					{
						$gaddress = trim($address);
						$requests ++;
					}
					$mstr .= $mid.",".$address.",".$requests.chr(1);
				}
			}
			$sql->db_Update("download", "download_requested = download_requested + 1, download_mirror = '{$mstr}' WHERE download_id = '".intval($download_id)."'");
			$sql->db_Update("download_mirror", "mirror_count = mirror_count + 1 WHERE mirror_id = '".intval($mirror_id)."'");
			header("Location: {$gaddress}");
			exit();
		}
		header("Location: ".e_BASE."download.php?error.{$download_id}.1");
		exit;
	}
}

$tmp = explode(".", e_QUERY);
if (!$tmp[1] || strstr(e_QUERY, "pub_")) 
{
	$id = intval($tmp[0]);
	$type = "file";
} 
else 
{
	$table = preg_replace("#\W#", "", $tp -> toDB($tmp[0], true));
	$id = intval($tmp[1]);
	$type = "image";
}


if(varset($pref['download_splashdelay'])==1 )
{
	
	if($type == 'file' && !varsettrue($_SESSION['download_splash']) && (e_MENU != "nosplash")) // just received request, so show page and refresh after a pause. 
	{	
		$SPLASH_PREVIEW = ((e_QUERY == "preview") && getperms('0')) ? TRUE : FALSE;
		
		if(!$SPLASH_PREVIEW)
		{
			$_SESSION['download_splash'] = TRUE;
			
			$theLink = SITEURL."request.php?".intval(e_QUERY);
			header("Refresh: 3; url=\"".$theLink."\"");

			function core_head() // deprecated function in 0.8
			{
				return '<meta http-equiv="refresh" content="5; URL=request.php?'.intval(e_QUERY).'" />';	// in case the header fails. 
			}
				
		}
		
		require_once(HEADERF);
	
		$template_name = "request_template.php";
		if(is_readable(THEME."templates/".$template_name))
		{
			require_once(THEME."templates/".$template_name);
		}
		elseif(is_readable(THEME.$template_name))
		{
			require_once(THEME.$template_name);
		}
		else
		{
			require_once(e_THEME."templates/".$template_name);
		}
		
		$srch = array();
		$repl = array();
		
		$srch[0] = "{REQUEST_MESSAGE}";
		$repl[0] = defined("LAN_dl_83") ? LAN_dl_83 : "Your download will begin in a moment..."; 
			
		$srch[1] = "{REQUEST_CLICKLINK}";
		$repl[1] = defined("LAN_dl_84") ? LAN_dl_84 : "If your download doesn't start within a few seconds, please [click here]."; 
			
		$srch[2] = "]";
		$repl[2] = "</a>";
		
		$srch[3] = "[";
		$repl[3] = "<a class='request-splash-clicklink' href='request.php?[nosplash]".intval(e_QUERY)."'>";
		
		$text = str_replace($srch,$repl,$REQUEST_TEMPLATE);
				
		$final_text = $tp->parseTemplate($text,TRUE);
		
		$ns->tablerender(LAN_dl_82,$final_text,'request-splash');
		
		require_once(FOOTERF);		
		exit;		
	} 
	else // redirected, so continue.
	{
		$_SESSION['download_splash'] = FALSE;
	}	
		
}



if (preg_match("#.*\.[a-z,A-Z]{3,4}#", e_QUERY)) 
{
	if(strstr(e_QUERY, "pub_"))
	{
		$bid = str_replace("pub_", "", e_QUERY);
		if (file_exists(e_FILE."public/".$bid))
		{
			send_file(e_FILE."public/".$bid);
			exit();
		}
	}
	if (file_exists($DOWNLOADS_DIRECTORY.e_QUERY)) 
	{
		send_file($DOWNLOADS_DIRECTORY.e_QUERY);
		exit();
	}
	require_once(HEADERF);
	$ns->tablerender(LAN_dl_61, "<div style='text-align:center'>".LAN_dl_65."\n<br /><br />\n<a href='javascript:history.back(1)'>".LAN_dl_64."</a></div>");
	require_once(FOOTERF);
	exit();
}

if ($type == "file")
{
	$qry = "SELECT d.*, dc.download_category_class FROM #download as d LEFT JOIN #download_category AS dc ON dc.download_category_id = d.download_category WHERE d.download_id = {$id}";
	if ($sql->db_Select_gen($qry)) 
	{
		$row = $sql->db_Fetch();
		if (check_class($row['download_category_class']) && check_class($row['download_class'])) 
		{
			if ($row['download_active'] == 0)
			{  // Inactive download - don't allow
				require_once(HEADERF);
				
				$srch = array('--LINK--','[',']');
				$repl = array("<a href='".e_HTTP.'download.php'."'>","<a href='".e_HTTP.'download.php'."'>","</a>");
								
				$ns -> tablerender(LAN_dl_61, "<div style='text-align:center'>".str_replace($srch,$repl,LAN_dl_78).'</div>');
				require_once(FOOTERF);
				exit();
			}

			if($pref['download_limits'] && $row['download_active'] == 1) 
			{
				check_download_limits();
			}
			extract($row);
			if($download_mirror) 
			{
				$array = explode(chr(1), $download_mirror);
				$c = (count($array)-1);
				for ($i=1; $i < $c; $i++) 
				{
					$d = mt_rand(0, $i);
					$tmp = $array[$i];
					$array[$i] = $array[$d];
					$array[$d] = $tmp;
				}
				$tmp = explode(",", $array[0]);
				$mirror_id = $tmp[0];
				$mstr = "";
				foreach($array as $mirror) 
				{
					if($mirror) 
					{
						$tmp = explode(",", $mirror);
						$mid = $tmp[0];
						$address = $tmp[1];
						$requests = $tmp[2];
						if($tmp[0] == $mirror_id) 
						{
							$gaddress = trim($address);
							$requests ++;
						}
					  $mstr .= $mid.",".$address.",".$requests.chr(1);
					}
				}
				$sql -> db_Update("download", "download_requested = download_requested + 1, download_mirror = '{$mstr}' WHERE download_id = '".intval($download_id)."'");
				$sql -> db_Update("download_mirror", "mirror_count = mirror_count + 1 WHERE mirror_id = '".intval($mirror_id)."'");

				header("Location: ".$gaddress);
				exit();
			}

			// increment download count
			$sql->db_Update("download", "download_requested = download_requested + 1 WHERE download_id = '{$id}'");
			$user_id = USER ? USERID : 0;
			$ip = $e107->getip();
			$request_data = "'0', '{$user_id}', '{$ip}', '{$id}', '".time()."'";
			//add request info to db
			$sql->db_Insert("download_requests", $request_data, FALSE);
			if (preg_match("/Binary\s(.*?)\/.*/", $download_url, $result)) 
			{
				$bid = $result[1];
				$result = @mysql_query("SELECT * FROM ".MPREFIX."rbinary WHERE binary_id = '{$bid}'");
				$binary_data = @mysql_result($result, 0, "binary_data");
				$binary_filetype = @mysql_result($result, 0, "binary_filetype");
				$binary_name = @mysql_result($result, 0, "binary_name");
				header("Content-type: {$binary_filetype}");
				header("Content-length: {$download_filesize}");
				header("Content-Disposition: attachment; filename={$binary_name}");
				header("Content-Description: PHP Generated Data");
				echo $binary_data;
				exit();
			}
			if (strstr($download_url, "http://") || strstr($download_url, "ftp://") || strstr($download_url, "https://")) {
				header("Location: {$download_url}");
				exit();
			} 
			else 
			{
				if (file_exists($DOWNLOADS_DIRECTORY.$download_url)) 
				{
					send_file($DOWNLOADS_DIRECTORY.$download_url);
					exit();
				} 
				elseif(file_exists(e_FILE."public/{$download_url}")) 
				{
					send_file(e_FILE."public/{$download_url}");
					exit();
				}
			}
		} 
		else 
		{	// Download Access Denied.
			if((!strpos($pref['download_denied'],".php") &&
				!strpos($pref['download_denied'],".htm") &&
				!strpos($pref['download_denied'],".html") &&
				!strpos($pref['download_denied'],".shtml") ||
				(strpos($pref['download_denied'],"signup.php") && USER == TRUE)
				))
			{
				header("Location: ".e_BASE."download.php?error.{$id}.1");
				exit();
			}
			else
			{
				header("Location: ".trim($pref['download_denied']));
				exit();
			}
		}
	}
	else if(strstr(e_QUERY, "pub_"))
	{
		/* check to see if public upload and not in download table ... */
		$bid = str_replace("pub_", "", e_QUERY);
		if($result = @mysql_query("SELECT * FROM ".MPREFIX."rbinary WHERE binary_id = '$bid' "))
		{
			$binary_data = @mysql_result($result, 0, "binary_data");
			$binary_filetype = @mysql_result($result, 0, "binary_filetype");
			$binary_name = @mysql_result($result, 0, "binary_name");
			header("Content-type: {$binary_filetype}");
			header("Content-length: {$download_filesize}");
			header("Content-Disposition: attachment; filename={$binary_name}");
			header("Content-Description: PHP Generated Data");
			echo $binary_data;
			exit();
		}
	}

	require_once(HEADERF);
	$ns -> tablerender(LAN_dl_61, "<div style='text-align:center'>".LAN_dl_65."<br /><br /><a href='javascript:history.back(1)'>".LAN_dl_64."</a></div>");
	require_once(FOOTERF);
	exit();
}

$sql->db_Select($table, "*", "{$table}_id = '{$id}'");
$row = $sql->db_Fetch();
extract($row);
$image = ($table == "upload" ? $upload_ss : $download_image);
if (preg_match("/Binary\s(.*?)\/.*/", $image, $result)) 
{
	$bid = $result[1];
	$result = @mysql_query("SELECT * FROM ".MPREFIX."rbinary WHERE binary_id = '{$bid}'");
	$binary_data = @mysql_result($result, 0, "binary_data");
	$binary_filetype = @mysql_result($result, 0, "binary_filetype");
	$binary_name = @mysql_result($result, 0, "binary_name");
	header("Content-type: {$binary_filetype}");
	header("Content-Disposition: inline; filename={$binary_name}");
	echo $binary_data;
	exit();
}


$image = ($table == "upload" ? $upload_ss : $download_image);

if (strpos($image, "http") !== FALSE) 
{
	header("Location: {$image}");
	exit();
} 
else 
{
	if ($table == "download") 
	{
		require_once(HEADERF);
		if (file_exists(e_FILE."download/{$image}")) 
		{
			$disp = "<div style='text-align:center'><img src='".e_FILE."download/{$image}' alt='' /></div>";
		}
		else if(file_exists(e_FILE."downloadimages/{$image}")) 
		{
			$disp = "<div style='text-align:center'><img src='".e_FILE."downloadimages/{$image}' alt='' /></div>";
		} 
		else 
		{
			$disp = "<div style='text-align:center'><img src='".e_FILE."public/{$image}' alt='' /></div>";
		}
		$disp .= "<br /><div style='text-align:center'><a href='javascript:history.back(1)'>".LAN_dl_64."</a></div>";
		$ns->tablerender($image, $disp);

		require_once(FOOTERF);
	} else 
	{
		if (is_file(e_FILE."public/{$image}")) 
		{
			echo "<img src='".e_FILE."public/{$image}' alt='' />";
		} 
		elseif(is_file(e_FILE."downloadimages/{$image}")) 
		{
			echo "<img src='".e_FILE."downloadimages/{$image}' alt='' />";
		} 
		else 
		{
			require_once(HEADERF);
			$ns -> tablerender(LAN_dl_61, "<div style='text-align:center'>".LAN_dl_65."<br /><br /><a href='javascript:history.back(1)'>".LAN_dl_64."</a></div>");
			require_once(FOOTERF);
			exit;
		}
		exit();
	}
}



// File retrieval function. by Cam.
function send_file($file) 
{
	global $pref, $DOWNLOADS_DIRECTORY,$FILES_DIRECTORY, $e107;
	if (!$pref['download_php'])
	{
		header("Location: ".SITEURL.$file);
		exit();
	}
	
	@set_time_limit(10 * 60);
	@session_write_close();
	@e107_ini_set("max_execution_time", 10 * 60);
	while (@ob_end_clean()); // kill all output buffering else it eats server resources
	@ob_implicit_flush(TRUE);
	
	
	$filename = $file;
	$file = basename($file);
	$path = realpath($filename);
	$path_downloads = realpath($DOWNLOADS_DIRECTORY);
	$path_public = realpath($FILES_DIRECTORY."public/");
	if(!strstr($path, $path_downloads) && !strstr($path,$path_public)) 
	{
        if(E107_DEBUG_LEVEL > 0 && ADMIN)
		{
			echo "Failed to Download <b>".$file."</b><br />";
			echo "The file-path <b>".$path."<b> didn't match with either <b>{$path_downloads}</b> or <b>{$path_public}</b><br />";
			exit();
        }
		else
		{
			header("location: {$e107->base_path}");
			exit();
		}
	} 
	else 
	{
		if (is_file($filename) && is_readable($filename) && connection_status() == 0) 
		{
			$seek = 0;
			if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
			{
				$file = preg_replace('/\./', '%2e', $file, substr_count($file, '.') - 1);
			}
			if (isset($_SERVER['HTTP_RANGE']))
			{
				$seek = intval(substr($_SERVER['HTTP_RANGE'] , strlen('bytes=')));
			}
			$bufsize = 2048;
			ignore_user_abort(true);
			$data_len = filesize($filename);
			if ($seek > ($data_len - 1)) { $seek = 0; }
			if ($filename == null) { $filename = basename($this->data); }
			$res =& fopen($filename, 'rb');
			if ($seek)
			{
				fseek($res , $seek);
			}
			$data_len -= $seek;
			header("Expires: 0");
			header("Cache-Control: max-age=30" );
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=\"{$file}\"");
			header("Content-Length: {$data_len}");
			header("Pragma: public");
			if ($seek)
			{
				header("Accept-Ranges: bytes");
				header("HTTP/1.0 206 Partial Content");
				header("status: 206 Partial Content");
				header("Content-Range: bytes {$seek}-".($data_len - 1)."/{$data_len}");
			}
			while (!connection_aborted() && $data_len > 0)
			{
				echo fread($res , $bufsize);
				$data_len -= $bufsize;
			}
			fclose($res);
		} 
		else 
		{
            if(E107_DEBUG_LEVEL > 0 && ADMIN)
			{
              	echo "file failed =".$file."<br />";
				echo "path =".$path."<br />";
                exit();
			}
			else
			{
			  	header("location: ".e_BASE."index.php");
				exit();
			}
		}
	}
}


function check_download_limits() 
{
	global $pref, $sql, $ns, $HEADER, $e107, $tp;
	// Check download count limits
	$qry = "SELECT gen_intdata, gen_chardata, (gen_intdata/gen_chardata) as count_perday FROM #generic WHERE gen_type = 'download_limit' AND gen_datestamp IN (".USERCLASS_LIST.") AND (gen_chardata >= 0 AND gen_intdata >= 0) ORDER BY count_perday DESC";
	if($sql->db_Select_gen($qry)) 
	{
		$limits = $sql->db_Fetch();
		$cutoff = time() - (86400 * $limits['gen_chardata']);
		if(USER) 
		{
			$where = "dr.download_request_datestamp > {$cutoff} AND dr.download_request_userid = ".USERID;
		} else {
			$ip = $e107->getip();
			$where = "dr.download_request_datestamp > {$cutoff} AND dr.download_request_ip = '{$ip}'";
		}
		$qry = "SELECT COUNT(d.download_id) as count FROM #download_requests as dr LEFT JOIN #download as d ON dr.download_request_download_id = d.download_id AND d.download_active = 1 WHERE {$where} GROUP by dr.download_request_userid";
		if($sql->db_Select_gen($qry)) 
		{
			$row=$sql->db_Fetch();
			if($row['count'] >= $limits['gen_intdata']) 
			{
				// Exceeded download count limit
			  header("Location: ".e_BASE."download.php?error.{$cutoff}.2");
/*				require_once(HEADERF);
				$ns->tablerender(LAN_dl_61, LAN_dl_62);
				require(FOOTERF);  */
				exit();
			}
		}
	}
	// Check download bandwidth limits
	$qry = "SELECT gen_user_id, gen_ip, (gen_user_id/gen_ip) as bw_perday FROM #generic WHERE gen_type='download_limit' AND gen_datestamp IN (".USERCLASS_LIST.") AND (gen_user_id >= 0 AND gen_ip >= 0) ORDER BY bw_perday DESC";
	if($sql->db_Select_gen($qry)) {
		$limit = $sql->db_Fetch();
		$cutoff = time() - (86400*$limit['gen_ip']);
		if(USER) {
			$where = "dr.download_request_datestamp > {$cutoff} AND dr.download_request_userid = ".USERID;
		} else {
			$ip = $e107->getip();
			$where = "dr.download_request_datestamp > {$cutoff} AND dr.download_request_ip = '{$ip}'";
		}
		$qry = "SELECT SUM(d.download_filesize) as total_bw FROM #download_requests as dr LEFT JOIN #download as d ON dr.download_request_download_id = d.download_id AND d.download_active = 1 WHERE {$where} GROUP by dr.download_request_userid";
		if($sql->db_Select_gen($qry)) {
			$row=$sql->db_Fetch();
			if($row['total_bw'] / 1024 > $limit['gen_user_id']) 
			{	//Exceed bandwith limit
			  header("Location: ".e_BASE."download.php?error.{$cutoff}.2");
/*				require(HEADERF);
				$ns->tablerender(LAN_dl_61, LAN_dl_62);
				require(FOOTERF); */
				exit();
			}
		}
	}
}

?>