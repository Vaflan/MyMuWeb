<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$topCount = intval($_POST['top_rank']);

$no_gm_in_top = !empty($mmw['gm_show'])
	? "AND c.CtlCode NOT IN (8, 32)"
	: '';
?>

<br>
<?php echo mmw_lang_top . ' ' . $topCount . ' ' . mmw_lang_killers; ?><br>
<br>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_character; ?></td>
		<td><?php echo mmw_lang_killed; ?></td>
		<td><?php echo mmw_lang_reset; ?></td>
		<td><?php echo mmw_lang_level; ?></td>
		<td><?php echo mmw_lang_class; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$result = mssql_query("SELECT TOP {$topCount}
		c.Name,
		c.Class,
		c.cLevel,
		c.{$mmw['reset_column']},
		ms.ConnectStat,
		ac.GameIDC,
		c.PkCount
			FROM dbo.Character AS c
			LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = c.AccountID
			LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = c.AccountID
				WHERE c.PkCount > 0 {$no_gm_in_top}
				ORDER BY c.PkCount DESC");
	$row_num = mssql_num_rows($result);
	if (empty($row_num)) {
		echo '<tr><td colspan="6">' . mmw_lang_no_characters . '</td></tr>';
	} else {
		$rank = 1;
		while ($row = mssql_fetch_row($result)) {
			$status = ($row[4] && $row[5] === $row[0])
				? '<img src=' . default_img('online.gif') . ' width=6 height=6>'
				: '<img src=' . default_img('offline.gif') . ' width=6 height=6>';
			$class = char_class($row[1]);

			echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td>{$status} <a href=?op=character&character={$row[0]}>{$row[0]}</a></td>
	<td>$row[6]</td>
	<td>$row[3]</td>
	<td>$row[2]</td>
	<td>{$class}</td>
</tr>
HTML;
			$rank++;
		}
	}
	?>
	</tbody>
</table>