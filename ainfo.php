<?php

/**
 * ainfo.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */


define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
includeLang('fleet');


$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];


if(!is_numeric($_GET["a"]) || !$_GET["a"] ){ message("{$lang['fl_uint_id']}","{$lang['error']}");}

$allyrow = doquery("SELECT ally_name,ally_tag,ally_description,ally_web,ally_image FROM {{table}} WHERE id=".$_GET["a"],"alliance",true);

if(!$allyrow){ message("{$lang['fl_nofind_uint']}","{$lang['error']}");}

$count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=".$_GET["a"].";","users",true);
$ally_member_scount = $count[0];

$page .="<table width=519><tr><td class=c colspan=2>{$lang['fl_uint_mess']}</td></tr>";

	if($allyrow["ally_image"] != ""){
		$page .= "<tr><th colspan=2><img src=\"".$allyrow["ally_image"]."\"></td></tr>";
	}

	$page .= "<tr><th>Tag</th><th>".$allyrow["ally_tag"]."</th></tr><tr><th>{$lang['fl_uint_name']}</th><th>".$allyrow["ally_name"]."</th></tr><tr><th>{$lang['fl_uint_meber'] }</th><th>$ally_member_scount</th></tr>";

	if($allyrow["ally_description"] != ""){
		$page .= "<tr><th colspan=2 height=100>".$allyrow["ally_description"]."</th></tr>";
	}


	if($allyrow["ally_web"] != ""){
		$page .="<tr>
		<th>{$lang['fl_uint_site']}</th>
		<th><a href=\"".$allyrow["ally_web"]."\">".$allyrow["ally_web"]."</a></th>
		</tr>";
	}
	$page .= "</table>";

	display($page,"{$lang['fl_uint_mess'] } [".$allyrow["ally_name"]."]",false);

// Created by Perberos. All rights reversed (C) 2006
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>