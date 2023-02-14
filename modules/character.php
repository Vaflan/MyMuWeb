<?PHP
$character_get = clean_var($_GET[character]);
if(isset($_POST["zen"])) {require("includes/character.class.php");option::send_zen($_POST["zen_to_char"],$_POST["zen"]); echo $rowbr;}

$char_results = mssql_query("SELECT Name,class,strength,dexterity,vitality,energy,money,accountid,mapnumber,clevel,reset,LevelUpPoint,pkcount,pklevel,money,leadership,CtlCode FROM Character WHERE Name='$character_get'"); 
$info = mssql_fetch_row($char_results);
if(mssql_num_rows($char_results) < 1) {echo "$die_start Character Dosn't Exist $die_end";}
elseif($info[16] == 0 && $mmw['info_gm_and_blocked'] == 0 || $mmw['info_gm_and_blocked'] > 0) {
 $profile_sql = mssql_query("Select hide_profile from memb_info where memb___id='$info[7]'");
 $profile_row = mssql_fetch_row($profile_sql);
 if($profile_row[0] == '0'){$profile = "<a href=?op=profile&profile=$info[0]><b>".mmw_lang_view_profile."</b></a><br/>";}

 $status_sql = mssql_query("select connectstat,CONNECTTM from MEMB_STAT where memb___id='$info[7]'");
 $status_row = mssql_fetch_row($status_sql);
 $statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$info[7]'");
 $statusdc = mssql_fetch_row($statusdc_reults);
 if($statusdc[0]==$info[0] && $status_row[0]==1){$login_status='<span class="online">'.mmw_lang_acc_online.'</span>';}
 else{$login_status='<span class="offline">'.mmw_lang_acc_offline.'</span>';}

 $guildm_results = mssql_query("Select G_name from GuildMember where name='$info[0]'");
 $guildm = mssql_fetch_row($guildm_results);
 if($guildm[0]==NULL || $guildm[0]==" "){$guild_end = mmw_lang_no_guild;}
 else {
  $guild_results = mssql_query("Select G_name,g_mark from Guild where g_name='$guildm[0]'");
 $guild_row = mssql_fetch_row($guild_results);
 $logo = urlencode(bin2hex($guild_row[1]));
 $guild_end = "<img src='decode.php?decode=$logo' height='10' width='10' class='helpLink' title='<img src=decode.php?decode=$logo height=60 width=60>'> <a href='?op=guild&guild=$guildm[0]'>$guildm[0]</a>";
 }

 if($info[12]==NULL || $info[12]==" "){$info[12] = mmw_lang_no_kills;}

 if(isset($_SESSION['char_set']) && $_SESSION['char_set']!=' ' && isset($_SESSION['user'])) {$send_zen = "<form action='' method='post' name='send_zen'><input name='zen_to_char' type='hidden' value='$character_get'> <input name='zen' type='text' size='8' maxlength='10'> <input type='submit' name='Submit' value='".mmw_lang_send."'><br>".mmw_lang_service_fee.': '.zen_format($mmw[service_send_zen]).' Zen</form>';}
 elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {$send_zen = mmw_lang_cant_add_no_char;}
 else {$send_zen = mmw_lang_guest_must_be_logged_on;}
?>

      <table border="0" cellpadding="0" cellspacing="0" align="center">
       <tr>
	<td valign="top">
	<table class="sort-table" cellpadding="0" cellspacing="0">
          <tr>
            <td align="right"><?echo mmw_lang_character;?>:</td>
            <td><span class="level<?echo $info[16];?>"><?echo $info[0];?></span></td>
          </tr>
          <?if($mmw[status_rules][$_SESSION[mmw_status]][gm_option] == 1){?><tr>
            <td align="right"><?echo mmw_lang_account;?>:</td>
            <td><?echo $info[7];?></td>
          </tr><?}?>
          <tr>
            <td align="right"><?echo mmw_lang_status;?>:</td>
            <td><?echo ctlcode($info[16]);?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_class;?>:</td>
            <td><?echo char_class($info[1],full);?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_guild;?>:</td>
            <td><?echo $guild_end;?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_level;?>:</td>
            <td><?echo $info[9];?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_reset;?>:</td>
            <td><?echo $info[10];?></td>
          </tr>
          <tr>
            <td align="right">Strength:</td>
            <td><?echo point_format($info[2]);?></td>
          </tr>
          <tr>
            <td align="right">Agility:</td>
            <td><?echo point_format($info[3]);?></td>
          </tr>
          <tr>
            <td align="right">Vitality:</td>
            <td><?echo point_format($info[4]);?></td>
          </tr>
          <tr>
            <td align="right">Energy:</td>
            <td><?echo point_format($info[5]);?></td>
          </tr>
          <?if($info[15]>0){?><tr>
            <td align="right">Command:</td>
            <td><?echo point_format($info[15]);?></td>
          </tr><?}?>
          <tr>
            <td align="right"><?echo mmw_lang_kills;?>:</td>
            <td><?echo $info[12];?> (<?echo pkstatus($info[13]);?>)</td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_map_name;?>:</td>
            <td><?echo map($info[8]);?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_last_login;?>:</td>
            <td><?echo time_format($status_row[1],"d M Y, H:i");?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_login_status;?>:</td>
            <td><?echo $login_status;?></td>
          </tr>
	</table>
	</td>
	<td valign="top" align="center" style="padding-left:2px;">
		<?echo "<img src='".default_img(char_class($info[1],img))."' title='".char_class($info[1],full)."'>";?><br><br>
		<a href='?op=user&u=mail&to=<?echo $info[0];?>'><b><?echo mmw_lang_send_message;?></b></a><br/>
		<?echo $profile;?>
		<div class="div-menu-out" onclick="expandit('menu_1')" onmouseover="tclass=this.className;this.className='div-menu-over';" onmouseout="this.className=tclass;"><?echo mmw_lang_send_zen;?></div>
		<div id="menu_1" style="display:none;padding-bottom:4px;"><?echo $send_zen;?><div>
	</td>
       </tr>
      </table>
<?php
}
else {echo "$die_start You can't see blocked information! <br> Supported by Vaflan $die_end";}
?>
