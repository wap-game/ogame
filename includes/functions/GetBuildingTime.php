<?php

/**
 * GetBuildingTime
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

// Calcul du temps de construction d'un Element (Batiment / Recherche / Defense / Vaisseau )
// $user       -> Le Joueur lui meme
// $planet     -> La planete sur laquelle l'Element doit etre construit
// $Element    -> L'Element que l'on convoite
function GetBuildingTime ($user, $planet, $Element) {
	global $pricelist, $resource, $reslist, $game_config;


	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	if       (in_array($Element, $reslist['build'])) {
		// Pour un batiment ...
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = ((($cost_crystal) + ($cost_metal)) / $game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_constructeur']) * 0.1)));
	} elseif (in_array($Element, $reslist['tech'])) {
		// Pour une recherche
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$intergal_lab = $user[$resource[123]];
		if       ( $intergal_lab < "1" ) {
			$lablevel = $planet[$resource['31']];
		} elseif ( $intergal_lab >= "1" ) {
			$empire = doquery("SELECT * FROM {{table}} WHERE id_owner='". $user[id] ."';", 'planets');
			$NbLabs = 0;
			while ($colonie = mysql_fetch_array($empire)) {
				$techlevel[$NbLabs] = $colonie[$resource['31']];
				$NbLabs++;
			}
			if ($intergal_lab >= "1") {
				$lablevel = 0;
				for ($lab = 1; $lab <= $intergal_lab; $lab++) {
					asort($techlevel);
					$lablevel += $techlevel[$lab - 1];
				}
			}
		}
		$time         = (($cost_metal + $cost_crystal) / $game_config['game_speed']) / (($lablevel + 1) * 2);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_scientifique']) * 0.1)));
	} elseif (in_array($Element, $reslist['defense'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_defenseur'])   * 0.375)));
	} elseif (in_array($Element, $reslist['fleet'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_technocrate']) * 0.05)));
	}


	return $time;
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>