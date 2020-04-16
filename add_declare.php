<?php

/**
 * add_declare.php
 *
 * @version 1.1
 Base SQL requise :
 
 CREATE TABLE `game_declared` (
  `declarator` text NOT NULL,
  `declared_1` text NOT NULL,
  `declared_2` text NOT NULL,
  `declared_3` text NOT NULL,
  `reason` text NOT NULL,
  `declarator_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
 
 */


define('INSIDE'  , true );
define('INSTALL' , false);

$ugamela_root_path = './';
include( $ugamela_root_path . 'extension.inc' );
include( $ugamela_root_path . 'common.' . $phpEx );


		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("add_declare");
		$parse     = $lang;

		if ($mode == 'addit') {
			$declarator              = $user['id'];
			$declarator_name  = addslashes(htmlspecialchars($user['username']));
			$decl1        	   		  = addslashes(htmlspecialchars($_POST['dec1']));
			$decl2       		       = addslashes(htmlspecialchars($_POST['dec2']));
			$decl3        		      = addslashes(htmlspecialchars($_POST['dec3']));
			$reason1        	  	 = addslashes(htmlspecialchars($_POST['reason']));

			$QryDeclare  = "INSERT INTO {{table}} SET ";
			$QryDeclare .= "`declarator` = '". $declarator ."', ";
			$QryDeclare .= "`declarator_name` = '". $declarator_name ."', ";			$QryDeclare .= "`declared_1` = '". $decl1 ."', ";
			$QryDeclare .= "`declared_2` = '". $decl2 ."', ";
			$QryDeclare .= "`declared_3` = '". $decl3 ."', ";
			$QryDeclare .= "`reason`     = '". $reason1 ."' ";
	
			doquery( $QryDeclare, "declared");
			doquery("UPDATE {{table}} SET multi_validated ='1' WHERE username='{$user['username']}'","users");

			AdminMessage ( $parse['adm_end_con'], $parse['adm_end_info'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, "Declaration d\'IP partagee", false, '', true);


?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>