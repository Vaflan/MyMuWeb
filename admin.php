<?PHP
// This is modified Admin area
// Creator =Master=, Edit by Vaflan
// For MyMuWeb Engine

session_start();
header("Cache-control: private");
header("Cache-control: max-age=3600");
include("config.php");
include("includes/sql_check.php");
include("includes/xss_check.php");
include("includes/format.php");
include("admin/inc/functions.php");

// Check Admin Panel
$mmw[admin_check] = $_SESSION['a_admin_level'];
writelog("a_check_admin_panel","<b>Admin Panel: ".urldecode('http://'.$_SERVER["SERVER_ADDR"].$_SERVER["REQUEST_URI"])."</b>");
?>
<html>
<head>
	<title>MyMuWeb Administrator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="images/admin.css" rel="stylesheet" type="text/css">
	<script language="javascript">var mmw_version = '<?echo $mmw[version];?>';</script>
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
<a href="?op=home">Home</a> | 
<?if($_SESSION[a_admin_level] > 6){?>
<a href="?op=sqlquery">SQL Query</a> | 
<a href="?op=server">Server</a> | 
<?}if($_SESSION[a_admin_level] > 3){?>
<a href="?op=news">News</a> | 
<a href="?op=downloads">Downloads</a> | 
<a href="?op=votes">Votes</a> | 
<a href="?op=ads">ADS</a> | 
<a href="?op=rename">Rename Character</a>
<?}?><br>
<a href="?op=char">Search Character</a> | 
<a href="?op=acc">Search Account</a> | 
<a href="?op=acclist">Account List</a> | 
<a href="?op=banip">Ban IP</a> | 
<a href="?op=findip">Find IP</a> | 
<a href="?op=logs">Logs</a> </td>
    </tr>
    <tr>
      <td align="center">
	<br>
<?
if(is_file("admin/$_GET[op].php")) {include("admin/$_GET[op].php");}
else {include("admin/home.php");}
?>
      </td>
    </tr>
  </table>

<?}else{?>

<script language='Javascript'>
function check_admin_form() {
 if(document.admin_form.adminusername.value == '') {
  alert('Please Enter Admin Username.');
  return false;
 }
 if(document.admin_form.adminpassword.value == '') {
  alert('Please Enter Admin Password.');
  return false;
 }
 if(document.admin_form.securitycode.value == '') {
  alert('Please Enter Admin SecurityCode.');
  return false;
 }
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
          <td width='126' align='right'>Admin Username</td>
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

<br><span class="copyright">MyMuWeb <?echo $mmw[version];?>. Design and PHP+SQL by Vaflan.</span>
</div>
</body>
</html>