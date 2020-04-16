<div id='leftmenu'>
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
</script>
<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<center>
<div id='menu'>
<br>
<table width="130" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" style="border-top: 1px #545454 solid"><div><center>{servername}<br><a href="changelog.php" target={mf}>(<font color=red>{XNovaRelease}</font>)</a><center></div></td>
</tr><tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{devlp}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="overview.php" accesskey="g" target="{mf}">{Overview}</a></div></td>
</tr><tr>
	<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php" accesskey="b" target="{mf}">{Buildings}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=research" accesskey="r" target="{mf}">{Research}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=fleet" accesskey="f" target="{mf}">{Shipyard}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=defense" accesskey="d" target="{mf}">{Defense}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="officier.php" accesskey="o" target="{mf}">{Officiers}</a></div></td>
</tr>
{marchand_link}
<tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{navig}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="alliance.php" accesskey="a" target="{mf}">{Alliance}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="fleet.php" accesskey="t" target="{mf}">{Fleet}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="messages.php" accesskey="c" target="{mf}">{Messages}</a></div></td>
</tr><tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{observ}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="galaxy.php?mode=0" accesskey="s" target="{mf}">{Galaxy}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="imperium.php" accesskey="i" target="{mf}">{Imperium}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="resources.php" accesskey="r" target="{mf}">{Resources}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="techtree.php" accesskey="g" target="{mf}">{Technology}</a></div></td>
</tr><tr>
	<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>
</tr><tr>
	<td colspan="2"><div><a href="records.php" accesskey="3" target="{mf}">{Records}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="stat.php?range={user_rank}" accesskey="k" target="{mf}">{Statistics}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="search.php" accesskey="b" target="{mf}">{Search}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="banned.php" accesskey="3" target="{mf}">{blocked}</a></div></td>
</tr>
{annonce_link}
<tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{commun}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="buddy.php" accesskey="c" target="{mf}">{Buddylist}</a></div></td>
</tr>
{notes_link}
<!--tr>
	<td colspan="2"><div><a href="chat.php" accesskey="a" target="{mf}">{Chat}</a></div></td>
</tr--><tr>
	<td colspan="2"><div><a href="{forum_url}" accesskey="1" target="{mf}">{Board}</a></div></td>
</tr><!--tr>
	<td colspan="2"><div><a href="add_declare.php" accesskey="1" target="{mf}">{Declare}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="rules.php"  accesskey="c" target="{mf}">{Rules}</a></div></td>
</tr--><tr>
	<td colspan="2"><div><a href="contact.php" accesskey="3" target="{mf}" >{Contact}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="options.php" accesskey="o" target="{mf}">{Options}</a></div></td>
</tr>
	{ADMIN_LINK}
	{added_link}
<tr>
	<td colspan="2"><div><a href="javascript:top.location.href='logout.php'" accesskey="s" style="color:red">{Logout}</a></div></td>
</tr><tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{infog}</center></td>
</tr>
	{server_info}
<tr>
	<td colspan="2"><div><center><a href="credit.php" accesskey="T" target="{mf}">{team_name}</a><br>&copy; Copyright 2008</center></div></td>
</tr>
</table>
</div>
</center>
</body>
</div>