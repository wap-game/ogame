<?php

/**
 * logout.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

	includeLang('logout');

	setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);

	echo "<center><div style='margin-top:60px;'><a href='login.php'>{$lang['logingame']}</a>&nbsp;&nbsp;<a href='http://www.ppdream.com'>{$lang['siteurl']}</a></div></center><br>";
	message ( $lang['see_you'], $lang['session_closed'], "login.".$phpEx );
	
// -----------------------------------------------------------------------------------------------------------
// History version
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>