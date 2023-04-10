<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Account List + Delete not connected...
if (isset($_POST['delete_acc'])) {
	$account = $_POST['delete_acc'];
	if (empty($account)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		$query = mssql_query("SELECT ConnectStat FROM dbo.MEMB_STAT WHERE memb___id='{$account}'");
		$checkPlayed = mssql_num_rows($query);
		if ($checkPlayed === 0) {
			mssql_query("DELETE FROM dbo.MEMB_INFO WHERE memb___id='{$account}'");
			mssql_query("DELETE FROM dbo.warehouse WHERE AccountID='{$account}'");

			echo $mmw['warning']['green'] . 'Account ' . $account . ' SuccessFully Deleted!';
			writelog('a_del_acc', 'Account ' . $account . ' Has Been <b style="color:#F00">Deleted</b>');
		} else {
			echo $mmw['warning']['red'] . 'Account Has Been connected!';
		}
	}
}
?>
<fieldset class="content">
	<legend>Account List</legend>

	<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
		<thead>
		<tr>
			<td align="center">#</td>
			<td>Account</td>
			<td>Mode</td>
			<td>Reg Date</td>
			<td>Login Date</td>
			<td>Chars</td>
			<td align="center">Status</td>
			<td align="center">Delete</td>
		</tr>
		</thead>
		<?php
		$rank = 1;
		$result = mssql_query("SELECT
			mi.memb___id,
			mi.bloc_code,
			mi.appl_days,
			ms.ConnectStat,
			ms.ConnectTM,
			c.count
			FROM dbo.MEMB_INFO AS mi
				LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = mi.memb___id
				LEFT JOIN (SELECT COUNT(*) AS count, AccountID FROM dbo.Character GROUP BY AccountID) AS c ON c.AccountID = mi.memb___id
				ORDER BY appl_days
		");
		while ($row = mssql_fetch_row($result)) {
			$mode = $row[1];
			if ($row[1] == 0) {
				$mode = 'Normal';
			}
			if ($row[1] == 1) {
				$mode = '<span style="background:yellow;color:black;border:1px solid black;">Blocked</span>';
			}
			if ($row[1] === null) {
				$mode = '<span style="background:red;color:white;border:1px solid black;">Error #111</span>';
			}

			if ($row[2] === null) {
				$row[2] = '<span style="background:red;color:white;border:1px solid black;">Error #112</span>';
			}

			$status = '<span style="background:red;color:white;border:1px solid black;">Error #113</span>';
			if ($row[3] == 0) {
				$status = '<img src="../images/offline.gif" alt="offline">';
			}
			if ($row[3] == 1) {
				$status = '<img src="../images/online.gif" alt="online">';
			}
			if ($row[3] === null) {
				$status = '<img src="../images/death.gif" alt="death">';
			}
			?>
			<tr>
				<td align="center"><?php echo $rank++; ?>.</td>
				<td><a href=?op=acc&acc=<?php echo $row[0]; ?>><?php echo $row[0]; ?></a></td>
				<td><?php echo $mode; ?></td>
				<td><?php echo time_format($row[2]); ?></td>
				<td><?php echo $row[4] ? time_format($row[4]) : '---'; ?></td>
				<td><?php echo intval($row[5]); ?></td>
				<td align="center"><?php echo $status; ?></td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="delete_acc" value="<?php echo $row[0]; ?>">
						<input type="submit" value="Delete"></form>
				</td>
			</tr>
		<?php } ?>
	</table>

</fieldset>