<?php
/* Read Logs By Vaflan For MyMuWeb */
session_start();
header("Cache-control: private");
?>
<html>
<head>
	<title>MMW Admin Logs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="background: #dddddd; font-family: Arial;">
<pre>
<?php
if($_SESSION['admin']['level'] < 1) {
 die('<font color="red"><u>/!\</u></font> Access Denied!');
}
$file = '../logs/'.$_GET['log'].'.htm';
if(is_file($file)) {
 echo @file_get_contents($file);
}
else{
 echo '<font color="red"><u>/!\</u></font> None!';
}
?>
</pre>
</body>
</html>