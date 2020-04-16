<?php

set_time_limit(360);

/*
All rights reserved
Code by MoF
Open-Source
*/

function getshipids ($array, $pricelist, $techs) {
	$return = array();

	foreach ($array as $id => $arrayx) {
		foreach ($arrayx as $schiffid => $arrays) {
			$anzahl = $arrays['anzahl'];

			for ($k = 0; $k < $anzahl; $k++) {
				$return['a'][$id . "|" . $schiffid . "|" . $k] = $id . "|" . $schiffid . "|" . $k;
				$return['c'][$id][$schiffid][$k] = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10 * (1 + ($techs[$id]['panzerung'] / 10)));
				$return['d'][$id][$schiffid][$k] = ($pricelist[$schiffid]['shield'] + $pricelist[$schiffid]['shield'] * $techs[$id]['schilde'] / 10);
			}

			$return['b'][$id][$schiffid] = $schiffid;
		}
	}

	return $return;
}

function DoppelteWerteEntfernen($AlterArray) {
	$AlterArray = array_unique($AlterArray);
	$i = 0;

	foreach($AlterArray as $Wert) {
		$NeuerArray[$i] = $Wert;
		$i++;
	}

	return $NeuerArray;
}

function get_komplett_name ($id) {
	switch ($id) {
		case '401':
			$name = "Lanceur de Missille";
			break;
		case '402':
			$name = "Canon Magn&eacute;tique";
			break;
		case '403':
			$name = "Batterie Electromagn&eacute;tique";
			break;
		case '404':
			$name = "Canon de Gauss";
			break;
		case '405':
			$name = "Lanceur Ionique";
			break;
		case '406':
			$name = "Lanceur de plasma";
			break;
		case '407':
			$name = "Petit bouclier";
			break;
		case '408':
			$name = "Grand bouclier";
			break;
		default:
			$name = "N/A";
	}

	return $name;
}

function getnamebyid ($id) {
	switch ($id) {
		case '202':
			$name = "Petit Remorqeur";
			break;
		case '203':
			$name = "Gros Remorqeur";
			break;
		case '204':
			$name = "Intercepteur L&eacute;ger";
			break;
		case '205':
			$name = "Intercepteur Lourd";
			break;
		case '206':
			$name = "Corvette l&eacute;g&egrave;re";
			break;
		case '207':
			$name = "Corvette Lourde.";
			break;
		case '208':
			$name = "Colonisateur";
			break;
		case '209':
			$name = "Recycleur";
			break;
		case '210':
			$name = "Sonde d espionnage";
			break;
		case '211':
			$name = "Bombardier";
			break;
		case '212':
			$name = "Panneau solaire";
			break;
		case '213':
			$name = "Fr&eacute;gate Lourde";
			break;
		case '214':
			$name = "Vaisseau M&egrave;re";
			break;
		case '215':
			$name = "Schlachtkr.";
			break;
		case '401':
			$name = "Rak.";
			break;
		case '402':
			$name = "L.Laser";
			break;
		case '403':
			$name = "S.Laser";
			break;
		case '404':
			$name = "Gau&szlig;";
			break;
		case '405':
			$name = "Ion.W";
			break;
		case '406':
			$name = "Plasma";
			break;
		case '407':
			$name = "S.Kuppel";
			break;
		case '408':
			$name = "GS.Kuppel";
			break;
		default:
			$name = "N/A";
	}

	return $name;
}

function aks($angreifer_daten, $verteidiger_daten, $angreifer_schiffe, $verteidiger_schiffe, $angreifer_techniken, $verteidiger_techniken, $ressis, $pricelist) {
	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;
	// RapidFire Start
	$rapidfire = array(202 =>
		array(210 => 5,
			212 => 5
			),
		203 =>
		array(210 => 5,
			212 => 5
			),
		204 =>
		array(210 => 5,
			212 => 5
			),
		205 =>
		array(202 => 3,
			210 => 5,
			212 => 5

			),
		206 =>
		array(204 => 6,
			210 => 5,
			212 => 5,
			401 => 10
			),
		207 =>
		array(210 => 5,
			212 => 5
			),
		208 =>
		array(210 => 5,
			212 => 5
			),
		209 =>
		array(210 => 5,
			212 => 5
			),
		211 =>
		array(210 => 5,
			212 => 5,
			401 => 20,
			402 => 20,
			403 => 10,
			405 => 10
			),
		213 =>
		array(210 => 5,
			212 => 5,
			215 => 2,
			402 => 10
			),
		214 =>
		array(210 => 1250,
			212 => 1250,
			202 => 250,
			203 => 250,
			204 => 200,
			205 => 100,
			206 => 33,
			207 => 30,
			208 => 250,
			209 => 250,
			211 => 25,
			213 => 5,
			215 => 15,
			401 => 200,
			402 => 200,
			403 => 100,
			404 => 50,
			405 => 100
			),
		215 =>
		array(202 => 3,
			203 => 3,
			205 => 4,
			206 => 4,
			207 => 7,
			210 => 5,
			212 => 5
			)
		);
	// RapidFire ende

	function pretty_number($n, $floor = true) {
		if ($floor) {
			$n = floor($n);
		}
		return number_format($n, 0, ",", ".");
	}

	$runde = array();
	$angreifer_schilde = array();
	$verteidiger_schilde = array();

	$angreifer_huelle = array();
	$verteidiger_huelle = array();

	$angreifer_schiffe_start = $angreifer_schiffe;

	$verteidiger_schiffe_start = $verteidiger_schiffe;

	foreach ($angreifer_schiffe as $id => $arrayx) {
		foreach ($arrayx as $schiffid => $array) {
			$anzahl = $array['anzahl'];

			for ($i = 0; $i < $anzahl; $i++) {
				$angreifer_huelle[$id][$schiffid][$i] = ((($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10) * (1 + ($angreifer_techniken[$id]['panzerung'] / 10)));
			}
		}
	}

	foreach ($verteidiger_schiffe as $schiffid => $arrayx) {
		foreach ($arrayx as $schiffid => $array) {
			$anzahl = $array['anzahl'];

			for ($i = 0; $i < $anzahl; $i++) {
				$verteidiger_huelle[$id][$schiffid][$i] = ((($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10) * (1 + ($verteidiger_techniken[$id]['panzerung'] / 10)));
			}
		}
	}

	$initialisierung = array();

	foreach ($angreifer_schiffe as $id => $arrayx) {
		foreach ($arrayx as $schiffid => $array) {
			$initialisierung['angreifer']['waffen'][$id][$schiffid] = ($pricelist[$schiffid]['attack'] + $pricelist[$schiffid]['attack'] * ($angreifer_techniken[$id]['waffen'] / 10));
			$initialisierung['angreifer']['huelle'][$id][$schiffid] = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10 * (1 + ($angreifer_techniken[$id]['panzerung'] / 10)));
			$initialisierung['angreifer']['schilde'][$id][$schiffid] = ($pricelist[$schiffid]['shield'] + $pricelist[$schiffid]['shield'] * $angreifer_techniken[$id]['schilde'] / 10);
		}
	}

	foreach ($verteidiger_schiffe as $id => $arrayx) {
		foreach ($arrayx as $schiffid => $array) {
			$initialisierung['verteidiger']['waffen'][$id][$schiffid] = ($pricelist[$schiffid]['attack'] + $pricelist[$schiffid]['attack'] * ($verteidiger_techniken[$id]['waffen'] / 10));
			$initialisierung['verteidiger']['huelle'][$id][$schiffid] = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) / 10 * (1 + ($verteidiger_techniken[$id]['panzerung'] / 10)));
			$initialisierung['verteidiger']['schilde'][$id][$schiffid] = ($pricelist[$schiffid]['shield'] + $pricelist[$schiffid]['shield'] * $verteidiger_techniken[$id]['schilde'] / 10);
		}
	}

	$parse = getshipids($angreifer_schiffe, $pricelist, $angreifer_techniken);
	$angreifer_huelle = $parse['c'];

	$parse = getshipids($verteidiger_schiffe, $pricelist, $verteidiger_techniken);
	$verteidiger_huelle = $parse['c'];

	$endrunde = 0;

	for ($i = 1; $i < 8; $i++) {
		// $i = runde
		$zufall_angreifer = array();
		$zufall_verteidiger = array();

		$parse = getshipids($angreifer_schiffe, $pricelist, $angreifer_techniken);
		$zufall_angreifer['a'] = $parse['a'];
		$angreifer_schilde = $parse['d'];

		$parse = getshipids($verteidiger_schiffe, $pricelist, $verteidiger_techniken);
		$zufall_verteidiger['a'] = $parse['a'];
		$verteidiger_schilde = $parse['d'];

		$runde[$i]['angreifer']['schiffe'] = $angreifer_schiffe;
		$runde[$i]['angreifer']['schilde_weg'] = 0;
		$runde[$i]['angreifer']['schuesse'] = 0;
		$runde[$i]['angreifer']['schusskraft'] = 0;

		$runde[$i]['verteidiger']['schiffe'] = $verteidiger_schiffe;
		$runde[$i]['verteidiger']['schilde_weg'] = 0;
		$runde[$i]['verteidiger']['schuesse'] = 0;
		$runde[$i]['verteidiger']['schusskraft'] = 0;
		$endrunde++;

		if (count($zufall_verteidiger['a']) == 0 || count($zufall_angreifer['a']) == 0) {
			$endrunde = $i;
			$killed = 1;

			if (count($zufall_verteidiger['a']) == 0 && count($zufall_angreifer['a']) == 0) {
				$ausgang = 1; // = Unentscheiden
			} elseif (count($zufall_verteidiger['a']) == 0) {
				$ausgang = 2; // = Angreifer

			} elseif (count($zufall_angreifer['a']) == 0) {
				$ausgang = 3; // = Verteidiger

			}
			break;
		}

		$delete_angreifer = array();
		$delete_verteidiger = array();

		foreach ($runde[$i]['angreifer']['schiffe'] as $id => $arrayx) {
			foreach ($arrayx as $schiffid => $array) {
				$anzahl = $array['anzahl'];

				for ($j = 0; $j < $anzahl; $j++) {
					$rapidfire_anzahl = 0;

					$fire = true;

					while ($fire == true) {
						$fire = false;

						$schuss_auf_huelle = 0;
						$rapidfire_vs = 0;
						$ship_rapidfire = false;

						$temp = array();
						$ids = array();

						if (count($zufall_verteidiger['a']) == 0) {
							$killed1 = 1;
						}

						if ($killed1 != 1) {
							foreach ($zufall_verteidiger['a'] as $xid => $array) {
								$explode = explode("|", $xid);
								$xid = $explode[0];
								$shipid = $explode[1];

								$ids[$xid] = $xid;

								$temp[$xid][$shipid] = $shipid;
							}

							sort($ids);

							foreach ($ids as $idx) {
								if (count($temp[$idx]) <= 0) {
									unset($zufall_verteidiger['a'][$idx]);
								}
							}

							srand((float) microtime() * 10000000);

							$rand = @array_rand($zufall_verteidiger['a']);
							$explode = explode("|", $rand);
							$schuss_nach_id2 = $explode[0];
							$schuss_nach_id = $explode[1];
							$selected_ships = $zufall_verteidiger['a'][$rand];

							$zufall = $explode[2];
							$selected_ship = $explode[2];
						}

						$feuerkraft = ($pricelist[$schiffid]['attack'] + $pricelist[$schiffid]['attack'] * ($angreifer_techniken[$id]['waffen'] / 10));

						$runde[$i]['angreifer']['schuesse']++;

						$runde[$i]['angreifer']['schusskraft'] += $feuerkraft;

						if ($killed1 != 1) {
							$schiffschilde = $verteidiger_schilde[$schuss_nach_id2][$schuss_nach_id][$selected_ship];

							if ($feuerkraft <= ($initialisierung['verteidiger']['schilde'][$schuss_nach_id2][$schuss_nach_id] / 100)) {
								$runde[$i]['verteidiger']['schilde_weg'] += $feuerkraft;
								$schuss_auf_huelle = 0;
							} else {
								if ($feuerkraft > $schiffschilde) {
									$runde[$i]['verteidiger']['schilde_weg'] += $schiffschilde;
									$verteidiger_schilde[$schuss_nach_id2][$schuss_nach_id][$selected_ship] = 0;

									$schuss_auf_huelle = ($feuerkraft - $schiffschilde);
								} else {
									$schuss_auf_huelle = 0;
									$verteidiger_schilde[$schuss_nach_id2][$schuss_nach_id][$selected_ship] -= $feuerkraft;
									$runde[$i]['verteidiger']['schilde_weg'] += $feuerkraft;
								}

								if ($schuss_auf_huelle > 0) {
									$verteidiger_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] -= $feuerkraft;

									if ($verteidiger_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] <= 0) {
										$delete_verteidiger[] = $rand . "*XXXX*" . $schuss_nach_id . "*XXXX*" . $schuss_nach_id2;
										$rapidfire_vs = $schuss_nach_id;
										$ship_rapidfire = true;
									} else {
										if ($verteidiger_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] < 0)
											$verteidiger_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] = 0;

										unset($huelle_start);
										unset($prozent);
										unset($einprozent);

										$huelle_start = $initialisierung['verteidiger']['huelle'][$schuss_nach_id2][$schuss_nach_id];

										$einprozent = ($huelle_start / 100);

										$prozent = (100 - round($verteidiger_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] / $einprozent));

										$zufall = mt_rand(1, 100);

										if ($prozent >= 30) {
											if ($prozent <= $zufall) {
												$delete_verteidiger[] = $rand . "*XXXX*" . $schuss_nach_id . "*XXXX*" . $schuss_nach_id2;

												$rapidfire_vs = $schuss_nach_id;

												$ship_rapidfire = true;
											}
										}
									}
								}

								if ($ship_rapidfire) {
									if ($rapidfire[$schiffid][$rapidfire_vs] > 0 && $rapidfire_anzahl <= 1250) {
										$rapidfire_ = 100 * ($rapidfire[$schiffid][$rapidfire_vs] - 1) / $rapidfire[$schiffid][$rapidfire_vs];

										$zufall = mt_rand(1, 100);

										if ($zufall <= $rapidfire_) {
											$fire = true;
										}
									} else
										$fire = false;
								} else
									$fire = false;
							}
						}
					}
				}
			}
		}
		// ##############
		foreach ($runde[$i]['verteidiger']['schiffe'] as $id => $arrayx) {
			foreach ($arrayx as $schiffid => $array) {
				$anzahl = $array['anzahl'];

				for ($j = 0; $j < $anzahl; $j++) {
					$rapidfire_anzahl = 0;

					$fire = true;

					while ($fire == true) {
						$fire = false;

						$schuss_auf_huelle = 0;
						$rapidfire_vs = 0;
						$ship_rapidfire = false;

						$temp = array();
						$ids = array();

						if (count($zufall_angreifer['a']) == 0) {
							$killed1 = 1;
						}

						if ($killed1 != 1) {
							foreach ($zufall_angreifer['a'] as $xid => $array) {
								$explode = explode("|", $xid);
								$xid = $explode[0];
								$shipid = $explode[1];

								$ids[$xid] = $xid;

								$temp[$xid][$shipid] = $shipid;
							}

							sort($ids);

							foreach ($ids as $idx) {
								if (count($temp[$idx]) <= 0) {
									unset($zufall_angreifer['a'][$idx]);
								}
							}

							srand((float) microtime() * 10000000);

							$rand = @array_rand($zufall_angreifer['a']);
							$explode = explode("|", $rand);
							$schuss_nach_id2 = $explode[0];
							$schuss_nach_id = $explode[1];
							$selected_ships = $zufall_angreifer['a'][$rand];

							$zufall = $explode[2];
							$selected_ship = $explode[2];
						}

						$feuerkraft = ($pricelist[$schiffid]['attack'] + $pricelist[$schiffid]['attack'] * ($verteidiger_techniken[$id]['waffen'] / 10));

						$runde[$i]['verteidiger']['schuesse']++;

						$runde[$i]['verteidiger']['schusskraft'] += $feuerkraft;

						if ($killed1 != 1) {
							$schiffschilde = $angreifer_schilde[$schuss_nach_id2][$schuss_nach_id][$selected_ship];

							if ($feuerkraft <= ($initialisierung['angreifer']['schilde'][$schuss_nach_id2][$schuss_nach_id] / 100)) {
								$runde[$i]['angreifer']['schilde_weg'] += $feuerkraft;
								$schuss_auf_huelle = 0;
							} else {
								if ($feuerkraft > $schiffschilde) {
									$runde[$i]['angreifer']['schilde_weg'] += $schiffschilde;
									$angreifer_schilde[$schuss_nach_id2][$schuss_nach_id][$selected_ship] = 0;

									$schuss_auf_huelle = ($feuerkraft - $schiffschilde);
								} else {
									$schuss_auf_huelle = 0;
									$angreifer_schilde[$schuss_nach_id2][$schuss_nach_id][$selected_ship] -= $feuerkraft;
									$runde[$i]['angreifer']['schilde_weg'] += $feuerkraft;
								}

								if ($schuss_auf_huelle > 0) {
									$angreifer_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] -= $feuerkraft;

									if ($angreifer_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] <= 0) {
										$delete_angreifer[] = $rand . "*XXXX*" . $schuss_nach_id . "*XXXX*" . $schuss_nach_id2;
										$rapidfire_vs = $schuss_nach_id;
										$ship_rapidfire = true;
									} else {
										if ($angreifer_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] < 0)
											$angreifer_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] = 0;

										unset($huelle_start);
										unset($prozent);
										unset($einprozent);

										$huelle_start = $initialisierung['angreifer']['huelle'][$schuss_nach_id2][$schuss_nach_id];

										$einprozent = ($huelle_start / 100);

										$prozent = (100 - round($angreifer_huelle[$schuss_nach_id2][$schuss_nach_id][$selected_ship] / $einprozent));

										$zufall = mt_rand(1, 100);

										if ($prozent >= 30) {
											if ($prozent <= $zufall) {
												$delete_angreifer[] = $rand . "*XXXX*" . $schuss_nach_id . "*XXXX*" . $schuss_nach_id2;

												$rapidfire_vs = $schuss_nach_id;

												$ship_rapidfire = true;
											}
										}
									}
								}

								if ($ship_rapidfire) {
									if ($rapidfire[$schiffid][$rapidfire_vs] > 0 && $rapidfire_anzahl <= 1250) {
										$rapidfire_ = 100 * ($rapidfire[$schiffid][$rapidfire_vs] - 1) / $rapidfire[$schiffid][$rapidfire_vs];

										$zufall = mt_rand(1, 100);

										if ($zufall <= $rapidfire_) {
											$fire = true;
										}
									} else
										$fire = false;
								} else
									$fire = false;
							}
						}
					}
				}
			}
		}
		// #############
		$delete_verteidiger = DoppelteWerteEntfernen($delete_verteidiger);
		$delete_angreifer = DoppelteWerteEntfernen($delete_angreifer);

		if (count($delete_verteidiger) > 0) {
			foreach ($delete_verteidiger as $nummer => $inhalt) {
				$split = explode("*XXXX*", $inhalt);

				unset($zufall_verteidiger['a'][$split[0]]);
				$verteidiger_schiffe[$split[2]][$split[1]]['anzahl']--;
			}
		}

		if (count($delete_angreifer) > 0) {
			foreach ($delete_angreifer as $nummer => $inhalt) {
				$split = explode("*XXXX*", $inhalt);
				unset($zufall_angreifer['a'][$split[0]]);
				$angreifer_schiffe[$split[2]][$split[1]]['anzahl']--;
			}
		}

		if ($killed1 == 1 || $killed2 == 1)
			$killed = 1;
	}

	$ausgabe = '<html>
<HEAD>
<LINK rel="stylesheet" type="text/css" href="http://mysqldb2.my.funpic.de/formate.css">
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
  <TITLE>Notizen</TITLE>
</HEAD>
<BODY>
<div id="overDiv"></div>
<table width="99%">
   <tr>
    <td>
	Folgende Flotten stehen sich um ' . date("m-d H:i:s") . ' gegen&uuml;ber:
	<br>
';

	$runde_id = 0;

	$return_angreifer = array();
	$return_verteidiger = array();

	foreach ($runde as $rundeid) {
		$runde_id++;

		$angreifer = $rundeid['angreifer'];
		$verteidiger = $rundeid['verteidiger'];

		$angreifer_komplettvernichtet = true;
		$angreifer_nicht_vernichtet = array();

		$verteidiger_komplettvernichtet = true;
		$verteidiger_nicht_vernichtet = array();

		foreach ($angreifer as $types => $array) {
			if ($types == "schiffe") {
				for ($i = 1; $i <= count($array); $i++) {
					$return_angreifer[$runde_id][$i]['typ'] = "<th>Typ</th>";
					$return_angreifer[$runde_id][$i]['anz'] = "<th>Anz.</th>";
					$return_angreifer[$runde_id][$i]['waffen'] = "<th>Bewaff.</th>";
					$return_angreifer[$runde_id][$i]['schilde'] = "<th>Schilde</th>";
					$return_angreifer[$runde_id][$i]['huelle'] = "<th>H&uuml;lle</th>";
				}

				foreach ($array as $id => $schiffe) {
					foreach ($schiffe as $schiffid => $xarray) {
						$anzahl = $xarray['anzahl'];

						if (!empty($anzahl)) {
							$angreifer_komplettvernichtet = false;
							$angreifer_nicht_vernichtet[$runde_id][$id] = true;

							$return_angreifer[$runde_id][$id]['typ'] .= "<th>" . getnamebyid($schiffid) . "</th>";
							$return_angreifer[$runde_id][$id]['anz'] .= "<th>" . pretty_number($anzahl) . "</th>";
							$return_angreifer[$runde_id][$id]['waffen'] .= "<th>" . pretty_number($initialisierung['angreifer']['waffen'][$id][$schiffid]) . "</th>";
							$return_angreifer[$runde_id][$id]['schilde'] .= "<th>" . pretty_number($initialisierung['angreifer']['schilde'][$id][$schiffid]) . "</th>";
							$return_angreifer[$runde_id][$id]['huelle'] .= "<th>" . pretty_number($initialisierung['angreifer']['huelle'][$id][$schiffid]) . "</th>";
						}
					}
				}
			}
		}

		foreach ($verteidiger as $types => $array) {
			if ($types == "schiffe") {
				for ($i = 1; $i <= count($array); $i++) {
					$return_verteidiger[$runde_id][$i]['typ'] = "<th>Typ</th>";
					$return_verteidiger[$runde_id][$i]['anz'] = "<th>Anz.</th>";
					$return_verteidiger[$runde_id][$i]['waffen'] = "<th>Bewaff.</th>";
					$return_verteidiger[$runde_id][$i]['schilde'] = "<th>Schilde</th>";
					$return_verteidiger[$runde_id][$i]['huelle'] = "<th>H&uuml;lle</th>";
				}

				foreach ($array as $id => $schiffe) {
					foreach ($schiffe as $schiffid => $xarray) {
						$anzahl = $xarray['anzahl'];

						if (!empty($anzahl)) {
							$verteidiger_komplettvernichtet = false;
							$verteidiger_nicht_vernichtet[$runde_id][$id] = true;

							$return_verteidiger[$runde_id][$id]['typ'] .= "<th>" . getnamebyid($schiffid) . "</th>";
							$return_verteidiger[$runde_id][$id]['anz'] .= "<th>" . pretty_number($anzahl) . "</th>";
							$return_verteidiger[$runde_id][$id]['waffen'] .= "<th>" . pretty_number($initialisierung['verteidiger']['waffen'][$id][$schiffid]) . "</th>";
							$return_verteidiger[$runde_id][$id]['schilde'] .= "<th>" . pretty_number($initialisierung['verteidiger']['schilde'][$id][$schiffid]) . "</th>";
							$return_verteidiger[$runde_id][$id]['huelle'] .= "<th>" . pretty_number($initialisierung['verteidiger']['huelle'][$id][$schiffid]) . "</th>";
						}
					}
				}
			}
		}

		$ausgabe .= "
	<table border=1 width=100%>
		<tr>";

		for ($i = 1; $i <= count($return_angreifer[$runde_id]); $i++) {
			$ausgabe .= "
			<th>
				<br>
				<center>
					Angreifer " . $angreifer_daten[$i]['name'] . " (" . $angreifer_daten[$i]['koords'] . ")";
			if ($runde_id == 1) {
				$ausgabe .= "
					<br>
					Waffen: " . ($angreifer_techniken[$i]['waffen'] * 10) . "% Schilde: " . ($angreifer_techniken[$i]['schilde'] * 10) . "% H&uuml;lle: " . ($angreifer_techniken[$i]['panzerung'] * 10) . "%";
			}

			if ($angreifer_nicht_vernichtet[$runde_id][$i]) {
				$ausgabe .= "<table border=1>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_angreifer[$runde_id][$i]['typ'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_angreifer[$runde_id][$i]['anz'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_angreifer[$runde_id][$i]['waffen'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_angreifer[$runde_id][$i]['schilde'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_angreifer[$runde_id][$i]['huelle'];
				$ausgabe .= "</tr>";

				$ausgabe .= "</table>";
			} else {
				$ausgabe .= "<br>
			Vernichtet";
			}

			$ausgabe .= "
				</center>
			</th>";
		}

		$ausgabe .= "
		</tr></table>";

		$ausgabe .= "
	<table border=1 width=100%>
		<tr>";

		for ($i = 1; $i <= count($return_verteidiger[$runde_id]); $i++) {
			$ausgabe .= "
			<th>
				<br>
				<center>
					Verteidiger " . $verteidiger_daten[$i]['name'] . " (" . $verteidiger_daten[$i]['koords'] . ")";
			if ($runde_id == 1) {
				$ausgabe .= "
					<br>
					Waffen: " . ($verteidiger_techniken[$i]['waffen'] * 10) . "% Schilde: " . ($verteidiger_techniken[$i]['schilde'] * 10) . "% H&uuml;lle: " . ($verteidiger_techniken[$i]['panzerung'] * 10) . "%";
			}

			if ($verteidiger_nicht_vernichtet[$runde_id][$i]) {
				$ausgabe .= "<table border=1>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_verteidiger[$runde_id][$i]['typ'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_verteidiger[$runde_id][$i]['anz'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_verteidiger[$runde_id][$i]['waffen'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_verteidiger[$runde_id][$i]['schilde'];
				$ausgabe .= "</tr>";
				$ausgabe .= "<tr>";
				$ausgabe .= $return_verteidiger[$runde_id][$i]['huelle'];
				$ausgabe .= "</tr>";

				$ausgabe .= "</table>";
			} else {
				$ausgabe .= "<br>Vernichtet";
			}

			$ausgabe .= "
				</center>
			</th>";
		}

		$ausgabe .= "
		</tr>
	</table>";

		if (!$verteidiger_komplettvernichtet && !$angreifer_komplettvernichtet) {
			$ausgabe .= "
	<br>
	<center>
		Die angreifende Flotte schie&szlig;t insgesamt <b>" . pretty_number($runde[$runde_id]['angreifer']['schuesse']) . "</b> mal mit Gesamtst&auml;rke <b>" . pretty_number($runde[$runde_id]['angreifer']['schusskraft']) . "</b> auf den Verteidiger.
		Die Schilde des Verteidigers absorbieren <b>" . pretty_number($runde[$runde_id]['verteidiger']['schilde_weg']) . "</b> Schadenspunkte
		<br>
		Die verteidigende Flotte schie&szlig;t insgesamt <b>" . pretty_number($runde[$runde_id]['verteidiger']['schuesse']) . "</b> mal mit Gesamtst&auml;rke <b>" . pretty_number($runde[$runde_id]['verteidiger']['schusskraft']) . "</b> auf den Angreifer.
		Die Schilde des Angreifers absorbieren <b>" . pretty_number($runde[$runde_id]['angreifer']['schilde_weg']) . "</b> Schadenspunkte
	</center>";
		} else {
			if ($verteidiger_komplettvernichtet) {
				$ausgang = "angreifer";
			} elseif ($angreifer_komplettvernichtet) {
				$ausgang = "verteidiger";
			} else {
				$ausgang = "unentschieden";
			}
		}
	}

	if ($ausgang == "angreifer") {
		$ausgabe .= "
	<p>Der Angreifer die Schlacht gewonnen!
	<br>
			";

		$angreifer_kapazitaet = array();
		$angreifer_gesamt_kapazitaet = 0;

		foreach ($angreifer_schiffe as $id => $arrayx) {
			foreach ($arrayx as $schiffid => $array) {
				$anzahl = $array['anzahl'];

				$angreifer_kapazitaet[$id] += ($pricelist[$schiffid]['capacity'] * $anzahl);
				$angreifer_gesamt_kapazitaet += ($pricelist[$schiffid]['capacity'] * $anzahl);
			}
		}

		$max_metall = floor($ressis['metall'] / 2);
		$max_kristall = floor($ressis['kristall'] / 2);
		$max_deut = floor($ressis['deuterium'] / 2);

		$einprozent = ($angreifer_gesamt_kapazitaet / 100);

		$angreifer_beute_metall = 0;
		$angreifer_beute_kristall = 0;
		$angreifer_beute_deuterium = 0;

		$angreifer_beute = array();

		$anzahl = count($angreifer_kapazitaet);

		foreach ($angreifer_kapazitaet as $id => $kapazitaet) {
			$prozent = (($kapazitaet / 100) / ($angreifer_gesamt_kapazitaet / 100) * 100);

			$max_metall_user = (($max_metall / 100) * $prozent);
			$max_kristall_user = (($max_kristall / 100) * $prozent);
			$max_deut_user = (($max_deut / 100) * $prozent);

			if (!empty($max_metall_user) && $max_metall_user < 1) {
				$max_metall_user = 1;
			} else {
				$max_metall_user = floor($max_metall_user);
			}

			if (!empty($max_kristall_user) && $max_kristall_user < 1) {
				$max_kristall_user = 1;
			} else {
				$max_kristall_user = floor($max_kristall_user);
			}

			if (!empty($max_deut_user) && $max_deut_user < 1) {
				$max_deut_user = 1;
			} else {
				$max_deut_user = floor($max_deut_user);
			}

			if (($max_metall_user + $max_kristall_user + $max_deut_user) >= $kapazitaet) {
				$angreifer_beute[$id]['metall'] += $max_metall_user;
				$angreifer_beute[$id]['kristall'] += $max_kristall_user;
				$angreifer_beute[$id]['deut'] += $max_deut_user;

				$angreifer_beute_metall += $max_metall_user;
				$angreifer_beute_kristall += $max_kristall_user;
				$angreifer_beute_deuterium += $max_deut_user;
			} else {
				$drittel = ($kapazitaet / 3);

				if ($drittel <= $max_metall_user) {
					$angreifer_beute[$id]['metall'] += $drittel;
					$angreifer_beute_metall += $drittel;
				} else {
					$angreifer_beute[$id]['metall'] += $max_metall_user;
					$angreifer_beute_metall += $max_metall_user;
				}

				if ($drittel <= $max_kristall_user) {
					$angreifer_beute[$id]['kristall'] += $drittel;
					$angreifer_beute_kristall += $drittel;
				} else {
					$angreifer_beute[$id]['kristall'] += $max_kristall_user;
					$angreifer_beute_kristall += $max_kristall_user;
				}

				if ($drittel <= $max_deut_user) {
					$angreifer_beute[$id]['deut'] += $drittel;
					$angreifer_beute_deuterium += $drittel;
				} else {
					$angreifer_beute[$id]['deut'] += $max_deut_user;
					$angreifer_beute_deuterium += $max_deut_user;
				}
			}
		}

		$ausgabe .= "
	Er erbeutet<br><b>" . pretty_number($angreifer_beute_metall) . "</b> Metall, <b>" . pretty_number($angreifer_beute_kristall) . "</b> Kristall und <b>" . pretty_number($angreifer_beute_deuterium) . "</b> Deuterium
	<br>";
	} elseif ($angreifer_komplettvernichtet) {
		$ausgang = "verteidiger";
	} else {
		$ausgang = "unentschieden";
	}

	$units_angreifer_start = 0;
	$units_angreifer_end = 0;

	$units_verteidiger_start = 0;
	$units_verteidiger_end = 0;

	$verlusteangreifer_schiffe = array();
	$verlusteverteidiger_schiffe = array();

	$verluste_verteidigung = array();

	foreach ($angreifer_schiffe_start as $id => $array) {
		foreach ($array as $schiffid => $arrayx) {
			$anzahl = $arrayx['anzahl'];

			$units = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) * $anzahl);
			$units_angreifer_start += $units;

			$verlusteangreifer_schiffe[$schiffid] += $anzahl;
		}
	}

	$fleet_array = array();
	$angr_schiffe = 0;
	if (count($angreifer_schiffe) > 0) {
		foreach ($angreifer_schiffe as $id => $array) {
			foreach ($array as $schiffid => $arrayx) {
				$anzahl = $arrayx['anzahl'];

				$units = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) * $anzahl);
				$units_angreifer_end += $units;

				$verlusteangreifer_schiffe[$schiffid] -= $anzahl;

				$fleet_array[$id] .= $schiffid . "," . $anzahl . ";";
				$angr_schiffe ++;
			}
		}
	}

	if (count($verteidiger_schiffe_start) > 0) {
		foreach ($verteidiger_schiffe_start as $id => $array) {
			foreach ($array as $schiffid => $arrayx) {
				$anzahl = $arrayx['anzahl'];

				$units = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) * $anzahl);
				$units_verteidiger_start += $units;

				$verlusteverteidiger_schiffe[$schiffid] += $anzahl;
			}
		}
	}

	if (count($verteidiger_schiffe) > 0) {
		foreach ($verteidiger_schiffe as $id => $array) {
			foreach ($array as $schiffid => $arrayx) {
				$anzahl = $arrayx['anzahl'];

				$units = (($pricelist[$schiffid]['metal'] + $pricelist[$schiffid]['crystal']) * $anzahl);
				$units_verteidiger_end += $units;

				$verlusteverteidiger_schiffe[$schiffid] -= $anzahl;
			}
		}
	}

	$metall = 0;
	$kristall = 0;

	if (count($verlusteverteidiger_schiffe) > 0) {
		foreach ($verlusteverteidiger_schiffe as $schiffid => $anzahl) {
			if ($anzahl > 0 && $schiffid < 400) {
				$metall += (($pricelist[$schiffid]['metal'] * 0.3) * $anzahl);
				$kristall += (($pricelist[$schiffid]['crystal'] * 0.3) * $anzahl);
			} elseif ($schiffid > 400 && $schiffid < 500) {
				$verluste_verteidigung[$schiffid] += $anzahl;
			}
		}
	}

	if (count($verlusteangreifer_schiffe) > 0) {
		foreach ($verlusteangreifer_schiffe as $schiffid => $anzahl) {
			if ($anzahl > 0 && $schiffid > 400 && $schiffid < 500) {
				$metall += (($pricelist[$schiffid]['metal'] * 0.3) * $anzahl);
				$kristall += (($pricelist[$schiffid]['crystal'] * 0.3) * $anzahl);
			}
		}
	}

	$repair = array();

	if (count($verlusteverteidiger_schiffe) > 0) {
		foreach ($verlusteverteidiger_schiffe as $schiffid => $anzahl) {
			if ($schiffid > 400 && $schiffid < 500) {
				for ($k = 0; $k < $anzahl; $k++) {
					$zufall = mt_rand(0, 100);

					if ($zufall <= 70) {
						$repair[$schiffid]++;
					} else {
						$return_delete[$schiffid]++;
					}
				}
			}
		}
	}

	$repairtext = "";

	$x = 0;
	$irgendwas = false;

	foreach ($repair as $schiffid => $anzahl) {
		$x++;
		$repairtext .= "<b>" . $anzahl . "</b> " . get_komplett_name($schiffid);

		if ($x < count($repair)) {
			$repairtext .= ", ";
			$irgendwas = true;
		} elseif ($x == count($repair)-1 && $irgendwas)
			$rapirtext .= " und ";

		$verteidiger_schiffe[$schiffid] += $anzahl;
	}

	$verluste_verteidiger = ($units_verteidiger_start - $units_verteidiger_end);
	$verluste_angreifer = ($units_angreifer_start - $units_angreifer_end);

	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$endtime = $mtime;

	$totaltime = round($endtime - $starttime, 5);

	$ausgabe_verteidiger .= $ausgabe . "
	<p>
	<br>
	Der Angreifer hat insgesamt " . pretty_number($verluste_angreifer) . " Units verloren.
	<br>
	Der Verteidiger hat insgesamt " . pretty_number($verluste_verteidiger) . " Units verloren.
	<br>
	Auf diesen Raumkoordinaten liegen nun <b>" . pretty_number($metall) . "</b> Metall und <b>" . pretty_number($kristall) . "</b> Kristall.
	<br>" . $repairtext . " liessen sich reparieren.
	<br><br>
	Der Server brauchte <b>" . $totaltime . "</b> Sekunden um den Kampf auszutragen!
    </td>

   </tr>
</table>
</BODY>
</html>";

	$ausgabe_angreifer .= $ausgabe . "
	<p>
	<br>
	Der Angreifer hat insgesamt " . pretty_number($verluste_angreifer) . " Units verloren.
	<br>
	Der Verteidiger hat insgesamt " . pretty_number($verluste_verteidiger) . " Units verloren.
	<br>
	Auf diesen Raumkoordinaten liegen nun <b>" . pretty_number($metall) . "</b> Metall und <b>" . pretty_number($kristall) . "</b> Kristall.
	<br><br>
	Der Server brauchte <b>" . $totaltime . "</b> Sekunden um den Kampf auszutragen!
    </td>

   </tr>
</table>
</BODY>
</html>";

	$hashes = array();
	$hashes['md5_angreifer'] = md5($ausgabe_angreifer);
	$hashes['sha1_angreifer'] = sha1($ausgabe_angreifer);
	$hashes['double_angreifer'] = $hashes['sha1_angreifer'] . $hashes['md5_angreifer'];

	$hashes['md5_verteidiger'] = md5($ausgabe_verteidiger);
	$hashes['sha1_verteidiger'] = sha1($ausgabe_verteidiger);
	$hashes['double_verteidiger'] = $hashes['sha1_verteidiger'] . $hashes['md5_verteidiger'];

	$return = array();
	$return['ausgabe_angreifer'] = $ausgabe_angreifer;
	$return['ausgabe_verteidger'] = $ausgabe_verteidiger;
	$return['angreifer_schiffe'] = $angreifer_schiffe;
	$return['verteidiger_schiffe'] = $verteidiger_schiffe;
	$return['hashes'] = $hashes;
	$return['delete'] = $return_delete;
	$return['tf'] = array("m" => $metall, "k" => $kristall);
	$return['units'] = array("a" => $verluste_angreifer, "v" => $verluste_verteidiger);
	$return['ausgang'] = $ausgang;
	$return['beute'] = $angreifer_beute;
	$return['endrunde'] = $endrunde;
	$return['fleet_amount'] = $angr_schiffe;
	$return['fleet_array'] = $fleet_array;

	return $return;
}

// aks(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$angreifer_schiffe =
array("1" =>
	array(214 => array("id" => 214,
			"anzahl" => 1000,
			)
		),
	"2" =>
	array(213 => array("id" => 213,
			"anzahl" => 1
			)
		)
	);

$verteidiger_schiffe =
array("1" =>
	array(213 => array("id" => 213,
			"anzahl" => 1
			)
		),
	"2" =>
	array(213 => array("id" => 213,
			"anzahl" => 10
			),
		401 => array("id" => 401,
			"anzahl" => 1
			),
		406 => array("id" => 406,
			"anzahl" => 1
			)
		),
	);

$angreifer_techniken =
array("1" =>
	array("waffen" => 1,
		"schilde" => 2,
		"panzerung" => 3
		),
	"2" =>
	array("waffen" => 3,
		"schilde" => 2,
		"panzerung" => 1
		)
	);

$angreifer_daten = array(1 => array("koords" => "1:1:1",
		"name" => "Test1",
		"id" => 1
		),
	2 => array("koords" => "1:1:2",
		"name" => "Test2",
		"id" => 2
		)
	);

$verteidiger_daten = array(1 => array("koords" => "1:1:3",
		"name" => "Test3",
		"id" => 1
		),
	2 => array("koords" => "1:1:4",
		"name" => "Test4",
		"id" => 2
		)
	);

$verteidiger_techniken =
array("1" =>
	array("waffen" => 1,
		"schilde" => 2,
		"panzerung" => 3
		),
	"2" =>
	array("waffen" => 1,
		"schilde" => 2,
		"panzerung" => 3
		)
	);

$ressis = array("metall" => 10010,
	"kristall" => 111,
	"deuterium" => 124);

$pricelist = array(

	1 => array('metal' => 60, 'crystal' => 15, 'deuterium' => 0, 'energy' => 0, 'factor' => 3 / 2),
	2 => array('metal' => 48, 'crystal' => 24, 'deuterium' => 0, 'energy' => 0, 'factor' => 1.6,),
	3 => array('metal' => 225, 'crystal' => 75, 'deuterium' => 0, 'energy' => 0, 'factor' => 3 / 2),
	4 => array('metal' => 75, 'crystal' => 30, 'deuterium' => 0, 'energy' => 0, 'factor' => 3 / 2),
	12 => array('metal' => 900, 'crystal' => 360, 'deuterium' => 180, 'energy' => 0, 'factor' => 1.8),
	14 => array('metal' => 400, 'crystal' => 120, 'deuterium' => 200, 'energy' => 0, 'factor' => 2),
	15 => array('metal' => 1000000, 'crystal' => 500000, 'deuterium' => 100000, 'energy' => 0, 'factor' => 2),
	21 => array('metal' => 400, 'crystal' => 200, 'deuterium' => 100, 'energy' => 0, 'factor' => 2),
	22 => array('metal' => 2000, 'crystal' => 0, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	23 => array('metal' => 2000, 'crystal' => 1000, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	24 => array('metal' => 2000, 'crystal' => 2000, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	31 => array('metal' => 200, 'crystal' => 400, 'deuterium' => 200, 'energy' => 0, 'factor' => 2),
	33 => array('metal' => 0, 'crystal' => 50000, 'deuterium' => 100000, 'energy' => 1000, 'factor' => 2),
	34 => array('metal' => 20000, 'crystal' => 40000, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	44 => array('metal' => 20000, 'crystal' => 20000, 'deuterium' => 1000, 'energy' => 0, 'factor' => 2),

	106 => array('metal' => 200, 'crystal' => 1000, 'deuterium' => 200, 'energy' => 0, 'factor' => 2),
	108 => array('metal' => 0, 'crystal' => 400, 'deuterium' => 600, 'energy' => 0, 'factor' => 2),
	109 => array('metal' => 800, 'crystal' => 200, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	110 => array('metal' => 200, 'crystal' => 600, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	111 => array('metal' => 1000, 'crystal' => 0, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	113 => array('metal' => 0, 'crystal' => 800, 'deuterium' => 400, 'energy' => 0, 'factor' => 2),
	114 => array('metal' => 0, 'crystal' => 4000, 'deuterium' => 2000, 'energy' => 0, 'factor' => 2),
	115 => array('metal' => 400, 'crystal' => 0, 'deuterium' => 600, 'energy' => 0, 'factor' => 2),
	117 => array('metal' => 2000, 'crystal' => 4000, 'deuterium' => 6000, 'energy' => 0, 'factor' => 2),
	118 => array('metal' => 10000, 'crystal' => 20000, 'deuterium' => 6000, 'energy' => 0, 'factor' => 2),
	120 => array('metal' => 200, 'crystal' => 100, 'deuterium' => 0, 'energy' => 0, 'factor' => 2),
	121 => array('metal' => 1000, 'crystal' => 300, 'deuterium' => 100, 'energy' => 0, 'factor' => 2),
	122 => array('metal' => 2000, 'crystal' => 4000, 'deuterium' => 1000, 'energy' => 0, 'factor' => 2),
	123 => array('metal' => 240000, 'crystal' => 400000, 'deuterium' => 160000, 'energy' => 0, 'factor' => 2),
	199 => array('metal' => 0, 'crystal' => 0, 'deuterium' => 0, 'energy_max' => 300000, 'factor' => 3),

	202 => array('metal' => 2000, 'crystal' => 2000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'consumption' => 20, 'speed' => 5000, 'capacity' => 5000, 'shield' => 10, 'attack' => 5, 'sd' => array(210 => 5, 212 => 5)),
	203 => array('metal' => 6000, 'crystal' => 6000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'consumption' => 50, 'speed' => 7500, 'capacity' => 25000, 'shield' => 25, 'attack' => 5, 'sd' => array(210 => 5, 212 => 5)),
	204 => array('metal' => 3000, 'crystal' => 1000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'consumption' => 20, 'speed' => 12500, 'capacity' => 50, 'shield' => 10, 'attack' => 50, 'sd' => array(210 => 5, 212 => 5)),
	205 => array('metal' => 6000, 'crystal' => 4000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'consumption' => 75, 'speed' => 10000, 'capacity' => 100, 'shield' => 25, 'attack' => 150, 'sd' => array(210 => 5, 212 => 5, 202 => 3)),
	206 => array('metal' => 20000, 'crystal' => 7000, 'deuterium' => 2000, 'energy' => 0, 'factor' => 1, 'consumption' => 300, 'speed' => 15000, 'capacity' => 800, 'shield' => 50, 'attack' => 400, 'sd' => array(210 => 5, 212 => 5, 204 => 6, 401 => 10)),
	207 => array('metal' => 45000, 'crystal' => 15000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'consumption' => 500, 'speed' => 10000, 'capacity' => 1500, 'shield' => 200, 'attack' => 1000, 'sd' => array(210 => 5, 212 => 5)),
	208 => array('metal' => 10000, 'crystal' => 20000, 'deuterium' => 10000, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'speed' => 2500, 'capacity' => 7500, 'shield' => 100, 'attack' => 50, 'sd' => array(210 => 5, 212 => 5)),
	209 => array('metal' => 10000, 'crystal' => 6000, 'deuterium' => 2000, 'energy' => 0, 'factor' => 1, 'consumption' => 300, 'speed' => 2000, 'capacity' => 20000, 'shield' => 10, 'attack' => 1, 'sd' => array(210 => 5, 212 => 5)),
	210 => array('metal' => 0, 'crystal' => 1000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'consumption' => 1, 'speed' => 100000000, 'capacity' => 5, 'shield' => 0, 'attack' => 0, 'sd' => array(210 => 0)),
	211 => array('metal' => 50000, 'crystal' => 25000, 'deuterium' => 15000, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'speed' => 4000, 'capacity' => 500, 'shield' => 500, 'attack' => 1000, 'sd' => array(210 => 5, 212 => 5, 401 => 20, 402 => 20, 403 => 10, 405 => 10)),
	212 => array('metal' => 0, 'crystal' => 2000, 'deuterium' => 500, 'energy' => 0, 'factor' => 1, 'shield' => 10, 'attack' => 5, 'attack' => 1, 'sd' => array(212 => 0)),
	213 => array('metal' => 60000, 'crystal' => 50000, 'deuterium' => 15000, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'speed' => 5000, 'capacity' => 2000, 'shield' => 500, 'attack' => 2000, 'sd' => array(210 => 5, 212 => 5, 402 => 10, 215 => 2)),
	214 => array('metal' => 5000000, 'crystal' => 4000000, 'deuterium' => 1000000, 'energy' => 0, 'factor' => 1, 'consumption' => 100, 'speed' => 100, 'capacity' => 1000000, 'shield' => 50000, 'attack' => 200000, 'sd' => array(210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 => 33, 207 => 30, 208 => 250, 209 => 250, 211 => 25, 215 => 15, 401 => 200, 402 => 200, 403 => 100, 404 => 50, 405 => 100)),
	215 => array('metal' => 30000, 'crystal' => 40000, 'deuterium' => 15000, 'energy' => 0, 'factor' => 1, 'consumption' => 250, 'speed' => 10000, 'capacity' => 750, 'shield' => 400, 'attack' => 700, 'sd' => array(210 => 5, 212 => 5, 202 => 3, 203 => 3, 205 => 4, 206 => 4, 207 => 7)),

	401 => array('metal' => 2000, 'crystal' => 0, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 20, 'attack' => 80, 'sd' => array(401 => 0)),
	402 => array('metal' => 1500, 'crystal' => 500, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 25, 'attack' => 100, 'sd' => array(402 => 0)),
	403 => array('metal' => 6000, 'crystal' => 2000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 100, 'attack' => 250, 'sd' => array(403 => 0)),
	404 => array('metal' => 20000, 'crystal' => 15000, 'deuterium' => 2000, 'energy' => 0, 'factor' => 1, 'shield' => 200, 'attack' => 1100, 'sd' => array(404 => 0)),
	405 => array('metal' => 2000, 'crystal' => 6000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 500, 'attack' => 150, 'sd' => array(405 => 0)),
	406 => array('metal' => 50000, 'crystal' => 50000, 'deuterium' => 30000, 'energy' => 0, 'factor' => 1, 'shield' => 300, 'attack' => 3000, 'sd' => array(406 => 0)),
	407 => array('metal' => 10000, 'crystal' => 10000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 2000, 'attack' => 1, 'sd' => array(407 => 0)),
	408 => array('metal' => 50000, 'crystal' => 50000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 2000, 'attack' => 1, 'sd' => array(408 => 0)),

	502 => array('metal' => 8000, 'crystal' => 2000, 'deuterium' => 0, 'energy' => 0, 'factor' => 1, 'shield' => 1, 'attack' => 1),
	503 => array('metal' => 12500, 'crystal' => 2500, 'deuterium' => 10000, 'energy' => 0, 'factor' => 1, 'shield' => 1, 'attack' => 12000),

	41 => array('metal' => 20000, 'crystal' => 40000, 'deuterium' => 20000, 'energy' => 0, 'factor' => 1),
	42 => array('metal' => 20000, 'crystal' => 40000, 'deuterium' => 20000, 'energy' => 0, 'factor' => 1),
	43 => array('metal' => 2000000, 'crystal' => 4000000, 'deuterium' => 2000000, 'energy' => 0, 'factor' => 1)

	);

$x = aks($angreifer_daten, $verteidiger_daten, $angreifer_schiffe, $verteidiger_schiffe, $angreifer_techniken, $verteidiger_techniken, $ressis, $pricelist);

print_r($x);

/*
All rights reserved
Code by MoF
Open-Source
*/

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>