<?PHP
// This is modified Admin area
// Creatro =Master=, Editor Vaflan
// For MyMuWeb

session_start();
header("Cache-control: private");
include("config.php");
include("admin/inc/query.php");
include("includes/sql_check.php");
include("includes/xss_check.php");
include("includes/format.php");
include("admin/inc/functions.php");
writelog("check_ip","<b>".urldecode($_SERVER["HTTP_REFERER"])."</b>");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="images/admin.css" rel="stylesheet" type="text/css" />
<title>MyMuWeb Administrator</title>
</head>
<body>
<div align="center">

<?if(isset($_SESSION['a_admin_login'],$_SESSION['a_admin_pass'],$_SESSION['a_admin_security'],$_SESSION['a_admin_level'])){?>

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" height="50">
<div class="login_stats">
<form action='' method='post' name='admin_logout' id='admin_logout'>
<?echo $warning_red;?> You are loged in <b><?echo "$_SESSION[a_admin_login] ".mmw_status($_SESSION[a_admin_level])." (Level: $_SESSION[a_admin_level])";?></b> 
<input name='admin_logout' type='hidden' id='admin_logout' value='admin_logout'> 
<input name='Logout' type='submit' id='Logout' title='Logout' value='Logout'>
</form>
</div>
      </td>
    </tr>
    <tr>
      <td align="center" height="20">
<?if($_SESSION[a_admin_level] > 6){?>
<a href="?op=sqlquery">SQL Query</a> | 
<a href="?op=server">Server</a> | 
<?}if($_SESSION[a_admin_level] > 3){?>
<a href="?op=news">News</a> | 
<a href="?op=downloads">Downloads</a> | 
<a href="?op=votes">Votes</a> | 
<?}?>
<a href="?op=char">Search Character</a> | 
<a href="?op=acc">Search Account</a> | 
<a href="?op=acclist">Account List</a> | 
<a href="?op=findip">Find Ip</a> | 
<a href="?op=logs">Logs</a> </td>
    </tr>
    <tr>
      <td align="center">
	<br />
<?
if(!isset($_GET['op'])){include("admin/home.php");}
elseif(is_file("admin/$_GET[op].php")){include("admin/$_GET[op].php");}
else{echo "<br><b>Not Find!</b>";}
?>
      </td>
    </tr>
  </table>

<?}else{?>

<script language='Javascript'>
function check_admin_form()
{
if ( document.admin_form.adminusername.value == '')
{
alert('Please Enter Admin Username.');
return false;
}
if ( document.admin_form.adminpassword.value == '')
{
alert('Please Enter Admin Password.');
return false;
}
if ( document.admin_form.securitycode.value == '')
{
alert('Please Enter Admin SecurityCode.');
return false;
}
//return false;
document.admin_form.submit();
}
</script>
<p>&nbsp;</p>
<table width='302' border='0' align='center' cellpadding='0' cellspacing='4'>
  <tr>
    <td width='294'><div align='center'><?echo $warning_red;?> Welcome <?echo $_SERVER[REMOTE_ADDR];?></div></td>
  </tr>
</table>
<table width='200' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td><form action='' method='post' name='admin_form' id='admin_form'>
      <table width='292' border='0' align='center' cellpadding='0' cellspacing='4'>
        <tr>
          <td width='126'><div align='right'>Admin Username</div></td>
          <td width='144'><input name='adminusername' type='text' size='15' maxlength='10'></td>
        </tr>
        <tr>
          <td align='right'>Admin Password</td>
          <td><input name='adminpassword' type='password' size='15' maxlength='10'></td>
        </tr>
        <tr>
          <td align='right'>Admin SecurityCode</td>
          <td><input name='securitycode' type='password' size='8' maxlength='10'> <input name='admin_login' type='hidden' id='admin_login' value='admin_login'></td>
        </tr>
        <tr>
          <td align='right'> </td>
          <td align='left'><input name='Login' type='submit' id='Login' value='Login' onclick='return check_admin_form()'> <input name='Reset' type='reset' id='Reset' value='Reset'></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>

<?}?>

<br><span class="copyright">MyMuWeb. Design and PHP+SQL by Vaflan.</span>
</div>
</body>
</html>