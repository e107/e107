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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/calendar_menu/search/search_parser.php $
|     $Revision: 11678 $
|     $Id: search_parser.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }    

$return_fields = 'event_id, event_start, event_title, event_location, event_details';
$search_fields = array('event_title', 'event_location', 'event_details');
$weights = array('1.2', '0.6', '0.6');
$no_results = LAN_198;
$where = "";
$order = array('event_start' => DESC);

$ps = $sch -> parsesearch('event', $return_fields, $search_fields, $weights, 'search_events', $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_events($row) {
	global $con;
	$res['link'] = e_PLUGIN."calendar_menu/event.php?".time().".event.".$row['event_id'];
	$res['title'] = $row['event_title'];
	$res['summary'] = $row['event_details'];
	$res['detail'] = $row['event_location']." | ".$con -> convert_date($row['event_start'], "long");
	return $res;
}

?>