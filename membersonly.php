<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvs_backup/e107_0.7/membersonly.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/
require_once("class2.php");

include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_membersonly.php");

if(is_readable(THEME."membersonly_template.php"))
{
	require_once(THEME."membersonly_template.php");
}
else
{
	require_once(e_THEME."templates/membersonly_template.php");
}

$HEADER=""; 
$FOOTER=""; 

include_once(HEADERF);

echo $MEMBERSONLY_BEGIN;
$ns->tablerender($MEMBERSONLY_CAPTION, $MEMBERSONLY_TABLE); 
echo $MEMBERSONLY_END;

?>
