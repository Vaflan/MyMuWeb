<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$topCount = intval($_POST['top_rank']);
?>

<br>
<?php echo mmw_lang_top . ' ' . $topCount . ' ' . mmw_lang_guilds; ?><br>
<br>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_guild; ?></td>
		<td><?php echo mmw_lang_score; ?></td>
		<td><?php echo mmw_lang_master; ?></td>
		<td><?php echo mmw_lang_members; ?></td>
		<td><?php echo mmw_lang_logo; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$result = mssql_query("SELECT TOP {$topCount}
		g.G_Name,
		g.G_Score,
		g.G_Master,
		g.G_Mark,
		gm.members
		FROM dbo.Guild AS g
		LEFT JOIN (SELECT G_Name, count(G_Name) AS members FROM dbo.GuildMember GROUP BY G_Name) AS gm ON gm.G_Name = g.G_Name
			WHERE g.G_Name != '{$mmw['gm_guild']}'
			ORDER BY g.G_score DESC");
	$row_num = mssql_num_rows($result);

	if (empty($row_num)) {
		echo '<tr><td colspan="6">' . mmw_lang_no_guilds . '</td></tr>';
	} else {
		$rank = 1;
		while ($row = mssql_fetch_row($result)) {
			$logo = urlencode(bin2hex($row[3]));

			echo <<<HTML
<tr> 
	<td>{$rank}</td>
	<td><a href="?op=guild&guild={$row[0]}">{$row[0]}</a></td>
	<td>{$row[1]}</td>
	<td><a href="?op=character&character={$row[2]}">{$row[2]}</a></td>
	<td>{$row[4]}</td>
	<td><img src="images/mark.php?decode={$logo}" alt="Mark" height="20" width="20" class="helpLink" title="<img src=images/mark.php?decode={$logo} height=60 width=60>"></a></td>
</tr>
HTML;
			$rank++;
		}
	}
	?>
	</tbody>
</table>