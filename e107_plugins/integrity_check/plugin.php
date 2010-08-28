<?php
/*
+---------------------------------------------------------------+
| e107 website system
| �Steve Dunstan 2001-2002
| http://e107.org
| jalist@e107.org
|
| Plugin : Integrity-Checker
| Version: 0.01 (first release)
| �HeX0R 2004
| http://h3x0r.ath.cx
| hex0r@h3x0r.ath.cx

| Released under the terms and conditions of the
| GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "Integrity Check";
$eplug_version = "0.03";
$eplug_author = "HeX0R";
$eplug_url = "http://h3x0r.ath.cx";
$eplug_email = "hex0r@h3x0r.ath.cx";
$eplug_description = "This plugin checks the checksums of your files, helping to find corrupted files.";
$eplug_compatible = "e107v6";
$eplug_readme = "";

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "integrity_check";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_integrity_check.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/integrity_32.png";
$eplug_icon_small = $eplug_folder."/images/integrity_16.png";
$eplug_caption = "Check Integrity";

// List of preferences -----------------------------------------------------------------------------------------------

$eplug_prefs = "";

// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = "";


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "Integrity-Check-Plugin successfully installed!";

// upgrading ... //

$upgrade_add_prefs = "";

$upgrade_remove_prefs = "";

$upgrade_alter_tables = "";

$eplug_upgrade_done = "Integrity-Check-Plugin successfully updated!";

?>