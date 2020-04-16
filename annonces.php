<?php

/**
 * annonce.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('annonces');

$users   = doquery("SELECT * FROM {{table}} WHERE id='".$user['id']."';", 'users');
$annonce = doquery("SELECT * FROM {{table}} ", 'annonce');
$action  = $_GET['action'];

if ($action == 5) {
	$metalvendre = $_POST['metalvendre'];
	$cristalvendre = $_POST['cristalvendre'];
	$deutvendre = $_POST['deutvendre'];

	$metalsouhait = $_POST['metalsouhait'];
	$cristalsouhait = $_POST['cristalsouhait'];
	$deutsouhait = $_POST['deutsouhait'];

	while ($v_annonce = mysql_fetch_array($users)) {
		$user = $v_annonce['username'];
		$galaxie = $v_annonce['galaxy'];
		$systeme = $v_annonce['system'];
	}

	doquery("INSERT INTO {{table}} SET
user='{$user}',
galaxie='{$galaxie}',
systeme='{$systeme}',
metala='{$metalvendre}',
cristala='{$cristalvendre}',
deuta='{$deutvendre}',
metals='{$metalsouhait}',
cristals='{$cristalsouhait}',
deuts='{$deutsouhait}'" , "annonce");

/*	$page2 = "HTML
<center>
<br>
<p>{$lang['Annonce']}</p>
<br><p><a href='annonces.php'>{$lang['Retour']} </a></p>
</center>";

	display($page2);
*/
echo "<script>location.href='annonces.php';</script>";
}

if ($action != 5) {
	$annonce = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ", "annonce");

	$page2 = "<HTML>
<center>
<br>
<table width=\"600\"><tr><td class=\"c\" colspan=\"10\"><font color=\"#FFFFFF\">{$lang['Petites']}</font></td></tr>
<tr><th colspan=\"3\">{$lang['Infos']}</th><th colspan=\"3\">{$lang['Ressources']}</th>
<th colspan=\"3\">{$lang['souhait']}</th><th>{$lang['Action']}</th></tr>
<tr><th>{$lang['Vendeur']}</th><th>{$lang['Galaxie']}</th><th>{$lang['system']}</th>
<th>{$lang['M']}</th><th>{$lang['C']}</th><th>{$lang['D']}</th><th>{$lang['M']}</th>
<th>{$lang['C']}</th><th>{$lang['D']}</th><th>{$lang['Delet']}</th></tr>
";
	while ($b = mysql_fetch_array($annonce)) {
		$page2 .= '<tr><th> ';
		$page2 .= $b["user"] ;
		$page2 .= '</th><th>';
		$page2 .= $b["galaxie"];
		$page2 .= '</th><th>';
		$page2 .= $b["systeme"];
		$page2 .= '</th><th>';
		$page2 .= $b["metala"];
		$page2 .= '</th><th>';
		$page2 .= $b["gcristala"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuta"];
		$page2 .= '</th><th>';
		$page2 .= $b["metals"];
		$page2 .= '</th><th>';
		$page2 .= $b["cristals"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuts"];
		$page2 .= '</th><th>';
		$page2 .= "</th></tr>";
	}

	$page2 .= "
<tr><th colspan=\"10\" align=\"center\"><a href=\"annonce2.php?action=2\">{$lang['Ajouter']}</a></th></tr>
</td>
</table>
</HTML>";

	display($page2);
}

// Créer par Tom1991 Copyright 2008
// Merci au site Spacon pour m'avoir donner l'inspiration
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>