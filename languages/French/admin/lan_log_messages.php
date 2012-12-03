<?php
/**
 * Fichiers utf-8 français pour le CMS e107 version 0.8 α
 * non compatible 0.7.11
 * Licence GNU/GPL
 * Traducteurs: communauté française e107 http://etalkers.tuxfamily.org/
 *
 * $Source: /cvsroot/touchatou/e107_french/e107_languages/French/admin/lan_log_messages.php,v $
 * $Revision: 1.8 $
 * $Date: 2009/06/05 13:24:40 $
 * $Author: marj_nl_fr $
 *
 * dev comments
 * The definitions in this file are for standard 'explanatory' messages which might be entered into any of the system logs.
 * They are in three groups with different prefixes:
 *	LAN_ADMIN_LOG_nnn - the admin log (records intentional actions by admins)
 *	LAN_AUDIT_LOG_nnn - the audit log (records actions, generally intentional, by users)
 *	LAN_ROLL_LOG_nnn  - the rolling log (records extraneous events, debugging etc)
 */
if (!defined('e107_INIT')) { exit(); }

// User audit trail events. For messages 11-30, the last 2 digits must match the define for the event type in the admin log
define('LAN_AUDIT_LOG_001', 'Accédé par un utilisateur banni.');
define('LAN_AUDIT_LOG_002', 'Protection flood  activée.');
define('LAN_AUDIT_LOG_003', 'Accédé depuis une adresse IP bannie.');
define('LAN_AUDIT_LOG_004', '');
define('LAN_AUDIT_LOG_005', '');
define('LAN_AUDIT_LOG_006', 'Un membre a changé son mot de passe.');
define('LAN_AUDIT_LOG_007', 'Un membre a changé son adresse email.');
define('LAN_AUDIT_LOG_008', '');
define('LAN_AUDIT_LOG_009', '');
define('LAN_AUDIT_LOG_010', 'Données utilisateur modifiées par un admin.');
define('LAN_AUDIT_LOG_011', 'Un utilisateur s’est enregistré.');
define('LAN_AUDIT_LOG_012', 'Un membre a confirmé son inscription.');
define('LAN_AUDIT_LOG_013', 'Un membre s’est connecté.');
define('LAN_AUDIT_LOG_014', 'Un membre s’est déconnecté.');
define('LAN_AUDIT_LOG_015', 'Un membre a changé son nom d’affichage.');
define('LAN_AUDIT_LOG_016', 'Un membre a changé son mot de passe.');
define('LAN_AUDIT_LOG_017', 'Un membre a changé son adresse email.');
define('LAN_AUDIT_LOG_018', 'Mot de passe membre réinitialisé.');
define('LAN_AUDIT_LOG_019', 'Un membre a changé ses paramètres.');
define('LAN_AUDIT_LOG_020', 'Membre créé par un admin.');


// Admin log events
//-----------------
define('LAN_ADMIN_LOG_002', 'Log admin: anciennes données supprimées.');
define('LAN_ADMIN_LOG_003', 'Log audit membres: anciennes données supprimées.');

// User edits
//-----------
define('LAN_AL_USET_01', 'Données utilisateur modifiées par un admin.');
define('LAN_AL_USET_02', 'Membre ajouté par un admin.');
define('LAN_AL_USET_03', 'Option membre modifiées.');
define('LAN_AL_USET_04', 'Membres supprimés.');
define('LAN_AL_USET_05', 'Membre banni.');
define('LAN_AL_USET_06', 'Membre débanni.');
define('LAN_AL_USET_07', 'Membre supprimé.');
define('LAN_AL_USET_08', 'Membre créé par un admin.');
define('LAN_AL_USET_09', 'Statuts admin supprimés.');
define('LAN_AL_USET_10', 'Membre approuvé.');
define('LAN_AL_USET_11', 'Ré-envoyer la validation email.');
define('LAN_AL_USET_12', 'Ré-envoyer toutes les validations emails.');
define('LAN_AL_USET_13', 'Emails non délivrés supprimés.');
define('LAN_AL_USET_14', 'Appartenance aux groupes mise à jour.');

// Userclass events
//------------------
define('LAN_AL_UCLASS_00', 'Évènement inconnu relatif à un groupe de membres.');
define('LAN_AL_UCLASS_01', 'Groupe de membres créé.');
define('LAN_AL_UCLASS_02', 'Groupe de membres supprimé.');
define('LAN_AL_UCLASS_03', 'Groupe de membres mis à jour.');
define('LAN_AL_UCLASS_04', 'Appartenance au groupe mise à jour.');
define('LAN_AL_UCLASS_05', 'Paramètres initiaux du groupe édités.');
define('LAN_AL_UCLASS_06', 'Appartenance aux groupes mise à jour.');

// Banlist events
//----------------
define('LAN_AL_BANLIST_00', 'Évènement inconnu relatif aux bannissements.');
define('LAN_AL_BANLIST_01', 'Bannissement manuel ajouté.');
define('LAN_AL_BANLIST_02', 'Bannissement supprimé.');
define('LAN_AL_BANLIST_03', 'Heure du bannissement modifiée.');
define('LAN_AL_BANLIST_04', 'Ajouté à la liste blanche.');
define('LAN_AL_BANLIST_05', 'Supprimé à la liste blanche');
define('LAN_AL_BANLIST_06', 'Liste des bannis exportée.');
define('LAN_AL_BANLIST_07', 'Liste des bannis importée.');
define('LAN_AL_BANLIST_08', 'Options de la liste des bannis mises à jour.');
define('LAN_AL_BANLIST_09', 'Modification dans la liste des bannis.');
define('LAN_AL_BANLIST_10', 'Liste blanche modifiée.');
define('LAN_AL_BANLIST_11', 'Entrée bannissement pour une adresse en liste blanche');


// Comment-related events
//-----------------------
define('LAN_AL_COMMENT_01', 'Commentaires supprimés.');

// Rolling log events
//-------------------
define('LAN_ROLL_LOG_01', 'Nom utilisateur ou mot de passe vide.');
define('LAN_ROLL_LOG_02', 'Code image incorrect.');
define('LAN_ROLL_LOG_03', 'Nom utilisateur ou mot de passe non valide.');
define('LAN_ROLL_LOG_04', 'Nom utilisateur non valide.');
define('LAN_ROLL_LOG_05', 'Essai de connexion par un utilisateur incomplètement enregistré.');
define('LAN_ROLL_LOG_06', 'Connexion bloquée par le handler trigger event.');
define('LAN_ROLL_LOG_07', 'Connexion multiples depuis la même adresse.');
define('LAN_ROLL_LOG_08', 'Nom utilisateur trop long.');
define('LAN_ROLL_LOG_09', 'Essai de connexion par un utilisateur banni.');
define('LAN_ROLL_LOG_10', 'Erreur de connexion. Raison inconnue.');
define('LAN_ROLL_LOG_11', 'Erreur de connexion admin.');

// Prefs events
//-------------------
define('LAN_AL_PREFS_01', 'Préférences modifiées');

// Front Page events
//------------------
define('LAN_AL_FRONTPG_00', 'Évènement page d’accueil inconnu');
define('LAN_AL_FRONTPG_01', 'Ordre des règles modifié');
define('LAN_AL_FRONTPG_02', 'Règle ajoutée');
define('LAN_AL_FRONTPG_03', 'Règle modifiée');
define('LAN_AL_FRONTPG_04', 'Règle supprimée');

// User theme admin
//-----------------
define('LAN_AL_UTHEME_00', 'Évènement inconnu relatif aux thèmes utilisateurs');
define('LAN_AL_UTHEME_01', 'Paramètres thèmes utilisateurs modifiés');
