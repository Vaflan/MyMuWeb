<?PHP
$account_get = clean_var(stripslashes($_GET[profile]));

$profile_sql = mssql_query("Select country,gender,age,avatar,hide_profile,y,msn,icq,skype,memb_name,appl_days,admin from memb_info where memb___id='$account_get'");
$profile_info = mssql_fetch_row($profile_sql);
$profile_info_check = mssql_num_rows($profile_sql);
if($profile_info[2] == '' || $profile_info[2] == ' ') {$profile_info[2] = mmw_lang_no_set;}
if($profile_info[5] == '' || $profile_info[5] == ' ') {$profile_info[5] = mmw_lang_no_set;}
if($profile_info[6] == '' || $profile_info[6] == ' ') {$profile_info[6] = mmw_lang_no_set;}
if($profile_info[7] == '' || $profile_info[7] == ' ') {$profile_info[7] = mmw_lang_no_set;}
if($profile_info[8] == '' || $profile_info[8] == ' ') {$profile_info[8] = mmw_lang_no_set;}
if($profile_info[3] == NULL || $profile_info[3] == " ") {$profile_info[3] = "images/no_avatar.jpg";}
?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='240'> 
	<tr>
          <td width="100"><?echo mmw_lang_account;?>:</td>
          <td><?echo $account_get;?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_full_name;?>:</td>
          <td><?echo $profile_info[9];?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_country;?>:</td>
          <td><?echo country($profile_info[0]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_age;?>:</td>
          <td><?echo $profile_info[2];?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_gender;?>:</td>
          <td><?echo gender($profile_info[1]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_level;?>:</td>
          <td><?echo admin_level($profile_info[11]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_reg_date;?>:</td>
          <td><?echo time_format($profile_info[10],"d M Y, H:i");?></td>
	</tr>
	<tr>
          <td><img src="images/im/im_yahoo.gif"> Yahoo!:</td>
          <td><?echo $profile_info[5];?></td>
	</tr>
	<tr>
          <td><img src="images/im/im_msn.gif"> MSN:</td>
          <td><?echo $profile_info[6];?></td>
	</tr>
	<tr>
          <td><img src="images/im/im_icq.gif"> ICQ:</td>
          <td><?echo $profile_info[7];?></td>
	</tr>
	<tr>
          <td><img src="images/im/im_skype.gif"> Skype:</td>
          <td><?echo $profile_info[8];?></td>
	</tr>
	<tr>
          <td valign="top"><?echo mmw_lang_avatar;?>:</td>
          <td><img  width="110" src="<?echo $profile_info[3];?>"></td>
	</tr>
</table>