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

/**
 * @param string $point
 * @param int $update
 * @return string
 */
function whQueryBuilderZen($point, $update = null)
{
	$queryBuilder = array(
		'column' => 'Money',
		'table' => 'warehouse',
		'extend_where' => '',
	);
	if ($point === 'ewh') {
		$queryBuilder['column'] = 'extMoney';
	}
	if (substr($point, 0, 2) === 'ch') {
		$queryBuilder['table'] = 'Character';
		$queryBuilder['extend_where'] = "AND Name='" . substr($point, 2) . "'";
	}

	/** @noinspection SqlWithoutWhere */
	$query = empty($update)
		? "SELECT {$queryBuilder['column']} FROM dbo.{$queryBuilder['table']}"
		: "UPDATE dbo.{$queryBuilder['table']} SET [{$queryBuilder['column']}] = [{$queryBuilder['column']}] + {$update}";

	return "{$query} WHERE AccountId='{$_SESSION['user']}' {$queryBuilder['extend_where']}";
}

if ($acc_online_check === 0) {
	if (isset($_POST['zen'])) {
		$from = stripslashes($_POST['from_wh']);
		$to = stripslashes($_POST['to_wh']);
		$zen = intval(str_replace('k', '000', $_POST['zen']));

		// From
		$queryFrom = whQueryBuilderZen($from);
		$resultFrom = mssql_query($queryFrom);
		$rowFrom = mssql_fetch_row($resultFrom);
		$fromCountZen = empty($rowFrom[0])
			? 0
			: $rowFrom[0];

		// To
		$queryTo = whQueryBuilderZen($to);
		$resultTo = mssql_query($queryTo);
		$rowTo = mssql_fetch_row($resultTo);
		$toCountZen = empty($rowTo[0])
			? 0
			: $rowTo[0];

		$fromEnd = $fromCountZen - $zen;
		$toEnd = $toCountZen + $zen;

		$error = false;
		if (empty($_POST['from_wh']) || empty($_POST['to_wh']) || empty($_POST['zen'])) {
			$error = true;
			echo $die_start . mmw_lang_left_blank . $die_end;
		} elseif (!preg_match('/^\d+$/', $zen)) {
			$error = true;
			echo $die_start . mmw_lang_zen_must_be_number . $die_end;
		} elseif ($from === $to) {
			$error = true;
			echo $die_start . mmw_lang_zen_cant_move . $die_end;
		} elseif ($fromEnd < 0) {
			$error = true;
			echo $die_start . mmw_lang_not_Zen_to_move . $die_end;
		} elseif ($to != 'ewh' && $toEnd > $mmw['max_char_wh_zen']) {
			$error = true;
			echo $die_start . mmw_lang_zen_more_max . ' ' . zen_format($mmw['max_char_wh_zen']) . ' Zen!' . $die_end;
		}

		if (!$error) {
			mssql_query(whQueryBuilderZen($from, -$zen));
			mssql_query(whQueryBuilderZen($to, $zen));
			echo $okey_start . zen_format($zen) . ' ' . mmw_lang_zen_moved . $okey_end;
			writelog('money', 'Acc <span style="color:red">' . $_SESSION['user'] . '</span> Has Been from: ' . $fromCountZen . ' <u>' . $from . '</u>|to: ' . $toCountZen . ' <u>' . $to . '</u>|how many: <b>' . $zen . '</b>|from end: ' . $fromEnd . '|to end: ' . $toEnd);
		}
		echo $rowbr;
	}

	$language = array(
		'where' => mmw_lang_where,
		'extra_ware_house' => mmw_lang_extra_ware_house,
		'ware_house' => mmw_lang_ware_house,
		'zen_from' => mmw_lang_zen_from,
		'zen_to' => mmw_lang_zen_to,
		'send' => mmw_lang_send,
		'renew' => mmw_lang_renew,
	);

	$result = mssql_query("SELECT Money,extMoney FROM dbo.warehouse WHERE accountid='{$_SESSION['user']}'");

	if (mssql_num_rows($result)) {
		$whRow = mssql_fetch_row($result);
		$whMoney = zen_format(empty($whRow[0]) ? 0 : $whRow[0]);
		$whExtraMoney = zen_format(empty($whRow[1]) ? 0 : $whRow[1]);

		$maxCharacterWarehouseZenCount = zen_format($mmw['max_char_wh_zen'], 'small');
		$charactersInfo = '';
		$selectFromTo = '<option value="ewh">' . mmw_lang_extra_ware_house . '</option>'
			. '<option value="wh0">' . mmw_lang_ware_house . '</option>';

		$result = mssql_query("SELECT Name,Money FROM dbo.Character WHERE AccountID='{$_SESSION['user']}'");
		while ($row = mssql_fetch_row($result)) {
			$zenCount = zen_format($row[1]);

			$charactersInfo .= <<<HTML
			<tr>
				<td>{$row[0]}</td>
				<td>{$zenCount}</td>
				<td>{$maxCharacterWarehouseZenCount}</td>
			</tr>
HTML;
			$selectFromTo .= '<option value="ch' . $row[0] . '">' . $row[0] . '</option>';
		}

		$extendedCurrencies = '';
		if ($mmw['enable_credits']) {
			/** @noinspection SqlResolve */
			$credits = mssql_fetch_row(mssql_query("SELECT credits FROM dbo.MEMB_CREDITS WHERE memb___id='{$_SESSION['user']}'"))[0] ?: 0;
			$extendedCurrencies .= <<<HTML
			<tr>
				<td>Credits</td>
				<td>{$credits}</td>
				<td>~</td>
			</tr>
HTML;
		}
		try {
			$csPoints = mssql_fetch_row(mssql_query("SELECT cspoints FROM dbo.MEMB_INFO WHERE memb___id='{$_SESSION['user']}'"))[0] ?: 0;
			$extendedCurrencies .= <<<HTML
			<tr>
				<td>W coin</td>
				<td>{$csPoints}</td>
				<td>~</td>
			</tr>
HTML;
		} catch (Exception $ignored) {
			// Do nothing
		}

		echo <<<HTML
		<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
			<thead>
			<tr>
				<td>{$language['where']}</td>
				<td>Zen</td>
				<td style="width:50px">Max Zen</td>
			</tr>
			</thead>
			<tr>
				<td>{$language['extra_ware_house']}</td>
				<td>{$whExtraMoney}</td>
				<td>~</td>
			</tr>
			<tr>
				<td>{$language['ware_house']}</td>
				<td>{$whMoney}</td>
				<td>{$maxCharacterWarehouseZenCount}</td>
			</tr>
			{$charactersInfo}
			{$extendedCurrencies}
		</table>

		{$rowbr}

		<form name="send_money" method="post" action="">
			<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
				<tr>
					<td>{$language['zen_from']}</td>
					<td><select name="from_wh">{$selectFromTo}</select></td>
				</tr>
				<tr>
					<td>{$language['zen_to']}</td>
					<td><select name="to_wh">{$selectFromTo}</select></td>
				</tr>
				<tr>
					<td>Zen</td>
					<td>
						<input name="zen" type='text' value="0" size="14">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" value="{$language['send']}">
						<input type="reset" value="{$language['renew']}">
					</td>
				</tr>
			</table>
		</form>
HTML;

	} else {
		echo $die_start . mmw_lang_check_vault_keeper_in_game . $die_end;
	}
} elseif ($acc_online_check === 1) {
	echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
} else {
	echo $die_start . 'I find you Hacker! :)' . $die_end;
}
