<?php

/**
 * ShowTopNavigationBar.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

function ShowTopNavigationBar ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $_GET;

	echo (json_encode($CurrentUser));

	if ($CurrentUser) {
		if ( !$CurrentPlanet ) {
			$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['current_planet'] ."';", 'planets', true);
		}

		// Actualisation des ressources de la planete
		PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time() );

		$NavigationTPL       = gettemplate('topnav');

		$dpath               = (!$CurrentUser["dpath"]) ? DEFAULT_SKINPATH : $CurrentUser["dpath"];
		$parse               = $lang;
		$parse['dpath']      = $dpath;
		$parse['image']      = $CurrentPlanet['image'];

		// Genearation de la combo des planetes du joueur
		$parse['planetlist'] = '';
		$ThisUsersPlanets    = SortUserPlanets ( $CurrentUser );
		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {
			if ($CurPlanet["destruyed"] == 0) {
				$parse['planetlist'] .= "\n<option ";
				if ($CurPlanet['id'] == $CurrentUser['current_planet']) {
					// Bon puisque deja on s'y trouve autant le marquer
					$parse['planetlist'] .= "selected=\"selected\" ";
				}
				$parse['planetlist'] .= "value=\"?cp=".$CurPlanet['id']."";
				$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
				$parse['planetlist'] .= "&amp;re=0\">";

				// Nom et coordonnées de la planete
				$parse['planetlist'] .= "".$CurPlanet['name'];
				$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
				$parse['planetlist'] .= "".$CurPlanet['system'].":";
				$parse['planetlist'] .= "".$CurPlanet['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
			}
		}

		// Metal
		$metal = pretty_number($CurrentPlanet["metal"]);
		$parse['metal_max'] = pretty_number($CurrentPlanet["metal_max"]);
		if (($CurrentPlanet["metal"] > $CurrentPlanet["metal_max"])) {
			$parse['metal'] = colorRed($metal);
		} else {
			$parse['metal'] = $metal;
		}
		// Cristal
		$crystal = pretty_number($CurrentPlanet["crystal"]);
		$parse['crystal_max'] = pretty_number($CurrentPlanet["crystal_max"]);
		if (($CurrentPlanet["crystal"] > $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = colorRed($crystal);
		} else {
			$parse['crystal'] = $crystal;
		}
		// Deuterium
		$deuterium = pretty_number($CurrentPlanet["deuterium"]);
		$parse['deuterium_max'] = pretty_number($CurrentPlanet["deuterium_max"]);
		if (($CurrentPlanet["deuterium"] > $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = colorRed($deuterium);
		} else {
			$parse['deuterium'] = $deuterium;
		}

		// Energie
		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]);
		$parse['energy_max'] = pretty_number($CurrentPlanet["energy_max"]);
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = colorRed($energy);
		} else {
			$parse['energy'] = $energy;
		}
		
		// Message
		$parse['message_all'] = $CurrentUser['message_all'];
		if ($CurrentUser['new_message'] > 0) {
			$parse['message'] = $CurrentUser['new_message'];
		} else {
			$parse['message'] = 0;
		}

		// Le tout passe dans la template
		$TopBar = parsetemplate( $NavigationTPL, $parse);
	} else {
		$TopBar = "";
	}

	return $TopBar;
}

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>