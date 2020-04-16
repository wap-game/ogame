<?php

/**
 * FlyingFleetHandler.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function FlyingFleetHandler (&$planet) {
	global $resource;

	doquery("LOCK TABLE {{table}}lunas WRITE, {{table}}rw WRITE, {{table}}errors WRITE, {{table}}messages WRITE, {{table}}fleets WRITE, {{table}}planets WRITE, {{table}}galaxy WRITE ,{{table}}users WRITE", "");

	$QryFleet   = "SELECT * FROM {{table}} ";
	$QryFleet  .= "WHERE (";
	$QryFleet  .= "( ";
	$QryFleet  .= "`fleet_start_galaxy` = ". $planet['galaxy']      ." AND ";
	$QryFleet  .= "`fleet_start_system` = ". $planet['system']      ." AND ";
	$QryFleet  .= "`fleet_start_planet` = ". $planet['planet']      ." AND ";
	$QryFleet  .= "`fleet_start_type` = ".   $planet['planet_type'] ." ";
	$QryFleet  .= ") OR ( ";
	$QryFleet  .= "`fleet_end_galaxy` = ".   $planet['galaxy']      ." AND ";
	$QryFleet  .= "`fleet_end_system` = ".   $planet['system']      ." AND ";
	$QryFleet  .= "`fleet_end_planet` = ".   $planet['planet']      ." ) AND ";
	$QryFleet  .= "`fleet_end_type`= ".      $planet['planet_type'] ." ) AND ";
	$QryFleet  .= "( `fleet_start_time` < '". time() ."' OR `fleet_end_time` < '". time() ."' );";
	$fleetquery = doquery( $QryFleet, 'fleets' );

	while ($CurrentFleet = mysql_fetch_array($fleetquery)) {
		switch ($CurrentFleet["fleet_mission"]) {
			case 1:
				// Attaquer
				MissionCaseAttack ( $CurrentFleet );
				break;

			case 2:
				// Attaque groupée
				doquery ("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');
				break;

			case 3:
				// Transporter
				MissionCaseTransport ( $CurrentFleet );
				break;

			case 4:
				// Stationner
				MissionCaseStay ( $CurrentFleet );
				break;

			case 5:
				// Stationner chez un Allié
			MissionCaseStayAlly ( $CurrentFleet );
				break;

			case 6:
				// Flotte d'espionnage
				MissionCaseSpy ( $CurrentFleet );
				break;

			case 7:
				// Coloniser
				MissionCaseColonisation ( $CurrentFleet );
				break;

			case 8:
				// Recyclage
				MissionCaseRecycling ( $CurrentFleet );
				break;

			case 9:
				// Detruire ??? dans le code ogame c'est 9 !!
				MissionCaseDestruction ( $CurrentFleet );
				break;

			case 10:
				// Missiles !!
				
				break;

			case 15:
				// Expeditions
				MissionCaseExpedition ( $CurrentFleet );
				break;

			default: {
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');
			}
		}
	}

	doquery("UNLOCK TABLES", "");
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>