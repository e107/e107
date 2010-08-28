<?php

if (!defined('e107_INIT')) { exit; }

// e107 requires PHP > 4.3.0, all functions that are used in e107, introduced in newer
// versions than that should be recreated in here for compatabilty reasons..

if (!function_exists('file_put_contents')) {
	/**
	* @return int
	* @param string $filename
	* @param mixed $data
	* @desc Write a string to a file
	*/
	define('FILE_APPEND', 1);
	function file_put_contents($filename, $data, $flag = false) 
	{
      $mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';
	  if (($h = @fopen($filename, $mode)) === false) 
	  {
		return false;
	  }
      if (is_array($data)) $data = implode($data);
	  if (($bytes = @fwrite($h, $data)) === false) 
	  {
		return false;
	  }
	  fclose($h);
	  return $bytes;
	}
}



if (!function_exists('stripos')) {
 	function stripos($str,$needle,$offset=0)
	{
		return strpos(strtolower($str), strtolower($needle), $offset);
	}
}



if(!function_exists("mime_content_type")){
	function mime_content_type($filename){

		$filename = basename($filename);

		$mime[".zip"] = "application/x-zip-compressed";
		$mime[".gif"] = "image/gif";
		$mime[".png"] = "image/x-png";
		$mime[".jpg"] = "image/jpeg";
		$mime[".jpeg"] = "image/jpeg";
		$mime[".tif"] = "image/tiff";
		$mime[".tiff"] = "image/tiff";
		$mime[".pdf"] = "application/pdf";
		$mime[".hqx"] = "application/mac-binhex40";
		$mime[".doc"] = "application/msword";
		$mime[".dot"] = "application/msword";
		$mime[".exe"] = "application/octet-stream";
		$mime[".au"] = "audio/basic";
		$mime[".snd"] = "audio/basic";
		$mime[".mid"] = "audio/mid";
		$mime[".mp3"] = "audio/mpeg";
		$mime[".aif"] = "audio/x-aiff";
		$mime[".ra"] = "audio/x-pn-realaudio";
		$mime[".ram"] = "audio/x-pn-realaudio";
		$mime[".wav"] = "audio/x-wav";
		$mime[".bmp"] = "image/bmp";
		$mime[".ra"] = "audio/x-pn-realaudio";
		$mime[".htm"] = "text/html";
		$mime[".html"] = "text/html";
		$mime[".css"] = "text/css";
		$mime[".txt"] = "text/plain";
		$mime[".mov"] = "video/quicktime";
		$mime[".mpg"] = "video/mpeg";
		$mime[".asx"] = "video/x-ms-asf";
		$mime[".avi"] = "video/x-msvideo";

		$ext = strrchr($filename, '.');
		return $mime[$ext];
	}
}
?>