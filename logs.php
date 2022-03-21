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

if(is_file("logs/$_GET[log].php")){
 $logfile="logs/$_GET[log].php";
 echo implode('', file($logfile));
}
else{
 echo "<font color='red'><u>/!\</u></font> None!";
}
?>
</pre>
</body>
</html>