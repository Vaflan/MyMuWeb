<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$topCount = intval($_POST['top_rank']);
$race = isset($_POST['sort'])
	? clean_var(stripslashes($_POST['sort']))
	: 'all';

if (!$mmw['gm_show']) {
	$no_gm_in_top = "AND c.CtlCode NOT IN (8, 32)";
}

$query_race['all'] = "c.Class>-1";
$query_race['dw'] = "c.Class>=0 AND c.Class<=15";
$query_race['dk'] = "c.Class>=16 AND c.Class<=31";
$query_race['elf'] = "c.Class>=32 AND c.Class<=47";
$query_race['mg'] = "c.Class>=48 AND c.Class<=63";
$query_race['dl'] = "c.Class>=64 AND c.Class<=79";
$query_race['sum'] = "c.Class>=80 AND c.Class<=95";
$query_race['rf'] = "c.Class>=96 AND c.Class<=112";
?>

<br>
<b><?php echo mmw_lang_top . ' ' . $topCount . ' ' . mmw_lang_characters; ?></b><br>
<br>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_character; ?></td>
		<td><?php echo mmw_lang_reset; ?></td>
		<td><?php echo mmw_lang_level; ?></td>
		<td><?php echo mmw_lang_class; ?></td>
		<td><?php echo mmw_lang_guild; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$query = "SELECT TOP {$topCount}
		c.Name,
		c.Class,
		c.cLevel,
		c.{$mmw['reset_column']},
		ms.ConnectStat,
		ac.GameIDC,
		gm.G_Name
			FROM dbo.Character AS c
			LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = c.AccountID
			LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = c.AccountID
			LEFT JOIN dbo.GuildMember AS gm ON gm.Name = c.Name
				WHERE {$query_race[$race]} {$no_gm_in_top} ORDER BY c.{$mmw['reset_column']} DESC, c.cLevel DESC";
	$result = mssql_query($query);
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
	<td>{$row[3]}</td>
	<td>{$row[2]}</td>
	<td>{$class}</td>
	<td><a href=?op=guild&guild={$row[6]}>{$row[6]}</a></td>
</tr>
HTML;
			$rank++;
		}
	}
	?>
	</tbody>
</table>