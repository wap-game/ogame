<?php

/**
 * banned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);


includeLang('banned');

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;


$query = doquery("SELECT * FROM {{table}} ORDER BY `id`;",'banned');
$i=0;
while($u = mysql_fetch_array($query)){
	$parse['banned'] .=
        "<tr><td class=b><center><b>".$u[1]."</center></td></b>".
	"<td class=b><center><b>".$u[2]."</center></b></td>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[4])."</center></b></td>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[5])."</center></b></td>".
	"<td class=b><center><b>".$u[6]."</center></b></td></tr>";
	$i++;
}

if ($i=="0")
 $parse['banned'] .= "<tr><th class=b colspan=6>{$lang['ban_no']}</th></tr>";
else
  $parse['banned'] .= "<tr><th class=b colspan=6>{$lang['ban_thereare']} {$i} {$lang['ban_players']}</th></tr>";

display(parsetemplate(gettemplate('banned_body'), $parse),'Banned',true);


// Created by e-Zobar (XNova Team). All rights reversed (C) 2008
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>