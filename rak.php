<?php

/**
 * german UGamela
 *       OpenSource aslong as you don't remove this Copyright
 *       http://ugamela-forum.pheelgood.net
 *       UGamela basescripts from Perberos
 * 2006 (all rights reversed)
 *       I-Rak by MoF
 *       UPDATE
 * 18:28 23.12.2007
 */

if (!defined('INSIDE')) {
	die("Hacking attempt");
}

if (file_exists($xnova_root_path . "includes/raketenangriff.php")) {
	include($xnova_root_path . "includes/raketenangriff.php");
} elseif (file_exists("includes/raketenangriff.php")) {
	include("./includes/raketenangriff.php");
} elseif (file_exists("../includes/raketenangriff.php")) {
	include("../includes/raketenangriff.php");
} else
	die('Fatal error!');

if (isset($resource) && !empty($resource[401])) {
	$iraks = doquery("SELECT * FROM {{table}} WHERE zeit <= '" . time() . "'", 'iraks');

	while ($selected_row = mysql_fetch_array($iraks)) {
		if ($selected_row['zeit'] != '' && $selected_row['galaxy'] != '' && $selected_row['system'] != '' && $selected_row['planet'] != '' && is_numeric($selected_row['owner']) && is_numeric($selected_row['zielid']) && is_numeric($selected_row['anzahl']) && !empty($selected_row['anzahl'])) {
			$planetrow = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy'] . "' AND
								system = '" . $selected_row['system'] . "' AND
								planet = '" . $selected_row['planet'] . "'", 'planets');

			$select_ziel = doquery("SELECT defence_tech FROM {{table}} WHERE
								id = '" . $selected_row['zielid'] . "'", 'users');

			$select_owner = doquery("SELECT military_tech FROM {{table}} WHERE
								id = '" . $selected_row['owner'] . "'", 'users');

			if (mysql_num_rows($planetrow) != 1 OR mysql_num_rows($select_ziel) != 1) {
				doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
			} else {
				$verteidiger = mysql_fetch_array($select_ziel);
				$angreifer = mysql_fetch_array($select_owner);
				$planet = mysql_fetch_array($planetrow);

				$ids = array(0 => 401,
					1 => 402,
					2 => 403,
					3 => 404,
					4 => 405,
					5 => 406,
					6 => 407,
					7 => 408,
					8 => 502,
					9 => 503
					);

				$def =
				array(0 => $planet['misil_launcher'], // Raketenwerfer
					1 => $planet['small_laser'], // Leichtes Lasergesch�tz
					2 => $planet['big_laser'], // Schweres Lasergesch�tz
					3 => $planet['gauss_canyon'], // Gau�kanone
					4 => $planet['ionic_canyon'], // Ionengesch�tz
					5 => $planet['buster_canyon'], // Plasmawerfer
					6 => $planet['small_protection_shield'], // Kleine Schildkuppel
					7 => $planet['big_protection_shield'], // Gro�e Schildkuppel
					8 => $planet['interplanetary_misil'], // Interplanetarrakete
					9 => $planet['interceptor_misil'], // Abfangrakete
					);

				$lang =
				array(0 => "Lanceur Missile",
					1 => "Canon Magn&eacute;tique",
					2 => "Batterie Electromagn&eacute;tique",
					3 => "Canon de Gauss",
					4 => "Lanceur Ionique",
					5 => "Lanceur de plasma",
					6 => "Petit bouclier",
					7 => "Grand bouclier",
					8 => "Missiles Intercepteur",
					9 => "Missiles Interplanetaire",
					10 => "Missiles Intercepteur"

					);

				$irak = raketenangriff($verteidiger['defence_tech'], $angreifer['military_tech'], $selected_row['anzahl'], $def, $selected_row['primaer']);

				$message = '';

				if ($planet['interceptor_misil'] >= $selected_row['anzahl']) {
					$message = 'Les Missiles Intercepteur adverses ont d&eacute;truit vos missiles Interplanetaire<br>';

					$x = $resource[$ids[9]];

					doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $selected_row['anzahl'] . " WHERE id = " . $planet['id'], 'planets');
				} else {
					if ($planet['interceptor_misil'] > 0) {
						$x = $resource[$ids[9]];

						doquery("UPDATE {{table}} SET " . $x . " = '0' WHERE id = " . $planet['id'], 'planets');

						$message = $planet['interceptor_misil'] . " missiles Interplanetaire ont &eacute;t&eacute; intercept&eacute;s par vos missiles.<br>";
					}

					foreach ($irak['zerstoert'] as $id => $anzahl) {
						if (!empty($anzahl) && $id < 10) {
							if ($id != 9)
								$message .= $lang[$id] . " (- " . $anzahl . ")<br>";

							$x = $resource[$ids[$id]];

							doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $anzahl . " WHERE id = " . $planet['id'], 'planets');
						}
					}
				}

				$planet_ = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy_angreifer'] . "' AND
								system = '" . $selected_row['system_angreifer'] . "' AND
								planet = '" . $selected_row['planet_angreifer'] . "'", 'planets');

				if (mysql_num_rows($planet_) == 1) {
					$array = mysql_fetch_array($planet_);

					$name = $array['name'];
				}

				$planet_2 = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy'] . "' AND
								system = '" . $selected_row['system'] . "' AND
								planet = '" . $selected_row['planet'] . "'", 'planets');

				if (mysql_num_rows($planet_2) == 1) {
					$array = mysql_fetch_array($planet_2);

					$name_deffer = $array['name'];
				}

				$message_vorlage  = 'Une attaque de missiles (' . $selected_row['anzahl'] . ') de ' . $name . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy_angreifer'] . '&system=' . $selected_row['system_angreifer'] . '&planet=' . $selected_row['planet_angreifer'] . '">[' . $selected_row['galaxy_angreifer'] . ':' . $selected_row['system_angreifer'] . ':' . $selected_row['planet_angreifer'] . ']</a>';
				$message_vorlage .= 'de la planete ' . $name_deffer . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy'] . '&system=' . $selected_row['system'] . '&planet=' . $selected_row['planet'] . '">[' . $selected_row['galaxy'] . ':' . $selected_row['system'] . ':' . $selected_row['planet'] . ']</a><br><br>';

				if (empty($message))
					$message = "L ennemis ne possedait pas de d&eacute;fenses, rien n a &eacute;t&eacute; d&eacute;truit !";

				doquery("INSERT INTO {{table}} SET
						`message_owner`='" . $selected_row['zielid'] . "',
						`message_sender`='',
						`message_time`=UNIX_TIMESTAMP(),
						`message_type`='0',
						`message_from`='QG',
						`message_subject`='Attaque de MIP',
						`message_text`='" . $message_vorlage . $message . "'" , 'messages');
				doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='" . $selected_row['zielid'] . "'", 'users');

				doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
			}
		} else {
			doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
		}
	}
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>