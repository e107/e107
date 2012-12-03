parse_str($parm);

if (isset($file) && $file && is_readable($file))
{
	$logo = $file;
	$path = $file;
}
else if (is_readable(THEME."images/e_adminlogo.png"))
{
	$logo = THEME_ABS."images/e_adminlogo.png";
	$path = THEME."images/e_adminlogo.png";
}
else
{
	$logo = e_IMAGE_ABS."adminlogo.png";
	$path = e_IMAGE."adminlogo.png";
}

$dimensions = getimagesize($path);

$image = "<img class='logo admin_logo' src='".$logo."' style='width: ".$dimensions[0]."px; height: ".$dimensions[1]."px' alt='".ADLAN_153."' />\n";

if (isset($link) && $link) {
	if ($link == 'index') {
		$image = "<a href='".e_ADMIN_ABS."index.php'>".$image."</a>";
	}
	else
	{
		$image = "<a href='".$link."'>".$image."</a>";
	}
}

return $image;