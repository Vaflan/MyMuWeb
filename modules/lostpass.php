<?PHP
// Lost Password
// For MyMuWeb
// By Vaflan
// System: 1.2

$step = clean_var(stripslashes($_GET["step"]));

if($_GET["step"]=="1")
 {
	$login = clean_var(stripslashes($_POST['username']));
	$email = clean_var(stripslashes($_POST['email']));	
	$username_check = mssql_query("SELECT memb___id,fpas_ques FROM MEMB_INFO WHERE mail_addr='$email' and memb___id='$login'"); 
	$username_check = mssql_fetch_row($username_check);
	$quest = $username_check[1];
	if($username_check[0]!="" && $login==$username_check[0]) {$step = "1";}
	else {
		$step = "";
		echo $die_start . mmw_lang_account_or_email_address_is_incorrect . $die_end . $rowbr;
	}
 }
elseif($_GET["step"]=="2")
 {
	$login = clean_var(stripslashes($_POST['username']));
	$email = clean_var(stripslashes($_POST['email']));
	$quest = clean_var(stripslashes($_POST['quest']));
	$answer = clean_var(stripslashes($_POST['answer']));	
	$username_check = mssql_query("SELECT fpas_answ FROM MEMB_INFO WHERE fpas_ques='$quest' and memb___id='$login'"); 
	$username_check = mssql_fetch_row($username_check);
	if($username_check[0]==$answer) {$step = "2";}
	else {
		$step = "";
		echo $die_start . mmw_lang_secret_answer_is_incorrect . $die_end . $rowbr;
	}
 }
?>

<?if($step == "") {?>
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
<?}elseif($step == "1") {?>
		<form action="?op=lostpass&step=2" method="post" name="step2">
		<input name="username" type="hidden" value="<?echo $login;?>">
		<input name="email" type="hidden" value="<?echo $email;?>">
		<input name="quest" type="hidden" value="<?echo $quest;?>">
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
<?
}
elseif($step == "2") {
require("includes/character.class.php");option::lostpassword();
}
else {
echo "$die_start What You Doing? d(O.o)b $die_end $rowbr";
}
?>