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

// SECURITY FIX: $_GET['log'] was concatenated into the path, so a traversal
// sequence read arbitrary .htm/.php files from the server.
// The nested ternary that used to be here also does not parse on PHP 8
// ("unparenthesized a ? b : c ? d : e"), which made this page a fatal error
// on any modern PHP; it is now written as plain branches.
$logName = preg_replace('/[^\w-]/', '', isset($_GET['log']) ? $_GET['log'] : '');
$file = __DIR__ . '/../logs/' . $logName;

if ($logName !== '' && is_file($file . '.htm')) {
	echo file_get_contents($file . '.htm');
} elseif ($logName !== '' && is_file($file . '.php')) {
	echo file_get_contents($file . '.php');
} else {
	echo '<u style="color:red">/!\</u> Empty!';
}
?>
</pre>
</body>
</html>