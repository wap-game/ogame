<?php

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Registrieren';
$lang['form']              = 'Anmeldung';
$lang['Register']          = 'Sky-Game Registrieren';
$lang['Undefined']         = 'Bitte w&auml;hlen';
$lang['Male']              = 'M&auml;nnlich';
$lang['Female']            = 'Weiblich';
$lang['Multiverse']        = '<b>Sky-Game</b> Beta Uni';
$lang['E-Mail']            = 'E-Mail Adresse (z.B. addy@mail.com)';
$lang['MainPlanet']        = 'Name des Hauptplanets (keine Sonderzeichen)';
$lang['GameName']          = 'Username';
$lang['Sex']               = 'Geschlecht';
$lang['accept']            = 'Ich akzeptiere die <a href="help.php?conditions">Regeln &amp; AGB</a>';
$lang['signup']            = 'Registrieren';
$lang['neededpass']        = 'Passwort';

// Send
$lang['mail_welcome']      = 'Vielen Dank fuer ihre Anmeldung bei uns ({gameurl}) \nVotre mot de passe est : {password}\n\nBon amusement !\n{gameurl}';
$lang['mail_title']        = 'Anmeldung erfolgreich';
$lang['thanksforregistry'] = 'Danke fuer ihre Anmeldung! Sie erhalten inerhalb von 30 Minuten eine E-Mail mit ihren Passwort.';

// Errors
$lang['error_mail']        = 'E-Mail Adresse ung&uuml;ltig!<br />';
$lang['error_hplanet']     = 'Name des Hauptplanets ung&uuml;ltig!.<br />';
$lang['error_hplanetnum']  = 'Der HP Name erh&auml;ltig ung&uuml;ltige Zeichen.<br />';
$lang['error_character']   = 'Username ung&uuml;ltig!<br />';
$lang['error_charalpha']   = 'Bitte nur Buchstaben und Zahlen verwenden!<br />';
$lang['error_password']    = 'Das Passwort muss mindestens 4 Zeichen lang sein!<br />';
$lang['error_rgt']         = 'Sie muessen die AGB zustimmen.<<br />';
$lang['error_userexist']   = 'Der User existiert bereits!<br />';
$lang['error_emailexist']  = 'Es existiert bereits ein User mit dieser E-Mail Adresse!<br />';
$lang['error_sex']         = 'Ung&uuml;ltiges Geschlecht.<br />';
$lang['error_mailsend']    = 'Ein fehler beim versenden der mail das Passwort ist: ';
$lang['reg_welldone']      = 'Registrierung abgeschlossen';

// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
?>