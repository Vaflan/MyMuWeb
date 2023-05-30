<?php
$alliance = intval($_GET['num']);

$guild_query = mssql_query("SELECT g_name,g_master,g_mark FROM dbo.Guild WHERE Number={$alliance}");
$guild_row = mssql_fetch_row($guild_query);
$logo = urlencode(bin2hex($guild_row[2]));
?>
<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
	<tr>
		<td style="text-align:right;width:100px"><?php echo mmw_lang_alliance; ?>:</td>
		<td>
			<a href="?op=guild&guild=<?php echo $guild_row[0]; ?>"><?php echo $guild_row[0]; ?></a>
			<a class="helpLink" href="#" onclick="showHelpTip(event,'<img src=images/mark.php?decode=<?php echo $logo; ?> height=60 width=60>');return false;">
				<img src="images/mark.php?decode=<?php echo $logo; ?>" height="10" width="10" border="0">
			</a>
		</td>
	</tr>
	<tr>
		<td style="text-align:right"><?php echo guild_status(128); ?>:</td>
		<td>
			<a href="?op=character&character=<?php echo $guild_row[1]; ?>"><?php echo $guild_row[1]; ?></a>
		</td>
	</tr>
</table>

<?php echo $rowbr; ?>

<div style="text-align:center;padding:12px;">
	<?php echo mmw_lang_guilds_in_alliance; ?>
</div>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<thead>
	<tr>
		<td>#</td>
		<td><?php echo mmw_lang_guild; ?></td>
		<td><?php echo guild_status(128); ?></td>
		<td><?php echo mmw_lang_members; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$alliance_result = mssql_query("SELECT
		g.G_Name,g.G_Master,g.G_Mark,gm.members
			FROM dbo.Guild AS g
			LEFT JOIN (SELECT G_name, count(G_name) AS members FROM dbo.Guildmember GROUP BY G_name) AS gm ON gm.G_Name = g.G_Name
				WHERE g.G_Union={$alliance}");
	$rank = 1;
	while ($alliance_row = mssql_fetch_row($alliance_result)) {
		$alliance_logo = urlencode(bin2hex($alliance_row[2]));

		echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td>
		<a href="?op=guild&guild={$alliance_row[0]}">{$alliance_row[0]}</a>
		<a class="helpLink" href="#" onclick="showHelpTip(event,'<img src=images/mark.php?decode={$alliance_logo} height=60 width=60>')">
			<img src="images/mark.php?decode={$alliance_logo}" height="10" width="10" border="0">
		</a>
	</td>
	<td><a href="?op=character&character={$alliance_row[1]}">{$alliance_row[1]}</a></td>
	<td>{$alliance_row[3]}</td>
</tr>
HTML;
		$rank++;
	}
	?>
	</tbody>
</table>