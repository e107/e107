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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/sql/core_sql.php $
|     $Revision: 12063 $
|     $Id: core_sql.php 12063 2011-02-07 22:25:44Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/
header("location:../index.php");
exit;
?>
#
# +---------------------------------------------------------------+
# |        e107 website system
# |        /files/sql.php
# |
# |        ?Steve Dunstan 2001-2002
# |        http://e107.org
# |        jalist@e107.org
# |
# |        Released under the terms and conditions of the
# |        GNU General Public License (http://gnu.org).
# +---------------------------------------------------------------+
# Database : <variable>
# --------------------------------------------------------

#
# Table structure for table `banlist`
#

CREATE TABLE banlist (
  banlist_ip varchar(100) NOT NULL default '',
  banlist_admin smallint(5) unsigned NOT NULL default '0',
  banlist_reason tinytext NOT NULL,
  PRIMARY KEY  (banlist_ip)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `banner`
#

CREATE TABLE banner (
  banner_id int(10) unsigned NOT NULL auto_increment,
  banner_clientname varchar(100) NOT NULL default '',
  banner_clientlogin varchar(20) NOT NULL default '',
  banner_clientpassword varchar(50) NOT NULL default '',
  banner_image varchar(150) NOT NULL default '',
  banner_clickurl varchar(150) NOT NULL default '',
  banner_impurchased int(10) unsigned NOT NULL default '0',
  banner_startdate int(10) unsigned NOT NULL default '0',
  banner_enddate int(10) unsigned NOT NULL default '0',
  banner_active tinyint(3) unsigned NOT NULL default '0',
  banner_clicks int(10) unsigned NOT NULL default '0',
  banner_impressions int(10) unsigned NOT NULL default '0',
  banner_ip text NOT NULL,
  banner_campaign varchar(150) NOT NULL default '',
  PRIMARY KEY  (banner_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `comments`
#

CREATE TABLE comments (
  comment_id int(10) unsigned NOT NULL auto_increment,
  comment_pid int(10) unsigned NOT NULL default '0',
  comment_item_id int(10) unsigned NOT NULL default '0',
  comment_subject varchar(100) NOT NULL default '',
  comment_author varchar(100) NOT NULL default '',
  comment_author_email varchar(200) NOT NULL default '',
  comment_datestamp int(10) unsigned NOT NULL default '0',
  comment_comment text NOT NULL,
  comment_blocked tinyint(3) unsigned NOT NULL default '0',
  comment_ip varchar(20) NOT NULL default '',
  comment_type varchar(10) NOT NULL default '0',
  comment_lock tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (comment_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `core`
#
CREATE TABLE core (
  e107_name varchar(100) NOT NULL default '',
  e107_value text NOT NULL,
  PRIMARY KEY  (e107_name)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `dblog`
#
CREATE TABLE dblog (
  dblog_id int(10) unsigned NOT NULL auto_increment,
  dblog_type varchar(60) NOT NULL default '',
  dblog_datestamp int(10) unsigned NOT NULL default '0',
  dblog_user_id int(10) unsigned NOT NULL default '0',
  dblog_ip varchar(80) NOT NULL default '',
  dblog_title varchar(255) NOT NULL default '',
  dblog_remarks text NOT NULL,
  PRIMARY KEY  (dblog_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `download`
#

CREATE TABLE download (
  download_id int(10) unsigned NOT NULL auto_increment,
  download_name varchar(100) NOT NULL default '',
  download_url varchar(150) NOT NULL default '',
  download_author varchar(100) NOT NULL default '',
  download_author_email varchar(200) NOT NULL default '',
  download_author_website varchar(200) NOT NULL default '',
  download_description text NOT NULL,
  download_filesize varchar(20) NOT NULL default '',
  download_requested int(10) unsigned NOT NULL default '0',
  download_category int(10) unsigned NOT NULL default '0',
  download_active tinyint(3) unsigned NOT NULL default '0',
  download_datestamp int(10) unsigned NOT NULL default '0',
  download_thumb varchar(150) NOT NULL default '',
  download_image varchar(150) NOT NULL default '',
  download_comment tinyint(3) unsigned NOT NULL default '0',
  download_class varchar(255) NOT NULL default '0',
  download_mirror text NOT NULL,
  download_mirror_type tinyint(1) unsigned NOT NULL default '0',
  download_visible varchar(255) NOT NULL default '0',
  PRIMARY KEY  (download_id),
  UNIQUE KEY download_name (download_name),
  KEY download_category (download_category)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `download_category`
#

CREATE TABLE download_category (
  download_category_id int(10) unsigned NOT NULL auto_increment,
  download_category_name varchar(100) NOT NULL default '',
  download_category_description text NOT NULL,
  download_category_icon varchar(100) NOT NULL default '',
  download_category_parent int(10) unsigned NOT NULL default '0',
  download_category_class varchar(255) NOT NULL default '0',
  download_category_order int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (download_category_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `download_mirror`
#

CREATE TABLE download_mirror (
  mirror_id int(10) unsigned NOT NULL auto_increment,
  mirror_name varchar(200) NOT NULL default '',
  mirror_url varchar(200) NOT NULL default '',
  mirror_image varchar(200) NOT NULL default '',
  mirror_location varchar(100) NOT NULL default '',
  mirror_description text NOT NULL,
  mirror_count int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (mirror_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `download_requests`
#
CREATE TABLE download_requests (
  download_request_id int(10) unsigned NOT NULL auto_increment,
  download_request_userid int(10) unsigned NOT NULL default '0',
  download_request_ip varchar(30) NOT NULL default '',
  download_request_download_id int(10) unsigned NOT NULL default '0',
  download_request_datestamp int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (download_request_id),
  KEY download_request_userid (download_request_userid),
  KEY download_request_download_id (download_request_download_id)
) ENGINE=MyISAM;
# --------------------------------------------------------


#
# Table structure for table `flood`
#

CREATE TABLE flood (
  flood_url text NOT NULL,
  flood_time int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `headlines`
#

CREATE TABLE headlines (
  headline_id int(10) unsigned NOT NULL auto_increment,
  headline_url varchar(150) NOT NULL default '',
  headline_data text NOT NULL,
  headline_timestamp int(10) unsigned NOT NULL default '0',
  headline_description text NOT NULL,
  headline_image varchar(100) NOT NULL default '',
  headline_active tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (headline_id)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `links`
#

CREATE TABLE links (
  link_id int(10) unsigned NOT NULL auto_increment,
  link_name varchar(100) NOT NULL default '',
  link_url varchar(200) NOT NULL default '',
  link_description text NOT NULL,
  link_button varchar(100) NOT NULL default '',
  link_category tinyint(3) unsigned NOT NULL default '0',
  link_order int(10) unsigned NOT NULL default '0',
  link_parent int(10) unsigned NOT NULL default '0',
  link_open tinyint(1) unsigned NOT NULL default '0',
  link_class varchar(255) NOT NULL default '0',
  PRIMARY KEY  (link_id)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `menus`
#

CREATE TABLE menus (
  menu_id int(10) unsigned NOT NULL auto_increment,
  menu_name varchar(100) NOT NULL default '',
  menu_location tinyint(3) unsigned NOT NULL default '0',
  menu_order tinyint(3) unsigned NOT NULL default '0',
  menu_class varchar(255) NOT NULL default '0',
  menu_pages text NOT NULL,
  menu_path varchar(100) NOT NULL default '',
  PRIMARY KEY  (menu_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `news`
#

CREATE TABLE news (
  news_id int(10) unsigned NOT NULL auto_increment,
  news_title varchar(200) NOT NULL default '',
  news_body text NOT NULL,
  news_extended text NOT NULL,
  news_datestamp int(10) unsigned NOT NULL default '0',
  news_author int(10) unsigned NOT NULL default '0',
  news_category tinyint(3) unsigned NOT NULL default '0',
  news_allow_comments tinyint(3) unsigned NOT NULL default '0',
  news_start int(10) unsigned NOT NULL default '0',
  news_end int(10) unsigned NOT NULL default '0',
  news_class varchar(255) NOT NULL default '0',
  news_render_type tinyint(3) unsigned NOT NULL default '0',
  news_comment_total int(10) unsigned NOT NULL default '0',
  news_summary text NOT NULL,
  news_thumbnail text NOT NULL,
  news_sticky tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (news_id)
) ENGINE=MyISAM;





# --------------------------------------------------------

#
# Table structure for table `news_category`
#

CREATE TABLE news_category (
  category_id int(10) unsigned NOT NULL auto_increment,
  category_name varchar(200) NOT NULL default '',
  category_icon varchar(250) NOT NULL default '',
  PRIMARY KEY  (category_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `online`
#

CREATE TABLE online (
  online_timestamp int(10) unsigned NOT NULL default '0',
  online_flag tinyint(3) unsigned NOT NULL default '0',
  online_user_id varchar(100) NOT NULL default '',
  online_ip varchar(15) NOT NULL default '',
  online_location varchar(100) NOT NULL default '',
  online_pagecount tinyint(3) unsigned NOT NULL default '0',
  online_active int(10) unsigned NOT NULL default '0',
  KEY online_ip (online_ip)
) ENGINE=InnoDB;
# --------------------------------------------------------

#
# Table structure for table `page`
#

CREATE TABLE page (
  page_id int(10) unsigned NOT NULL auto_increment,
  page_title varchar(250) NOT NULL default '',
  page_text mediumtext NOT NULL,
  page_author int(10) unsigned NOT NULL default '0',
  page_datestamp int(10) unsigned NOT NULL default '0',
  page_rating_flag tinyint(1) unsigned NOT NULL default '0',
  page_comment_flag tinyint(1) unsigned NOT NULL default '0',
  page_password varchar(50) NOT NULL default '',
  page_class varchar(250) NOT NULL default '',
  page_ip_restrict text NOT NULL,
  page_theme varchar(50) NOT NULL default '',
  PRIMARY KEY  (page_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `plugin`
#

CREATE TABLE plugin (
  plugin_id int(10) unsigned NOT NULL auto_increment,
  plugin_name varchar(100) NOT NULL default '',
  plugin_version varchar(10) NOT NULL default '',
  plugin_path varchar(100) NOT NULL default '',
  plugin_installflag tinyint(1) unsigned NOT NULL default '0',
  plugin_addons text NOT NULL,
  PRIMARY KEY  (plugin_id),
  UNIQUE KEY plugin_path (plugin_path)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `rate`
#

CREATE TABLE preset (
  preset_id int(10) unsigned NOT NULL auto_increment,
  preset_name varchar(80) NOT NULL default '',
  preset_field varchar(80) NOT NULL default '',
  preset_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (preset_id)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `rate`
#

CREATE TABLE rate (
  rate_id int(10) unsigned NOT NULL auto_increment,
  rate_table varchar(100) NOT NULL default '',
  rate_itemid int(10) unsigned NOT NULL default '0',
  rate_rating int(10) unsigned NOT NULL default '0',
  rate_votes int(10) unsigned NOT NULL default '0',
  rate_voters text NOT NULL,
  PRIMARY KEY  (rate_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `rbinary`
#

CREATE TABLE rbinary (
  binary_id int(10) unsigned NOT NULL auto_increment,
  binary_name varchar(200) NOT NULL default '',
  binary_filetype varchar(100) NOT NULL default '',
  binary_data longblob NOT NULL,
  PRIMARY KEY  (binary_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `session`
#

CREATE TABLE session (
  session_id varchar(32) NOT NULL default '',
  session_expire int(10) unsigned NOT NULL default '0',
  session_datestamp int(10) unsigned NOT NULL default '0',
  session_ip varchar(200) NOT NULL default '',
  session_data text NOT NULL
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `submitnews`
#

CREATE TABLE submitnews (
  submitnews_id int(10) unsigned NOT NULL auto_increment,
  submitnews_name varchar(100) NOT NULL default '',
  submitnews_email varchar(100) NOT NULL default '',
  submitnews_title varchar(200) NOT NULL default '',
  submitnews_category tinyint(3) unsigned NOT NULL default '0',
  submitnews_item text NOT NULL,
  submitnews_datestamp int(10) unsigned NOT NULL default '0',
  submitnews_ip varchar(15) NOT NULL default '',
  submitnews_auth tinyint(3) unsigned NOT NULL default '0',
  submitnews_file varchar(100) NOT NULL default '',
  PRIMARY KEY  (submitnews_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tmp`
#

CREATE TABLE tmp (
  tmp_ip varchar(20) NOT NULL default '',
  tmp_time int(10) unsigned NOT NULL default '0',
  tmp_info text NOT NULL,
  KEY tmp_ip (tmp_ip)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `upload`
#

CREATE TABLE upload (
  upload_id int(10) unsigned NOT NULL auto_increment,
  upload_poster varchar(100) NOT NULL default '',
  upload_email varchar(100) NOT NULL default '',
  upload_website varchar(100) NOT NULL default '',
  upload_datestamp int(10) unsigned NOT NULL default '0',
  upload_name varchar(100) NOT NULL default '',
  upload_version varchar(10) NOT NULL default '',
  upload_file varchar(100) NOT NULL default '',
  upload_ss varchar(100) NOT NULL default '',
  upload_description text NOT NULL,
  upload_demo varchar(100) NOT NULL default '',
  upload_filesize int(10) unsigned NOT NULL default '0',
  upload_active tinyint(3) unsigned NOT NULL default '0',
  upload_category tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (upload_id),
  KEY upload_active (upload_active)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `user`
#

CREATE TABLE user (
  user_id int(10) unsigned NOT NULL auto_increment,
  user_name varchar(100) NOT NULL default '',
  user_loginname varchar(100) NOT NULL default '',
  user_customtitle varchar(100) NOT NULL default '',
  user_password varchar(32) NOT NULL default '',
  user_sess varchar(100) NOT NULL default '',
  user_email varchar(100) NOT NULL default '',
  user_signature text NOT NULL,
  user_image varchar(100) NOT NULL default '',
  user_timezone varchar(3) NOT NULL default '',
  user_hideemail tinyint(3) unsigned NOT NULL default '0',
  user_join int(10) unsigned NOT NULL default '0',
  user_lastvisit int(10) unsigned NOT NULL default '0',
  user_currentvisit int(10) unsigned NOT NULL default '0',
  user_lastpost int(10) unsigned NOT NULL default '0',
  user_chats int(10) unsigned NOT NULL default '0',
  user_comments int(10) unsigned NOT NULL default '0',
  user_forums int(10) unsigned NOT NULL default '0',
  user_ip varchar(20) NOT NULL default '',
  user_ban tinyint(3) unsigned NOT NULL default '0',
  user_prefs text NOT NULL,
  user_new text NOT NULL,
  user_viewed text NOT NULL,
  user_visits int(10) unsigned NOT NULL default '0',
  user_admin tinyint(3) unsigned NOT NULL default '0',
  user_login varchar(100) NOT NULL default '',
  user_class text NOT NULL,
  user_perms text NOT NULL,
  user_realm text NOT NULL,
  user_pwchange int(10) unsigned NOT NULL default '0',
  user_xup varchar(100) NOT NULL default '',
  PRIMARY KEY  (user_id),
  UNIQUE KEY user_name (user_name),
  UNIQUE KEY user_loginname (user_loginname),
  KEY user_ban_index (user_ban)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `userclass_classes`
#
CREATE TABLE userclass_classes (
  userclass_id tinyint(3) unsigned NOT NULL default '0',
  userclass_name varchar(100) NOT NULL default '',
  userclass_description varchar(250) NOT NULL default '',
  userclass_editclass tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (userclass_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `e107_user_extended`
#

CREATE TABLE user_extended (
  user_extended_id int(10) unsigned NOT NULL default '0',
  user_hidden_fields text NOT NULL,
  PRIMARY KEY  (user_extended_id)
) ENGINE=MyISAM;
# --------------------------------------------------------


#
# Table structure for table `e107_user_extended_struct`
#

CREATE TABLE user_extended_struct (
  user_extended_struct_id int(10) unsigned NOT NULL auto_increment,
  user_extended_struct_name varchar(255) NOT NULL default '',
  user_extended_struct_text varchar(255) NOT NULL default '',
  user_extended_struct_type tinyint(3) unsigned NOT NULL default '0',
  user_extended_struct_parms varchar(255) NOT NULL default '',
  user_extended_struct_values text NOT NULL,
  user_extended_struct_default varchar(255) NOT NULL default '',
  user_extended_struct_read tinyint(3) unsigned NOT NULL default '0',
  user_extended_struct_write tinyint(3) unsigned NOT NULL default '0',
  user_extended_struct_required tinyint(3) unsigned NOT NULL default '0',
  user_extended_struct_signup tinyint(3) unsigned NOT NULL default '0',
  user_extended_struct_applicable tinyint(3) unsigned NOT NULL default '0',
  user_extended_struct_order int(10) unsigned NOT NULL default '0',
  user_extended_struct_parent int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (user_extended_struct_id)
) ENGINE=MyISAM;
# --------------------------------------------------------


#
# Table structure for table `generic`
#
CREATE TABLE generic (
  gen_id int(10) unsigned NOT NULL auto_increment,
  gen_type varchar(80) NOT NULL default '',
  gen_datestamp int(10) unsigned NOT NULL default '0',
  gen_user_id int(10) unsigned NOT NULL default '0',
  gen_ip varchar(80) NOT NULL default '',
  gen_intdata int(10) unsigned NOT NULL default '0',
  gen_chardata text NOT NULL,
  PRIMARY KEY  (gen_id),
  KEY gen_type (gen_type)
) ENGINE=MyISAM;
# --------------------------------------------------------
