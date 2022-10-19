<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$search = clean_var(stripslashes($_POST['search']));

$result = mssql_query("SELECT
	c.Name,
	c.Class,
	c.{$mmw['reset_column']},
	c.cLevel,
	ms.ConnectStat
		FROM dbo.Character AS c
		LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = c.AccountID
		WHERE c.Name LIKE '%{$search}%'");
$row_num = mssql_num_rows($result);
?>

<br>
<?php echo mmw_lang_search_character_results; ?><br>
<br>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_character; ?></td>
		<td><?php echo mmw_lang_reset; ?></td>
		<td><?php echo mmw_lang_level; ?></td>
		<td><?php echo mmw_lang_class; ?></td>
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
			$class = char_class($row[1]);
			$status = ($row[4])
				? '<img src=' . default_img('online.gif') . ' width=6 height=6>'
				: '<img src=' . default_img('offline.gif') . ' width=6 height=6>';

			echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td><a href=?op=character&character={$row[0]}>{$row[0]}</a></td>
	<td>{$row[2]}</td>
	<td>{$row[3]}</td>
	<td>{$class}</td>
	<td>{$status}</td>
</tr>
HTML;
			$rank++;
		}
	}
	?>
	</tbody>
</table>