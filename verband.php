<?php

/**
 * verband.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('fleet');


	$fleetid = $_POST['fleetid'];

	if (!is_numeric($fleetid) || empty($fleetid)) {
		header("Location: overview.php");
		exit();
	}

	$query = doquery("SELECT * FROM {{table}} WHERE fleet_id = '" . $fleetid . "'", 'fleets');

	if (mysql_num_rows($query) != 1) {
		message("{$lang['Erreur1']}", "{$lang['error']}");
	}

	$daten = mysql_fetch_array($query);

	if ($daten['fleet_start_time'] <= time() || $daten['fleet_end_time'] < time() || $daten['fleet_mess'] == 1) {
		message("{$lang['Erreur2']}", "{$lang['error']}");
	}

	if (!isset($_POST['send'])) {
		SetSelectedPlanet ( $user );

		$planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
		$galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true);
		$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
		$maxfleet = doquery("SELECT COUNT(fleet_owner) as ilosc FROM {{table}} WHERE fleet_owner='{$user['id']}'", 'fleets', true);
		$maxfleet_count = $maxfleet["ilosc"];

		CheckPlanetUsedFields($planetrow);

		$fleet = doquery("SELECT * FROM {{table}} WHERE fleet_id = '" . $fleetid . "'", 'fleets', true);

		if (empty($fleet['fleet_group'])) {
			$rand = mt_rand(100000, 999999999);

		doquery(
		"INSERT INTO {{table}} SET
		`name` = 'KV" . $rand . "',
		`teilnehmer` = '" . $user['id'] . "',
		`flotten` = '" . $fleetid . "',
		`ankunft` = '" . $fleet['fleet_start_time'] . "',
		`galaxy` = '" . $fleet['fleet_start_galaxy'] . "',
		`system` = '" . $fleet['fleet_start_system'] . "',
		`planet` = '" . $fleet['fleet_start_planet'] . "',
		`eingeladen` = '" . $user['id'] . "'
		",
		'aks');

		$aks = doquery(
		"SELECT * FROM {{table}} WHERE
		`name` = 'KV" . $rand . "' AND
		`teilnehmer` = '" . $user['id'] . "' AND
		`flotten` = '" . $fleetid . "' AND
		`ankunft` = '" . $fleet['fleet_start_time'] . "' AND
		`galaxy` = '" . $fleet['fleet_start_galaxy'] . "' AND
		`system` = '" . $fleet['fleet_start_system'] . "' AND
		`planet` = '" . $fleet['fleet_start_planet'] . "' AND
		`eingeladen` = '" . $user['id'] . "'
		", 'aks', true);

		doquery(
		"UPDATE {{table}} SET
		fleet_group = '" . $aks['id'] . "'
		WHERE
		fleet_id = '" . $fleetid . "'", 'fleets');
	} else {
		$aks = doquery(
		"SELECT * FROM {{table}} WHERE
		id = '" . $fleet['fleet_group'] . "'"
		, 'aks');

		if (mysql_num_rows($aks) != 1) {
			message("{$lang['Fehler']}", "{$lang['error']}");
		}
		$aks = mysql_num_rows($aks);
	}

	$missiontype =  $lang['type_mission'];
	
	$speed = array(10 => 100,
		9 => 90,
		8 => 80,
		7 => 70,
		6 => 60,
		5 => 50,
		4 => 40,
		3 => 30,
		2 => 20,
		1 => 10,
		);

	if (!$galaxy) {
		$galaxy = $planetrow['galaxy'];
	}
	if (!$system) {
		$system = $planetrow['system'];
	}
	if (!$planet) {
		$planet = $planetrow['planet'];
	}
	if (!$planettype) {
		$planettype = $planetrow['planet_type'];
	}
	$ile = '' . ++$user[$resource[108]] . '';
	$page = "<script language='JavaScript' src='scripts/flotten.js'></script>
<script language='JavaScript' src='scripts/ocnt.js'></script>
  <center>
    <table width='650' border='0' cellpadding='0' cellspacing='1'>
      <tr height='20'>
        <td colspan='9' class='c'>{$lang['fl_count']} ({$lang['fl_selmax']} {$ile})</td>
      </tr>
      <tr height='20'>
        <th width='4%'>{$lang['fl_id']}</th>
        <th width='6%'>{$lang['fl_mission']}</th>
        <th width='10%'>{$lang['fl_count']}</th>
        <th width='10%'>{$lang['fl_from']}</th>
        <th width='11%'>{$lang['fl_start_t']}</th>
        <th width='10%'>{$lang['fl_dest']}</th>
        <th width='11%'>{$lang['fl_dest_t']}</th>
        <th width='11%'>{$lang['fl_back_t']}</th>
        <th width='18%'>{$lang['fl_back_in']}</th>
        <th width='9%'>{$lang['fl_order']}</th>
        </tr>";
	/*
	  Here must show the fleet movings of owner player.
	*/

	$fq = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$user['id']}", 'fleets');

	$i = 0;
	while ($f = mysql_fetch_array($fq)) {
		$i++;

		$page .= "<tr height=20><th>$i</th><th>";

		$page .= "<a title=''>{$missiontype[$f[fleet_mission]]}</a>";
		if (($f['fleet_start_time'] + 1) == $f['fleet_end_time']) {
			$page .= "<br><a title=\"".$lang['fl_back_to_ttl']."\">".$lang['fl_back_to']."</a>";
		} else {
			$page .= "<br><a title=\"".$lang['fl_get_to_ttl']."\">".$lang['fl_get_to']."</a>";
		}
		$page .= "</th>";
		$page .= "</th><th><a title=\"";
		/*
		  Se debe hacer una lista de las tropas
		*/
		$fleet = explode(";", $f['fleet_array']);
		$e = 0;
		foreach($fleet as $a => $b) {
			if ($b != '') {
				$e++;
				$a = explode(",", $b);
				$page .= "{$lang['tech']{$a[0]}}: {$a[1]}\n";
				if ($e > 1) {
					$page .= "\t";
				}
			}
		}
		$page .= "\">" . pretty_number($f[fleet_amount]) . "</a></th>";
		$page .= "<th>[{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}]</th>";
		$page .= "<th>".gmdate("y-m-d H:i:s",$f['fleet_start_time'])."</th>";
		$page .= "<th>[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]</th>";
		$page .= "<th>" . gmdate("y-m-d H:i:s", $f['fleet_start_time']) . "</th>";
		$page .= "<th>" . gmdate("y-m-d H:i:s", $f['fleet_end_time']) . "</th>";
		$page .= " </form>";

		$page .= "<th><font color=\"lime\"><div id=\"time_0\"><font>" . pretty_time(floor($f['fleet_end_time'] + 1 - time())) . "</font></th><th>";

		if ($f['fleet_mess'] == 0) {
			$page .= "     <form action=\"fleetback.php\" method=\"post\">
      <input name=\"zawracanie\" value=" . $f['fleet_id'] . " type=hidden>
         <input value=\"{$lang['fl_cheat_back']}\" type=\"submit\">
       </form></th>";
		} else $page .= "&nbsp;</th>";

		$page .= "</div></font>
            </tr>";
	}

	if ($i == 0) {
		$page .= "<th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th>";
	}
	if ($ile == $maxfleet_count) {
		$maxflot = "<tr height='20'><th colspan='9'><font color='red'>{$lang['fl_max_count']}</font></th></tr>";
	}
	$page .= "{$maxflot}</table>
	  </center>
    <table width='650' border='0' cellpadding='0' cellspacing='1'>
   <tr height='20'>
     <td class='c' colspan='2'>	{$lang['fl_floatt_uint']}</td>
   </tr>

   <form action='verband.php' method='POST'>
   <input type='hidden' name='fleetid'  value='{$fleetid}' />
   <input type='hidden' name='changename' value='49021' />
   <tr height='20'>

  <td class='c' colspan='2'>{$lang['fl_chang_uint']}</td>
   </tr>
   <tr>
    <th colspan='2'><input name='groupname' value='' /> <input type='submit' value='{$lang['ok']}' /></th>
   </tr>
   </form>

   <tr>
    <th>
     <table width='100%' border='0' cellpadding='0' cellspacing='1'>
      <tr height='20'>
       <td class='c'>{$lang['fl_invi_join']}</td>
       <td class='c'>{$lang['fl_invi_join']}</td>
      </tr>
      <tr>

       <th width='50%'>
        <select size='5'>
                   <option></option>
                 </select>
       </th>

	    <form action='index.php?page=flotten1' method='POST'>
	<input type='hidden' name='order_union' value='49021' />
       <input type='hidden' name='adduser' value='49021' />

       <td><input name='addtogroup' /> <br /><input type='submit' value='OK' /></td>
    </form>
             </tr>
     </table>
    </th>
   </tr>
   <tr>

   </tr>

  </table>
	  <center>
		<form action='floten1.php' method='post'>
		<table width='650' border='0' cellpadding='0' cellspacing='1'>
		  <tr height='20'>
			<td colspan='4' class='c'>{$lang['fl_choce_flotte']}</td>
		  </tr>
		  <tr height='20'>
			<th>{$lang['fl_flotte_name']}</th>
			<th>{$lang['fl_count']}</th>";

	// <!--    <th>Gesch.</th> -->
	$page .= '
			<th>-</th>
			<th>-</th>
		  </tr>';
	if (!$planetrow) {
		message("{$lang['fl_warn']}", "{$lang['fl_error']}");
	} //uno nunca sabe xD
	$galaxy = intval($_GET['galaxy']);
	$system = intval($_GET['system']);
	$planet = intval($_GET['planet']);
	$planettype = intval($_GET['planettype']);
	$target_mission = intval($_GET['target_mission']);

	foreach($reslist['fleet'] as $n => $i) {
		if ($planetrow[$resource[$i]] > 0) {
			if ($i == 202 or $i == 203 or $i == 204 or $i == 209 or $i == 210) {
				$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $user['combustion_tech']) * 0.1);
			}
			if ($i == 205 or $i == 206 or $i == 208 or $i == 211) {
				$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $user['impulse_motor_tech']) * 0.2);
			}
			if ($i == 207 or $i == 213 or $i == 214 or $i == 215 or $i == 216) {
				$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $user['hyperspace_motor_tech']) * 0.3);
			}
			$page .= "<tr height='20'>
			<th><a title='{$lang['fl_speed']}: {$pricelist[$i]['speed']}'>{$lang['tech'][$i]}</a></th>
			<th>". pretty_number($planetrow[$resource[$i]]) ."
			  <input type='hidden' name='maxship {$i}' value='{$planetrow[$resource[$i]]}'/></th>

			<input type='hidden' name='consumption{$i}' value='{$pricelist[$i]['consumption']}'/>

			<input type='hidden' name='speed{$i}' value='{$pricelist[$i]['speed']}' />
			<input type='hidden' name='galaxy' value='{$galaxy}'/>

			<input type='hidden' name='system' value={$system} />
			<input type='hidden' name='planet' value='{$planet}'/>
			<input type='hidden' name='planet_type' value='{$planettype}'/>
			<input type='hidden' name='mission' value='{$target_mission}'/>
			</th>
			<input type='hidden' name='capacity{$i}' value='{$pricelist[$i]['capacity']}' />
			</th>";
			if ($i == 212) {
				$page .= '<th></th><th></th></tr>';
			} else {
				$page .= "<th><a href=\"javascript:maxShip('ship{$i}'); shortInfo();\">{$lang['fl_selmax']}</a> </th>
				<th><input name='ship{$i}' size='10' value='0' onfocus='javascript:if(this.value == \"0\") this.value=\"\";' onblur='javascript:if(this.value == \"\") this.value=\"0\";' alt='". $lang['tech'][$i] . $planetrow[$resource[$i]] . "'  onChange='shortInfo()' onKeyUp='shortInfo()'/></th>
				</tr>";
				$aaaaaaa = $pricelist[$i]['consumption'];
			}
			$have_ships = true;
		}
	}

	if (!$have_ships) {
		$page .= "<tr height='20'>
		<th colspan='4'>{$lang['fl_any_floatte']}</th>
		</tr>
		<tr height='20'>
		<th colspan='4'>
		<input type='button' value='{$lang['ok']}' enabled/></th>
		</tr>
		</table>
		</center>
		</form>";
	} else {
		$page .= "
		  <tr height='20'>
			<th colspan='2'><a href='javascript:noShips();shortInfo();noResources();' > " . $lang['fl_any_floatte'] . "</a></th>
			<th colspan='2'><a href='javascript:maxShips();shortInfo();' >{$lang['fl_all_floatte']}</a></th>
		  </tr>";

		$przydalej = "<tr height='20'><th colspan='4'><input type='submit' value='{$lang['ok']}' /></th></tr>";
		if ($ile == $maxfleet_count) {
			$przydalej = '';
		}
		$page .= "{$przydalej}
		<tr><th colspan='4'>
		<br><center></center><br>
		</th></tr>
		</table>
	  </center>
	</form>";
	}
} else {
}

display($page, "Flotten");

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>