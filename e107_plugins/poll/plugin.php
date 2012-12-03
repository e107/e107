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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/poll/plugin.php $
|     $Revision: 12178 $
|     $Id: plugin.php 12178 2011-05-02 20:45:40Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."poll/languages/".e_LANGUAGE.".php");

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = 'POLL_ADLAN01';
$eplug_version = "2.0";
$eplug_author = "Steve Dunstan (jalist)";
$eplug_url = "http://e107.org";
$eplug_email = "jalist@e107.org";
$eplug_description = POLL_ADLAN02;
$eplug_compatible = "e107v0.7+";
$eplug_readme = "";

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "poll";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "poll_menu";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";


// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/polls_32.png";
$eplug_icon_small = $eplug_folder."/images/polls_16.png";
$eplug_caption = POLL_ADLAN03;

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array();

// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = array("polls");

// List of comment_type ids used by this plugin. -----------------------------
$eplug_comment_ids = array(4);

// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = array(
"CREATE TABLE ".MPREFIX."polls (
  poll_id int(10) unsigned NOT NULL auto_increment,
  poll_datestamp int(10) unsigned NOT NULL default '0',
  poll_start_datestamp int(10) unsigned NOT NULL default '0',
  poll_end_datestamp int(10) unsigned NOT NULL default '0',
  poll_admin_id int(10) unsigned NOT NULL default '0',
  poll_title varchar(250) NOT NULL default '',
  poll_options text NOT NULL,
  poll_votes text NOT NULL,
  poll_ip text NOT NULL,
  poll_type tinyint(1) unsigned NOT NULL default '0',
  poll_comment tinyint(1) unsigned NOT NULL default '1',
  poll_allow_multiple tinyint(1) unsigned NOT NULL default '0',
  poll_result_type tinyint(2) unsigned NOT NULL default '0',
  poll_vote_userclass tinyint(3) unsigned NOT NULL default '0',
  poll_storage_method tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (poll_id)
) ENGINE=MyISAM;");

// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = POLL_ADLAN04;

?>
