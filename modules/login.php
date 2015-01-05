<?PHP
if($_GET[login]=='false'){echo $die_start . mmw_lang_acc_pass_incorrect . $die_end . $rowbr;}
?>

<form action='' method='post' name='login_account'>
  <table width='160' border='0' align="center" cellpadding='0' cellspacing='0'>
    <tr>
      <td width='90' height='24'><?echo mmw_lang_account;?></td>
      <td><input name='login' type='text' title='<?echo mmw_lang_account;?>' size='15' maxlength='10'></td>
    </tr>
    <tr>
      <td><?echo mmw_lang_password;?></td>
      <td><input name='pass' type='password' title='<?echo mmw_lang_password;?>' size='15' maxlength='10'></td>
    </tr>
    <tr>
      <td colspan="2" align="center" height='24'><input name='Submit' type='submit' value='<?echo mmw_lang_login;?>' title='<?echo mmw_lang_login;?>'> <input name='account_login' type='hidden' value='account_login'></td>
    </tr>
  </table>
</form>

<center>
<a href="?op=register"><?echo mmw_lang_new_account;?></a> :: <a href='?op=lostpass'><?echo mmw_lang_lost_pass;?></a>
</center>