<?php
// This is modified Admin area For MyMuWeb Engine
// Creator =Master=, Edit by Vaflan

session_start();
header("Cache-control: private");
header("Cache-control: max-age=3600");
@date_default_timezone_set('Europe/Helsinki');

require('../config.php');
include('../includes/mmw.php');
include('../includes/sql_check.php');
include('../includes/xss_check.php');
include("../includes/functions.php");


// Start Login Sistem
if(isset($_POST['admin_login'])) {
 $account = clean_var($_POST['account']);
 $password = clean_var($_POST['password']);
 $security = clean_var($_POST['security']);

 if(empty($account) || empty($password) || empty($security)) {die('<center>'.$mmw['warning']['red'].' <b>Fatal ErroR!</b></center>');}

 if($mmw['md5'] > 0){$pass = "[dbo].[fn_md5]('".$password."','".$account."')";} else{$pass = "'".$password."'";}
 $row = @mssql_fetch_row(@mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='".$account."' AND memb__pwd=".$pass));

 if($row[0]!=$account || $mmw['security_code']!=$security) {
  echo '<script language="Javascript">alert(\'Ups! '.$_SERVER['REMOTE_ADDR'].' Username or Password or Security Code Invalid!\'); window.location=\'.\';</script>';
 }
 elseif($row[0]==$account && $mmw['status_rules'][$row[1]]['admin_panel']!=1) {
  echo '<script language="Javascript">alert("Ups! '.$row[0].' You Can\'t Enter in Here!"); window.location="'.$mmw[serverwebsite].'";</script>';
 }
 elseif($row[0]==$account && $mmw['security_code']==$security && !empty($password) && $mmw['status_rules'][$row[1]]['admin_panel']==1) {
  $_SESSION['admin_account'] = $account;
  $_SESSION['admin']['password'] = $password;
  $_SESSION['admin']['security'] = $security;
  $_SESSION['admin']['level'] = $row[1];
  echo '<script language="Javascript">alert(\'Welcome '.$row[0].', Press Ok To Enter The Admin Control Panel!\'); window.location=\'.\';</script>';
 }
}


// Check Login
if(isset($_SESSION['admin']['account']) || isset($_SESSION['admin']['password']) || isset($_SESSION['admin']['security']) || isset($_SESSION['admin']['level'])){
 $account = clean_var($_SESSION['admin']['account']);
 $password = clean_var($_SESSION['admin']['password']);
 $security = clean_var($_SESSION['admin']['security']);
 $level = clean_var($_SESSION['admin']['level']);

 if($mmw['md5'] > 0){$pass = "[dbo].[fn_md5]('".$password."','".$account."')";} else{$pass = "'".$password."'";}
 $check_row = mssql_fetch_row(mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='".$account."' AND memb__pwd=".$pass));

 if($mmw['security_code']!=$security || $account!=$check_row[0] || $level!=$check_row[1] || $mmw['status_rules'][$level]['admin_panel']!=1) {
  session_destroy();
  echo '<script language="Javascript">alert(\'Dear '.$_SERVER['REMOTE_ADDR'].', Don\\\'t Try Fuckin Things!\');window.location=\''.$mmw['serverwebsite'].'\';</script>';
 }
}


// Logout
if(isset($_POST['logout'])) { 
 session_destroy();
 echo '<script language="Javascript">alert(\'You Have Logged Out From Your Admin Control Panel, Press Ok To Go To The Main WebSite!\'); window.location=\''.$mmw[serverwebsite].'\';</script>';
}


// Check admin file
if(substr($_SERVER['SCRIPT_FILENAME'], -15) != 'admin/index.php') {
 die("$sql_die_start <b>Incorrect filename admin panel!</b><br>You should: admin/index.php $sql_die_end");
}
else {
 $mmw['status_rules'][666]['admin_panel'] = 1;
}


// Check Admin Panel
if($mmw['check_admin_panel'] > 0) {
 writelog('a_check_admin_panel', '<b>'.urlencode('http://'.$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI']).'</b>');
}

if(is_file('themes/'.$mmw['theme'].'/admin.css')) {$css = 'themes/'.$mmw['theme'].'/admin.css';}
else {$css = 'images/admin.css';}
?>
<html>
<head>
	<title>MyMuWeb Administrator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="<?php echo $css;?>" rel="stylesheet" type="text/css">
	<script>var mmw_version = '<?php echo $mmw['version'];?>';</script>
</head>
<body>
<div align="center">
<?php
if(isset($_SESSION['admin']['login'], $_SESSION['admin']['password'], $_SESSION['admin']['security'], $_SESSION['admin']['level'])) {
?>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" height="50">
<div class="login_stats">
<form action="" method="post" name="admin_logout">
 <?php echo $mmw['warning']['red'];?> You are loged in <b><?php echo $_SESSION['admin']['login'].' '.$mmw['status_rules'][$_SESSION['admin']['level']]['name'].' (Level: '.$_SESSION['admin']['level'].')';?></b> 
 <input name="logout" type="hidden" value="logout"> <input type="submit" title="Logout" value="Logout">
</form>
</div>
      </td>
    </tr>
    <tr>
      <td align="center" height="20">
<a href="?op=home">Home</a> | 
<a href="?op=sqlquery">SQL Query</a> | 
<a href="?op=backup">Back Up</a> | 
<a href="?op=server">Server</a> | 
<a href="?op=news">News</a> | 
<a href="?op=downloads">Downloads</a> | 
<a href="?op=votes">Votes</a> | 
<a href="?op=forum">Forum</a> | 
<a href="?op=ads">ADS</a> | 
<a href="?op=request">Request</a><br>
<a href="?op=rename">Rename Character</a> | 
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
<?php
if(is_file($_GET['op'].'.php')) {include($_GET['op'].'.php');}
elseif(is_file($_GET['op'].'.mmw')) {mmw($_GET['op'].'.mmw');}
else {include('home.php');}
?>
      </td>
    </tr>
  </table>
<?php
}
else {
?>
<script language="Javascript">
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
          <td width='126' align='right'>Admin Account</td>
          <td width='144'><input name='account' type='text' size='15' maxlength='10'></td>
        </tr>
        <tr>
          <td align='right'>Admin Password</td>
          <td><input name='password' type='password' size='15' maxlength='10'></td>
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
<?php
}
?>
<br><span class="copyright">MyMuWeb <?php echo $mmw['version'];?>. Design and PHP+SQL by Vaflan.</span>
</div>
</body>
</html>