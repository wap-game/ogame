<?php

/**
 * MissionCaseSpy.php
 *
 * @version 1
 * @copyright 2008
 */

// ----------------------------------------------------------------------------------------------------------------
// Mission Case 6: -> Espionner
//
function MissionCaseSpy ( $FleetRow ) {
	global $lang, $resource;

	if ($FleetRow['fleet_start_time'] <= time()) {
		$CurrentUser         = doquery("SELECT * FROM {{table}} WHERE `id` = '".$FleetRow['fleet_owner']."';", 'users', true);
		$CurrentUserID       = $FleetRow['fleet_owner'];
		$QryGetTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryGetTargetPlanet .= "WHERE ";
		$QryGetTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryGetTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryGetTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
		$QryGetTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
		$TargetPlanet        = doquery( $QryGetTargetPlanet, 'planets', true);
		$TargetUserID        = $TargetPlanet['id_owner'];
		$CurrentPlanet       = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."';", 'planets', true);
		$CurrentSpyLvl       = $CurrentUser['spy_tech'];
		$TargetUser          = doquery("SELECT * FROM {{table}} WHERE `id` = '".$TargetUserID."';", 'users', true);
		$TargetSpyLvl        = $TargetUser['spy_tech'];
		$fleet               = explode(";", $FleetRow['fleet_array']);
		$fquery              = "";
		foreach ($fleet as $a => $b) {
			if ($b != '') {
				$a = explode(",", $b);
				$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
				if ($FleetRow["fleet_mess"] != "1") {
					if ($a[0] == "210") {
						$LS    = $a[1];
						$QryTargetGalaxy  = "SELECT * FROM {{table}} WHERE ";
						$QryTargetGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryTargetGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryTargetGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
						$TargetGalaxy     = doquery( $QryTargetGalaxy, 'galaxy', true);
						$CristalDebris    = $TargetGalaxy['crystal'];
						$SpyToolDebris    = $LS * 300;

						$MaterialsInfo    = SpyTarget ( $TargetPlanet, 0, $lang['sys_spy_maretials'] );
						$Materials        = $MaterialsInfo['String'];

						$PlanetFleetInfo  = SpyTarget ( $TargetPlanet, 1, $lang['sys_spy_fleet'] );
						$PlanetFleet      = $Materials;
						$PlanetFleet     .= $PlanetFleetInfo['String'];

						$PlanetDefenInfo  = SpyTarget ( $TargetPlanet, 2, $lang['sys_spy_defenses'] );
						$PlanetDefense    = $PlanetFleet;
						$PlanetDefense   .= $PlanetDefenInfo['String'];

						$PlanetBuildInfo  = SpyTarget ( $TargetPlanet, 3, $lang['tech'][0] );
						$PlanetBuildings  = $PlanetDefense;
						$PlanetBuildings .= $PlanetBuildInfo['String'];

						$TargetTechnInfo  = SpyTarget ( $TargetUser, 4, $lang['tech'][100] );
						$TargetTechnos    = $PlanetBuildings;
						$TargetTechnos   .= $TargetTechnInfo['String'];

						$TargetForce      = ($PlanetFleetInfo['Count'] * $LS) / 4;

						if ($TargetForce > 100) {
							$TargetForce = 100;
						}
						$TargetChances = rand(0, $TargetForce);
						$SpyerChances  = rand(0, 100);
						if ($TargetChances >= $SpyerChances) {
							$DestProba = sprintf( $lang['sys_mess_spy_lostproba'], $TargetChances);
						} elseif ($TargetChances < $SpyerChances) {
							$DestProba = "<font color=\"red\">".$lang['sys_mess_spy_destroyed']."</font>";
						}
						$AttackLink = "<center>";
						$AttackLink .= "<a href=\"fleet.php?galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."";
						$AttackLink .= "&planet=".$FleetRow['fleet_end_planet']."";
						$AttackLink .= "&target_mission=1";
						$AttackLink .= " \">". $lang['type_mission'][1] ."";
						$AttackLink .= "</a></center>";


						$MessageEnd = "<center>".$DestProba."</center>";

						$pT = ($TargetSpyLvl - $CurrentSpyLvl);
						$pW = ($CurrentSpyLvl - $TargetSpyLvl);
						if ($TargetSpyLvl > $CurrentSpyLvl) {
							$ST = ($LS - pow($pT, 2));
						}
						if ($CurrentSpyLvl > $TargetSpyLvl) {
							$ST = ($LS + pow($pW, 2));
						}
						if ($TargetSpyLvl == $CurrentSpyLvl) {
							$ST = $CurrentSpyLvl;
						}
						if ($ST <= "1") {
							$SpyMessage = $Materials."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST == "2") {
							$SpyMessage = $PlanetFleet."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST == "4" or $ST == "3") {
							$SpyMessage = $PlanetDefense."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST == "5" or $ST == "6") {
							$SpyMessage = $PlanetBuildings."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST >= "7") {
							$SpyMessage = $TargetTechnos."<br />".$AttackLink.$MessageEnd;
						}

						SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_qg'], $lang['sys_mess_spy_report'], $SpyMessage);

						$TargetMessage  = $lang['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];
						$TargetMessage .= "<a href=\"galaxy.php?mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
						$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
						$TargetMessage .= $lang['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
						$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."].";

						SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_spy_control'], $lang['sys_mess_spy_activity'], $TargetMessage);

					}
					if ($TargetChances >= $SpyerChances) {
						$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
						$QryUpdateGalaxy .= "`crystal` = `crystal` + '". (0 + $SpyToolDebris) ."' ";
						$QryUpdateGalaxy .= "WHERE `id_planet` = '". $TargetPlanet['id'] ."';";
						doquery( $QryUpdateGalaxy, 'galaxy');

						doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
					} else {
						doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
					}
				}
			} else {
				// Retour de sondes
				if ($FleetRow['fleet_end_time'] <= time()) {
					RestoreFleetToPlanet ( $FleetRow, true );
					doquery("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				}
			}
		}
	}
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>