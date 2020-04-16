<?php

/**
 * chat.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('chat');
	$BodyTPL = gettemplate('chat_body');

	$nick = $user['username'];
	$parse = $lang;

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['Chat'], false);

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>