<?php

/**
 * index.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

if (filesize('config.php') == 0) {
	header('location: install/');
	exit();
}

header('location: login.php');

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Creation avec redirection vers l'installeur si pas de config.php
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>