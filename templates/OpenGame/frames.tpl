<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset={ENCODING}">
	<link rel="shortcut icon" href="favicon.ico">
	<title>{game_name}</title>
</head>

<frameset rows="*,15" cols="*" frameborder="no" border="0" framespacing="0" id="ogameframe">
    <frameset rows="*" cols="131,*" frameborder="no" border="0" framespacing="0">
        <frame target="Mainframe" src="leftmenu.php" noresize scrolling="no" marginwidth="0" marginheight="0">
	<frame src="overview.php" name="Hauptframe" scrolling="auto" />
    </frameset>
    <frame src="chat.php" name="bottomFrame" frameborder="yes" scrolling="No" marginheight="2" id="bottomFrame"/>
</frameset>
<noframes>
	<p>{NoFrames}</p>
</noframes>
<body>
</body>
</html>