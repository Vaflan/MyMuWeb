<?PHP
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
if ( document.register_from.verifyinput2.value == "")
{
alert("Please enter Verify input.");
return false;
}
//return false;
document.register_from.submit();
}
</script>

<?if(isset($_POST["registration"])){include("includes/character.class.php");option::register(); echo $rowbr;}?>

<?if($_GET['terms'] == 'agree') {
echo '<form action="" method="post" name="register_from" id="register_from">
                    <table align="center"  width="293" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td width="106" align="right">Account ID</td>
                        <td colspan="4"><input name="account" type="text" class="post" id="account" size="17" maxlength="10" value="'.$_POST[account].'"></td>
                      </tr>
                      <tr>
                        <td align="right">Password</td>
                        <td colspan="4"><input name="password" type="password" class="post" id="password" size="17" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td align="right">Repeat Password</td>
                        <td colspan="4"><input name="repassword" type="password" class="post" id="repassword" size="17" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td align="right">E-Mail Address</td>
                        <td colspan="4"><input name="email" type="text" class="post" id="email" size="17" maxlength="50" value="'.$_POST[email].'"></td>
                      </tr>
                      <tr>
                        <td align="right">Secret Question</td>
                        <td colspan="4"><input name="question" type="text" class="post" id="question" size="17" maxlength="10" value="'.$_POST[question].'"></td>
                      </tr>
                      <tr>
                        <td align="right">Secret Answer</td>
                        <td colspan="4"><input name="answer" type="text" class="post" id="answer" size="17" maxlength="10" value="'.$_POST[answer].'"></td>
                      </tr>
                      <tr>
                        <td align="right">Full Name</td>
                        <td colspan="4"><input name="fullname" type="text" id="fullname" size="17" maxlength="12" value="'.$_POST[fullname].'"></td>
                      </tr>
                      <tr>
                        <td align="right">Country</td>
                        <td colspan="4"><select name="country" id="country">'.$select_country.'</select></td>
                      </tr>
                      <tr>
                        <td align="right">Gender</td>
                        <td width="20"><input name="gender" type="radio" value="male" checked></td>
                        <td width="35" valign="top">Male</td>
                        <td width="20" valign="top"><input name="gender" type="radio" value="female"></td>
                        <td width="80" valign="top">Female</td>
                      </tr>
                      <tr>
                        <td align="right">Verify Code</td>
                        <td colspan="4"><img src="image_verify.php" alt="Image Verify"></td>
                      </tr>
                      <tr>
                        <td align="right">Verify Input</td>
                        <td colspan="4"><input name="verifyinput2" type="text" class="post" id="verifyinput2" size="8" maxlength="10"></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="center"> <input type="submit" name="Submit" value="New Account" onclick="return check_register_form()"> <input name="registration" type="hidden" id="registration" value="registration"> <input type="reset" name="Reset" value="Reset"></td>
                      </tr>
                    </table>
                  </form>';
}else{
?>
<form action="?op=register&terms=agree" method="post" name="terms" id="terms">
<table width="200" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr>
    <td align="center"><h2>Terms of Agreement</h2></td>
  </tr>
  <tr>
    <td align="center">
	<textarea name="terms" cols="60" rows="20" readonly="readonly" id="terms"><?include("modules/terms.txt");?></textarea>
	<?echo $rowbr;?>
	<input type="submit" value="I agree!"> <input type="reset" value="I don't!" onclick="top.location='?op=news';">
    </td>
  </tr>
</table>
</form>
<?}?>