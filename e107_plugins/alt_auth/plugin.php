<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     �Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: /cvs_backup/e107_0.7/e107_plugins/alt_auth/plugin.php,v $
|     $Revision: 11346 $
|     $Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|     $Author: secretr $
+----------------------------------------------------------------------------+
*/


// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "Alternate Authentication";
$eplug_version = "0.3";
$eplug_author = "McFly";
$eplug_logo = "/images/icon_ldap.png";
$eplug_url = "";
$eplug_email = "mcfly@e107.org";
$eplug_description = "This plugin allows for alternate authentication methods.";
$eplug_compatible = "e107v7+";
$eplug_readme = "";	// leave blank if no readme file

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "alt_auth";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "alt_auth";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "alt_auth_conf.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/icon_ldap.png";
$eplug_caption =  "Configure Alt auth";

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = "";

// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = array(
	"alt_auth"
);

// List of sql requests to create tables -----------------------------------------------------------------------------


$eplug_tables = array(
"CREATE TABLE ".MPREFIX."alt_auth (
  auth_type varchar(20) NOT NULL default '',
  auth_parmname varchar(30) NOT NULL default '',
  auth_parmval varchar(120) NOT NULL default ''
) TYPE=MyISAM;");



// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "Alt auth service is now set up.  You will now need to configure your preferred method.";

?>	
