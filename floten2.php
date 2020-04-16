<?php

/**
 * floten2.php
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

	$galaxy     = intval($_POST['galaxy']);
	$system     = intval($_POST['system']);
	$planet     = intval($_POST['planet']);
	$planettype = intval($_POST['planettype']);

	// Test d'existance et de proprieté de la planete
	$YourPlanet = false;
	$UsedPlanet = false;
	$select       = doquery("SELECT * FROM {{table}}", "planets");

	while ($row = mysql_fetch_array($select)) {
		if ($galaxy     == $row['galaxy'] &&
			$system     == $row['system'] &&
			$planet     == $row['planet'] &&
			$planettype == $row['planet_type']) {
			if ($row['id_owner'] == $user['id']) {
				$YourPlanet = true;
				$UsedPlanet = true;
			} else {
				$UsedPlanet = true;
			}
			break;
		}
	}

	// Determinons les type de missions possibles par rapport a la planete cible
	if ($_POST['planettype'] == "2") {
		if ($_POST['ship209'] >= 1) {
			$missiontype = array(8 => $lang['type_mission'][8]);
		} else {
			$missiontype = array();
		}
	} elseif ($_POST['planettype'] == "1" || $_POST['planettype'] == "3") {
		if ($_POST['ship208'] >= 1 && !$UsedPlanet) {
			$missiontype = array(7 => $lang['type_mission'][7]);
		} elseif ($_POST['ship210'] >= 1 && !$YourPlanet) {
			$missiontype = array(6 => $lang['type_mission'][6]);
		}

		if ($_POST['ship202'] >= 1 ||
			$_POST['ship203'] >= 1 ||
			$_POST['ship204'] >= 1 ||
			$_POST['ship205'] >= 1 ||
			$_POST['ship206'] >= 1 ||
			$_POST['ship207'] >= 1 ||
			$_POST['ship210'] >= 1 ||
			$_POST['ship211'] >= 1 ||
			$_POST['ship213'] >= 1 ||
			$_POST['ship214'] >= 1 ||
			$_POST['ship215'] >= 1) {
			if (!$YourPlanet) {
				$missiontype[1] = $lang['type_mission'][1];
			}
			$missiontype[3] = $lang['type_mission'][3];
			$missiontype[5] = $lang['type_mission'][5];
		}

		
	} elseif ($_POST['ship209'] >= 1 || $_POST['ship208']) {
		$missiontype[3] = $lang['type_mission'][3];
	}
	if ($YourPlanet)
		$missiontype[4] = $lang['type_mission'][4];

	if ( $_POST['planettype'] == 3 &&
		($_POST['ship214']         ||
		 $_POST['ship213'])        &&
		 !$YourPlanet              &&
		 $UsedPlanet) {
		$missiontype[2] = $lang['type_mission'][2];
	}
	if ( $_POST['planettype'] == 3 &&
	     $_POST['ship214'] >= 1    &&
           !$YourPlanet            &&
           $UsedPlanet) {
          $missiontype[9] = $lang['type_mission'][9];
   }

	$fleetarray    = unserialize(base64_decode(str_rot13($_POST["usedfleet"])));
	$mission       = $_POST['target_mission'];
	$SpeedFactor   = $_POST['speedfactor'];
	$AllFleetSpeed = GetFleetMaxSpeed ($fleetarray, 0, $user);
	$GenFleetSpeed = $_POST['speed'];
	$MaxFleetSpeed = min($AllFleetSpeed, $GenFleetSpeed);

	$distance      = GetTargetDistance ( $_POST['thisgalaxy'], $_POST['galaxy'], $_POST['thissystem'], $_POST['system'], $_POST['thisplanet'], $_POST['planet'] );
	$duration      = GetMissionDuration ( $GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor );
	$consumption   = GetFleetConsumption ( $fleetarray, $SpeedFactor, $duration, $distance, $MaxFleetSpeed, $user );

	$MissionSelector  = "";
	if (count($missiontype) > 0) {
		if ($planet == 16) {
			$MissionSelector .= "<tr height=\"20\">";
			$MissionSelector .= "<th>";
			$MissionSelector .= "<input type=\"radio\" name=\"mission\" value=\"15\" checked=\"checked\">". $lang['type_mission'][15] ."<br /><br />";
			$MissionSelector .= "<font color=\"red\">". $lang['fl_expe_warning'] ."</font>";
			$MissionSelector .= "</th>";
			$MissionSelector .= "</tr>";
		} else {
			$i = 0;
			foreach ($missiontype as $a => $b) {
				$MissionSelector .= "<tr height=\"20\">";
				$MissionSelector .= "<th>";
				$MissionSelector .= "<input id=\"inpuT_".$i."\" type=\"radio\" name=\"mission\" value=\"".$a."\"". ($mission == $a ? " checked=\"checked\"":"") .">";
				$MissionSelector .= "<label for=\"inpuT_".$i."\">".$b."</label><br>";
				$MissionSelector .= "</th>";
				$MissionSelector .= "</tr>";
				$i++;
			}
		}
	} else {
		$MissionSelector .= "<tr height=\"20\">";
		$MissionSelector .= "<th>";
		$MissionSelector .= "<font color=\"red\">". $lang['fl_bad_mission'] ."</font>";
		$MissionSelector .= "</th>";
		$MissionSelector .= "</tr>";
	}

	if       ($_POST['thisplanettype'] == 1) {
		$TableTitle = "". $_POST['thisgalaxy'] .":". $_POST['thissystem'] .":". $_POST['thisplanet'] ." - ". $lang['fl_planet'] ."";
	} elseif ($_POST['thisplanettype'] == 3) {
		$TableTitle = "". $_POST['thisgalaxy'] .":". $_POST['thissystem'] .":". $_POST['thisplanet'] ." - ". $lang['fl_moon'] ."";
	}

	$page  = "<script type=\"text/javascript\" src=\"scripts/flotten.js\">\n</script>";
	$page .= "<script type=\"text/javascript\">\n";
	$page .= "function getStorageFaktor() {\n";
	$page .= "    return 1;\n";
	$page .= "}\n";
	$page .= "</script>\n";
	$page .= "<br><center>";
	$page .= "<form action=\"floten3.php\" method=\"post\">\n";
	$page .= "<input type=\"hidden\" name=\"thisresource1\"  value=\"". floor($planetrow["metal"]) ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"thisresource2\"  value=\"". floor($planetrow["crystal"]) ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"thisresource3\"  value=\"". floor($planetrow["deuterium"]) ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"consumption\"    value=\"". $consumption ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"dist\"           value=\"". $distance ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"speedfactor\"    value=\"". $_POST['speedfactor'] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"thisgalaxy\"     value=\"". $_POST["thisgalaxy"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"thissystem\"     value=\"". $_POST["thissystem"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"thisplanet\"     value=\"". $_POST["thisplanet"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"galaxy\"         value=\"". $_POST["galaxy"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"system\"         value=\"". $_POST["system"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"planet\"         value=\"". $_POST["planet"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"thisplanettype\" value=\"". $_POST["thisplanettype"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"planettype\"     value=\"". $_POST["planettype"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"speedallsmin\"   value=\"". $_POST["speedallsmin"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"speed\"          value=\"". $_POST['speed'] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"speedfactor\"    value=\"". $_POST["speedfactor"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"usedfleet\"      value=\"". $_POST["usedfleet"] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"maxepedition\"   value=\"". $_POST['maxepedition'] ."\" />\n";
	$page .= "<input type=\"hidden\" name=\"curepedition\"   value=\"". $_POST['curepedition'] ."\" />\n";
	if(!empty($fleetarray)) {
		foreach ($fleetarray as $Ship => $Count) {
			$page .= "<input type=\"hidden\" name=\"ship". $Ship ."\"        value=\"". $Count ."\" />\n";
			$page .= "<input type=\"hidden\" name=\"capacity". $Ship ."\"    value=\"". $pricelist[$Ship]['capacity'] ."\" />\n";
			$page .= "<input type=\"hidden\" name=\"consumption". $Ship ."\" value=\"". GetShipConsumption ( $Ship, $user ) ."\" />\n";
			$page .= "<input type=\"hidden\" name=\"speed". $Ship ."\"       value=\"". GetFleetMaxSpeed ( "", $Ship, $user ) ."\" />\n";
	
		}
	}
	$page .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"519\">\n";
	$page .= "<tbody>\n";
	$page .= "<tr align=\"left\" height=\"20\">\n";
	$page .= "<td class=\"c\" colspan=\"2\">". $TableTitle ."</td>\n";
	$page .= "</tr>\n";
	$page .= "<tr align=\"left\" valign=\"top\">\n";
	$page .= "<th width=\"50%\">\n";
	$page .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"259\">\n";
	$page .= "<tbody>\n";
	$page .= "<tr height=\"20\">\n";
	$page .= "<td class=\"c\" colspan=\"2\">". $lang['fl_mission'] ."</td>\n";
	$page .= "</tr>\n";
	$page .= $MissionSelector;
	$page .= "</tbody>\n";
	$page .= "</table>\n";
	$page .= "</th>\n";
	$page .= "<th>\n";
	$page .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"259\">\n";
	$page .= "<tbody>\n";
	$page .= "<tr height=\"20\">\n";
	$page .= "<td colspan=\"3\" class=\"c\">". $lang['fl_ressources'] ."</td>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Metal'] ."</th>\n";
	$page .= "<th><a href=\"javascript:maxResource('1');\">". $lang['fl_selmax'] ."</a></th>\n";
	$page .= "<th><input name=\"resource1\" alt=\"". $lang['Metal'] ." ". floor($planetrow["metal"]) ."\" size=\"10\" onchange=\"calculateTransportCapacity();\" type=\"text\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Crystal'] ."</th>\n";
	$page .= "<th><a href=\"javascript:maxResource('2');\">". $lang['fl_selmax'] ."</a></th>\n";
	$page .= "<th><input name=\"resource2\" alt=\"". $lang['Crystal'] ." ". floor($planetrow["crystal"]) ."\" size=\"10\" onchange=\"calculateTransportCapacity();\" type=\"text\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Deuterium'] ."</th>\n";
	$page .= "<th><a href=\"javascript:maxResource('3');\">". $lang['fl_selmax'] ."</a></th>\n";
	$page .= "<th><input name=\"resource3\" alt=\"". $lang['Deuterium'] ." ". floor($planetrow["deuterium"]) ."\" size=\"10\" onchange=\"calculateTransportCapacity();\" type=\"text\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['fl_space_left'] ."</th>\n";
	$page .= "<th colspan=\"2\"><div id=\"remainingresources\">-</div></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th colspan=\"3\"><a href=\"javascript:maxResources()\">". $lang['fl_allressources'] ."</a></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th colspan=\"3\">&nbsp;</th>\n";
	$page .= "</tr>\n";
	if ($planet == 16) {
		$page .= "<tr height=\"20\">";
		$page .= "<td class=\"c\" colspan=\"3\">". $lang['fl_expe_staytime'] ."</td>";
		$page .= "</tr>";
		$page .= "<tr height=\"20\">";
		$page .= "<th colspan=\"3\">";
		$page .= "<select name=\"expeditiontime\" >";
		$page .= "<option value=\"1\">1</option>";
		$page .= "<option value=\"2\">2</option>";
		$page .= "</select>";
		$page .= $lang['fl_expe_hours'];
		$page .= "</th>";
		$page .= "</tr>";
	} elseif ( $missiontype[5] != '' ) {
		$page .= "<tr height=\"20\">";
		$page .= "<td class=\"c\" colspan=\"3\">". $lang['fl_expe_staytime'] ."</td>";
		$page .= "</tr>";
		$page .= "<tr height=\"20\">";
		$page .= "<th colspan=\"3\">";
		$page .= "<select name=\"holdingtime\" >";
		$page .= "<option value=\"0\">0</option>";
		$page .= "<option value=\"1\">1</option>";
		$page .= "<option value=\"2\">2</option>";
		$page .= "<option value=\"4\">4</option>";
		$page .= "<option value=\"8\">8</option>";
		$page .= "<option value=\"16\">16</option>";
		$page .= "<option value=\"32\">32</option>";
		$page .= "</select>";
		$page .= $lang['fl_expe_hours'];
		$page .= "</th>";
		$page .= "</tr>";
	}
	$page .= "</tbody>\n";
	$page .= "</table>\n";
	$page .= "</th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th colspan=\"2\"><input accesskey=\"z\" value=\"". $lang['fl_continue'] ."\" type=\"submit\"></th>\n";
	$page .= "</tr>\n";
	$page .= "</tbody>\n";
	$page .= "</table>\n";
	$page .= "</form></center>\n";

	display($page, $lang['fl_title']);

// Updated by Chlorel. 16 Jan 2008 (String extraction, bug corrections, code uniformisation)
// Created by Perberos. All rights reversed (C) 2006
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>