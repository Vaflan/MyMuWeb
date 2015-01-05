<?php
$account = $login = $_SESSION['user'];
$character = $char = $_SESSION['char_set'];
$char_guid = $_SESSION['char_guid'];

$acc_online_check = 0;
$online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='".$account."'");
if(mssql_num_rows($online_check) > 0) {
 $acc_online_check = @current(mssql_fetch_row($online_check));
}

$u = preg_replace("/[^a-zA-Z0-9_-]/", '', $_GET['u']);
if(empty($u)) {include('modules/user/acc.php');}
elseif(is_file('modules/user/'.$u.'.php')) {include('modules/user/'.$u.'.php');}
elseif(is_file('modules/user/'.$u.'.mmw')) {mmw('modules/user/'.$u.'.mmw');}
else {echo $die_start.'Empty Page, Go Back!'.$die_end;}
?>