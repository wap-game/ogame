<?php

/**
 * settings.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser ) {
	global $lang, $game_config, $_POST;

	includeLang('admin/settings');

	if ( $CurrentUser['authlevel'] >= 3 ) {
		if ($_POST['opt_save'] == "1") {

			if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
				$game_config['game_disable']         = "1";
				$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
			} else {
				$game_config['game_disable']         = "0";
				$game_config['close_reason']         = "";
			}

			if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
				$game_config['OverviewNewsFrame']     = "1";
				$game_config['OverviewNewsText']      = addslashes( $_POST['NewsText'] );
			} else {
				$game_config['OverviewNewsFrame']     = "0";
				$game_config['OverviewNewsText']      = "";
			}

			// Y a un TCHAT externe ??
			if (isset($_POST['chatframe']) && $_POST['chatframe'] == 'on') {
				$game_config['OverviewExternChat']     = "1";
				$game_config['OverviewExternChatCmd']  = addslashes( $_POST['ExternChat'] );
			} else {
				$game_config['OverviewExternChat']     = "0";
				$game_config['OverviewExternChatCmd']  = "";
			}

			if (isset($_POST['googlead']) && $_POST['googlead'] == 'on') {
				$game_config['OverviewBanner']         = "1";
				$game_config['OverviewClickBanner']    = addslashes( $_POST['GoogleAds'] );
			} else {
				$game_config['OverviewBanner']         = "0";
				$game_config['OverviewClickBanner']    = "";
			}

			// Y a un BANNER Frame ?
			if (isset($_POST['bannerframe']) && $_POST['bannerframe'] == 'on') {
				$game_config['ForumBannerFrame']     = "1";
			} else {
				$game_config['ForumBannerFrame']     = "0";
			}

			// Mode Debug ou pas !
			if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
				$game_config['debug'] = "1";
			} else {
				$game_config['debug'] = "0";
			}

			// Nom du Jeu
			if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
				$game_config['game_name'] = $_POST['game_name'];
			}

			// Adresse du Forum
			if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
				$game_config['forum_url'] = $_POST['forum_url'];
			}

			// Vitesse du Jeu
			if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
				$game_config['game_speed'] = $_POST['game_speed'];
			}

			// Vitesse des Flottes
			if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
				$game_config['fleet_speed'] = $_POST['fleet_speed'];
			}

			// Multiplicateur de Production
			if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
				$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
			}

			// Taille de la planete mère
			if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
				$game_config['initial_fields'] = $_POST['initial_fields'];
			}

			// Revenu de base Metal
			if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
				$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
			}

			// Revenu de base Cristal
			if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
				$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
			}

			// Revenu de base Deuterium
			if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
				$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
			}

			// Revenu de base Energie
			if (isset($_POST['energy_basic_income']) && is_numeric($_POST['energy_basic_income'])) {
				$game_config['energy_basic_income'] = $_POST['energy_basic_income'];
			}
				
			// Lien supplémentaire dans le menu
			if (isset($_POST['enable_link_']) && is_numeric($_POST['enable_link_'])) {
				$game_config['link_enable'] = $_POST['enable_link_'];
			}
			// Texte de ce lien...
			$game_config['link_name'] = addslashes( $_POST['name_link_']);

			// URL de ce lien...
			$game_config['link_url'] = $_POST['url_link_'];
			// Image de la bannière
			$game_config['banner_source_post'] = $_POST['banner_source_post'];
			// 1 point = ??? Ressources ?
			if (isset($_POST['stat_settings']) && is_numeric($_POST['stat_settings'])) {
				$game_config['stat_settings'] = $_POST['stat_settings'];
			}
			// Activation -ou non- des annonces
			if (isset($_POST['enable_announces_']) && is_numeric($_POST['enable_announces_'])) {
				$game_config['enable_announces'] = $_POST['enable_announces_'];
			}
			// Activation -ou non- du marchand
			if (isset($_POST['enable_marchand_']) && is_numeric($_POST['enable_marchand_'])) {
				$game_config['enable_marchand'] = $_POST['enable_marchand_'];
			}
			// Activation -ou non- des notes
			if (isset($_POST['enable_notes_']) && is_numeric($_POST['enable_notes_'])) {
				$game_config['enable_notes'] = $_POST['enable_notes_'];
			}
			// Nom du bot antimulti
			$game_config['bot_name'] = addslashes( $_POST['name_bot']);

			// email du bot antimulti
			$game_config['bot_adress'] = addslashes( $_POST['adress_bot']);

			// Activation -ou non- des notes
			if (isset($_POST['duration_ban']) && is_numeric($_POST['duration_ban'])) {
				$game_config['ban_duration'] = $_POST['duration_ban'];
			}
				
			// Activation -ou non- du bot
			if (isset($_POST['bot_enable']) && is_numeric($_POST['bot_enable'])) {
				$game_config['enable_bot'] = $_POST['bot_enable'];
			}
				
			// BBCode ou pas ?

			if (isset($_POST['bbcode_field']) && is_numeric($_POST['bbcode_field'])) {
				$game_config['enable_bbcode'] = $_POST['bbcode_field'];
			}

			$game_config['ADMINEMAIL'] = addslashes( $_POST['admin_email']);
			
			if (isset($_POST['max_galaxy']) && is_numeric($_POST['max_galaxy'])) {
				$game_config['MAX_GALAXY_IN_WORLD'] = $_POST['max_galaxy'];
			}
			if (isset($_POST['max_system']) && is_numeric($_POST['max_system'])) {
				$game_config['MAX_SYSTEM_IN_GALAXY'] = $_POST['max_system'];
			}
			if (isset($_POST['max_planet']) && is_numeric($_POST['max_planet'])) {
				$game_config['MAX_PLANET_IN_SYSTEM'] = $_POST['max_planet'];
			}
			if (isset($_POST['base_storage']) && is_numeric($_POST['base_storage'])) {
				$game_config['BASE_STORAGE_SIZE'] = $_POST['base_storage'];
			}

			if (isset($_POST['build_metal']) && is_numeric($_POST['build_metal'])) {
				$game_config['BUILD_METAL'] = $_POST['build_metal'];
			}
			if (isset($_POST['build_cristal']) && is_numeric($_POST['build_cristal'])) {
				$game_config['BUILD_CRISTAL'] = $_POST['build_cristal'];
			}
			if (isset($_POST['build_deuterium']) && is_numeric($_POST['build_deuterium'])) {
				$game_config['BUILD_DEUTERIUM'] = $_POST['build_deuterium'];
			}
			if (isset($_POST['max_overflow']) && is_numeric($_POST['max_overflow'])) {
				$game_config['MAX_OVERFLOW'] = $_POST['max_overflow'];
			}

			if (isset($_POST['moonbasis_level']) && is_numeric($_POST['moonbasis_level'])) {
				$game_config['FIELDS_BY_MOONBASIS_LEVEL'] = $_POST['moonbasis_level'];
			}
			if (isset($_POST['show_admin']) && is_numeric($_POST['show_admin'])) {
				$game_config['SHOW_ADMIN_IN_RECORDS'] = $_POST['show_admin'];
			}
			if (isset($_POST['max_player_planets']) && is_numeric($_POST['max_player_planets'])) {
				$game_config['MAX_PLAYER_PLANETS'] = $_POST['max_player_planets'];
			}
			if (isset($_POST['max_fleet']) && is_numeric($_POST['max_fleet'])) {
				$game_config['MAX_FLEET_OR_DEFS_PER_ROW'] = $_POST['max_fleet'];
			}
			if (isset($_POST['max_building']) && is_numeric($_POST['max_building'])) {
				$game_config['MAX_BUILDING_QUEUE_SIZE'] = $_POST['max_building'];
			}
			if (isset($_POST['report_row']) && is_numeric($_POST['report_row'])) {
				$game_config['SPY_REPORT_ROW'] = $_POST['report_row'];
			}

						
			// Activation du jeu
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_name']           ."' WHERE `config_name` = 'game_name';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_disable']           ."' WHERE `config_name` = 'game_disable';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['close_reason']           ."' WHERE `config_name` = 'close_reason';", 'config');

			//Stats
				
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['stat_settings']              ."' WHERE `config_name` = 'stat_settings';", 'config');
				
				
			// Configuration du Jeu
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['forum_url']              ."' WHERE `config_name` = 'forum_url';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_speed']             ."' WHERE `config_name` = 'game_speed';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['fleet_speed']            ."' WHERE `config_name` = 'fleet_speed';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['resource_multiplier']    ."' WHERE `config_name` = 'resource_multiplier';", 'config');

			// Page Generale
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsFrame']       ."' WHERE `config_name` = 'OverviewNewsFrame';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsText']        ."' WHERE `config_name` = 'OverviewNewsText';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChat']      ."' WHERE `config_name` = 'OverviewExternChat';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChatCmd']   ."' WHERE `config_name` = 'OverviewExternChatCmd';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewBanner']          ."' WHERE `config_name` = 'OverviewBanner';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewClickBanner']     ."' WHERE `config_name` = 'OverviewClickBanner';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ForumBannerFrame']       ."' WHERE `config_name` = 'ForumBannerFrame';", 'config');
				
			//Bannière
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['banner_source_post']       ."' WHERE `config_name` = 'banner_source_post';", 'config');

			// Lien supplémentaire dans le menu
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['link_enable']         ."' WHERE `config_name` = 'link_enable';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['link_name']         ."' WHERE `config_name` = 'link_name';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['link_url']         ."' WHERE `config_name` = 'link_url';", 'config');
				
			// Options Planete
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['initial_fields']         ."' WHERE `config_name` = 'initial_fields';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['metal_basic_income']     ."' WHERE `config_name` = 'metal_basic_income';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['crystal_basic_income']   ."' WHERE `config_name` = 'crystal_basic_income';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['deuterium_basic_income'] ."' WHERE `config_name` = 'deuterium_basic_income';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['energy_basic_income']    ."' WHERE `config_name` = 'energy_basic_income';", 'config');

			//Bot antimulti
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bot_name']    ."' WHERE `config_name` = 'bot_name';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bot_adress']    ."' WHERE `config_name` = 'bot_adress';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ban_duration']    ."' WHERE `config_name` = 'ban_duration';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_bot']    ."' WHERE `config_name` = 'enable_bot';", 'config');
				
				
			//Réglage du BBCode
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_bbcode']    ."' WHERE `config_name` = 'enable_bbcode';", 'config');
				
				
			//Controle des pages
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_announces']    ."' WHERE `config_name` = 'enable_announces';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_marchand']    ."' WHERE `config_name` = 'enable_marchand';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_notes']    ."' WHERE `config_name` = 'enable_notes';", 'config');
				
			// Mode Debug
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['debug'] ."' WHERE `config_name` ='debug'", 'config');

			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['ADMINEMAIL'] ."' WHERE `config_name` ='ADMINEMAIL'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_GALAXY_IN_WORLD'] ."' WHERE `config_name` ='MAX_GALAXY_IN_WORLD'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_SYSTEM_IN_GALAXY'] ."' WHERE `config_name` ='MAX_SYSTEM_IN_GALAXY'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_PLANET_IN_SYSTEM'] ."' WHERE `config_name` ='MAX_PLANET_IN_SYSTEM'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['BASE_STORAGE_SIZE'] ."' WHERE `config_name` ='BASE_STORAGE_SIZE'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['BUILD_METAL'] ."' WHERE `config_name` ='BUILD_METAL'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['BUILD_CRISTAL'] ."' WHERE `config_name` ='BUILD_CRISTAL'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['BUILD_DEUTERIUM'] ."' WHERE `config_name` ='BUILD_DEUTERIUM'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_OVERFLOW'] ."' WHERE `config_name` ='MAX_OVERFLOW'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['FIELDS_BY_MOONBASIS_LEVEL'] ."' WHERE `config_name` ='FIELDS_BY_MOONBASIS_LEVEL'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['SHOW_ADMIN_IN_RECORDS'] ."' WHERE `config_name` ='SHOW_ADMIN_IN_RECORDS'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_PLAYER_PLANETS'] ."' WHERE `config_name` ='MAX_PLAYER_PLANETS'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_FLEET_OR_DEFS_PER_ROW'] ."' WHERE `config_name` ='MAX_FLEET_OR_DEFS_PER_ROW'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['MAX_BUILDING_QUEUE_SIZE'] ."' WHERE `config_name` ='MAX_BUILDING_QUEUE_SIZE'", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['SPY_REPORT_ROW'] ."' WHERE `config_name` ='SPY_REPORT_ROW'", 'config');
			
			AdminMessage ($lang['adm_opt_btn_success'], $lang['adm_opt_success'], '?');
			
			header("Location:settings.php");
		} else {

			$parse                           = $lang;
			$parse['game_name']              = $game_config['game_name'];
			$parse['game_speed']             = $game_config['game_speed'];
			$parse['fleet_speed']            = $game_config['fleet_speed'];
			$parse['resource_multiplier']    = $game_config['resource_multiplier'];
			$parse['forum_url']              = $game_config['forum_url'];
			$parse['initial_fields']         = $game_config['initial_fields'];
			$parse['metal_basic_income']     = $game_config['metal_basic_income'];
			$parse['crystal_basic_income']   = $game_config['crystal_basic_income'];
			$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'];
			$parse['energy_basic_income']    = $game_config['energy_basic_income'];
			$parse['enable_link']			 = $game_config['link_enable'];
			$parse['name_link']				 = $game_config['link_name'];
			$parse['url_link']				 = $game_config['link_url'];
			$parse['enable_announces']       = $game_config['enable_announces'];
			$parse['enable_marchand']		 = $game_config['enable_marchand'];
			$parse['enable_notes']			 = $game_config['enable_notes'];
			$parse['bot_name']				 = stripslashes($game_config['bot_name']);
			$parse['bot_adress']			 = stripslashes($game_config['bot_adress']);
			$parse['ban_duration']	         = stripslashes($game_config['ban_duration']);
			$parse['enable_bot']			 = stripslashes($game_config['enable_bot']);
			$parse['enable_bbcode']			 = stripslashes($game_config['enable_bbcode']);
			$parse['banner_source_post']     = $game_config['banner_source_post'];
			$parse['stat_settings']          = stripslashes($game_config['stat_settings']);
				
			$parse['admin_email']            = stripslashes($game_config['ADMINEMAIL']);
			$parse['max_galaxy']    		 = $game_config['MAX_GALAXY_IN_WORLD'];
			$parse['max_system']   			 = $game_config['MAX_SYSTEM_IN_GALAXY'];
			$parse['max_planet']   			 = $game_config['MAX_PLANET_IN_SYSTEM'];
			$parse['base_storage']      	 = $game_config['BASE_STORAGE_SIZE'];
			$parse['build_metal']      		 = $game_config['BUILD_METAL'];
			$parse['build_cristal']     	 = $game_config['BUILD_CRISTAL'];
			$parse['build_deuterium']        = $game_config['BUILD_DEUTERIUM'];
			$parse['max_overflow']      	 = $game_config['MAX_OVERFLOW'];
			$parse['moonbasis_level'] 		 = $game_config['FIELDS_BY_MOONBASIS_LEVEL'];
			$parse['show_admin']  			 = $game_config['SHOW_ADMIN_IN_RECORDS'];
			$parse['max_player_planets']     = $game_config['MAX_PLAYER_PLANETS'];
			$parse['max_fleet'] 			 = $game_config['MAX_FLEET_OR_DEFS_PER_ROW'];
			$parse['max_building']			 = $game_config['MAX_BUILDING_QUEUE_SIZE'];
			$parse['report_row']         	 = $game_config['SPY_REPORT_ROW'];
				
			$parse['closed']                 = ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
			$parse['close_reason']           = stripslashes( $game_config['close_reason'] );

			$parse['newsframe']              = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
			$parse['NewsTextVal']            = stripslashes( $game_config['OverviewNewsText'] );

			$parse['chatframe']              = ($game_config['OverviewExternChat'] == 1) ? " checked = 'checked' ":"";
			$parse['ExtTchatVal']            = stripslashes( $game_config['OverviewExternChatCmd'] );

			$parse['googlead']               = ($game_config['OverviewBanner'] == 1) ? " checked = 'checked' ":"";
			$parse['GoogleAdVal']            = stripslashes( $game_config['OverviewClickBanner'] );

			$parse['debug']                  = ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";

			$parse['bannerframe']            = ($game_config['ForumBannerFrame'] == 1) ? " checked = 'checked' ":"";

			$PageTPL                         = gettemplate('admin/options_body');
			$Page                           .= parsetemplate( $PageTPL,  $parse );

			display ( $Page, $lang['adm_opt_title'], false, '', true );
		}
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
	return $Page;
}

$Page = DisplayGameSettingsPage ( $user );

?>
