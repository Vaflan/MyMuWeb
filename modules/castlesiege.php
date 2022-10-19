<?php
/**
 * Castle Siege information module
 * @var array $mmw
 * @var string $rowbr
 */

if ($mmw['castle_siege']['switch']) {
	if ($_ENV['mmw_cache']['castle_siege']['timeout'] + $mmw['server_timeout'] < time()) {
		$_ENV['mmw_cache']['castle_siege']['status'] = false;
		if ($check = @fsockopen($mmw['castle_siege']['ip'], $mmw['castle_siege']['port'], $error_code, $error_message, 0.3)) {
			fclose($check);
			$_ENV['mmw_cache']['castle_siege']['status'] = true;
		}
		$_ENV['mmw_cache']['castle_siege']['timeout'] = time();
	}

	$cs_status = ($_ENV['mmw_cache']['castle_siege']['status'])
		? '<span class="online">' . mmw_lang_is_opened . '</span>'
		: '<span class="offline">' . mmw_lang_is_closed . '</span>';

	/**
	 * Load MuCastleData.dat
	 * @noinspection PhpUndefinedFunctionInspection
	 */
	$muCastleData = mu_server_file($mmw['castle_siege']['data'], true)[1];

	$query = mssql_query("SELECT
            mcd.OWNER_GUILD,
            mcd.SIEGE_START_DATE,
            mcd.SIEGE_END_DATE,
            mcd.MONEY,
            mcd.TAX_HUNT_ZONE,
            g.G_Master,
            g.G_Mark
        FROM dbo.MuCastle_DATA AS mcd
        LEFT JOIN dbo.Guild AS g ON g.G_Name = mcd.OWNER_GUILD
    ");
	$row = mssql_fetch_row($query);
	if (!empty($row[0])) {
		$cs_guild = '<a href="?op=guild&guild=' . $row[0] . '">' . $row[0] . '</a>';
		$cs_guild_master = '<a href="?op=character&character=' . $row[5] . '">' . $row[5] . '</a>';
		$logo = urlencode(bin2hex($row[6]));
		$cs_guild_mark = '<a class="helpLink" href="#" onclick="showHelpTip(event,\'<img src=images/mark.php?decode=' . $logo . ' height=60 width=60>\');return false;"><img src="images/mark.php?decode=' . $logo . '" height="10" width="10" border="0"></a>';
	} else {
		$cs_guild = 'None';
		$cs_guild_master = 'None';
	}

	if ($mmw['cs_memb_reset_discount']) {
		$edited_zen_cs = ($mmw['cs_memb_reset_must_have_zen'] > $row[3])
			? $row[3]
			: $mmw['cs_memb_reset_must_have_zen'];
		$cs_zen_kk = substr($edited_zen_cs, 0, -6);
		$cs_memb_reset_proc = ceil($cs_zen_kk / $mmw['cs_memb_reset_max_percent']);
		$cs_memb_reset_zen = (substr($mmw['reset_money'], 0, -6) * $cs_memb_reset_proc) / 100;
	}

	function array2time($array)
	{
		if (strlen($array[2]) < 2) {
			$array[2] = '0' . $array[2];
		}
		if (strlen($array[3]) < 2) {
			$array[3] = '0' . $array[3];
		}
		echo $array[2] . ':' . $array[3];
	}

	function dayArray2sec($date, $array)
	{
		return strtotime($date) + ($array[1] * 24 * 60 * 60) + ($array[2] * 60 * 60) + ($array[3] * 60);
	}

	$now_time = time();
	$cs_start = time_format($row[1], 'd M Y');
	if (dayArray2sec($cs_start, $muCastleData[2]) > $now_time) {
		$cs_period = mmw_lang_register_for_attack;
	} elseif (dayArray2sec($cs_start, $muCastleData[4]) > $now_time) {
		$cs_period = mmw_lang_sing_of_lord;
	} elseif (dayArray2sec($cs_start, $muCastleData[6]) > $now_time) {
		$cs_period = mmw_lang_information;
	} elseif (dayArray2sec($cs_start, $muCastleData[7]) > $now_time) {
		$cs_period = mmw_lang_ready_for_attack;
	} elseif (dayArray2sec($cs_start, $muCastleData[8]) > $now_time) {
		$cs_period = mmw_lang_attack_castle_siege;
	} else {
		$cs_period = 'Truce';
	}
	?>

	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td valign="top">

				<table class="sort-table" align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
					<tr>
						<td width="118">Castle Siege:</td>
						<td><?php echo $cs_status; ?></td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_owner_guild; ?>:</td>
						<td><?php echo $cs_guild_mark; ?><?php echo $cs_guild; ?></td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_king_of_castle; ?>:</td>
						<td><?php echo $cs_guild_master; ?></td>
					</tr>
					<?php if ($mmw['cs_memb_reset_discount']) : ?>
						<tr>
							<td><?php echo mmw_lang_reset_for_members; ?>:</td>
							<td>-<?php echo $cs_memb_reset_proc; ?>% (<?php echo $cs_memb_reset_zen; ?>kk Zen)</td>
						</tr>
					<?php endif; ?>
					<tr>
						<td><?php echo mmw_lang_tax_hunt_zone; ?>:</td>
						<td><?php echo number_format($row[4]); ?> Zen</td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_start_siege; ?>:</td>
						<td><?php echo $cs_start; ?></td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_next_siege; ?>:</td>
						<td><?php echo time_format($row[2], 'd M Y'); ?></td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_now_period; ?>:</td>
						<td><?php echo $cs_period; ?></td>
					</tr>
				</table>

				<?php echo $rowbr; ?>

				<table class="sort-table" align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
					<tr>
						<td width="118"><?php echo mmw_lang_register_for_attack; ?>:</td>
						<td>
							<?php echo week2str($muCastleData[1]); ?>.<?php array2time($muCastleData[1]); ?>
							-
							<?php echo week2str($muCastleData[2]); ?>.<?php array2time($muCastleData[2]); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_sing_of_lord; ?>:</td>
						<td>
							<?php echo week2str($muCastleData[3]); ?>.<?php array2time($muCastleData[3]); ?>
							-
							<?php echo week2str($muCastleData[4]); ?>.<?php array2time($muCastleData[4]); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_information; ?>:</td>
						<td>
							<?php echo week2str($muCastleData[5]); ?>.<?php array2time($muCastleData[5]); ?>
							-
							<?php echo week2str($muCastleData[6]); ?>.<?php array2time($muCastleData[6]); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_ready_for_attack; ?>:</td>
						<td>
							<?php echo week2str($muCastleData[6]); ?>.<?php array2time($muCastleData[6]); ?>
							-
							<?php echo week2str($muCastleData[7]); ?>.<?php array2time($muCastleData[7]); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo mmw_lang_attack_castle_siege; ?>:</td>
						<td>
							<?php echo week2str($muCastleData[7]); ?>.<?php array2time($muCastleData[7]); ?>
							-
							<?php echo week2str($muCastleData[8]); ?>.<?php array2time($muCastleData[8]); ?>
						</td>
					</tr>
				</table>

				<?php echo $rowbr; ?>

				<table class="sort-table" align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
					<thead>
					<tr>
						<th><?php echo mmw_lang_registered_guilds_for_attack; ?></th>
					</tr>
					</thead>
					<?php
					$cs_reg_query = mssql_query("SELECT SEQ_NUM,REG_SIEGE_GUILD,REG_MARKS,IS_GIVEUP FROM dbo.MuCastle_REG_SIEGE ORDER BY SEQ_NUM DESC");
					if (mssql_num_rows($cs_reg_query)) {
						while ($cs_row_reg = mssql_fetch_row($cs_reg_query)) {
							echo '<tr><td>' . $cs_row_reg[0] . '. <a href="?op=guild&guild=' . $cs_row_reg[1] . '">' . $cs_row_reg[1] . '</a> (Sing of Lord: ' . $cs_row_reg[2] . ')</td></tr>';
							echo <<<HTML
<tr>
    <td>
        {$cs_row_reg[0]}. <a href="?op=guild&guild={$cs_row_reg[1]}">{$cs_row_reg[1]}</a> (Sing of Lord: {$cs_row_reg[2]})
    </td>
</tr>
HTML;
						}
					} else {
						echo '<tr><td>' . mmw_lang_no_guilds . '</td></tr>';
					} ?>
				</table>

			</td>
			<td style="width:200px;text-align:right;vertical-align:top">
				<img src="<?php echo default_img('castlesiege.png'); ?>" title="Castle Siege" alt="Castle Siege">
			</td>
		</tr>
	</table>
	<?php
} else {
	echo '<div style="text-align:center;font-weight:bold">' . mmw_lang_is_closed . '</div>';
}
