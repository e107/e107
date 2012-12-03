<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_admin/credits.php $
|     $Id: credits.php 12030 2011-01-06 13:29:15Z nlstart $
+----------------------------------------------------------------------------+
*/

require_once("../class2.php");
$e_sub_cat = 'credits';
include(e_ADMIN.'ver.php');


$creditsArray = array(
	array(	"name" => "MagpieRSS",
				"url" => "http://magpierss.sourceforge.net/",
				"description" => CRELAN_10,
				"version" => "0.71.1",
				"licence" => "GPL, ".CRELAN_8
			),
	array(	"name" => "PCLZip",
				"url" => "http://www.phpconcept.net/pclzip/",
				"description" => CRELAN_11,
				"version" => "2.8.2",
				"licence" => "GPL"
			),
	array(	"name" => "PCLTar",
				"url" => "http://www.phpconcept.net/pcltar/",
				"description" => CRELAN_12,
				"version" => "1.3",
				"licence" => "GPL"
			),
	array(	"name" => "TinyMCE",
				"url" => "http://tinymce.moxiecode.com/",
				"description" => CRELAN_13,
				"version" => "3.3.9.2",
				"licence" => "GPL"
			),
	array(	"name" => "Nuvolo Icons",
				"url" => "http://www.icon-king.com",
				"description" => CRELAN_14,
				"version" => "1.0",
				"licence" => "GPL"
			),
	array(	"name" => "PHPMailer",
				"url" => "http://phpmailer.sourceforge.net/",
				"description" => CRELAN_15,
				"version" => "2.0.4",
				"licence" => "GPL"
			),
	array(	"name" => "Brainjar DHTML Menu",
				"url" => "http://www.brainjar.com/dhtml/menubar/",
				"description" => CRELAN_16,
				"version" => "0.1",
				"licence" => "GPL, ".CRELAN_8
			),
	array(	"name" => "DHTML / JavaScript Calendar",
				"url" => "http://www.dynarch.com/projects/",
				"description" => CRELAN_17,
				"version" => "1.0",
				"licence" => "GPL"
			),
	array(	"name" => "FPDF",
				"url" => "http://www.fpdf.org/",
				"description" => CRELAN_18,
				"version" => "1.53",
				"licence" => "Freeware"
			),
	array(	"name" => "UFPDF",
				"url" => "http://www.acko.net/node/56",
				"description" => CRELAN_19,
				"version" => "0.1",
				"licence" => "GPL"
			),
	);

$contentA = array( // ORDER BY FirstName ASC ;)
	"<h3>".CRELAN_6."<\/h3>",
	"<h1>Александр Кадников<\/h1>[ Predator ]<br /><br /><br />".CRELAN_555,
	"<h1>Александр Евланов<\/h1>[ Kapman ]<br /><br /><br />".CRELAN_556,
	"<h1>Стив Данстан<\/h1>[ jalist ]<br /><br /><br />".CRELAN_22,
	"<h1>Камерон Хенли<\/h1>[ CaMer0n ]<br /><br /><br />".CRELAN_21,
	"<h1>Карл Сидергрин<\/h1>[ asperon ]<br /><br /><br />".CRELAN_20,
	"<h1>Эрик Вандерфистен<\/h1> [ lisa ]<br /><br /><br />".CRELAN_23,
	"<h1>Джеймс Курри<\/h1>[ SweetAs ]<br /><br /><br />".CRELAN_27,
	"<h1>Мартин Николлс<\/h1>[ streaky ]<br /><br /><br />".CRELAN_26,
	"<h1>Мирослав Ёвчев<\/h1>[ SecretR ]<br /><br /><br />".defset('CRELAN_29'),
	"<h1>Пит Холзманн<\/h1>[ MrPete ]<br /><br /><br />".CRELAN_28,
	"<h1>Стивен Дэвис<\/h1>[ steved ]<br /><br /><br />".defset('CRELAN_30'),
	"<h1>Том Мичелбринк<\/h1>[ McFly ]<br /><br /><br />".CRELAN_24,
	"<h1>Уильям Моффетт<\/h1>[ que ]<br /><br /><br />".CRELAN_25,
);

echo "<?xml version='1.0' encoding='".CHARSET."' ?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>".PAGE_NAME."</title>
<meta http-equiv='content-type' content='text/html; charset=".CHARSET."' />
<meta http-equiv='content-style-type' content='text/css' />
<link rel='stylesheet' href='".THEME."style.css' type='text/css' />
</head>
<body style='padding: 0; margin: 0; background-color: #f8f8f8; color: #8E8E8E'>

<div><img src='".e_IMAGE."generic/credits.png' alt='' />
<div class='smalltext' style='background: #f8f8f8; padding:2px; border: #000 solid 1px; border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; -o-border-radius: 4px; position: absolute; top: 104px; left: 46px; color: #000; font-weight: bold;'>".CRELAN_7." ".$e107info['e107_version']."<br />&copy; 2002-2012 ".CRELAN_3." All Rights Reserved.<br />&copy; е107 Клуб, 2010-2012. Все права защищены.</div>

";


$fadejs = "
<script type='text/javascript'>
<!--

var delay = 3500;
var maxsteps=30;
var stepdelay=70;
var startcolor= new Array(255,255,255);
var endcolor=new Array(0,0,0);
var fcontent=new Array();
";

if(e_QUERY && e_QUERY == "stps")
{
	$count=1;
	$fadejs .= "fcontent[0] = '<br /><br />".CRELAN_2."';";
	foreach($creditsArray as $credits)
	{
		extract($credits);
		$fadejs .= "fcontent[$count] = '<br /><br /><h1>$name<\/h1>".CRELAN_7." $version<br /><br />$description<br /><br />[ <a href=\"$url\" rel=\"external\">$url<\/a> ]<br /><br />".CRELAN_9." - $licence';
		";
		$count++;
	}
}
else
{
	$count=0;
	foreach($contentA as $content)
	{
		$fadejs .= "fcontent[$count] = '<br /><br />$content';
		";
		$count++;
	}
}

$fadejs .= <<<TEXT
begintag='';
closetag='';


var fadelinks=1;

var fwidth='95%';
var fheight='220px;'

///No need to edit below this line/////////////////

var ie4=document.all&&!document.getElementById;
var DOM2=document.getElementById;
var faderdelay=0;
var index=0;

/*Rafael Raposo edited function*/
//function to change content
function changecontent(){
  if (index>=fcontent.length)
    index=0
  if (DOM2){
    document.getElementById("fscroller").style.color="rgb("+startcolor[0]+", "+startcolor[1]+", "+startcolor[2]+")"
    document.getElementById("fscroller").innerHTML=begintag+fcontent[index]+closetag
    if (fadelinks)
      linkcolorchange(1);
    colorfade(1, 15);
  }
  else if (ie4)
    document.all.fscroller.innerHTML=begintag+fcontent[index]+closetag;
  index++
}

// colorfade() partially by Marcio Galli for Netscape Communications.  ////////////
// Modified by Dynamicdrive.com

function linkcolorchange(step){
  var obj=document.getElementById("fscroller").getElementsByTagName("A");
  if (obj.length>0){
    for (i=0;i<obj.length;i++)
      obj[i].style.color=getstepcolor(step);
  }
}

/*Rafael Raposo edited function*/
var fadecounter;
function colorfade(step) {
  if(step<=maxsteps) {
    document.getElementById("fscroller").style.color=getstepcolor(step);
    if (fadelinks)
      linkcolorchange(step);
    step++;
    fadecounter=setTimeout("colorfade("+step+")",stepdelay);
  }else{
    clearTimeout(fadecounter);
    document.getElementById("fscroller").style.color="rgb("+endcolor[0]+", "+endcolor[1]+", "+endcolor[2]+")";
    setTimeout("changecontent()", delay);

  }
}

/*Rafael Raposo's new function*/
function getstepcolor(step) {
  var diff
  var newcolor=new Array(3);
  for(var i=0;i<3;i++) {
    diff = (startcolor[i]-endcolor[i]);
    if(diff > 0) {
      newcolor[i] = startcolor[i]-(Math.round((diff/maxsteps))*step);
    } else {
      newcolor[i] = startcolor[i]+(Math.round((Math.abs(diff)/maxsteps))*step);
    }
  }
  return ("rgb(" + newcolor[0] + ", " + newcolor[1] + ", " + newcolor[2] + ")");
}

if (ie4||DOM2)
  document.write('<div id="fscroller" style="text-align: center; width:'+fwidth+';height:'+fheight+'"><\/div>');

if (window.addEventListener)
window.addEventListener("load", changecontent, false)
else if (window.attachEvent)
window.attachEvent("onload", changecontent)
else if (document.getElementById)
window.onload=changecontent;
//-->
</script>

TEXT;

echo $fadejs;

echo "
<div style='text-align: center; margin-left: auto; margin-right: auto;'>
<form method='get' action=''><div>".
(e_QUERY && e_QUERY == "stps" ? "<input class='button' type='button' onclick=\"self.parent.location='".e_ADMIN."credits.php'\" value='".CRELAN_4."' />" : "<input class='button' type='button' onclick=\"self.parent.location='".e_ADMIN."credits.php?stps'\" value='".CRELAN_5."' />")."</div>
</form>
</div>

</div>
</body>
</html>
";
?>