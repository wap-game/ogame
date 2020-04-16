<?php

/**
 * CheckUser.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function CheckTheUser ( $IsUserChecked ) {
	global $user;
	
	includeLang('admin');
	$Result        = @CheckCookies( $IsUserChecked );
	$IsUserChecked = $Result['state'];
	

	if ($Result['record'] != false) {
		$user = $Result['record'];
		if ($user['bana'] == "1") {
			die (

			$page .= parsetemplate(gettemplate('usr_banned'), $lang)

			);
		}
		$RetValue['record'] = $user;
		$RetValue['state']  = $IsUserChecked;
	} else {
		$RetValue['record'] = array();
		$RetValue['state']  = false;
	}

	return $RetValue;
}


?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>