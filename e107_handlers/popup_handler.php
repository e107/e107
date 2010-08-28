<?php
/*
+---------------------------------------------------------------+
|        e107 website system
|
|        �Steve Dunstan 2001-2002
|        http://e107.org
|        jalist@e107.org
|
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
|		$Source: /cvs_backup/e107_0.7/e107_handlers/popup_handler.php,v $
|		$Revision: 11346 $
|		$Date: 2010-02-17 12:56:14 -0600 (Wed, 17 Feb 2010) $
|		$Author: secretr $
+---------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

class popup{

	// usage:
	// you need to add the following call to popup.js in a headerjs function
	//
	// function headerjs(){
	// echo "<script type='text/javascript' src='".e_FILE."popup.js'></script>\n";
	// }
	// on the page where you want to popup image to appear,
	// you need to include this class and create a new object for it:
	// require_once(e_HANDLER."popup_handler.php");
	// $pp = new popup;
	// then you need to prepare the right paramater in the function call.
	// the function returns the image with the popup link as a href on it
	// clicking the popup will use the js functions in the included js file to popup the image
	// $pp -> popup($oSrc, $oSrcThumb, $oIconWidth, $oMaxWidth, $oTitle, $oText)

	function popup($image, $thumb, $iconwidth='100', $maxwidth='', $title, $text){
			global $tp;
			//$image	:	full path to the large image you want to popup
			//$thumb	:	full path to the small image to show on screen
			//$maxwidth	:	the maximum size (width or height) an image may be popup'ed
			//$title	:	the window title of the popup
			//$text		:	the additional text to add into the popup

			if(file_exists($image)){
				
				//use $image if $thumb doesn't exist
				if(!file_exists($thumb)){
					$thumb = $image;
				}
				$imagearray = getimagesize(trim($image));
				//$imagearray holds width and height parameters of the image
				//$imagearray[0] is width - $imagearray[1] is height

				if($imagearray[1] > $imagearray[0]){
					if(isset($maxwidth) && $maxwidth!='' && $imagearray[1] > $maxwidth){
						$width		= round(($maxwidth*$imagearray[0])/$imagearray[1],0);
						$height		= $maxwidth;
					}else{
						$width		= $imagearray[0];
						$height		= $imagearray[1];
					}
				}else{
					if(isset($maxwidth) && $maxwidth!='' && $imagearray[0] > $maxwidth){
						$width		= $maxwidth;
						$height		= round(($maxwidth*$imagearray[1])/$imagearray[0],0);
					}else{
						$width		= $imagearray[0];
						$height		= $imagearray[1];
					}
				}
				$iconwidth = ($title == "help" ? "" : ($iconwidth ? "width:".intval($iconwidth)."px;" : "width:100px;") );

				$width		= intval($width);
				$search		= array("'", '$', '"', '&#036;','&#039;', '&#092;');
				$replace	= array("\'", '\$', '&quot;', '\$', "\'", '\\');
				$title		= str_replace($search, $replace, $title);
				$text		= str_replace($search, $replace, $text);

				$popup = "<a href='javascript:void(0);' onclick=\"javascript:openPerfectPopup('".$image."',".$width.",'".$title."','".$text."')\" style='cursor:pointer;' onmouseover=\"window.status='".POPUP_LAN_1."'; return true;\" onmouseout=\"window.status=''; return true;\" ><img src='".$thumb."' style='".$iconwidth."' alt='' /></a><br /><br />";

			}else{
				$popup = "";
			}
			return $popup;
	}
}

?>