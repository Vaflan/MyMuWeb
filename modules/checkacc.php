<?php
/**
 * @var string $die_start
 * @var string $die_end
 * @var string $okey_start
 * @var string $okey_end
 */

if ($_GET['w'] === 'online') {
	echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
} elseif ($_GET['w'] === 'block') {
	$account = clean_var(stripslashes($_GET['n']));
	$accountBlockResult = mssql_query("SELECT bloc_code,block_date,unblock_time,blocked_by,block_reason FROM dbo.MEMB_INFO WHERE memb___id='{$account}'");
	$row = mssql_fetch_row($accountBlockResult);

	if ($row[0] == 1 && !empty($row[1]) && !empty($row[2]) && time() > ($row[1] + $row[2])) {
		echo $okey_start . mmw_lang_account_must_be_logged_on_for_unblock . $okey_end;
	} elseif ($row[0] == 1) {
		echo $die_start . mmw_lang_account . ' ' . $account . ' ' . mmw_lang_is_blocked;

		if (!empty($row[1])) {
			echo '<br> ' . mmw_lang_date . ': ' . date('H:i:s, d.m.Y', $row[1]);
		}

		if (!empty($row[1]) && !empty($row[2])) {
			if ($row[2] < 60) {
				$need_wait = $row[2] . ' s.';
			} elseif ($row[2] < 3600) {
				$need_wait = ceil($row[2] / 60) . ' m.';
			} elseif ($row[2] < 86400) {
				$need_wait = ceil($row[2] / 3600) . ' h.';
			} else {
				$need_wait = ceil($row[2] / 86400) . ' d.';
			}

			echo '<br>' . mmw_lang_unblocked . ': ' . date('H:i:s, d.m.Y', $row[1] + $row[2]);
			echo '<br>' . mmw_lang_need_wait . ': ' . $need_wait;
		}

		if (!empty($row[3])) {
			echo '<br>' . mmw_lang_blocked_by . ': ' . $row[3];
		}

		if (!empty($row[4])) {
			echo '<br>' . mmw_lang_reason . ': ' . $row[4];
		}
		echo $die_end;
	} else {
		echo $die_start . mmw_lang_account_not_blocked_or_cant_find . $die_end;
	}
}
