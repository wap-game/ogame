<?php

/**
 * add_fleet.php
 *
 * @version 1.0
 * @copyright 2008 by Tom1991 for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if($user['authlevel']!="3" && $user['authlevel']!="1"){message("Vous n'avez pas acces a cette page","Acces refuser");}

includeLang('admin/add_fleet');

$mode = $_GET['mode'];

   if($mode != 'add')
    {
        $parse['ID']      = $lang['Id'];
        $parse['Cle']     = $lang['cle'];
        $parse['Clourd']  = $lang['clourd'];
        $parse['Pt']      = $lang['pt'];
        $parse['Gt']      = $lang['gt'];
        $parse['Cruise']  = $lang['cruise'];
        $parse['Vb']      = $lang['vb'];
        $parse['Colo']    = $lang['colo'];
        $parse['Rc']      = $lang['rc'];
        $parse['Spy']     = $lang['spy'];
        $parse['Bomb']    = $lang['bomb'];
        $parse['Solar']   = $lang['solar'];
        $parse['Des']     = $lang['des'];
        $parse['Rip']     = $lang['rip'];
        $parse['Traq']    = $lang['traq'];

    }
    elseif($mode == 'add')
    {
	    $id        = $_POST['id'];
	    $cle       = $_POST['cle'];
	    $clourd    = $_POST['clourd'];
	    $pt        = $_POST['pt'];
	    $gt        = $_POST['gt'];
	    $cruise    = $_POST['cruise'];
	    $vb        = $_POST['vb'];
	    $colo      = $_POST['colo'];
	    $rc        = $_POST['rc'];
	    $spy       = $_POST['spy'];
	    $bomb      = $_POST['bomb'];
	    $solar     = $_POST['solar'];
	    $des       = $_POST['des'];
	    $rip       = $_POST['rip'];
	    $traq      = $_POST['traq'];


        $SqlAdd = "UPDATE {{table}} SET";
        $SqlAdd .= "`light_hunter` = '".$cle."+light_hunter', ";
        $SqlAdd .= "`heavy_hunter` = '".$clourd."+heavy_hunter', ";
        $SqlAdd .= "`small_ship_cargo` = '".$pt."+small_ship_cargo', ";
        $SqlAdd .= "`big_ship_cargo` = '".$gt."+big_ship_cargo', ";
		$SqlAdd .= "`crusher` = '".$cruise."+crusher', ";
		$SqlAdd .= "`battle_ship` = '".$vb."+battle_ship', ";
		$SqlAdd .= "`colonizer` = '".$colo."+colonizer', ";
		$SqlAdd .= "`recycler` = '".$rc."+recycler', ";
		$SqlAdd .= "`spy_sonde`= '".$spy."+spy_sonde', ";
		$SqlAdd .= "`bomber_ship` = '".$bomb."+bomber_ship', ";
		$SqlAdd .= "`solar_satelit` = '".$solar."+solar_satelit', ";
		$SqlAdd .= "`destructor` = '".$des."+destructor', ";
		$SqlAdd .= "`dearth_star` = '".$rip."+dearth_star', ";
		$SqlAdd .= "`battleship` = '".$traq."+battleship', ";
		$SqlAdd .= " WHERE `id` = '".$id."' LIMIT 1";

		doquery( $SqlAdd, "planets");

		message('Ajout OK');


	}



 $page = parsetemplate(gettemplate('admin/add_fleet'), $parse);
 display( $page);
?>