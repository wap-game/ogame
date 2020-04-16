<?php


/**
 * constants.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------

if ( defined('INSIDE') ) {

	define('GAMENAME'				  , $game_config['game_name']);
	define('VERSION'               	  , $game_config['VERSION']);
	define('TIMEZONE'              	  , 'TZ=' . $game_config['TIMEZONE']);
	define('ADMINEMAIL'               , $game_config['ADMINEMAIL']);
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	// Definition du monde connu !
	define('MAX_GALAXY_IN_WORLD'      , $game_config['MAX_GALAXY_IN_WORLD']);
	define('MAX_SYSTEM_IN_GALAXY'     , $game_config['MAX_SYSTEM_IN_GALAXY']);
	define('MAX_PLANET_IN_SYSTEM'     , $game_config['MAX_PLANET_IN_SYSTEM']);
	// Nombre de colones pour les rapports d'espionnage
	define('SPY_REPORT_ROW'           , $game_config['SPY_REPORT_ROW']);
	// Cases données par niveau de Base Lunaire
	define('FIELDS_BY_MOONBASIS_LEVEL', $game_config['FIELDS_BY_MOONBASIS_LEVEL']);
	// Nombre maximum de colonie par joueur
	define('MAX_PLAYER_PLANETS'       , $game_config['MAX_PLAYER_PLANETS']);
	// Nombre maximum d'element dans la liste de construction de batiments
	define('MAX_BUILDING_QUEUE_SIZE'  , $game_config['MAX_BUILDING_QUEUE_SIZE']);
	// Nombre maximum d'element dans une ligne de liste de construction flotte et defenses
	define('MAX_FLEET_OR_DEFS_PER_ROW', $game_config['MAX_FLEET_OR_DEFS_PER_ROW']);
	// Taux de depassement possible dans l'espace de stockage des hangards ...
	// 1.0 pour 100% - 1.1 pour 110% etc ...
	define('MAX_OVERFLOW'             , $game_config['MAX_OVERFLOW']);
	// Affiche les administrateur dans la page des records ...
	// 1 -> les affiche
	// 0 -> les affiche pas
	define('SHOW_ADMIN_IN_RECORDS'    , $game_config['SHOW_ADMIN_IN_RECORDS']);

	// Valeurs de bases pour les colonies ou planetes fraichement crées
	define('BASE_STORAGE_SIZE'        , $game_config['BASE_STORAGE_SIZE']);
	define('BUILD_METAL'              , $game_config['BUILD_METAL']);
	define('BUILD_CRISTAL'            , $game_config['BUILD_CRISTAL']);
	define('BUILD_DEUTERIUM'          , $game_config['BUILD_DEUTERIUM']);
	// Debug Level
	define('DEBUG'					  , $game_config['BUILD_DEUTERIUM']); 
	// Mot qui sont interdit a la saisie !
	$ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript", "'" );
} else {
	//die("黑客入侵企图Hacking attempt");
	die("Hacking attempt");
}



?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>