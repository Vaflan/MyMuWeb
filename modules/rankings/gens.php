<?php
/**
 * Gens Stats Ver. 2.20510 By Vaflan
 * @var array $mmw
 */

$no_gm_in_top = !empty($mmw['gm_show'])
	? "WHERE c.CtlCode NOT IN (8, 32)"
	: '';

$result = mssql_query("SELECT
	c.Name,
	c.SCFGensContribution,
	c.SCFGensFamily,
	ms.ConnectStat,
	ac.GameIDC
	FROM dbo.Character AS c
	LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = c.AccountID
	LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = c.AccountID
	{$no_gm_in_top}
		ORDER by c.SCFGensContribution DESC");
$gens = array();
while ($row = mssql_fetch_row($result)) {
	$gens[$row[2]]['list'][] = $row;
	$gens[$row[2]]['points'] += $row[1] ?: 0;
}
?>

<br>
<b>Durpian vs Vanert</b><br>
<br>

<table style="margin:0 auto;border:0;padding:0">
	<tr>
		<td style="vertical-align:top;padding:2px;width:50%">
			<table class="sort-table" style="border:0;padding:0">
				<thead>
				<tr>
					<td>#</td>
					<td><?php echo mmw_lang_character . ' (' . count($gens[1]['list']) . ')'; ?></td>
					<td><?php echo mmw_lang_score . ' (' . ($gens[1]['points'] ?: 0) . ')'; ?></td>
				</tr>
				</thead>
				<tbody>
				<?php
				if (empty($gens[1]['list'])) {
					echo '<tr><td colspan="3">' . mmw_lang_no_characters . '</td></tr>';
				} else {
					$rank = 1;
					foreach ($gens[1]['list'] as $row) {
						$status = ($row[4] && $row[5] === $row[0])
							? '<img src=' . default_img('online.gif') . ' width=6 height=6>'
							: '<img src=' . default_img('offline.gif') . ' width=6 height=6>';

						echo " <tr><td>$rank</td><td>$status <a href=?op=character&character=$row[0]>$row[0]</a></td><td>$row[1]</td></tr>";
						$rank++;
					}
				}
				?>
				</tbody>
			</table>
		</td>
		<td style="vertical-align:top;padding:2px;width:50%">
			<table class="sort-table" style="border:0;padding:0">
				<thead>
				<tr>
					<td>#</td>
					<td><?php echo mmw_lang_character . ' (' . count($gens[2]['list']) . ')'; ?></td>
					<td><?php echo mmw_lang_score . ' (' . ($gens[2]['points'] ?: 0) . ')'; ?></td>
				</tr>
				</thead>
				<?php
				if (empty($gens[2]['list'])) {
					echo '<tr><td colspan="3">' . mmw_lang_no_characters . '</td></tr>';
				} else {
					$rank = 1;
					foreach ($gens[2]['list'] as $row) {
						$status = ($row[4] && $row[5] === $row[0])
							? '<img src=' . default_img('online.gif') . ' width=6 height=6>'
							: '<img src=' . default_img('offline.gif') . ' width=6 height=6>';

						echo " <tr><td>$rank</td><td>$status <a href=?op=character&character=$row[0]>$row[0]</a></td><td>$row[1]</td></tr>";
						$rank++;
					}
				}
				?>
			</table>
		</td>
	</tr>
</table>
