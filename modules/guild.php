<?php
$guild = clean_var(stripslashes($_GET['guild']));

$guild_query = mssql_query("SELECT
	g.G_Mark,
	g.G_Score,
	g.G_Master,
	g.G_Notice,
	g.G_Union,
	a.G_Name
FROM dbo.Guild AS g
LEFT JOIN dbo.Guild AS a ON a.Number = g.G_Union
	WHERE g.G_Name='{$guild}'");
$guild_row = mssql_fetch_row($guild_query);
$logo = urlencode(bin2hex($guild_row[0]));

$guild_row[1] = intval($guild_row[1]);
?>
<table class="sort-table" style="padding:0;border:0;width:100%">
	<tr>
		<td style="text-align:center;width:80px" rowspan="5">
			<img src="images/mark.php?decode=<?php echo $logo; ?>" alt="Mark" width="80">
		</td>
		<td style="text-align:right;width:100px"><?php echo mmw_lang_guild; ?>:</td>
		<td><?php echo $guild; ?></td>
	</tr>
	<tr>
		<td style="text-align:right"><?php echo mmw_lang_score; ?>:</td>
		<td><?php echo $guild_row[1]; ?></td>
	</tr>
	<tr>
		<td style="text-align:right"><?php echo guild_status(128); ?>:</td>
		<td>
			<a href="?op=character&character=<?php echo $guild_row[2]; ?>"><?php echo $guild_row[2]; ?></a>
		</td>
	</tr>
	<tr>
		<td style="text-align:right"><?php echo mmw_lang_notice; ?>:</td>
		<td><?php echo htmlspecialchars($guild_row[3]); ?></td>
	</tr>
	<?php if (!empty($guild_row[4])) : ?>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_alliance; ?>:</td>
			<td>
				<a href="?op=alliance&num=<?php echo $guild_row[4]; ?>"><?php echo $guild_row[5]; ?></a>
			</td>
		</tr>
	<?php endif; ?>
</table>

<?php echo $rowbr; ?>

<table class="sort-table" style="padding:0;border:0;width:100%;">
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
	$result = mssql_query("SELECT
			g.Name,
			g.G_Status,
			c.Class,
			c.cLevel,
			c.{$mmw['reset_column']},
			ms.ConnectStat,
			ac.GameIDC
		FROM dbo.GuildMember AS g
		LEFT JOIN dbo.Character AS c ON c.Name = g.Name
		LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = c.AccountID
		LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = c.AccountID
		WHERE g.G_Name='{$guild}'
		ORDER BY g.G_Status DESC");
	$rank = 1;
	while ($row = mssql_fetch_row($result)) {
		$status = ($row[6] === $row[0] && !empty($row[5]))
			? '<img src="' . default_img('online.gif') . '" style="width:6px;height:6px">'
			: '<img src="' . default_img('offline.gif') . '" style="width:6px;height:6px">';
		$class = char_class($row[2]);
		$position = guild_status($row[1]);

		echo <<<HTML
<tr>
	<td>{$rank}</td>
	<td>{$status} <a href=?op=character&character={$row[0]}>{$row[0]}</a></td>
	<td>{$row[4]}</td>
	<td>{$row[3]}</td>
	<td>{$class}</td>
	<td>{$position}</td>
</tr>
HTML;
		$rank++;
	}
	?>
	</tbody>
</table>