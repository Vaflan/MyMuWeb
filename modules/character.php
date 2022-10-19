<?php
/**
 * @var array $mmw
 * @var string $die_start
 * @var string $die_end
 * @var string $okey_start
 * @var string $okey_end
 * @var string $rowbr
 */

$characterName = clean_var($_GET['character']);

$characterResult = mssql_query("SELECT Name,class,strength,dexterity,vitality,energy,money,accountid,mapnumber,clevel,{$mmw['reset_column']},LevelUpPoint,pkcount,pklevel,leadership,CtlCode FROM dbo.Character WHERE Name='{$characterName}'");
$info = mssql_fetch_row($characterResult);
if (!mssql_num_rows($characterResult)) {
	echo $die_start . 'Character does not exist' . $die_end;
} elseif (empty($mmw['info_gm_and_blocked']) && !empty($info[15])) {
	echo $die_start . 'You cannot see blocked information! <br> Supported by MyMuWeb' . $die_end;
} else {
	if (isset($_POST['send_zen'])) {
		$zen = intval($_POST['zen']);
		$zenWithFee = $zen + $mmw['service_send_zen'];

		$result = mssql_query("SELECT extMoney FROM dbo.warehouse WHERE AccountID='{$_SESSION['user']}'");
		$from = mssql_fetch_row($result);

		if (!preg_match('/^\d+$/', $_POST['zen'])) {
			echo $die_start . mmw_lang_zen_must_be_number . $die_end;
		} elseif ($info[7] === $_SESSION['user']) {
			echo $die_start . mmw_lang_zen_cant_move . $die_end;
		} elseif ($zen < $mmw['min_send_zen']) {
			echo $die_start . zen_format($mmw['min_send_zen']) . ' ' . mmw_lang_minimum_zen_can_send . ' ' . $from[0] . $die_end;
		} elseif ($from[0] - $zenWithFee < 0) {
			echo $die_start . mmw_lang_no_zen_for_send_zen . ' ' . zen_format($mmw['service_send_zen']) . '!' . $die_end;
		} else {
			mssql_query("UPDATE dbo.warehouse SET [extMoney]=[extMoney]-{$zenWithFee} WHERE AccountID='{$_SESSION['user']}'");
			mssql_query("UPDATE dbo.warehouse SET [extMoney]=[extMoney]+{$zen} WHERE AccountID='{$info[7]}'");
			guard_mmw_mess($characterName, 'It was sent to you in Extra Ware House: ' . zen_format($zen) . ', From: ' . $_SESSION['character'] . '.');
			writelog('send_zen', 'Char: <b>' . $_SESSION['character'] . '</b> Has Been <span style="color:red">Send Zen</span>: ' . $zen . ', To: ' . $characterName . ' (Start:' . $from[0] . ',Merge:' . $zenWithFee . ')');
			echo $okey_start . $zen . ' ' . mmw_lang_zen_sent . $okey_end;
		}
		echo $rowbr;
	}

	$account_result = mssql_query("SELECT mi.hide_profile,ms.ConnectStat,ms.ConnectTM,ac.GameIDC
		FROM dbo.MEMB_INFO AS mi
		LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = mi.memb___id
		LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id = mi.memb___id
		WHERE mi.memb___id='{$info[7]}'");
	$account_row = mssql_fetch_row($account_result);

	$profile_link = '';
	if (empty($account_row[0])) {
		$profile_link = '<a href="?op=profile&profile=' . $info[7] . '"><b>' . mmw_lang_view_profile . '</b></a><br>';
	}

	$login_status = ($account_row[1] && $account_row[3] === $info[0])
		? '<span class="online">' . mmw_lang_acc_online . '</span>'
		: '<span class="offline">' . mmw_lang_acc_offline . '</span>';

	$guild_result = mssql_query("SELECT gm.G_Name,g.G_Mark
		FROM dbo.GuildMember AS gm
		JOIN dbo.Guild AS g ON g.G_Name = gm.G_Name
		WHERE gm.Name='{$info[0]}'");
	$guild_row = mssql_fetch_row($guild_result);
	if (empty($guild_row[0])) {
		$guildData = mmw_lang_no_guild;
	} else {
		$guildMark = urlencode(bin2hex($guild_row[1]));
		$guildData = <<<HTML
<img src="images/mark.php?decode={$guildMark}" alt="Guild mark" height="10" width="10" class="helpLink" title="<img src=images/mark.php?decode={$guildMark} height=60 width=60>">
<a href="?op=guild&guild={$guild_row[0]}">{$guild_row[0]}</a>
HTML;
	}

	if (empty($info[12])) {
		$info[12] = mmw_lang_no_kills;
	}

	$send_zen = mmw_lang_guest_must_be_logged_on;
	if (!empty($_SESSION['character'])) {
		$language = array(
			'send' => mmw_lang_send,
			'service_fee' => mmw_lang_service_fee
		);
		$serviceFee = zen_format($mmw['service_send_zen']);
		$send_zen = <<<HTML
<form action="" method="post">
	<input name="zen" type="text" size="8" maxlength="10">
	<input type="submit" name="send_zen" value="{$language['send']}"><br>
	{$language['service_fee']}: {$serviceFee} Zen
</form>
HTML;
	} elseif (isset($_SESSION['user'])) {
		$send_zen = mmw_lang_cant_add_no_char;
	}
	?>

	<table style="border:0;padding:0;margin:0 auto;">
		<tr>
			<td style="vertical-align:top">
				<table class="sort-table" style="border:0;padding:0;margin:0 auto;">
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_character; ?>:</td>
						<td><span class="level<?php echo $info[15]; ?>"><?php echo $info[0]; ?></span></td>
					</tr>
					<?php if ($mmw['status_rules'][$_SESSION['mmw_status']]['gm_option']) : ?>
						<tr>
							<td style="text-align:right"><?php echo mmw_lang_account; ?>:</td>
							<td><?php echo $info[7]; ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_status; ?>:</td>
						<td><?php echo ctlCode($info[16]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_class; ?>:</td>
						<td><?php echo char_class($info[1], 'full'); ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_guild; ?>:</td>
						<td><?php echo $guildData; ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_level; ?>:</td>
						<td><?php echo $info[9]; ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_reset; ?>:</td>
						<td><?php echo $info[10]; ?></td>
					</tr>
					<tr>
						<td style="text-align:right">Strength:</td>
						<td><?php echo point_format($info[2]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right">Agility:</td>
						<td><?php echo point_format($info[3]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right">Vitality:</td>
						<td><?php echo point_format($info[4]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right">Energy:</td>
						<td><?php echo point_format($info[5]); ?></td>
					</tr>
					<?php if (!empty($info[14])) : ?>
						<tr>
							<td style="text-align:right">Command:</td>
							<td><?php echo point_format($info[14]); ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_kills; ?>:</td>
						<td><?php echo $info[12]; ?> (<?php echo pkstatus($info[13]); ?>)</td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_map_name; ?>:</td>
						<td><?php echo map($info[8]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_last_login; ?>:</td>
						<td><?php echo time_format($account_row[2], 'd M Y, H:i'); ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_login_status; ?>:</td>
						<td><?php echo $login_status; ?></td>
					</tr>
				</table>
			</td>
			<td style="vertical-align:top;text-align:center;padding-left:2px;">
				<img src="<?php echo default_img(char_class($info[1], 'img')); ?>"
					 alt="<?php echo char_class($info[1], 'full'); ?>">
				<br><br>
				<a href="?op=user&u=mail&to=<?php echo $info[0]; ?>"><b><?php echo mmw_lang_send_message; ?></b></a><br>
				<?php echo $profile_link; ?>
				<div class="div-menu-out" onclick="expandit('menu_1')"
					 onmouseover="tclass=this.className;this.className='div-menu-over';"
					 onmouseout="this.className=tclass;">
					<?php echo mmw_lang_send_zen; ?>
				</div>
				<div id="menu_1" style="display:none;padding-bottom:4px;">
					<?php echo $send_zen; ?>
				</div>
			</td>
		</tr>
	</table>
	<?php
}