<?if($_GET[op]!='user') {echo "$die_start Access Denied! $die_end";}

if(isset($_POST["newpassword"])) {require("includes/character.class.php");option::changepassword($login); echo $rowbr;}										
if(isset($_POST["profile"])) {require("includes/character.class.php");option::profile($login); echo $rowbr;}
if(isset($_POST["new_request"])) {require("includes/character.class.php");option::request($login); echo $rowbr;}

   $account = clean_var(stripslashes($login));
   $acc_info_reslut = mssql_query("Select mail_addr,memb_name,age,country,gender,avatar,hide_profile,y,msn,icq,skype,appl_days from MEMB_INFO where memb___id='$account'");
   $acc_info = mssql_fetch_row($acc_info_reslut);

   $timeinfo_reslut = mssql_query("select CONNECTTM,DISCONNECTTM,connectstat from MEMB_STAT where memb___id = '$account'");
   $timeinfo = mssql_fetch_row($timeinfo_reslut);

 // Referral
 if($mmw[switch_ref]==yes) {
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
		if($referral_row[1]==1) {$ref_status = mmw_lang_have_a_reset;} else {$ref_status = mmw_lang_have_not_a_reset;}
		$referral_list = $referral_list . "$rank. $referral_row[0] ($ref_status)<br>";
	}
   }
   else {
	$referral_list = mmw_lang_no_referral;
   }
   $referral_result_check = mssql_query("SELECT memb___id FROM MEMB_INFO WHERE ref_acc='$login' AND ref_check='1'");
   $referral_num_check = mssql_num_rows($referral_result_check);
 }
 // Online
   if($acc_info[6]==1) {$hide_profile = mmw_lang_yes;} else {$hide_profile = mmw_lang_no;}
   $country = country($acc_info[3]);

 // Offline
   if($acc_info[4]=='female') {$gender_sel[1]="selected";} else {$gender_sel[0]="selected";}
   if($acc_info[6]>=0) {$hide_profile_sel[$acc_info[6]]="selected";}
   for($i=0; $i<139; ++$i) {
	$country = country($i);
	if($i == $acc_info[3]){$selected_country="selected";} else{$selected_country="";}
	$select_country = $select_country . "<option value='$i' $selected_country>$country</option>";
   }  
?>
<form action="" method="post" name="change_profile">
  <table width="380" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right"><?echo mmw_lang_account;?>:</td>
      <td><b><?echo $login;?></b></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_email_address;?>:</td>
      <td><?echo $acc_info[0];?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_register_date;?>:</td>
      <td><?echo time_format($acc_info[11],"d M Y, H:i");?></td>
    </tr>
<?if($mmw[switch_ref]==yes){?>
    <tr>
      <td align="right"><?echo mmw_lang_about_referral;?>:</td>
      <td><?echo mmw_lang_one_referral_with_reset.' = '.zen_format($mmw[zen_for_ref]).' Zen';?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_referral_link;?>:</td>
      <td><?echo $mmw[serverwebsite];?>?ref=<?echo $login;?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_your_referrals;?>:</td>
      <td><a href="#" class="helpLink" onclick="showHelpTip(event,'<?echo $referral_list;?>',false); return false"><?echo mmw_lang_all_referrals.": $referral_num, ".mmw_lang_have_a_reset.": $referral_num_check";?></td>
    </tr>
<?}?>
<?if($timeinfo[2] == '1'){?>
    <tr>
      <td align="right"><?echo mmw_lang_last_login;?>:</td>
      <td align="left"><?echo time_format($timeinfo[0],"d M Y, H:i");?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_login_status;?>:</td>
      <td align="left"><span class="online"><?echo mmw_lang_online;?></span></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_time_in_playing;?>:</td>
      <td align="left"><span class="online"><?echo date_formats(time_format($timeinfo[0],"d.m.Y H:i"),time());?></span></td>
    </tr>
<?}elseif($timeinfo[2] == '0') {?>
    <tr>
      <td align="right"><?echo mmw_lang_last_login;?>:</td>
      <td align="left"><?echo time_format($timeinfo[0],"d M Y, H:i");?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_login_status;?>:</td>
      <td align="left"><span class="offline"><?echo mmw_lang_offline;?> [<?echo date_formats(time_format($timeinfo[0],"d.m.Y H:i"),time());?>]</span></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_last_play_time;?>:</td>
      <td align="left"><span class="offline"><?echo date_formats(time_format($timeinfo[0],"d.m.Y H:i"),strtotime(time_format($timeinfo[1],"d.m.Y H:i")));?></span></td>
    </tr>
<?}else{?>
    <tr>
      <td align="right"><?echo mmw_lang_last_login;?>:</td>
      <td align="left"><?echo mmw_lang_not_joined;?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_login_status;?>:</td>
      <td align="left"><?echo mmw_lang_not_joined;?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_last_play_time;?>:</td>
      <td align="left"><?echo mmw_lang_not_joined;?></td>
    </tr>
<?}?>
    <tr>
      <td align="right"><?echo mmw_lang_full_name;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[1];} else{?><input name='fullname' type='text' value='<?echo $acc_info[1];?>' size='12' maxlength='10'><?}?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_age;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[2];} else{?><input name='age' type='text' value='<?echo $acc_info[2];?>' size='2' maxlength='2'><?}?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_country;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo $country;} else{?><select name='country'><?echo $select_country;?></select><?}?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_gender;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo gender($acc_info[4]);} else{?><select name='gender'><option value='male'<?echo $gender_sel[0];?>><?echo mmw_lang_male;?></option><option value='female'<?echo $gender_sel[1];?>><?echo mmw_lang_female;?></option></select><?}?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_avatar_url;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[5];} else{?><input name='avatar' type='text' value='<?echo $acc_info[5];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_hide_profile;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo $hide_profile;} else{?><select name='hide_profile'><option value='0'<?echo $hide_profile_sel[0];?>><?echo mmw_lang_no;?></option><option value='1'<?echo $hide_profile_sel[1];?>><?echo mmw_lang_yes;?></option></select><?}?></td>
    </tr>
    <tr>
      <td align="right">Yahoo!:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[7];} else{?><input name='y' type='text' value='<?echo $acc_info[7];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">MSN:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[8];} else{?><input name='msn' type='text' value='<?echo $acc_info[8];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">ICQ:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[9];} else{?><input name='icq' type='text' value='<?echo $acc_info[9];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right">Skype:</td>
      <td><?if($timeinfo[2] == '1'){echo $acc_info[10];} else{?><input name='skype' type='text' value='<?echo $acc_info[10];?>' size='20' maxlength='100'><?}?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_profile;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo mmw_lang_cant_change_online;} else{?><input type='submit' name='Submit' value='<?echo mmw_lang_save_profile;?>'> <input name='profile' type='hidden' value='profile'> <input type='reset' name='Reset' value='<?echo mmw_lang_renew;?>'><?}?></td>
    </tr>
</table>
</form>

<?echo $rowbr;?>

<form action="" method="post" name="change_password">
  <table width="380" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right"><?echo mmw_lang_current_password;?>:</td>
      <td><input name='oldpassword' type='password' size='17' maxlength='10'></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_new_password;?>:</td>
      <td><input name='newpassword' type='password' size='17' maxlength='10'></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_retype_new_password;?>:</td>
      <td><input name='renewpassword' type='password' size='17' maxlength='10'></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_password;?>:</td>
      <td><?if($timeinfo[2] == '1'){echo mmw_lang_cant_change_online;} else{?><input type='submit' name='Submit' value='<?echo mmw_lang_change_password;?>'><?}?></td>
    </tr>
  </table>
</form>

<?echo $rowbr;?>

<form action="" method="post" name="new_request">
  <table width="380" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right"><?echo mmw_lang_to;?>:</td>
      <td><?echo $mmw[servername];?> Administrator</td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_title;?>:</td>
      <td><input name="subject" type="text" size="30" maxlength="30"></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_text;?>:</td>
      <td><textarea name="msg" cols="32" rows="8" onFocus="CheckLeng(this,'250')" onBlur="CheckLeng(this,'250')" onChange="CheckLeng(this,'250')" onKeyDown="CheckLeng(this,'250')" onKeyUp="CheckLeng(this,'250')"></textarea></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_message;?>:</td>
      <td><input type="submit" name="Submit" value="<?echo mmw_lang_send_message;?>"> <input name="new_request" type="hidden" value="new_request"> <input type="reset" name="Reset" value="<?echo mmw_lang_renew;?>"></td>
    </tr>
  </table>
</form>