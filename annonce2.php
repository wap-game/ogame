<?php

/**
 * annonce2.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includelang('annonces');

$actions = $_GET['action'];

if($actions == 2)
{
$page .=<<<HTML
<center>
<br>
<table width="600">
<td class="c" colspan="10" align="center"><b><font color="white">{$lang['Ajouter']}</font></b></td></tr>
<td class="c" colspan="10" align="center"><b>{$lang['Ressources']}</font></b></td></tr>

<form action="annonces.php?action=5" method="post">
<tr><th colspan="5">{$lang['M']}</th><th colspan="5"><input type="texte" value="0" name="metalvendre" /></th></tr>
<tr><th colspan="5">{$lang['C']}</th><th colspan="5"><input type="texte" value="0" name="cristalvendre" /></th></tr>
<tr><th colspan="5">{$lang['D']}</th><th colspan="5"><input type="texte" value="0" name="deutvendre" /></th></tr>
<td class="c" colspan="10" align="center"><b>{$lang['souhait']}</font></b></td></tr>
<tr><th colspan="5">{$lang['M']}</th><th colspan="5"><input type="texte" value="0" name="metalsouhait" /></th></tr>
<tr><th colspan="5">{$lang['C']}</th><th colspan="5"><input type="texte" value="0" name="cristalsouhait" /></th></tr>
<tr><th colspan="5">{$lang['D']}</th><th colspan="5"><input type="texte" value="0" name="deutsouhait" /></th></tr>
<tr><th colspan="10"><input type="submit" value="{$lang['Ajouter']}" /></th></tr>

<form>
</table>
HTML;

display($page);
}
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>