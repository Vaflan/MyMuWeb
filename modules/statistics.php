<?PHP
// Stats By Vaflan
// For MyMuWeb
// Version: 0.2

$total_accounts = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO") );
if($mmw[gm]=='no') {$gm_not_show = "WHERE ctlcode !='32' AND ctlcode !='8'";}
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character $gm_not_show") );
$total_guilds = mssql_fetch_row( mssql_query("SELECT count(*) FROM Guild WHERE G_Name!='$mmw[gm_guild]'") );
$total_banneds = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO WHERE bloc_code = '1'") );
$users_connected = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1'") );

if(is_file(default_img("bar.jpg"))) {$size = getimagesize(default_img("bar.jpg"));}
else {$size = '3';}

function s_characters_done($type,$class) {
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character") );
$characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character WHERE Class = $class") );
if($characters[0] > 0) {$procent = substr(100 * $characters[0] / $total_characters[0], 0, 4);}
else {$procent = 0;}
 if($type==0) {$return = $procent;}
 else {$return = $characters[0];}
return $return;
}

function s_map_done($type,$map) {
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character") );
$in_map_char = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character WHERE mapnumber = $map") );
if($in_map_char[0] > 0) {$procent = substr(100 * $in_map_char[0] / $total_characters[0], 0, 4);}
else {$procent = 0;}
 if($type==0) {$return = $procent;}
 else {$return = $in_map_char[0];}
return $return;
}

$online_characters = mssql_query("SELECT count(*) FROM memb_stat WHERE connectstat = 1");
$online_characters_done = mssql_fetch_row($online_characters);
$online = substr(100 * $online_characters_done[0] / $total_accounts[0], 0, 4);

$users_connected_results = substr(100 * $users_connected[0] / $total_accounts[0], 0, 4);
$total_banneds_results = substr(100 * $total_banneds[0] / $total_accounts[0], 0, 4);

$in_guilds = mssql_query("Select count(*) from GuildMember WHERE G_Name!='$gm_guild'");
$total_in_guilds = mssql_fetch_row($in_guilds);
if($total_in_guilds[0] > 0) {$total_in_guilds_results = substr(100 * $total_in_guilds[0] / $total_characters[0], 0, 4);}
else {$total_in_guilds_results = 0;}

$male = mssql_query("Select count(*) from MEMB_INFO where gender='male'");
$male_done = mssql_fetch_row($male);
$male_results = substr(100 * $male_done[0] / $total_accounts[0], 0, 4);

$female = mssql_query("Select count(*) from MEMB_INFO where gender='female'");
$female_done = mssql_fetch_row($female);
$female_results = substr(100 * $female_done[0] / $total_accounts[0], 0, 4);
?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
   <tr>
      <td>
<?
$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type from mmw_servers order by display_order asc");
$serv_num = mssql_num_rows($result);
for($i=0;$i < $serv_num;++$i) {
 $row = mssql_fetch_row($result);
 if($i < $serv_num - 1) {$other_serv = ',';} else {$other_serv = '';}
 if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.8)) {fclose($check); $status_done = "<span class='online'><b>".mmw_lang_serv_online."</b></span>";}
 else {$status_done = "<span class='offline'><b>".mmw_lang_serv_offline."</b></span>";} 
 echo " <span class=\"helpLink\" title=\"<b>".mmw_lang_version.":</b> $row[5]<br><b>".mmw_lang_experience.":</b> $row[1]<br><b>".mmw_lang_drops.":</b> $row[2]<br><b>".mmw_lang_type.":</b> $row[6]\">$row[0]</span>: $status_done" . $other_serv;
}
?>
      </td>
   </tr>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
          <tr>
            <td align="right" width="120"><?echo mmw_lang_total_accounts;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". 100 * 2 . "'><font size='1'> 100% ($total_accounts[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_characters;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". 100 * 2 . "'><font size='1'> 100% (<a href='?op=rankings&sort=all'>$total_characters[0]</a>)</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_banneds;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". $total_banneds_results * 2 . "'><font size='1'> $total_banneds_results% ($total_banneds[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_guilds;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". 100 * 2 . "'><font size='1'> 100% (<a href='?op=rankings&sort=guild'>$total_guilds[0]</a>)</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_in_guilds;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". $total_in_guilds_results * 2 . "'><font size='1'> $total_in_guilds_results% ($total_in_guilds[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_users_online;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". $users_connected_results * 2 . "'><font size='1'> $users_connected_results% (<a href='?op=rankings&sort=online'>$users_connected[0]</a>)</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_male_users;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". $male_results * 2 . "'><font size='1'> $male_results% ($male_done[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_total_female_users;?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". $female_results * 2 . "'><font size='1'> $female_results% ($female_done[0])</font>";?>
            </td>
          </tr>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
<?
 $mmw[statistics_char_row] = explode(",", $mmw[statistics_char]);
 for($i=0;$i<count($mmw[statistics_char_row]);$i++) {
?>
          <tr>
            <td align="right" width="120"><?echo char_class($mmw[statistics_char_row][$i],full);?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". s_characters_done(0,$mmw[statistics_char_row][$i]) * 2 . "'><font size=\"1\"> ".s_characters_done(0,$mmw[statistics_char_row][$i])."% (".s_characters_done(1,$mmw[statistics_char_row][$i]).")</font>";?>
            </td>
          </tr>
<?}?>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
<?
 $mmw[statistics_maps_row] = explode(",", $mmw[statistics_maps]);
 for($i=0;$i<count($mmw[statistics_maps_row]);$i++) {
?>
          <tr>
            <td align="right" width="120"><?echo map($mmw[statistics_maps_row][$i]);?></td>
            <td align="left">
<?echo "<img src='".default_img("bar.jpg")."' height='$size[1]' width='". s_map_done(0,$mmw[statistics_maps_row][$i]) * 2 . "'><font size=\"1\"> ".s_map_done(0,$mmw[statistics_maps_row][$i])."% (".s_map_done(1,$mmw[statistics_maps_row][$i]).")</font>";?>
            </td>
          </tr>
<?}?>
</table>