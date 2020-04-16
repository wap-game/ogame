<?php

/**
 * md5enc.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= "1") {
		includeLang('admin/changepass');

		$parse   = $lang;

		if ($_POST['md5q'] != "") {

			doquery ("UPDATE {{table}} SET `password` = '" . md5 ($_POST['md5q']) . "' WHERE `username` = '".$_POST['user']."';", 'users');
		} else {

		}
		
		$PageTpl = gettemplate("admin/changepass");
		$Page    = parsetemplate( $PageTpl, $parse);

		display( $Page, $lang['md5_title'], false, '', true );
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>