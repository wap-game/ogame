<?php

/**
 * fleetshortcut.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('fleet');

$mode = $_GET['mode'];
$a = $_GET['a'];
/*
  Este script es original xD
  La funcion de este script es administrar una variable del $user
  Permite agregar y quitar arrays...
*/
//Lets start!
if(isset($_GET['mode'])){
	if($_POST){
		//Pegamos el texto :P
		if($_POST["n"] == ""){$_POST["n"] = "{$lang[fl_uncheat]}";}

		$r = strip_tags($_POST[n]).",".intval($_POST[g]).",".intval($_POST[s]).",".intval($_POST[p]).",".intval($_POST[t])."\r\n";
		$user['fleet_shortcut'] .= $r;
		doquery("UPDATE {{table}} SET fleet_shortcut='{$user[fleet_shortcut]}' WHERE id={$user[id]}","users");
		message("{$lang['Cheat_1']}","{$lang['fl_cheat_2']}","fleetshortcut.php");
	}
	$page = "<form method=POST><table border=0 cellpadding=0 cellspacing=1 width=519>
	<tr height=20>
	
	<td colspan=2 class=c>{$lang['fl_cheat_name']}[{$lang['fl_cheat_galaxy']}/{$lang['fl_cheat_sun']}/{$lang['fl_cheat_plant']}]</td>
	</tr><tr height=\"20\"><th>
	<input type=text name=n value=\"$g\" size=32 maxlength=32 title=\"{$lang['fl_cheat_name']}\">
	<input type=text name=g value=\"$s\" size=3 maxlength=1 title=\"{$lang['fl_cheat_galaxy']}\">
	<input type=text name=s value=\"$p\" size=3 maxlength=3 title=\"{$lang['fl_cheat_sun']}\">
	<input type=text name=p value=\"$t\" size=3 maxlength=3 title=\"{$lang['fl_cheat_plant']}\">
	 <select name=t>";
	$page .= '<option value="1"'.(($c[4]==1)?" SELECTED":"").">{$lang['fl_cheat_plant']}</option>";
	$page .= '<option value="2"'.(($c[4]==2)?" SELECTED":"").">{$lang['fl_cheat_debirs']}</option>";
	$page .= '<option value="3"'.(($c[4]==3)?" SELECTED":"").">{$lang['fl_cheat_moon']}</option>";
	$page .= "</select>
	</th></tr><tr>
	<th><input type=\"reset\" value=\"{$lang['fl_cheat_reset']}\"> <input type=\"submit\" value=\"{$lang['fl_cheat_save']}\">";
	//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
	$page .= "</th></tr>";
	$page .= "<tr><td colspan=2 class=c><a href=fleetshortcut.php>{$lang['fl_cheat_back']}</a></td></tr></tr></table></form>";
}
elseif(isset($_GET['a'])){
	if($_POST){
		//Armamos el array...
		$scarray = explode("\r\n",$user['fleet_shortcut']);
		if($_POST["delete"]){
			unset($scarray[$a]);
			$user['fleet_shortcut'] =  implode("\r\n",$scarray);
			doquery("UPDATE {{table}} SET fleet_shortcut='{$user[fleet_shortcut]}' WHERE id={$user[id]}","users");
			message("{$lang['fl_cheat_mess1']}",
				"{$lang['fl_cheat_mess2']}","fleetshortcut.php");
		}
		else{
			$r = explode(",",$scarray[$a]);
			$r[0] = strip_tags($_POST['n']);
			$r[1] = intval($_POST['g']);
			$r[2] = intval($_POST['s']);
			$r[3] = intval($_POST['p']);
			$r[4] = intval($_POST['t']);
			$scarray[$a] = implode(",",$r);
			$user['fleet_shortcut'] =  implode("\r\n",$scarray);
			doquery("UPDATE {{table}} SET fleet_shortcut='{$user[fleet_shortcut]}' WHERE id={$user[id]}","users");
			message("{$lang['fl_cheat_mess3']}","{$lang['fl_cheat_edit']}","fleetshortcut.php");
		}
	}
	if($user['fleet_shortcut']){

		$scarray = explode("\r\n",$user['fleet_shortcut']);
		$c = explode(',',$scarray[$a]);

		$page = "<form method=POST><table border=0 cellpadding=0 cellspacing=1 width=519>
	<tr height=20>
	<td colspan=2 class=c>{$lang['fl_cheat_report']}: {$c[0]} [{$c[1]}:{$c[2]}:{$c[3]}]</td>
	</tr>";
		//if($i==0){$page .= "";}
		$page .= "<tr height=\"20\"><th>
		<input type=hidden name=a value=$a>
		<input type=text name=n value=\"{$c[0]}\" size=32 maxlength=32>
		<input type=text name=g value=\"{$c[1]}\" size=3 maxlength=1>
		<input type=text name=s value=\"{$c[2]}\" size=3 maxlength=3>
		<input type=text name=p value=\"{$c[3]}\" size=3 maxlength=3>
		 <select name=t>";
		$page .= '<option value="1"'.(($c[4]==1)?" SELECTED":"").">{$lang['fl_cheat_plant']}</option>";
		$page .= '<option value="2"'.(($c[4]==2)?" SELECTED":"").">{$lang['fl_cheat_debirs']}</option>";
		$page .= '<option value="3"'.(($c[4]==3)?" SELECTED":"").">{$lang['fl_cheat_moon']}</option>";
		$page .= "</select>
		</th></tr><tr>
		<th><input type=reset value=\"{$lang['fl_cheat_reset']}\"> <input type=submit value=\"{$lang['fl_cheat_save']}\"> <input type=submit name=delete value=\"{$lang['fl_cheat_delete']}\">";
		$page .= "</th></tr>";

	}else{$page .= message("{$lang['fl_cheat_mess4']}","{$lang['fl_cheat_report']}","fleetshortcut.php");}

	$page .= "<tr><td colspan=2 class=c>
	<a href=fleetshortcut.php>{$lang['fl_cheat_back']}</a></td></tr></tr></table></form>";


}
else{

	$page = "<table border='0' cellpadding='0' cellspacing='1' width='519'>
	<tr height='20'>
	<td colspan='2' class='c'>{$lang['fl_shortcut']}(<a href='?mode=add'>{$lang['fl_cheat_join']}</a>)</td>
	</tr>";

	if($user['fleet_shortcut']){
		/*
		  Dentro de fleet_shortcut, se pueden almacenar las diferentes direcciones
		  de acceso directo, el formato es el siguiente.
		  Nombre, Galaxia,Sistema,Planeta,Tipo
		*/
		$scarray = explode("\r\n",$user['fleet_shortcut']);
		$i=$e=0;
		foreach($scarray as $a => $b){
			if($b!=""){
			$c = explode(',',$b);
			if($i==0){$page .= "<tr height=\"20\">";}
			$page .= "<th><a href=\"?a=".$e++."\">";
			$page .= "{$c[0]} {$c[1]}:{$c[2]}:{$c[3]}";
			//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
			if($c[4]==2){$page .= " (E)";}elseif($c[4]==3){$page .= " (L)";}
			$page .= "</a></th>";
			if($i==1){$page .= "</tr>";}
			if($i==1){$i=0;}else{$i=1;}
			}

		}
		if($i==1){$page .= "<th></th></tr>";}

	}else{$page .= "<th colspan=\"2\">{$lang['fl_noshortc']}</th>";}

	$page .= "<tr><td colspan=2 class=c><a href=fleet.php>{$lang['fl_cheat_back']}</a></td></tr></tr></table>";
}
display($page,"Shortcutmanager");

// Created by Perberos. All rights reversed (C) 2006
?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>