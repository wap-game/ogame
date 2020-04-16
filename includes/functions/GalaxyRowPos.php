<?php

/**
 * GalaxyRowPos.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function GalaxyRowPos ( $Planet, $GalaxyRow ) {
	// Pos
	$Result  = "<th width=30>";
	$Result .= "<a href=\"#\"";
	if ($GalaxyRow) {
		$Result .= " tabindex=\"". ($Planet + 1) ."\"";
	}
	$Result .= ">". $Planet ."</a>";
	$Result .= "</th>";

	return $Result;
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>