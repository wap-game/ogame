<?php

/**
 * rw.php
 *
 * @version 1.0
 * @copyright 2008 by ????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang("rw");

$parse = $lang;
$parse['dpath'] = $dpath;
$open = true;

	$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '".(mysql_escape_string($_GET["raport"]))."';", 'rw', true);

	if (($raportrow["id_owner1"] == $user["id"]) or
		($raportrow["id_owner2"] == $user["id"]) or
		 $open) {
		 	
		
		if (($raportrow["id_owner1"] == $user["id"]) and
			($raportrow["a_zestrzelona"] == 1)) {
			$pagecon .= "<td>{$parse['linkmsg']}</td>";
		} else {
			$pagecon .= "<td>". stripslashes( $raportrow["raport"] ) ."</td>";
		}

		$parse['pagecon'] = $pagecon;
		$page = gettemplate('rw');
		$page = parsetemplate($page, $parse);
		display($page, $parse);
	}

// -----------------------------------------------------------------------------------------------------------
// History version

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>