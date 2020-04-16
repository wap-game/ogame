<?php

/**
 * marchand.php
 *
 * @version 1.2
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function ModuleMarchand ( $CurrentUser, &$CurrentPlanet ) {
	global $lang, $_POST;

	includeLang('marchand');
	
	$parse   = $lang;

	if ($_POST['ress'] != '') {
		$PageTPL   = gettemplate('message_body');
		$Error     = false;
		$CheatTry  = false;
		$Metal     = $_POST['metal'];
		$Crystal   = $_POST['cristal'];
		$Deuterium = $_POST['deut'];
		if ($Metal < 0) {
			$Metal     *= -1;
			$CheatTry   = true;
		}
		if ($Crystal < 0) {
			$Crystal   *= -1;
			$CheatTry   = true;
		}
		if ($Deuterium < 0) {
			$Deuterium *= -1;
			$CheatTry   = true;
		}
		if ($CheatTry  == false) {
			switch ($_POST['ress']) {
				case 'metal':
					$Necessaire   = (( $Crystal * 2) + ( $Deuterium * 4));
					if ($CurrentPlanet['metal'] > $Necessaire) {
						$CurrentPlanet['metal'] -= $Necessaire;
					} else {
						$Message = $lang['mod_ma_noten'] ." ". $lang['Metal'] ."! ";
						$Error   = true;
					}
					break;

				case 'cristal':
					$Necessaire   = (( $Metal * 0.5) + ( $Deuterium * 2));
					if ($CurrentPlanet['crystal'] > $Necessaire) {
						$CurrentPlanet['crystal'] -= $Necessaire;
					} else {
						$Message = $lang['mod_ma_noten'] ." ". $lang['Crystal'] ."! ";
						$Error   = true;
					}
					break;

				case 'deuterium':
					$Necessaire   = (( $Metal * 0.25) + ( $Crystal * 0.5));
					if ($CurrentPlanet['deuterium'] > $Necessaire) {
						$CurrentPlanet['deuterium'] -= $Necessaire;
					} else {
						$Message = $lang['mod_ma_noten'] ." ". $lang['Deuterium'] ."! ";
						$Error   = true;
					}
					break;
			}
		}
		if ($Error == false) {
			if ($CheatTry == true) {
				$CurrentPlanet['metal']      = 0;
				$CurrentPlanet['crystal']    = 0;
				$CurrentPlanet['deuterium']  = 0;
			} else {
				$CurrentPlanet['metal']     += $Metal;
				$CurrentPlanet['crystal']   += $Crystal;
				$CurrentPlanet['deuterium'] += $Deuterium;
			}

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = '".     $CurrentPlanet['metal']     ."', ";
			$QryUpdatePlanet .= "`crystal` = '".   $CurrentPlanet['crystal']   ."', ";
			$QryUpdatePlanet .= "`deuterium` = '". $CurrentPlanet['deuterium'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".        $CurrentPlanet['id']        ."';";
			doquery ( $QryUpdatePlanet , 'planets');
			$Message = $lang['mod_ma_done'];
		}
		if ($Error == true) {
			$parse['title'] = $lang['mod_ma_error'];
		} else {
			$parse['title'] = $lang['mod_ma_donet'];
		}
		$parse['mes']   = $Message;
	} else {
		if ($_POST['action'] != 2) {
			$PageTPL = gettemplate('marchand_main');
		} else {
			$parse['mod_ma_res']   = "1";
			switch ($_POST['choix']) {
				case 'metal':
					$PageTPL = gettemplate('marchand_metal');
					$parse['mod_ma_res_a'] = "2";
					$parse['mod_ma_res_b'] = "4";
					break;
				case 'cristal':
					$PageTPL = gettemplate('marchand_cristal');
					$parse['mod_ma_res_a'] = "0.5";
					$parse['mod_ma_res_b'] = "2";
					break;
				case 'deut':
					$PageTPL = gettemplate('marchand_deuterium');
					$parse['mod_ma_res_a'] = "0.25";
					$parse['mod_ma_res_b'] = "0.5";
					break;
			}
		}
	}

	$Page    = parsetemplate ( $PageTPL, $parse );
	return  $Page;
}

	$Page = ModuleMarchand ( $user, $planetrow );
	display ( $Page, $lang['mod_marchand'], true, '', false );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Version 2.0 de Tom1991 ajout java
// 1.2 - Réécriture Chlorel passage aux template, optimisation des appels et des requetes SQL
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>