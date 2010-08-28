// $Id: admin_update.sc 11346 2010-02-17 18:56:14Z secretr $
global $tp;
	if (!ADMIN) return "";

	global $e107cache,$ns, $pref;
	
  	if (!varset($pref['check_updates'], FALSE)) return "";
	
	if (is_readable(e_ADMIN."ver.php"))
	{
		include(e_ADMIN."ver.php");
	}

	$feed = "http://www.e107.org/releases.php";
	
	$e107cache->CachePageMD5 = md5($e107info['e107_version']);

    if($cacheData = $e107cache->retrieve("updatecheck",3600, TRUE))
    {
   	  	return $ns -> tablerender(LAN_NEWVERSION, $cacheData);
    }

	// Keep commented out to be sure it continues to work under all circumstances.

	//if ((strpos(e_SELF,'localhost') !== FALSE) || (strpos(e_SELF,'127.0.0.1') !== FALSE)) return '';

	require_once(e_HANDLER."xml_class.php");
	
	$xml = new parseXml;
	$xm = new XMLParse();
	
    $ftext = "";
	
	if($rawData = $xml -> getRemoteXmlFile($feed,5))
	{	
		$array = $xm->parse($rawData);
		
		list($cur_version,$tag) = explode(" ", $e107info['e107_version']);

		foreach($array['e107Release']['core'] as $val)
		{
			$val = (array) $val;
	
			$version = varsettrue($val['attributes']['version']);
			$link = varsettrue($val['attributes']['url']);
			$compat = varsettrue($val['attributes']['compatibility']);
	
		 	if(($compat == '0.7') && version_compare($version,$cur_version)==1)
			{
	        	$ftext = "<a rel='external' href='".$link."' >".sprintf(LAN_NEWVERSION_DLD, "e107 v".$version)."</a><br />\n";
	        	if(varsettrue($val['description']))
	        	{
	        		$ftext .= '<br />'.$tp->toHTML(trim($val['description']), true, 'BODY').'<br />';
	        	}
	        	if(varsettrue($val['attributes']['infourl']))
	        	{
	        		$ftext .= "<a rel='external' href='".$val['attributes']['infourl']."' >".LAN_NEWVERSION_MORE."</a>\n";
	        	}
				break;
			}
		}
	}
	else // Error getting data
	{  
	  $ftext = ADLAN_154;
	}

	$e107cache->set("updatecheck", $ftext, TRUE);
	
	if($ftext)
	{
		return $ns -> tablerender(LAN_NEWVERSION, $ftext);
	}


