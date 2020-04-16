<?php

/**
 * frame.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = false;

$XNova_Host    = $_SERVER['HTTP_HOST'];
$XNova_Script  = $_SERVER['SCRIPT_NAME'];
$Uri_Array     = explode ('/', $XNova_Script);
// On vire le script
array_pop($Uri_Array);
$XNova_URI     = implode ('/', $Uri_Array);

$XNovaRootURL  = "http://". $XNova_Host ."/". $XNova_URI ."/";

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

	$pageTpl = gettemplate("frames");
	$info = array(
		"ENCODING"		=> $langInfos['ENCODING'],
		"game_name"		=> GAMENAME,
		"NoFrames"		=> $lang['NoFrames'],
	);
	
	$page = parsetemplate($pageTpl, $info);

	echo $page;

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Euuhh ... je ne sais plus ...
?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>