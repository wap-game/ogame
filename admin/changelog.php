<?php

/**
 * changelog.php
 *
 * @version 1.0
 * @copyright 2008 by Perberos
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('changelog');
$template = gettemplate('changelog_table');

$parse = $lang;

foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description']    = nl2br($b);

	$body .= parsetemplate($template, $parse);

}

$parse['body'] = $body;

$page .= parsetemplate(gettemplate('changelog_body'), $parse);

display( $page, "Changelog", false, '', true);

?>