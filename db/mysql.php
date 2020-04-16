<?php

function doquery($query, $table, $fetch = false){
	global $link, $debug, $xnova_root_path;
	//    echo $query."<br />";
	require($xnova_root_path.'config.php');

	$sql = str_replace("{{table}}", $dbsettings["prefix"].$table, $query);



	if(!$link)
	{
		$link = mysql_connect($dbsettings["server"], $dbsettings["user"], $dbsettings["pass"]) or
		$debug->error(mysql_error()."<br />$sql","SQL Error");
		//message(mysql_error()."<br />$query","SQL Error");


		mysql_select_db($dbsettings["name"]) or
		$debug->error(mysql_error()."<br />$sql","SQL Error");
		//echo mysql_error();
	}

	//mysql_query("set names gbk;");

	$sqlquery = mysql_query($sql) or
	$debug->error(mysql_error()."<br />$sql<br />","SQL Error");
	//print(mysql_error()."<br />$query"."SQL Error");

	unset($dbsettings);

	global $numqueries,$debug;
	$numqueries++;

	$debug->add("<tr><th>Query $numqueries: </th><th>$sql</th><th>$table</th><th>$fetch</th></tr>");

	if($fetch)
	{
		$sqlrow = mysql_fetch_array($sqlquery);
		return $sqlrow;
	}else{
		return $sqlquery;
	}

}

function utfquery ($sql, $Table) {
	global $link, $debug, $xnova_root_path;

	require($xnova_root_path.'config.php');
	
	$Table  = $dbsettings["prefix"] . $Table;
	if(!$link)
	{
		$link = mysql_connect($dbsettings["server"], $dbsettings["user"], $dbsettings["pass"]) or
		$debug->error(mysql_error()."<br />$sql","SQL Error");
		//message(mysql_error()."<br />$query","SQL Error");


		mysql_select_db($dbsettings["name"]) or
		$debug->error(mysql_error()."<br />$sql","SQL Error");
		//echo mysql_error();
	}
	mysql_query("set names utf8;");
	$DoQry  = str_replace("{{table}}", $Table, $sql);
		
	$return = mysql_query($DoQry) or die("MySQL Error: <b>".mysql_error()."</b>");
	return $return;
}


// Created by Perberos. All rights reversed (C) 2006
?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>