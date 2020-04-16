<?php

/**
 * planetlist.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);


	if ($user['authlevel'] >= "2") {
		includeLang('admin');
		$parse = $lang;

		$query = doquery("SELECT `id`, `id_owner`, `name`,  `field_current`, `field_max`, `galaxy`, `system`, `planet` FROM {{table}} WHERE planet_type=1 order by `id_owner`, id", "planets");
		$i = 0;
		while ($u = mysql_fetch_array($query)) {
			$parse['planetes'] .= "<tr>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['id']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['id_owner']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['name']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['field_max']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['field_current']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['galaxy']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['system']}</a></center></b></td>"
			. "<td class=b><center><b><a href='planetlist.php?action=edit&id={$u['id']}'>{$u['planet']}</a></center></b></td>"
			. "</tr>";
			$i++;
		}

		$parse['planetes'] .= "<tr><th class=b colspan=8>" . sprintf($lang['adm_pl_amount'], $i) . "</th></tr>";
		
		if(isset($_GET['action']) && isset($_GET['id'])) {
			$id = intval($_GET['id']);
			$query  = doquery("SELECT `id`, `id_owner`, `name`,  `field_current`, `field_max`, `galaxy`, `system`, `planet` FROM {{table}} WHERE planet_type=1 AND id='{$id}' LIMIT 1", "planets");
			$planet = mysql_fetch_array($query);
			$parse['show_edit_form'] = "<form action='' method='post'>
										 <input type='hidden' name='currid' value='{$planet['id']}'>
										 <table width='750' style='color:#FFFFFF'>
										 <tr>
											<td class='c' colspan='9'> 
												" . sprintf($lang['adm_pl_edit'], $planet['name']) . "
											</td>
										  </tr>
										  <tr>
										   <th>{$parse['adm_pl_no']}</td>
										   <th>{$parse['adm_pl_id']}</td>
										   <th>{$parse['adm_pl_name']}</td>
										   <th>{$parse['adm_pl_name']}</td>
										   <th>{$parse['adm_pl_area_all']}</td>
										   <th>{$parse['adm_pl_area_use']}</td>
										   <th>{$parse['adm_pl_galaxy']}</td>
										   <th>{$parse['adm_pl_system']}</td>
										   <th>{$parse['adm_pl_planet']}</td>
										  </tr>
										  <tr style='text-align:center;'>
										   <td class=b>{$planet['id']}</td>
										   <td class=b>{$planet['id_owner']}</td>
										   <td class=b>{$planet['name']}</td>
										   <td class=b><input type='text' name='planetname' size='15' value='{$planet['name']}'></td>
										   <td class=b><input type='text' name='felder' size='4' maxlength='4' value='{$planet['field_max']}'></td>
										   <td class=b>{$planet['field_current']}</td>
										   <td class=b>{$planet['galaxy']}</td>
										   <td class=b>{$planet['system']}</td>
										   <td class=b>{$planet['planet']}</td>
										  </tr>
										  <tr>
										   <td colspan='9'><input type='submit' name='submit' value='{$parse['adm_pl_save']}'></td>
										  </tr>
										  </table>
										  </form>";
		}
		if(isset($_POST['submit'])) {
			
			$edit_id 	= intval($_POST['currid']);
			$planetname = mysql_real_escape_string($_POST['planetname']);
			$fields_max = intval($_POST['felder']);
			$query = doquery("UPDATE {{table}} SET `name` = '{$planetname}', `field_max` = '{$fields_max}' WHERE `id` = '{$edit_id}' LIMIT 1",'planets'); 
			AdminMessage ("<meta http-equiv='refresh' content='1; url=planetlist.php'>{$parse['adm_pl_success']}", $parse['adm_pl_save_info']);
		}
		display(parsetemplate(gettemplate('admin/planetlist_body'), $parse), 'Planetlist', false, '', true);
	} else {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>