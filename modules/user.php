<?
$login = stripslashes($_SESSION[user]);
$char = stripslashes($_SESSION[char_set]);
$char_guid = stripslashes($_SESSION[char_guid]);
$online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$login'");
if(mssql_num_rows($online_check)==1) {
 $online_row = mssql_fetch_row($online_check);
 $acc_online_check = $online_row[0];
}
else {
 $acc_online_check = 0;
}

 $u = preg_replace("/[^a-zA-Z0-9_-]/",'',$_GET['u']);
 if(empty($u)) {include("modules/user/acc.php");}
 elseif(is_file("modules/user/$u.php")) {include("modules/user/$u.php");}
 elseif(is_file("modules/user/$u.mmw")) {mmw("modules/user/$u.mmw");}
 else {echo "$die_start Empty Page, Go Back!$die_end";}
?>