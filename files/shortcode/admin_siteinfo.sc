// $Id: admin_siteinfo.sc 12060 25,09,2011 03:54:47 Predator $
//<?
if (ADMIN) 
{
	global $ns, $pref, $themename, $themeversion, $themeauthor, $themedate, $themeinfo, $mySQLdefaultdb;

	if (file_exists(e_ADMIN."ver.php"))
	{ 
		include(e_ADMIN."ver.php"); 
	}
	
	if($parm == "version")
	{
		return $e107info['e107_version'];
	}
	
	
	

	$obj = new convert;
	$install_date = $obj->convert_date($pref['install_date'], "long");

	$text = "<input style=\"display:block; margin:5px auto 5px;\" alt=\"е107 Клуб - Официальный портал поддержки пользователей русскоязычного сообщества е107 cms - Нажмите кнопку для перехода\" title=\"е107 Клуб - Официальный портал поддержки пользователей русскоязычного сообщества е107 cms - Нажмите кнопку для перехода\" type=\"button\" class=\"button\" value=\"Портал поддержки пользователей\" onclick=\"window.open('http://www.e107club.ru/', '_blank');\" /><br /><br />
	<b>".FOOTLAN_1."</b>
	<br />".
	SITENAME."
	<br /><br />
	<b>".FOOTLAN_2."</b>
	<br />
	<a href=\"mailto:".SITEADMINEMAIL."\">".SITEADMIN."</a>
	<br />
	<br />
	<b>e107</b>
	<br />
	".FOOTLAN_3." ".$e107info['e107_version']."
	<br /><br />
	<b>".FOOTLAN_20."</b>
	<br />
	[".e_SECURITY_LEVEL."] ".defset('LAN_SECURITYL_'.e_SECURITY_LEVEL, 'n/a')." 
	<br /><br />
	<b>".FOOTLAN_18."</b>
	<br />".$pref['sitetheme']."<br /><br />
	<b>".FOOTLAN_5."</b>
	<br />
	".$themename." v".$themeversion." ".($themeauthor ? FOOTLAN_6.' '.$themeauthor : '')." ".($themedate ? "(".$themedate.")" : "");

	$text .= $themeinfo ? "<br />".FOOTLAN_7.": ".$themeinfo : "";

	$text .= "<br /><br />
	<b>".FOOTLAN_8."</b>
	<br />
	".$install_date."
	<br /><br />
	<b>".FOOTLAN_19."</b>
	<br />
	".date('r')."
	<br /><br />
	<b>".FOOTLAN_9."</b>
	<br />".
	 preg_replace("/PHP.*/i", "", $_SERVER['SERVER_SOFTWARE'])."<br />(".FOOTLAN_10.": ".$_SERVER['SERVER_NAME'].")
	<br /><br />
	<b>".FOOTLAN_11."</b>
	<br />
	".phpversion()."
	<br /><br />
	<b>".FOOTLAN_12."</b>
	<br />
	".mysql_get_server_info().
	"<br />
	".FOOTLAN_16.": ".$mySQLdefaultdb."
	<br /><br />
	<b>".FOOTLAN_17."</b>
	<br />".CHARSET;
	return $ns -> tablerender(FOOTLAN_13, $text, 'admin_siteinfo', TRUE);
}