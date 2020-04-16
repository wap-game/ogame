<?php

/**
 * buildings.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('buildings');
	
	UpdatePlanetBatimentQueueList ( $planetrow, $user );
	$IsWorking = HandleTechnologieBuild ( $planetrow, $user );

	switch ($_GET['mode']) {
		case 'fleet':
			// --------------------------------------------------------------------------------------------------
			FleetBuildingPage ( $planetrow, $user );
			break;

		case 'research':
			// --------------------------------------------------------------------------------------------------
			ResearchBuildingPage ( $planetrow, $user, $IsWorking['OnWork'], $IsWorking['WorkOn'] );
			break;

		case 'defense':
			// --------------------------------------------------------------------------------------------------
			DefensesBuildingPage ( $planetrow, $user );
			break;

		default:
			// --------------------------------------------------------------------------------------------------
			BatimentBuildingPage ( $planetrow, $user );
			break;
	}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Nettoyage modularisation
// 1.1 - Mise au point, mise en fonction pour linéarisation du fonctionnement
// 1.2 - Liste de construction batiments
?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>