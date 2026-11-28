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

if (isset($_POST['change_password'])) {
	$validates = array(
		'old_password' => array('label' => $die_start . mmw_lang_invalid_current_password . $die_end, 'len_min' => 4, 'len_max' => 10, 'cont' => 'alpha'),
		'new_password' => array('label' => $die_start . mmw_lang_invalid_new_password . $die_end, 'len_min' => 4, 'len_max' => 10, 'cont' => 'alpha'),
		'renew_password' => array('label' => $die_start . mmw_lang_invalid_repassword . $die_end, 'len_max' => 10, 'equal' => 'new_password')
	);

	$errorValidates = false;
	foreach ($validates as $field => $rule) {
		if (!isset($_POST[$field])
			|| strlen($_POST[$field]) < $rule['len_min']
			|| strlen($_POST[$field]) > $rule['len_max']
			|| ($rule['cont'] === 'alpha' && !preg_match('/^[a-z\d_-]*$/i', $_POST[$field]))
			|| ($rule['cont'] === 'email' && !filter_var($_POST[$field], FILTER_VALIDATE_EMAIL))
			|| (isset($rule['equal']) && $_POST[$field] !== $_POST[$rule['equal']])
		) {
			echo $rule['label'];
			var_dump($_POST[$field]);
			var_dump($_POST[$rule['equal']]);
			$errorValidates = true;
		}
	}

	if ($errorValidates !== true) {
		$throwError = false;

		$oldPassword = stripslashes($_POST['old_password']);
		$newPassword = stripslashes($_POST['new_password']);
		$renewPassword = stripslashes($_POST['renew_password']);

		$queryPassword = ($mmw['md5'])
			? "[dbo].[fn_md5]('{$oldPassword}', '{$_SESSION['user']}')"
			: "'{$oldPassword}'";
		$passwordCheck = mssql_num_rows(mssql_query("SELECT memb___id FROM dbo.MEMB_INFO WHERE memb___id='{$_SESSION['user']}' AND memb__pwd={$queryPassword}"));

		if ($acc_online_check !== 0) {
			$throwError = true;
			echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;
		}
		if ($passwordCheck === 0) {
			$throwError = true;
			echo $die_start . mmw_lang_invalid_current_password . $die_end;
		}

		if (!$throwError) {
			$queryPassword = ($mmw['md5'])
				? "[dbo].[fn_md5]('{$newPassword}', '{$_SESSION['user']}')"
				: "'{$newPassword}'";

			mssql_query("UPDATE dbo.MEMB_INFO SET [memb__pwd]={$queryPassword} WHERE memb___id ='{$_SESSION['user']}'");

			$_SESSION['pass'] = $newPassword;
			echo $okey_start . mmw_lang_password_changed . $okey_end;
		}
	}
	echo $rowbr;
}

if (isset($_POST['profile'])) {
	$fullName = clean_var(stripslashes($_POST['full_name']));
	$age = clean_var(stripslashes($_POST['age']));
	$country = clean_var(stripslashes($_POST['country']));
	$avatar = clean_var(stripslashes($_POST['avatar']));
	$gender = clean_var(stripslashes($_POST['gender']));
	$hide_profile = clean_var(stripslashes($_POST['hide_profile']));
	$y = clean_var(stripslashes($_POST['y']));
	$msn = clean_var(stripslashes($_POST['msn']));
	$icq = clean_var(stripslashes($_POST['icq']));
	$skype = clean_var(stripslashes($_POST['skype']));

	mssql_query("UPDATE dbo.MEMB_INFO SET [memb_name]='{$fullName}',[country]='{$country}',[gender]='{$gender}',[age]='{$age}',[avatar]='{$avatar}',[hide_profile]='{$hide_profile}',[y]='{$y}',[msn]='{$msn}',[icq]='{$icq}',[skype]='{$skype}' WHERE memb___id='{$_SESSION['user']}'");
	writelog('profile', 'Acc <span style="color:red">' . $_SESSION['user'] . '</span> Has Been Change: [memb_name]=' . $fullName . ',[country]=' . $country . ',[gender]=' . $gender . ',[age]=' . $age . ',[avatar]=' . $avatar . ',[hide_profile]=' . $hide_profile . ',[y]=' . $y . ',[msn]=' . $msn . ',[icq]=' . $icq . ',[skype]=' . $skype);
	echo $okey_start . mmw_lang_profile_edited . $okey_end;

	echo $rowbr;
}

if (isset($_POST['new_request'])) {
	if (empty($_POST['subject']) || empty($_POST['msg'])) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} else {
		$title = bugsend(stripslashes($_POST['subject']));
		$msg = str_replace('[br]', '<br>', bugsend(stripslashes($_POST['msg'])));
		$text = 'Acc: <b>' . $_SESSION['user'] . '</b>, New Request Title: <u>' . $title . '</u><br><span style="color:red">' . $msg . '</span><br>All Those On <i>' . date('d.m.Y H:i:s') . '</i> By <u>' . $_SERVER['REMOTE_ADDR'] . '</u><hr>' . PHP_EOL;
		$fp = fopen('logs/request.htm', 'a');
		fputs($fp, $text);
		fclose($fp);
		echo $okey_start . mmw_lang_request_sent . $okey_end;
	}
	echo $rowbr;
}

$accInfo_result = mssql_query("SELECT mail_addr,memb_name,age,country,gender,avatar,hide_profile,y,msn,icq,skype,appl_days FROM dbo.MEMB_INFO WHERE memb___id='{$_SESSION['user']}'");
$accInfo = mssql_fetch_row($accInfo_result);

$timeInfo_result = mssql_query("SELECT ConnectTM,DisconnectTM FROM dbo.MEMB_STAT WHERE memb___id='{$_SESSION['user']}'");
$timeInfo = mssql_fetch_row($timeInfo_result);

// Referral
if ($mmw['referral']['switch']) {
	$referral_list = mmw_lang_no_referral;
	$referral_num_check = 0;

	$referral_result = mssql_query("SELECT memb___id,ref_check FROM dbo.MEMB_INFO WHERE ref_acc='{$_SESSION['user']}'");
	if ($referral_num = mssql_num_rows($referral_result)) {
		$rank = 0;
		$referral_list = '';
		while ($referral_row = mssql_fetch_row($referral_result)) {
			$rank++;
			if (empty($referral_row[1])) {
				$char_ref_sql = mssql_query("SELECT name FROM dbo.Character WHERE AccountID='{$referral_row[0]}' AND {$mmw['reset_column']} > 0");
				if (mssql_num_rows($char_ref_sql)) {
					$referral_row[1] = 1;
					$referral_character = mssql_fetch_row($char_ref_sql)[0];
					mssql_query("UPDATE dbo.MEMB_INFO SET [ref_check]=1 WHERE memb___id='{$referral_row[0]}'");
					mssql_query("UPDATE dbo.warehouse SET [extMoney]=[extMoney] + {$mmw['referral']['zen']} WHERE AccountID='{$_SESSION['user']}'");
					writelog('referral', 'Account <b>' . $_SESSION['user'] . '</b> Has Been <span style="color:red">GET</span> Zen: ' . $mmw['referral']['zen'] . '|For Acc: ' . $referral_row[0] . '|For Char: ' . $referral_character);
				}
			}

			$referralStatus = empty($referral_row[1])
				? mmw_lang_have_not_a_reset
				: mmw_lang_have_a_reset;
			$referral_list .= $rank . '. ' . $referral_row[0] . ' (' . $referralStatus . ')<br>';

			if (!empty($referral_row[1])) {
				$referral_num_check++;
			}
		}
	}
}
?>
<form action="" method="post">
	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:380px">
		<thead>
		<tr>
			<th colspan="2" style="text-align:center"><?php echo mmw_lang_profile; ?></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_account; ?>:</td>
			<td><b><?php echo $_SESSION['user']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_email_address; ?>:</td>
			<td><?php echo $accInfo[0]; ?></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_register_date; ?>:</td>
			<td><?php echo time_format($accInfo[11], 'd M Y, H:i'); ?></td>
		</tr>

		<?php if ($mmw['referral']['switch']) : ?>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_about_referral; ?>:</td>
				<td><?php echo mmw_lang_one_referral_with_reset . ' = ' . zen_format($mmw['referral']['zen']) . ' Zen'; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_referral_link; ?>:</td>
				<td><?php echo $mmw['serverwebsite']; ?>?ref=<?php echo $_SESSION['user']; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_your_referrals; ?>:</td>
				<td>
					<span class="helpLink" title="<?php echo $referral_list; ?>">
						<?php echo mmw_lang_all_referrals . ': ' . $referral_num . ', ' . mmw_lang_have_a_reset . ': ' . $referral_num_check; ?>
					</span>
				</td>
			</tr>
		<?php endif; ?>

		<?php if ($acc_online_check) : ?>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_last_login; ?>:</td>
				<td><?php echo time_format($timeInfo[0], 'd M Y, H:i'); ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_login_status; ?>:</td>
				<td><span class="online"><?php echo mmw_lang_acc_online; ?></span></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_time_in_playing; ?>:</td>
				<td>
					<span class="online">
						<?php echo date_formats(time_format($timeInfo[0], null), time()); ?>
					</span>
				</td>
			</tr>
		<?php elseif ($acc_online_check === 0) : ?>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_last_login; ?>:</td>
				<td><?php echo time_format($timeInfo[0], 'd M Y, H:i'); ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_login_status; ?>:</td>
				<td>
					<span class="offline">
						<?php echo mmw_lang_acc_offline; ?> [<?php echo date_formats(time_format($timeInfo[0], null), time()); ?>]
					</span>
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_last_play_time; ?>:</td>
				<td>
					<span class="offline">
						<?php echo date_formats(time_format($timeInfo[0], null), time_format($timeInfo[1], null)); ?>
					</span>
				</td>
			</tr>
		<?php else : ?>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_last_login; ?>:</td>
				<td><?php echo mmw_lang_not_joined; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_login_status; ?>:</td>
				<td><?php echo mmw_lang_not_joined; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_last_play_time; ?>:</td>
				<td><?php echo mmw_lang_not_joined; ?></td>
			</tr>
		<?php endif; ?>

		<?php if ($acc_online_check) : ?>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_full_name; ?>:</td>
				<td><?php echo $accInfo[1]; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_age; ?>:</td>
				<td><?php echo $accInfo[2]; ?>
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_country; ?>:</td>
				<td><?php echo country($accInfo[3]); ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_gender; ?>:</td>
				<td><?php echo gender($accInfo[4]); ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_avatar_url; ?>:</td>
				<td><?php echo $accInfo[5]; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_hide_profile; ?>:</td>
				<td><?php echo ($accInfo[6] == 1) ? mmw_lang_yes : mmw_lang_no; ?>
				</td>
			</tr>
			<tr>
				<td style="text-align:right">Yahoo!:</td>
				<td><?php echo $accInfo[7]; ?></td>
			</tr>
			<tr>
				<td style="text-align:right">MSN:</td>
				<td><?php echo $accInfo[8]; ?></td>
			</tr>
			<tr>
				<td style="text-align:right">ICQ:</td>
				<td><?php echo $accInfo[9]; ?></td>
			</tr>
			<tr>
				<td style="text-align:right">Skype:</td>
				<td><?php echo $accInfo[10]; ?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center"><?php echo mmw_lang_cant_change_online; ?></td>
			</tr>
		<?php else: ?>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_full_name; ?>:</td>
				<td>
					<input name="full_name" type="text" value="<?php echo $accInfo[1]; ?>" size="12" maxlength="10">
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_age; ?>:</td>
				<td>
					<input name="age" type="text" value="<?php echo $accInfo[2]; ?>" size="2" maxlength="2">
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_country; ?>:</td>
				<td>
					<select name="country">
						<option></option>
						<?php foreach (country(null, true) as $id => $country) : ?>
							<option value="<?php echo $id; ?>"<?php echo ($accInfo[3] == $id) ? ' selected' : ''; ?>>
								<?php echo $country; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_gender; ?>:</td>
				<td>
					<select name="gender">
						<option value="male"<?php echo ($accInfo[4] === 'male') ? ' selected' : ''; ?>>
							<?php echo mmw_lang_male; ?>
						</option>
						<option value="female"<?php echo ($accInfo[4] === 'female') ? ' selected' : ''; ?>>
							<?php echo mmw_lang_female; ?>
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_avatar_url; ?>:</td>
				<td>
					<input name="avatar" type="text" value="<?php echo $accInfo[5]; ?>" size="20" maxlength="100">
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_hide_profile; ?>:</td>
				<td>
					<select name="hide_profile">
						<option value="0"<?php echo ($accInfo[6] == 0) ? ' selected' : ''; ?>><?php echo mmw_lang_no; ?></option>
						<option value="1"<?php echo ($accInfo[6] == 1) ? ' selected' : ''; ?>><?php echo mmw_lang_yes; ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:right">Yahoo!:</td>
				<td>
					<input name="y" type="text" value="<?php echo $accInfo[7]; ?>" size="20" maxlength="100">
				</td>
			</tr>
			<tr>
				<td style="text-align:right">MSN:</td>
				<td>
					<input name="msn" type="text" value="<?php echo $accInfo[8]; ?>" size="20" maxlength="100">
				</td>
			</tr>
			<tr>
				<td style="text-align:right">ICQ:</td>
				<td>
					<input name="icq" type="text" value="<?php echo $accInfo[9]; ?>" size="20" maxlength="100">
				</td>
			</tr>
			<tr>
				<td style="text-align:right">Skype:</td>
				<td>
					<input name="skype" type="text" value="<?php echo $accInfo[10]; ?>" size="20" maxlength="100">
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center">
					<input type="submit" name="profile" value="<?php echo mmw_lang_save_profile; ?>">
					<input type="reset" value="<?php echo mmw_lang_renew; ?>">
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
</form>

<?php echo $rowbr; ?>

<form action="" method="post">
	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:380px">
		<thead>
		<tr>
			<th colspan="2" style="text-align:center"><?php echo mmw_lang_password; ?></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_current_password; ?>:</td>
			<td><input name="old_password" type="password" size="20" maxlength="10"></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_new_password; ?>:</td>
			<td><input name="new_password" type="password" size="20" maxlength="10"></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_retype_new_password; ?>:</td>
			<td><input name="renew_password" type="password" size="20" maxlength="10"></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
				<?php if ($acc_online_check) : ?>
					<?php echo mmw_lang_cant_change_online; ?>
				<?php else: ?>
					<input type="submit" name="change_password" value="<?php echo mmw_lang_change_password; ?>">
				<?php endif; ?>
			</td>
		</tr>
		</tbody>
	</table>
</form>

<?php echo $rowbr; ?>

<form action="" method="post">
	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:380px">
		<thead>
		<tr>
			<th colspan="2" style="text-align:center">Contact the administrator</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_to; ?>:</td>
			<td>
				<?php echo $mmw['servername']; ?>
			</td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_title; ?>:</td>
			<td>
				<input name="subject" type="text" size="20" maxlength="30">
			</td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_text; ?>:</td>
			<td>
				<textarea name="msg" rows="8" cols="22"
						  onChange="CheckMsgLength(this,250)"
						  onKeyUp="CheckMsgLength(this,250)"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
				<input type="submit" name="new_request" value="<?php echo mmw_lang_send_message; ?>">
				<input type="reset" value="<?php echo mmw_lang_renew; ?>">
			</td>
		</tr>
		</tbody>
	</table>
</form>