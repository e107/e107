<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/log/stats.php $
|     $Revision: 12206 $
|     $Id: stats.php 12206 2011-05-10 21:27:26Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/
require_once("../../class2.php");
if (!isset($pref['plug_installed']['log']))
{
	header('Location: '.e_BASE.'index.php');
	exit;
}

include_lan(e_PLUGIN."log/languages/".e_LANGUAGE.".php");

function core_head() {
	$bar = (file_exists(THEME."images/bar.png") ? THEME."images/bar.png" : e_IMAGE."generic/bar.png");
	return "<style type='text/css'>
<!--
.b { background-image: url('".$bar."'); border: 1px solid #999; height: 10px; font-size: 0px }
-->
</style>";
}

require_once(HEADERF);

if(!check_class($pref['statUserclass'])) {
	$text = "<div style='text-align: center;'>".ADSTAT_L4."</div>";
	$ns->tablerender(ADSTAT_L6, $text);
	require_once(FOOTERF);
	exit;
}

if (!$pref['statActivate']) {
	$text = (ADMIN ? "<div style='text-align:center'>".ADSTAT_L41."</div>" : "<div style='text-align:center'>".ADSTAT_L5."</div>");
	$ns->tablerender(ADSTAT_L6, $text);
	require_once(FOOTERF);
	exit;
}


$qs = explode('.', e_QUERY, 3);
$action = varset($qs[0],1);
$sec_action = varset($qs[1],FALSE);
$order = varset($qs[1],0);

$toremove = varset($qs[2],'');
$order = intval($order);

$stat = new siteStats();

if($stat -> error) 
{
	$ns->tablerender(ADSTAT_L6, $stat -> error);
	require_once(FOOTERF);
	exit;
}

$browser_map = array (
'Netcaptor'         => "netcaptor",
'Internet Explorer' => "explorer",
'Firefox'           => "firefox",
'Opera'             => "opera",
'AOL'               => "aol",
'Netscape'          => "netscape",
'Mozilla'           => "mozilla",
'Mosaic'            => "mosaic",
'K-Meleon'          => "k-meleon",
'Konqueror'         => "konqueror",
'Avant Browser'     => "avantbrowser",
'AvantGo'           => "avantgo",
'Proxomitron'       => "proxomitron",
'Safari'            => "safari",
'Lynx'              => "lynx",
'Links'             => "links",
'Galeon'            => "galeon",
'ABrowse'           => "abrowse",
'Amaya'             => "amaya",
'ANTFresco'         => "ant",
'Aweb'              => "aweb",
'Beonex'            => "beonex",
'Blazer'            => "blazer",
'Camino'            => "camino",
'Chimera'           => "chimera",
'Columbus'          => "columbus",
'Crazy Browser'     => "crazybrowser",
'Curl'              => "curl",
'Deepnet Explorer'  => "deepnet",
'Dillo'             => "dillo",
'Doris'             => "doris",
'ELinks'            => "elinks",
'Epiphany'          => "epiphany",
'Firebird'          => "firebird",
'IBrowse'           => "ibrowse",
'iCab'              => "icab",
'ICEbrowser'        => "ice",
'iSiloX'            => "isilox",
'Lotus Notes'       => "lotus",
'Lunascape'         => "lunascape",
'Maxthon'           => "maxthon",
'mBrowser'          => "mbrowser",
'Multi-Browser'     => "multibrowser",
'Nautilus'          => "nautilus",
'NetFront'          => "netfront",
'NetPositive'       => "netpositive",
'OmniWeb'           => "omniweb",
'Oregano'           => "oregano",
'PhaseOut'          => "phaseout",
'PLink'             => "plink",
'Phoenix'           => "phoenix",
'Proxomitron'       => "proxomitron",
'Shiira'            => "shiira",
'Sleipnir'          => "sleipnir",
'SlimBrowser'       => "slimbrowser",
'StarOffice'        => "staroffice",
'Sunrise'           => "sunrise",
'Voyager'           => "voyager",
'w3m'               => "w3m",
'Webtv'             => "webtv",
'Xiino'             => "xiino",
'Chrome'            => "chrome",
'Nokia S60 OSS Browser' => "nokia",
'Nokia Browser'     => "nokia",
);

$country["arpa"] = "ARPANet";
$country["com"] = "Commercial Users";
$country["edu"] = "Education";
$country["gov"] = "Government";
$country["int"] = "Organisation established by an International Treaty";
$country["mil"] = "Military";
$country["net"] = "Network";
$country["org"] = "Organisation";
$country["ad"] = "Andorra";
$country["ae"] = "United Arab Emirates";
$country["af"] = "Afghanistan";
$country["ag"] = "Antigua & Barbuda";
$country["ai"] = "Anguilla";
$country["al"] = "Albania";
$country["am"] = "Armenia";
$country["an"] = "Netherland Antilles";
$country["ao"] = "Angola";
$country["aq"] = "Antarctica";
$country["ar"] = "Argentina";
$country["as"] = "American Samoa";
$country["at"] = "Austria";
$country["au"] = "Australia";
$country["aw"] = "Aruba";
$country["az"] = "Azerbaijan";
$country["ba"] = "Bosnia-Herzegovina";
$country["bb"] = "Barbados";
$country["bd"] = "Bangladesh";
$country["be"] = "Belgium";
$country["bf"] = "Burkina Faso";
$country["bg"] = "Bulgaria";
$country["bh"] = "Bahrain";
$country["bi"] = "Burundi";
$country["bj"] = "Benin";
$country["bm"] = "Bermuda";
$country["bn"] = "Brunei Darussalam";
$country["bo"] = "Bolivia";
$country["br"] = "Brasil";
$country["bs"] = "Bahamas";
$country["bt"] = "Bhutan";
$country["bv"] = "Bouvet Island";
$country["bw"] = "Botswana";
$country["by"] = "Belarus";
$country["bz"] = "Belize";
$country["ca"] = "Canada";
$country["cc"] = "Cocos (Keeling) Islands";
$country["cf"] = "Central African Republic";
$country["cg"] = "Congo";
$country["ch"] = "Switzerland";
$country["ci"] = "Ivory Coast";
$country["ck"] = "Cook Islands";
$country["cl"] = "Chile";
$country["cm"] = "Cameroon";
$country["cn"] = "China";
$country["co"] = "Colombia";
$country["cr"] = "Costa Rica";
$country["cs"] = "Czechoslovakia";
$country["cu"] = "Cuba";
$country["cv"] = "Cape Verde";
$country["cx"] = "Christmas Island";
$country["cy"] = "Cyprus";
$country["cz"] = "Czech Republic";
$country["de"] = "Germany";
$country["dj"] = "Djibouti";
$country["dk"] = "Denmark";
$country["dm"] = "Dominica";
$country["do"] = "Dominican Republic";
$country["dz"] = "Algeria";
$country["ec"] = "Ecuador";
$country["ee"] = "Estonia";
$country["eg"] = "Egypt";
$country["eh"] = "Western Sahara";
$country["er"] = "Eritrea";
$country["es"] = "Spain";
$country["et"] = "Ethiopia";
$country["fi"] = "Finland";
$country["fj"] = "Fiji";
$country["fk"] = "Falkland Islands (Malvibas)";
$country["fm"] = "Micronesia";
$country["fo"] = "Faroe Islands";
$country["fr"] = "France";
$country["fx"] = "France (European Territory)";
$country["ga"] = "Gabon";
$country["gb"] = "Great Britain";
$country["gd"] = "Grenada";
$country["ge"] = "Georgia";
$country["gf"] = "Guyana (French)";
$country["gh"] = "Ghana";
$country["gi"] = "Gibralta";
$country["gl"] = "Greenland";
$country["gm"] = "Gambia";
$country["gn"] = "Guinea";
$country["gp"] = "Guadeloupe (French)";
$country["gq"] = "Equatorial Guinea";
$country["gr"] = "Greece";
$country["gs"] = "South Georgia & South Sandwich Islands";
$country["gt"] = "Guatemala";
$country["gu"] = "Guam (US)";
$country["gw"] = "Guinea Bissau";
$country["gy"] = "Guyana";
$country["hk"] = "Hong Kong";
$country["hm"] = "Heard & McDonald Islands";
$country["hn"] = "Honduras";
$country["hr"] = "Croatia";
$country["ht"] = "Haiti";
$country["hu"] = "Hungary";
$country["id"] = "Indonesia";
$country["ie"] = "Ireland";
$country["il"] = "Israel";
$country["in"] = "India";
$country["io"] = "British Indian Ocean Territories";
$country["iq"] = "Iraq";
$country["ir"] = "Iran";
$country["is"] = "Iceland";
$country["it"] = "Italy";
$country["jm"] = "Jamaica";
$country["jo"] = "Jordan";
$country["jp"] = "Japan";
$country["ke"] = "Kenya";
$country["kg"] = "Kyrgyz Republic";
$country["kh"] = "Cambodia";
$country["ki"] = "Kiribati";
$country["km"] = "Comoros";
$country["kn"] = "Saint Kitts Nevis Anguilla";
$country["kp"] = "Korea (North)";
$country["kr"] = "Korea (South)";
$country["kw"] = "Kuwait";
$country["ky"] = "Cayman Islands";
$country["kz"] = "Kazachstan";
$country["la"] = "Laos";
$country["lb"] = "Lebanon";
$country["lc"] = "Saint Lucia";
$country["li"] = "Liechtenstein";
$country["lk"] = "Sri Lanka";
$country["lr"] = "Liberia";
$country["ls"] = "Lesotho";
$country["lt"] = "Lithuania";
$country["lu"] = "Luxembourg";
$country["lv"] = "Latvia";
$country["ly"] = "Libya";
$country["ma"] = "Morocco";
$country["mc"] = "Monaco";
$country["md"] = "Moldova";
$country["mg"] = "Madagascar";
$country["mh"] = "Marshall Islands";
$country["mk"] = "Macedonia";
$country["ml"] = "Mali";
$country["mm"] = "Myanmar";
$country["mn"] = "Mongolia";
$country["mo"] = "Macau";
$country["mp"] = "Northern Mariana Islands";
$country["mq"] = "Martinique (French)";
$country["mr"] = "Mauretania";
$country["ms"] = "Montserrat";
$country["mt"] = "Malta";
$country["mu"] = "Mauritius";
$country["mv"] = "Maldives";
$country["mw"] = "Malawi";
$country["mx"] = "Mexico";
$country["my"] = "Malaysia";
$country["mz"] = "Mozambique";
$country["na"] = "Namibia";
$country["nc"] = "New Caledonia (French)";
$country["ne"] = "Niger";
$country["nf"] = "Norfolk Island";
$country["ng"] = "Nigeria";
$country["ni"] = "Nicaragua";
$country["nl"] = "Netherlands";
$country["no"] = "Norway";
$country["np"] = "Nepal";
$country["nr"] = "Nauru";
$country["nt"] = "Saudiarab. Irak)";
$country["nu"] = "Niue";
$country["nz"] = "New Zealand";
$country["om"] = "Oman";
$country["pa"] = "Panama";
$country["pe"] = "Peru";
$country["pf"] = "Polynesia (French)";
$country["pg"] = "Papua New Guinea";
$country["ph"] = "Philippines";
$country["pk"] = "Pakistan";
$country["pl"] = "Poland";
$country["pm"] = "Saint Pierre & Miquelon";
$country["pn"] = "Pitcairn";
$country["pr"] = "Puerto Rico (US)";
$country["pt"] = "Portugal";
$country["pw"] = "Palau";
$country["py"] = "Paraguay";
$country["qa"] = "Qatar";
$country["re"] = "Reunion (French)";
$country["ro"] = "Romania";
$country["ru"] = "Russian Federation";
$country["rw"] = "Rwanda";
$country["sa"] = "Saudi Arabia";
$country["sb"] = "Salomon Islands";
$country["sc"] = "Seychelles";
$country["sd"] = "Sudan";
$country["se"] = "Sweden";
$country["sg"] = "Singapore";
$country["sh"] = "Saint Helena";
$country["si"] = "Slovenia";
$country["sj"] = "Svalbard & Jan Mayen";
$country["sk"] = "Slovakia";
$country["sl"] = "Sierra Leone";
$country["sm"] = "San Marino";
$country["sn"] = "Senegal";
$country["so"] = "Somalia";
$country["sr"] = "Suriname";
$country["st"] = "Sao Tome & Principe";
$country["su"] = "Soviet Union";
$country["sv"] = "El Salvador";
$country["sy"] = "Syria";
$country["sz"] = "Swaziland";
$country["tc"] = "Turks & Caicos Islands";
$country["td"] = "Chad";
$country["tf"] = "French Southern Territories";
$country["tg"] = "Togo";
$country["th"] = "Thailand";
$country["tj"] = "Tadjikistan";
$country["tk"] = "Tokelau";
$country["tm"] = "Turkmenistan";
$country["tn"] = "Tunisia";
$country["to"] = "Tonga";
$country["tp"] = "East Timor";
$country["tr"] = "Turkey";
$country["tt"] = "Trinidad & Tobago";
$country["tv"] = "Tuvalu";
$country["tw"] = "Taiwan";
$country["tz"] = "Tanzania";
$country["ua"] = "Ukraine";
$country["ug"] = "Uganda";
$country["uk"] = "United Kingdom";
$country["um"] = "US Minor outlying Islands";
$country["us"] = "United States";
$country["uy"] = "Uruguay";
$country["uz"] = "Uzbekistan";
$country["va"] = "Vatican City State";
$country["vc"] = "St Vincent & Grenadines";
$country["ve"] = "Venezuela";
$country["vg"] = "Virgin Islands (British)";
$country["vi"] = "Virgin Islands (US)";
$country["vn"] = "Vietnam";
$country["vu"] = "Vanuatu";
$country["wf"] = "Wallis & Futuna Islands";
$country["ws"] = "Samoa";
$country["ye"] = "Yemen";
$country["yt"] = "Mayotte";
$country["yu"] = "Yugoslavia";
$country["za"] = "South Africa";
$country["zm"] = "Zambia";
$country["zr"] = "Zaire";
$country["zw"] = "Zimbabwe";


/* stats displayed will depend on the query string. For example, ?1.2.4 will render today's stats, all time stats and browser stats */
/*
1: today's stats
2: all time total and unique
3: browsers
4: operating systems
5: domains
6: screen resolution/colour depth
7: referers
8: search engine strings
*/

$text = '';
if ((ADMIN == TRUE) && ($sec_action == "rem"))
{
  $toremove = rawurldecode($toremove);
  if ($stat -> remove_entry($toremove))
  {
    $text .= "<div style='text-align: center; font-weight: bold'>".ADSTAT_L45.$toremove."<br />".ADSTAT_L46."</div>";
  }
  else
  {
    $text .= "<div style='text-align: center; font-weight: bold'>".ADSTAT_L47.$toremove."</div>";
  }
}

$action = intval($action);

switch($action) 
{
	case 1:
	$text .= $stat -> renderTodaysVisits(FALSE);
	break;
	case 2:
	$text .= $stat -> renderAlltimeVisits(FALSE);
	break;
	case 12:
	  if (ADMIN == TRUE)
		$text .= $stat -> renderTodaysVisits(TRUE);
	break;
	case 13:
	  if (ADMIN == TRUE)
		$text .= $stat -> renderAlltimeVisits(TRUE);
	break;
	case 3:
	if($pref['statBrowser']) {
		$text .= $stat -> renderBrowsers($pref['statBrowserDispCompr']);
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 4:
	if($pref['statOs']) {
		$text .= $stat -> renderOses();
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 5:
	if($pref['statDomain']) {
		$text .= $stat -> renderDomains();
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 6:
	if($pref['statScreen']) {
		$text .= $stat -> renderScreens();
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 7:
	if($pref['statRefer']) {
		$text .= $stat -> renderRefers();
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 8:
	if($pref['statQuery']) {
		$text .= $stat -> renderQueries();
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 9:
	if($pref['statRecent']) {
		$text .= $stat -> recentVisitors();
	} else {
		$text .= ADSTAT_L7;
	}
	break;
	case 10:
	$text .= $stat -> renderDaily();
	break;
	case 11:
	$text .= $stat -> renderMonthly();
	break;
	default :
	  $text .= $stat -> renderTodaysVisits(FALSE);
}



/* render links 
 1 - Todays visits
 2 - All-time
 3 - Browser stats
 4 - OS Stats
 5 - Domain Stats
 6 - Screen resolution
 7 - Referral stats
 8 - Search strings
 9 - Recent visitors
10 - Daily Stats
11 - Monthly stats
12 - Today's error page visits
13 - All-time error page visits
*/

$path = e_PLUGIN."log/stats.php";
$links = "
<div style='text-align: center;'>".
($action != 1 ? "<a href='{$path}?1'>".ADSTAT_L8."</a>" : "<b>".ADSTAT_L8."</b>")." | ".
($action != 2 ? "<a href='{$path}?2'>".ADSTAT_L9."</a>" : "<b>".ADSTAT_L9."</b>")." | ".
($action != 10 ? "<a href='{$path}?10'>".ADSTAT_L10."</a>" : "<b>".ADSTAT_L10."</b>")." | ".
($action != 11 ? "<a href='{$path}?11'>".ADSTAT_L11."</a>" : "<b>".ADSTAT_L11."</b>")." | ".
($action != 3 && $pref['statBrowser'] ? "<a href='{$path}?3'>".ADSTAT_L12."</a> | " : ($pref['statBrowser'] ? "<b>".ADSTAT_L12."</b> | " : "")).
($action != 4 && $pref['statOs'] ? "<a href='{$path}?4'>".ADSTAT_L13."</a> | " : ($pref['statOs'] ? "<b>".ADSTAT_L13."</b> | " : "")).
($action != 5 && $pref['statDomain'] ? "<a href='{$path}?5'>".ADSTAT_L14."</a> | " : ($pref['statDomain'] ? "<b>".ADSTAT_L14."</b> | " : "")).
($action != 6 && $pref['statScreen'] ? "<a href='{$path}?6'>".ADSTAT_L15."</a> | " : ($pref['statScreen'] ? "<b>".ADSTAT_L15."</b> | " : "")).
($action != 7 && $pref['statRefer'] ? "<a href='{$path}?7'>".ADSTAT_L16."</a> | " : ($pref['statRefer'] ? "<b>".ADSTAT_L16."</b> | " : "")).
($action != 8 && $pref['statQuery'] ? "<a href='{$path}?8'>".ADSTAT_L17."</a> | " : ($pref['statQuery'] ? "<b>".ADSTAT_L17."</b> | " : "")).
($action != 9 && $pref['statRecent'] ? "<a href='{$path}?9'>".ADSTAT_L18."</a> | " : ($pref['statRecent'] ? "<b>".ADSTAT_L18."</b> | " : ""));
if (ADMIN == TRUE)
$links .= 
($action != 12 ? "<a href='{$path}?12'>".ADSTAT_L43."</a>" : "<b>".ADSTAT_L43."</b>")." | ".
($action != 13 ? "<a href='{$path}?13'>".ADSTAT_L44."</a>" : "<b>".ADSTAT_L44."</b>");
$links .= "</div><br /><br />";

$ns->tablerender(ADSTAT_L6, $links.$text);
require_once(FOOTERF);

class siteStats {

	var $dbPageInfo;
	var $fileInfo;
	var $fileBrowserInfo;
	var $fileOsInfo;
	var $fileScreenInfo;
	var $fileDomainInfo;
	var $fileReferInfo;
	var $fileQueryInfo;
	var $fileRecent;
	var $error;
	var $order;
	var $bar;

	var $filesiteTotal;
	var $filesiteUnique;

	function siteStats() 
	{
		/* constructor */
		global $sql;

		/* get today's logfile ... */
		$logfile = e_PLUGIN."log/logs/logp_".date("z.Y", time()).".php";
		if(is_readable($logfile)) {
			require($logfile);
		}
		$logfile = e_PLUGIN."log/logs/logi_".date("z.Y", time()).".php";
		if(is_readable($logfile)) {
			require($logfile);
		}

		$this -> filesiteTotal = $siteTotal;
		$this -> filesiteUnique = $siteUnique;

		/* set order var */
		global $order;
		$this -> order = $order;

		$this -> fileInfo = $pageInfo;
		$this -> fileBrowserInfo = $browserInfo;
		$this -> fileOsInfo = $osInfo;
		$this -> fileScreenInfo = $screenInfo;
		$this -> fileDomainInfo = $domainInfo;
		$this -> fileReferInfo = $refInfo;
		$this -> fileQueryInfo = $searchInfo;
		$this -> fileRecent = $visitInfo;

		/* get main stat info from database */
		if($sql -> db_Select("logstats", "*", "log_id='pageTotal'")){
			$row = $sql -> db_Fetch();
			$this -> dbPageInfo = unserialize($row[2]);
		} else {
			$this -> dbPageInfo = array();
		}

		/* temp consolidate today's info (if it exists)... */
		if(is_array($pageInfo)) {
			foreach($pageInfo as $key => $info) {
				$key = preg_replace("/\?.*/", "", $key);
				if(array_key_exists($key, $this -> dbPageInfo)) {
					$this -> dbPageInfo[$key]['ttlv'] += $info['ttl'];
					$this -> dbPageInfo[$key]['unqv'] += $info['unq'];
				} else {
					$this -> dbPageInfo[$key]['url'] = $info['url'];
					$this -> dbPageInfo[$key]['ttlv'] = $info['ttl'];
					$this -> dbPageInfo[$key]['unqv'] = $info['unq'];
				}
			}
		}

		$this -> bar = (file_exists(THEME."images/bar.png") ? THEME."images/bar.png" : e_IMAGE."generic/bar.png");


		/* end constructor */
	}

	function arraySort($array, $column, $order = SORT_DESC)
	{
		/* sorts multi-dimentional array based on which field is passed */
		$i=0;
		foreach($array as $info) {
			$sortarr[]=$info[$column];
			$i++;
		}
		array_multisort($sortarr, $order, $array, $order);
		return($array);
		/* end method */
	}
	
	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderTodaysVisits($do_errors = FALSE) 
	{
		/* renders information for today only */

		$do_errors = $do_errors && ADMIN && getperms("P");

		// Now run through and keep either the non-error pages, or the error pages, according to $do_errors
		$totalArray = array();
		$totalv = 0;
		$totalu = 0;
		foreach ($this -> fileInfo as $k => $v)
		{
			$found = (strpos($k,'error/') === 0);
			if ($do_errors XOR !$found) 
			{
				$totalArray[$k] = $v;
				if (isset($v['ttlv'])) $total += $v['ttlv'];
			}
		}
		$totalArray = $this -> arraySort($totalArray, "ttl");

		foreach($totalArray as $key => $info) 
		{
			$totalv += $info['ttl'];
			$totalu += $info['unq'];
		}

		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 20%;'>".ADSTAT_L19."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L20."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		foreach($totalArray as $key => $info) 
		{
			if($info['ttl'])
			{
				$percentage = round(($info['ttl']/$totalv) * 100, 2);
				$text .= "<tr>\n<td class='forumheader3' style='width: 20%;'><img src='".e_PLUGIN."log/images/html.png' alt='' style='vertical-align: middle;' /> <a href='".$info['url']."'>".$key."</a>
				</td>\n<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info['ttl']." [".$info['unq']."]")."</td>\n<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>\n</tr>\n";
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21." [".ADSTAT_L22."]</td><td class='forumheader' style='text-align: center;'>{$totalv} [{$totalu}]</td><td class='forumheader'></td></tr></table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderAlltimeVisits($do_errors = FALSE) 
	{
		/* renders information for alltime, total and unique */

		global $sql, $action;

		$sql -> db_Select("logstats", "*", "log_id='pageTotal' ");
		$row = $sql -> db_Fetch();
		$pageTotal = unserialize($row['log_data']);
		$total = 0;
		$text = '';

		$can_delete = ADMIN && getperms("P");
		$do_errors = $do_errors && $can_delete;
		
		foreach($this -> fileInfo as $url => $tmpcon) 
		{
			$pageTotal[$url]['url'] = $tmpcon['url'];
			$pageTotal[$url]['ttlv'] += $tmpcon['ttl'];
			$pageTotal[$url]['unqv'] += $tmpcon['unq'];
		}

		// Now run through and keep either the non-error pages, or the error pages, according to $do_errors
		$totalArray = array();
		foreach ($pageTotal as $k => $v)
		{
		  $found = (strpos($k,'error/') === 0);
		  if ($do_errors XOR !$found) 
		  {
		    $totalArray[$k] = $v;
			$total += $v['ttlv'];
		  }
		}

		$totalArray = $this -> arraySort($totalArray, "ttlv");

		$text .= "<table class='fborder' style='width: 100%;'>\n
			<colgroup>
			  <col style='width: 20%;' />
			  <col style='width: 60%;' />
			  <col style='width: 10%;' />
			  <col style='width: 10%;' />
			</colgroup>
			<tr>\n<td class='fcaption' >".ADSTAT_L19."</td>\n
			<td class='fcaption' colspan='2'>".ADSTAT_L23."</td>\n<td class='fcaption' text-align: center;'>%</td>\n</tr>\n";
		foreach($totalArray as $key => $info) 
		{
			if($info['ttlv'])
			{
				$percentage = round(($info['ttlv']/$total) * 100, 2);
				$text .= "<tr>
				<td class='forumheader3' >
				".($can_delete ? "<a href='".e_SELF."?{$action}.rem.".rawurlencode($key)."'><img src='".e_PLUGIN."log/images/remove.png' alt='".ADSTAT_L39."' title='".ADSTAT_L39."' style='vertical-align: middle; border: 0;' /></a> " : "")."
				<img src='".e_PLUGIN."log/images/html.png' alt='' style='vertical-align: middle;' /> <a href='".$info['url']."'>".$key."</a>
				";
				$text .= "</td>
				<td class='forumheader3' >".$this->bar($percentage, $info['ttlv'])."</td>
				<td class='forumheader3' style='text-align: center;'>".$percentage."%</td>
				</tr>\n";
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></td></tr>\n</table>";


		$uniqueArray = array();
		$totalv = 0;
		foreach ($this -> dbPageInfo as $k => $v)
		{
		  $found = (strpos($k,'error/') === 0);
		  if ($do_errors XOR !$found) 
		  {
		    $uniqueArray[$k] = $v;
			$totalv += $v['unqv'];
		  }
		}
		$uniqueArray = $this -> arraySort($uniqueArray, "unqv");

		$text .= "<br /><table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 20%;'>Page</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L24."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		foreach($uniqueArray as $key => $info) 
		{
			if($info['ttlv'])
			{
				$percentage = round(($info['unqv']/$totalv) * 100, 2);
				$text .= "<tr>
				<td class='forumheader3' style='width: 20%;'><img src='".e_PLUGIN."log/images/html.png' alt='' style='vertical-align: middle;' /> <a href='".$info['url']."'>".$key."</a></td>
				<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info['unqv'])."</td>
				<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>
				</tr>\n";
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$totalv</td><td class='forumheader'></td></tr>\n</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderBrowsers($compress = FALSE) {
		global $sql, $browser_map;

		if($entries = $sql -> db_Select("logstats", "*", "log_id='statBrowser'")) {
			$row = $sql -> db_Fetch();
			$statBrowser = unserialize($row['log_data']);
		}

		/* temp consolidate today's data ... */
		foreach($this -> fileBrowserInfo as $name => $count) {
			$statBrowser[$name] += $count;
		}

		if(!is_array($statBrowser)) {
			return "<div style='text-align: center;'>".ADSTAT_L25."</div>";
		}

		if($compress) {
			$tempArray = array();
			foreach($statBrowser as $k => $v) {
				$found = false;
				foreach(array_keys($browser_map) as $br) {
					if(stripos($k, $br) === 0) {
						$tempArray[$br] = (isset($tempArray[$br]) ? $tempArray[$br]+$v : $v);
						$found = true;
						break;  //We found what we wanted, break from foreach
					}
				}
				if(!$found) {
					$tempArray[$k] = $v;
				}
			}
			$statBrowser = $tempArray;
		}

		if(is_array($statBrowser)) {
			if($this -> order) {
				ksort($statBrowser);
				reset ($statBrowser);
				$browserArray = $statBrowser;
			} else {
				$browserArray = $this -> arraySort($statBrowser, 0);
			}
			$total = array_sum($browserArray);
			$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 20%;'><a title='".($this -> order ? "sort by total" : "sort alphabetically")."'href='".e_SELF."?3".($this -> order ? "" : ".1" )."'>".ADSTAT_L26."</a></td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L21."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";

			foreach($browserArray as $key => $info) {
				$image = "";
				foreach ($browser_map as $name => $file) {
					if(strstr($key, $name)) {
						$image = "{$file}.png";
						break;
					}
				}
				if($image == "") {
					$image = "unknown.png";
				}
				$percentage = round(($info/$total) * 100, 2);
				$text .= "<tr>
				<td class='forumheader3' style='width: 20%;'>".($image ? "<img src='".e_PLUGIN."log/images/$image' alt='' style='vertical-align: middle;' /> " : "").$key."</td>".
				($entries == 1 ? "<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>" : "<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>")."
				<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>
				</tr>\n";
			}
			$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></td></tr>\n</table>";
		}
		return $text;
	}
	
	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderOses() {
		global $sql;

		if($entries = $sql -> db_Select("logstats", "*", "log_id='statOs'")) {
			$row = $sql -> db_Fetch();
			$statOs = unserialize($row['log_data']);
		}

		/* temp consolidate today's data ... */
		foreach($this -> fileOsInfo as $name => $count) {
			$statOs[$name] += $count;
		}

		if(!is_array($statOs)) {
			return "<div style='text-align: center;'>".ADSTAT_L25.".</div>";
		}

		if($this -> order) {
			ksort($statOs);
			reset ($statOs);
			$osArray = $statOs;
		} else {
			$osArray = $this -> arraySort($statOs, 0);
		}

		$total = array_sum($osArray);
		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 20%;'><a title='".($this -> order ? "sort by total" : "sort alphabetically")."'href='".e_SELF."?4".($this -> order ? "" : ".1" )."'>".ADSTAT_L27."</a></td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L21."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		foreach($osArray as $key => $info) {

			$image = "";
			if(strstr($key, "Windows")) {	$image = "windows.png"; }
			elseif(strstr($key, "Mac")) {	$image = "mac.png"; }
			elseif(strstr($key, "Linux")) {	$image = "linux.png"; }
			elseif(strstr($key, "BeOS")) {	$image = "beos.png"; }
			elseif(strstr($key, "FreeBSD")) {	$image = "freebsd.png"; }
			elseif(strstr($key, "NetBSD")) {	$image = "netbsd.png"; }
			elseif(strstr($key, "Unspecified")) {	$image = "unspecified.png"; }
			elseif(strstr($key, "OpenBSD")) {	$image = "openbsd.png"; }
			elseif(strstr($key, "Unix")) {	$image = "unix.png"; }
			elseif(strstr($key, "Spiders")) {	$image = "spiders.png"; }
			elseif(stristr($key, "Android")) {	$image = "android.png"; }

			$percentage = round(($info/$total) * 100, 2);
			$text .= "<tr>
			<td class='forumheader3' style='width: 20%;'>".($image ? "<img src='".e_PLUGIN."log/images/$image' alt='' style='vertical-align: middle;' /> " : "").$key."</td>".
			($entries == 1 ? "<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>" : "<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>")."
			<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>
			</tr>\n";
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></tr></tr>\n</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderDomains() {
		global $sql;

		if($sql -> db_Select("logstats", "*", "log_id='statDomain'")) {
			$row = $sql -> db_Fetch();
			$statDom = unserialize($row['log_data']);
		}

		/* temp consolidate today's data ... */
		foreach($this -> fileDomainInfo as $name => $count) {
			$statDom[$name] += $count;
		}

		if(!count($statDom)) {
			return "<div style='text-align: center;'>".ADSTAT_L25.".</div>";
		}

		if($this -> order) {
			ksort($statDom);
			reset ($statDom);
			$domArray = $statDom;
		} else {
			$domArray = $this -> arraySort($statDom, 0);
		}

		$total = array_sum($domArray);
		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 20%;'><a title='".($this -> order ? "sort by total" : "sort alphabetically")."'href='".e_SELF."?5".($this -> order ? "" : ".1" )."'>".ADSTAT_L28."</a></td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L21."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		foreach($domArray as $key => $info) {
			if($key = $this -> getcountry($key)) {
				$percentage = round(($info/$total) * 100, 2);
				$text .= "<tr>
				<td class='forumheader3' style='width: 20%;'>".$key."</td>
				<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>
				<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>
				</tr>\n";
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></td></tr>\n</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderScreens() {
		global $sql;

		if($entries = $sql -> db_Select("logstats", "*", "log_id='statScreen'")) {
			$row = $sql -> db_Fetch();
			$statScreen = unserialize($row['log_data']);
		}

		/* temp consolidate today's data ... */
		foreach($this -> fileScreenInfo as $name => $count) {
			$statScreen[$name] += $count;
		}

		if(!is_array($statScreen)) {
			return "<div style='text-align: center;'>".ADSTAT_L25."</div>";
		}

		if($this -> order) {
			$nsarray = array();
			foreach($statScreen as $key => $info) {
				if(preg_match("/(\d+)x/", $key, $match)) {
					$nsarray[$key] = array('width' => $match[1], 'info' => $info);
				}
			}
			$nsarray = $this -> arraySort($nsarray, 'width', SORT_ASC);
			reset($nsarray);
			$screenArray = array();
			foreach($nsarray as $key => $info) {
				$screenArray[$key] = $info['info'];
			}

		} else {
			$screenArray = $this -> arraySort($statScreen, 0);
		}

		$total = array_sum($screenArray);
		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 20%;'><a title='".($this -> order ? "sort by total" : "sort alphabetically")."'href='".e_SELF."?6".($this -> order ? "" : ".1" )."'>".ADSTAT_L29."</a></td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L21."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		foreach($screenArray as $key => $info) {
			if(strstr($key, "@") && !strstr($key, "undefined") && preg_match("/(\d+)x(\d+)@(\d+)/", $key)) {
				$percentage = round(($info/$total) * 100, 2);
				$text .= "<tr>
				<td class='forumheader3' style='width: 20%;'><img src='".e_PLUGIN."log/images/screen.png' alt='' style='vertical-align: middle;' /> ".$key."</td>".
				($entries == 1 ? "<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>" : "<td class='forumheader3' style='width: 70%;'>".$this -> bar($percentage, $info)."</td>")."
				<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>
				</tr>\n";
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></td></tr>\n</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderRefers() {
		global $sql, $pref;

		if($sql -> db_Select("logstats", "*", "log_id='statReferer'")) {
			$row = $sql -> db_Fetch();
			$statRefer = unserialize($row['log_data']);
		}

		/* temp consolidate today's data ... */
		foreach($this -> fileReferInfo as $name => $count) {
			$statRefer[$name]['url'] = $count['url'];
			$statRefer[$name]['ttl'] += $count['ttl'];
		}

		//echo "<pre>"; print_r($statRefer); echo "</pre>"; exit;

		if(!is_array($statRefer) || !count($statRefer)) {
			return "<div style='text-align: center;'>".ADSTAT_L25.".</div>";
		}

		$statArray = $this -> arraySort($statRefer, 'ttl');

		$total = 0;
		foreach($statArray as $key => $info) {
			$total += $info['ttl'];
		}

		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 40%;'><a title='".($this -> order ? "show cropped url" : "show full url")."'href='".e_SELF."?7".($this -> order ? "" : ".1" )."'>".ADSTAT_L30."</a></td>\n<td class='fcaption' style='width: 50%;' colspan='2'>".ADSTAT_L21."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		$count = 0;
		foreach($statArray as $key => $info) {
			$percentage = round(($info['ttl']/$total) * 100, 2);
			if (!$this -> order && strlen($key) > 50) {
				$key = substr($key, 0, 50)." ...";
			}
			$text .= "<tr>
			<td class='forumheader3'><img src='".e_PLUGIN."log/images/html.png' alt='' style='vertical-align: middle;' /> <a href='".$info['url']."' rel='external'>".$key."</a></td>
			<td class='forumheader3'>".$this -> bar($percentage, $info['ttl'])."</td>
			<td class='forumheader3' style='text-align: center;'>".$percentage."%</td>
			</tr>\n";
			$count++;
			if($count == $pref['statDisplayNumber']) {
				break;
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></td></tr>\n</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderQueries() {
		global $sql;

		if($sql -> db_Select("logstats", "*", "log_id='statQuery'")) {
			$row = $sql -> db_Fetch();
			$statQuery = unserialize($row['log_data']);
		}

		/* temp consolidate today's data ... */
		foreach($this -> fileQueryInfo as $name => $count) {
			$statQuery[$name] += $count;
		}

		if(!is_array($statQuery) || !count($statQuery)) {
			return "<div style='text-align: center;'>".ADSTAT_L25."</div>";
		}

		$queryArray = $this -> arraySort($statQuery, 0);
		$total = array_sum($queryArray);
		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 60%;'>".ADSTAT_L31."</td>\n<td class='fcaption' style='width: 30%;' colspan='2'>".ADSTAT_L21."</td>\n<td class='fcaption' style='width: 10%; text-align: center;'>%</td>\n</tr>\n";
		$count = 1;
		foreach($queryArray as $key => $info) {
			$percentage = round(($info/$total) * 100, 2);
			$key = str_replace("%20", " ", $key);
			$text .= "<tr>
			<td class='forumheader3' style='width: 60%;'><img src='".e_PLUGIN."log/images/screen.png' alt='' style='vertical-align: middle;' /> ".$key."</td>
			<td class='forumheader3' style='width: 30%;'>".$this -> bar($percentage, $info)."</td>
			<td class='forumheader3' style='width: 10%; text-align: center;'>".$percentage."%</td>
			</tr>\n";
			$count ++;
			if($count == $pref['statDisplayNumber']) {
				break;
			}
		}
		$text .= "<tr><td class='forumheader' colspan='2'>".ADSTAT_L21."</td><td class='forumheader' style='text-align: center;'>$total</td><td class='forumheader'></td></tr>\n</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function recentVisitors() {
		if(!is_array($this -> fileRecent) || !count($this -> fileRecent)) {
			return "<div style='text-align: center;'>".ADSTAT_L25.".</div>";
		}

		$gen = new convert;
		$recentArray = array_reverse($this -> fileRecent, TRUE);
		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L18."</td>\n<td class='fcaption' style='width: 70%;'>Information</td>\n</tr>\n";

		foreach($recentArray as $key => $info) {
			if(is_array($info)) {
				$host      = $info['host'];
				$datestamp = $info['date'];
				$os        = $info['os'];
				$browser   = $info['browser'];
				$screen    = $info['screen'];
				$referer   = $info['referer'];
			} else {
				list($host, $datestamp, $os, $browser, $screen, $referer) = explode(chr(1), $info);
			}
			$datestamp = $gen -> convert_date($datestamp, "long");

			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'>$datestamp</td>
			<td class='forumheader3' style='width: 70%;'>Host: $host<br />".ADSTAT_L26.": $browser<br />".ADSTAT_L27.": $os<br />".ADSTAT_L29.": $screen".($referer ? "<br />".ADSTAT_L32.": <a href='$referer' rel='external'>$referer</a>" : "")."</td>
			</tr>\n";
		}

		$text .= "</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderDaily() {
		global $sql, $siteTotal, $siteUnique;

		$td = date("Y-m-j", time());
		$dayarray[$td] = array();
		$pagearray = array();

		$qry = "
		SELECT * from #logstats WHERE log_id REGEXP('[[:digit:]]+\-[[:digit:]]+\-[[:digit:]]+')
		ORDER BY CONCAT(LEFT(log_id,4), SUBSTRING(log_id, 6, 2), LPAD(SUBSTRING(log_id, 9), 2, '0'))
		DESC LIMIT 0,14
		";

		if($amount = $sql -> db_Select_gen($qry)) {
			$array = $sql -> db_getList();

			$ttotal = 0;
			$utotal = 0;

			foreach($array as $key => $value) {
				extract($value);
				if(is_array($log_data)) {
					$entries[0] = $log_data['host'];
					$entries[1] = $log_data['date'];
					$entries[2] = $log_data['os'];
					$entries[3] = $log_data['browser'];
					$entries[4] = $log_data['screen'];
					$entries[5] = $log_data['referer'];
				} else {
					$entries = explode(chr(1), $log_data);
				}

				$dayarray[$log_id]['daytotal'] = $entries[0];
				$dayarray[$log_id]['dayunique'] = $entries[1];

				unset($entries[0]);
				unset($entries[1]);
				
				foreach($entries as $entry) {
					if($entry) {
						list($url, $total, $unique) = explode("|", $entry);
						if(strstr($url, "/")) {
							$urlname = preg_replace("/\.php|\?.*/", "", substr($url, (strrpos($url, "/")+1)));
						} else {
							$urlname = preg_replace("/\.php|\?.*/", "", $url);
						}
						$dayarray[$log_id][$urlname] = array('url' => $url, 'total' => $total, 'unique' => $unique);
						$pagearray[$urlname]['total'] += $total;
						$pagearray[$urlname]['unique'] += $unique;
						$ttotal += $total;
						$utotal += $unique;
					}
				}
			}
		}

		foreach($this -> fileInfo as $fkey => $fvalue)
		{
			$dayarray[$td][$fkey]['total'] += $fvalue['ttl'];
			$dayarray[$td][$fkey]['unique'] += $fvalue['unq'];
			$dayarray[$td]['daytotal'] += $fvalue['ttl'];
			$dayarray[$td]['dayunique'] += $fvalue['unq'];
			$pagearray[$fkey]['total'] += $fvalue['ttl'];
			$pagearray[$fkey]['unique'] += $fvalue['unq'];
			$ttotal += $fvalue['ttl'];
			$utotal += $fvalue['unq'];
		}

		$text = "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L33." ".($amount+1)." ".ADSTAT_L40."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L34."</td>\n</tr>\n";

		foreach($dayarray as $date => $total) {

			list($year, $month, $day) = explode("-", $date);
			$date = strftime ("%A, %B %d", mktime (0,0,0,$month,$day,$year));
			$barWidth = round(($total['daytotal']/$ttotal) * 100, 2);
			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'>$date</td>
			<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['daytotal'])."</td>
			</tr>\n";
		}

		$text .= "</table>";
		$text .= "<br /><table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L35." ".($amount+1)." ".ADSTAT_L40."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L34."</td>\n</tr>\n";


		foreach($dayarray as $date => $total) {
			list($year, $month, $day) = explode("-", $date);
			$date = strftime ("%A, %B %d", mktime (0,0,0,$month,$day,$year));
			$barWidth = round(($total['dayunique']/$utotal) * 100, 2);
			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'>$date</td>
			<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['dayunique'])."</td>
			</tr>\n";
		}
		$text .= "</table>";

		$text .= "<br /><table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L33." ".($amount+1)." ".ADSTAT_L36."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L34."</td>\n</tr>\n";

		$newArray = $this -> arraySort($pagearray, "total");
		foreach($newArray as $key => $total) {
			$barWidth = round(($total['total']/$ttotal) * 100, 2);
			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'><img src='".e_PLUGIN."log/images/html.png' alt='' style='vertical-align: middle;' /> $key</td>
			<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['total'])."</td>
			</tr>\n";

		}
		$text .= "</table>";
		$text .= "<br /><table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L35." ".($amount+1)." ".ADSTAT_L36."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L34."</td>\n</tr>\n";
		$newArray = $this -> arraySort($pagearray, "unique");

		foreach($newArray as $key => $total) {
			$barWidth = round(($total['unique']/$utotal) * 100, 2);
			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'><img src='".e_PLUGIN."log/images/html.png' alt='' style='vertical-align: middle;' /> $key</td>
			<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['unique'])."</td>
			</tr>\n";
		}
		$text .= "</table>";
		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function renderMonthly() 
	{
		global $sql;

		if(!$entries = $sql -> db_Select("logstats", "*", "log_id REGEXP('^[[:digit:]]+\-[[:digit:]]+$') ORDER BY CONCAT(LEFT(log_id,4), RIGHT(log_id,2)) DESC")) {
			return ADSTAT_L42;
		}

		$array = $sql -> db_getList();

		$monthTotal = array();
		$mtotal = 0;
		$utotal = 0;
		foreach($array as $info) 
		{
			$date = $info['log_id'];
			$stats = unserialize($info['log_data']);

			/*
			Used to have to calculate monthly stats by adding the individual page access fields
			foreach($stats as $key => $total) 
			{
				if (!isset($monthTotal[$date]['totalv'])) $monthTotal[$date]['totalv'] = 0;
				if (!isset($monthTotal[$date]['uniquev'])) $monthTotal[$date]['uniquev'] = 0;
				$monthTotal[$date]['totalv'] += $total['ttlv'];
				$monthTotal[$date]['uniquev'] += $total['unqv'];
				$mtotal += $total['ttlv'];
				$utotal += $total['unqv'];
			}
			*/
			// Now we store a total, so just use that
			$monthTotal[$date]['totalv'] = varset($stats['TOTAL']['ttlv'], 0);
			$monthTotal[$date]['uniquev'] = varset($stats['TOTAL']['unqv'], 0);
			$mtotal += $monthTotal[$date]['totalv'];
			$utotal += $monthTotal[$date]['uniquev'];
		}

		$tmpArray = $this -> arraySort($monthTotal, "totalv");

		$text .= "<table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L37."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L34."</td>\n</tr>\n";

		foreach($monthTotal as $date => $total) {

			list($year, $month) = explode("-", $date);
			$date = strftime ("%B %Y", mktime (0,0,0,$month,1,$year));
			$barWidth = round(($total['totalv']/$mtotal) * 100, 2);
			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'>$date</td>".
			($entries == 1 ? "<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['totalv'])."</td>" : "<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['totalv'])."</td>")."
			</tr>\n";
		}
		$text .= "</table>";

		$text .= "<br /><table class='fborder' style='width: 100%;'>\n<tr>\n<td class='fcaption' style='width: 30%;'>".ADSTAT_L38."</td>\n<td class='fcaption' style='width: 70%;' colspan='2'>".ADSTAT_L34."</td>\n</tr>\n";

		foreach($monthTotal as $date => $total) {
			$barWidth = round(($total['uniquev']/$utotal) * 100, 2);
			list($year, $month) = explode("-", $date);
			$date = strftime ("%B %Y", mktime (0,0,0,$month,1,$year));
			$text .= "<tr>
			<td class='forumheader3' style='width: 30%;'>$date</td>".
			($entries == 1 ? "<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['uniquev'])."</td>" : "<td class='forumheader3' style='width: 70%;'>".$this -> bar($barWidth, $total['uniquev'])."</td>")."
			</tr>\n";
		}
		$text .= "</table>";


		return $text;
	}

	/* -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function getWidthRatio ($array, $column) {
		$tmpArray = $this -> arraySort($array, $column);
		$data = each($tmpArray);
		$maxValue = $data[1]['totalv'];
		echo "<b>maxValue</b> ".$maxValue." <br />";
		$ratio = 0;
		while($maxValue > 100) {
			$maxValue = ($maxValue / 2);
			$ratio ++;
		}
		if(!$ratio)
		{
			return 1;
		}
		echo "<b>ratio</b> ".$ratio." <br />";
		return $ratio;
	}

	function getcountry($dom) {
		global $country;
		return $country[$dom];
	}

	function bar($percen, $val)
	{
		return "<div class='b' style='width: ".intval($percen)."%'></div>
		</td>
		<td style='width:10%; text-align:center' class='forumheader3'>".$val;
	}

	function remove_entry($toremove) 
	{	// Note - only removes info from the database - not from the current page file
	  global $sql;
	  if ($sql -> db_Select("logstats", "*", "log_id='pageTotal'"))
	  {
		$row = $sql -> db_Fetch();
		$dbPageInfo = unserialize($row[2]);
		unset($dbPageInfo[$toremove]);
		$dbPageDone = serialize($dbPageInfo);
		$sql -> db_Update("logstats", "log_data='{$dbPageDone}' WHERE log_id='pageTotal' ");
//		$this -> renderAlltimeVisits();
		return TRUE;
	  }
	  return FALSE;
	}
}



?>