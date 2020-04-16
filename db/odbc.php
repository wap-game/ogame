<?php

function doquery($query, $table, $fetch = false){
  global $link,$debug,$xnova_root_path;

	@include($xnova_root_path.'config.php');

	if(!$link)
	{
		$link = odbc_connect($dbsettings["server"], $dbsettings["user"], 
				$dbsettings["pass"]) or
				$debug->error(odbc_error()."<br />$query","SQL Error");
				//message(mysql_error()."<br />$query","SQL Error");
		
		odbc_select_db($dbsettings["name"]) or $debug->error(odbc_error()."<br />$query","SQL Error");
	}
	// por el momento $query se mostrara
	// pero luego solo se vera en modo debug
	$sqlquery = odbc_exec($query, str_replace("{{table}}", $dbsettings["prefix"].
				$table)) or 
				$debug->error(odbc_error()."<br />$query","SQL Error");
				//message(mysql_error()."<br />$query","SQL Error");

	unset($dbsettings);//se borra la array para liberar algo de memoria

	global $numqueries,$debug;//,$depurerwrote003;
	$numqueries++;
	//$depurerwrote003 .= ;
	$debug->add("<tr><th>Query $numqueries: </th><th>$query</th><th>$table</th><th>$fetch</th></tr>");

	if($fetch)
	{ //hace el fetch y regresa $sqlrow
		$sqlrow = odbc_fetch_array($sqlquery);
		return $sqlrow;
	}else{ //devuelve el $sqlquery ("sin fetch")
		return $sqlquery;
	}
	
}



// Created by Perberos. All rights reversed (C) 2006

?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>