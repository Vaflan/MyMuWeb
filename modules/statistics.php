<?php
/**
 * Stats for MyMuWeb by Vaflan
 * Version: 0.3
 * @var array $mmw
 * @var string $rowbr
 */

$barImagePath = default_img('bar.jpg');
$barImageSize = is_file($barImagePath)
	? getimagesize($barImagePath)
	: 3;

$total_accounts = mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.MEMB_INFO"));
if (!$mmw['gm_show']) {
	$gm_not_show = "WHERE CtlCode NOT IN (8, 32)";
}
$total_characters = mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.Character {$gm_not_show}"));
$total_guilds = mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.Guild WHERE G_Name!='{$mmw['gm_guild']}'"));
$total_banneds = mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.MEMB_INFO WHERE bloc_code = 1"));
$users_connected = mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.MEMB_STAT WHERE ConnectStat = 1"));

function select_characters_info_count($key, $value)
{
	global $total_characters;
	$characters = mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.Character WHERE {$key} = {$value}"));
	$percent = ($characters[0] > 0)
		? substr(100 * $characters[0] / $total_characters[0], 0, 4)
		: 0;

	return [$percent, $characters[0]];
}

$serverList = array();
$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type FROM dbo.MMW_SERVERS ORDER BY display_order");
while ($row = mssql_fetch_row($result)) {
	$status = '<span class="offline"><b>' . mmw_lang_serv_offline . '</b></span>';
	if ($check = @fsockopen($row[4], $row[3], $error_code, $error_message, 0.8)) {
		$status = '<span class="online"><b>' . mmw_lang_serv_online . '</b></span>';
		fclose($check);
	}
	$title = '<b>' . mmw_lang_version . ':</b> ' . $row[5]
		. '<br><b>' . mmw_lang_experience . ':</b> ' . $row[1]
		. '<br><b>' . mmw_lang_drops . ':</b> ' . $row[2]
		. '<br><b>' . mmw_lang_type . ':</b> ' . $row[6];
	$serverList[] = <<<HTML
		<span class="helpLink" title="{$title}">{$row[0]}</span>: {$status}
HTML;
}

$online_characters = mssql_query("SELECT count(*) FROM dbo.MEMB_STAT WHERE connectstat = 1");
$online_characters_done = mssql_fetch_row($online_characters);
$online = substr(100 * $online_characters_done[0] / $total_accounts[0], 0, 4);

$users_connected_results = substr(100 * $users_connected[0] / $total_accounts[0], 0, 4);
$total_banneds_results = substr(100 * $total_banneds[0] / $total_accounts[0], 0, 4);

$in_guilds = mssql_query("SELECT count(*) FROM dbo.GuildMember WHERE G_Name!='{$mmw['gm_guild']}'");
$total_in_guilds = mssql_fetch_row($in_guilds);
$total_in_guilds_results = !empty($total_in_guilds[0])
	? substr(100 * $total_in_guilds[0] / $total_characters[0], 0, 4)
	: 0;

$male = mssql_query("SELECT count(*) FROM dbo.MEMB_INFO WHERE gender='male'");
$male_done = mssql_fetch_row($male);
$male_results = substr(100 * $male_done[0] / $total_accounts[0], 0, 4);

$female = mssql_query("SELECT count(*) FROM dbo.MEMB_INFO WHERE gender='female'");
$female_done = mssql_fetch_row($female);
$female_results = substr(100 * $female_done[0] / $total_accounts[0], 0, 4);

$informationList = array(
	['label' => mmw_lang_total_accounts, 'percent' => 100, 'count' => $total_accounts[0]],
	['label' => mmw_lang_total_characters, 'percent' => 100, 'count' => $total_characters[0], 'link' => '?op=rankings&sort=all'],
	['label' => mmw_lang_total_banneds, 'percent' => $total_banneds_results, 'count' => $total_banneds[0], 'link' => '?op=blocked'],
	['label' => mmw_lang_total_guilds, 'percent' => 100, 'count' => $total_guilds[0], 'link' => '?op=rankings&sort=guild'],
	['label' => mmw_lang_total_in_guilds, 'percent' => $total_in_guilds_results, 'count' => $total_in_guilds[0]],
	['label' => mmw_lang_total_users_online, 'percent' => $users_connected_results, 'count' => $users_connected[0], 'link' => '?op=rankings&sort=online'],
	['label' => mmw_lang_total_male_users, 'percent' => $male_results, 'count' => $male_done[0]],
	['label' => mmw_lang_total_female_users, 'percent' => $female_results, 'count' => $female_done[0]],
);
?>

<table class="sort-table" style="border:0;padding:0;width:100%">
	<tr>
		<td>
			<?php echo implode(', ', $serverList); ?>
		</td>
	</tr>
</table>

<?php echo $rowbr; ?>

<table class="sort-table" style="border:0;padding:0;width:100%">
	<?php foreach ($informationList as $info) : ?>
	<tr>
		<td style="text-align:right;width:120px"><?php echo $info['label']; ?></td>
		<td>
			<?php
			$doublePercent = $info['percent'] * 2;
			$htmlCount = empty($info['link'])
				? $info['count']
				: '<a href="' . $info['link'] . '">' . $info['count'] . '</a>';

			echo <<<HTML
<img src="{$barImagePath}" height="{$barImageSize[1]}" width="{$doublePercent}" alt="percent">{$info['percent']}% ({$htmlCount})
HTML;
			?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php echo $rowbr; ?>

<table class="sort-table" style="border:0;padding:0;width:100%">
	<?php foreach (explode(',', $mmw['statistics_char']) as $char) : ?>
		<tr>
			<td style="text-align:right;width:120px"><?php echo char_class($char, 'full'); ?></td>
			<td>
				<?php
				list($percent, $count) = select_characters_info_count('Class', $char);
				$doublePercent = $percent * 2;
				echo <<<HTML
<img src="{$barImagePath}" height="{$barImageSize[1]}" width="{$doublePercent}" alt="percent"> {$percent}% ({$count})
HTML;
				?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<?php echo $rowbr; ?>

<table class="sort-table" style="border:0;padding:0;width:100%">
	<?php foreach (explode(',', $mmw['statistics_maps']) as $map) : ?>
		<tr>
			<td style="text-align:right;width:120px"><?php echo map($map); ?></td>
			<td>
				<?php
					list($percent, $count) = select_characters_info_count('MapNumber', $map);
					$doublePercent = $percent * 2;
					echo <<<HTML
<img src="{$barImagePath}" height="{$barImageSize[1]}" width="{$doublePercent}" alt="percent"> {$percent}% ({$count})
HTML;
				?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
