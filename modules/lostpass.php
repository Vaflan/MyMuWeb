<?
$step = stripslashes($_GET["step"]);

if($_GET["step"]=="1")
 {
	$login = clean_var(stripslashes($_POST['username']));
	$email = clean_var(stripslashes($_POST['email']));	
	$username_check = mssql_query("SELECT memb___id,fpas_ques FROM MEMB_INFO WHERE mail_addr='$email' and memb___id='$login'"); 
	$username_check = mssql_fetch_row($username_check);
	$quest = $username_check[1];
	if($username_check[0]!="" && $login==$username_check[0]){$step = "1";}
	else{$step = ""; $error = "login";}
 }
elseif($_GET["step"]=="2")
 {
	$login = clean_var(stripslashes($_POST['username']));
	$email = clean_var(stripslashes($_POST['email']));
	$quest = clean_var(stripslashes($_POST['squestion']));
	$answer = clean_var(stripslashes($_POST['sanswer']));	
	$username_check = mssql_query("SELECT fpas_answ FROM MEMB_INFO WHERE fpas_ques='$quest' and memb___id='$login'"); 
	$username_check = mssql_fetch_row($username_check);
	if($username_check[0]==$answer){$step = "2";}
	else{$step = ""; $error = "answer";}
 }
?>

<script language="Javascript">
function lostpassword_form()
{
if ( document.lostpass.username.value == "")
{
alert("Please Enter Your Username.");
return false;
}
if ( document.lostpass.email.value == "")
{
alert("Please Enter Your E-Mail Address.");
return false;
}
//return false;
document.search_.submit();
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="bgcolor" align="center">
        <fieldset><legend>Lost Password</legend>

	<?if($step == ""){?>
		<form action="?op=lostpass&step=1" method="post" name="lostpass" id="lostpass">
		<?if($error=="login"){echo "$die_start Login or E-Mail Address You Entered Is Incorrect! $die_end";}?>
		<?if($error=="answer"){echo "$die_start Secret Answer Is Incorrect! $die_end";}?>
		<table width="246" border="0" cellspacing="4" cellpadding="0">
                      <tr>
                        <td width="102"><div align="right" class="normal_text_white">Login</div></td>
                        <td width="144"><div align="left"><input name="username" type="text" id="username" maxlength="10"></div></td>
                      </tr>
                      <tr>
                        <td><div align="right" class="normal_text_white">E-Mail Address</div></td>
                        <td><div align="left"><input name="email" type="text" id="email" maxlength="50"></div></td>
                      </tr>
                    </table>
                    <table width="200" border="0" cellspacing="4" cellpadding="0">
                      <tr>
                        <td width="114"><div align="right"><input type="submit" name="Submit" value="Find Password" onClick="return lostpassword_form()" class="button"></div></td>
                        <td width="74"><div align="left"><input type="reset" name="Reset" value="Reset" class="button"></div></td>
                      </tr>
		</table>
		</form>
	<?}elseif($step == "1"){?>
		<form action="?op=lostpass&step=2" method="post" name="step2" id="step2">
		<input name="username" type="hidden" id="username" value="<?echo $_POST['username'];?>">
		<input name="email" type="hidden" id="email" value="<?echo $_POST['email'];?>">
		<input name="squestion" type="hidden" id="squestion" value="<?echo $quest;?>">
		<table width="246" border="0" cellspacing="4" cellpadding="0">
                      <tr>
                        <td><div align="right" class="normal_text_white">Secret Question</div></td>
                        <td><div align="left"><b><?echo $quest;?></b></div></td>
                      </tr>
                      <tr>
                        <td><div align="right" class="normal_text_white">Secret Answer</div></td>
                        <td><div align="left"><input name="sanswer" type="text" id="sanswer" size="15" maxlength="10"></div></td>
                      </tr>
                    </table>
                    <table width="200" border="0" cellspacing="4" cellpadding="0">
                      <tr>
                        <td width="114"><div align="right"><input type="submit" name="Submit" value="Find Password" onClick="return lostpassword_form()" class="button"></div></td>
                        <td width="74"><div align="left"><input type="reset" name="Reset" value="Reset" class="button"></div></td>
                      </tr>
		</table>
		</form>
	<?}elseif($step == "2"){?>
		<?require("includes/character.class.php");option::lostpassword();?>
	<?}else{echo "Error! Death Hacker!";}?>
        </fieldset>
      </td>
    </tr>
</table>