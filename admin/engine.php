<?PHP
// Admin Panel Function
// For MyMuWeb

function writelog($logfile,$text) {
 $text .= ", All Those On <i>".date('d.m.Y H:i:s')."</i> By <u>$_SERVER[REMOTE_ADDR]</u> \n";
 $fp = fopen("logs/$logfile.php","a");
 fputs($fp, $text);
 fclose($fp);
}


function clearlog($logfile) {
 //$fp = fopen("logs/$logfile.php","w");
 //fwrite ($fp, "");
 unlink("logs/$logfile.php");
}


// Start Login Sistem
if(isset($_POST["admin_login"])) {
 $account = clean_var(stripslashes($_POST['account']));
 $password = clean_var(stripslashes($_POST['password']));
 $securitycode = clean_var(stripslashes($_POST['securitycode']));

 if($account==NULL || $password==NULL || $securitycode==NULL) {die("$warning_red <center><b>Fatal ErroR! by Vaflan</b></center>");}

 if($mmw[md5] == yes){$pass = "[dbo].[fn_md5]('$password','$account')";} else{$pass = "'$password'";}
 $result = @mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='$account' AND memb__pwd=$pass");
 $row = @mssql_fetch_row($result);

 if($row[0]!=$account || $mmw[admin_securitycode]!=$securitycode) {
  echo '<script language="Javascript">alert("Ups! '.$_SERVER["REMOTE_ADDR"].' Username or Password or SecurityCode Invalid!"); window.location="admin.php";</script>';
 }
 if($row[0]==$account && $mmw[status_rules][$row[1]][admin_panel]!=1) {
  echo '<script language="Javascript">alert("Ups! '.$row[0].' You Can\'t Enter in Here!"); window.location="'.$mmw[serverwebsite].'";</script>';
 }
 if($row[0]==$account && $mmw[admin_securitycode]==$securitycode && !empty($password) && $mmw[status_rules][$row[1]][admin_panel]==1) {
  $_SESSION['a_admin_login'] = $account;
  $_SESSION['a_admin_password'] = $password;
  $_SESSION['a_admin_security'] = $securitycode;
  $_SESSION['a_admin_level'] = $row[1];
  echo '<script language="Javascript">alert("Welcome '.$row[0].', Press Ok To Enter The Admin Control Panel!"); window.location="admin.php";</script>';
 }
}


if(substr($_SERVER['SCRIPT_FILENAME'],-9)!='admin.php') {
 die("$sql_die_start <b>Incorrect filename admin panel!</b><br>You should: admin.php $sql_die_end");
}
else {
 $mmw[status_rules][666][admin_panel] = 1;
}


// Logout
if(isset($_POST["admin_logout"])) { 
 session_destroy();
 echo '<script language="Javascript">alert("You Have Logged Out From Your Admin Control Panel, Press Ok To Go To The Main WebSite!"); window.location="'.$mmw[serverwebsite].'";</script>';
}


// Check Login
if(isset($_SESSION['a_admin_security']) || isset($_SESSION['a_admin_pass']) || isset($_SESSION['a_admin_login']) || isset($_SESSION['a_admin_level'])){
 $login = clean_var(stripslashes($_SESSION['a_admin_login']));
 $password = clean_var(stripslashes($_SESSION['a_admin_password']));
 $security = clean_var(stripslashes($_SESSION['a_admin_security']));
 $level = clean_var(stripslashes($_SESSION['a_admin_level']));

 if($mmw[md5] == yes){$password = "[dbo].[fn_md5]('$password','$login')";} else{$password = "'$password'";}
 $check_result = mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='$login' AND memb__pwd=$password");
 $check_row = mssql_fetch_row($check_result);

 if($mmw[admin_securitycode]!=$security || $login!=$check_row[0] || $level!=$check_row[1] || $mmw[status_rules][$level][admin_panel]!=1) {
  session_destroy();
  echo '<script language="Javascript">alert("Dear '.$_SERVER["REMOTE_ADDR"].', Don\'t Try Fuckin Things!");window.location="'.$mmw[serverwebsite].'";</script>';
 }
}
?>