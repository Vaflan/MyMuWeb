<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$topCount = intval($_POST['top_rank']);

$result = mssql_query("SELECT TOP {$topCount}
	ms.memb___id,
	ms.ServerName,
	ms.ConnectTM,
	ac.GameIDC,
	c.Class,
	c.cLevel,
	c.{$mmw['reset_column']}
		FROM dbo.MEMB_STAT AS ms
		LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = ms.memb___id
		LEFT JOIN dbo.Character AS c ON c.Name = ac.GameIDC
			WHERE ms.ConnectStat = 1
			ORDER BY ms.ConnectTM");
$row_num = mssql_num_rows($result);
?>

<br>
<?php echo mmw_lang_total_users_online . ': ' . $row_num; ?><br>
<br>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_character; ?></td>
		<td><?php echo mmw_lang_reset; ?></td>
		<td><?php echo mmw_lang_level; ?></td>
		<td><?php echo mmw_lang_class; ?></td>
		<td><?php echo mmw_lang_server; ?></td>
		<td><?php echo mmw_lang_connect_date; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	if (empty($row_num)) {
		echo '<tr><td colspan="7">' . mmw_lang_all_characters_is_offline . '</td></tr>';
	} else {
		$rank = 1;
		while ($row = mssql_fetch_row($result)) {
			$image = default_img('online.gif');
			$class = char_class($row[4]);
			$time = time_format($row[2], 'd M Y, H:i');

			echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td><img src="{$image}" width=6 height=6> <a href=?op=character&character={$row[3]}>{$row[3]}</a></td>
	<td>{$row[6]}</td>
	<td>{$row[5]}</td>
	<td>{$class}</td>
	<td>{$row[1]}</td>
	<td>{$time}</td>
</tr>
HTML;
		}
	}
	?>
	</tbody>
</table>