<div id="header_top">
<center>
<table class="header">
<tbody>
<tr>
	<td>
		<center>
		<table>
		<tbody>
		<tr>
			<td rowspan="3"><img src="{dpath}planeten/small/s_{image}.jpg" height="70" width="70"></td>
			<td valign="middle" height="35">
				<select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
				{planetlist}
				</select>			</td>
		</tr>
		<tr>
			<td valign="middle" align="right" style="font-weight:bold; color:#FF9900;">{resources_title}</td>
		</tr>
		<tr>
			<td align="right" valign="middle" style="font-weight:bold; color:#FF9900;">{capacity_title}</td>
		</tr>
		</tbody>
		</table>
		</center>
	</td>
	<td>
		<table style="width: 508px;" id="resources" padding-right="30" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr>
			<td align="center" width="140"><img src="{dpath}images/metall.gif" border="0" height="22" width="42"></td>
			<td align="center" width="140"><img src="{dpath}images/kristall.gif" border="0" height="22" width="42"></td>
			<td align="center" width="140"><img src="{dpath}images/deuterium.gif" border="0" height="22" width="42"></td>
			<td align="center" width="140"><img src="{dpath}images/energie.gif" border="0" height="22" width="42"></td>
			<td align="center" width="140"><img src="{dpath}images/message.gif" border="0" height="22" width="42"></td>
		</tr>
		<tr>
			<td align="center" width="140"><i><b><font color="#ffffff">{Metal}</font></b></i></td>
			<td align="center" width="140"><i><b><font color="#ffffff">{Crystal}</font></b></i></td>
			<td align="center" width="140"><i><b><font color="#ffffff">{Deuterium}</font></b></i></td>
			<td align="center" width="140"><i><b><font color="#ffffff">{Energy}</font></b></i></td>
			<td align="center" width="140"><i><b><font color="#ffffff">{Message}</font></b></i></td>
		</tr>
		<tr>
			<td width="140" align="center">{metal}</td>
			<td align="center" width="140">{crystal}</td>
			<td align="center" width="140">{deuterium}</td>
			<td align="center" width="140">{energy}</td>
			<td align="center" width="140"><a href="messages.php">[ {message} ]</a></td>
		</tr>
		<tr>
			<td align="center" width="140">{metal_max}</td>
			<td align="center" width="140">{crystal_max}</td>
			<td align="center" width="140">{deuterium_max}</td>
			<td align="center" width="140">{energy_max}</td>
			<td align="center" width="140"><a href="messages.php">[ {message_all} ]</a></td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</center>
</div>