<?php

/**
 * ainfo.php
 *
 * @version 0.5
 * @copyright 2008 by Tom1991 for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('galaxy');

$Attaquant = $_GET['current'];
$NbreMip   = $_POST['SendMI'];

$Galaxy    = $_GET['galaxy'];
$System    = $_GET['system'];
$Planet    = $_GET['planet'];

$PlaneteAttaquant = doquery("SELECT * FROM {{table}} WHERE `id`='" . $Attaquant . "'", "planets", true);
$PlaneteAdverse   = doquery("SELECT * FROM {{table}} WHERE galaxy = " . $Galaxy . " AND system = " . $System . " AND planet = " . $Planet . "", "planets", true);

$MipAttaquant = $PlaneteAttaquant['interplanetary_misil'];
if ($MipAttaquant < $NbreMip) {
    message($lang['no_missile'], $lang['error']);
}

$AntiMipAdverse = $PlaneteAdverse['interceptor_misil'];
$MipRestant     = $NbreMip - $AntiMipAdverse;
$AntiMipRestant = $$AntiMipAdverse - $NbreMip;

echo $MipRestant;
echo $AntiMipRestant;
// L'attaquant se fait exploser tout ses MIP
if ($MipRestant <= 0) {
    doquery("UPDATE {{table}} SET `interplanetary_misil`='0' WHERE `id`='" . $Attaquant . "'", "planets");
    doquery("UPDATE {{table}} SET `interceptor_misil`='" . $AntiMipRestant . "' WHERE `id`='" . $PlaneteAdverse['id_owner'] . "'", "planets");

    $Owner    = $user['id'];
    $Sender   = "0";
    $Time     = time();
    $Type     = 3;
    $From     = $lang['gm_from'];
    $Subject  = $lang['gm_subject'];
    $Message  = $lang['gm_message'];
    SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);


    $Owner2   = $PlaneteAdverse['id_owner'];
    $Message2 = $lang['gm_message21'] . $NbreMip . $lang['gm_message221'] . $AntiMipRestant . $lang['gm_message23'];
    SendSimpleMessage($Owner2, $Sender, $Time, $Type, $From, $Subject, $Message2);
}

if($MipRestant > 0){
	$Id = $PlaneteAdverse['id'];
	MipAttack($NbreMip, $Id);
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>