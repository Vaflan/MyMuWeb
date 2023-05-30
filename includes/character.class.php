<?php
/**
 * Creator =Master= Get from MuWeb 0.8
 * It's modified for MyMuWeb by Vaflan
 */

class Character
{
	/**
	 * @param $classNumber int
	 * @return string dw | dk | fe | mg | dl | sm | rf
	 */
	static function characterClassToSimpleClass($classNumber)
	{
		$simpleClasses = char_class($classNumber, 'group');

		if (empty($simpleClasses)) {
			throw new RuntimeException('Character class not defined');
		}
		return $simpleClasses;
	}

	/**
	 * @return int
	 * @throws Exception
	 */
	static function getAccountExtraMoney()
	{
		$warehouseResult = mssql_query("SELECT extMoney FROM dbo.warehouse WHERE AccountID='{$_SESSION['user']}'");
		$warehouseRow = mssql_fetch_row($warehouseResult);
		return !empty($warehouseRow[0])
			? $warehouseRow[0]
			: 0;
	}

	static function reset($characterName)
	{
		global $mmw, $okey_start, $okey_end, $die_start, $die_end;

		$characterResult = mssql_query("SELECT Money,class,LevelUpPoint,Clevel,{$mmw['reset_column']},Inventory FROM dbo.Character WHERE Name='{$characterName}'");
		$characterInfo = mssql_fetch_row($characterResult);
		$characterInventory = strtoupper(substr(bin2hex($characterInfo[5]), 0, $mmw['item_byte_size'] * 12));
		$characterMoney = $characterInfo[0];
		$warehouseMoney = self::getAccountExtraMoney();
		$totalMoney = $characterMoney + $warehouseMoney;

		$simpleClass = self::characterClassToSimpleClass($characterInfo[1]);
		$resetLevel = $mmw['reset_level'][$simpleClass];
		$resetPoints = $mmw['reset_points'][$simpleClass];
		$resetUp = $characterInfo[4] + 1;
		$resetPrice = $mmw['reset_money'];

		if ($mmw['reset_money_system']) {
			$resetPrice *= $resetUp;
		}
		if (!empty($mmw['reset_limit_price']) && $mmw['reset_limit_price'] < $resetPrice) {
			$resetPrice = $mmw['reset_limit_price'];
		}

		if ($mmw['cs_memb_reset_discount']) {
			$guild_result = mssql_query("SELECT G_Name FROM dbo.GuildMember WHERE Name='{$_SESSION['character']}'");
			$guild_row = mssql_fetch_row($guild_result);
			$castle_siege_result = mssql_query("SELECT OWNER_GUILD,MONEY FROM dbo.MuCastle_DATA");
			$castle_siege_row = mssql_fetch_row($castle_siege_result);
			if (!empty($guild_row[0]) && $castle_siege_row[0] === $guild_row[0]) {
				$castleSiegeResetPercent = ($mmw['cs_memb_reset_must_have_zen'] > $castle_siege_row[1])
					? ceil($castle_siege_row[1] * $mmw['cs_memb_reset_max_percent'] / $mmw['cs_memb_reset_must_have_zen'])
					: $mmw['cs_memb_reset_max_percent'];

				$resetPrice -= ceil($resetPrice * $castleSiegeResetPercent / 100);
			}
		}

		$warehouseMoney -= $resetPrice;
		if ($warehouseMoney < 0) {
			$characterMoney += $warehouseMoney;
			$warehouseMoney = 0;
		}

		if ($totalMoney - $resetPrice < 0) {
			echo $die_start . mmw_lang_for_reset_need . ' ' . zen_format($resetPrice) . ' Zen!' . $die_end;
		} elseif ($characterInfo[3] < $resetLevel) {
			echo $die_start . mmw_lang_for_reset_need . ' '.$resetLevel.' ' . mmw_lang_level . '!' . $die_end;
		} elseif ($resetUp >= $mmw['reset_limit_level']) {
			echo $die_start . mmw_lang_reset_limit_to . ' ' . $mmw['reset_limit_level'] . '!' . $die_end;
		} elseif ($mmw['reset_check_inventory'] && $characterInventory !== free_hex($mmw['item_byte_size'], 12)) {
			echo $die_start . mmw_lang_take_off_set . $die_end;
		} else {
			$levelUpPoint = ($mmw['reset_points_mode'])
				? $resetPoints * $resetUp
				: $resetPoints + $characterInfo[2];

			$additionalUpdates = '';
			if ($mmw['reset_points_drop']) {
				$additionalUpdates .= ",[strength]=25,[dexterity]=25,[vitality]=25,[energy]=25";
			}
			if ($mmw['reset_command_drop'] && $simpleClass === 'dl') {
				$additionalUpdates .= ",[Leadership]=25";
			}
			if ($mmw['reset_clean_inventory']) {
				$additionalUpdates .= ",[inventory]=0x" . free_hex($mmw['item_byte_size'], 108);
			}
			if ($mmw['reset_clean_skills']) {
				$additionalUpdates .= ",[magiclist]=0x" . free_hex(20, 18);
			}

			mssql_query("UPDATE dbo.warehouse SET [extMoney]='{$warehouseMoney}' WHERE AccountID='{$_SESSION['user']}'");
			mssql_query("UPDATE dbo.Character SET [money]='{$characterMoney}',[clevel]=1,[experience]=0,[LevelUpPoint]={$levelUpPoint},{$mmw['reset_column']}={$resetUp} {$additionalUpdates} WHERE Name='{$characterName}'");
			echo $okey_start . mmw_lang_character_reseted . $okey_end;
			writelog('reset', 'Character <b>'.$characterName.'</b> Has Been <span style="color:red">Reseted</span>, Before Reset: '.$characterInfo[4].'(reset), After Reset: '.$resetUp.'(reset), For: '.$resetPrice.' Zen');
		}
	}


	static function add_stats($characterName)
	{
		global $mmw, $okey_start, $okey_end, $die_start, $die_end;

		$addPoints = array(
			'strength' => intval($_POST['str']),
			'dexterity' => intval($_POST['agi']),
			'vitality' => intval($_POST['vit']),
			'energy' => intval($_POST['ene']),
			'leadership' => intval($_POST['com'])
		);

		$characterResult = mssql_query("SELECT levelupPoint,strength,dexterity,vitality,energy,leadership FROM dbo.Character WHERE Name='{$characterName}'");
		$characterInfo = mssql_fetch_row($characterResult);

		$newPoints = array(
			'strength' => $characterInfo[1] + $addPoints['strength'],
			'dexterity' => $characterInfo[2] + $addPoints['dexterity'],
			'vitality' => $characterInfo[3] + $addPoints['vitality'],
			'energy' => $characterInfo[4] + $addPoints['energy'],
			'leadership' => $characterInfo[5] + $addPoints['leadership']
		);
		$leftPoints = $characterInfo[0] - $addPoints['strength'] - $addPoints['dexterity'] - $addPoints['vitality'] - $addPoints['energy'] - $addPoints['leadership'];

		if (
			!preg_match('/^\d*$/', $_POST['str'] . $_POST['agi'] . $_POST['vit'] . $_POST['ene'])
			|| (isset($_POST['com']) && !preg_match('/^\d*$/', $_POST['com']))
		) {
			echo $die_start . mmw_lang_point_must_be_number . $die_end;
		} elseif ($leftPoints < 0) {
			echo $die_start . mmw_lang_dont_have_point . ' ' . $characterInfo[0] . $die_end;
		} elseif (
			$newPoints['strength'] > $mmw['max_stats']
			|| $newPoints['dexterity'] > $mmw['max_stats']
			|| $newPoints['vitality'] > $mmw['max_stats']
			|| $newPoints['energy'] > $mmw['max_stats']
			|| $newPoints['leadership'] > $mmw['max_stats']
		) {
			echo $die_start . $mmw['max_stats'] . ' ' . mmw_lang_max_point . $die_end;
		} else {
			mssql_query("UPDATE dbo.Character SET [Strength]='{$newPoints['strength']}',[Dexterity]='{$newPoints['dexterity']}',[Vitality]='{$newPoints['vitality']}',[Energy]='{$newPoints['energy']}',[leadership]='{$newPoints['leadership']}',[LevelUpPoint]='{$leftPoints}' WHERE Name='{$characterName}'");
			echo $okey_start . mmw_lang_character_stats_added . ' ' . $leftPoints . $okey_end;
			writelog('add_stats', 'Character <b>' . $characterName . '</b> Has Been <span style="color:red">Updated</span> Stats with the next -> Strength: ' . $newPoints['strength'] . '|Agiltiy: ' . $newPoints['dexterity'] . '|Vitality: ' . $newPoints['vitality'] . '|Energy: ' . $newPoints['energy'] . '|Command: ' . $newPoints['leadership'] . ', Levelup Points Left: ' . $leftPoints);
		}
	}


	static function clear_pk($characterName)
	{
		global $mmw, $okey_start, $okey_end, $die_start, $die_end;

		$characterResult = mssql_query("SELECT Money,PkLevel FROM dbo.Character WHERE Name='{$characterName}'");
		$characterInfo = mssql_fetch_row($characterResult);
		$characterMoney = $characterInfo[0];
		$warehouseMoney = self::getAccountExtraMoney();
		$totalMoney = $characterMoney + $warehouseMoney;

		$warehouseMoney -= $mmw['clear_pk_cost'];
		if ($warehouseMoney < 0) {
			$characterMoney += $warehouseMoney;
			$warehouseMoney = 0;
		}

		if ($characterInfo[1] < 3) {
			echo $die_start . mmw_lang_is_not_killer . $die_end;
		} elseif ($totalMoney - $mmw['clear_pk_cost'] < 0) {
			echo $die_start . mmw_lang_clear_pk_need . ' ' . zen_format($mmw['clear_pk_cost']) . ' Zen!' . $die_end;
		} else {
			mssql_query("UPDATE dbo.warehouse SET [extMoney]='{$warehouseMoney}' WHERE AccountID='{$_SESSION['user']}'");
			mssql_query("UPDATE dbo.Character SET [money]='{$characterMoney}',[PkLevel]=3,[PkTime]=0 WHERE Name='{$characterName}'");
			echo $okey_start . mmw_lang_character_cleared . $okey_end;
			writelog('clear_pk', 'Character <b>' . $characterName . '</b> Has Been <span style="color:red">Cleared</span> Pk Status');
		}
	}


	static function move($characterName)
	{
		global $mmw, $okey_start, $okey_end, $die_start, $die_end;

		list($mapNumber, $x, $y) = $mmw['move_list'][$_POST['map']];

		$characterResult = mssql_query("SELECT Money FROM dbo.character WHERE Name='{$characterName}'");
		$characterInfo = mssql_fetch_row($characterResult);
		$characterMoney = $characterInfo[0];
		$warehouseMoney = self::getAccountExtraMoney();
		$totalMoney = $characterMoney + $warehouseMoney;

		$warehouseMoney -= $mmw['move_zen'];
		if ($warehouseMoney < 0) {
			$characterMoney += $warehouseMoney;
			$warehouseMoney = 0;
		}

		if ($_POST['map'] === '') {
			echo $die_start . mmw_lang_left_blank . $die_end;
		} elseif ($totalMoney - $mmw['move_zen'] < 0) {
			echo $die_start . mmw_lang_move_need . ' ' . zen_format($mmw['move_zen']) . ' Zen!' . $die_end;
		} else {
			mssql_query("UPDATE dbo.warehouse SET [extMoney]='{$warehouseMoney}' WHERE AccountID='{$_SESSION['user']}'");
			mssql_query("UPDATE dbo.Character SET [money]='{$characterMoney}',[mapnumber]='$mapNumber',[mapposx]='$x',[mapposy]='$y' WHERE Name='{$characterName}'");
			echo $okey_start . mmw_lang_character_moved . $okey_end;
			writelog('move', 'Char <span style="color:red">' . $characterName . '</span> Has Been Moved To: ' . $mapNumber . ', ' . $x . '-' . $y . '|Char: ' . $characterMoney . ' Zen|Acc: ' . $warehouseMoney . ' Zen');
		}
	}


	static function change_class($characterName)
	{
		global $mmw, $okey_start, $okey_end, $die_start, $die_end;

		list($class, $price) = $mmw['change_class_list'][$_POST['new_class']];

		$characterResult = mssql_query("SELECT Money,CAST(Inventory AS varbinary(1728)) FROM dbo.Character WHERE Name='{$characterName}'");
		$characterInfo = mssql_fetch_row($characterResult);
		$characterInventory = strtoupper(substr(bin2hex($characterInfo[1]), 0, $mmw['item_byte_size'] * 12));
		$characterMoney = $characterInfo[0];
		$warehouseMoney = self::getAccountExtraMoney();
		$totalMoney = $characterMoney + $warehouseMoney;

		$warehouseMoney -= $price;
		if ($warehouseMoney < 0) {
			$characterMoney += $warehouseMoney;
			$warehouseMoney = 0;
		}

		if ($_POST['new_class'] === '') {
			echo $die_start . mmw_lang_left_blank . $die_end;
		} elseif ($characterInventory !== free_hex($mmw['item_byte_size'], 12)) {
			echo $die_start . mmw_lang_take_off_set . $die_end;
		} elseif ($totalMoney - $price < 0) {
			echo $die_start . mmw_lang_change_class_need . ' ' . zen_format($price) . ' Zen!' . $die_end;
		} else {
			mssql_query("UPDATE dbo.warehouse SET [extMoney]='{$warehouseMoney}' WHERE AccountID='{$_SESSION['user']}'");
			mssql_query("UPDATE dbo.Character SET [money]='{$characterMoney}',[class]='{$class}',[MagicList]=0xFF,[Quest]=0xFF WHERE Name='{$characterName}'");
			echo $okey_start . mmw_lang_character_changed . $okey_end;
			writelog('change_class', 'Char <span style="color:red">' . $characterName . '</span> Has Been Changed Class To: ' . $class . '|Char: ' . $characterMoney . ' Zen|Acc: ' . $warehouseMoney . ' Zen');
		}
	}
}
