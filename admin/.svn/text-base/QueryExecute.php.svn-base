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
		includeLang('admin');

		$parse   = $lang;

		if ($_POST['really_do_it'] == 'on') {

			mysql_query ($_POST['qry_sql']);
			AdminMessage ($lang['qry_succesful'], 'Succes', '?');
			
		} else {

		
		}
		
		$PageTpl = gettemplate("admin/exec_query");
		$Page    = parsetemplate( $PageTpl, $parse);

		display( $Page, $lang['qry_title'], false, '', true );
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>