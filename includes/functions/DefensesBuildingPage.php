<?php

/**
 * DefensesBuildingPage.php
 *
 * @version 1.2
 * @copyright 2008 By Chlorel for XNova
 */

function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $phpEx, $dpath, $_POST;

	if (isset($_POST['fmenge'])) {

		$Missiles[502] = $CurrentPlanet[ $resource[502] ];
		$Missiles[503] = $CurrentPlanet[ $resource[503] ];
		$SiloSize      = $CurrentPlanet[ $resource[44] ];
		$MaxMissiles   = $SiloSize * 10;

		$BuildQueue    = $CurrentPlanet['b_hangar_id'];
		$BuildArray    = explode (";", $BuildQueue);
		for ($QElement = 0; $QElement < count($BuildArray); $QElement++) {
			$ElmentArray = explode (",", $BuildArray[$QElement] );
			if       ($ElmentArray[502] != 0) {
				$Missiles[502] += $ElmentArray[502];
			} elseif ($ElmentArray[503] != 0) {
				$Missiles[503] += $ElmentArray[503];
			}
		}
		foreach($_POST['fmenge'] as $Element => $Count) {

			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}


			if ($Count != 0) {
				$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
				$IsBuild = ($CurrentPlanet[$resource[407]] >= 1) ? true : false;
				if ($Element == 407 || $Element == 408) {
					if ($InQueue === false && !$IsBuild) {
                        $Count = 1;
					}
				}

				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
					// On verifie combien on sait faire de cet element au max
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );

					// Testons si on a de la place pour ces nouveaux missiles !
					if ($Element == 502 || $Element == 503) {
						// Cas particulier des missiles
						$ActuMissiles  = $Missiles[502] + ( 2 * $Missiles[503] );
						$MissilesSpace = $MaxMissiles - $ActuMissiles;
						if ($Element == 502) {
							if ( $Count > $MissilesSpace ) {
								$Count = $MissilesSpace;
							}
						} else {
							if ( $Count > floor( $MissilesSpace / 2 ) ) {
								$Count = floor( $MissilesSpace / 2 );
							}
						}
						if ($Count > $MaxElements) {
							$Count = $MaxElements;
						}
						$Missiles[$Element] += $Count;
					} else {
						// Si pas assez de ressources, on ajuste le nombre d'elements
						if ($Count > $MaxElements) {
							$Count = $MaxElements;
						}
					}

					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					if ($Count >= 1) {
						$CurrentPlanet['metal']           -= $Ressource['metal'];
						$CurrentPlanet['crystal']         -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
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
	$TabIndex  = 0;
	$PageTable = "";
	foreach($lang['tech'] as $Element => $ElementName) {
		if ($Element > 400 && $Element <= 599) {
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
					$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
					$IsBuild = ($CurrentPlanet[$resource[407]] >= 1) ? true : false;
					$BuildIt = true;
					if ($Element == 407 || $Element == 408) {
                        $BuildIt = false;
						if ( $InQueue === false && !$IsBuild) {
							$BuildIt = true;
						}
					}
					if ( !$BuildIt ) {
						$PageTable .= "<font color=\"red\">".$lang['only_one']."</font>";
					} else {
						$TabIndex++;
						$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=8 maxlength=8 value=0 tabindex=".$TabIndex.">";
						$PageTable .= "</th>";
					}
				} else {
					$PageTable .= "</th>";
				}
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
	// fragmento de template
	$page .= parsetemplate(gettemplate('buildings_defense'), $parse);

	display($page, $lang['Defense']);

}
// Version History
// - 1.0 Modularisation
// - 1.1 Correction mise en place d'une limite max d'elements constructibles par ligne
// - 1.2 Correction limitation bouclier meme si en queue de fabrication
//
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>