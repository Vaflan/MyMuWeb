<?PHP
if($_GET[w]=="online")
 {
	echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
 }
elseif($_GET[w]=="block")
 {
	$login = clean_var(stripslashes($_GET['n']));
	$acc_block = mssql_query("SELECT bloc_code,block_date,unblock_time,blocked_by,block_reason FROM MEMB_INFO WHERE memb___id='$login'");
	$row = mssql_fetch_row($acc_block);

	$time_now = time();
	$time_end = $row[1] + $row[2];
	$time_need = $time_end - $time_now;

	if($row[0]==1 && $time_end > $time_now) {
		echo $die_start . mmw_lang_account." $login ".mmw_lang_is_blocked;
		if($row[1] != 0) {echo "<br> ".mmw_lang_date.": ".date("H:i:s, d.m.Y", $row[1]);}
		echo "<br>".mmw_lang_blocked_by.": $row[3]";
		if($row[1]!=0 && $row[2]!=0) {

			if($time_need<60) {$time_need = $time_need . ' s.';}
			elseif($time_need<3600) {$time_need = ceil($time_need / 60) . ' m.';}
			elseif($time_need<86400) {$time_need = ceil($time_need / 3600) . ' h.';}
			else {$time_need = ceil($time_need / 86400) . ' d.';}

			echo "<br>".mmw_lang_unblocked.": " . date("H:i:s, d.m.Y",$time_end);
			echo "<br>".mmw_lang_need_wait.": $time_need";
		}
		echo "<br>".mmw_lang_reason.": $row[4] $die_end";
	}
	elseif($row[0]==1 && $time_end!=0) {
		echo $okey_start . mmw_lang_account_must_be_logged_on_for_unblock . $okey_end;
	}
	else {
		echo $die_start . mmw_lang_account_not_blocked_or_cant_find . $die_end;
	}
 }
?>