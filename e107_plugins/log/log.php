<?php
/*
* e107 website system
*
* Copyright 2001-2010 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Site access logging - 'receiver'
*
* $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/log/log.php $
* $Id: log.php 12938 2012-08-10 03:57:15Z e107coders $
*
*/

/* File to log page accesses - called with
	e_PLUGIN_ABS."log/log.php?base64encode(referer=' + ref + '&color=' + colord + '&eself=' + eself + '&res=' + res + '\">' );)";
		referer= ref
		color= colord
		eself= eself 
		res= res
		err_direct - optional error flag
		err_referer - referrer if came via error page
*/
define('log_INIT', TRUE);
error_reporting(0);

//define('STATS_LOG_DEBUG', TRUE);			// Enables separate logging of first reference of each page to a separate file

//$logVals = urldecode(base64_decode($_SERVER['QUERY_STRING']));
$logVals = urldecode(base64_decode($_GET['lv']));
parse_str($logVals, $vals);


// We MUST have a timezone set in PHP >= 5.3. This should work for PHP >= 5.1:
if (function_exists('date_default_timezone_get'))
{
// Just set a default - it should default to UTC if no timezone set
	date_default_timezone_set(@date_default_timezone_get());
}


header('Cache-Control: no-cache, must-revalidate');		// See if this discourages browser caching
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');		// Date in the past

//$logfp = fopen('logs/rcvstring.txt', 'a+'); fwrite($logfp, print_r($vals, TRUE)."\n"); fclose($logfp);

$colour = strip_tags((isset($vals['colour']) ? $vals['colour'] : ''));
$res = strip_tags((isset($vals['res']) ? $vals['res'] : ''));
$self = strip_tags((isset($vals['eself']) ? $vals['eself'] : ''));
$ref = addslashes(strip_tags((isset($vals['referer']) ? $vals['referer'] : '')));

$date = date("z.Y", time());
$logPfile = "logs/logp_".$date.".php";


// vet resolution and colour depth some more - avoid dud values
if ($res && preg_match("#.*?((\d+)\w+?(\d+))#", $res, $match))
{
	$res = $match[2].'x'.$match[3];
}
else
{
	$res = '??';			// Can't decode resolution
}

if ($colour && preg_match("#.*?(\d+)#",$colour,$match))
{
	$colour = intval($match[1]);
}
else
{
	$colour='??';
}


if ($err_code = strip_tags((isset($vals['err_direct']) ? $vals['err_direct'] : '')))
{
	$ref = addslashes(strip_tags(isset($vals['err_referer']) ? $vals['err_referer'] : ''));
// Uncomment the next two lines to create a separate CSV format log of invalid accesses - error code, entered URL, referrer
//	$log_string = $err_code.",".$self.",".$ref;
//  $logfp = fopen("logs/errpages.csv", 'a+'); fwrite($logfp, $log_string."\n"); fclose($logfp);
	$err_code .= ':';
}

if(strstr($ref, 'admin')) 
{
	$ref = FALSE;
}

$screenstats = $res.'@'.$colour;
$agent = $_SERVER['HTTP_USER_AGENT'];
$ip = getip();

$oldref = $ref; // backup for search string being stripped off for referer
if($ref && !strstr($ref, $_SERVER['HTTP_HOST'])) 
{
	if(preg_match("#http://(.*?)($|/)#is", $ref, $match)) 
	{
		$ref = $match[0];
	}
}

$pageDisallow = "cache|file|eself|admin";
$tagRemove = "(\\\)|(\s)|(\')|(\")|(eself)|(&nbsp;)|(\.php)|(\.html)";
$tagRemove2 = "(\\\)|(\s)|(\')|(\")|(eself)|(&nbsp;)";

preg_match("#/(.*?)(\?|$)#si", $self, $match);
$match[1] = isset($match[1]) ? $match[1] : '';
$pageName = substr($match[1], (strrpos($match[1], "/")+1));
$PN = $pageName;
$pageName = preg_replace("/".$tagRemove."/si", "", $pageName);
if($pageName == "") $pageName = "index";

if(preg_match("/".$pageDisallow."/i", $pageName)) return;


$pageName = $err_code.$pageName;			// Add the error code at the beginning, so its treated uniquely
//$logfp = fopen('logs/rcvstring.txt', 'a+'); fwrite($logfp, $pageName."\n"); fclose($logfp);

$p_handle = fopen($logPfile, 'r+');
if($p_handle && flock( $p_handle, LOCK_EX ) ) 
{
	$log_file_contents = '';
	while (!feof($p_handle))
	{  // Assemble a string of data
		$log_file_contents.= fgets($p_handle,1000);
	}
	$log_file_contents = str_replace(array('<'.'?php','?'.'>'),'',$log_file_contents);
	if (eval($log_file_contents) === FALSE) echo "error in log file contents<br /><br /><br /><br />";
}
else
{
	echo "Couldn't log data<br /><br /><br /><br />";
	exit;
}


$flag = FALSE;
if(array_key_exists($pageName, $pageInfo)) 
{  // Existing page - just increment stats
	$pageInfo[$pageName]['ttl'] ++;
}
else 
{  // First access of page
	$url = preg_replace("/".$tagRemove2."/si", "", $self);
	if(preg_match("/".$pageDisallow."/i", $url)) return;
	$pageInfo[$pageName] = array('url' => $url, 'ttl' => 1, 'unq' => 1);
	$flag = TRUE;

	if (defined('STATS_LOG_DEBUG'))
	{	// log first access of each page (each day)
		preg_match("#//(?:.*?)(/.*?)(\?|$)#si", $self, $match);
		$longPage = isset($match[1]) ? $match[1] : 'blankpage';

		//$log_string = $ip.",".$pageName.",".$longPage.",".$ref.",".$_SERVER['PHP_SELF'].",".$agent;
		$log_string = $ip.",".$pageName.",".$longPage.",".$ref.",".$agent;
		$logfp = fopen("logs/firstpages.log", 'a+'); fwrite($logfp, $log_string."\n"); fclose($logfp);
	}
}

if(!strstr($ipAddresses, $ip)) 
{	/* unique visit */
	if(!$flag) 
	{
		$pageInfo[$pageName]['unq'] ++;
	}
	$siteUnique ++;
	$ipAddresses .= $ip.".";		// IP address is stored as hex string
	require_once("loginfo.php");
}

$siteTotal ++;
$info_data = var_export($pageInfo, true);
//$date_stamp = date("z:Y", time());			// Same as '$date' variable

$data = "<?php

/* e107 website system: Log file: {$date} */

\$ipAddresses = '{$ipAddresses}';
\$siteTotal = '{$siteTotal}';
\$siteUnique = '{$siteUnique}';

\$pageInfo = {$info_data};

?>";

if ($p_handle)
{
  ftruncate( $p_handle, 0 );
  fseek( $p_handle, 0 );
  fwrite($p_handle, $data);
  fclose($p_handle);
}


// Get current IP address - return as a hex-encoded string
function getip() 
{
	$ip = $_SERVER['REMOTE_ADDR'];
	if (getenv('HTTP_X_FORWARDED_FOR')) 
	{
		if (preg_match("#^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})#", getenv('HTTP_X_FORWARDED_FOR'), $ip3)) 
		{  
			$ip2 = array('#^0\..*#', 
				   '#^127\..*#', 							// Local loopbacks
				   '#^192\.168\..*#', 						// RFC1918 - Private Network
				   '#^172\.(?:1[6789]|2\d|3[01])\..*#', 	// RFC1918 - Private network
				   '#^10\..*#', 							// RFC1918 - Private Network
				   '#^169\.254\..*#', 						// RFC3330 - Link-local, auto-DHCP 
				   '#^2(?:2[456789]|[345][0-9])\..*#'		// Single check for Class D and Class E
				   );
			$ip = preg_replace($ip2, $ip, $ip3[1]);
		}
	}
	if ($ip == "") 
	{
		$ip = "x.x.x.x";
	}
	$ipa = explode(".", $ip);
	return sprintf('%02x%02x%02x%02x', $ipa[0], $ipa[1], $ipa[2], $ipa[3]);
}

?>