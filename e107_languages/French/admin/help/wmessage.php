<?php
/**
 * Fichiers utf-8 français pour le CMS e107 version 0.8 α
 * accessoirement compatible 0.7.11
 * Licence GNU/GPL
 * Traducteurs: communauté française e107 http://etalkers.tuxfamily.org/
 *
 * $Source: /cvsroot/touchatou/e107_french/e107_languages/French/admin/help/wmessage.php,v $
 * $Revision: 1.7 $
 * $Date: 2009/02/02 22:01:02 $
 * $Author: marj_nl_fr $
 */

if (!defined('e107_INIT')) { exit(); }

$text = 'Cette page permet de rédiger un message de bienvenue ou informatif qui est placer en haut de la page d’accueil.<br />
Le message peut être différent pour les visiteurs, les membres, les administrateurs et autres groupes.';
$ns -> tablerender('Aide sur WMessage', $text);
