<?php
// $Id: fpw_template.php 12322 2011-07-22 12:32:50Z secretr $


if (!defined('e107_INIT')) { exit; }
if (!defined("USER_WIDTH")){ define("USER_WIDTH","width:70%"); }

// ##### FPW TABLE -----------------------------------------------------------------------------
if(!isset($FPW_TABLE))
{
		$FPW_TABLE = "
		<div style='text-align:center'>
		<form method='post' action='".SITEURL."fpw.php'>
		<table style='".USER_WIDTH."' class='fborder'>

		<tr>
		<td class='fcaption' colspan='2'>".LAN_05."</td>
		</tr>

		<tr>
		<td class='forumheader3' style='width:70%'>".LAN_FPW1.":</td>
		<td class='forumheader3' style='width:30%;text-align:center'>
		<input class='tbox' type='text' name='username' size='40' value='' maxlength='100' />
		</td>
		</tr>

		<tr>
		<td class='forumheader3' style='width:70%'>".LAN_112.":</td>
		<td class='forumheader3' style='width:30%; text-align:center'>
		<input class='tbox' type='text' name='email' size='40' value='' maxlength='100' />
		</td>
		</tr>";

		if(defsettrue('USE_IMAGECODE'))
		{
				$FPW_TABLE .= "
				<tr>
					<td class='forumheader3' style='width:25%'>{FPW_TABLE_SECIMG_LAN}</td>
					<td class='forumheader3' style='width:75%;text-align:left'>{FPW_TABLE_SECIMG_HIDDEN} {FPW_TABLE_SECIMG_SECIMG}<br />
					{FPW_TABLE_SECIMG_TEXTBOC}<br />
					</td>
				</tr>";
		}

		$FPW_TABLE .="
		<tr style='vertical-align:top'>
		<td class='forumheader' colspan='2' style='text-align:center'>
		<input class='button' type='submit' name='pwsubmit' value='".LAN_156."' />
		<input type='hidden' name='e-token' value=\"".e_TOKEN."\" />
		</td>
		</tr>
		</table>
		</form>
		</div>";
}
// ##### ------------------------------------------------------------------------------------------

// ##### FPW HEADER TABLE -------------------------------------------------------------------------
if(!isset($FPW_TABLE_HEADER))
{
		$FPW_TABLE_HEADER = "
		<div style='width:100%;text-align:center;margin-left:auto;margin-right:auto'>
			<div style='width:70%;margin-left:auto;margin-right:auto;text-align:center;'><br />
			{FPW_LOGIN_LOGO}
			<br />";
}
// ##### ------------------------------------------------------------------------------------------

// ##### FPW FOOTER TABLE -------------------------------------------------------------------------
if(!isset($FPW_TABLE_FOOTER))
{
  $FPW_TABLE_FOOTER = "</div></div>";
}
// ##### ------------------------------------------------------------------------------------------

?>