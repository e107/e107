// $Id: admin_pword.sc 11836 2010-09-30 21:43:10Z e107coders $
// <?
if (ADMIN && ADMINPERMS == "0") {
	global $ns;
	if ($pref['adminpwordchange'] && ((ADMINPWCHANGE+2592000) < time())) {
		$text = "<div style='mediumtext; text-align:center'>".ADLAN_102." <a href='".e_ADMIN_ABS."updateadmin.php'>".ADLAN_103."</a></div>";
		return $ns -> tablerender(ADLAN_104, $text, 'admin_pword', TRUE);
	}
}
