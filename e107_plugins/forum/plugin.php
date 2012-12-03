<?php
/**
 * e107 website system
 * 
 * Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
 * Copyright (C) 2008-2010 e107 Inc (e107.org)
 * 
 * Released under the terms and conditions of the GNU General Public License
 * (http://gnu.org).
 * 
 * $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/plugin.php $
 * $Revision: 12538 $
 * $Id: plugin.php 12538 2012-01-11 12:37:03Z berckoff $
 * $Author: berckoff $
 */

if (!defined('e107_INIT'))  exit;

include_lan(e_PLUGIN.'forum/languages/'.e_LANGUAGE.'/lan_forum_conf.php');

# Plugin info
$eplug_name         = LAN_FORUM_INSTALL_01;
$eplug_url          = 'http://e107.org';
$eplug_email        = '';
$eplug_author       = 'e107dev';
$eplug_version      = '1.2';
$eplug_compatible   = 'e107v0.7+';
$eplug_description  = LAN_FORUM_INSTALL_02;
$eplug_readme       = '';

# Plugin options
$eplug_latest       = true;                  # Show reported threads in admin (use latest.php)
$eplug_status       = true;                  # Show post count in admin (use status.php)
$eplug_folder       = 'forum';               # Name of the plugin's folder
$eplug_conffile     = 'forum_admin.php';     # Name of the admin configuration file
$eplug_menu_name    = 'forum';               # Name of menu item for plugin

$eplug_link         = true;                  # Create a link in main menu (true=YES, false=NO)
$eplug_link_url     = e_PLUGIN.'forum/forum.php';
$eplug_link_name    = LAN_FORUM_INSTALL_01;

$eplug_done         = LAN_FORUM_INSTALL_04;  # Message for successfull instalation
$eplug_upgrade_done = sprintf(LAN_FORUM_INSTALL_05, $eplug_version);

# Icon images and caption text
$eplug_icon         = $eplug_folder.'/images/forums_32.png';
$eplug_icon_small   = $eplug_folder.'/images/forums_16.png';
$eplug_caption      = LAN_FORUM_INSTALL_03;


# List of plugin preferences
$eplug_prefs        = array(
	'forum_poll'          => '0',
	'forum_track'         => '0',
	'forum_title'         => LAN_FORUM_INSTALL_01,
	'forum_eprefix'       => LAN_FORUM_INSTALL_06,
	'forum_postfix'       => LAN_FORUM_INSTALL_07,
	'forum_enclose'       => '1',
	'forum_popular'       => '10',
	'forum_postspage'     => '10',
	'forum_show_topics'   => '1',
	'forum_hilightsticky' => '1',
);

# List of DB tables (names)
$eplug_table_names  = array('forum', 'forum_t');

# List of SQL requests (create tables)
$eplug_tables       = array(
"CREATE TABLE ".MPREFIX."forum (
	forum_id int(10) unsigned NOT NULL auto_increment,
	forum_name varchar(250) NOT NULL default '',
	forum_description text NOT NULL,
	forum_parent int(10) unsigned NOT NULL default '0',
	forum_sub int(10) unsigned NOT NULL default '0',
	forum_datestamp int(10) unsigned NOT NULL default '0',
	forum_moderators text NOT NULL,
	forum_threads int(10) unsigned NOT NULL default '0',
	forum_replies int(10) unsigned NOT NULL default '0',
	forum_lastpost_user varchar(200) NOT NULL default '',
	forum_lastpost_info varchar(40) NOT NULL default '',
	forum_class varchar(100) NOT NULL default '',
	forum_order int(10) unsigned NOT NULL default '0',
	forum_postclass tinyint(3) unsigned NOT NULL default '0',
	PRIMARY KEY  (forum_id)
) ENGINE=MyISAM AUTO_INCREMENT=1;",

"CREATE TABLE ".MPREFIX."forum_t (
	thread_id int(10) unsigned NOT NULL auto_increment,
	thread_name varchar(250) NOT NULL default '',
	thread_thread text NOT NULL,
	thread_forum_id int(10) unsigned NOT NULL default '0',
	thread_datestamp int(10) unsigned NOT NULL default '0',
	thread_parent int(10) unsigned NOT NULL default '0',
	thread_user varchar(250) NOT NULL default '',
	thread_views int(10) unsigned NOT NULL default '0',
	thread_active tinyint(3) unsigned NOT NULL default '0',
	thread_lastpost int(10) unsigned NOT NULL default '0',
	thread_s tinyint(1) unsigned NOT NULL default '0',
	thread_edit_datestamp int(10) unsigned NOT NULL default '0',
	thread_lastuser varchar(30) NOT NULL default '',
	thread_total_replies int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (thread_id),
	KEY thread_parent (thread_parent),
	KEY thread_datestamp (thread_datestamp),
	KEY thread_forum_id (thread_forum_id)
) ENGINE=MyISAM AUTO_INCREMENT=1;",
);

# Update SQL queries
$upgrade_alter_tables = array(
	"ALTER TABLE ".MPREFIX."forum ADD forum_postclass TINYINT(3) UNSIGNED DEFAULT '0' NOT NULL;",
);

if (!function_exists('forum_install'))
{
	function forum_install()
	{
		$sql = new db();
		$sql->db_Update('user', "user_forums='0'");
	}
}

if (!function_exists('forum_uninstall'))
{
	function forum_uninstall()
	{
		$sql = new db();
		$sql->db_Update('user', "user_forums='0'");
	}
}