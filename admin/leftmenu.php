<?PHP

/**
 * leftmenu.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('leftmenu');

	if ($user['authlevel'] >= "1") {
		$parse                 = $lang;
		$parse['mf']           = "Hauptframe";
		$parse['dpath']        = $dpath;
		$parse['XNovaRelease'] = VERSION;
		$parse['servername']   = GAMENAME;
		$Page                  = parsetemplate(gettemplate('admin/left_menu'), $parse);
		display( $Page, "", false, '', true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>
