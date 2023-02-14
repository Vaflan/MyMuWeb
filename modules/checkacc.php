<?PHP
// Updated for MyMuWeb 0.8
// Module by Vaflan

if($_GET['w']=="online") {
 echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
}
elseif($_GET['w']=="block") {
 $name = clean_var(stripslashes($_GET['n']));
 $login = mssql_fetch_row( mssql_query("SELECT AccountID FROM Character WHERE Name='".$name."'") );
 $acc_block = mssql_query("SELECT bloc_code,block_date,unblock_time,blocked_by,block_reason FROM MEMB_INFO WHERE memb___id='".$login[0]."'");
 $row = mssql_fetch_row($acc_block);
 $a1 = substr($login[0], 1, 2);$a2 = substr($login[0], 4, 1);$a3 = substr($login[0], 6, 1);$a4 = substr($login[0], 8, 1);
 $time_need = ($row[1] + $row[2]) - time();
 if($row[0]==1 && $time_need<=0 && $row[1]>0 && $row[2]!=0) {
  echo $okey_start . mmw_lang_account_must_be_logged_on_for_unblock . $okey_end;
 }
 elseif($row[0]==1) {
  echo $die_start . mmw_lang_account." *".$a1."*".$a2."*".$a3."*".$a4."* ".mmw_lang_is_blocked;
  if($row[1] != 0) {echo "<br> ".mmw_lang_date.": ".date("H:i:s, d.m.Y", $row[1]);}
  echo "<br>".mmw_lang_blocked_by.": $row[3]";
  if($row[1]!=0 && $row[2]!=0) {

	if($time_need<60) {$need_wait = $time_need . ' s.';}
	elseif($time_need<3600) {$need_wait = ceil($time_need / 60) . ' m.';}
	elseif($time_need<86400) {$need_wait = ceil($time_need / 3600) . ' h.';}
	else {$need_wait = ceil($time_need / 86400) . ' d.';}

	echo "<br>".mmw_lang_unblocked.": " . date("H:i:s, d.m.Y", $row[1] + $row[2]);
	echo "<br>".mmw_lang_need_wait.": $need_wait";
  }
  if(!empty($row[4]) && $row[4]!=' ') {echo "<br>".mmw_lang_reason.": $row[4]";}
  echo $die_end;
 }
 else {
  echo $die_start . mmw_lang_account_not_blocked_or_cant_find . $die_end;
 }
}
?>