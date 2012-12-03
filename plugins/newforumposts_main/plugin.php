<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/newforumposts_main/plugin.php $
|     $Revision: 11678 $
|     $Id: plugin.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "New Forum Posts";
$eplug_version = "1";
$eplug_author = "jalist";
$eplug_url = "http://e107.org";
$eplug_email = "jalist@e107.org";
$eplug_description = "This plugin displays a list of new forum posts on your front page";
$eplug_compatible = "e107v6";
$eplug_readme = "";
// leave blank if no readme file
	
// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "newforumposts_main";
	
// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "newforumposts_main";
	
// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";
	
// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/new_forum_32.png";
$eplug_icon_small = $eplug_folder."/images/new_forum_16.png";
$eplug_caption = "Configure New Forum Posts";
	
// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array(
"nfp_display" => 0,
	"nfp_caption" => "Latest Forum Posts",
	"nfp_amount" => 5,
	);
	
// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = "";
	
// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = "";
	
	
// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$ec_dir = e_PLUGIN."";
$eplug_link_url = "";
	
	
// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "To configure please click on the link in the plugins section of the admin front page";
	
	
// upgrading ... //
	
$upgrade_add_prefs = "";
	
$upgrade_remove_prefs = "";
	
$upgrade_alter_tables = "";
	
$eplug_upgrade_done = "";
	
	
	
	
	
?>