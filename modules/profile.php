<?PHP
// Profile for MMW
// By Vaflan

$account_get = clean_var($_GET[profile]);
$profile_sql = mssql_query("Select country,gender,age,avatar,hide_profile,y,msn,icq,skype,memb_name,appl_days,mmw_status from memb_info where memb___id='$account_get'");
$profile_info = mssql_fetch_row($profile_sql);
if(mssql_num_rows($profile_sql) < 1) {echo "$die_start Profile Dosn't Exist $die_end";}
elseif($profile_info[4] == 0 || $mmw[status_rules][$_SESSION[mmw_status]][gm_option] == 1) {
 if(empty($profile_info[2]) || $profile_info[2] == ' ') {$profile_info[2] = mmw_lang_no_set;}
 if(empty($profile_info[5]) || $profile_info[5] == ' ') {$profile_info[5] = mmw_lang_no_set;}
 if(empty($profile_info[6]) || $profile_info[6] == ' ') {$profile_info[6] = mmw_lang_no_set;}
 if(empty($profile_info[7]) || $profile_info[7] == ' ') {$profile_info[7] = mmw_lang_no_set;}
 if(empty($profile_info[8]) || $profile_info[8] == ' ') {$profile_info[8] = mmw_lang_no_set;}
 if(empty($profile_info[3]) || $profile_info[3] == ' ') {$profile_info[3] = default_img('no_avatar.jpg');}
?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='300'> 
	<tr>
          <td width="120"><?echo mmw_lang_account;?>:</td>
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
          <td><?echo $mmw[status_rules][$profile_info[11]][name];?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_register_date;?>:</td>
          <td><?echo time_format($profile_info[10],"d M Y, H:i");?></td>
	</tr>
	<tr>
          <td><img src="<?echo default_img('im/im_yahoo.gif');?>"> Yahoo!:</td>
          <td><?echo $profile_info[5];?></td>
	</tr>
	<tr>
          <td><img src="<?echo default_img('im/im_msn.gif');?>"> MSN:</td>
          <td><?echo $profile_info[6];?></td>
	</tr>
	<tr>
          <td><img src="<?echo default_img('im/im_icq.gif');?>"> ICQ:</td>
          <td><?echo $profile_info[7];?></td>
	</tr>
	<tr>
          <td><img src="<?echo default_img('im/im_skype.gif');?>"> Skype:</td>
          <td><?echo $profile_info[8];?></td>
	</tr>
	<tr>
          <td valign="top"><?echo mmw_lang_avatar;?>:</td>
          <td><img  width="110" src="<?echo $profile_info[3];?>"></td>
	</tr>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='300'> 
	<thead><tr>
          <td>#</td>
          <td><?echo mmw_lang_character;?></td>
          <td><?echo mmw_lang_reset;?></td>
          <td><?echo mmw_lang_level;?></td>
          <td><?echo mmw_lang_class;?></td>
	</tr></thead>
<?php
 $result = mssql_query("Select Name,Class,cLevel,Reset from Character where AccountID='$account_get' order by reset desc, clevel desc");
 $row_num = mssql_num_rows($result);

 if($row_num<=0) {
  echo '<tr><td colspan="5">'.mmw_lang_no_characters.'</td></tr>';
 }

 for($i=0; $i<$row_num; ++$i) {
	$rank = $i+1;
	$row = mssql_fetch_row($result);
	$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$account_get'");
	$status = mssql_fetch_row($status_reults);
	$statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$account_get'");
	$statusdc = mssql_fetch_row($statusdc_reults);

	if($status[0] == 1 && $statusdc[0] == $row[0]) {$status[0] ='<img src='.default_img('online.gif').' width=6 height=6>';}
	else {$status[0] ='<img src='.default_img('offline.gif').' width=6 height=6>';}

 echo 	"<tbody><tr>
            <td>$rank</td>
            <td>$status[0] <a href=?op=character&character=$row[0]>$row[0]</a></td>
            <td>$row[3]</td>
            <td>$row[2]</td>
            <td>".char_class($row[1],off)."</td>
            </tr></tbody>";
 }
echo '</table>';
}
else {echo "$die_start Profile is Hidden! <br> Supported by Vaflan $die_end";}
?>
