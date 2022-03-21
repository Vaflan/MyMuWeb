<?if($_GET[op]!='user') {echo "$die_start Access Denied! $die_end";}

if(isset($_POST["newpassword"])) {require("includes/character.class.php");option::changepassword($login); echo $divbr;}										
if(isset($_POST["profile"])) {require("includes/character.class.php");option::profile($login); echo $divbr;}
if(isset($_POST["new_request"])) {require("includes/character.class.php");option::request($login); echo $divbr;}

   $account = clean_var(stripslashes($login));
   $acc_info_reslut = mssql_query("Select mail_addr,memb_name,age,country,gender,avatar,hide_profile,y,msn,icq,skype,appl_days from MEMB_INFO where memb___id='$account'");
   $acc_info = mssql_fetch_row($acc_info_reslut);

   $timeinfo_reslut = mssql_query("select CONNECTTM,DISCONNECTTM,connectstat from MEMB_STAT where memb___id = '$account'");
   $timeinfo = mssql_fetch_row($timeinfo_reslut);

   $referral_result = mssql_query("SELECT memb___id,ref_check FROM MEMB_INFO WHERE ref_acc='$login'");
   $referral_num = mssql_num_rows($referral_result);
   if($referral_num>0) {
	for($i=0; $i < $referral_num; ++$i) {
		$rank = $i + 1;
		$referral_row = mssql_fetch_row($referral_result);
		if($referral_row[1]<=0) {
			$char_ref_sql = mssql_query("Select name,Reset From Character WHERE AccountID='$referral_row[0]'");
			for($c=0; $c < mssql_num_rows($char_ref_sql); ++$c) {
				$char_ref_row = mssql_fetch_row($char_ref_sql);
				if($char_ref_row[1]>0 && $referral_row[1]<=0) {
				mssql_query("UPDATE MEMB_INFO SET [ref_check]='1' WHERE memb___id='$referral_row[0]'");
				$referral_row[1] = 1;
				$wh_resoult = mssql_query("Select AccountID,extMoney From warehouse WHERE AccountID = '$login'");
				$wh_row = mssql_fetch_row($wh_resoult); $wh_updated = $wh_row[1] + $mmw[zen_for_ref];
				mssql_query("UPDATE warehouse SET [extMoney]='$wh_updated' WHERE AccountID = '$login'");
				writelog("referral.php","Account <b>$login</b> Has Been <font color=#FF0000>GET</font> Zen: $mmw[zen_for_ref]|For Acc: $referral_row[0]|For Char: $char_ref_row[0]");
				}
			}
		}
		if($referral_row[1]==1) {$ref_status="Have a Reset";} else {$ref_status="Have not a Reset";}
		$referral_list = $referral_list . "$rank. $referral_row[0] ($ref_status)<br>";
	}
   }
   else {
	$referral_list = "No Referral";
   }
   $referral_result_check = mssql_query("SELECT memb___id FROM MEMB_INFO WHERE ref_acc='$login' AND ref_check='1'");
   $referral_num_check = mssql_num_rows($referral_result_check);

 // Online
   if($acc_info[4]!='') {$gender_img=" <img src='images/$acc_info[4].gif'>";}
   if($acc_info[6]==1) {$hide_profile="Yes";} else {$hide_profile="No";}
   $country = country($acc_info[3]);

 // Offline
   if($acc_info[4]=='Female') {$gender_sel[1]="selected";} else {$gender_sel[0]="selected";}
   if($acc_info[6]>=0) {$hide_profile_sel[$acc_info[6]]="selected";}
   for($i=0; $i<139; ++$i) {
	$country = country($i);
	if($i == $acc_info[3]){$selected_country="selected";} else{$selected_country="";}
	$select_country = $select_country . "<option value='$i' $selected_country>$country</option>";
   }  
?>
<form action="" method="post" name="change_profile" id="change_profile">
  <table width="300" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="78" align="right">Account ID:</td>
      <td><b><?echo $login;?></b></td>
    </tr>
    <tr>
      <td align="right">E-Mail:</td>
      <td><?echo $acc_info[0];?></td>
    </tr>
    <tr>
      <td align="right">Reg Date:</td>
      <td><?echo time_format($acc_info[11],"d M Y, H:i");?></td>
    </tr>
    <tr>
      <td align="right">Referral:</td>
      <td>1 Referral With Reset = <?echo substr($mmw[zen_for_ref], 0, -6)."kk";?> Zen</td>
    </tr>
    <tr>
      <td align="right">Referral Link:</td>
      <td>http://redangel.put.lv/mu/?ref=<?echo $login;?></td>
    </tr>
    <tr>
      <td align="right">Your Referrals:</td>
      <td><a href="#" class="helpLink" onclick="showHelpTip(event,'<?echo $referral_list;?>',false); return false">All: <?echo $referral_num;?>, Have a Reset: <?echo $referral_num_check;?></td>
    </tr>
<?if($timeinfo[2] == '1'){?>
    <tr>
      <td align="right">Last Login:</td>
      <td align="left"><?echo time_format($timeinfo[0],"d M Y, H:i");?></td>
    </tr>
    <tr>
      <td align="right">Login Status:</td>
      <td align="left"><span class="online">Online</span></td>
    </tr>
    <tr>
      <td align="right">Time in Playing:</td>
      <td align="left"><span class="online"><?echo date_formats(time_format($timeinfo[0],"d.m.Y H:i"),time());?></span></td>
    </tr>
<?}elseif($timeinfo[2] == '0') {?>
    <tr>
      <td align="right">Last Login:</td>
      <td align="left"><?echo time_format($timeinfo[0],"d M Y, H:i");?></td>
    </tr>
    <tr>
      <td align="right">Login Status:</td>
      <td align="left"><span class="offline">Offline [<?echo date_formats(time_format($timeinfo[0],"d.m.Y H:i"),time());?>]</span></td>
    </tr>
    <tr>
      <td align="right">Last Play Time:</td>
      <td align="left"><span class="offline"><?echo date_formats(time_format($timeinfo[0],"d.m.Y H:i"),strtotime(time_format($timeinfo[1],"d.m.Y H:i")));?></span></td>
    </tr>
<?}else{?>
    <tr>
      <td align="right">Last Login:</td>
      <td align="left">Not Joined</td>
    </tr>
    <tr>
      <td align="right">Login Status:</td>
      <td align="left">Not Joined</td>
    </tr>
    <tr>
      <td align="right">Last Play Time:</td>
      <td align="left">Not Joined</td>
    </tr>
<?}?>
    <tr>
      <td align="right">Full Name:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[1];} else{?><input name='fullname' type='text' id='fullname' value='<?echo $acc_info[1];?>' size='12' maxlength='12'><?}?></td>
    </tr>
    <tr>
      <td align="right">Age:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[2];} else{?><input name='age' type='text' id='age' value='<?echo $acc_info[2];?>' size='2' maxlength='2'><?}?></td>
    </tr>
    <tr>
      <td align="right">Country:</td>
      <td><?if($timeinfo[2] == '1'){echo $country;} else{?><select name='country' id='country'><?echo $select_country;?></select><?}?></td>
    </tr>
    <tr>
      <td align="right">Gender:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[4].$gender_img;} else{?><select name='gender' id='gender'><option value='Male'<?echo $gender_sel[0];?>>Male</option><option value='Female'<?echo $gender_sel[1];?>>Female</option></select><?}?></td>
    </tr>
    <tr>
      <td align="right">Avatar url:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[5];} else{?><input name='avatar' type='text' id='avatar' value='<?echo $acc_info[5];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">Hide Profile:</td>
      <td><?if($timeinfo[2] == '1'){echo $hide_profile;} else{?><select name='hide_profile' id='hide_profile'><option value='0'<?echo $hide_profile_sel[0];?>>No</option><option value='1'<?echo $hide_profile_sel[1];?>>Yes</option></select><?}?></td>
    </tr>
    <tr>
      <td align="right">Yahoo!:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[7];} else{?><input name='y' type='text' id='y' value='<?echo $acc_info[7];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">MSN:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[8];} else{?><input name='msn' type='text' id='msn' value='<?echo $acc_info[8];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">ICQ Number:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[9];} else{?><input name='icq' type='text' id='icq' value='<?echo $acc_info[9];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">Skype Name:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[10];} else{?><input name='skype' type='text' id='skype' value='<?echo $acc_info[10];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">Profile:</td>
      <td><?if($timeinfo[2] == '1'){?>You Want Change? Must Be Logged Off!<?} else{?><input type='submit' name='Submit' value='Save Profile'> <input name='profile' type='hidden' id='profile' value='profile'> <input type='reset' name='Reset' value='Reset'><?}?></td>
    </tr>
</table>
</form>

<div class="brdiv"> &nbsp; </div>

<form action="" method="post" name="change_password" id="change_password">
  <table width="300" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="120" align="right">Curent Password:</td>
      <td><input name='oldpassword' type='password' id='oldpassword' size='17' maxlength='10'></td>
    </tr>
    <tr>
      <td align="right">New Password:</td>
      <td><input name='newpassword' type='password' id='newpassword' size='17' maxlength='10'></td>
    </tr>
    <tr>
      <td align="right">Retype New Password:</td>
      <td><input name='renewpassword' type='password' id='renewpassword' size='17' maxlength='10'></td>
    </tr>
    <tr>
      <td align="right">Password:</td>
      <td><?if($timeinfo[2] == '1'){?>Must Be Logged Off!<?} else{?><input type='submit' name='Submit' value='Change Password' onclick='return check_password_form()'><?}?></td>
    </tr>
  </table>
</form>

<div class="brdiv"> &nbsp; </div>

<form action="" method="post" name="new_request" id="new_request">
  <table width="300" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" width="30">To:</td>
      <td><?echo $mmw[servername];?> Administrator</td>
    </tr>
    <tr>
      <td align="right">Title:</td>
      <td><input name="subject" type="text" id="subject" size="30" maxlength="30"></td>
    </tr>
    <tr>
      <td align="right">Text:</td>
      <td><textarea name="msg" cols="40" rows="10" id="msg" onFocus="CheckLeng(this,'250')" onBlur="CheckLeng(this,'250')" onChange="CheckLeng(this,'250')" onKeyDown="CheckLeng(this,'250')" onKeyUp="CheckLeng(this,'250')"></textarea></td>
    </tr>
    <tr>
      <td align="right">Message:</td>
      <td><input type="submit" name="Submit" value="Send"> <input name="new_request" type="hidden" id="new_request" value="new_request"> <input type="reset" name="Reset" value="Reset"></td>
    </tr>
  </table>
</form>