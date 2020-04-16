<?PHP

/**
 * leftmenu.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

function ShowLeftMenu ( $Level , $Template = 'left_menu') {
	global $lang, $dpath, $game_config;

	includeLang('leftmenu');

	$MenuTPL                  = gettemplate( $Template );
	$InfoTPL                  = gettemplate( 'serv_infos' );
	$parse                    = $lang;
	$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
	$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
	$SubFrame                 = parsetemplate( $InfoTPL, $parse );
	$parse['server_info']     = $SubFrame;
	$parse['XNovaRelease']    = VERSION;
	$parse['dpath']           = $dpath;
	$parse['forum_url']       = $game_config['forum_url'];
	$parse['mf']              = "Hauptframe";
	$rank                     = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';",'statpoints',true);
	$parse['user_rank']       = $rank['total_rank'];
	if ($Level > 0) {
		$parse['ADMIN_LINK']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"admin/leftmenu.php\"><font color=\"lime\">".$lang['user_level'][$Level]."</font></a></div></td>
		</tr>";
	} else {
		$parse['ADMIN_LINK']  = "";
	}
	if ($game_config['link_enable'] == 1) {
		$parse['added_link']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"".$game_config['link_url']."\" target=\"_blank\">".stripslashes($game_config['link_name'])."</a></div></td>
		</tr>";
	} else {
		$parse['added_link']  = "";
	}
	
	if ($game_config['enable_announces'] == 1) {
		$parse['annonce_link']  = "
		<tr>
			<td colspan='2'><div><a href='annonces.php' target='{$parse['mf']}'>{$parse['Annonces']}</a></div></td>
		</tr>";
	} else {
		$parse['annonce_link']  = "";
	}
	
		//Maintenant le marchand
	if ($game_config['enable_marchand'] == 1) {
		$parse['marchand_link']  = "
		<tr>
			<td colspan='2'><div><a href='marchand.php' target='{$parse['mf']}'>{$parse['Marchand']}</a></div></td>
		</tr>
		<tr>
			<td colspan='2'><div><a href='schrotti.php' target='{$parse['mf']}'>{$parse['Schrotti']}</a></div></td>
		</tr>";
	} else {
		$parse['marchand_link']  = "";
	}
			//Maintenant les notes
	if ($game_config['enable_notes'] == 1) {
		$parse['notes_link']  = "
		<tr>
			<td colspan='2'><div><a href='notes.php' onClick='f('notes.php', 'Report');' accesskey='n' target='{$parse['mf']}'>{$parse['Notes']}</a></div></td>
		</tr>";
	} else {
		$parse['notes_link']  = "";
	}
	$parse['servername']   = $game_config['game_name'];
	$Menu                  = parsetemplate( $MenuTPL, $parse);

	return $Menu;
}
	$Menu = ShowLeftMenu ( $user['authlevel'] );
	display ( $Menu, "Menu", '', false );


?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>