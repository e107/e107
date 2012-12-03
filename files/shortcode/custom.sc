//<? $Id: custom.sc 11346 2010-02-17 18:56:14Z secretr $
global $tp, $pref;
$ret = "";
$custom_query = explode('+', $parm);
switch($custom_query[0])
{
  case "login":
  case "login noprofile":
	include_lan(e_PLUGIN."login_menu/languages/".e_LANGUAGE.".php");

	$sep = (defined("LOGINC_SEP")) ? LOGINC_SEP : "<span class='loginc sep'>.:.</span>";

	if (USER == TRUE)
	{
	  $ret .= "<span class='mediumtext'><span class='loginc welcome'>".LOGIN_MENU_L5." ".USERNAME."</span>&nbsp;&nbsp;&nbsp;".$sep." ";
	  if(ADMIN == TRUE)
	  {
		$ret .= "<a class='loginc admin' href='".e_ADMIN."admin.php'>".LOGIN_MENU_L11."</a> ".$sep." ";
	  }
	  $ret .= ($custom_query[0] != "login noprofile") ? "<a class='loginc profile' href='".e_BASE."user.php?id.".USERID."'>".LOGIN_MENU_L13."</a>\n".$sep." ":"";
	  $ret .= "<a class='loginc usersettings' href='" . e_BASE . "usersettings.php'>".LOGIN_MENU_L12."</a> ".$sep." <a class='loginc logout' href='".e_BASE."index.php?logout'>".LOGIN_MENU_L8."</a> ".$sep."</span>";
	} 
	else 
	{
	  $ret .= "<form method='post' action='".e_SELF.(e_QUERY ? '?'.e_QUERY : '')."'>\n<div class='loginc_div'>\n".LOGIN_MENU_L1."<input class='tbox loginc user' type='text' name='username' size='15' value='$username' maxlength='20' />&nbsp;&nbsp;\n".LOGIN_MENU_L2."<input class='tbox loginc pass' type='password' name='userpass' size='15' value='' maxlength='20' />&nbsp;&nbsp;\n";
	  $ret .= ($pref['user_tracking'] == "cookie") ? "<input type='checkbox' name='autologin' value='1' />".LOGIN_MENU_L6."&nbsp;&nbsp;\n" : "";
	  $ret .= "<input class='button loginc' type='submit' name='userlogin' value='".LOGIN_MENU_L28."' />";
	  if($pref['user_reg'])
	  {
		$ret .= "&nbsp;&nbsp;<a class='loginc signup' href='".e_SIGNUP."'>".LOGIN_MENU_L3."</a>";
	  }
	  $ret .= "</div>\n</form>";
	}
	return $ret;
	break;

		case "search":
				if(!check_class($pref['search_restrict']))
				{
						return "";
				}
				$searchflat = TRUE;
				include_once(e_PLUGIN."search_menu/search_menu.php");
				return "";
				break;

		case "quote":
				$qotd_file = e_BASE."quote.txt";
				if(!file_exists($qotd_file))
				{
						$quote = "Quote file not found ($qotd_file)";
				}
				else
				{
						$quotes = file(e_BASE."quote.txt");
						$quote = $tp->toHTML($quotes[rand(0, count($quotes) -1 )], TRUE);
				}
				return $quote;
				break;

		case 'language':
				//FIXME obtrusive and may not work with session or subdomains - certainly better to use {LANGUAGELINKS} anyway
				$languageList = explode(',', e_LANLIST);
				sort($languageList);
				$action = (e_QUERY && ! $_GET['elan']) ? e_SELF.'?'.e_QUERY : e_SELF;
				$text = '
				<form method="post" action="'.$action.'" id="langchange">
					<select name="sitelanguage" class="tbox" onchange=\'document.getElementById("langchange").submit()\'>';

				foreach($languageList as $languageFolder)
				{
					$selected = ($languageFolder == e_LANGUAGE) ? ' selected="selected"' : '';
					$text .= '
							<option value="'.$languageFolder.'"'.$selected.'>'.$languageFolder.'</option>';
				}

				$text .= '
					</select>
					<input type="hidden" name="setlanguage" value="1" />
				</form>';
				return $text;
				break;



		case "clock":
				$clock_flat = TRUE;
				include_once(e_PLUGIN."clock_menu/clock_menu.php");
				return "";
				break;



		case "welcomemessage":

				return $tp->parseTemplate("{WMESSAGE}");
				break;
}
