<?php
/* $Id: e_search.php 11346 2010-02-17 18:56:14Z secretr $ */
if (!defined('e107_INIT')) { exit(); }

include_lan(e_PLUGIN."chatbox_menu/languages/".e_LANGUAGE."/lan_chatbox_search.php");

$search_info[] = array('sfile' => e_PLUGIN.'chatbox_menu/search/search_parser.php', 'qtype' => CB_SCH_LAN_1, 'refpage' => 'chat.php', 'advanced' => e_PLUGIN.'chatbox_menu/search/search_advanced.php');
?>