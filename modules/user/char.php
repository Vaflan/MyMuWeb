<?php
/**
 * @var array $mmw
 * @var int $acc_online_check
 * @var string $die_start
 * @var string $die_end
 * @var string $okey_start
 * @var string $okey_end
 * @var string $rowbr
 */

if (empty($_SESSION['character'])) {
	jump('?op=user');
} elseif ($acc_online_check) {
	echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
} else {
	require_once 'includes/Character.class.php';
	if (isset($_POST['reset_character'])) {
		Character::reset($_SESSION['character']);
		echo $rowbr;
	}
	if (isset($_POST['add_points'])) {
		Character::add_stats($_SESSION['character']);
		echo $rowbr;
	}
	if (isset($_POST['clear_pk'])) {
		Character::clear_pk($_SESSION['character']);
		echo $rowbr;
	}
	if (isset($_POST['move_character'])) {
		Character::move($_SESSION['character']);
		echo $rowbr;
	}
	if (isset($_POST['change_class'])) {
		Character::change_class($_SESSION['character']);
		echo $rowbr;
	}

	$language = array(
		'reset' => mmw_lang_reset,
		'you_have' => mmw_lang_you_have,
		'add_points' => mmw_lang_add_point,
		'price' => mmw_lang_price,
		'pk_clear' => mmw_lang_pk_clear,
		'select_map' => mmw_lang_select_map,
		'move' => mmw_lang_move,
		'class_price' => mmw_lang_class_price,
		'select_class' => mmw_lang_select_class,
		'change' => mmw_lang_change,
	);

	$char_results = mssql_query("SELECT Name,class,strength,dexterity,vitality,energy,leadership,experience,money,mapnumber,clevel,{$mmw['reset_column']},LevelUpPoint,pkcount,pklevel,CtlCode FROM dbo.Character WHERE Name='{$_SESSION['character']}'");
	$info = mssql_fetch_row($char_results);

	$simpleClass = Character::characterClassToSimpleClass($info[1]);

	$warehouseResult = mssql_query("SELECT extMoney FROM dbo.warehouse WHERE AccountID='{$_SESSION['user']}'");
	$warehouseRow = mssql_fetch_row($warehouseResult);
	if (empty($warehouseRow[0])) {
		$warehouseRow[0] = 0;
	}
	$all_money = $info[8] + $warehouseRow[0];

	$guild_result = mssql_query("SELECT gm.G_Name,g.G_Mark
		FROM dbo.GuildMember AS gm
		JOIN dbo.Guild AS g ON g.G_Name = gm.G_Name
		WHERE gm.Name='{$_SESSION['character']}'");
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


	if ($mmw['reset']) {
		$resetLevel = $mmw['reset_level'][$simpleClass];
		$resetPrice = $mmw['reset_money'];

		if ($mmw['reset_money_system']) {
			$resetPrice *= ($info[11] + 1);
		}
		if (!empty($mmw['reset_limit_price']) && $mmw['reset_limit_price'] < $resetPrice) {
			$resetPrice = $mmw['reset_limit_price'];
		}

		$castleSiegeResetNotice = '';
		if ($mmw['cs_memb_reset_discount'] && !empty($guild_row[0])) {
			$castle_siege_result = mssql_query("SELECT OWNER_GUILD,MONEY FROM dbo.MuCastle_DATA");
			$castle_siege_row = mssql_fetch_row($castle_siege_result);
			if ($castle_siege_row[0] === $guild_row[0]) {
				$castleSiegeResetPercent = ($mmw['cs_memb_reset_must_have_zen'] > $castle_siege_row[1])
					? ceil($castle_siege_row[1] * $mmw['cs_memb_reset_max_percent'] / $mmw['cs_memb_reset_must_have_zen'])
					: $mmw['cs_memb_reset_max_percent'];

				$castleSiegeResetNotice = mmw_lang_you_have . ': -' . $castleSiegeResetPercent . '%<br>';
				$resetPrice -= ceil($resetPrice * $castleSiegeResetPercent / 100);
			}
		}

		if ($info[10] < $resetLevel) {
			$reset = mmw_lang_need . ' ' . $resetLevel . ' ' . mmw_lang_level . '!';
		} elseif ($all_money < $resetPrice) {
			$reset = mmw_lang_need . ' ' . zen_format($resetPrice) . ' Zen!';
		} else {
			$price = zen_format($resetPrice);

			$reset = <<<HTML
<form action="" method="post">
{$language['price']}: {$price} Zen!<br>{$castleSiegeResetNotice}
<input type="submit" name="reset_character" value="{$language['reset']}">
</form>
HTML;
		}
	}


	if ($mmw['add_points']) {
		if ($info[12] < 1) {
			$addPoints = mmw_lang_no_up_point_found;
		} else {
			$add_command = '';
			if ($simpleClass === 'dl') {
				$add_command = 'Command <input name="com" type="text" size="5" maxlength="5"><br>';
			}

			$addPoints = <<<HTML
<form action="" method="post">
{$language['you_have']}: <b>{$info[12]}</b><br>
<div style="text-align:right">
	Strength <input name="str" type="text" size="5" maxlength="5"><br>
	Agility <input name="agi" type="text" size="5" maxlength="5"><br>
	Vitality <input name="vit" type="text" size="5" maxlength="5"><br>
	Energy <input name="ene" type="text" size="5" maxlength="5"><br>
	{$add_command}
</div>
<input type="submit" name="add_points" value="{$language['add_points']}">
</form>
HTML;
		}
	}


	if ($mmw['clear_pk']) {
		if ($info[14] < 4) {
			$clearPK = mmw_lang_no_pk_status_found;
		} elseif ($all_money < $mmw['clear_pk_cost']) {
			$clearPK = mmw_lang_need . ' ' . zen_format($mmw['clear_pk_cost']) . ' Zen!';
		} else {
			$price = zen_format($mmw['clear_pk_cost']);

			$clearPK = <<<HTML
<form action="" method="post">
{$language['price']}: {$price} Zen!<br>
<input type="submit" name="clear_pk" value="{$language['pk_clear']}">
</form>
HTML;
		}
	}


	if ($mmw['move']) {
		if ($info[10] < 6) {
			$move = mmw_lang_need_6_level;
		} elseif ($all_money < $mmw['move_zen']) {
			$move = mmw_lang_need . ' ' . zen_format($mmw['move_zen']) . ' Zen!';
		} else {
			$price = zen_format($mmw['move_zen']);
			$locationOptions = '';
			foreach ($mmw['move_list'] as $index => $location) {
				$locationOptions .= '<option value="' . $index . '">' . map($location[0]) . '</option>';
			}

			$move = <<<HTML
<form action="" method="post">
{$language['price']}: {$price} Zen!<br>
<select name="map" style="width:76px">
	<option value="">{$language['select_map']}</option>
	{$locationOptions}
</select><br>
<input type="submit" name="move_character" value="{$language['move']}">
</form>
HTML;
		}
	}


	if ($mmw['change_class']) {
		$changeClassOptions = '';
		foreach ($mmw['change_class_list'] as $index => $row) {
			$changeClassOptions .= '<option value="' . $index . '">' . char_class($row[0]) . ' - ' . zen_format($row[1], 'small') . ' Zen</option>';
		}

		$changeClass = <<<HTML
<form action="" method="post">
{$language['class_price']}<br>
<select name="new_class" style="width:76px">
	<option value="">{$language['select_class']}</option>
	{$changeClassOptions}
</select><br>
<input type="submit" name="change_class" value="{$language['change']}">
</form>
HTML;
	}
	?>

	<table style="margin:0 auto;border:0;padding:0">
		<tr>
			<td style="vertical-align:top">
				<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:240px">
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_character; ?>:</td>
						<td>
							<span class="level<?php echo $info[15]; ?>"><?php echo $_SESSION['character']; ?></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_status; ?>:</td>
						<td><?php echo ctlCode($info[15]); ?></td>
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
						<td style="text-align:right"><?php echo mmw_lang_experience; ?>:</td>
						<td><?php echo $info[7]; ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_level; ?>:</td>
						<td><?php echo $info[10]; ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_reset; ?>:</td>
						<td><?php echo $info[11]; ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_up_point; ?>:</td>
						<td><?php echo $info[12]; ?></td>
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
					<?php if (!empty($info[6])) : ?>
						<tr>
							<td style="text-align:right">Command:</td>
							<td><?php echo point_format($info[6]); ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<td style="text-align:right">Zen:</td>
						<td><?php echo number_format($info[8]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_kills; ?>:</td>
						<td>
							<?php echo empty($info[13]) ? mmw_lang_no_kills : $info[13]; ?>
							(<?php echo pkstatus($info[14]); ?>)
						</td>
					</tr>
					<tr>
						<td style="text-align:right"><?php echo mmw_lang_map_name; ?>:</td>
						<td><?php echo map($info[9]); ?></td>
					</tr>
				</table>
			</td>
			<td style="vertical-align:top;text-align:center;padding-left:2px;">
				<img src="<?php echo default_img(char_class($info[1], 'img')); ?>"
					 alt="<?php echo char_class($info[1], 'full'); ?>">
				<br><br>
				<?php if ($mmw['reset']) : ?>
					<div class="div-menu-out" onclick="expandit('menu_1')"
						 onmouseover="tclass=this.className;this.className='div-menu-over';"
						 onmouseout="this.className=tclass;"><?php echo mmw_lang_reset; ?></div>
					<div id="menu_1" style="display:none;padding-bottom:4px;"><?php echo $reset; ?></div>
				<?php endif; ?>
				<?php if ($mmw['add_points']) : ?>
					<div class="div-menu-out" onclick="expandit('menu_2')"
						 onmouseover="tclass=this.className;this.className='div-menu-over';"
						 onmouseout="this.className=tclass;"><?php echo mmw_lang_add_point; ?></div>
					<div id="menu_2" style="display:none;padding-bottom:4px;"><?php echo $addPoints; ?></div>
				<?php endif; ?>
				<?php if ($mmw['clear_pk']) : ?>
					<div class="div-menu-out" onclick="expandit('menu_3')"
						 onmouseover="tclass=this.className;this.className='div-menu-over';"
						 onmouseout="this.className=tclass;"><?php echo mmw_lang_pk_clear; ?></div>
					<div id="menu_3" style="display:none;padding-bottom:4px;"><?php echo $clearPK; ?></div>
				<?php endif; ?>
				<?php if ($mmw['move']) : ?>
					<div class="div-menu-out" onclick="expandit('menu_4')"
						 onmouseover="tclass=this.className;this.className='div-menu-over';"
						 onmouseout="this.className=tclass;"><?php echo mmw_lang_move; ?></div>
					<div id="menu_4" style="display:none;padding-bottom:4px;"><?php echo $move; ?></div>
				<?php endif; ?>
				<?php if ($mmw['change_class']) : ?>
					<div class="div-menu-out" onclick="expandit('menu_5')"
						 onmouseover="tclass=this.className;this.className='div-menu-over';"
						 onmouseout="this.className=tclass;"><?php echo mmw_lang_change_class; ?></div>
					<div id="menu_5" style="display:none;padding-bottom:4px;"><?php echo $changeClass; ?></div>
				<?php endif; ?>
			</td>
		</tr>
	</table>

	<?php
}
