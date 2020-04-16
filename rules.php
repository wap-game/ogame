<?php

/**
 * rules.php
 * @version 1.0
 * @copyright 2008 by XxmangaxX for XNova
**/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('rules');

	$parse = $lang;
	$parse['servername']   = $game_config['game_name'];

	$PageTPL  = gettemplate('rules_body');
	$page     = parsetemplate( $PageTPL, $parse);

	display($page, $lang['rules'], false);


?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>