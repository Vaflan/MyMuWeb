<?php
/*
	Lost Password v1.30407
	For MyMuWeb By Vaflan
*/

$step = intval($_GET['step']);
if($_GET['step'] == 1) {
	$login = clean_var($_POST['username']);
	$email = clean_var($_POST['email']);
	echo $_POST['username'].' - '.$login;
	$username_check = mssql_fetch_row(mssql_query("SELECT memb___id, fpas_ques FROM MEMB_INFO WHERE mail_addr='".$email."' and memb___id='".$login."'"));
	if(!empty($username_check[0]) && $login==$username_check[0]) {
		$step = 1;
		$quest = $username_check[1];
	}
	else {
		$step = NULL;
		echo $die_start . mmw_lang_account_or_email_address_is_incorrect . $die_end . $rowbr;
	}
}
elseif($_GET['step'] == 2) {
	$login = clean_var($_POST['username']);
	$email = clean_var($_POST['email']);
	$answer = clean_var($_POST['answer']);
	$username_check = mssql_fetch_row(mssql_query("SELECT fpas_answ FROM MEMB_INFO WHERE mail_addr='".$email."' and memb___id='".$login."'"));
	if($username_check[0] == $answer) {
		$step = 2;
	}
	else {
		$step = NULL;
		echo $die_start . mmw_lang_secret_answer_is_incorrect . $die_end . $rowbr;
	}
}


if($step < 1) {
?>
	<form action="?op=lostpass&step=1" method="post" name="lostpass">
		<table width="250" border="0" cellspacing="0" cellpadding="0" class="sort-table" align="center">
			<tr>
				<td width="100" align="right"><?echo mmw_lang_account;?></td>
				<td><input name="username" type="text" maxlength="10"></td>
			</tr>
			<tr>
				<td align="right"><?echo mmw_lang_email_address;?></td>
				<td><input name="email" type="text" maxlength="50"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="Submit" value="<?echo mmw_lang_find_password;?>"> <input type="reset" value="<?echo mmw_lang_renew;?>"></td>
			</tr>
		</table>
	</form>
<?php
}
elseif($step < 2) {
?>
	<form action="?op=lostpass&step=2" method="post" name="step2">
		<input name="username" type="hidden" value="<?echo $login;?>">
		<input name="email" type="hidden" value="<?echo $email;?>">
		<table width="250" border="0" cellspacing="0" cellpadding="0" class="sort-table" align="center">
			<tr>
				<td width="100" align="right"><?echo mmw_lang_secret_question;?></td>
				<td><b><?echo $quest;?></b></td>
			</tr>
			<tr>
				<td align="right"><?echo mmw_lang_secret_answer;?></td>
				<td><input name="answer" type="text" size="15" maxlength="10"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="Submit" value="<?echo mmw_lang_find_password;?>"> <input type="reset" value="<?echo mmw_lang_renew;?>"></td>
			</tr>
		</table>
	</form>
<?php
}
elseif($step < 3) {
	$login = clean_var($_POST['username']);
	$email = clean_var($_POST['email']);

	$result = mssql_fetch_row(mssql_query("SELECT ".(($mmw['md5']=='yes')?'memb__pwd2':'memb__pwd')." FROM MEMB_INFO WHERE memb___id='".$login."' and mail_addr='".$email."'")); 

	if(empty($result)) {
		echo $die_start . 'Fatal error!' . $die_end; 
	}
	else {
		echo $okey_start . mmw_lang_your_password . ' '. $result[0] . $okey_end;
	}
}
else {
	echo $die_start.'What You Doing? d(O.o)b'.$die_end.$rowbr;
}
?>