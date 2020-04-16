<br />
<br />
<h2>{adm_opt_title}</h2>
<form action="" method="post"><input type="hidden"
	name="opt_save" value="1">
<table width="519" style="color: #FFFFFF">
	<tbody>
		<tr>
			<td class="c" colspan="2">{adm_opt_game_settings}</td>
		</tr>
		<tr>
			<th>{adm_opt_game_name}</th>
			<th><input name=game_name size=20 value={game_name} type=text></th>
		</tr>
		<tr>
			<th>{adm_opt_game_gspeed}</th>
			<th><input name="game_speed" size="20" value="{game_speed}"
				type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_game_fspeed}</th>
			<th><input name="fleet_speed" size="20" value="{fleet_speed}"
				type="text"></th>
		</tr>
		<tr>
			<th>{MAX_FLEET_OR_DEFS_PER_ROW}</th>
			<th><input name="max_fleet" size="20" value="{max_fleet}"
				type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_game_pspeed}</th>
			<th><input name="resource_multiplier" maxlength="20" size="20"
				value="{resource_multiplier}" type="text"></th>
		</tr>
		<tr>
			<th>{stat_settings_desc}</th>
			<th>{stat_desc}<input name="stat_settings" size="10"
				value="{stat_settings}" type="text"> {stat_units}</th>
		</tr>
		<tr>
			<th>{adm_opt_plan_initial}</th>
			<th><input name="initial_fields" maxlength="20" size="10"
				value="{initial_fields}" type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_plan_base_inc}{Metal}</th>
			<th><input name="metal_basic_income" maxlength="20" size="10"
				value="{metal_basic_income}" type="text"> {par_hour}</th>
		</tr>
		<tr>
			<th>{adm_opt_plan_base_inc}{Crystal}</th>
			<th><input name="crystal_basic_income" maxlength="20" size="10"
				value="{crystal_basic_income}" type="text"> {par_hour}</th>
		</tr>
		<tr>
			<th>{adm_opt_plan_base_inc}{Deuterium}</th>
			<th><input name="deuterium_basic_income" maxlength="20" size="10"
				value="{deuterium_basic_income}" type="text"> {par_hour}</th>
		</tr>
		<tr>
			<th>{adm_opt_plan_base_inc}{Energy}</th>
			<th><input name="energy_basic_income" maxlength="20" size="10"
				value="{energy_basic_income}" type="text"> {par_hour}</th>
		</tr>
		<tr>
			<th>{MAX_BUILDING_QUEUE_SIZE}</th>
			<th><input name="max_building" maxlength="20" size="20"
				value="{max_building}" type="text"></th>
		</tr>
		<tr>
			<th>{MAX_PLAYER_PLANETS}</th>
			<th><input name="max_player_planets" maxlength="20" size="20"
				value="{max_player_planets}" type="text"></th>
		</tr>
		<tr>
			<th>{MAX_GALAXY_IN_WORLD}</th>
			<th><input name="max_galaxy" maxlength="20" size="20"
				value="{max_galaxy}" type="text"></th>
		</tr>
		<tr>
			<th>{MAX_SYSTEM_IN_GALAXY}</th>
			<th><input name="max_system" maxlength="20" size="20"
				value="{max_system}" type="text"></th>
		</tr>
		<tr>
			<th>{MAX_PLANET_IN_SYSTEM}</th>
			<th><input name="max_planet" maxlength="20" size="20"
				value="{max_planet}" type="text"></th>
		</tr>
		<tr>
			<th>{BASE_STORAGE_SIZE}</th>
			<th><input name="base_storage" maxlength="20" size="20"
				value="{base_storage}" type="text"></th>
		</tr>
		<tr>
			<th>{BUILD_METAL}</th>
			<th><input name="build_metal" maxlength="20" size="20"
				value="{build_metal}" type="text"></th>
		</tr>
		<tr>
			<th>{BUILD_CRISTAL}</th>
			<th><input name="build_cristal" maxlength="20" size="20"
				value="{build_cristal}" type="text"></th>
		</tr>
		<tr>
			<th>{BUILD_DEUTERIUM}</th>
			<th><input name="build_deuterium" maxlength="20" size="20"
				value="{build_deuterium}" type="text"></th>
		</tr>
		<tr>
			<th>{MAX_OVERFLOW}</th>
			<th><input name="max_overflow" maxlength="20" size="20"
				value="{max_overflow}" type="text"></th>
		</tr>
		<tr>
			<th>{FIELDS_BY_MOONBASIS_LEVEL}</th>
			<th><input name="moonbasis_level" maxlength="20" size="20"
				value="{moonbasis_level}" type="text"></th>
		</tr>
		<tr>
			<th>{SPY_REPORT_ROW}</th>
			<th><input name="report_row" maxlength="20" size="20"
				value="{report_row}" type="text"></th>
		</tr>
		<tr>
			<th>{SHOW_ADMIN_IN_RECORDS}</th>
			<th><input name="show_admin" maxlength="20" size="20"
				value="{show_admin}" type="text"></th>
		</tr>
		<tr>
			<th>{ADMINEMAIL}<br />
			</th>
			<th><input name="admin_email" size="40" maxlength="254"
				value="{admin_email}" type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_game_forum}<br />
			</th>
			<th><input name="forum_url" size="40" maxlength="254"
				value="{forum_url}" type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_game_online}<br />
			</th>
			<th><input name="closed" {closed} type="checkbox" /></th>
		</tr>
		<tr>
			<th>{adm_opt_menu_link_enable}</th>
			<th><input name="enable_link_" size="20" value="{enable_link}"
				type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_menu_link_text}</th>
			<th><input name="name_link_" size="20" value="{name_link}"
				type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_menu_link_url}</th>
			<th><input name="url_link_" size="20" value="{url_link}"
				type="text"></th>
		</tr>
		<tr>
			<th>{adm_opt_game_offreaso}<br />
			</th>
			<th><textarea name="close_reason" cols="80" rows="5" size="80">{close_reason}</textarea></th>
		</tr>
		<tr>
			<th>{adm_opt_game_noobpr}</th>
			<th><input name="noobprotection" maxlength="1" size="5" value="{noobprotection}" type="text"></th>
		</tr><tr>
			<th>{adm_opt_game_noobti}</th>
			<th><input name="noobprotectiontime" maxlength="7" size="5" value="{noobprotectiontime}" type="text"></th>
		</tr><tr>
			<th>{adm_opt_game_noobmu}</th>
			<th><input name="noobprotectionmulti" maxlength="1" size="5" value="{noobprotectionmulti}" type="text"></th>
		</tr>
		<tr>
			<td class="c" colspan="2">{messages_settings}</td>
		</tr>
		<tr>
			<th>{bbcode_settings}<br />
			</th>
			<th><input name="bbcode_field" size="1" maxlength="254"
				value="{enable_bbcode}" type="text"></th>
		</tr>
		<tr>
			<td class="c" colspan="2">{multi_bot_settings}</td>
		</tr>
		<tr>
			<th>{bot_active}</th>
			<th><input name="bot_enable" size="1" value="{enable_bot}"
				type="text"></th>
		</tr>
		<tr>
			<th>{bot_name_multi}</th>
			<th><textarea name="name_bot" cols="1" rows="1" size="80">{bot_name}</textarea></th>
		</tr>
		<tr>
			<th>{bot_adress_multi}</th>
			<th><textarea name="adress_bot" cols="80" rows="1" size="80">{bot_adress}</textarea></th>
		</tr>
		<tr>
			<th>{bot_ban_duration}</th>
			<th><input name="duration_ban" size="20" value="{ban_duration}"
				type="text"></th>
		</tr>
		<tr>
			<td class="c" colspan="2">{adm_opt_plan_settings}</td>
		</tr>
		<tr>
			<td class="c" colspan="2">{adm_opt_control_pages}</td>
		</tr>
		<tr>
			<th>{enable_the_anounces}</th>
			<th><input name="enable_announces_" size="1"
				value="{enable_announces}" type="text"></th>
		</tr>
		<tr>
			<th>{enable_the_marchand}</th>
			<th><input name="enable_marchand_" size="1"
				value="{enable_marchand}" type="text"></th>
		</tr>
		<tr>
			<th>{enable_the_notes}</th>
			<th><input name="enable_notes_" size="1" value="{enable_notes}"
				type="text"></th>
		</tr>
		<tr>
			<td class="c" colspan="2">{adm_opt_game_oth_info}</td>
		</tr>
		<tr>
			<th>{adm_opt_game_oth_bann}<br />
			</th>
			<th><input name="bannerframe" {bannerframe} type="checkbox" />({adm_opt_warning1})</th>
		</tr>
		<tr>
			<th>{adm_opt_game_oth_news}<br />
			</th>
			<th><input name="newsframe" {newsframe} type="checkbox" /></th>
		</tr>
		<tr>
			<th colspan="2"><textarea name="NewsText" cols="80" rows="5"
				size="80">{NewsTextVal}</textarea></th>
		</tr>
		<tr>
			<th>{adm_opt_game_oth_chat}</th>
			<th><input name="chatframe" {chatframe} type="checkbox" /></th>
		</tr>
		<tr>
			<th colspan="2"><textarea name="ExternChat" cols="80" rows="5"
				size="80">{ExtTchatVal}</textarea></th>
		</tr>
		<tr>
			<th>{adm_opt_game_oth_adds}</th>
			<th><input name="googlead" {googlead} type="checkbox" /></th>
		</tr>
		<tr>
			<th colspan="2"><textarea name="GoogleAds" cols="80" rows="5"
				size="80">{GoogleAdVal}</textarea></th>
		</tr>
		<tr>
			<th>{adm_opt_game_debugmod}</a></th>
			<th><input name="debug" {debug} type="checkbox" /></th>
		</tr>
		<tr>
			<th>{banner}</th>
			<th><textarea name="banner_source_post" cols="80" rows="1"
				size="80">{banner_source_post}</textarea></th>
		</tr>
		<tr>
			<th colspan="2"><img src="{banner_source_post}"
				alt="{banner_source_post}" title="{banner_source_post}"></th>
		</tr>
		</tr>
		<th colspan="3"><input value="{adm_opt_btn_save}" type="submit"></th>
		</tr>
	</tbody>
</table>
</form>