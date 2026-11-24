<?PHP
// Read Logs By Vaflan
// For MyMuWeb
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
<?
if(!isset($_SESSION[a_admin_login],$_SESSION[a_admin_password],$_SESSION[a_admin_security]))
{die("<font color='red'><u>/!\</u></font> Access Denied!");}

// SECURITY FIX: $_GET[log] was concatenated raw into the path, so
// a traversal sequence in the log name read config.php (DB credentials) into the page.
// Only allow log names, never path separators.
$mmw[log_name] = preg_replace("/[^a-zA-Z0-9_-]/",'',$_GET[log]);
if($mmw[log_name] != '' && is_file("logs/$mmw[log_name].php")){
 $logfile="logs/$mmw[log_name].php";
 echo implode('', file($logfile));
}
else{
 echo "<font color='red'><u>/!\</u></font> None!";
}
?>
</pre>
</body>
</html>