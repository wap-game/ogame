<?php

/**
 * chat_add.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	// On récupère les informations du message et de l'envoyeur
	if (isset($_POST["msg"]) && isset($user['username'])) {
	   $nick = trim (str_replace ("+","plus",$user['username']));
	   $msg  = trim (str_replace ("+","plus",$_POST["msg"]));
	   $msg  = addslashes ($_POST["msg"]);
	   $nick = addslashes ($user['username']);
	}
	else {
	   $msg="";
	   $nick="";
	}

	// Ajout du message dans la database
	if ($msg!="" && $nick!="") {
	   $query = doquery("INSERT INTO {{table}}(user, message, timestamp) VALUES ('".$nick."', '".$msg."', '".time()."')", "chat");
	}

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>