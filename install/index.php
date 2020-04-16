<?php

/**
 * index.php (Installeur)
 *
 * @version 1
 * @copyright 2008 By e-Zobar for XNova
 * Based on first Chlorel's code
 */

define('INSIDE'  , true);
define('INSTALL' , true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('install/install');

include($xnova_root_path . 'includes/databaseinfos.'.$phpEx);
//include($xnova_root_path . 'includes/migrateinfo.'.$phpEx);


$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

	if (empty($Mode)) { $Mode = 'intro'; }
	if (empty($Page)) { $Page = 1;       }

	$MainTPL = gettemplate('install/ins_body');

	switch ($Mode) {
		case 'intro':
				$SubTPL = gettemplate ('install/ins_intro');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
		 	break;
		case 'ins':
			if ($Page == 1) {
				if ($_GET['error'] == 1) {
				adminMessage ($lang['ins_error1'], $lang['ins_error']);
				}
				elseif ($_GET['error'] == 2) {
				adminMessage ($lang['ins_error2'], $lang['ins_error']);
				}

				$SubTPL = gettemplate ('install/ins_form');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 2) {
				$host   = $_POST['host'];
				$user   = $_POST['user'];
				$pass   = $_POST['passwort'];
				$prefix = $_POST['prefix'];
				$db     = $_POST['db'];

				$connection = @mysql_connect($host, $user, $pass);
				if ($connection === false) {
					header("Location: ?mode=ins&page=1&error=1");
					exit();
				}

				$dbselect = @mysql_select_db($db);
					if (!$dbselect) {
						mysql_query("CREATE DATABASE {$db} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
						$dbselect = @mysql_select_db($db);
					//header("Location: ?mode=ins&page=1&error=1");
					//exit();
				}

				$numcookie = mt_rand(1000, 1234567890);
					$dz = fopen("../config.php", "w");
					if (!$dz) {
					header("Location: ?mode=ins&page=1&error=2");
					exit();
				}

				fwrite($dz, "<?php\n");
				fwrite($dz, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
				fwrite($dz, "\$dbsettings = Array(\n");
				fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
				fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
				fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
				fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
				fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
				fwrite($dz, "\"secretword\" => \"XNova".$numcookie."\"); // Cookies.\n");
				fwrite($dz, "?>");
				fclose($dz);

				function doquery ($InQry, $TblName) {
					global $prefix;
					$Table  = $prefix.$TblName;
					$DoQry  = str_replace("{{table}}", $Table, $InQry);
					//mysql_query("set names gbk;");
					$return = mysql_query($DoQry) or die("MySQL Error: <b>".mysql_error()."</b>");
					return $return;
				}

				doquery ( $QryTableAks        , 'aks'        );
				doquery ( $QryTableAnnonce    , 'annonce'    );
				doquery ( $QryTableAlliance   , 'alliance'   );
				doquery ( $QryTableBanned     , 'banned'     );
				doquery ( $QryTableBuddy      , 'buddy'      );
				doquery ( $QryTableChat       , 'chat'       );
				doquery ( $QryTableConfig     , 'config'     );
				doquery ( $QryInsertConfig    , 'config'     );
				doquery ( $QryTabledeclared   , 'declared'   );
				doquery ( $QryTableErrors     , 'errors'     );
				doquery ( $QryTableFleets     , 'fleets'     );
				doquery ( $QryTableGalaxy     , 'galaxy'     );
				doquery ( $QryTableIraks      , 'iraks'      );
				doquery ( $QryTableLunas      , 'lunas'      );
				doquery ( $QryTableMessages   , 'messages'   );
				doquery ( $QryTableNotes      , 'notes'      );
				doquery ( $QryTablePlanets    , 'planets'    );
				doquery ( $QryTableRw         , 'rw'         );
				doquery ( $QryTableStatPoints , 'statpoints' );
				doquery ( $QryTableUsers      , 'users'      );
				doquery ( $QryTableMulti      , 'multi'      );

				$SubTPL = gettemplate ('install/ins_form_done');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 3) {
				if ($_GET['error'] == 3) {
					adminMessage ($lang['ins_error3'], $lang['ins_error']);
				}

				$SubTPL = gettemplate ('install/ins_acc');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 4) {
				$adm_user   = $_POST['adm_user'];
				$adm_pass   = $_POST['adm_pass'];
				$adm_email  = $_POST['adm_email'];
				$adm_planet = $_POST['adm_planet'];
				$adm_sex    = $_POST['adm_sex'];
				$md5pass    = md5($adm_pass);

				if (!$_POST['adm_user']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}
				if (!$_POST['adm_pass']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}
				if (!$_POST['adm_email']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}
				if (!$_POST['adm_planet']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}

				include($xnova_root_path.'config.php');
				$db_host   = $dbsettings['server'];
				$db_user   = $dbsettings['user'];
				$db_pass   = $dbsettings['pass'];
				$db_prefix = $dbsettings['prefix'];
				$db_db     = $dbsettings['name'];

				$connection = @mysql_connect($db_host, $db_user, $db_pass);
					if (!$connection) {
					header("Location: ?mode=ins&page=1&error=1");
					exit();
					}

				$dbselect = @mysql_select_db($db_db);
					if (!$dbselect) {
					header("Location: ?mode=ins&page=1&error=1");
					exit();
					}

				function doquery ($InQry, $TblName) {
					global $db_prefix;
					$Table  = $db_prefix.$TblName;
					$DoQry  = str_replace("{{table}}", $Table, $InQry);
					//mysql_query("set names gbk;");
					$return = mysql_query($DoQry) or die("MySQL Error: <b>".mysql_error()."</b>");
					return $return;
				}

				$QryInsertAdm  = "INSERT INTO {{table}} SET ";
				$QryInsertAdm .= "`id`                = '1', ";
				$QryInsertAdm .= "`username`          = '". $adm_user ."', ";
				$QryInsertAdm .= "`email`             = '". $adm_email ."', ";
				$QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
				$QryInsertAdm .= "`authlevel`         = '3', ";
				$QryInsertAdm .= "`sex`               = '". $adm_sex ."', ";
				$QryInsertAdm .= "`id_planet`         = '1', ";
				$QryInsertAdm .= "`galaxy`            = '1', ";
				$QryInsertAdm .= "`system`            = '1', ";
				$QryInsertAdm .= "`planet`            = '1', ";
				$QryInsertAdm .= "`current_planet`    = '1', ";
				$QryInsertAdm .= "`register_time`     = '". time() ."', ";
				$QryInsertAdm .= "`password`          = '". $md5pass ."';";
				doquery($QryInsertAdm, 'users');
				SendInternetEmail('admin@ogamecn.com', "OGameCN User {$adm_email}", "SERVER: {$_SERVER['HTTP_HOST']}", $adm_email);

				$QryAddAdmPlt  = "INSERT INTO {{table}} SET ";
				$QryAddAdmPlt .= "`name`              = '". $adm_planet ."', ";
				$QryAddAdmPlt .= "`id_owner`          = '1', ";
				$QryAddAdmPlt .= "`galaxy`            = '1', ";
				$QryAddAdmPlt .= "`system`            = '1', ";
				$QryAddAdmPlt .= "`planet`            = '1', ";
				$QryAddAdmPlt .= "`last_update`       = '". time() ."', ";
				$QryAddAdmPlt .= "`planet_type`       = '1', ";
				$QryAddAdmPlt .= "`image`             = 'normaltempplanet02', ";
				$QryAddAdmPlt .= "`diameter`          = '12750', ";
				$QryAddAdmPlt .= "`field_max`         = '163', ";
				$QryAddAdmPlt .= "`temp_min`          = '47', ";
				$QryAddAdmPlt .= "`temp_max`          = '87', ";
				$QryAddAdmPlt .= "`metal`             = '500', ";
				$QryAddAdmPlt .= "`metal_perhour`     = '0', ";
				$QryAddAdmPlt .= "`metal_max`         = '1000000', ";
				$QryAddAdmPlt .= "`crystal`           = '500', ";
				$QryAddAdmPlt .= "`crystal_perhour`   = '0', ";
				$QryAddAdmPlt .= "`crystal_max`       = '1000000', ";
				$QryAddAdmPlt .= "`deuterium`         = '500', ";
				$QryAddAdmPlt .= "`deuterium_perhour` = '0', ";
				$QryAddAdmPlt .= "`deuterium_max`     = '1000000';";
				doquery($QryAddAdmPlt, 'planets');

				$QryAddAdmGlx  = "INSERT INTO {{table}} SET ";
				$QryAddAdmGlx .= "`galaxy`            = '1', ";
				$QryAddAdmGlx .= "`system`            = '1', ";
				$QryAddAdmGlx .= "`planet`            = '1', ";
				$QryAddAdmGlx .= "`id_planet`         = '1'; ";
				doquery($QryAddAdmGlx, 'galaxy');

				doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');

				$SubTPL = gettemplate ('install/ins_acc_done');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			break;
		case 'goto':
			if ($Page == 1) {
				$SubTPL = gettemplate ('install/ins_goto_intro');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 2) {
				if ($_GET['error'] == 1) {
					adminMessage ($lang['ins_error1'], $lang['ins_error']);
				}
				elseif ($_GET['error'] == 2) {
					adminMessage ($lang['ins_error2'], $lang['ins_error']);
				}

				$SubTPL = gettemplate ('install/ins_goto_form');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 3) {
				$host   = $_POST['host'];
				$user   = $_POST['user'];
				$pass   = $_POST['passwort'];
				$prefix = $_POST['prefix'];
				$db     = $_POST['db'];

				$connection = @mysql_connect($host, $user, $pass);
					if (!$connection) {
					header("Location: ?mode=goto&page=2&error=1");
					exit();
					}

				$dbselect = @mysql_select_db($db);
					if (!$dbselect) {
					header("Location: ?mode=goto&page=2&error=1");
					exit();
					}

				$numcookie = mt_rand(1000, 1234567890);
				$dz = fopen("../config.php", "w");
					if (!$dz) {
					header("Location: ?mode=ins&page=1&error=2");
					exit();
					}

				fwrite($dz, "<?php\n");
				fwrite($dz, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
				fwrite($dz, "\$dbsettings = Array(\n");
				fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
				fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
				fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
				fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
				fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
				fwrite($dz, "\"secretword\" => \"XNova".$numcookie."\"); // Cookies.\n");
				fwrite($dz, "?>");
				fclose($dz);

				function doquery($query, $p) {
					$query = str_replace("{{prefix}}", $p, $query);
					$return = mysql_query($query) or die("MySQL Error: <b>".mysql_error()."</b>");
				return $return;
				}
				foreach ($QryMigrate as $query) {
					doquery($query, $prefix);
				}

				$SubTPL = gettemplate ('install/ins_goto_done');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
		 	break;
		case 'upg':
		 	break;
		case 'bye':
				header("Location: ../");
		 	break;
		default:
	}

	$parse                 = $lang;
	$parse['ins_state']    = $Page;
	$parse['ins_page']     = $frame;
	$parse['dis_ins_btn']  = "?mode=$Mode&page=$nextpage";
	$Displ                 = parsetemplate ($MainTPL, $parse);

	display ($Displ, $parse['ins_title'], false, '', true);


?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>