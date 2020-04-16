<?php

/**
 * deletuser.php
 *
 * @version 1.0
 * @copyright 2008 by Tom1991 for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc' );
include($xnova_root_path . 'common.' . $phpEx );

	if ( $CurrentUser['authlevel'] >= 1 ) {
		$PageTpl = gettemplate( "admin/deletuser" );

		if ( $mode != "delet" ) {
			$parse['adm_bt_delet'] = $lang['adm_bt_delet'];
		}

		$Page = parsetemplate( $PageTpl, $parse );
		display ( $Page, $lang['adminpanel'], false, '', true );

	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>