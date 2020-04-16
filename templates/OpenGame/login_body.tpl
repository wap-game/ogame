<div id="main">
	<script type="text/javascript">
    var lastType = "";
    function changeAction(type) {
  
		if(document.formular.username.value=='') {
			alert('{log_username}');
			return false;
		}
		if(document.formular.password.value=='') {
			alert('{log_password}');
			return false;
		}
		if(type == "login" && lastType == "") {
			var url = "http://" + $_SERVER['HTTP_HOST'] + "/ogame/login.php";
			document.formular.action = url;
			return true;
		}
		return false;
    }
    </script>
    <div id="login">
        <div id="login_input">
            <form name="formular" action="" method="post" onsubmit="return changeAction('login');">
                <table width="400" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr style="vertical-align: top;">
                            <td style="padding-right: 4px;">
                              
                                   
                                </select>
                                {User_name} <input name="username" value="" type="text">
                                {Password} <input name="password" value="" type="password">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-right: 4px; font:12px;">
                                <a href="lostpassword.php">{PasswordLost}</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
                                <input name="rememberme" type="checkbox">{Remember_me} &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
                                <input name="submit" value="{Login}" type="submit" style="font:12px;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
			<script type="text/javascript">document.formular.Uni.focus(); </script>
        </div>
    </div>
    <div id="mainmenu" style="margin-top: 0px;">
        <a href="{forum_url}" target="_blank">{Forum}</a>
        <a href="contact.php" target="_blank">{Contact}</a>
        <!--a href="credit.php" target="_blank">{log_cred}</a-->
        <a>————</a>
        <a href="http://www.ppdream.com/plus/view.php?aid=55" target="_blank">新手教程</a>
        <a href="http://www.ppdream.com/plus/list.php?tid=25" target="_blank">银河资讯</a>
        <a href="http://www.ppdream.com/plus/list.php?tid=14" target="_blank">建筑资料</a>
        <a href="http://www.ppdream.com/plus/list.php?tid=13" target="_blank">研究资料</a>
        <a href="http://www.ppdream.com/plus/list.php?tid=12" target="_blank">舰队资料</a>
        <a href="http://www.ppdream.com/plus/list.php?tid=11" target="_blank">防御资料</a>
    </div>
    <div id="rightmenu" class="rightmenu">
        <div id="title">{log_welcome} {servername}</div>
        <div id="content">
            <center>
                <div id="text1">
                    <div style="text-align: left;"><strong>{servername}</strong> {log_desc}</div>
                </div>
                <div id="register" class="bigbutton">
                    <a href="reg.php" style="color:#cc0000;">{log_toreg}</a>
                    <a href="http://www.ppdream.com/bbs/forumdisplay.php?fid=4" style="color:#cc0000;">{log_tosource}</a>
                </div>
                <div id="text2">
                    <div id="text3">
                        <center><b><font color="#00cc00">{log_online}: </font>
                        <font color="#c6c7c6">{online_users}</font> - <font color="#00cc00">{log_lastreg}: </font>
                        <font color="#c6c7c6">{last_user}</font> - <font color="#00cc00">{log_numbreg}:</font> <font color="#c6c7c6">{users_amount}</font>
                        </b></center>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
