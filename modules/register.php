<?PHP
if(isset($_POST["registration"])){include("includes/character.class.php");option::register(); echo $rowbr;}

for($i=0; $i<139; ++$i) {
	$country = country($i);
	if($i == $_POST[country]){$selected_country=" selected";} else{$selected_country="";}
	$select_country = $select_country . "<option value='$i'$selected_country>$country</option>";
 }
?>
<script language="Javascript" type="text/javascript">
function check_register_form()
{
if ( document.register_from.account.value == "")
{
alert("Please enter Account.");
return false;
}
if ( document.register_from.password.value == "")
{
alert("Please enter Password.");
return false;
}
if ( document.register_from.repassword.value == "")
{
alert("Please enter Repeat password.");
return false;
}
if ( document.register_from.email.value == "")
{
alert("Please enter E-mail address.");
return false;
}
if ( document.register_from.question.value == "")
{
alert("Please enter Secret question.");
return false;
}
if ( document.register_from.answer.value == "")
{
alert("Please enter Secret answer.");
return false;
}
if ( document.register_from.country.value == "null")
{
alert("Please select Country.");
return false;
}
if ( document.register_from.verifyinput.value == "")
{
alert("Please enter Verify input.");
return false;
}
//return false;
document.register_from.submit();
return false;
}
</script>

<?if($_GET['terms'] == 'agree') {
echo '<form action="" method="post" name="register_from">
                    <table align="center" width="300" border="0" class="sort-table" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="110" align="right">'.mmw_lang_account.'</td>
                        <td><input name="account" type="text" size="17" maxlength="10" value="'.$_POST[account].'"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_password.'</td>
                        <td><input name="password" type="password" size="17" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_repeat_password.'</td>
                        <td><input name="repassword" type="password" size="17" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_email_address.'</td>
                        <td><input name="email" type="text" size="17" maxlength="50" value="'.$_POST[email].'"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_secret_question.'</td>
                        <td><input name="question" type="text" size="17" maxlength="10" value="'.$_POST[question].'"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_secret_answer.'</td>
                        <td><input name="answer" type="text" size="17" maxlength="10" value="'.$_POST[answer].'"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_full_name.'</td>
                        <td><input name="fullname" type="text" size="17" maxlength="10" value="'.$_POST[fullname].'"></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_country.'</td>
                        <td><select name="country">'.$select_country.'</select></td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_gender.'</td>
                        <td><input name="gender" type="radio" value="male" checked> '.mmw_lang_male.' &nbsp; <input name="gender" type="radio" value="female"> '.mmw_lang_female.'</td>
                      </tr>
                      <tr>
                        <td align="right">'.mmw_lang_security_code.'</td>
                        <td><input name="verifyinput" type="text" size="6" maxlength="8"> <img src="image_verify.php" align="center" id="secImg"> <img src="images/refresh.gif" align="center" onclick="document.getElementById(\'secImg\').src=\'image_verify.php?refresh=\'+Math.random();" title="'.mmw_lang_renew.'"></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center"><input type="submit" name="Submit" value="'.mmw_lang_new_account.'" onclick="return check_register_form()"> <input name="registration" type="hidden" value="registration"> <input type="reset" value="'.mmw_lang_renew.'"></td>
                      </tr>
                    </table>
                  </form>';
}else{?>
<form action="?op=register&terms=agree" method="post" name="terms">
<table width="200" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr>
    <td align="center"><h2><?echo mmw_lang_terms_of_agreement;?></h2></td>
  </tr>
  <tr>
    <td align="center">
	<textarea name="terms" cols="60" rows="20" readonly="readonly"><?include("modules/terms.txt");?></textarea>
	<?echo $rowbr;?>
	<input type="submit" value="<?echo mmw_lang_i_agree;?>"> <input type="reset" value="<?echo mmw_lang_i_dont;?>" onclick="top.location='?op=info';">
    </td>
  </tr>
</table>
</form>
<?}?>