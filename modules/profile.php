<?
$account_get = clean_var(stripslashes($_GET[profile]));

$profile_sql = mssql_query("Select country,gender,age,avatar,hide_profile,y,msn,icq,skype,memb_name from memb_info where memb___id='$account_get'");
$profile_info = mssql_fetch_row($profile_sql);
$profile_info_check = mssql_num_rows($profile_sql);
if($profile_info[2] == '') {$profile_info[2] = "Not Set";}
if($profile_info[0] == '0') {$country = "Not Set";}
else{$country = country($profile_info[0]);}
if($profile_info[3] == NULL || $profile_info[3] == " ") {$profile_info[3] = "images/no_avatar.jpg";}
if($profile_info[1] == 'male') {$profile_info[1] = "<table><tr><td>Male</td><td><img src='images/male.gif'></td></tr></table>";}
elseif($profile_info[1] == 'female') {$profile_info[1] = "<table><tr><td>Female</td><td><img src='images/female.gif'></td></tr></table>";}
?>

<div align="center">
  <table width="200" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="335" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="335"><fieldset>
        <legend><?echo "$account_get Profile";?></legend>
        <div align="center">
          <table width="200" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="49">Full Name:</td>
              <td width="139"><div align="left"><?echo $profile_info[9];?></div></td>
            </tr>
            <tr>
              <td>Country:</td>
              <td><div align="left"><?echo $country;?></div></td>
            </tr>
            <tr>
              <td>Age:</td>
              <td><div align="left"><?echo $profile_info[2];?></div></td>
            </tr>
            <tr>
              <td>Gender:</td>
              <td><div align="left"><?echo $profile_info[1];?></div></td>
            </tr>
            <tr>
              <td>Avatar:</td>
              <td><div align="left"><img  width="110" src="<?echo $profile_info[3];?>"></div></td>
            </tr>
          </table>
          <table width="200" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
          <table width="222" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="62"><div align="left"><img src="images/im/im_yahoo.gif"> Yahoo!:</div></td>
              <td width="168"><div align="left"><?echo $profile_info[5];?></div></td>
            </tr>
            <tr>
              <td><div align="left"><img src="images/im/im_msn.gif"> MSN:</div></td>
              <td><div align="left"><?echo $profile_info[6];?></div></td>
            </tr>
            <tr>
              <td><div align="left"><img src="images/im/im_icq.gif"> ICQ:</div></td>
              <td><div align="left"><?echo $profile_info[7];?></div></td>
            </tr>
            <tr>
              <td><div align="left"><img src="images/im/im_skype.gif"> Skype:</div></td>
              <td><div align="left"><?echo $profile_info[8];?></div></td>
            </tr>
          </table>
        </div>
      </fieldset></td>
    </tr>
  </table>
</div>
