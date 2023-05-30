<div style="text-align:center;padding-bottom:12px">
	<?php echo mmw_lang_blocked_accounts; ?>
</div>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
		<tr>
			<td>#</td>
			<td><?php echo mmw_lang_character; ?></td>
			<td><?php echo mmw_lang_toblocked; ?></td>
			<td><?php echo mmw_lang_unblocked; ?></td>
			<td><?php echo mmw_lang_blocked_by; ?></td>
			<td><?php echo mmw_lang_information; ?></td>
		</tr>
	</thead>
	<tbody>
	<?php
	$result = mssql_query("SELECT
		mi.memb___id,
		mi.block_date,
		mi.unblock_time,
		mi.blocked_by,
		ac.GameIDC
			FROM dbo.MEMB_INFO AS mi
			LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = mi.memb___id
			WHERE mi.bloc_code=1 ORDER BY mi.block_date");
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

		$account = empty($row[4]) || !empty($mmw['status_rules'][$_SESSION['mmw_status']]['gm_option'])
			? " [<a href=\"?op=profile&profile={$row[0]}\">{$row[0]}</a>]"
			: '';

		$check_url = !empty($row[4])
			? "?op=checkacc&w=block&character={$row[4]}"
			: "?op=checkacc&w=block&n={$row[0]}";

		echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td><a href="?op=profile&character={$row[4]}">{$row[4]}</a>{$account}</td>
	<td>{$date}</td>
	<td>{$to}</td>
	<td>{$by_who}</td>
	<td><a href="{$check_url}">{$language['show_now']}</a></td>
</tr>
HTML;
		$rank++;
	}
	?>
	</tbody>
</table>