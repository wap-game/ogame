<?php

/**
 * GetPhalanxRange.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

function GetPhalanxRange ( $PhalanxLevel ) {
	// Niveau                       1  2  3  4  5  6  7  = lvl
	// Portée ajouté                0  3  5  7  9 11 13  = (lvl * 2) - 1
	// Phalanx en nbre de systemes  0  3  8 15 24 35 48  =
	$PhalanxRange = 0;
	if ($PhalanxLevel > 1) {
		for ($Level = 2; $Level < $PhalanxLevel + 1; $Level++) {
			$lvl           = ($Level * 2) - 1;
			$PhalanxRange += $lvl;
		}
	}
	return $PhalanxRange;
}

?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>