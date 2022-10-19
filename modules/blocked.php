<div style="text-align:center;padding-bottom:12px">
	<?php echo mmw_lang_blocked_accounts; ?>
</div>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
		<tr>
			<td>#</td>
			<td><?php echo mmw_lang_account; ?></td>
			<td><?php echo mmw_lang_toblocked; ?></td>
			<td><?php echo mmw_lang_unblocked; ?></td>
			<td><?php echo mmw_lang_blocked_by; ?></td>
			<td><?php echo mmw_lang_information; ?></td>
		</tr>
	</thead>
	<tbody>
	<?php
	$result = mssql_query("SELECT memb___id,block_date,unblock_time,blocked_by FROM dbo.MEMB_INFO WHERE bloc_code=1 ORDER BY block_date");
	if (mssql_num_rows($result) === 0) {
		echo '<tr><td colspan="6">' . mmw_lang_no_blocked_accounts . '</td></tr>';
	}

	$language = array(
		'show_now' => mmw_lang_show_now
	);

	$rank = 1;
	while ($row = mssql_fetch_row($result)) {
		$date = !empty($row[1])
			? date('d M Y, H:i', $row[1])
			: mmw_lang_for_ever;

		$to = !empty($row[2])
			? date('d M Y, H:i', $row[1] + $row[2])
			: mmw_lang_never;

		$by_who = !empty($row[3])
			? '<a href="?op=profile&profile=' . $row[3] . '">' . $row[3] . '</a>'
			: 'unknown';

		echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td><a href="?op=profile&profile={$row[0]}">{$row[0]}</a></td>
	<td>{$date}</td>
	<td>{$to}</td>
	<td>{$by_who}</td>
	<td><a href="?op=checkacc&w=block&n={$row[0]}">{$language['show_now']}</a></td>
</tr>
HTML;
		$rank++;
	}
	?>
	</tbody>
</table>