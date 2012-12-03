<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/gsitemap/plugin.php $
|     $Revision: 12178 $
|     $Id: plugin.php 12178 2011-05-02 20:45:40Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "Google Sitemap";
$eplug_version = "1.0";
$eplug_author = "cameron / jalist";

$eplug_url = "http://e107coders.org";
$eplug_email = "cameron@e107coders.org";
$eplug_description = "Google Sitemap. For more information on the Sitemap protocol, go to <a href='http://www.sitemaps.org/'>http://www.sitemaps.org/</a> or <a href='http://www.google.com/support/webmasters/bin/answer.py?answer=156184'>Google's page About Sitemaps</a>";
$eplug_compatible = "e107 v0.7";
$eplug_readme = "";        // leave blank if no readme file

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "gsitemap";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
 $eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/icon.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_logo = $eplug_folder."/images/icon.png";

$eplug_caption =  "Configure Sitemap";

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = "";
$eplug_module = TRUE;
$eplug_table_names = array("gsitemap");


// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = array("
CREATE TABLE ".MPREFIX."gsitemap (
	gsitemap_id int(11) unsigned NOT NULL auto_increment,
	gsitemap_name varchar(200) NOT NULL default '',
	gsitemap_url varchar(200) NOT NULL default '',
	gsitemap_lastmod varchar(15) NOT NULL default '',
	gsitemap_freq varchar(10) NOT NULL default '',
	gsitemap_priority char(3) NOT NULL default '',
	gsitemap_cat varchar(100) NOT NULL default '',
	gsitemap_order int(3) NOT NULL default '0',
	gsitemap_img varchar(50) NOT NULL default '',
	gsitemap_active int(3) NOT NULL default '0',
	PRIMARY KEY  (gsitemap_id)
) ENGINE=MyISAM;"
);


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = TRUE;
$eplug_link_name = "Sitemap";
$eplug_link_url = "gsitemap.php?show";


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "Installation Successful..";

$eplug_uninstall_done = "You should delete gsitemap.php from your root directory.";

// upgrading ... //

$upgrade_add_prefs = '';

$upgrade_remove_prefs = '';

$upgrade_alter_tables = '';

$eplug_upgrade_done = '';
?>