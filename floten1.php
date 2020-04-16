<?php

/**
 * floten1.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('fleet');

	$speed = array(
		10 => 100,
		9 => 90,
		8 => 80,
		7 => 70,
		6 => 60,
		5 => 50,
		4 => 40,
		3 => 30,
		2 => 20,
		1 => 10,
		);

	$g = $_POST['galaxy'];
	$s = $_POST['system'];
	$p = $_POST['planet'];
	$t = $_POST['planet_type'];

	if (!$g) {
		$g = $planetrow['galaxy'];
	}
	if (!$s) {
		$s = $planetrow['system'];
	}
	if (!$p) {
		$p = $planetrow['planet'];
	}
	if (!$t) {
		$t = $planetrow['planet_type'];
	}

	// Verifions si nous avons bien tout ce que nous voullons envoyer
	$FleetHiddenBlock  = "";
	foreach ($reslist['fleet'] as $n => $i) {
		if ($i > 200 && $i < 300 && $_POST["ship{$i}"] > "0") {
			if ($_POST["ship{$i}"] > $planetrow[$resource[$i]]) {
				$page .= $lang['fl_noenought'];
				$speedalls[$i]             = GetFleetMaxSpeed ( "", $i, $user );
			} else {
				$fleet['fleetarray'][$i]   = $_POST["ship{$i}"];
				// Tableau des vaisseaux avec leur nombre
				$fleet['fleetlist']       .= $i . "," . $_POST["ship{$i}"] . ";";
				// Nombre total de vaisseaux
				$fleet['amount']          += $_POST["ship{$i}"];
				// Tableau des vitesses
				$FleetHiddenBlock         .= "<input type='hidden' name='consumption{$i}' value='". GetShipConsumption ( $i, $user ) ."' />";
				$FleetHiddenBlock         .= "<input type='hidden' name='speed{$i}'       value='". GetFleetMaxSpeed ( "", $i, $user ) ."' />";
				$FleetHiddenBlock         .= "<input type='hidden' name='capacity{$i}'    value='". $pricelist[$i]['capacity'] ."' />";
				$FleetHiddenBlock         .= "<input type='hidden' name='ship{$i}'        value='". $_POST["ship{$i}"] ."' />";
				$speedalls[$i]             = GetFleetMaxSpeed ( "", $i, $user );
			}
		}
	}

	if (!$fleet['fleetlist']) {
		message($lang['fl_unselectall'], $lang['fl_error'], "fleet." . $phpEx, 1);
	} else {
		$speedallsmin = min($speedalls);
	}
	$page .= "<script type='text/javascript' src='scripts/flotten.js'></script>";
	$page .= "<script type='text/javascript'>\n";
	$page .= "function getStorageFaktor() {\n";
	$page .= "	return 1;\n";
	$page .= "}\n";
	$page .= "</script>\n";
	$page .= "<form action='floten2.php' method='post'>";
	$page .= $FleetHiddenBlock;
	$page .= "<input type='hidden' name='speedallsmin'   value='". $speedallsmin ."' />";
	$page .= "<input type='hidden' name='usedfleet'      value='". str_rot13(base64_encode(serialize($fleet['fleetarray']))) ."' />";
	$page .= "<input type='hidden' name='thisgalaxy'     value='". $planetrow['galaxy'] ."' />";
	$page .= "<input type='hidden' name='thissystem'     value='". $planetrow['system'] ."' />";
	$page .= "<input type='hidden' name='thisplanet'     value='". $planetrow['planet'] ."' />";
	$page .= "<input type='hidden' name='galaxyend'      value='". intval($_POST['galaxy']) ."' />";
	$page .= "<input type='hidden' name='systemend'      value='". intval($_POST['system']) ."' />";
	$page .= "<input type='hidden' name='planetend'      value='". intval($_POST['planet']) ."' />";
	$page .= "<input type='hidden' name='speedfactor'    value='". GetGameSpeedFactor () ."' />";
	$page .= "<input type='hidden' name='thisplanettype' value='". $planetrow['planet_type'] ."' />";
	$page .= "<input type='hidden' name='thisresource1'  value='". floor($planetrow['metal']) ."' />";
	$page .= "<input type='hidden' name='thisresource2'  value='". floor($planetrow['crystal']) ."' />";
	$page .= "<input type='hidden' name='thisresource3'  value='". floor($planetrow['deuterium']) ."' />";

	$page .= "<br><div><center>";
	$page .= "<table width='650' border='0' cellpadding='0' cellspacing='1'>";
	$page .= "<tr height='20'>";
	$page .= "<th colspan='2' class='c'>". $lang['fl_floten1_ttl'] ."</th>";
	$page .= "</tr>";
	$page .= "<tr height='20'>";
	$page .= "<th width='50%'>". $lang['fl_dest'] ."</th>";
	$page .= "<th>";
	$page .= "<input name='galaxy' size='3' maxlength='2' onChange='shortInfo()' onKeyUp='shortInfo()' value='". $g ."' />";
	$page .= "<input name='system' size='3' maxlength='3' onChange='shortInfo()' onKeyUp='shortInfo()' value='". $s ."' />";
	$page .= "<input name='planet' size='3' maxlength='2' onChange='shortInfo()' onKeyUp='shortInfo()' value='". $p ."' />";
	$page .= "<select name='planettype' onChange='shortInfo()' onKeyUp='shortInfo()'>";
	$page .= "<option value='1'". (($t == 1) ? " SELECTED" : "" ) .">". $lang['fl_planet'] ." </option>";
	$page .= "<option value='2'". (($t == 2) ? " SELECTED" : "" ) .">". $lang['fl_ruins']  ." </option>";
	$page .= "<option value='3'". (($t == 3) ? " SELECTED" : "" ) .">". $lang['fl_moon'] ." </option>";
	$page .= "</select>";
	$page .= "</th>";
	$page .= "</tr>";
	$page .= "<tr height='20'>";
	$page .= "<th>". $lang['fl_speed'] ."</th>";
	$page .= "<th>";
	$page .= "<select name='speed' onChange='shortInfo()' onKeyUp='shortInfo()'>";
	foreach ($speed as $a => $b) {
		$page .= "<option value='".$a."'>".$b."</option>";
	}
	$page .= "</select> %";
	$page .= "</th>";
	$page .= "</tr>";

	$page .= "<tr height='20'>";
	$page .= "<th>". $lang['fl_dist'] ."</th>";
	$page .= "<th><div id='distance'>-</div></th>";
	$page .= "</tr><tr height='20'>";
	$page .= "<th>". $lang['fl_fltime'] ."</th>";
	$page .= "<th><div id='duration'>-</div></th>";
	$page .= "</tr><tr height='20'>";
/* A faire assez rapidement (faut juste savoir comment)
	$page .= "<th>". $lang['fl_time_go'] ."</th>";
	$page .= "<th><font color='lime'><div id='llegada1'>". gmdate("y-m-d H:i:s") ."</div></font></th>";
	$page .= "</tr><tr height='20'>";
	$page .= "<th>". $lang['fl_time_back'] ."</th>";
	$page .= "<th><font color='lime'><div id='llegada2'>". gmdate("y-m-d H:i:s") ."</div></font></th>";
	$page .= "</tr><tr height='20'>";
*/	$page .= "<th>". $lang['fl_deute_need'] ."</th>";
	$page .= "<th><div id='consumption'>-</div></th>";
	$page .= "</tr><tr height='20'>";
	$page .= "<th>". $lang['fl_speed_max'] ."</th>";
	$page .= "<th><div id='maxspeed'>-</div></th>";
	$page .= "</tr><tr height='20'>";
	$page .= "<th>". $lang['fl_max_load'] ."</th>";
	$page .= "<th><div id='storage'>-</div></th>";
	$page .= "</tr>";

	// Gestion des raccourcis sur la galaxie
	$page .= "<tr height='20'>";
	$page .= "<td colspan='2' class='c'>{$lang['fl_shortcut']}<a href='fleetshortcut.php'>{$lang['fl_shortlnk']}</a></th>";
	$page .= "</tr>";
	if ($user['fleet_shortcut']) {
		$scarray = explode("\r\n", $user['fleet_shortcut']);
		$i = 0;
		foreach ($scarray as $a => $b) {
			if ($i == 0) {
				$page .= "<tr height='20'>";
			}
			if ($b != "") {
				$c = explode(',', $b);
				$page .= "<th width='50%'><a href='javascript:setTarget({$c[1]}, {$c[2]}, {$c[3]}, {$c[4]}); shortInfo();'>";
				$page .= "{$c[0]} [{$c[1]}:{$c[2]}:{$c[3]}] ";

				if ($c[4] == 1) {
					$page .= $lang['fl_shrtcup1'];
				} elseif ($c[4] == 2) {
					$page .= $lang['fl_shrtcup2'];
				} elseif ($c[4] == 3) {
					$page .= $lang['fl_shrtcup3'];
				}
				$page .= "</a></th>";
			} else {
				$page .= "<th width='50%'>&nbsp;</th>";
			}
			if ($i == 1) {
				$page .= "</tr>";
			}
			if ($i == 1) {
				$i = 0;
			} else {
				$i = 1;
			}
		}
		if ($i == 1) {
			$page .= "<th>&nbsp;</th></tr>";
		}
	} else {
		$page .= "<tr height='20'>";
		$page .= "<th colspan='2'>". $lang['fl_noshortc'] ."</th>";
		$page .= "</tr>";
	}

	$page .= "<tr height='20'>";
	$page .= "<th colspan='2' class='c'>". $lang['fl_myplanets'] ."</th>";
	$page .= "</tr>";

	// Gestion des raccourcis vers ses propres colonies ou planetes
	$kolonien      = SortUserPlanets ( $user );
	$currentplanet = doquery("SELECT * FROM {{table}} WHERE id = '" . $user['current_planet'] . "'", 'planets', true);

	if (mysql_num_rows($kolonien) > 1) {
		$i = 0;
		$w = 0;
		$tr = true;
		while ($row = mysql_fetch_array($kolonien)) {
			if($i%2==0) {
				$page .= "<tr height='20'>";
			}
			$page .= '<th width="50%"><a href="javascript:setTarget('.$row['galaxy'].','.$row['system'].','.$row['planet'].','.$row['planet_type'].'); shortInfo();">'.$row['name'].' '.$row['galaxy'].':'.$row['system'].':'.$row['planet'].'</a></th>';
			if(($i+1)%2==0) {
				$page .= "</tr>";
			}
			$i++;
		}
		if($i%2!=0) {
			$page .= "<th>&nbsp;</th></tr>";
		}
	} else {
		$page .= "<tr height='20'><th colspan='2'>". $lang['fl_nocolonies'] ."</th></tr>";
	}

/*	$page .= "</tr>";

	$page .= "<tr height='20'>";
	$page .= "<td colspan='2' class='c'>". $lang['fl_grattack'] ."</th>";
	$page .= "</tr>";
	$page .= "<tr height='20'>";
	$page .= "<th colspan='2'>-</th>";
	$page .= "</tr>";
*/
	$page .= "<tr height='20'>";
	$page .= "<th colspan='2'><input type='submit' value='". $lang['fl_continue'] ."' /></th>";
	$page .= "</tr>";
	$page .= "</table>";
	$page .= "</div></center>";
	$page .= "<input type='hidden' name='maxepedition' value='". $_POST['maxepedition'] ."' />";
	$page .= "<input type='hidden' name='curepedition' value='". $_POST['curepedition'] ."' />";
	$page .= "<input type='hidden' name='target_mission' value='". $target_mission ."' />";
	$page .= "</form>";
	$page .= "<script>javascript:shortInfo(); </script>";

	display($page, $lang['fl_title']);

// Updated by Chlorel. 16 Jan 2008 (String extraction, bug corrections, code uniformisation
// Created by Perberos. All rights reversed (C) 2006
?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>