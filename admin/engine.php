<?PHP
// Admin Panel Function
// For MyMuWeb

function writelog($logfile,$text) {
 // SECURITY FIX: see includes/engine.php - keep PHP open tags out of the .php
 // log files and keep the file name inside logs/.
 $text = str_ireplace('<?', '&lt;?', $text);
 $logfile = preg_replace("/[^a-zA-Z0-9_-]/", '', $logfile);
 if($logfile == '') { return; }
 $text .= ", All Those On <i>".date('d.m.Y H:i:s')."</i> By <u>$_SERVER[REMOTE_ADDR]</u> \n";
 $fp = fopen("logs/$logfile.php","a");
 fputs($fp, $text);
 fclose($fp);
}


function clearlog($logfile) {
 //$fp = fopen("logs/$logfile.php","w");
 //fwrite ($fp, "");
 // SECURITY FIX: $logfile came from $_POST["log_name"] unsanitised, so
 // a traversal sequence there deleted files outside logs/ (index.php, config, ...).
 // Restrict it to a plain log name inside logs/.
 $logfile = preg_replace("/[^a-zA-Z0-9_-]/",'',$logfile);
 if($logfile == '') { return; }
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

 // SECURITY FIX: the security code was compared with loose != / == , so on
 // PHP 5/7 (which this engine targets) a numeric code such as "4321" also
 // matched "4321anything", "4321.0" and " 4321". Compare exactly instead, and
 // in constant time where hash_equals() is available.
 $mmw[code_ok] = ((string)$securitycode === (string)$mmw[admin_securitycode]);
 if(function_exists('hash_equals')) {
  $mmw[code_ok] = hash_equals((string)$mmw[admin_securitycode], (string)$securitycode);
 }

 if($row[0]!=$account || !$mmw[code_ok]) {
  echo '<script language="Javascript">alert("Ups! '.$_SERVER["REMOTE_ADDR"].' Username or Password or SecurityCode Invalid!"); window.location="admin.php";</script>';
  exit; // SECURITY FIX: the failure branches never stopped execution
 }
 if($row[0]==$account && $mmw[status_rules][$row[1]][admin_panel]!=1) {
  echo '<script language="Javascript">alert("Ups! '.$row[0].' You Can\'t Enter in Here!"); window.location="'.$mmw[serverwebsite].'";</script>';
  exit;
 }
 if($row[0]==$account && $mmw[code_ok] && !empty($password) && $mmw[status_rules][$row[1]][admin_panel]==1) {
  session_regenerate_id(true); // SECURITY FIX: prevent session fixation
  $_SESSION['a_admin_login'] = $account;
  $_SESSION['a_admin_password'] = $password;
  $_SESSION['a_admin_security'] = $securitycode;
  $_SESSION['a_admin_level'] = $row[1];
  echo '<script language="Javascript">alert("Welcome '.$row[0].', Press Ok To Enter The Admin Control Panel!"); window.location="admin.php";</script>';
  exit;
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
 $_SESSION = array(); // SECURITY FIX: session_destroy() alone leaves $_SESSION populated
 session_destroy();
 echo '<script language="Javascript">alert("You Have Logged Out From Your Admin Control Panel, Press Ok To Go To The Main WebSite!"); window.location="'.$mmw[serverwebsite].'";</script>';
 exit;
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

 // SECURITY FIX: same loose comparison as above, plus session_destroy()
 // without clearing $_SESSION - so a demoted or deleted admin's failing
 // request still rendered the whole panel and executed one more action.
 $mmw[code_ok] = ((string)$security === (string)$mmw[admin_securitycode]);
 if(function_exists('hash_equals')) {
  $mmw[code_ok] = hash_equals((string)$mmw[admin_securitycode], (string)$security);
 }
 if(!$mmw[code_ok] || $login!=$check_row[0] || $level!=$check_row[1] || $mmw[status_rules][$level][admin_panel]!=1) {
  $_SESSION = array();
  session_destroy();
  echo '<script language="Javascript">alert("Dear '.$_SERVER["REMOTE_ADDR"].', Don\'t Try Fuckin Things!");window.location="'.$mmw[serverwebsite].'";</script>';
  exit;
 }
}
?>