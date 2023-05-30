<?php
/**
 * Lost Password v2.20607
 * For MyMuWeb By Vaflan
 * @var array $mmw
 * @var string $rowbr
 * @var string $die_start
 * @var string $die_end
 * @var string $okey_start
 * @var string $okey_end
 */

$step = isset($_GET['step'])
	? intval($_GET['step'])
	: 0;


if ($step === 1) {
	$account = clean_var($_POST['account']);
	$email = clean_var($_POST['email']);
	$account_check = mssql_fetch_row(mssql_query("SELECT memb___id, fpas_ques FROM dbo.MEMB_INFO WHERE mail_addr='{$email}' AND memb___id='{$account}'"));
	if (!empty($account_check[0]) && $account === $account_check[0]) {
		$_SESSION['last_password'] = array(
			'account' => $account,
			'email' => $email,
		);
		$quest = $account_check[1];
	} else {
		$step = null;
		echo $die_start . mmw_lang_account_or_email_address_is_incorrect . $die_end . $rowbr;
	}
} elseif ($step === 2) {
	$account = $_SESSION['last_password']['account'];
	$email = $_SESSION['last_password']['email'];
	$answer = clean_var($_POST['answer']);
	$account_check = mssql_fetch_row(mssql_query("SELECT fpas_answ, memb__pwd FROM dbo.MEMB_INFO WHERE mail_addr='{$email}' and memb___id='{$account}'"));
	if ($account_check[0] !== $answer) {
		$step = null;
		echo $die_start . mmw_lang_secret_answer_is_incorrect . $die_end . $rowbr;
	}
}


switch($step) {
	case 1:
?>
		<form action="?op=lostpass&step=2" method="post" name="step2">
			<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:250px">
				<tr>
					<td style="width:100px;text-align:right"><?php echo mmw_lang_secret_question; ?></td>
					<td><b><?php echo $quest; ?></b></td>
				</tr>
				<tr>
					<td style="text-align:right"><?php echo mmw_lang_secret_answer; ?></td>
					<td><input name="answer" type="text" size="15" maxlength="10"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" value="<?php echo mmw_lang_find_password; ?>">
						<input type="reset" value="<?php echo mmw_lang_renew; ?>">
					</td>
				</tr>
			</table>
		</form>
<?php
		break;
	case 2:
		echo empty($account_check[1])
			? $die_start . 'Fatal error!' . $die_end
			: $okey_start . mmw_lang_your_password . ' ' . $account_check[1] . $okey_end;
		break;
	default:
?>
		<form action="?op=lostpass&step=1" method="post" name="lostpass">
			<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:250px">
				<tr>
					<td style="width:100px;text-align:right"><?php echo mmw_lang_account; ?></td>
					<td><input name="account" type="text" size="15" maxlength="10"></td>
				</tr>
				<tr>
					<td style="text-align:right"><?php echo mmw_lang_email_address; ?></td>
					<td><input name="email" type="text" size="15" maxlength="50"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" value="<?php echo mmw_lang_find_password; ?>">
						<input type="reset" value="<?php echo mmw_lang_renew; ?>">
					</td>
				</tr>
			</table>
		</form>
<?php
		break;
}
