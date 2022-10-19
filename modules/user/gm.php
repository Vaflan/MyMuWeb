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

require_once __DIR__ . '/../../includes/shout_msg.php';

if (isset($_POST['hex_wh'])) {
	$money = intval($_POST['Money']);
	$extMoney = intval($_POST['extMoney']);
	$hex_wh = clean_var(stripslashes($_POST['hex_wh']));

	if (empty($hex_wh)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif ($mmw['status_rules'][$_SESSION['mmw_status']]['hex_wh'] != 1) {
		echo $die_start . 'You Can`t Use HEX WareHouse!' . $die_end;
	} elseif (!preg_match('/^\d+$/', $money) || !preg_match('/^\d+$/', $extMoney)) {
		echo $die_start . 'Money must be a positive number!' . $die_end;
	} else {
		/** @noinspection SqlWithoutWhere */
		$query = "UPDATE dbo.warehouse SET [Items]=0x{$hex_wh},[Money]={$money},[extMoney]={$extMoney} WHERE AccountID='{$_SESSION['user']}'";
		echo mssql_query($query)
			? $okey_start . $_SESSION['user'] . 'WareHouse SuccessFully Edited!' . $okey_end
			: $die_start . 'HEX ErroR blyat`! :(' . $die_end;
		writelog('hex_wh', 'Acc: <b>' . $_SESSION['user'] . '</b> Has Been <div style="color:#F00">edit wh</div>: ' . $hex_wh . ' | [Money]=' . $money . ', [extMoney]=' . $extMoney);
	}
	echo $rowbr;
}

if (isset($_POST['gm_msg'])) {
	$text = stripslashes($_POST['gm_msg']);

	if (empty($text)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif ($mmw['status_rules'][$_SESSION['mmw_status']]['gm_msg'] != 1) {
		echo $die_start . 'You Can`t Send GM Message!' . $die_end;
	} else {
		echo send_gm_msg($mmw['joinserver']['ip'], $mmw['joinserver']['port'], $text)
			? $okey_start . 'GM Msg SuccessFully Send!' . $okey_end
			: $die_start . 'GM Msg ErroR blya! :(' . $die_end;
		writelog('gm_msg', 'Acc: <b>' . $_SESSION['user'] . '</b> Has Been <div style="color:#F00">Send Msg</div>: ' . $text);
	}
	echo $rowbr;
}

if (isset($_POST['block_mode'])) {
	$block_mode = intval($_POST['block_mode']);
	$entity = clean_var(stripslashes($_POST['entity']));
	$entity_value = clean_var(stripslashes($_POST['entity_value']));
	$account_unblock = clean_var(stripslashes($_POST['account_unblock']));
	$unblock_time = intval($_POST['unblock_time']);
	$block_date = clean_var(stripslashes($_POST['block_date']));
	$block_reason = clean_var(stripslashes($_POST['block_reason']));

	if (empty($account_unblock) && $block_mode === 0) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif ($mmw['status_rules'][$_SESSION['mmw_status']]['gm_block'] != 1) {
		echo $die_start . 'You Can`t Send GM Message!' . $die_end;
	} else {
		if ($block_mode === 0) {
			mssql_query("UPDATE dbo.MEMB_INFO SET [bloc_code]=0,[block_date]=0,[unblock_time]=0 WHERE memb___id='{$account_unblock}'");
			echo $okey_start . 'Account ' . $account_unblock . ' is Unblocked!' . $okey_end;
		} else {
			$block_menu = '';
			if ($block_date !== 'no') {
				$block_date = ($block_date === 'yes')
					? time()
					: 0;
				$block_menu = "[block_date]='{$block_date}',";
			}
			$block_menu .= "[unblock_time]='{$unblock_time}',[block_reason]='{$block_reason}',[blocked_by]='{$_SESSION['character']}',";

			$account_block = ($entity === 'character_block')
				? "(SELECT AccountID FROM dbo.Character WHERE Name='{$entity_value}')"
				: "'{$entity_value}'";
			/** @noinspection SqlWithoutWhere */
			$query = "UPDATE dbo.MEMB_INFO SET {$block_menu} [bloc_code]=1 WHERE memb___id={$account_block}";
			echo mssql_query($query)
				? $okey_start . 'Account ' . $account_block . ' is Blocked!' . $okey_end
				: $die_start . $query . $die_end;
		}
		writelog('gm_block', 'Account: <b>' . $account_block . $account_unblock . '</b> Has Been <div style="color:#F00">block mode</div>: ' . $block_mode . ' by ' . $_SESSION['user']);
	}
	echo $rowbr;
}
?>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<tr>
		<td style="text-align:right;width:100px">Your Level:</td>
		<td>
			<b><?php echo $_SESSION['mmw_status']; ?></b>
			(<?php echo $mmw['status_rules'][$_SESSION['mmw_status']]['name']; ?>)
		</td>
	</tr>
	<tr>
		<td style="text-align:right">Security Code:</td>
		<td><b><?php echo $mmw['admin_security_code']; ?></b></td>
	</tr>
	<tr>
		<td style="text-align:right">Admin Area:</td>
		<td><a target="_blank" href="admin/">Enter</a></td>
	</tr>
</table>

<?php
echo $rowbr;

if ($mmw['status_rules'][$_SESSION['mmw_status']]['hex_wh']) {
	echo '<div style="text-align:center;font-weight:bold">HEX Warehouse Can Edit!</div>' . $rowbr;
	$result = mssql_query("SELECT Money,extMoney,Items FROM dbo.warehouse where AccountId='{$_SESSION['user']}'");
	$row = mssql_fetch_row($result);
	$vault = bin2hex($row[2]);
	?>
	<form name="edit_wh" method="post" action="">
		<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:90%">
			<tr>
				<td style="text-align:center" colspan="2">
					<textarea name="hex_wh" rows="12" style="width:100%"><?php echo $vault; ?></textarea>
				</td>
			</tr>
			<tr>
				<td style="text-align:center">
					<?php echo mmw_lang_ware_house; ?>:
					<input name="Money" type="text" value="<?php echo $row[0]; ?>" size="14">
				</td>
				<td style="text-align:center">
					<?php echo mmw_lang_extra_ware_house; ?>:
					<input name="extMoney" type="text" value="<?php echo $row[1]; ?>" size="14">
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center">
					<input type="submit" value="Submit">
					<input type="reset" value="Renew">
				</td>
			</tr>
		</table>
	</form>
	<?php
	echo $rowbr;
}

if ($mmw['status_rules'][$_SESSION['mmw_status']]['gm_msg']) {
	echo '<div style="text-align:center;font-weight:bold">GameMaster Chat In Game!</div>' . $rowbr;
	$gmMessage = isset($_POST['gm_msg'])
		? $_POST['gm_msg']
		: $_SESSION['character'] . ': TEXT';
	?>
	<form name="form_gm_msg" method="post" action="">
		<table class="sort-table" style="margin:0 auto;border:0;padding:0">
			<tr>
				<td><input name="gm_msg" type="text" value="<?php echo $gmMessage; ?>" size="60" maxlength="40"></td>
			</tr>
			<tr>
				<td style="text-align:center">
					<input type="submit" value="Submit">
					<input type="reset" value="Renew">
				</td>
			</tr>
		</table>
	</form>
	<?php
	echo $rowbr;
}

if ($mmw['status_rules'][$_SESSION['mmw_status']]['gm_block']) {
	echo '<div style="text-align:center;font-weight:bold">Set Block and UnBlock acc!</div>' . $rowbr;
	$result = mssql_query("SELECT memb___id FROM dbo.MEMB_INFO WHERE bloc_code=1 ORDER BY block_date ");
	$blocked = '<option value="">No Account</option>';
	if (mssql_num_rows($result) > 0) {
		$blocked = '';
		while ($row = mssql_fetch_row($result)) {
			$blocked .= '<option>' . $row[0] . '</option>';
		}
	}
	?>
	<script>
        function select_block() {
            var select = document.form_gm_block_acc.block_mode.value;
            document.getElementById('block0').style.display = 'none';
            document.getElementById('block1').style.display = 'none';
            document.getElementById('block' + select).style.display = '';
        }
	</script>

	<form name="form_gm_block_acc" method="post" action="">
		<table class="sort-table" style="margin:0 auto;border:0;padding:0">
			<tr>
				<td style="text-align:right">Mode:</td>
				<td>
					<select name="block_mode" size="1" onChange="select_block();">
						<option value="1">Blocked</option>
						<option value="0">UnBlock</option>
					</select>
				</td>
			</tr>
			<tbody id="block1">
			<tr>
				<td style="text-align:right">
					<select name="entity" size="1" onChange="select_block();">
						<option value="account_block"><?php echo mmw_lang_account; ?></option>
						<option value="character_block"><?php echo mmw_lang_character; ?></option>
					</select>
				</td>
				<td><input name="entity_value" type="text" value="" size="12" maxlength="10"></td>
			</tr>
			<tr>
				<td style="text-align:right">Block Time:</td>
				<td>
					<select name="unblock_time" size="1">
						<option value="0">Forever</option>
						<option value="1800">30 m</option>
						<option value="3600">1 h</option>
						<option value="21600">6 h</option>
						<option value="43200">12 h</option>
						<option value="86400">1 day</option>
						<option value="172800">2 day</option>
						<option value="259200">3 day</option>
						<option value="432000">5 day</option>
						<option value="864000">10 day</option>
						<option value="2592000">30 day</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:right">Block Date:</td>
				<td><select name="block_date" size="1">
						<option value="0">Not Select Day</option>
						<option value="no">Has been Blocked</option>
						<option value="yes">Today <?php echo date('H:i'); ?></option>
					</select></td>
			</tr>
			<tr>
				<td style="text-align:right">Block Reason:</td>
				<td><input name="block_reason" type="text" value="" size="17" maxlength="200"></td>
			</tr>
			</tbody>
			<tbody id="block0" style="display:none;">
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_account; ?>:</td>
				<td><select name="account_unblock" size="1"><?php echo $blocked; ?></select></td>
			</tr>
			</tbody>
			<tr>
				<td colspan="2" style="text-align:center">
					<input type="submit" value="Submit">
					<input type="reset" value="Renew">
				</td>
			</tr>
		</table>
	</form>
	<?php
	echo $rowbr;
}
?>

<div style="text-align:center;font-style:italic"><a href="http://www.mymuweb.ru/">Thank Vaflan For This MMW!</a></div>