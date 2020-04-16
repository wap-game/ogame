<?php

/**
 * credit.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('credit');
$parse   = $lang;

if ($user['authlevel'] >= 3) {
	if ($_POST['opt_save'] == "1") {
		// Extended copyright is activated?
		if (isset($_POST['ExtCopyFrame']) && $_POST['ExtCopyFrame'] == 'on') {
			$game_config['ExtCopyFrame'] = "1";
			$game_config['ExtCopyOwner'] = $_POST['ExtCopyOwner'];
			$game_config['ExtCopyFunct'] = $_POST['ExtCopyFunct'];
		} else {
			$game_config['ExtCopyFrame'] = "0";
			$game_config['ExtCopyOwner'] = "";
			$game_config['ExtCopyFunct'] = "";
		}

		// Update values
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyFrame'] ."' WHERE `config_name` = 'ExtCopyFrame';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyOwner'] ."' WHERE `config_name` = 'ExtCopyOwner';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyFunct'] ."' WHERE `config_name` = 'ExtCopyFunct';", 'config');

		AdminMessage ($lang['cred_done'], $lang['cred_ext']);

	} else {
		//View values
		$parse['ExtCopyFrame'] = ($game_config['ExtCopyFrame'] == 1) ? " checked = 'checked' ":"";
		$parse['ExtCopyOwnerVal'] = $game_config['ExtCopyOwner'];
		$parse['ExtCopyFunctVal'] = $game_config['ExtCopyFunct'];

		$BodyTPL = gettemplate('admin/credit_body');
		$page = parsetemplate($BodyTPL, $parse);
		display($page, $lang['cred_credit'], false);
	}

} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>