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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/ad_links.php $
|     $Revision: 12903 $
|     $Id: ad_links.php 12903 2012-07-23 07:37:12Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

if (file_exists(THEME.'admin_images/admin_images.php')) {
	e107_require_once(THEME.'admin_images/admin_images.php');
}

// Small Category Images
if (!defined('E_16_CAT_SETT')) {
	define('E_16_CAT_SETT', e_IMAGE.'admin_images/cat_settings_16.png');
}
if (!defined('E_16_CAT_USER')) {
	define('E_16_CAT_USER', e_IMAGE.'admin_images/cat_users_16.png');
}
if (!defined('E_16_CAT_CONT')) {
	define('E_16_CAT_CONT', e_IMAGE.'admin_images/cat_content_16.png');
}
if (!defined('E_16_CAT_FILE')) {
	define('E_16_CAT_FILE', e_IMAGE.'admin_images/cat_files_16.png');
}
if (!defined('E_16_CAT_TOOL')) {
	define('E_16_CAT_TOOL', e_IMAGE.'admin_images/cat_tools_16.png');
}
if (!defined('E_16_CAT_PLUG')) {
	define('E_16_CAT_PLUG', e_IMAGE.'admin_images/cat_plugins_16.png');
}

// Large Category Images
if (!defined('E_32_CAT_SETT')) {
	define('E_32_CAT_SETT', "<img src='".e_IMAGE."admin_images/cat_settings_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CAT_USER')) {
	define('E_32_CAT_USER', "<img src='".e_IMAGE."admin_images/cat_users_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CAT_CONT')) {
	define('E_32_CAT_CONT', "<img src='".e_IMAGE."admin_images/cat_content_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CAT_FILE')) {
	define('E_32_CAT_FILE', "<img src='".e_IMAGE."admin_images/cat_files_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CAT_TOOL')) {
	define('E_32_CAT_TOOL', "<img src='".e_IMAGE."admin_images/cat_tools_32.png' alt='' style='border:0px; width:32px; height:32px' />");
}
if (!defined('E_32_CAT_PLUG')) {
	define('E_32_CAT_PLUG', "<img src='".e_IMAGE."admin_images/cat_plugins_32.png' alt='' style='border:0px; width:32px; height:32px' />");
}

// Small Nav Images
if (!defined('E_16_NAV_MAIN')) {
	define('E_16_NAV_MAIN', e_IMAGE.'admin_images/main_16.png');
}
if (!defined('E_16_NAV_DOCS')) {
	define('E_16_NAV_DOCS', e_IMAGE.'admin_images/docs_16.png');
}
if (!defined('E_16_NAV_LEAV')) {
	define('E_16_NAV_LEAV', e_IMAGE.'admin_images/leave_16.png');
}
if (!defined('E_16_NAV_LGOT')) {
	define('E_16_NAV_LGOT', e_IMAGE.'admin_images/logout_16.png');
}
if (!defined('E_16_NAV_ARROW')) {
	define('E_16_NAV_ARROW', e_IMAGE.'admin_images/arrow_16.png');
}
if (!defined('E_16_NAV_ARROW_OVER')) {
	define('E_16_NAV_ARROW_OVER', e_IMAGE.'admin_images/arrow_over_16.png');
}

// Large Nav Images
if (!defined('E_32_NAV_MAIN')) {
	define('E_32_NAV_MAIN', "<img src='".e_IMAGE."'admin_images/main_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NAV_DOCS')) {
	define('E_32_NAV_DOCS', "<img src='".e_IMAGE."'admin_images/docs_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NAV_LEAV')) {
	define('E_32_NAV_LEAV', "<img src='".e_IMAGE."'admin_images/leave_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NAV_LGOT')) {
	define('E_32_NAV_LGOT', "<img src='".e_IMAGE."'admin_images/logout_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NAV_ARROW')) {
	define('E_32_NAV_ARROW', "<img src='".e_IMAGE."'admin_images/arrow_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NAV_ARROW_OVER')) {
	define('E_32_NAV_ARROW_OVER', "<img src='".e_IMAGE."'admin_images/arrow_over_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}

// Small Admin Main Link Images
if (!defined('E_16_ADMIN')) {
	define('E_16_ADMIN', "<img src='".e_IMAGE."admin_images/admins_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_ADPASS')) {
	define('E_16_ADPASS', "<img src='".e_IMAGE."admin_images/adminpass_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_BANLIST')) {
	define('E_16_BANLIST', "<img src='".e_IMAGE."admin_images/banlist_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_BANNER')) {
	define('E_16_BANNER', "<img src='".e_IMAGE."admin_images/banners_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_CACHE')) {
	define('E_16_CACHE', "<img src='".e_IMAGE."admin_images/cache_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_CREDITS')) {
	define('E_16_CREDITS', "<img src='".e_IMAGE."admin_images/credits_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_CUST')) {
	define('E_16_CUST', "<img src='".e_IMAGE."admin_images/custom_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_DATAB')) {
	define('E_16_DATAB', "<img src='".e_IMAGE."admin_images/database_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_DOWNL')) {
	define('E_16_DOWNL', "<img src='".e_IMAGE."admin_images/downloads_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_EMOTE')) {
	define('E_16_EMOTE', "<img src='".e_IMAGE."admin_images/emoticons_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_FILE')) {
	define('E_16_FILE', "<img src='".e_IMAGE."admin_images/filemanager_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_FORUM')) {
	define('E_16_FORUM', "<img src='".e_IMAGE."admin_images/forums_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_FRONT')) {
	define('E_16_FRONT', "<img src='".e_IMAGE."admin_images/frontpage_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_IMAGES')) {
	define('E_16_IMAGES', "<img src='".e_IMAGE."admin_images/images_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_INSPECT')) {
	define('E_16_INSPECT', "<img src='".e_IMAGE."admin_images/fileinspector_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_LINKS')) {
	define('E_16_LINKS', "<img src='".e_IMAGE."admin_images/links_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_WELCOME')) {
	define('E_16_WELCOME', "<img src='".e_IMAGE."admin_images/welcome_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_MAIL')) {
	define('E_16_MAIL', "<img src='".e_IMAGE."admin_images/mail_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_MAINTAIN')) {
	define('E_16_MAINTAIN', "<img src='".e_IMAGE."admin_images/maintain_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_MENUS')) {
	define('E_16_MENUS', "<img src='".e_IMAGE."admin_images/menus_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_META')) {
	define('E_16_META', "<img src='".e_IMAGE."admin_images/meta_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_NEWS')) {
	define('E_16_NEWS', "<img src='".e_IMAGE."admin_images/news_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_NEWSFEED')) {
	define('E_16_NEWSFEED', "<img src='".e_IMAGE."admin_images/newsfeeds_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_NOTIFY')) {
	define('E_16_NOTIFY', "<img src='".e_IMAGE."admin_images/notify_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_PHP')) {
	define('E_16_PHP', "<img src='".e_IMAGE."admin_images/phpinfo_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_POLLS')) {
	define('E_16_POLLS', "<img src='".e_IMAGE."admin_images/polls_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_PREFS')) {
	define('E_16_PREFS', "<img src='".e_IMAGE."admin_images/prefs_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_SEARCH')) {
	define('E_16_SEARCH', "<img src='".e_IMAGE."admin_images/search_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_UPLOADS')) {
	define('E_16_UPLOADS', "<img src='".e_IMAGE."admin_images/uploads_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_USER')) {
	define('E_16_USER', "<img src='".e_IMAGE."admin_images/users_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_USER_EXTENDED')) {
	define('E_16_USER_EXTENDED', "<img src='".e_IMAGE."admin_images/extended_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_USERCLASS')) {
	define('E_16_USERCLASS', "<img src='".e_IMAGE."admin_images/userclass_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_LANGUAGE')) {
	define('E_16_LANGUAGE', "<img src='".e_IMAGE."admin_images/language_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}

// Small Admin Other Link Images
if (!defined('E_16_PLUGIN')) {
	define('E_16_PLUGIN', "<img src='".e_IMAGE."admin_images/plugins_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_PLUGMANAGER')) {
	define('E_16_PLUGMANAGER', "<img src='".e_IMAGE."admin_images/plugmanager_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_DOCS')) {
	define('E_16_DOCS', "<img src='".e_IMAGE."admin_images/docs_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_THEMEMANAGER')) {
	define('E_16_THEMEMANAGER', "<img src='".e_IMAGE."admin_images/themes_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}

// Small Admin Other Images
if (!defined('E_16_COMMENT')) {
	define('E_16_COMMENT', "<img src='".e_IMAGE."admin_images/comments_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}
if (!defined('E_16_ADMINLOG')) {
	define('E_16_ADMINLOG', "<img src='".e_IMAGE."admin_images/adminlogs_16.png' alt='' style='border:0px; vertical-align:bottom; width: 16px; height: 16px' />");
}

// Large Admin Main Link Images
if (!defined('E_32_ADMIN')) {
	define('E_32_ADMIN', "<img src='".e_IMAGE."admin_images/admins_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_ADPASS')) {
	define('E_32_ADPASS', "<img src='".e_IMAGE."admin_images/adminpass_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_BANLIST')) {
	define('E_32_BANLIST', "<img src='".e_IMAGE."admin_images/banlist_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_BANNER')) {
	define('E_32_BANNER', "<img src='".e_IMAGE."admin_images/banners_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CACHE')) {
	define('E_32_CACHE', "<img src='".e_IMAGE."admin_images/cache_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CREDITS')) {
	define('E_32_CREDITS', "<img src='".e_IMAGE."admin_images/credits_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_CUST')) {
	define('E_32_CUST', "<img src='".e_IMAGE."admin_images/custom_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_DATAB')) {
	define('E_32_DATAB', "<img src='".e_IMAGE."admin_images/database_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_DOWNL')) {
	define('E_32_DOWNL', "<img src='".e_IMAGE."admin_images/downloads_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_EMOTE')) {
	define('E_32_EMOTE', "<img src='".e_IMAGE."admin_images/emoticons_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_FILE')) {
	define('E_32_FILE', "<img src='".e_IMAGE."admin_images/filemanager_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_FORUM')) {
	define('E_32_FORUM', "<img src='".e_IMAGE."admin_images/forums_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_FRONT')) {
	define('E_32_FRONT', "<img src='".e_IMAGE."admin_images/frontpage_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_IMAGES')) {
	define('E_32_IMAGES', "<img src='".e_IMAGE."admin_images/images_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_INSPECT')) {
	define('E_32_INSPECT', "<img src='".e_IMAGE."admin_images/fileinspector_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_LINKS')) {
	define('E_32_LINKS', "<img src='".e_IMAGE."admin_images/links_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_WELCOME')) {
	define('E_32_WELCOME', "<img src='".e_IMAGE."admin_images/welcome_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_MAIL')) {
	define('E_32_MAIL', "<img src='".e_IMAGE."admin_images/mail_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_MAINTAIN')) {
	define('E_32_MAINTAIN', "<img src='".e_IMAGE."admin_images/maintain_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_MENUS')) {
	define('E_32_MENUS', "<img src='".e_IMAGE."admin_images/menus_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_META')) {
	define('E_32_META', "<img src='".e_IMAGE."admin_images/meta_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NEWS')) {
	define('E_32_NEWS', "<img src='".e_IMAGE."admin_images/news_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NEWSFEED')) {
	define('E_32_NEWSFEED', "<img src='".e_IMAGE."admin_images/newsfeeds_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_NOTIFY')) {
	define('E_32_NOTIFY', "<img src='".e_IMAGE."admin_images/notify_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_PHP')) {
	define('E_32_PHP', "<img src='".e_IMAGE."admin_images/phpinfo_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_POLLS')) {
	define('E_32_POLLS', "<img src='".e_IMAGE."admin_images/polls_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_PREFS')) {
	define('E_32_PREFS', "<img src='".e_IMAGE."admin_images/prefs_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_SEARCH')) {
	define('E_32_SEARCH', "<img src='".e_IMAGE."admin_images/search_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_UPLOADS')) {
	define('E_32_UPLOADS', "<img src='".e_IMAGE."admin_images/uploads_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_USER')) {
	define('E_32_USER', "<img src='".e_IMAGE."admin_images/users_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_USER_EXTENDED')) {
	define('E_32_USER_EXTENDED', "<img src='".e_IMAGE."admin_images/extended_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_USERCLASS')) {
	define('E_32_USERCLASS', "<img src='".e_IMAGE."admin_images/userclass_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_LANGUAGE')) {
	define('E_32_LANGUAGE', "<img src='".e_IMAGE."admin_images/language_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}

// Large Admin Other Link Images
if (!defined('E_32_PLUGIN')) {
	define('E_32_PLUGIN', "<img src='".e_IMAGE."admin_images/plugins_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_PLUGMANAGER')) {
	define('E_32_PLUGMANAGER', "<img src='".e_IMAGE."admin_images/plugmanager_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_DOCS')) {
	define('E_32_DOCS', "<img src='".e_IMAGE."admin_images/docs_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_MAIN')) {
	define('E_32_MAIN', "<img src='".e_IMAGE."admin_images/main_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}

if (!defined('E_32_THEMEMANAGER')) {
	define('E_32_THEMEMANAGER', "<img src='".e_IMAGE."admin_images/themes_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}

// Large Admin Other Images
if (!defined('E_32_COMMENT')) {
	define('E_32_COMMENT', "<img src='".e_IMAGE."admin_images/comments_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_ADMINLOG')) {
	define('E_32_ADMINLOG', "<img src='".e_IMAGE."admin_images/adminlogs_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}
if (!defined('E_32_LOGOUT')) {
	define('E_32_LOGOUT', "<img src='".e_IMAGE."admin_images/logout_32.png' alt='' style='border:0px; width: 32px; height: 32px' />");
}

$e_icon_array = array(
	'main' => E_32_MAIN,
	'admin' => E_32_ADMIN,
	'admin_pass' => E_32_ADPASS,
	'banlist' => E_32_BANLIST,
	'banner' => E_32_BANNER,
	'cache' => E_32_CACHE,
	'comments' => E_32_COMMENT,
	'credits' => E_32_CREDITS,
	'custom' => E_32_CUST,
	'database' => E_32_DATAB,
	'docs' => E_32_DOCS,
	'download' => E_32_DOWNL,
	'emoticon' => E_32_EMOTE,
	'filemanage' => E_32_FILE,
	'fileinspector' => E_32_INSPECT,
	'frontpage' => E_32_FRONT,
	'image' => E_32_IMAGES,
	'language' => E_32_LANGUAGE,
	'links' => E_32_LINKS,
	'mail' => E_32_MAIL,
	'maintain' => E_32_MAINTAIN,
	'menus' => E_32_MENUS,
	'meta' => E_32_META,
	'newsfeed' => E_32_NEWSFEED,
	'news' => E_32_NEWS,
	'notify' => E_32_NOTIFY,
	'phpinfo' => E_32_PHP,
	'plug_manage' => E_32_PLUGMANAGER,
	'poll' => E_32_POLLS,
	'prefs' => E_32_PREFS,
	'search' => E_32_SEARCH,
	'theme_manage' => E_32_THEMEMANAGER,
	'maintain' => E_32_MAINTAIN,
	'upload' => E_32_UPLOADS,
	'userclass' => E_32_USERCLASS,
	'user_extended' => E_32_USER_EXTENDED,
	'users' => E_32_USER,
	'wmessage' => E_32_WELCOME );

$admin_cat['title'][1] = ADLAN_CL_1;
$admin_cat['id'][1] = 'setMenu';
$admin_cat['img'][1] = E_16_CAT_SETT;
$admin_cat['lrg_img'][1] = E_32_CAT_SETT;

$admin_cat['title'][2] = ADLAN_CL_2;
$admin_cat['id'][2] = 'userMenu';
$admin_cat['img'][2] = E_16_CAT_USER;
$admin_cat['lrg_img'][2] = E_32_CAT_USER;

$admin_cat['title'][3] = ADLAN_CL_3;
$admin_cat['id'][3] = 'contMenu';
$admin_cat['img'][3] = E_16_CAT_CONT;
$admin_cat['lrg_img'][3] = E_32_CAT_CONT;

$admin_cat['title'][4] = ADLAN_CL_6;
$admin_cat['id'][4] = 'toolMenu';
$admin_cat['img'][4] = E_16_CAT_TOOL;
$admin_cat['lrg_img'][4] = E_32_CAT_TOOL;

$admin_cat['title'][5] = ADLAN_CL_7;
$admin_cat['id'][5] = 'plugMenu';
$admin_cat['img'][5] = E_16_CAT_PLUG;
$admin_cat['lrg_img'][5] = E_32_CAT_PLUG;

// Info about attributes
/*
attribute 1 = link
attribute 2 = title
attribute 3 = description
attribute 4 = perms
attribute 5 = category
attribute 6 = 16 x 16 image
attribute 7 = 32 x 32 image
*/

$array_functions = array(
	0 => array(e_ADMIN."administrator.php", ADLAN_8, ADLAN_9, "3", 2, E_16_ADMIN, E_32_ADMIN),
	1 => array(e_ADMIN."updateadmin.php", ADLAN_10, ADLAN_11, "", 2, E_16_ADPASS, E_32_ADPASS),
	2 => array(e_ADMIN."banlist.php", ADLAN_34, ADLAN_35, "4", 2, E_16_BANLIST, E_32_BANLIST),
	3 => array(e_ADMIN."banner.php", ADLAN_54, ADLAN_55, "D", 3, E_16_BANNER, E_32_BANNER),
	4 => array(e_ADMIN."cache.php", ADLAN_74, ADLAN_75, "C", 1, E_16_CACHE, E_32_CACHE),
	5 => array(e_ADMIN."cpage.php", ADLAN_42, ADLAN_43, "5", 3, E_16_CUST, E_32_CUST),
	6 => array(e_ADMIN."db.php", ADLAN_44, ADLAN_45, "0", 4, E_16_DATAB, E_32_DATAB),
	7 => array(e_ADMIN."download.php", ADLAN_24, ADLAN_25, "R", 3, E_16_DOWNL, E_32_DOWNL),
	8 => array(e_ADMIN."emoticon.php", ADLAN_58, ADLAN_59, "F", 1, E_16_EMOTE, E_32_EMOTE),
	9 => array(e_ADMIN."filemanager.php", ADLAN_30, ADLAN_31, "6", 4, E_16_FILE, E_32_FILE),
	10 => array(e_ADMIN."frontpage.php", ADLAN_60, ADLAN_61, "G", 1, E_16_FRONT, E_32_FRONT),
	11 => array(e_ADMIN."image.php", ADLAN_105, ADLAN_106, "A", 1, E_16_IMAGES, E_32_IMAGES),
	12 => array(e_ADMIN."links.php", ADLAN_138, ADLAN_139, "I", 1, E_16_LINKS, E_32_LINKS),
	13 => array(e_ADMIN."wmessage.php", ADLAN_28, ADLAN_29, "M", 3, E_16_WELCOME, E_32_WELCOME),
	14 => array(e_ADMIN."ugflag.php", ADLAN_40, ADLAN_41, "9", 4, E_16_MAINTAIN, E_32_MAINTAIN),
	15 => array(e_ADMIN."menus.php", ADLAN_6, ADLAN_7, "2", 3, E_16_MENUS, E_32_MENUS),
	16 => array(e_ADMIN."meta.php", ADLAN_66, ADLAN_67, "T", 1, E_16_META, E_32_META),
	17 => array(e_ADMIN."newspost.php", ADLAN_0, ADLAN_1, "H", 3, E_16_NEWS, E_32_NEWS),
	18 => array(e_ADMIN."phpinfo.php", ADLAN_68, ADLAN_69, "0", 4, E_16_PHP, E_32_PHP),
	19 => array(e_ADMIN."prefs.php", ADLAN_4, ADLAN_5, "1", 1, E_16_PREFS, E_32_PREFS),
	20 => array(e_ADMIN."search.php", ADLAN_142, ADLAN_143, "X", 1, E_16_SEARCH, E_32_SEARCH),
	21 => array(e_ADMIN."theme.php", ADLAN_140, ADLAN_141, "1", 4, E_16_THEMEMANAGER, E_32_THEMEMANAGER),
	22 => array(e_ADMIN."upload.php", ADLAN_72, ADLAN_73, "V", 3, E_16_UPLOADS, E_32_UPLOADS),
	23 => array(e_ADMIN."users.php", ADLAN_36, ADLAN_37, "4", 2, E_16_USER, E_32_USER),
	24 => array(e_ADMIN."userclass2.php", ADLAN_38, ADLAN_39, "4", 2, E_16_USERCLASS, E_32_USERCLASS),
	25 => array(e_ADMIN."language.php", ADLAN_132, ADLAN_133, "L", 1, E_16_LANGUAGE, E_32_LANGUAGE),
	26 => array(e_ADMIN."mailout.php", ADLAN_136, ADLAN_137, "W", 2, E_16_MAIL, E_32_MAIL),
	27 => array(e_ADMIN."users_extended.php", ADLAN_78, ADLAN_79, "4", 2, E_16_USER_EXTENDED, E_32_USER_EXTENDED),
	28 => array(e_ADMIN."fileinspector.php", ADLAN_147, ADLAN_148, "Y", 4, E_16_INSPECT, E_32_INSPECT),
	29 => array(e_ADMIN."notify.php", ADLAN_149, ADLAN_150, "O", 4, E_16_NOTIFY, E_32_NOTIFY),
	30 => array(e_ADMIN."modcomment.php", ADLAN_114, ADLAN_114, "B", 4, E_16_COMMENT, E_32_COMMENT)
	);
?>
