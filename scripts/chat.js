// Définition du pseudo
var nick="<?php print $nick; ?>";
var nick=nick.replace(/\+/,"plus");

// Scrolling automatique
function descendreTchat(){
 	var elDiv =document.getElementById('shoutbox');
 	elDiv.scrollTop = elDiv.scrollHeight-elDiv.offsetHeight;
}

// Ajout de message
function addMessage(){
	var x_object = null;
	if(window.XMLHttpRequest){
		x_object = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		x_object = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		alert('AJAX Error');
		return;
	}
	x_object.open("POST","chat_add.php",true); 
	x_object.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	msg.value=msg.value.replace(/\+/g,"plus");
//	alert(msg.value);
	x_object.send("nick="+nick+"&msg="+msg.value);
	msg.value = "";
	showMessage();
}

// Affichage des messages
function showMessage(){
var x_object2 = null;
	if(window.XMLHttpRequest){
		x_object2 = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		x_object2 = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		alert('AJAX Error');
	return;
	}
	x_object2.open("POST","chat_msg.php",true);
	x_object2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	x_object2.send(null);
	
	x_object2.onreadystatechange = function(){
		if(x_object2.readyState==4){
			if(x_object2.status==200){
			document.getElementById('shoutbox').innerHTML = x_object2.responseText;
//			alert(x_object2.responseText);
			descendreTchat();
//			Layer1.style.visibility="hidden";
			}
		}
	}
	
}

// Raccourcis des smileys
function addSmiley(smiley){
	msg.value=msg.value+smiley;
	msg.focus();
}

// Intervalle entre les messages
setInterval(showMessage,3000);