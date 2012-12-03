<?php
/*
+ ------------------------------------------------------------------------------+
|	© е107 Inc. 2010-2011. All Rights Reserved.									|
|	© е107 Club 2010-2012. All Rights Reserved.									|
|	Site: http://www.e107club.ru												|
|	Email: no-reply@e107club.ru													|
|	File: Prefs																	|
|	Version: 3.0																|
|	Date: 08.03.2012 05:05:05													|
|	Author: © Alexander Kadnikov [Predator]										|
+-------------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$pref = array (
  'install_date' => time(),
  'sitename' => LAN_PREF_1,
  'siteurl' => $e_HTTP,
  'sitebutton' => 'e107club.png',
  'sitetag' => LAN_PREF_2,
  'sitedescription' => '',
  'siteadmin' => $site_admin_user,
  'siteadminemail' => $site_admin_email,
  'sitecontactinfo' => '[b]е107 Клуб - Официальный портал русскоязычного сообщества системы е107cms[/b]
[b]Сайт:[/b] [url=http://www.e107club.ru]www.e107club.ru[/url]
[b]Почта:[/b] no-reply@e107club.ru
Сборка настоящей версии системы и русская локализация подготовлены командой портала е107 Клуб

© е107 Клуб, '.date("Y").'. Все права защищены.',
  'sitetheme' => 'core',
  'themecss' => 'style.css',
  'image_preload' => '0',
  'admintheme' => 'core',
  'admincss' => 'style.css',
  'adminstyle' => 'categories',
  'sitedisclaimer' => LAN_PREF_3,
  'newsposts' => '5',

  'flood_protect' => '1',
  'flood_timeout' => '5',
  'flood_time' => '30',
  'flood_hits' => '100',
  'anon_post' => '0',

  'user_reg' => '1',
  'membersonly_enabled' => '0',

  'use_coppa' => '0',
  'signcode' => '1',
  'user_reg_veri' => '1',
  'user_reg_secureveri' => '1',
  'signup_pass_len' => '5',
  'signup_maxip' => '3',
  'signup_disallow_text' => '',
  'disable_emailcheck' => 0,
  'signup_text' => '',
  'signup_text_after' => '',
  'signup_option_realname' => '1',
  'signup_option_signature' => '1',
  'signup_option_image' => '1',
  'signup_option_timezone' => '1',
  'signup_option_class' => '1',
  'signup_remote_emailcheck' => 0,

  'displayname_class' => 255,
  'displayname_maxlength' => 30,
  'loginname_maxlength' => 37,
  
  'profanity_filter' => '0',
  'profanity_replace' => '[Цензура]',
  'smiley_activate' => '1',
  'log_refertype' => '1',
  'longdate' => '%A %d %B %Y - %H:%M:%S',
  'shortdate' => '%d %b : %H:%M',
  'forumdate' => '%a %b %d %Y, %I:%M%p',
  'sitelanguage' => $pref_language,
  'maintainance_flag' => '0',
  'time_offset' => '0',
  'meta_tag' => '',
  'email_notify' => '0',
  'resize_method' => 'gd2',
  'image_post' => '1',
  'image_post_class' => '0',
  'im_path' => '',
  'im_quality' => '80',
  'im_width' => '100',
  'im_height' => '100',
  'upload_enabled' => '0',
  'upload_storagetype' => '1',
  'upload_maxfilesize' => '',
  'upload_class' => '255',
  'cachestatus' => '0',
  'displayrendertime' => '0',
  'displaysql' => '0',
  'displaythemeinfo' => '0',
  'timezone' => 'GMT',
  'search_restrict' => '0',
  'antiflood1' => '1',
  'antiflood_timeout' => '10',
  'autoban' => '0',
  'sitelang_init' => $pref_language,
  'linkpage_screentip' => '0',
  'plug_status' => 'rss_menu',
  'plug_latest' => '',
  'wmessage_sc' => '0',
  'frontpage' =>
  array (
    'all' => 'news.php',
  ),
  'admin_alerts_ok' => '1',
  'link_replace' => '0',
  'link_text' => '',
  'logcode' => '0',
  'newsposts_archive' => '0',
  'newsposts_archive_title' => '',
  'news_cats' => '',
  'nbr_cols' => '1',
  'subnews_attach' => '',
  'subnews_resize' => '',
  'subnews_class' => '0',
  'subnews_htmlarea' => '0',
  'subnews_hide_news' => '',
  'news_newdateheader' => '0',
  'email_text' => '',
  'useGeshi' => '1',
  'wysiwyg' => '0',
  'old_np' => '0',
  'make_clickable' => '0',
  'track_online' => '1',
  'emotepack' => '',
  'xup_enabled' => '0',
  'mailer' => 'php',
  'ue_upgrade' => '1',
  'search_highlight' => '1',
  'mail_pause' => '3',
  'mail_pausetime' => '4',
  'themecss' => 'style.css',
  'plug_sc' => ':featurebox',
  'auth_method' => '',
  'post_html' => '250',
  'post_script' => '250',
  'filter_script' => '1',
  'html_abuse' => '1',
  'redirectsiteurl' => '0',
  'admin_alerts_uniquemenu' => '0',
  'null' => '',
  'links_new_window' => '0',
  'main_wordwrap' => '30',
  'menu_wordwrap' => '30',
  'php_bbcode' => '255',
  'ssl_enabled' => '0',
  'fpwcode' => '0',
  'disallowMultiLogin' => '0',
  'profanity_words' => '',
  'adminpwordchange' => '0',
  'comments_icon' => '1',
  'nested_comments' => '1',
  'allowCommentEdit' => '0',
  'admincss' => 'style.css',
  'developer' => '0',
  'download_email' => '0',
  'comments_disabled' => '0',
  'memberlist_access' => '253',
  'check_updates' => '0',
  'user_tracking' => 'cookie',
  'cookie_name' => 'cookie',
  'email_item_class' => '253'
);

?>