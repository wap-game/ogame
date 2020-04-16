<?php

/**
 * credit.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

	define('INSIDE'  , true);
	define('INSTALL' , false);
	
	$xnova_root_path = './';
	include($xnova_root_path . 'extension.inc');
	include($xnova_root_path . 'common.' . $phpEx);

	includeLang('credit');
	$parse = $lang;

	if ($game_config['ExtCopyFrame'] == '1') {
		$parse['ExtCopyFrame'] = "<tr><td colspan=\"2\" class=\"c\">". $lang['cred_ext'] ."</td></tr><tr><th>". nl2br($game_config['ExtCopyOwner']) ."</th><th>". nl2br($game_config['ExtCopyFunct']) ."</th></tr>";
	}

	$BodyTPL = gettemplate('credit_body');

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['cred_credit'], false);

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>