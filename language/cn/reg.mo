<?php
//?????

if (!defined('INSIDE')) {
	die("企图攻击。");
}

// Registration form
$lang['registry'] 		= '用户注册';
$lang['form']           = '注册信息';
$lang['Register'] 		= '注册';
$lang['Undefined']		= '保密';
$lang['Male'] 			= '男';
$lang['Female']			= '女';
$lang['Multiverse'] 		= '银河帝国';
$lang['E-Mail'] 		= 'E-Mail:';
$lang['MainPlanet'] 		= '星球名称:';
$lang['GameName'] 		= '用户名:';
$lang['Sex'] 			= '性别';
$lang['accept'] 		= '了解并同意所有条款';
$lang['signup'] 		= '立刻注册';
$lang['neededpass']        	= '密码:';

// Send
$lang['mail_ppdream']       = '启梦工作室';
$lang['mail_game']        	= 'OGame中国';
$lang['mail_test']        	= '测试服务器';

$lang['mail_welcome']      	= '
{mail_ppdream} 热情欢迎您的到来，感谢您对 {mail_ppdream}--{mail_game} 的支持！

以下是您的注册信息：
用户名：{username} 
密  码：{password}

请登录 {mail_game} 游戏，祝您玩的开心 ！

{mail_ppdream}：http://www.ppdream.com
{mail_game}：http://www.ogamecn.com
{mail_test}：http://test.ogamecn.com
';
$lang['thanksforregistry'] 	= '谢谢您的注册，请<a href="login.php">登录系统</a>。';

// Errors
$lang['error_mail'] 		= 'E-Mail地址不合法!<br />';
$lang['error_planet']      	= '请输入您星球的名称!<br />';
$lang['error_hplanetnum'] 	= '必须输入英文！<br />';
$lang['error_character'] 	= '用户名输入有误！<br />';
$lang['error_charalpha']  	= '用户名称必须是字母数字的组合，不能包含其他字符(不允许使用空格)！<br />';
$lang['error_password']    	= '密码至少要4个字符！<br />';
$lang['error_rgt']         	= '只有同意用户协议才能注册.<br />';
$lang['error_userexist'] 	= '用户名已存在,请重新选择用户名！<br />';
$lang['error_emailexist'] 	= 'E-Mail地址已被使用！<br />';
$lang['error_sex'] 			= '请选择性别<br />';
$lang['error_mailsend']    	= '邮件发送错误，你的密码是:';

$lang['reg_welldone'] 		= '注册成功，请<a href="login.php">登录系统</a>。';
$lang['sender_message_ig']  = '管理员';
$lang['subject_message_ig'] = 'OGame中国高速测试服务器';
$lang['text_message_ig']    = '
启梦工作室全体成员欢迎您的到来！感谢您对我们的支持！
您可以通过“新手教程”来帮助您开始游戏！
预祝您玩的开心！
如果您遇到问题请给我们留言。';

// Created by ppdream. All rights reversed (C) 2008
?>