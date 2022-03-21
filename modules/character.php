<?PHP
$character_get = stripslashes($_GET[character]);

$char_results = mssql_query("SELECT Name,class,strength,dexterity,vitality,energy,money,accountid,mapnumber,clevel,reset,LevelUpPoint,pkcount,pklevel,money,leadership,CtlCode FROM Character WHERE Name='$character_get'"); 
$info = mssql_fetch_row($char_results);

$profile_sql = mssql_query("Select hide_profile from memb_info where memb___id='$info[7]'");
$profile_row = mssql_fetch_row($profile_sql);
if($profile_row[0] == '0'){$profile = "<a href=?op=profile&profile=$info[7]><b>View Profile</b></a>";}

$status_sql = mssql_query("select connectstat,CONNECTTM from MEMB_STAT where memb___id='$info[7]'");
$status_row = mssql_fetch_row($status_sql);
$statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$info[7]'");
$statusdc = mssql_fetch_row($statusdc_reults);
if($statusdc[0]==$info[0] && $status_row[0]==1){$login_status='<span class="online">Online</span>';}
else{$login_status='<span class="offline">Offline</span>';}

$guildm_results = mssql_query("Select G_name from GuildMember where name='$info[0]'");
$guildm = mssql_fetch_row($guildm_results);
if($guildm[0]==NULL || $guildm[0]==" "){$guild_end = 'No Guild';}
else {
$guild_results = mssql_query("Select G_name,g_mark from Guild where g_name='$guildm[0]'");
$guild_row = mssql_fetch_row($guild_results);
$logo = urlencode(bin2hex($guild_row[1]));
$guild_end = "<a class='helpLink' href='#' onclick=\"showHelpTip(event,'<img src=decode.php?decode=$logo height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height='10' width='10' broder='0'></a> <a href='?op=guild&guild=$guildm[0]'>$guildm[0]</a>";
}

if($info[12]==NULL || $info[12]==" "){$info[12] = 'No Kills';}
?>
<div class="brdiv"></div>

      <table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
       <tr>
	<td valign="top">
	<table width="100%" class="sort-table" cellpadding="0" cellspacing="0">
          <tr>
            <td width="40%" align="right">Name:</td>
            <td width="50%"><span class="level<?echo $info[16];?>"><?echo $info[0];?></span></td>
          </tr>
          <tr>
            <td align="right">Class:</td>
            <td><?echo char_class($info[1],full);?></td>
          </tr>
          <tr>
            <td align="right">Guild:</td>
            <td><?echo $guild_end;?></td>
          </tr>
          <tr>
            <td align="right">Level:</td>
            <td><?echo $info[9];?></td>
          </tr>
          <tr>
            <td align="right">Reset:</td>
            <td><?echo $info[10];?></td>
          </tr>
          <tr>
            <td align="right">Strength:</td>
            <td><?echo $info[2];?></td>
          </tr>
          <tr>
            <td align="right">Agility:</td>
            <td><?echo $info[3];?></td>
          </tr>
          <tr>
            <td align="right">Vitality:</td>
            <td><?echo $info[4];?></td>
          </tr>
          <tr>
            <td align="right">Energy:</td>
            <td><?echo $info[5];?></td>
          </tr>
          <?if($info[15]>0){?><tr>
            <td align="right">Command:</td>
            <td><?echo $info[15];?></td>
          </tr><?}?>
          <tr>
            <td align="right">Kills:</td>
            <td><?echo $info[12];?> (<?echo pkstatus($info[13]);?>)</td>
          </tr>
          <tr>
            <td align="right">Location:</td>
            <td><?echo map($info[8]);?></td>
          </tr>
          <tr>
            <td align="right">Last Login:</td>
            <td><?echo time_format($status_row[1],"d M Y, H:i");?></td>
          </tr>
          <tr>
            <td align="right">Login Status:</td>
            <td><?echo $login_status;?></td>
          </tr>
	</table>
	</td>
	<td valign="top" align="center" width="100">
	<?echo char_class($info[1],img);?><br><br>
	<a href='?op=user&u=mail&to=<?echo $info[0];?>'><b>Send Message</b></a><br/>
	<?echo $profile;?><br/>
	</td>
       </tr>
      </table>