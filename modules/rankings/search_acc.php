<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$search = clean_var(stripslashes($_POST['search']));

$result = mssql_query("SELECT
	mi.memb___id,
	mi.memb_name,
	mi.gender,
	mi.country,
	mi.hide_profile,
	ms.ConnectStat
		FROM dbo.MEMB_INFO AS mi
		LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = mi.memb___id
		WHERE mi.memb___id LIKE '%{$search}%'");
$row_num = mssql_num_rows($result);
?>

<br>
<?php echo mmw_lang_search_account_results; ?><br>
<br>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_account; ?></td>
		<td><?php echo mmw_lang_full_name; ?></td>
		<td><?php echo mmw_lang_gender; ?></td>
		<td><?php echo mmw_lang_country; ?></td>
		<td><?php echo mmw_lang_status; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	if (empty($row_num)) {
		echo '<tr><td colspan="6">' . mmw_lang_cant_find . '</td></tr>';
	} else {
		$rank = 1;
		while ($row = mssql_fetch_row($result)) {
			$gender = gender($row[2]);
			$country = country($row[3]);
			$status = ($row[5])
				? '<img src=' . default_img('online.gif') . ' width=6 height=6>'
				: '<img src=' . default_img('offline.gif') . ' width=6 height=6>';

			echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td><a href=?op=profile&profile={$row[0]}>{$row[0]}</a></td>
	<td>{$row[1]}</td>
	<td>{$gender}</td>
	<td>{$country}</td>
	<td>{$status}</td>
</tr>
HTML;
			$rank++;
		}
	}
	?>
	</tbody>
</table>