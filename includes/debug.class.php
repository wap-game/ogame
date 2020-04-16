<?php

if(!defined('INSIDE')){ die("企图黑客");}

class debug
{
	var $log,$numqueries;

	function debug()
	{
		$this->vars = $this->log = '';
		$this->numqueries = 0;
	}

	function add($mes)
	{
		$this->log .= $mes;
		$this->numqueries++;
	}

	function echo_log()
	{
		global $xnova_root_path;
		echo  "<br><table><tr><td class=k colspan=4><a href=".$xnova_root_path."admin/settings.php>调试日志</a>:</td></tr>".$this->log."</table>";
		die();
	}
	
	function error($message,$title)
	{
/*		global $link,$game_config;
		if($game_config['debug']==1){
			echo "<h2>$title</h2><br><font color=red>$message</font><br><hr>";
			echo  "<table>".$this->log."</table>";
		}
		else{
			global $user,$xnova_root_path,$phpEx;
			include($xnova_root_path . 'config.'.$phpEx);
			if(!$link) die('数据库中现在没有您要的数据，对不起给您带来不便…….');
			$query = "INSERT INTO {{table}} SET
				`error_sender` = '{$user['id']}' ,
				`error_time` = '".time()."' ,
				`error_type` = '{$title}' ,
				`error_text` = '".mysql_escape_string($message)."';";
			$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors',$query))
				or die('数据库发生致命的错误！');
			$query = "explain select * from {{table}}";
			$q = mysql_fetch_array(mysql_query(str_replace("{{table}}", $dbsettings["prefix"].
				'errors', $query))) or die('数据库发生致命的错误！');

			if (!function_exists('message'))
				echo "发生错误，请您联系管理员。错误编号：<b>".$q['rows']."</b>";
			else
				message("发生错误，请您联系管理员。错误编号：<b>".$q['rows']."</b>", "错误");
		}
		die();
*/	}
	
	
}

// Created by Perberos. All rights reversed (C) 2006
?>
<?php /*  Powered by OGameCN www.ogamecn.com  */ ?>