<?php
/**
 * @var array $mmw
 * @var string $rowbr
 * @var string $okey_start
 * @var string $okey_end
 * @var string $die_start
 * @var string $die_end
 */

if (isset($_POST['registration'])) {
	$validates = array(
		'account' => array('label' => $die_start . mmw_lang_invalid_account . $die_end, 'len_min' => 4, 'len_max' => 10, 'cont' => 'alpha'),
		'email' => array('label' => $die_start . mmw_lang_invalid_email . $die_end, 'len_max' => 50, 'cont' => 'email'),
		'password' => array('label' => $die_start . mmw_lang_invalid_password . $die_end, 'len_min' => 4, 'len_max' => 10, 'cont' => 'alpha'),
		'repassword' => array('label' => $die_start . mmw_lang_invalid_repassword . $die_end, 'len_max' => 10, 'equal' => 'password'),
		'question' => array('label' => $die_start . mmw_lang_invalid_question . $die_end, 'len_min' => 4, 'len_max' => 10, 'cont' => 'alpha'),
		'answer' => array('label' => $die_start . mmw_lang_invalid_answer . $die_end, 'len_min' => 4, 'len_max' => 10, 'cont' => 'alpha'),
		'fullname' => array('label' => $die_start . mmw_lang_invalid_fullname . $die_end, 'len_min' => 2, 'len_max' => 10, 'cont' => 'alpha'),
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
			$errorValidates = true;
		}
	}

	if ($errorValidates !== true) {
		$throwError = false;

		$account = stripslashes($_POST['account']);
		$password = stripslashes($_POST['password']);
		$rePassword = stripslashes($_POST['repassword']);
		$email = stripslashes($_POST['email']);
		$sQuestion = stripslashes($_POST['question']);
		$sAnswer = stripslashes($_POST['answer']);
		$country = stripslashes($_POST['country']);
		$gender = stripslashes($_POST['gender']);
		$fullMame = stripslashes($_POST['fullname']);
		$verifyInput = md5($_POST['verifyinput']);
		$referral = $_SESSION['referral'];
		$ip = $_SERVER['REMOTE_ADDR'];

		if ($verifyInput !== $_SESSION['image_random_value']) {
			$throwError = true;
			echo $die_start . mmw_lang_correctly_code . $die_end;
		} else {
			$username_check = mssql_query("SELECT memb___id FROM dbo.MEMB_INFO WHERE memb___id='{$account}'");
			$username_verify = mssql_num_rows($username_check);

			$email_check = mssql_query("SELECT mail_addr FROM dbo.MEMB_INFO WHERE mail_addr='{$email}'");
			$email_verify = mssql_num_rows($email_check);

			$ip_check = mssql_query("SELECT ip FROM dbo.MEMB_INFO WHERE ip='{$ip}'");
			$ip_verify = mssql_num_rows($ip_check);

			if ($username_verify) {
				$throwError = true;
				echo $die_start . mmw_lang_account_in_use . $die_end;
			}
			if ($email_verify) {
				$throwError = true;
				echo $die_start . mmw_lang_email_in_use . $die_end;
			}
			if (empty($country)) {
				$throwError = true;
				echo $die_start . mmw_lang_invalid_country . $die_end;
			}
			if (!empty($mmw['max_ip_acc']) && $ip_verify >= $mmw['max_ip_acc']) {
				$throwError = true;
				echo $die_start . str_replace('{NUMBER}', $mmw['max_ip_acc'], mmw_lang_max_acc_one_ip) . $die_end;
			}
		}

		if (!$throwError) {
			$queryPassword = ($mmw['md5'])
				? "[dbo].[fn_md5]('{$password}', '{$account}')"
				: "'{$password}'";

			$externalColumns = ['', ''];
			foreach ($mmw['external_columns'] as $column => $field) {
				$externalColumns[0] .= ", $column";
				$externalColumns[1] .= ", '$field'";
			}

			mssql_query("INSERT INTO dbo.MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc,ip {$externalColumns[0]})
				VALUES ('$account',{$queryPassword},'$fullMame','1234','$email',GETDATE(),GETDATE(),'2008-12-20','2008-12-20',1,0,0,'$sQuestion','$sAnswer','$country','$gender',0,'$referral','$ip' {$externalColumns[1]})");

			$warehouseItems = '0x' . free_hex($mmw['item_byte_size'], 120);
			mssql_query("INSERT INTO dbo.warehouse (AccountID, Items, EndUseDate, DbVersion, extMoney)
				VALUES ('{$account}', {$warehouseItems} ,GETDATE(), 2, {$mmw['zen_for_acc']})");
			if ($mmw['enable_credits']) {
				/** @noinspection SqlResolve */
				mssql_query("INSERT INTO dbo.MEMB_CREDITS (memb___id, credits) VALUES ('{$account}', 0)");
			}
			echo $okey_start . mmw_lang_account_created . $okey_end;
		}
	}
	echo $rowbr;
}


if ($_GET['terms'] === 'agree') {
	$selectCountry = '<option></option>';
	foreach (country(null, true) as $id => $country) {
		$selected_country = ($id == $_POST['country'])
			? ' selected'
			: '';

		$selectCountry .= '<option value="' . $id . '"' . $selected_country . '>' . $country . '</option>';
	}

	$language = array(
		'account' => mmw_lang_account,
		'password' => mmw_lang_password,
		'repeat_password' => mmw_lang_repeat_password,
		'email_address' => mmw_lang_email_address,
		'secret_question' => mmw_lang_secret_question,
		'secret_answer' => mmw_lang_secret_answer,
		'full_name' => mmw_lang_full_name,
		'country' => mmw_lang_country,
		'gender' => mmw_lang_gender,
		'male' => mmw_lang_male,
		'female' => mmw_lang_female,
		'security_code' => mmw_lang_security_code,
		'renew' => mmw_lang_renew,
		'new_account' => mmw_lang_new_account,
	);
	$imageSourceRefresh = default_img('refresh.gif');

	echo <<<HTML
	<script>
		function check_register_form() {
			var errors = [];
			var list = [
				{key: 'account', message: 'Please enter Account.'},
				{key: 'password', message: 'Please enter Password.'},
				{key: 'repassword', message: 'Please enter Repeat password.'},
				{key: 'email', message: 'Please enter E-mail address.'},
				{key: 'question', message: 'Please enter Secret question.'},
				{key: 'answer', message: 'Please enter Secret answer.'},
				{key: 'country', message: 'Please select Country.'},
				{key: 'verifyinput', message: 'Please enter Verify input.'},
			];

			list.forEach(function (rule) {
				if (document.register_from[rule.key].value === '') {
					errors.push(rule.message);
				}
			});
			if (errors.length) {
				alert(errors.join('\\n'));
			}

			return !errors.length;
		}
	</script>

	<form action="" method="post" name="register_from">
		<table class="sort-table" style="width:300px;border:0;padding:0;margin:0 auto;">
			<tr>
				<td style="width:110px;text-align:right;">{$language['account']}</td>
				<td><input name="account" type="text" size="17" maxlength="10" value="{$_POST['account']}"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['password']}</td>
				<td><input name="password" type="password" size="17" maxlength="10"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['repeat_password']}</td>
				<td><input name="repassword" type="password" size="17" maxlength="10"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['email_address']}</td>
				<td><input name="email" type="text" size="17" maxlength="50" value="{$_POST['email']}"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['secret_question']}</td>
				<td><input name="question" type="text" size="17" maxlength="10" value="{$_POST['question']}"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['secret_answer']}</td>
				<td><input name="answer" type="text" size="17" maxlength="10" value="{$_POST['answer']}"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['full_name']}</td>
				<td><input name="fullname" type="text" size="17" maxlength="10" value="{$_POST['fullname']}"></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['country']}</td>
				<td><select name="country">{$selectCountry}</select></td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['gender']}</td>
				<td>
					<label><input name="gender" type="radio" value="male">{$language['male']}</label>
					&nbsp;
					<label><input name="gender" type="radio" value="female">{$language['female']}</label>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;">{$language['security_code']}</td>
				<td>
					<input name="verifyinput" type="text" size="6" maxlength="8">
					<img src="images/captcha.php" alt="captcha" id="secImg">
					<img src="{$imageSourceRefresh}" alt="renew" onclick="document.getElementById('secImg').src='images/captcha.php?refresh='+Math.random();" title="{$language['renew']}">
				</td>
			</tr>
			<tr>
				<td style="text-align:center;" colspan="2">
					<input type="submit" name="registration" value="{$language['new_account']}" onclick="return check_register_form();">
					<input type="reset" value="{$language['renew']}">
				</td>
			</tr>
		</table>
	</form>
HTML;
} else {
	$terms_file = is_file('lang/' . $_SESSION['language'] . '_terms.txt')
		? 'lang/' . $_SESSION['language'] . '_terms.txt'
		: 'lang/English_terms.txt';
	?>
	<form action="?op=register&terms=agree" method="post" name="terms">
		<div style="width:400px;margin:0 auto;text-align: center">
			<h3><?php echo mmw_lang_terms_of_agreement; ?></h3>
			<textarea name="terms" style="width:100%"
					  rows="20"><?php echo remove_utf8_bom(file_get_contents($terms_file)); ?></textarea>
			<?php echo $rowbr; ?>
			<input type="submit" value="<?php echo mmw_lang_i_agree; ?>">
			<input type="reset" value="<?php echo mmw_lang_i_dont; ?>" onclick="top.location='?op=info';">
		</div>
	</form>
	<?php
}
