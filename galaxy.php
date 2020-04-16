<?php

/**
 * galaxy.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('galaxy');

	$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."';", 'planets', true);
	$lunarow       = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_luna'] ."';", 'lunas', true);
	$galaxyrow     = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $CurrentPlanet['id'] ."';", 'galaxy', true);

	$dpath         = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
	$fleetmax      = $user['computer_tech'] + 1;
	$CurrentPlID   = $CurrentPlanet['id'];
	$CurrentMIP    = $CurrentPlanet['interplanetary_misil'];
	$CurrentRC     = $CurrentPlanet['recycler'];
	$CurrentSP     = $CurrentPlanet['spy_sonde'];
	$HavePhalanx   = $CurrentPlanet['phalanx'];
	$CurrentSystem = $CurrentPlanet['system'];
	$CurrentGalaxy = $CurrentPlanet['galaxy'];
	$CanDestroy    = $CurrentPlanet[$resource[213]] + $CurrentPlanet[$resource[214]];

	$maxfleet       = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $user['id'] ."';", 'fleets');
	$maxfleet_count = mysql_num_rows($maxfleet);

	CheckPlanetUsedFields($CurrentPlanet);
	CheckPlanetUsedFields($lunarow);

	if (!isset($mode)) {
		if (isset($_GET['mode'])) {
			$mode          = intval($_GET['mode']);
		} else {
			$mode          = 0;
		}
	}

	if ($mode == 0) {
		$galaxy        = $CurrentPlanet['galaxy'];
		$system        = $CurrentPlanet['system'];
		$planet        = $CurrentPlanet['planet'];
	} elseif ($mode == 1) {
		if ($_POST["galaxyLeft"]) {
			if ($_POST["galaxy"] <= 1) {
				$galaxy          = 1;
			} else {
				$galaxy = $_POST["galaxy"] - 1;
			}
		} elseif ($_POST["galaxyRight"]) {
			if ($_POST["galaxy"]      >= MAX_GALAXY_IN_WORLD) {
				$galaxy               = MAX_GALAXY_IN_WORLD;
			} else {
				$galaxy = $_POST["galaxy"] + 1;
			}
		} else {
			$galaxy = $_POST["galaxy"];
		}

		if ($_POST["systemLeft"]) {
			if ($_POST["system"] <= 1) {
				$system          = 1;
			} else {
				$system = $_POST["system"] - 1;
			}
		} elseif ($_POST["systemRight"]) {
			if ($_POST["system"]      >= MAX_SYSTEM_IN_GALAXY) {
				$system               = MAX_SYSTEM_IN_GALAXY;
			} else {
				$system = $_POST["system"] + 1;
			}
		} else {
			$system = $_POST["system"];
		}
	} elseif ($mode == 2) {
		$galaxy        = $_GET['galaxy'];
		$system        = $_GET['system'];
		$planet        = $_GET['planet'];
	} elseif ($mode == 3) {
		$galaxy        = $_GET['galaxy'];
		$system        = $_GET['system'];
	} else {
		$galaxy        = 1;
		$system        = 1;
	}

	$planetcount = 0;
	$lunacount   = 0;

	$page  = InsertGalaxyScripts ( $CurrentPlanet );

	$page .= ShowGalaxySelector ( $galaxy, $system );

	if ($mode == 2) {
		$CurrentPlanetID = $_GET['current'];
		$page .= ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
	}

	$page .= "<table width='650px'><tbody>";

	$page .= ShowGalaxyTitles ( $galaxy, $system );
    $page .= ShowGalaxyRows   ( $galaxy, $system );
    $page .= ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

	$page .= "</tbody></table></div>";

	display ($page, $lang[''], false, '', false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Created by Perberos
// 1.1 - Modified by -MoF- (UGamela germany)
// 1.2 - 1er Nettoyage Chlorel ...
// 1.3 - 2eme Nettoyage Chlorel ... Mise en fonction et debuging complet
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>