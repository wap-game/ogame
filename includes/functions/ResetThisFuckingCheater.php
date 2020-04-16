<?php

/**
 * ResetThisFuckingCheater.php
 *
 * @version $Id$
 * @copyright 2008
 */

function ResetThisFuckingCheater ( $UserID ) {
	$TheUser        = doquery ("SELECT * FROM {{table}} WHERE `id` = '". $UserID ."';", 'users', true);
	$UserPlanet     = doquery ("SELECT `name` FROM {{table}} WHERE `id` = '". $TheUser['id_planet']."';", 'planets', true);
	DeleteSelectedUser ( $UserID );
	if ($UserPlanet['name'] != "") {
		// Creation de l'utilisateur
		$QryInsertUser  = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`id` = '".            $TheUser['id']            ."', ";
		$QryInsertUser .= "`username` = '".      $TheUser['username']      ."', ";
		$QryInsertUser .= "`email` = '".         $TheUser['email']         ."', ";
		$QryInsertUser .= "`email_2` = '".       $TheUser['email_2']       ."', ";
		$QryInsertUser .= "`sex` = '".           $TheUser['sex']           ."', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`authlevel` = '".     $TheUser['authlevel']     ."', ";
		$QryInsertUser .= "`dpath` = '".         $TheUser['dpath']         ."', ";
		$QryInsertUser .= "`galaxy` = '".        $TheUser['galaxy']        ."', ";
		$QryInsertUser .= "`system` = '".        $TheUser['system']        ."', ";
		$QryInsertUser .= "`planet` = '".        $TheUser['planet']        ."', ";
		$QryInsertUser .= "`register_time` = '". $TheUser['register_time'] ."', ";
		$QryInsertUser .= "`password` = '".      $TheUser['password']      ."';";
		doquery( $QryInsertUser, 'users');

		// On cherche le numero d'enregistrement de l'utilisateur fraichement cr??
		$NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". $TheUser['username'] ."' LIMIT 1;", 'users', true);

		CreateOnePlanetRecord ($TheUser['galaxy'], $TheUser['system'], $TheUser['planet'], $NewUser['id'], $UserPlanet['name'], true);
		// Recherche de la reference de la nouvelle planete (qui est unique normalement !
		$PlanetID       = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

		// Mise a jour de l'enregistrement utilisateur avec les infos de sa planete mere
		$QryUpdateUser  = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`id_planet` = '".      $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '".             $NewUser['id']  ."';";
		doquery( $QryUpdateUser, 'users');
	}

	return;
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>