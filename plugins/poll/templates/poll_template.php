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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/poll/templates/poll_template.php $
|     $Revision: 11678 $
|     $Id: poll_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
|
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

/* ################################# */
/*		template for polls when user HASN'T voted ...			*/


$POLL_NOTVOTED_START = "
<div style='text-align:center'>
<p>
<br />
<b><i>{QUESTION}</i></b>
</p>
<hr />
</div>
<p>
<br />
";

$POLL_NOTVOTED_LOOP = "
{OPTIONBUTTON}<b>{OPTION}</b>
<br /><br />";

$POLL_NOTVOTED_END = "
</p>
<div style='text-align:center' class='smalltext'>
<p>
{SUBMITBUTTON}
<br /><br />
{AUTHOR}
<br />
{VOTE_TOTAL} {COMMENTS}
<br />
{OLDPOLLS}
</p>
</div>";


/* ################################# */
/*		template for polls when user HAS voted ...			*/

$POLL_VOTED_START = "
<div style='text-align:center'>
<br />
<b><i>{QUESTION}</i></b>
<hr />
</div>
<br />
";

$POLL_VOTED_LOOP = "
<b>{OPTION}</b>
<br /><div class='spacer'>{BAR}</div><br />
<span class='smalltext'>{VOTES} | {PERCENTAGE}</span>
<br /><br />
";

$POLL_VOTED_END = "
<div style='text-align:center' class='smalltext'>
{AUTHOR}
<br />
{VOTE_TOTAL} {COMMENTS}
<br />
{OLDPOLLS}
</div>
";


/* ################################# */
/*		template for polls when user CANNOT vote ...		*/


$POLL_DISALLOWED_START = "
<div style='text-align:center'>
<br />
<b><i>{QUESTION}</i></b>
<hr />
</div>
<br />
";

$POLL_DISALLOWED_LOOP = "
<b>{OPTION}</b>
<br /><br />
";

$POLL_DISALLOWED_END = "
<div style='text-align:center' class='smalltext'>
{DISALLOWMESSAGE}<br /><br />
{VOTE_TOTAL} {COMMENTS}
<br />
{OLDPOLLS}
</div>
";


/* ################################# */
/*		template for forum polls when user HASN'T voted*/

$POLL_FORUM_NOTVOTED_START = "
<div style='text-align:center; margin-left: auto; margin-right: auto;'>
<table class='fborder' style='width: 350px;'>
<tr>
<td class='forumheader' style='width: 100%; text-align: center;'>
<b><i>{QUESTION}</i></b>
</td>
</tr>
<tr>
<td class='forumheader3' style='width: 100%;'>";

$POLL_FORUM_NOTVOTED_LOOP = "
{OPTIONBUTTON}<b>{OPTION}</b>
<br /><br />";

$POLL_FORUM_NOTVOTED_END = "
</td>
</tr>

<tr>
<td class='forumheader' style='width: 100%;'>
<div style='text-align:center' class='smalltext'>
{SUBMITBUTTON}
</div>
</td>
</tr>
</table>
</div>";


/* ################################# */
/*		template for forum polls when user HAS voted		*/

$POLL_FORUM_VOTED_START = "
<div style='text-align:center; margin-left: auto; margin-right: auto;'>
<table class='fborder' style='width: 350px;'>
<tr>
<td class='forumheader' style='width: 100%; text-align: center;'>
<b><i>{QUESTION}</i></b>
</td>
</tr>
<tr>
<td class='forumheader3' style='width: 100%;'>
";

$POLL_FORUM_VOTED_LOOP = "
<b>{OPTION}</b>
<br />{BAR}<br />
<span class='smalltext'>{VOTES} | {PERCENTAGE}</span>
<br /><br />
";

$POLL_FORUM_VOTED_END = "
</td>
</tr>

<tr>
<td class='forumheader' style='width: 100%;'>
<div style='text-align:center' class='smalltext'>
{VOTE_TOTAL}
</div>
</td>
</tr>
</table>
</div>
";

?>