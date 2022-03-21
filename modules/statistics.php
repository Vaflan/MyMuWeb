<?PHP
//Stats By Vaflan
//For MyMuWeb
//Version: 0.1

$total_accounts = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO") );
if($mmw[gm]=='no') {$gm_not_show = "WHERE ctlcode !='32' AND ctlcode !='8'";}
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character $gm_not_show") );
$total_guilds = mssql_fetch_row( mssql_query("SELECT count(*) FROM Guild WHERE G_Name!='$mmw[gm_guild]'") );
$total_banneds = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_INFO WHERE bloc_code = '1'") );
$users_connected = mssql_fetch_row( mssql_query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = '1'") );

$size = getimagesize("images/bar.jpg");

function s_characters_done($type,$class) {
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character") );
$characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character WHERE Class = $class") );
$procent = substr(100 * $characters[0] / $total_characters[0], 0, 4);
 if($type==0) {$return = $procent;}
 else {$return = $characters[0];}
return $return;
}

function s_map_done($type,$map) {
$total_characters = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character") );
$in_map_char = mssql_fetch_row( mssql_query("SELECT count(*) FROM Character WHERE mapnumber = $map") );
$procent = substr(100 * $in_map_char[0] / $total_characters[0], 0, 4);
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
$total_in_guilds_results = substr(100 * $total_in_guilds[0] / $total_characters[0], 0, 4);

$male = mssql_query("Select count(*) from MEMB_INFO where gender='male'");
$male_done = mssql_fetch_row($male);
$male_results = substr(100 * $male_done[0] / $total_accounts[0], 0, 4);

$female = mssql_query("Select count(*) from MEMB_INFO where gender='female'");
$female_done = mssql_fetch_row($female);
$female_results = substr(100 * $female_done[0] / $total_accounts[0], 0, 4);
?>

<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
        <fieldset>
        <legend><?echo $mmw[servername];?> Servers</legend>
<?
$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,type from mmw_servers order by display_order asc");
for($i=0;$i < mssql_num_rows($result);++$i) {
$rank = $i+1;
$row = mssql_fetch_row($result);
if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.5)) 
 {fclose($check); $status_done = "<span class='online'><b>Online</b></span>";}
else
 {$status_done = "<span class='offline'><b>Offline</b></span>";} 
echo "<a class='helpLink' href='info' onclick=\"showHelpTip(event, 'Version: $row[5]<br>Name: $row[0]<br>Experience: $row[1]<br>Drops: $row[2]<br>Type: $row[6]' ,false); return false\">$row[0]</a> $status_done<br>";
}
?>
        </fieldset>
    </td>
  </tr>
</table>

<?echo $rowbr;?>

<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
        <fieldset>
        <legend><?echo $mmw[servername];?> Server Statistics </legend>
        <table align=center width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="right">Total Accounts</td>
            <td align="left" width="300">
<?echo "<img src='images/bar.jpg' Alt='Total Accounts' height='$size[1]' width='". 100 * 2 . "'><font size='1'> 100 % ($total_accounts[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Total Characters</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='Total Characters' height='$size[1]' width='". 100 * 2 . "'><font size='1'> 100 % (<a href='?op=rankings&sort=all'>$total_characters[0])</a></font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Total Banneds</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='Total Banneds' height='$size[1]' width='". $total_banneds_results * 2 . "'><font size='1'> $total_banneds_results % ($total_banneds[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Total Guilds</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='Total Guild' height='$size[1]' width='". 100 * 2 . "'><font size='1'> 100 % (<a href='?op=rankings&sort=guild'>$total_guilds[0]</a>)</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Total in Guilds</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='Total in Guild' height='$size[1]' width='". $total_in_guilds_results * 2 . "'><font size='1'> $total_in_guilds_results % ($total_in_guilds[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Users Online</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='User Online' height='$size[1]' width='". $users_connected_results * 2 . "'><font size='1'> $users_connected_results % (<a href='?op=rankings&sort=online'>$users_connected[0]</a>)</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Total Male Users</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='Male' height='$size[1]' width='". $male_results * 2 . "'><font size='1'> $male_results % ($male_done[0])</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right">Total Female Users</td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='Female' height='$size[1]' width='". $female_results * 2 . "'><font size='1'> $female_results % ($female_done[0])</font>";?>
            </td>
          </tr>
        </table>
        </fieldset>
    </td>
  </tr>
</table>

<?echo $rowbr;?>

<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
        <fieldset>
        <legend><?echo "$mmw[servername]";?> Character Statistics </legend>
        <table align=center width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="right"><?echo char_class(0,full);?></td>
            <td align="left" width="300">
<?echo "<img src='images/bar.jpg' Alt='".char_class(0,full)."' height='$size[1]' width='". s_characters_done(0,0) * 2 . "'><font size=\"1\"> ".s_characters_done(0,0)." % (".s_characters_done(1,0).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(1,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(1,full)."' height='$size[1]' width='". s_characters_done(0,1) * 2 . "'><font size=\"1\"> ".s_characters_done(0,1)." % (".s_characters_done(1,1).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(2,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(2,full)."' height='$size[1]' width='". s_characters_done(0,2) * 2 . "'><font size=\"1\"> ".s_characters_done(0,2)." % (".s_characters_done(1,2).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(16,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(16,full)."' height='$size[1]' width='". s_characters_done(0,16) * 2 . "'><font size=\"1\"> ".s_characters_done(0,16)." % (".s_characters_done(1,16).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(17,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(17,full)."' height='$size[1]' width='". s_characters_done(0,17) * 2 . "'><font size=\"1\"> ".s_characters_done(0,17)." % (".s_characters_done(1,17).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(18,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(18,full)."' height='$size[1]' width='". s_characters_done(0,18) * 2 . "'><font size=\"1\"> ".s_characters_done(0,18)." % (".s_characters_done(1,18).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(32,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(32,full)."' height='$size[1]' width='". s_characters_done(0,32) * 2 . "'><font size=\"1\"> ".s_characters_done(0,32)." % (".s_characters_done(1,32).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(33,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(33,full)."' height='$size[1]' width='". s_characters_done(0,33) * 2 . "'><font size=\"1\"> ".s_characters_done(0,33)." % (".s_characters_done(1,33).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(34,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(34,full)."' height='$size[1]' width='". s_characters_done(0,34) * 2 . "'><font size=\"1\"> ".s_characters_done(0,34)." % (".s_characters_done(1,34).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(48,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(48,full)."' height='$size[1]' width='". s_characters_done(0,48) * 2 . "'><font size=\"1\"> ".s_characters_done(0,48)." % (".s_characters_done(1,48).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(50,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(50,full)."' height='$size[1]' width='". s_characters_done(0,50) * 2 . "'><font size=\"1\"> ".s_characters_done(0,50)." % (".s_characters_done(1,50).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(64,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(64,full)."' height='$size[1]' width='". s_characters_done(0,64) * 2 . "'><font size=\"1\"> ".s_characters_done(0,64)." % (".s_characters_done(1,64).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(66,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(66,full)."' height='$size[1]' width='". s_characters_done(0,66) * 2 . "'><font size=\"1\"> ".s_characters_done(0,66)." % (".s_characters_done(1,66).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(80,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(80,full)."' height='$size[1]' width='". s_characters_done(0,80) * 2 . "'><font size=\"1\"> ".s_characters_done(0,80)." % (".s_characters_done(1,80).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(81,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(81,full)."' height='$size[1]' width='". s_characters_done(0,81) * 2 . "'><font size=\"1\"> ".s_characters_done(0,81)." % (".s_characters_done(1,81).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo char_class(82,full);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".char_class(82,full)."' height='$size[1]' width='". s_characters_done(0,82) * 2 . "'><font size=\"1\"> ".s_characters_done(0,82)." % (".s_characters_done(1,82).")</font>";?>
            </td>
          </tr>
        </table>
        </fieldset>
    </div></td>
  </tr>
</table>

<?echo $rowbr;?>

<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
        <fieldset>
        <legend><?echo "$mmw[servername]";?> Players On Map </legend>
        <table align=center width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="right"><?echo map(0);?></td>
            <td align="left" width="300">
<?echo "<img src='images/bar.jpg' Alt='".map(0)."' height='$size[1]' width='". s_map_done(0,0) * 2 . "'><font size=\"1\"> ".s_map_done(0,0)." % (".s_map_done(1,0).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(1);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(1)."' height='$size[1]' width='". s_map_done(0,1) * 2 . "'><font size=\"1\"> ".s_map_done(0,1)." % (".s_map_done(1,1).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(2);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(2)."' height='$size[1]' width='". s_map_done(0,2) * 2 . "'><font size=\"1\"> ".s_map_done(0,2)." % (".s_map_done(1,2).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(3);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(3)."' height='$size[1]' width='". s_map_done(0,3) * 2 . "'><font size=\"1\"> ".s_map_done(0,3)." % (".s_map_done(1,3).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(4);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(4)."' height='$size[1]' width='". s_map_done(0,4)  * 2 . "'><font size=\"1\"> ".s_map_done(0,4)." % (".s_map_done(1,4).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(6);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(6)."' height='$size[1]' width='". s_map_done(0,6) * 2 . "'><font size=\"1\"> ".s_map_done(0,6)." % (".s_map_done(1,6).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(7);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(7)."' height='$size[1]' width='". s_map_done(0,7) * 2 . "'><font size=\"1\"> ".s_map_done(0,7)." % (".s_map_done(1,7).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(8);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(8)."' height='$size[1]' width='". s_map_done(0,8) * 2 . "'><font size=\"1\"> ".s_map_done(0,8)." % (".s_map_done(1,8).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(10);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(10)."' height='$size[1]' width='". s_map_done(0,10) * 2 . "'><font size=\"1\"> ".s_map_done(0,10)." % (".s_map_done(1,10).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(30);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(30)."' height='$size[1]' width='". s_map_done(0,30) * 2 . "'><font size=\"1\"> ".s_map_done(0,30)." % (".s_map_done(1,30).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(31);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(31)."' height='$size[1]' width='". s_map_done(0,31) * 2 . "'><font size=\"1\"> ".s_map_done(0,31)." % (".s_map_done(1,31).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(33);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(33)."' height='$size[1]' width='". s_map_done(0,33) * 2 . "'><font size=\"1\"> ".s_map_done(0,33)." % (".s_map_done(1,33).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(34);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(34)."' height='$size[1]' width='". s_map_done(0,34) * 2 . "'><font size=\"1\"> ".s_map_done(0,34)." % (".s_map_done(1,34).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(41);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(41)."' height='$size[1]' width='". s_map_done(0,41) * 2 . "'><font size=\"1\"> ".s_map_done(0,41)." % (".s_map_done(1,41).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(42);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(42)."' height='$size[1]' width='". s_map_done(0,42) * 2 . "'><font size=\"1\"> ".s_map_done(0,42)." % (".s_map_done(1,42).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(51);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(51)."' height='$size[1]' width='". s_map_done(0,51) * 2 . "'><font size=\"1\"> ".s_map_done(0,51)." % (".s_map_done(1,51).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(56);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(56)."' height='$size[1]' width='". s_map_done(0,56) * 2 . "'><font size=\"1\"> ".s_map_done(0,56)." % (".s_map_done(1,56).")</font>";?>
            </td>
          </tr>
          <tr>
            <td align="right"><?echo map(57);?></td>
            <td align="left">
<?echo "<img src='images/bar.jpg' Alt='".map(57)."' height='$size[1]' width='". s_map_done(0,57) * 2 . "'><font size=\"1\"> ".s_map_done(0,57)." % (".s_map_done(1,57).")</font>";?>
            </td>
          </tr>
        </table>
        </fieldset>
    </td>
  </tr>
</table>