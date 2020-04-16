<?php

define('INSIDE' , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('messages');
includeLang('system');


$Mode = $_GET['mode'];


if ($Mode != 'add') {

    $parse['Declaration']     = $lang['Declaration'];
    $parse['DeclarationText'] = $lang['DeclarationText'];

    $page = parsetemplate(gettemplate('multi'), $parse);
    display($page, $lang['messages']);

}
if ($mode == 'add') {
    $Texte = $_POST['texte'];
    $Joueur = $user['username'];

    $SQLAjoutDeclaration = "INSERT INTO {{table}} SET ";
    $SQLAjoutDeclaration .= "`player` = '". $Joueur ."', ";
	$SQLAjoutDeclaration .= "`text` = '". $Texte ."';";
    doquery($SQLAjoutDeclaration, 'multi');


    message($lang['sys_request_ok'],$lang['sys_ok']);

}
// Déclaration des multi compte
// Par Tom pour XNova
?>

<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>