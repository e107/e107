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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_themes/lamb/download_template.php $
|     $Revision: 11678 $
|     $Id: download_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

// ##### CAT TABLE --------------------------------------------------------------------------------
$DOWNLOAD_CAT_TABLE_RENDERPLAIN = TRUE;

$DOWNLOAD_CAT_TABLE_START = "
<img src='".e_THEME."lamb/images/download.png' alt='' style='vertical-align: middle;' /> <span class='dlmain'>".LAN_dl_18."</span>\n
<br /><br />
";



$DOWNLOAD_CAT_PARENT_TABLE .= "
<h4>{DOWNLOAD_CAT_MAIN_ICON} {DOWNLOAD_CAT_MAIN_NAME}</h4>
";


$DOWNLOAD_CAT_CHILD_TABLE .= "
{DOWNLOAD_CAT_SUB_ICON}
{DOWNLOAD_CAT_SUB_NEW_ICON} {DOWNLOAD_CAT_SUB_NAME} 
<span class='smalltext'>
{DOWNLOAD_CAT_SUB_DESCRIPTION}
</span>
";

$DOWNLOAD_CAT_CHILD_TABLE .= "
<br /><span class='defaulttext'>
{DOWNLOAD_CAT_SUBSUB_NAME}
</span>
<span class='smalltext'>
{DOWNLOAD_CAT_SUBSUB_DESCRIPTION}
</span><br />
{DOWNLOAD_CAT_SUBSUB}
<br />
";

$DOWNLOAD_CAT_SUBSUB_TABLE .= "
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{DOWNLOAD_CAT_SUBSUB_NEW_ICON} {DOWNLOAD_CAT_SUBSUB_NAME}
";

$DOWNLOAD_CAT_TABLE_END = "
<br /><br /><br /><br />
{DOWNLOAD_CAT_SEARCH}
";

// ##### ------------------------------------------------------------------------------------------

// ##### LIST TABLE -------------------------------------------------------------------------------
$DOWNLOAD_LIST_TABLE_RENDERPLAIN = TRUE;
if(!$DOWNLOAD_LIST_TABLE_START){

                $DOWNLOAD_LIST_TABLE_START = "
<img src='".e_THEME."lamb/images/download.png' alt='' style='vertical-align: middle;' /> <span class='dlmain'>".LAN_dl_18.": {DOWNLOAD_CATEGORY}</span><br /><br />{DOWNLOAD_CATEGORY_DESCRIPTION}<br /><br />

<form method='post' action='".e_SELF."?".e_QUERY."'>
<p>
<span class='defaulttext'>".LAN_dl_38."
<select name='order' class='tbox'>".
($order == "download_datestamp" ? "<option value='download_datestamp' selected='selected'>".LAN_dl_22."</option>" : "<option value='download_datestamp'>".LAN_dl_22."</option>").
($order == "download_requested" ? "<option value='download_requested' selected='selected'>".LAN_dl_18."</option>" : "<option value='download_requested'>".LAN_dl_18."</option>").
($order == "download_name" ? "<option value='download_name' selected='selected'>".LAN_dl_23."</option>" : "<option value='download_name'>".LAN_dl_23."</option>").
($order == "download_author" ? "<option value='download_author' selected='selected'>".LAN_dl_24."</option>" : "<option value='download_author'>".LAN_dl_24."</option>")."
</select>&nbsp;&nbsp;&nbsp;

".LAN_dl_37."
<select name='view' class='tbox'>".
($view == 5 ? "<option selected='selected'>5</option>" : "<option>5</option>").
($view == 10 ? "<option selected='selected'>10</option>" : "<option>10</option>").
($view == 15 ? "<option selected='selected'>15</option>" : "<option>15</option>").
($view == 20 ? "<option selected='selected'>20</option>" : "<option>20</option>").
($view == 50 ? "<option selected='selected'>50</option>" : "<option>50</option>")."
</select>
&nbsp;
                        
&nbsp;
".LAN_dl_39."
<select name='sort' class='tbox'>".
($sort == "ASC" ? "<option value='ASC' selected='selected'>".LAN_dl_25."</option>" : "<option value='ASC'>".LAN_dl_25."</option>").
($sort == "DESC" ? "<option value='DESC' selected='selected'>".LAN_dl_26."</option>" : "<option value='DESC'>".LAN_dl_26."</option>")."
</select>
&nbsp;
<input class='button' type='submit' name='goorder' value='".LAN_dl_27."' />
</span>


<br /><br />
</p>
<table style='width:100%'>\n

<tr>
<td style='width:35%; text-align:left; font-weight: bold;'>".LAN_dl_28."</td>
<td style='width:20%; text-align:center; font-weight: bold;'>".LAN_dl_24."</td>
<td style='width:10%; text-align:center; font-weight: bold;'>".LAN_dl_21."</td>
<td style='width:5%; text-align:center; font-weight: bold;'>".LAN_dl_29."</td>
<td style='width:10%; text-align:center; font-weight: bold;'>".LAN_dl_12."</td>
<td style='width:5%; text-align:center; font-weight: bold;'>".LAN_dl_8."</td>
</tr>";

}

if(!$DOWNLOAD_LIST_TABLE){
                $DOWNLOAD_LIST_TABLE .= "
<tr>
<td style='text-align:left;'>{DOWNLOAD_LIST_NEWICON} {DOWNLOAD_LIST_NAME}</td>
<td style='text-align:center;'>{DOWNLOAD_LIST_AUTHOR}</td>
<td style='text-align:center;'>{DOWNLOAD_LIST_FILESIZE}</td>
<td style='text-align:center;'>{DOWNLOAD_LIST_REQUESTED}</td>
<td style='text-align:center;'>{DOWNLOAD_LIST_RATING}</td>
<td style='text-align:center;'>{DOWNLOAD_LIST_LINK} {DOWNLOAD_LIST_ICON}</td>
</tr>\n";
}

if(!$DOWNLOAD_LIST_TABLE_END){
                $DOWNLOAD_LIST_TABLE_END = "</table>\n</form><br /><br />
<div class='smalltext' style='text-align:right;'>{DOWNLOAD_LIST_TOTAL_AMOUNT} {DOWNLOAD_LIST_TOTAL_FILES}</div>\n";
}
// ##### ------------------------------------------------------------------------------------------


// ##### VIEW TABLE -------------------------------------------------------------------------------
$DOWNLOAD_VIEW_TABLE_RENDERPLAIN = TRUE;
if(!$DOWNLOAD_VIEW_TABLE_START){
                $DOWNLOAD_VIEW_TABLE_START = "

<img src='".e_THEME."lamb/images/download.png' alt='' style='vertical-align: middle;' /> <span class='dlmain'>".LAN_dl_18.": {DOWNLOAD_CATEGORY}</span><br /><br /><br />\n";
}

if(!$DOWNLOAD_VIEW_TABLE){
                $DOWNLOAD_VIEW_TABLE .= "
<div class='dlcat'>{DOWNLOAD_VIEW_NAME_LINKED}</div>
{DOWNLOAD_VIEW_AUTHOR_LAN}: {DOWNLOAD_VIEW_AUTHOR} ( {DOWNLOAD_VIEW_AUTHOREMAIL} ) ( {DOWNLOAD_VIEW_AUTHORWEBSITE} )<br /><br />
{DOWNLOAD_VIEW_DESCRIPTION}<br /><br />

 ";    
       

              
                $DOWNLOAD_VIEW_TABLE .= "
        <br /><span class='mediumtext'>{DOWNLOAD_VIEW_IMAGE}</span> <br /> | ";
           

        $DOWNLOAD_VIEW_TABLE .= "
                <span class='mediumtext'>{DOWNLOAD_VIEW_FILESIZE_LAN}: {DOWNLOAD_VIEW_FILESIZE} | {DOWNLOAD_VIEW_REQUESTED_LAN}: {DOWNLOAD_VIEW_REQUESTED} | {DOWNLOAD_REPORT_LINK} 
				<br />{DOWNLOAD_VIEW_RATING}</span><br /><br />
";
}

if(!$DOWNLOAD_VIEW_TABLE_END){
                $DOWNLOAD_VIEW_TABLE_END = "\n";
}
// ##### ------------------------------------------------------------------------------------------

if(!$DOWNLOAD_MIRROR_START)
{
	$DOWNLOAD_MIRROR_START = "
	<div style='text-align:center'>
	<table class='fborder' style='width:100%'>
	<tr>
	<td class='fcaption' colspan='4'>{DOWNLOAD_MIRROR_REQUEST}</td>
	</tr>
	<tr>
	<td class='forumheader' style='width: 30%; text-align: center;'>{DOWNLOAD_MIRROR_HOST_LAN}</td>
	<td class='forumheader' style='width: 40%;'>{DOWNLOAD_MIRROR_DESCRIPTION_LAN}</td>
	<td class='forumheader' style='width: 20%; text-align: center;'>{DOWNLOAD_MIRROR_LOCATION_LAN}</td>
	<td class='forumheader' style='width: 10%; text-align: center;'>{DOWNLOAD_MIRROR_GET_LAN}</td>
	</tr>
	";
}

if(!$DOWNLOAD_MIRROR)
{
	$DOWNLOAD_MIRROR = "
	<tr>
	<td class='forumheader3' style='width: 30%; text-align: center;'>{DOWNLOAD_MIRROR_IMAGE}<br /><br /><div class='smalltext'>{DOWNLOAD_MIRROR_REQUESTS}<br />{DOWNLOAD_TOTAL_MIRROR_REQUESTS}</div></td>
	<td class='forumheader3' style='width: 40%'><div class='smalltext'>{DOWNLOAD_MIRROR_DESCRIPTION}</div></td>
	<td class='forumheader3' style='width: 20%;; text-align: center;'>{DOWNLOAD_MIRROR_LOCATION}</td>
	<td class='forumheader3' style='width: 10%; text-align: center;'><div class='smalltext'>{DOWNLOAD_MIRROR_LINK} {DOWNLOAD_MIRROR_FILESIZE}</div></td>
	</tr>
	";
}

if(!$DOWNLOAD_MIRROR_END)
{
	$DOWNLOAD_MIRROR_END = "
	</table>
	</div>
	";
}

?>