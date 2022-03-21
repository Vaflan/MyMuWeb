<div class='brdiv'></div>
<?
if($_GET[w]=="online")
 {
	echo "$die_start <b>Account Is Online, Must Be Logged Off!</b> $die_end";
 }
elseif($_GET[w]=="block")
 {
	$login = clean_var(stripslashes($_GET['n']));

	$acc_block = mssql_query("SELECT bloc_code,block_date,unblock_time,blocked_by,block_reason FROM MEMB_INFO WHERE memb___id='$login'");
	$row = mssql_fetch_row($acc_block);

	if($row[0]>0) {
		echo "$die_start <b>$login Account Is Blocked!</b>";
		echo "<br> Blocked By $row[3]";
		if($row[1]!=0 && $row[2]!=0) {
			$time_now = time();
			$time_end = $row[1]+$row[2];
			$time_need = $time_end - $time_now;

			if($time_need<60) {$time_need = $time_need . ' s.';}
			elseif($time_need<3600) {$time_need = ceil($time_need / 60) . ' m.';}
			elseif($time_need<86400) {$time_need = ceil($time_need / 3600) . ' h.';}
			else {$time_need = ceil($time_need / 86400) . ' d.';}

			echo "<br> To: ".date("H:i:s, d.m.Y",$time_end).
			     "<br> Need Wait: $time_need";
		}
		echo "<br> $row[4]" . $die_end;
	}
	else {
		echo "$okey_start This Account is not blocked! $okey_end";
	}
 }
?>