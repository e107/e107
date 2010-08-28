<?php
/**
 * Fichiers utf-8 français pour le CMS e107 version 0.8 a
 * non compatible 0.7.11
 * Licence GNU/GPL
 * Traducteurs: communauté française e107 http://etalkers.tuxfamily.org/
 *
 * $Source: /cvsroot/touchatou/e107_french/e107_plugins/log/languages/admin/French_log_help.php,v $
 * $Revision: 1.5 $
 * $Date: 2009/02/02 22:01:04 $
 * $Author: marj_nl_fr $
 */

define('LAN_STAT_HELP_01',	'Statistiques des connexions');
define('LAN_STAT_HELP_02',	'Cette option supprime l’historique de la BdD mais n’affecte pas la représentation des “stats depuis le début”.<br /><br />Attention! Une fois supprimées ces données ne peuvent être récupérées. Faites un backup ou exportez les données que vous désirez conserver.');

define('LAN_STAT_HELP_03',	' Cette option permet de ne supprimer que les données relatives à une certaine page.');

define('LAN_STAT_HELP_04',	'Cette option permet d’exporter des données au format CSV et par conséquent d’être importées dans de nombreuses applications pour des analyses détaillées. Référez vous à la page “stats logging plugin” du wiki de pour plus de détails.');

define('LAN_STAT_HELP_05',	'<b>Activation des stats</b><br />Aucun enregistrement n’est effectué si désactivé.<br /><br />
<b>Accès aux pages de stats</b><br />
Détermine qui peut visualiser les stats du site.<br /><br />
<b>Prendre en compte les visites admins</b><br />
De fréquentes visites de la part des admins peuvent fausser les stats. Vous pouvez donc les exclure.<br /><br />
<b>Nombre maximum d’enregistrement à afficher</b><br />
Paramètre le nombre de “visiteurs récents” à retenir.<br /><br />
<b> Types de statistiques</b><br />
Détermine quelles informations doivent être enregistrées. Des enregistrement par mois laissent plus de place en BdD et donnent une meilleur visibilité.
Dans ce cas vous pouvez choisir le mois courant uniquement ou le mois précédent en sus pour l’affichage.<br /><br />
<b>Remise à zéro des stats</b><br />
Supprime les “stats depuis le début” jusqu’à hier minuit. Pour supprimer également les stats du jour effacez les fichiers  log*.php du dossier  log/logs du plugin.<br /><br />');

define('LAN_STAT_HELP_06',	'');
