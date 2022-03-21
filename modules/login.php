<?if($_GET[login]=='false'){echo "$die_start Username Or Password Is Incorrect! $die_end $rowbr";}?>

<form action='' method='post' name='login_account' id='login_account'>
  <table width='160' border='0' align="center" cellpadding='0' cellspacing='0'>
    <tr>
      <td width='90' height='24'>Username</td>
      <td><input name='login' type='text' class='login_field' id='login' title='Username' size='15' maxlength='10'></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name='pass' type='password' class='login_field' id='pass' title='Password' size='15' maxlength='10'></td>
    </tr>
    <tr>
      <td colspan="2" align="center" height='24'><input name='Submit' type='submit' class='button' value='Login' title='Login'> <input name='account_login' type='hidden' id='account_login' value='account_login'></td>
    </tr>
    <tr>
      <td colspan="2" align="center" height='24'><a href="?op=register">New Account</a> :: <a href='?op=lostpass'>Lost Password </a></td>
    </tr>
  </table>
</form>