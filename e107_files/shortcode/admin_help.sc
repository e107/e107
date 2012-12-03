/* $Id: admin_help.sc 11836 2010-09-30 21:43:10Z e107coders $ */
//<?
if (!ADMIN) return '';

  $helpfile = '';
  global $ns, $pref;			// Used by the help renderer

  if(strpos(e_SELF, e_ADMIN_ABS) !== FALSE)
  {
	//@TODO better way to do this?
	if (is_readable(e_LANGUAGEDIR.e_LANGUAGE."/admin/help/".e_PAGE)) 
	{
	  $helpfile = e_LANGUAGEDIR.e_LANGUAGE."/admin/help/".e_PAGE;
	} 
	elseif (is_readable(e_LANGUAGEDIR."English/admin/help/".e_PAGE)) 
	{
	  $helpfile = e_LANGUAGEDIR."English/admin/help/".e_PAGE;
	}
  }
  else
  {
	$plugpath = getcwd()."/help.php"; // deprecated file. For backwards compat. only. 
	$eplugpath = getcwd()."/e_help.php";
	if(is_readable($eplugpath))
	{
	  $helpfile = $eplugpath;
	}
	elseif(is_readable($plugpath))
	{
	  $helpfile = $plugpath;
	}
  }
  if (!$helpfile) return '';

  ob_start();
  include_once($helpfile);
  $help_text = ob_get_contents();
  ob_end_clean();
  return $help_text;
