<?php

/**
 * alliance.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSTALL' , false);

function getV($a) {
	return isset($_GET[$a]) ? isset($_GET[$a]) : null;
}

$mode = getV('mode');
if (empty($mode))   { unset($mode); }
$a     = intval(getV('a'));
if (empty($a))      { unset($a); }
$sort1 = intval(getV('sort1'));
if (empty($sort1))  { unset($sort1); }
$sort2 = intval(getV('sort2'));
if (empty($sort2))  { unset($sort2); }
$d = getV('d');
if ((!is_numeric($d)) || (empty($d) && $d != 0))
	unset($d);

$edit = getV('edit');

if (empty($edit))
	unset($edit);

$rank = intval(getV('rank'));
if (empty($rank))
	unset($rank);

$kick = intval(getV('kick'));
if (empty($kick))
	unset($kick);

$id = intval(getV('id'));
if (empty($id))
	unset($id);

define('INSIDE', true);
$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

$mode     = getV('mode');
$yes      = getV('yes');
$edit     = getV('edit');
$allyid   = intval(getV('allyid'));
$show     = intval(getV('show'));
$sort     = intval(getV('sort'));
$sendmail = intval(getV('sendmail'));
$t        = getV('t');
$a        = intval(getV('a'));
$tag      = mysql_escape_string(getV('tag'));

includeLang('alliance');


/*
  Alianza consiste en tres partes.
  La primera es la comun. Es decir, no se necesita comprobar si se esta en una alianza o no.
  La segunda, es sin alianza. Eso implica las solicitudes.
  La ultima, seria cuando ya se esta dentro de una.
*/
// Parte inicial.

if (getV('mode') == 'ainfo') {
	$a = intval(getV('a'));
	$tag = mysql_escape_string(getV('tag'));
	// Evitamos errores casuales xD
	// query

	if (getV('tag')) {
		$allyrow = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$tag}'", "alliance", true);
	} elseif (is_numeric($a) && $a != 0) {
		$allyrow = doquery("SELECT * FROM {{table}} WHERE id='{$a}'", "alliance", true);
	} else {
		message($lang['Alliance_information1'], "{$lang['Alliance_information']} (1)");
	}
	// Si no existe
	if (!$allyrow) {
		message($lang['Alliance_information1'], "{$lang['Alliance_information']} (1)");
			}
	extract($allyrow);

	if ($ally_image != "") {
		$ally_image = "<tr><th colspan=2><img src=\"{$ally_image}\"></td></tr>";
	}

	if ($ally_description != "") {
		$ally_description = "<tr><th colspan=2 height=100>{$ally_description}</th></tr>";
	} else
		$ally_description = "<tr><th colspan=2 height=100>{$lang['notperson']}</th></tr>";

	if ($ally_web != "") {
		$ally_web = "<tr>
		<th>{$lang['Initial_page']}</th>
		<th><a href=\"{$ally_web}\">{$ally_web}</a></th>
		</tr>";
	}

	$lang['ally_member_scount'] = $ally_members;
	$lang['ally_name'] = $ally_name;
	$lang['ally_tag'] = $ally_tag;
	// codigo raro
	$patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
	$replacements[] = '<font color="\1">\2</font>';
	$patterns[] = '#\[img\](.*?)\[/img\]#Smi';
	$replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
	$patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
	$replacements[] = '<font color="\1">';
	$patterns[] = "#\[/f\]#Ssi";
	$replacements[] = '</font>';
	$ally_description = preg_replace($patterns, $replacements, $ally_description);

	$lang['ally_description'] = nl2br($ally_description);
	$lang['ally_image'] = $ally_image;
	$lang['ally_web'] = $ally_web;

	if ($user['ally_id'] == 0) {
		$lang['bewerbung'] = "<tr>
	  <th>{$lang['Bewerben']}</th>
	  <th><a href=\"alliance.php?mode=apply&amp;allyid=" . $id . "\">{$lang['Bewerben_info']}</a></th>

	</tr>";
	} else
		$lang['bewerbung'] = "";

	$page .= parsetemplate(gettemplate('alliance_ainfo'), $lang);
	display($page, str_replace('%s', $ally_name, $lang['Info_of_Alliance']));
}
// --[Comprobaciones de alianza]-------------------------
if ($user['ally_id'] == 0) { // Sin alianza
	if ($mode == 'make' && $user['ally_request'] == 0) { // Make alliance
		/*
	  Aca se crean las alianzas...
	*/
		if ($yes == 1 && $_POST) {
			/*
		  Por el momento solo estoy improvisando, luego se perfeccionara el sistema :)
		  Creo que aqui se realiza una query para comprovar el nombre, y luego le pregunta si es el tag correcto...
		*/
			if (!$_POST['atag']) {
				message($lang['have_not_tag'], $lang['make_alliance']);
			}
			if (!$_POST['aname']) {
				message($lang['have_not_name'], $lang['make_alliance']);
			}

			$tagquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$_POST['atag']}'", 'alliance', true);

			if ($tagquery) {
				message(str_replace('%s', $_POST['atag'], $lang['always_exist']), $lang['make_alliance']);
			}

			doquery("INSERT INTO {{table}} SET
			`ally_name`='{$_POST['aname']}',
			`ally_tag`='{$_POST['atag']}' ,
			`ally_owner`='{$user['id']}',
			`ally_owner_range`='Leader',
			`ally_members`='1',
			`ally_register_time`=" . time() , "alliance");

			$allyquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$_POST['atag']}'", 'alliance', true);

			doquery("UPDATE {{table}} SET
			`ally_id`='{$allyquery['id']}',
			`ally_name`='{$allyquery['ally_name']}',
			`ally_register_time`='" . time() . "'
			WHERE `id`='{$user['id']}'", "users");

			$page = MessageForm(str_replace('%s', $_POST['atag'], $lang['ally_maked']),

				str_replace('%s', $_POST['atag'], $lang['alliance_has_been_maked']) . "<br><br>", "", $lang['Ok']);
		} else {
			$page .= parsetemplate(gettemplate('alliance_make'), $lang);
		}

		display($page, $lang['make_alliance']);
	}

	if ($mode == 'search' && $user['ally_request'] == 0) { // search one
		/*
	  Buscador de alianzas
	*/
		$parse = $lang;
		$lang['searchtext'] = $_POST['searchtext'];
		$page = parsetemplate(gettemplate('alliance_searchform'), $lang);

		if ($_POST) { // esta parte es igual que el buscador de search.php...
			// searchtext
			$search = doquery("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$_POST['searchtext']}%' or ally_tag LIKE '%{$_POST['searchtext']}%' LIMIT 30", "alliance");

			if (mysql_num_rows($search) != 0) {
				$template = gettemplate('alliance_searchresult_row');

				while ($s = mysql_fetch_array($search)) {
					$entry = array();
					$entry['ally_tag'] = "[<a href=\"alliance.php?mode=apply&allyid={$s['id']}\">{$s['ally_tag']}</a>]";
					$entry['ally_name'] = $s['ally_name'];
					$entry['ally_members'] = $s['ally_members'];

					$parse['result'] .= parsetemplate($template, $entry);
				}

				$page .= parsetemplate(gettemplate('alliance_searchresult_table'), $parse);
			}
		}

		display($page, $lang['search_alliance']);
	}

	if ($mode == 'apply' && $user['ally_request'] == 0) { // solicitudes
		if (!is_numeric(getV('allyid')) || !getV('allyid') || $user['ally_request'] != 0 || $user['ally_id'] != 0) {
			message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
		}
		// pedimos la info de la alianza
		$allyrow = doquery("SELECT ally_tag,ally_request FROM {{table}} WHERE id='" . intval(getV('allyid')) . "'", "alliance", true);

		if (!$allyrow) {
			message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
		}

		extract($allyrow);

		if ($_POST['further'] == $lang['Send']) { // esta parte es igual que el buscador de search.php...
			doquery("UPDATE {{table}} SET `ally_request`='" . intval($allyid) . "', ally_request_text='" . mysql_escape_string(strip_tags($_POST['text'])) . "', ally_register_time='" . time() . "' WHERE `id`='" . $user['id'] . "'", "users");
			// mensaje de cuando se envia correctamente el mensaje
			message($lang['apply_registered'], $lang['your_apply']);
			// mensaje de cuando falla el envio
			// message($lang['apply_cantbeadded'], $lang['your_apply']);
		} else {
			$text_apply = ($ally_request) ? $ally_request : $lang['There_is_no_a_text_apply'];
		}

		$parse = $lang;
		$parse['allyid'] = intval(getV('allyid'));
		$parse['chars_count'] = strlen($text_apply);
		$parse['text_apply'] = $text_apply;
		$parse['Write_to_alliance'] = str_replace('%s', $ally_tag, $lang['Write_to_alliance']);

		$page = parsetemplate(gettemplate('alliance_applyform'), $parse);

		display($page, $lang['Write_to_alliance']);
	}

	if ($user['ally_request'] != 0) { // Esperando una respuesta
		// preguntamos por el ally_tag
		$allyquery = doquery("SELECT ally_tag FROM {{table}} WHERE id='" . intval($user['ally_request']) . "' ORDER BY `id`", "alliance", true);

		extract($allyquery);
		if ($_POST['bcancel']) {
			doquery("UPDATE {{table}} SET `ally_request`=0 WHERE `id`=" . $user['id'], "users");

			$lang['request_text'] = str_replace('%s', $ally_tag, $lang['Canceled_a_request_text']);
			$lang['button_text'] = $lang['Ok'];
			$page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
		} else {
			$lang['request_text'] = str_replace('%s', $ally_tag, $lang['Waiting_a_request_text']);
			$lang['button_text'] = $lang['Delete_apply'];
			$page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
		}
		// mysql_escape_string(strip_tags());
		display($page, "Deine Anfrage");
	} else { // Vista sin allianza
		/*
	  Vista normal de cuando no se tiene ni solicitud ni alianza
	*/
		$page .= parsetemplate(gettemplate('alliance_defaultmenu'), $lang);
		display($page, $lang['alliance']);
	}
}

//---------------------------------------------------------------------------------------------------------------------------------------------------
// Parte de adentro de la alianza
elseif ($user['ally_id'] != 0 && $user['ally_request'] == 0) { // Con alianza
	// query para la allyrow
	/*
array(1 =>
	'name' => 'Co. Leader',
	'mails' => '1',
	'delete' => '0',
	'kick' => '1',
	'bewerbungen' => '1',
	'administrieren' => '1',
	'memberlist' => '1',
	'bewerbungenbearbeiten' => '1',
	'onlinestatus' => '1',
	'rechtehand' => '1'
	);

*/
	$ally = doquery("SELECT * FROM {{table}} WHERE id='{$user['ally_id']}'", "alliance", true);

	$ally_ranks = unserialize($ally['ally_ranks']);

	$allianz_raenge = unserialize($ally['ally_ranks']);

	if ($allianz_raenge[$user['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_watch_memberlist_status = true;
	} else
		$user_can_watch_memberlist_status = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['memberlist'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_watch_memberlist = true;
	} else
		$user_can_watch_memberlist = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['mails'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_send_mails = true;
	} else
		$user_can_send_mails = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['kick'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_kick = true;
	} else
		$user_can_kick = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['rechtehand'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_edit_rights = true;
	else
		$user_can_edit_rights = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['delete'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_exit_alliance = true;
	else
		$user_can_exit_alliance = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['bewerbungen'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_bewerbungen_einsehen = true;
	else
		$user_bewerbungen_einsehen = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['bewerbungenbearbeiten'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_bewerbungen_bearbeiten = true;
	else
		$user_bewerbungen_bearbeiten = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_admin = true;
	else
		$user_admin = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_onlinestatus = true;
	else
		$user_onlinestatus = false;

	if (!$ally) {
		doquery("UPDATE {{table}} SET `ally_id`=0 WHERE `id`='{$user['id']}'", "users");
		message($lang['ally_notexist'], $lang['your_alliance'], 'alliance.php');
	}

	if ($mode == 'exit') {
		if ($ally['ally_owner'] == $user['id']) {
			message($lang['Owner_cant_go_out'], $lang['Alliance']);
		}
		// se sale de la alianza
		if (getV('yes') == 1) {
			doquery("UPDATE {{table}} SET `ally_id`=0, `ally_name` = '' WHERE `id`='{$user['id']}'", "users");
			$lang['Go_out_welldone'] = str_replace("%s", $ally_name, $lang['Go_out_welldone']);
			$page = MessageForm($lang['Go_out_welldone'], "<br>", $PHP_SELF, $lang['Ok']);
			// Se quitan los puntos del user en la alianza
		} else {
			// se pregunta si se quiere salir
			$lang['Want_go_out'] = str_replace("%s", $ally_name, $lang['Want_go_out']);
			$page = MessageForm($lang['Want_go_out'], "<br>", "?mode=exit&yes=1", "{$lang['Continue']}");
		}
		display($page);
	}

	if ($mode == 'memberslist') { // Lista de miembros.
		/*
	  Lista de miembros.
	  Por lo que parece solo se hace una query fijandose los usuarios con el mismo ally_id.
	  seguido del query del planeta principal de cada uno para sacarle la posicion, pero
	  voy a ver si tambien agrego las cordenadas en el id user...
	*/
		// obtenemos el array de los rangos
		// $ally_ranks = unserialize($ally['ally_ranks']);
		$allianz_raenge = unserialize($ally['ally_ranks']);
		// $user_can_watch_memberlist
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_watch_memberlist) {
			message($lang['Denied_access'], $lang['Members_list']);
		}
		// El orden de aparicion
		if ($sort2) {
			$sort1 = intval(getV('sort1'));
			$sort2 = intval(getV('sort2'));

			if ($sort1 == 1) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 2) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 4) {
				$sort = " ORDER BY `ally_register_time`";
			} elseif ($sort1 == 5) {
				$sort = " ORDER BY `onlinetime`";
			} else {
				$sort = " ORDER BY `id`";
			}

			if ($sort2 == 1) {
				$sort .= " DESC;";
			} elseif ($sort2 == 2) {
				$sort .= " ASC;";
			}
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'{$sort}", 'users');
		} else {
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'", 'users');
		}
		// contamos la cantidad de usuarios.
		$i = 0;
		// Como es costumbre. un row template
		$template = gettemplate('alliance_memberslist_row');
		$page_list = '';
		while ($u = mysql_fetch_array($listuser)) {
			$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $u['id'] . "';", 'statpoints', true);

			$i++;
			$u['i'] = $i;

			if ($u["onlinetime"] + 60 * 10 >= time() && $user_can_watch_memberlist_status) {
				$u["onlinetime"] = "lime>{$lang['On']}<";
			} elseif ($u["onlinetime"] + 60 * 20 >= time() && $user_can_watch_memberlist_status) {
				$u["onlinetime"] = "yellow>{$lang['15_min']}<";
			} elseif ($user_can_watch_memberlist_status) {
				$u["onlinetime"] = "red>{$lang['Off']}<";
			} else $u["onlinetime"] = "orange>-<";
			// Nombre de rango
			if ($ally['ally_owner'] == $u['id']) {
				$u["ally_range"] = ($ally['ally_owner_range'] == '')?"Leader":$ally['ally_owner_range'];
			} elseif (isset($allianz_raenge[$u['ally_rank_id']]['name'])) {
				$u["ally_range"] = $allianz_raenge[$u['ally_rank_id']]['name'];
			} else {
				$u["ally_range"] = $lang['Novate'];
			}

			$u["dpath"]  = $dpath;
			$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";

			if ($u['ally_register_time'] > 0)
				$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
			else
				$u['ally_register_time'] = "-";

			$page_list .= parsetemplate($template, $u);
		}
		// para cambiar el link de ordenar.
		if ($sort2 == 1) {
			$s = 2;
		} elseif ($sort2 == 2) {
			$s = 1;
		} else {
			$s = 1;
		}

		if ($i != $ally['ally_members']) {
			doquery("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
		}

		$parse = $lang;
		$parse['i'] = $i;
		$parse['s'] = $s;
		$parse['list'] = $page_list;

		$page .= parsetemplate(gettemplate('alliance_memberslist_table'), $parse);

		display($page, $lang['Members_list']);
	}

	if ($mode == 'circular') { // Correo circular
		/*
	  Mandar un correo circular.
	  creo que aqui tendria que ver yo como crear el sistema de mensajes...
	*/
		// un loop para mostrar losrangos
		$allianz_raenge = unserialize($ally['ally_ranks']);
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_send_mails) {
			message($lang['Denied_access'], $lang['Send_circular_mail']);
		}

		if ($sendmail == 1) {
			$_POST['r'] = intval($_POST['r']);
			$_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));

			if ($_POST['r'] == 0) {
				$sq = doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}'", "users");
			} else {
				$sq = doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
			}
			// looooooop
			$list = '';
			while ($u = mysql_fetch_array($sq)) {
				doquery("INSERT INTO {{table}} SET
				`message_owner`='{$u['id']}',
				`message_sender`='{$user['id']}' ,
				`message_time`='" . time() . "',
				`message_type`='2',
				`message_from`='{$ally['ally_tag']}',
				`message_subject`='{$user['username']}',
				`message_text`='{$_POST['text']}'
				", "messages");
				$list .= "<br>{$u['username']} ";
			}
			// doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}' ORDER BY `id`","users");
			doquery("UPDATE {{table}} SET `new_message`=new_message+1 WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
			doquery("UPDATE {{table}} SET `mnl_alliance`=mnl_alliance+1 WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
			/*
		  Aca un mensajito diciendo que a quien se mando.
		*/
			$page = MessageForm($lang['Circular_sended'], $lang['Folgende'] . $list, "alliance.php", $lang['Ok'], true);
			display($page, $lang['Send_circular_mail']);
		}

		$lang['r_list'] = "<option value=\"0\">{$lang['All_players']}</option>";
		if ($allianz_raenge) {
			foreach($allianz_raenge as $id => $array) {
				$lang['r_list'] .= "<option value=\"" . ($id + 1) . "\">" . $array['name'] . "</option>";
			}
		}

		$page .= parsetemplate(gettemplate('alliance_circular'), $lang);

		display($page, $lang['Send_circular_mail']);
	}

	if ($mode == 'admin' && $edit == 'rights') { // Administrar leyes
		$allianz_raenge = unserialize($ally['ally_ranks']);

		if ($ally['ally_owner'] != $user['id'] && !$user_can_edit_rights) {
			message($lang['Denied_access'], $lang['Members_list']);
		} elseif (!empty($_POST['newrangname'])) {
			$name = mysql_escape_string(strip_tags($_POST['newrangname']));

			$allianz_raenge[] = array('name' => $name,
				'mails' => 0,
				'delete' => 0,
				'kick' => 0,
				'bewerbungen' => 0,
				'administrieren' => 0,
				'bewerbungenbearbeiten' => 0,
				'memberlist' => 0,
				'onlinestatus' => 0,
				'rechtehand' => 0
				);

			$ranks = serialize($allianz_raenge);

			doquery("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");

			$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

			header("Location: " . $goto);
			exit();
		} elseif ($_POST['id'] != '' && is_array($_POST['id'])) {
			$ally_ranks_new = array();

			foreach ($_POST['id'] as $id) {
				$name = $allianz_raenge[$id]['name'];

				$ally_ranks_new[$id]['name'] = $name;

				if (isset($_POST['u' . $id . 'r0'])) {
					$ally_ranks_new[$id]['delete'] = 1;
				} else {
					$ally_ranks_new[$id]['delete'] = 0;
				}

				if (isset($_POST['u' . $id . 'r1']) && $ally['ally_owner'] == $user['id']) {
					$ally_ranks_new[$id]['kick'] = 1;
				} else {
					$ally_ranks_new[$id]['kick'] = 0;
				}

				if (isset($_POST['u' . $id . 'r2'])) {
					$ally_ranks_new[$id]['bewerbungen'] = 1;
				} else {
					$ally_ranks_new[$id]['bewerbungen'] = 0;
				}

				if (isset($_POST['u' . $id . 'r3'])) {
					$ally_ranks_new[$id]['memberlist'] = 1;
				} else {
					$ally_ranks_new[$id]['memberlist'] = 0;
				}

				if (isset($_POST['u' . $id . 'r4'])) {
					$ally_ranks_new[$id]['bewerbungenbearbeiten'] = 1;
				} else {
					$ally_ranks_new[$id]['bewerbungenbearbeiten'] = 0;
				}

				if (isset($_POST['u' . $id . 'r5'])) {
					$ally_ranks_new[$id]['administrieren'] = 1;
				} else {
					$ally_ranks_new[$id]['administrieren'] = 0;
				}

				if (isset($_POST['u' . $id . 'r6'])) {
					$ally_ranks_new[$id]['onlinestatus'] = 1;
				} else {
					$ally_ranks_new[$id]['onlinestatus'] = 0;
				}

				if (isset($_POST['u' . $id . 'r7'])) {
					$ally_ranks_new[$id]['mails'] = 1;
				} else {
					$ally_ranks_new[$id]['mails'] = 0;
				}

				if (isset($_POST['u' . $id . 'r8'])) {
					$ally_ranks_new[$id]['rechtehand'] = 1;
				} else {
					$ally_ranks_new[$id]['rechtehand'] = 0;
				}
			}

			$ranks = serialize($ally_ranks_new);

			doquery("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");

			$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

			header("Location: " . $goto);
			exit();
		}
		// borrar una entrada
		elseif (isset($d) && isset($ally_ranks[$d])) {
			unset($ally_ranks[$d]);
			$ally['ally_rank'] = serialize($ally_ranks);

			doquery("UPDATE {{table}} SET `ally_ranks`='{$ally['ally_rank']}' WHERE `id`={$ally['id']}", "alliance");
		}

		if (count($ally_ranks) == 0 || $ally_ranks == '') { // si no hay rangos
			$list = "<th>{$lang['There_is_not_range']}</th>";
		} else { // Si hay rangos
			// cargamos la template de tabla
			$list = parsetemplate(gettemplate('alliance_admin_laws_head'), $lang);
			$template = gettemplate('alliance_admin_laws_row');
			// Creamos la lista de rangos
			$i = 0;

			foreach($ally_ranks as $a => $b) {
				if ($ally['ally_owner'] == $user['id']) {
					// $i++;u2r5
					$lang['id'] = $a;
					$lang['delete'] = "<a href=\"alliance.php?mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
					$lang['r0'] = $b['name'];
					$lang['a'] = $a;
					$lang['r1'] = "<input type=checkbox name=\"u{$a}r0\"" . (($b['delete'] == 1)?' checked="checked"':'') . ">"; //{$b[1]}
					$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
					$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
					$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
					$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
					$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
					$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
					$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
					$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";

					$list .= parsetemplate($template, $lang);
				} else {
					$lang['id'] = $a;
					$lang['r0'] = $b['name'];
					$lang['delete'] = "<a href=\"alliance.php?mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
					$lang['a'] = $a;
					$lang['r1'] = "<b>-</b>";
					$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
					$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
					$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
					$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
					$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
					$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
					$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
					$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";

					$list .= parsetemplate($template, $lang);
				}
			}

			if (count($ally_ranks) != 0) {
				$list .= parsetemplate(gettemplate('alliance_admin_laws_feet'), $lang);
			}
		}

		$lang['list'] = $list;
		$lang['dpath'] = $dpath;
		$page .= parsetemplate(gettemplate('alliance_admin_laws'), $lang);

		display($page, $lang['Law_settings']);
	}

	if ($mode == 'admin' && $edit == 'ally') { // Administrar la alianza *pendiente urgente*
		if ($t != 1 && $t != 2 && $t != 3) {
			$t = 1;
		}
		// post!
		if ($_POST) {
			if (!get_magic_quotes_gpc()) {
				$_POST['owner_range'] = stripslashes($_POST['owner_range']);
				$_POST['web'] = stripslashes($_POST['web']);
				$_POST['image'] = stripslashes($_POST['image']);
				$_POST['text'] = stripslashes($_POST['text']);
			}
		}

		if ($_POST['options']) {
			$ally['ally_owner_range'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['owner_range'])));

			$ally['ally_web'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['web'])));

			$ally['ally_image'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['image'])));

			$ally['ally_request_notallow'] = intval($_POST['request_notallow']);

			if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1) {
				message("{$lang['Mail_info']}", "Fehler");
				exit;
			}

			doquery("UPDATE {{table}} SET
			`ally_owner_range`='{$ally['ally_owner_range']}',
			`ally_image`='{$ally['ally_image']}',
			`ally_web`='{$ally['ally_web']}',
			`ally_request_notallow`='{$ally['ally_request_notallow']}'
			WHERE `id`='{$ally['id']}'", "alliance");
		} elseif ($_POST['t']) {
			if ($t == 3) {
				$ally['ally_request'] = mysql_escape_string(strip_tags($_POST['text']));

				doquery("UPDATE {{table}} SET
				`ally_request`='{$ally['ally_request']}'
				WHERE `id`='{$ally['id']}'", "alliance");
			} elseif ($t == 2) {
				$ally['ally_text'] = mysql_escape_string(strip_tags($_POST['text']));
				doquery("UPDATE {{table}} SET
				`ally_text`='{$ally['ally_text']}'
				WHERE `id`='{$ally['id']}'", "alliance");
			} else {
				$ally['ally_description'] = mysql_escape_string(strip_tags(stripslashes($_POST['text'])));

				doquery("UPDATE {{table}} SET
				`ally_description`='" . $ally['ally_description'] . "'
				WHERE `id`='{$ally['id']}'", "alliance");
			}
		}
		$lang['dpath'] = $dpath;
		/*
	  Depende del $t, muestra el formulario para cada tipo de texto.
	*/
		if ($t == 3) {
			$lang['request_type'] = $lang['Show_of_request_text'];
		} elseif ($t == 2) {
			$lang['request_type'] = $lang['Internal_text_of_alliance'];
		} else {
			$lang['request_type'] = $lang['Public_text_of_alliance'];
		}

		if ($t == 2) {
			$lang['text'] = $ally['ally_text'];
			$lang['Texts'] = "Interner Text";
			$lang['Show_of_request_text'] = "Internet Allianz Text";
		} else {
			$lang['text'] = $ally['ally_description'];
		}

		if ($t == 3) {
		}
		$lang['t'] = $t;

		$lang['ally_web'] = $ally['ally_web'];
		$lang['ally_image'] = $ally['ally_image'];
		$lang['ally_request_notallow_0'] = (($ally['ally_request_notallow'] == 1) ? ' SELECTED' : '');
		$lang['ally_request_notallow_1'] = (($ally['ally_request_notallow'] == 0) ? ' SELECTED' : '');
		$lang['ally_owner_range'] = $ally['ally_owner_range'];
		$lang['Transfer_alliance'] = MessageForm("{$lang['Transfer_alliance']}", "", "?mode=admin&edit=give", $lang['Continue']);
		$lang['Disolve_alliance'] = MessageForm("{$lang['Disolve_alliance']}", "", "?mode=admin&edit=exit", $lang['Continue']);

		$page .= parsetemplate(gettemplate('alliance_admin'), $lang);
		display($page, $lang['Alliance_admin']);
	}

	if ($mode == 'admin' && $edit == 'members') { // Administrar a los miembros
		/*
	  En la administrar a los miembros se pueden establecer los rangos
	  para dar los diferentes derechos "Leyes"
	*/
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_kick) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		/*
	  Kickear usuarios requiere el permiso numero 1
	*/
		if (isset($kick)) {
			if ($ally['ally_owner'] != $user['id'] && !$user_can_kick) {
				message($lang['Denied_access'], $lang['Members_list']);
			}

			$u = doquery("SELECT * FROM {{table}} WHERE id='{$kick}' LIMIT 1", 'users', true);
			// kickeamos!
			if ($u['ally_id'] == $ally['id'] && $u['id'] != $ally['ally_owner']) {
				doquery("UPDATE {{table}} SET `ally_id`='0' WHERE `id`='{$u['id']}'", 'users');
			}
		} elseif (isset($_POST['newrang'])) {
			$q = doquery("SELECT * FROM {{table}} WHERE id='{$u}' LIMIT 1", 'users', true);

			if ((isset($ally_ranks[$_POST['newrang']-1]) || $_POST['newrang'] == 0) && $q['id'] != $ally['ally_owner']) {
				doquery("UPDATE {{table}} SET `ally_rank_id`='" . mysql_escape_string(strip_tags($_POST['newrang'])) . "' WHERE `id`='" . intval($id) . "'", 'users');
			}
		}
		// obtenemos las template row
		$template = gettemplate('alliance_admin_members_row');
		$f_template = gettemplate('alliance_admin_members_function');
		// El orden de aparicion
		if ($sort2) {
			// agregar el =0 para las coordenadas...
			if ($sort1 == 1) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 2) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 4) {
				$sort = " ORDER BY `ally_register_time`";
			} elseif ($sort1 == 5) {
				$sort = " ORDER BY `onlinetime`";
			} else {
				$sort = " ORDER BY `id`";
			}

			if ($sort2 == 1) {
				$sort .= " DESC;";
			} elseif ($sort2 == 2) {
				$sort .= " ASC;";
			}
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'{$sort}", 'users');
		} else {
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id={$user['ally_id']}", 'users');
		}
		// contamos la cantidad de usuarios.
		$i = 0;
		// Como es costumbre. un row template
		$page_list = '';
		$lang['memberzahl'] = mysql_num_rows($listuser);

		while ($u = mysql_fetch_array($listuser)) {
			$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $u['id'] . "';", 'statpoints', true);
			$i++;
			$u['i'] = $i;
			// Dias de inactivos
			$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";
			$days = floor(round(time() - $u["onlinetime"]) / 3600 % 24);
			$u["onlinetime"] = str_replace("%s", $days, "%s d");
			// Nombre de rango
			if ($ally['ally_owner'] == $u['id']) {
				$ally_range = ($ally['ally_owner_range'] == '')?$lang['Founder']:$ally['ally_owner_range'];
			} elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name'])) {
				$ally_range = $lang['Novate'];
			} else {
				$ally_range = $ally_ranks[$u['ally_rank_id']-1]['name'];
			}

			/*
		  Aca viene la parte jodida...
		*/
			if ($ally['ally_owner'] == $u['id'] || $rank == $u['id']) {
				$u["functions"] = '';
			} elseif ($ally_ranks[$user['ally_rank_id']-1][5] == 1 || $ally['ally_owner'] == $user['id']) {
				$f['dpath'] = $dpath;
				$f['Expel_user'] = $lang['Expel_user'];
				$f['Set_range'] = $lang['Set_range'];
				$f['You_are_sure_want_kick_to'] = str_replace("%s", $u['username'], $lang['You_are_sure_want_kick_to']);
				$f['id'] = $u['id'];
				$u["functions"] = parsetemplate($f_template, $f);
			} else {
				$u["functions"] = '';
			}
			$u["dpath"] = $dpath;
			// por el formulario...
			if ($rank != $u['id']) {
				$u['ally_range'] = $ally_range;
			} else {
				$u['ally_range'] = '';
			}
			$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
			$page_list .= parsetemplate($template, $u);
			if ($rank == $u['id']) {
				$r['Rank_for'] = str_replace("%s", $u['username'], $lang['Rank_for']);
				$r['options'] .= "<option value=\"0\">{$lang['Novate']}</option>";

				foreach($ally_ranks as $a => $b) {
					$r['options'] .= "<option value=\"" . ($a + 1) . "\"";
					if ($u['ally_rank_id']-1 == $a) {
						$r['options'] .= ' selected=selected';
					}
					$r['options'] .= ">{$b['name']}</option>";
				}
				$r['id'] = $u['id'];
				$r['Save'] = $lang['Save'];
				$page_list .= parsetemplate(gettemplate('alliance_admin_members_row_edit'), $r);
			}
		}
		// para cambiar el link de ordenar.
		if ($sort2 == 1) {
			$s = 2;
		} elseif ($sort2 == 2) {
			$s = 1;
		} else {
			$s = 1;
		}

		if ($i != $ally['ally_members']) {
			doquery("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
		}

		$lang['memberslist'] = $page_list;
		$lang['s'] = $s;
		$page .= parsetemplate(gettemplate('alliance_admin_members_table'), $lang);

		display($page, $lang['Members_administrate']);
		// a=9 es para cambiar la etiqueta de la etiqueta.
		// a=10 es para cambiarle el nombre de la alianza
	}


	if ($mode == 'admin' && $edit == 'requests') { // Administrar solicitudes
		if ($ally['ally_owner'] != $user['id'] && !$user_bewerbungen_bearbeiten) {
			message($lang['Denied_access'], $lang['Check_the_requests']);
		}

		if ($_POST['accept'] != "") {
			$_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));

			$u = doquery("SELECT * FROM {{table}} WHERE id=$show", 'users', true);
			// agrega los puntos al unirse el user a la alianza
			doquery("UPDATE {{table}} SET
			ally_members=ally_members+1
			WHERE id='{$ally['id']}'", 'alliance');

			doquery("UPDATE {{table}} SET
			ally_name='{$ally['ally_name']}',
			ally_request_text='',
			ally_request='0',
			ally_id='{$ally['id']}',
			new_message=new_message+1,
			mnl_alliance=mnl_alliance+1
			WHERE id='{$show}'", 'users');
			// Se envia un mensaje avizando...

			doquery("INSERT INTO {{table}} SET
			`message_owner`='{$show}',
			`message_sender`='{$user['id']}' ,
			`message_time`='" . time() . "',
			`message_type`='2',
			`message_from`='{$ally['ally_tag']}',
			`message_subject`='[" . $ally['ally_name'] . "] {$lang['Apply_accept']}',
			`message_text`='" . $ally['ally_name'] . "{$lang['Apply_ok']}" . $_POST['text'] . "'", "messages");

			header('Location:alliance.php?mode=admin&edit=requests');
			die();

		}
		if ($_POST['reject'] != '') {
			$_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));

			doquery("UPDATE {{table}} SET ally_request_text='',ally_request='0',ally_id='0',new_message=new_message+1, mnl_alliance=mnl_alliance+1 WHERE id='{$show}'", 'users');
			// Se envia un mensaje avizando...
			doquery("INSERT INTO {{table}} SET
			`message_owner`='{$show}',
			`message_sender`='{$user['id']}' ,
			`message_time`='" . time() . "',
			`message_type`='2',
			`message_from`='{$ally['ally_tag']}',
			`message_subject`='[" . $ally['ally_name'] . "] {$lang['Apply_reject']}',
			`message_text`='" . $ally['ally_name'] . "{$lang['Apply_cancel']}" . $_POST['text'] . "'", "messages");

			header('Location:alliance.php?mode=admin&edit=requests');
			die();
		}

		$row = gettemplate('alliance_admin_request_row');
		$i = 0;
		$parse = $lang;
		$query = doquery("SELECT id,username,ally_request_text,ally_register_time FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users');
		while ($r = mysql_fetch_array($query)) {
			// recolectamos los datos del que se eligio.
			if (isset($show) && $r['id'] == $show) {
				$s['username'] = $r['username'];
				$s['ally_request_text'] = nl2br($r['ally_request_text']);
				$s['id'] = $r['id'];
			}
			// la fecha de cuando se envio la solicitud
			$r['time'] = date("Y-m-d h:i:s", $r['ally_register_time']);
			$parse['list'] .= parsetemplate($row, $r);
			$i++;
		}
		if ($parse['list'] == '') {
			$parse['list'] = "<tr><th colspan=2>{$lang['Apply_havent']}</th></tr>";
		}
		// Con $show
		if (isset($show) && $show != 0 && $parse['list'] != '') {
			// Los datos de la solicitud
			$parse['id'] = $show;
			$parse['Request_from'] = str_replace('%s', $s['username'], $lang['Request_from']);
			// el formulario
			$parse['request'] = parsetemplate(gettemplate('alliance_admin_request_form'), $parse);
			$parse['request'] = parsetemplate($parse['request'], $lang);
		} else {
			$parse['request'] = '';
		}

		$parse['ally_tag'] = $ally['ally_tag'];
		$parse['Back'] = $lang['Back'];

		$parse['There_is_hanging_request'] = str_replace('%n', $i, $lang['There_is_hanging_request']);
		// $parse['list'] = $lang['Return_to_overview'];
		$page = parsetemplate(gettemplate('alliance_admin_request_table'), $parse);
		display($page, $lang['Check_the_requests']);
	}

	if ($mode == 'admin' && $edit == 'name') {
		 // Changer le nom de l'alliance

		$ally_ranks = unserialize($ally['ally_ranks']);
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_admin) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		if ($_POST['newname']) {
			// Y a le nouveau Nom
			$ally['ally_name'] = mysql_escape_string(strip_tags($_POST['newname']));
			doquery("UPDATE {{table}} SET `ally_name` = '". $ally['ally_name'] ."' WHERE `id` = '". $user['ally_id'] ."';", 'alliance');
			doquery("UPDATE {{table}} SET `ally_name` = '". $ally['ally_name'] ."' WHERE `ally_id` = '". $ally['id'] ."';", 'users');
		}

		$parse['question']           = str_replace('%s', $ally['ally_name'], $lang['How_you_will_call_the_alliance_in_the_future']);
		$parse['New_name']           = $lang['New_name'];
		$parse['Change']             = $lang['Change'];
		$parse['name']               = 'newname';
		$parse['Return_to_overview'] = $lang['Return_to_overview'];
		$page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
		display($page, $lang['Alliance_admin']);

	}

	if ($mode == 'admin' && $edit == 'tag') {
		// Changer le TAG l'alliance
		$ally_ranks = unserialize($ally['ally_ranks']);

		// Bon si on verifiait les autorisation ?
		if ($ally['ally_owner'] != $user['id'] && !$user_admin) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		if ($_POST['newtag']) {
			// Y a le nouveau TAG
			$ally['ally_tag'] = mysql_escape_string(strip_tags($_POST['newtag']));
			doquery("UPDATE {{table}} SET `ally_tag` = '". $ally['ally_tag'] ."' WHERE `id` = '". $user['ally_id'] ."';", 'alliance');
		}

		$parse['question']           = str_replace('%s', $ally['ally_tag'], $lang['How_you_will_call_the_alliance_in_the_future']);
		$parse['New_name']           = $lang['New_name'];
		$parse['Change']             = $lang['Change'];
		$parse['name']               = 'newtag';
		$parse['Return_to_overview'] = $lang['Return_to_overview'];
		$page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
		display($page, $lang['Alliance_admin']);
	}

	if ($mode == 'admin' && $edit == 'exit') { // disolver una alianza
		// obtenemos el array de los rangos
		$ally_ranks = unserialize($ally['ally_ranks']);
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_exit_alliance) {
			message($lang['Denied_access'], $lang['Members_list']);
		}
		/*
	  Si bien, se tendria que confirmar, no tengo animos para hacerlo mas detallado...
	  sorry :(
	*/
		doquery("DELETE FROM {{table}} WHERE id='{$ally['id']}'", "alliance");
		header('Location: alliance.php');
		exit;
	}
	{
	 // Default *falta revisar...*
		if ($ally['ally_owner'] != $user['id']) {
			$ally_ranks = unserialize($ally['ally_ranks']);
		}
		// Imagen de la alianza
		if ($ally['ally_ranks'] != '') {
			$ally['ally_ranks'] = "<tr><td colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>";
		}
		// temporalmente...
		if ($ally['ally_owner'] == $user['id']) {
			$range = ($ally['ally_owner_range'] != '')?$lang['Founder']:$ally['ally_owner_range'];
		} elseif ($user['ally_rank_id'] != 0 && isset($ally_ranks[$user['ally_rank_id']-1]['name'])) {
			$range = $ally_ranks[$user['ally_rank_id']-1]['name'];
		} else {
			$range = $lang['member'];
		}
		// Link de la lista de miembros
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['memberlist'] != 0) {
			$lang['members_list'] = " (<a href=\"?mode=memberslist\">{$lang['Members_list']}</a>)";
		} else {
			$lang['members_list'] = '';
		}
		// El link de adminstrar la allianza
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['administrieren'] != 0) {
			$lang['alliance_admin'] = " (<a href=\"?mode=admin&edit=ally\">{$lang['Alliance_admin']}</a>)";
		} else {
			$lang['alliance_admin'] = '';
		}
		// El link de enviar correo circular
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['mails'] != 0) {
			$lang['send_circular_mail'] = "<tr><th>{$lang['Circular_message']}</th><th><a href=\"?mode=circular\">{$lang['Send_circular_mail']}</a></th></tr>";
		} else {
			$lang['send_circular_mail'] = '';
		}
		// El link para ver las solicitudes
		$lang['requests'] = '';
		$request = doquery("SELECT id FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users');
		$request_count = mysql_num_rows($request);
		if ($request_count != 0) {
			if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['bewerbungen'] != 0)
				$lang['requests'] = "<tr><th>{$lang['Requests']}</th><th><a href=\"alliance.php?mode=admin&edit=requests\">{$request_count} {$lang['XRequests']}</a></th></tr>";
		}
		if ($ally['ally_owner'] != $user['id']) {
			$lang['ally_owner'] .= MessageForm($lang['Exit_of_this_alliance'], "", "?mode=exit", $lang['Continue']);
		} else {
			$lang['ally_owner'] .= '';
		}
		// La imagen de logotipo
		$lang['ally_image'] = ($ally['ally_image'] != '')?
		"<tr><th colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>":'';
		// $ally_image =
		$lang['range'] = $range;
		// codigo raro
		$patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
		$replacements[] = '<font color="\1">\2</font>';
		$patterns[] = '#\[img\](.*?)\[/img\]#Smi';
		$replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
		$patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
		$replacements[] = '<font color="\1">';
		$patterns[] = "#\[/f\]#Ssi";
		$replacements[] = '</font>';
		$ally['ally_description'] = preg_replace($patterns, $replacements, $ally['ally_description']);
		$lang['ally_description'] = nl2br($ally['ally_description']);

		$ally['ally_text'] = preg_replace($patterns, $replacements, $ally['ally_text']);
		$lang['ally_text'] = nl2br($ally['ally_text']);

		$lang['ally_web'] = $ally['ally_web'];
		$lang['ally_tag'] = $ally['ally_tag'];
		$lang['ally_members'] = $ally['ally_members'];
		$lang['ally_name'] = $ally['ally_name'];

		$page .= parsetemplate(gettemplate('alliance_frontpage'), $lang);
		display($page, $lang['your_alliance']);
	}
}

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>