<?PHP
// Read Logs By Vaflan
// For MyMuWeb
session_start();
header("Cache-control: private");
?>
<html>
<head>
<title>Admin Logs</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body bgcolor="#dddddd">
<pre>
<?
if(!isset($_SESSION["a_admin_login"],$_SESSION["a_admin_pass"],$_SESSION['a_admin_security'],$_SESSION['a_admin_level']))
{die("<img src=images/warning.gif> Access Denied!");}

if(is_file("logs/$_GET[log].php")){
$logfile="logs/$_GET[log].php";
echo implode('', file($logfile));
}
else{
echo "<img src=images/die.gif> None!";
}
?>
</pre>
</body>
</html>