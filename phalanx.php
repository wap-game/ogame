<?php

/**
 * phalanx.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('overview');
	includeLang('phalanx');

	$PageTPL     = gettemplate('phalanx_body');
	$PhalanxMoon = doquery ("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."';", 'planets', true);

	if ( $PhalanxMoon['planet_type'] == 3) {
		$parse                     = $lang;

		$parse['phl_pl_galaxy']    = $PhalanxMoon['galaxy'];
		$parse['phl_pl_system']    = $PhalanxMoon['system'];
		$parse['phl_pl_place']     = $PhalanxMoon['planet'];
		$parse['phl_pl_name']      = $user['username'];

		if ( $PhalanxMoon['deuterium'] > 10000 ) {
			doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` - '10000' WHERE `id` = '". $user['current_planet'] ."';", 'planets');
			$parse['phl_er_deuter'] = "";
			$DoScan                 = true;
		} else {
			$parse['phl_er_deuter'] = $lang['phl_no_deuter'];
			$DoScan                 = false;
		}

		if ($DoScan == true) {
			$Galaxy  = $_GET["galaxy"];
			$System  = $_GET["system"];
			$Planet  = $_GET["planet"];
			$PlType  = $_GET["planettype"];

			$TargetInfo = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $Galaxy ."' AND `system` = '". $System ."' AND `planet` = '". $Planet ."' AND `planet_type` = '". $PlType ."';", 'planets', true);
			$TargetName = $TargetInfo['name'];

			$QryLookFleets  = "SELECT * ";
			$QryLookFleets .= "FROM {{table}} ";
			$QryLookFleets .= "WHERE ( ( ";
			$QryLookFleets .= "`fleet_start_galaxy` = '". $Galaxy ."' AND ";
			$QryLookFleets .= "`fleet_start_system` = '". $System ."' AND ";
			$QryLookFleets .= "`fleet_start_planet` = '". $Planet ."' AND ";
			$QryLookFleets .= "`fleet_start_type` = '". $PlType ."' ";
			$QryLookFleets .= ") OR ( ";
			$QryLookFleets .= "`fleet_end_galaxy` = '". $Galaxy ."' AND ";
			$QryLookFleets .= "`fleet_end_system` = '". $System ."' AND ";
			$QryLookFleets .= "`fleet_end_planet` = '". $Planet ."' AND ";
			$QryLookFleets .= "`fleet_end_type` = '". $PlType ."' ";
			$QryLookFleets .= ") ) ";
			$QryLookFleets .= "ORDER BY `fleet_start_time`;";

			$FleetToTarget  = doquery( $QryLookFleets, 'fleets' );

			if (mysql_num_rows($FleetToTarget) <> 0 ) {
				while ($FleetRow = mysql_fetch_array($FleetToTarget)) {
					$Record++;

					// Discrimination de l'heure
					$StartTime   = $FleetRow['fleet_start_time'];
					$StayTime    = $FleetRow['fleet_end_stay'];
					$EndTime     = $FleetRow['fleet_end_time'];

					// Flotte hostile ? ou pas ??
					if ($FleetRow['fleet_owner'] == $TargetInfo['id_owner']) {
						$FleetType = true;
					} else {
						$FleetType = false;
					}

					// Masquage des ressources transportées
					$FleetRow['fleet_resource_metal']     = 0;
					$FleetRow['fleet_resource_crystal']   = 0;
					$FleetRow['fleet_resource_deuterium'] = 0;

					$Label = "fs";
					if ($StartTime > time()) {
						$fpage[$StartTime] = BuildFleetEventTable ( $FleetRow, 0, $FleetType, $Label, $Record );
					}

					if ($FleetRow['fleet_mission'] <> 4) {
						$Label = "ft";
						if ($StayTime > time()) {
							$fpage[$StayTime] = BuildFleetEventTable ( $FleetRow, 1, $FleetType, $Label, $Record );
						}

						if ($FleetType == true) {
							// On n'affiche les flottes en retour que pour les flottes du possesseur de la planete
							$Label = "fe";
							if ($EndTime > time()) {
								$fpage[$EndTime]  = BuildFleetEventTable ( $FleetRow, 2, $FleetType, $Label, $Record );
							}
						}
					}
				} // End While
			}

			if (count($fpage) > 0) {
				ksort($fpage);
				foreach ($fpage as $FleetTime => $FleetContent) {
					$Fleets .= $FleetContent ."\n";
				}
			}
		}

		$parse['phl_fleets_table'] = $Fleets;
		$page = parsetemplate( $PageTPL, $parse );
	}

	display ($page, $lang['sys_phalanx'], false, '', false);

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>