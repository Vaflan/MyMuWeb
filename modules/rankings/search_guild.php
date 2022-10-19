<?php
/**
 * PHP Script By Vaflan For MyMuWeb
 * @var array $mmw
 */

$search = clean_var(stripslashes($_POST['search']));

$result = mssql_query("SELECT g.G_Name,
	g.G_Mark,
	g.G_Score,
	g.G_Master,
	gm.members
		FROM dbo.Guild AS g
		LEFT JOIN (SELECT count(*) AS members, G_Name FROM dbo.GuildMember GROUP BY G_Name) AS gm ON gm.G_Name = g.G_Name
			WHERE g.G_Name LIKE '%{$search}%'
			ORDER BY g.G_score DESC");
$row_num = mssql_num_rows($result);
?>

<br>
<?php echo mmw_lang_search_guild_results; ?><br>
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
	if (empty($row_num)) {
		echo '<tr><td colspan="6">' . mmw_lang_cant_find . '</td></tr>';
	} else {
		$rank = 1;
		while ($row = mssql_fetch_row($result)) {
			if (empty($row[2])) {
				$row[2] = 0;
			}
			$logo = urlencode(bin2hex($row[1]));

			echo <<<HTML
<tr> 
	<td>{$rank}</td>
	<td><a href=?op=guild&guild={$row[0]}>{$row[0]}</a></td>
	<td>{$row[2]}</td>
	<td><a href=?op=character&character={$row[3]}>{$row[3]}</a></td>
	<td>{$row[4]}</td>
	<td style="text-align:center">
		<a class="helpLink" href="#" onclick="showHelpTip(event, '<img src=\'images/mark.php?decode={$logo}\' height=60 width=60>',false); return false">
			<img src="images/mark.php?decode={$logo}" height=10 width=10 border=0>
		</a>
	</td>
</tr>
HTML;
		}
		$rank++;
	}
	?>
	</tbody>
</table>