<?php
/* Read Logs By Vaflan For MyMuWeb */
session_start();
header('Cache-Control: private');
?>
<html lang="en">
<head>
	<title>MMW Admin Logs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="background: #dddddd; font-family: Arial, serif;">
<pre>
<?php
if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

$file = __DIR__ . '/../logs/' . $_GET['log'];
echo is_file($file . '.htm')
	? @file_get_contents($file . '.htm')
	:  is_file($file . '.php')
		? @file_get_contents($file . '.php')
		: '<u style="color:red">/!\</u> Empty!';
?>
</pre>
</body>
</html>