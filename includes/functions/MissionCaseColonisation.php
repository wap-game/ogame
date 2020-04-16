<?php

/**
 * MissionCaseColonisation.php
 *
 * @version 1
 * @copyright 2008
 */

// ----------------------------------------------------------------------------------------------------------------
// Mission Case 9: -> Coloniser
//
function MissionCaseColonisation ( $FleetRow ) {
	global $lang, $resource;

	$iPlanetCount = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `id_owner` = '". $FleetRow['fleet_owner'] ."' AND `planet_type` = '1'", 'planets'), 0);
	if ($FleetRow['fleet_mess'] == 0) {
		// Déjà, sommes nous a l'aller ??
		$iGalaxyPlace = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `galaxy` = '". $FleetRow['fleet_end_galaxy']."' AND `system` = '". $FleetRow['fleet_end_system']."' AND `planet` = '". $FleetRow['fleet_end_planet']."';", 'galaxy'), 0);
		$TargetAdress = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
		if ($iGalaxyPlace == 0) {
			// Y a personne qui s'y est mis avant que je ne debarque !
			if ($iPlanetCount >= MAX_PLAYER_PLANETS) {
				$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'] . MAX_PLAYER_PLANETS . $lang['sys_colo_planet'];
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
			} else {
				$NewOwnerPlanet = CreateOnePlanetRecord($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], $lang['sys_colo_defaultname'], false);
				if ( $NewOwnerPlanet == true ) {
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
					SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
					// Verifier ce que contient fleet_array (et le cas et cheant retirer un element '208'
					if ($FleetRow['fleet_amount'] == 1) {
						doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
					} else {
						$CurrentFleet = explode(";", $FleetRow['fleet_array']);
						$NewFleet     = "";
						foreach ($CurrentFleet as $Item => $Group) {
							if ($Group != '') {
								$Class = explode (",", $Group);
								if ($Class[0] == 208) {
									if ($Class[1] > 1) {
										$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
									}
								} else {
									if ($Class[1] <> 0) {
									$NewFleet  .= $Class[0].",".$Class[1].";";
									}
								}
							}
						}
						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_array` = '". $NewFleet ."', ";
						$QryUpdateFleet .= "`fleet_amount` = `fleet_amount` - 1, ";
						$QryUpdateFleet .= "`fleet_mess` = '1' ";
						$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';";
						doquery( $QryUpdateFleet, 'fleets');
					}
				} else {
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
					SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				}
			}
		} else {
			// Pas de bol coiffé sur le poteau !
			$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
			// Mettre a jour la flotte pour qu'effectivement elle revienne !
			doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');

		}
	} else {
		// Retour de flotte
		RestoreFleetToPlanet ( $FleetRow, true );
		doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
	}
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>