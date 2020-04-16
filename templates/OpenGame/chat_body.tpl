<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>
<script language="JavaScript" type="text/javascript">
	function switchChatBar(){
		if (parent.document.getElementById('ogameframe').rows=="*,105"){	
			parent.document.getElementById('ogameframe').rows="*,15";
			document.getElementById('switchbar').innerHTML = "{chat_show}";
		}
		else{
			parent.document.getElementById('ogameframe').rows="*,105";		
			document.getElementById('switchbar').innerHTML = "{chat_hidden}";
		}
	}
</script>
    <style type="text/css">
		body
		{
		  background-image : url(skins/xnova/img/bottom_bg.jpg);
		}
    </style>
<table width='100%' height="100%" border="0" align="center" valign="top" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="c" align="center"><a href="#" onclick="switchChatBar()" id="switchbar">{chat_hidden}</a></td>
  </tr>
  <tr>
    <th width='60%'> <div id="shoutbox" style="margin: 0px; vertical-align: text-top; height: 87; overflow:auto; "></div></th>
    <th width='40%'> <table width="100%" align="center">
      <tr>
        <th> <input name="msg" type="text" id="msg" size="45" maxlength="100"
                            onkeypress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;" />
              <input type="button" name="send" value="{chat_send}" id="send" onclick="addMessage()" />
        </th>
      </tr>
      <tr>
        <th><img src="images/smileys/cry.png" align="absmiddle"
                        title=":c" alt=":c" width="12" height="12" onclick="addSmiley(':c')" /> <img src="images/smileys/confused.png" align="absmiddle" title=":/"
                        alt=":/" width="12" height="12" onclick="addSmiley(':/')" /> <img
                        src="images/smileys/dizzy.png" align="absmiddle" title="o0" alt="o0"
                        width="12" height="12" onclick="addSmiley('o0')" /> <img
                        src="images/smileys/happy.png" align="absmiddle" title="^^" alt="^^"
                        width="12" height="12" onclick="addSmiley('^^')" /> <img
                        src="images/smileys/lol.png" align="absmiddle" title=":D" alt=":D"
                        width="12" height="12" onclick="addSmiley(':D')" /> <img
                        src="images/smileys/neutral.png" align="absmiddle" title=":|"
                        alt=":|" width="12" height="12" onclick="addSmiley(':|')" /> <img
                        src="images/smileys/smile.png" align="absmiddle" title=":)" alt=":)"
                        width="12" height="12" onclick="addSmiley(':)')" /> <img
                        src="images/smileys/omg.png" align="absmiddle" title=":o" alt=":o"
                        width="12" height="12" onclick="addSmiley(':o')" /> <img
                        src="images/smileys/tongue.png" align="absmiddle" title=":p" alt=":p"
                        width="12" height="12" onclick="addSmiley(':p')" /> <img
                        src="images/smileys/sad.png" align="absmiddle" title=":(" alt=":("
                        width="12" height="12" onclick="addSmiley(':(')" /> <img
                        src="images/smileys/wink.png" align="absmiddle" title=";)" alt=";)"
                        width="12" height="12" onclick="addSmiley(';)')" /> <img
                        src="images/smileys/shit.png" align="absmiddle" title=":s" alt=":s"
                        width="12" height="12" onclick="addSmiley(':s')" /> </th>
      </tr>
    </table></th>
  </tr>
</table>
