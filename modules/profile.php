<?php
/**
 * Profile for MMW
 * @var array $mmw
 * @var string $rowbr
 * @var string $die_start
 * @var string $die_end
 */

$account_get = clean_var($_GET['profile']);
$profile_sql = mssql_query("SELECT country,gender,age,avatar,hide_profile,y,msn,icq,skype,memb_name,appl_days,mmw_status FROM dbo.MEMB_INFO WHERE memb___id='{$account_get}'");
$profile_info = mssql_fetch_row($profile_sql);
if (empty($profile_info)) {
	echo $die_start . 'Profile does not exist' . $die_end;
} elseif (!empty($profile_info[4]) && !$mmw['status_rules'][$_SESSION['mmw_status']]['gm_option']) {
	echo $die_start . 'Profile hidden!' . $die_end;
} else {
	if (empty($profile_info[2])) {
		$profile_info[2] = mmw_lang_no_set;
	}
	if (empty($profile_info[5])) {
		$profile_info[5] = mmw_lang_no_set;
	}
	if (empty($profile_info[6])) {
		$profile_info[6] = mmw_lang_no_set;
	}
	if (empty($profile_info[7])) {
		$profile_info[7] = mmw_lang_no_set;
	}
	if (empty($profile_info[8])) {
		$profile_info[8] = mmw_lang_no_set;
	}
	if (empty($profile_info[3])) {
		$profile_info[3] = default_img('no_avatar.jpg');
	}
	?>

	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
		<tbody>
			<tr>
				<td style="width:120px"><?php echo mmw_lang_account; ?>:</td>
				<td><?php echo $account_get; ?></td>
			</tr>
			<tr>
				<td><?php echo mmw_lang_full_name; ?>:</td>
				<td><?php echo $profile_info[9]; ?></td>
			</tr>
			<tr>
				<td><?php echo mmw_lang_country; ?>:</td>
				<td><?php echo country($profile_info[0]); ?></td>
			</tr>
			<tr>
				<td><?php echo mmw_lang_age; ?>:</td>
				<td><?php echo $profile_info[2]; ?></td>
			</tr>
			<tr>
				<td><?php echo mmw_lang_gender; ?>:</td>
				<td><?php echo gender($profile_info[1]); ?></td>
			</tr>
			<tr>
				<td><?php echo mmw_lang_level; ?>:</td>
				<td><?php echo $mmw['status_rules'][$profile_info[11]]['name']; ?></td>
			</tr>
			<tr>
				<td><?php echo mmw_lang_register_date; ?>:</td>
				<td><?php echo time_format($profile_info[10], 'd M Y, H:i'); ?></td>
			</tr>
			<tr>
				<td><img src="<?php echo default_img('im/im_yahoo.gif'); ?>"> Yahoo!:</td>
				<td><?php echo $profile_info[5]; ?></td>
			</tr>
			<tr>
				<td><img src="<?php echo default_img('im/im_msn.gif'); ?>"> MSN:</td>
				<td><?php echo $profile_info[6]; ?></td>
			</tr>
			<tr>
				<td><img src="<?php echo default_img('im/im_icq.gif'); ?>"> ICQ:</td>
				<td><?php echo $profile_info[7]; ?></td>
			</tr>
			<tr>
				<td><img src="<?php echo default_img('im/im_skype.gif'); ?>"> Skype:</td>
				<td><?php echo $profile_info[8]; ?></td>
			</tr>
			<tr>
				<td style="vertical-align:top"><?php echo mmw_lang_avatar; ?>:</td>
				<td><img width="110" src="<?php echo $profile_info[3]; ?>"></td>
			</tr>
		</tbody>
	</table>

	<?php echo $rowbr; ?>

	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
	<thead>
		<tr>
			<td>#</td>
			<td><?php echo mmw_lang_character; ?></td>
			<td><?php echo mmw_lang_reset; ?></td>
			<td><?php echo mmw_lang_level; ?></td>
			<td><?php echo mmw_lang_class; ?></td>
		</tr>
	</thead>
	<tbody>
	<?php
	$result = mssql_query("SELECT
			c.Name,
			c.Class,
			c.cLevel,
			c.{$mmw['reset_column']},
			ms.ConnectStat,
			ac.GameIDC
		FROM dbo.Character AS c
		LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = c.AccountID
		LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = c.AccountID
		WHERE c.AccountID = '{$account_get}'
		ORDER BY c.{$mmw['reset_column']} DESC, c.cLevel DESC");
	$rowCount = mssql_num_rows($result);

	if (empty($rowCount)) {
		echo '<tr><td colspan="5">' . mmw_lang_no_characters . '</td></tr>';
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
</tr>
HTML;
			$rank++;
		}
	}
	echo '</tbody></table>';
}
