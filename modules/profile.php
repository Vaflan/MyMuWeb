<?PHP
$account_get = clean_var(stripslashes($_GET[profile]));

$profile_sql = mssql_query("Select country,gender,age,avatar,hide_profile,y,msn,icq,skype,memb_name,appl_days,admin from memb_info where memb___id='$account_get'");
$profile_info = mssql_fetch_row($profile_sql);
$profile_info_check = mssql_num_rows($profile_sql);
if($profile_info[2] == '' || $profile_info[2] == ' ') {$profile_info[2] = "Not Set";}
if($profile_info[5] == '' || $profile_info[5] == ' ') {$profile_info[5] = "Not Set";}
if($profile_info[6] == '' || $profile_info[6] == ' ') {$profile_info[6] = "Not Set";}
if($profile_info[7] == '' || $profile_info[7] == ' ') {$profile_info[7] = "Not Set";}
if($profile_info[8] == '' || $profile_info[8] == ' ') {$profile_info[8] = "Not Set";}
if($profile_info[3] == NULL || $profile_info[3] == " ") {$profile_info[3] = "images/no_avatar.jpg";}
if($profile_info[1] == 'Male' || $profile_info[1] == 'male') {$profile_info[1] = "Male <img src='images/male.gif'>";}
elseif($profile_info[1] == 'Female' || $profile_info[1] == 'female') {$profile_info[1] = "Female <img src='images/female.gif'>";}
?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='230'> 
	<tr>
          <td width="100">Profile:</td>
          <td><?echo $account_get;?></td>
	</tr>
	<tr>
          <td>Full Name:</td>
          <td><?echo $profile_info[9];?></td>
	</tr>
	<tr>
          <td>Country:</td>
          <td><?echo country($profile_info[0]);?></td>
	</tr>
	<tr>
          <td>Age:</td>
          <td><?echo $profile_info[2];?></td>
	</tr>
	<tr>
          <td>Gender:</td>
          <td><?echo $profile_info[1];?></td>
	</tr>
	<tr>
          <td>Level:</td>
          <td><?echo admin_level($profile_info[11]);?></td>
	</tr>
	<tr>
          <td>Reg Date:</td>
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
          <td valign="top">Avatar:</td>
          <td><img  width="110" src="<?echo $profile_info[3];?>"></td>
	</tr>
</table>