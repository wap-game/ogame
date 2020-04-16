<?php

/**
 * md5enc.php
 *
 * @version 1
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE' , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
		includeLang('admin/multi');

		$query   = doquery("SELECT * FROM {{table}}", 'multi');

		$parse                 = $lang;
		$parse['adm_mt_table'] = "";
		$i                     = 0;

		$RowsTPL = gettemplate('admin/multi_rows');
		$PageTPL = gettemplate('admin/multi_body');

		while ($infos = mysql_fetch_assoc($query)) {
			$Bloc['player'] = $infos['player'];
			$Bloc['text']   = $infos['text'];

			$parse['adm_mt_table'] .= parsetemplate( $RowsTPL, $Bloc );
			$i++;
		}

		$parse['adm_mt_count'] = $i;

		$page = parsetemplate( $PageTPL, $parse );
		display( $page, $lang['adm_mt_title'], false, '', true);

	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>