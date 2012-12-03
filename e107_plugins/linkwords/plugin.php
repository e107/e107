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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/linkwords/plugin.php $
|     $Revision: 12178 $
|     $Id: plugin.php 12178 2011-05-02 20:45:40Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."linkwords/languages/".e_LANGUAGE.".php");

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "LWLANINS_1";
$eplug_version = "1.1";
$eplug_author = "jalist";
$eplug_url = "http://e107.org";
$eplug_email = "jalist@e107.org";
$eplug_description = LWLANINS_2;
$eplug_compatible = "e107v7+";
$eplug_readme = "";
// leave blank if no readme file

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "linkwords";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/linkwords_32.png";
$eplug_icon_small = $eplug_folder."/images/linkwords_16.png";
$eplug_caption = LWLANINS_3;

// List of preferences -----------------------------------------------------------------------------------------------

$eplug_array_pref = array(
	'tohtml_hook' => 'linkwords'
	);
$eplug_prefs = array(
	'lw_page_visibility'=>'',
	'lw_context_visibility'=>array(			
			'olddefault' => FALSE,
			'title' => FALSE,
			'summary' => TRUE,
			'body' => TRUE,
			'description' => TRUE,
			'user_title' => FALSE,
			'user_body'  => TRUE,
			'linktext' => FALSE,
			'rawtext' => FALSE
			)
	);

// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = array(
	"linkwords"
);

// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = array(
	"CREATE TABLE ".MPREFIX."linkwords (
	linkword_id INT UNSIGNED NOT NULL auto_increment,
	linkword_active tinyint(1) unsigned NOT NULL default '0',
	linkword_word varchar(100) NOT NULL default '',
	linkword_link varchar(150) NOT NULL default '',
	PRIMARY KEY ( linkword_id )
	) ENGINE=MyISAM AUTO_INCREMENT=1;"
);


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$ec_dir = e_PLUGIN."";
$eplug_link_url = "";


// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = LWLANINS_4;


// upgrading ... //

$upgrade_add_prefs = array(
	'lw_page_visibility'=>'', 
	'lw_context_visibility'=>array(			
			'olddefault' => FALSE,
			'title' => FALSE,
			'summary' => TRUE,
			'body' => TRUE,
			'description' => TRUE,
			'linktext' => FALSE,
			'rawtext' => FALSE
			)
);

$upgrade_remove_prefs = "";

$upgrade_alter_tables = "";

$eplug_upgrade_done = "";





?>