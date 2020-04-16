<?php

/**
 * FleetBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

// Page de Construction d'Elements de Flotte
// $CurrentPlanet -> Planete sur laquelle la construction est lancÃ©e
//                   Parametre passÃ© par adresse, cela permet de mettre les valeurs a jours
//                   dans le programme appelant
// $CurrentUser   -> Utilisateur qui a lancÃ© la construction
//
function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $phpEx, $dpath, $_POST;

	if (isset($_POST['fmenge'])) {
		// On vient de Cliquer ' Construire '
		// Et y a une liste de doléances
		$AddedInQueue = false;
		// Ici, on sait precisement ce qu'on aimerait bien construire ...
		foreach($_POST['fmenge'] as $Element => $Count) {
			// Construction d'Element recuperés sur la page de Flotte ...
			// ATTENTION ! La file d'attente Flotte est Commune a celle des Defenses
			// Dans fmenge, on devrait trouver un tableau des elements constructibles et du nombre d'elements souhaités

			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}

			if ($Count != 0) {
				// On verifie si on a les technologies necessaires a la construction de l'element
				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
					// On verifie combien on sait faire de cet element au max
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );
					// Si pas assez de ressources, on ajuste le nombre d'elements
					if ($Count > $MaxElements) {
						$Count = $MaxElements;
					}
					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					if ($Count >= 1) {
						$CurrentPlanet['metal']          -= $Ressource['metal'];
						$CurrentPlanet['crystal']        -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
					}
				}
			}
		}
	}

	// -------------------------------------------------------------------------------------------------------
	// S'il n'y a pas de Chantier ...
	if ($CurrentPlanet[$resource[21]] == 0) {
		// Veuillez avoir l'obligeance de construire le Chantier Spacial !!
		message($lang['need_hangar'], $lang['tech'][21]);
	}

	// -------------------------------------------------------------------------------------------------------
	// Construction de la page du Chantier (car si j'arrive ici ... c'est que j'ai tout ce qu'il faut pour ...
	$TabIndex = 0;
	foreach($lang['tech'] as $Element => $ElementName) {
		if ($Element > 201 && $Element <= 399) {
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
				$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				$ElementCount        = $CurrentPlanet[$resource[$Element]];
				$ElementNbre         = ($ElementCount == 0) ? "" : " (".$lang['dispo'].": " . pretty_number($ElementCount) . ")";

				$PageTable .= "\n<tr>";
				$PageTable .= "<th class=l>";
				$PageTable .= "<a href=infos.".$phpEx."?gid=".$Element.">";
				$PageTable .= "<img border=0 src=\"".$dpath."gebaeude/".$Element.".gif\" align=top width=120 height=120></a>";
				$PageTable .= "</th>";

				$PageTable .= "<td class=l width='70%'>";
				$PageTable .= "<a href=infos.".$phpEx."?gid=".$Element.">".$ElementName."</a> ".$ElementNbre."<br>";
				$PageTable .= "".$lang['res']['descriptions'][$Element]."<br>";
				$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
				$PageTable .= ShowBuildTime($BuildOneElementTime);
				$PageTable .= "</td>";

				$PageTable .= "<th class=k width='10%'>";
				if ($CanBuildOne) {
					$TabIndex++;
					$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=8 maxlength=8 value=0 tabindex=".$TabIndex.">";
				}
				$PageTable .= "</th>";
				$PageTable .= "</tr>";
			}
		}
	}

	if ($CurrentPlanet['b_hangar_id'] != '') {
		$BuildQueue = ElementBuildListBox( $CurrentUser, $CurrentPlanet );
	}

	$parse = $lang;
	// La page se trouve dans $PageTable;
	$parse['buildlist']    = $PageTable;
	// Et la liste de constructions en cours dans $BuildQueue;
	$parse['buildinglist'] = $BuildQueue;
	$page .= parsetemplate(gettemplate('buildings_fleet'), $parse);

	display($page, $lang['Fleet']);
}
// Version History
// - 1.0 Modularisation
// - 1.1 Correction mise en place d'une limite max d'elements constructibles par ligne
//
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>