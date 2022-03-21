<?if($acc_online_check=="0"){

if(empty($char_set) || $char_set==""){jump('?op=user');}

if(isset($_POST["reset_char"])) {require("includes/character.class.php");option::reset($char_set); echo $rowbr;}
if(isset($_POST["stats_char"])) {require("includes/character.class.php");option::add_stats($char_set); echo $rowbr;}
if(isset($_POST["clearpk_char"])) {require("includes/character.class.php");option::clear_pk($char_set); echo $rowbr;}
if(isset($_POST["warp_char"])) {require("includes/character.class.php");option::warp($char_set); echo $rowbr;}

$char_results = mssql_query("SELECT Name,class,strength,dexterity,vitality,energy,money,accountid,mapnumber,clevel,reset,LevelUpPoint,pkcount,pklevel,money,leadership,experience FROM Character WHERE Name='$char_set'"); 
$info = mssql_fetch_row($char_results);

$wh_result = mssql_query("SELECT AccountID,extMoney FROM warehouse WHERE accountid='$login'");
$wh_row = mssql_fetch_row($wh_result); if($wh_row[1]=="" || empty($wh_row[1])) {$wh_row[1]="0";}
$all_money = $info[14] + $wh_row[1];

$guildm_results = mssql_query("Select G_name from GuildMember where name='$char_set'");
$guildm = mssql_fetch_row($guildm_results);
if($guildm[0]==NULL || $guildm[0]==" "){$guild_end = 'No Guild';}
else {
$guild_results = mssql_query("Select G_name,g_mark from Guild where g_name='$guildm[0]'");
$guild_row = mssql_fetch_row($guild_results);
$logo = urlencode(bin2hex($guild_row[1]));
$guild_end = "<a class='helpLink' href='#' onclick=\"showHelpTip(event,'<img src=decode.php?decode=$logo height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height='10' width='10' broder='0'></a> <a href='?op=guild&guild=$guildm[0]'>$guildm[0]</a>";
	if($mmw[mix_cs_memb_reset]=="yes") {
	$cs_query = mssql_query("SELECT owner_guild,money FROM MuCastle_DATA");
	$cs_row = mssql_fetch_row($cs_query);
		if($cs_row[0]==$guildm[0]){
		if($mmw[max_zen_cs_reset]>$cs_row[1]){$edited_zen_cs = $cs_row[1];} else{$edited_zen_cs = $mmw[max_zen_cs_reset];}
		$cs_memb_reset_zen = ( substr($mmw['resetmoney'], 0, -6) * ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ) ) / 100;
		$cs_memb_reset_proc = "<br>You Have: -" . ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ) . "%";
		}
	}
}

if($info[12]==NULL || $info[12]==" "){$info[12] = 'No Kills';}

$locations = '<select name="map" id="map" style="width:60px" size="1">
                <option value="maps">Select Map</option>
                <option value="0">Lorenica</option>
                <option value="3">Noria</option>
                <option value="2">Devias</option>
                <option value="1">Dungeon</option>
                <option value="7">Atlans</option>
                <option value="4">Losttower</option>
                <option value="8">Tarkan</option>
                <option value="6">Stadium</option>
                <option value="10">Icarus</option>
              </select>';

$add_stats = 'Strength <input name="str" type="text" id="str" size="5" maxlength="5"><br>';
$add_stats = $add_stats.'Agility <input name="agi" type="text" id="agi" size="5" maxlength="5"><br>';
$add_stats = $add_stats.'Vitality <input name="vit" type="text" id="vit" size="5" maxlength="5"><br>';
$add_stats = $add_stats.'Energy <input name="ene" type="text" id="ene" size="5" maxlength="5"><br>';
if($info[1]==64){$add_stats = $add_stats.'Command <input name="com" type="text" id="com" size="5" maxlength="5"><br>';}

if($mmw[mix_cs_memb_reset]=="yes" && $cs_row[0]==$guildm[0]) {$edited_res_money = $mmw['resetmoney'] - ($cs_memb_reset_zen * 1000000);}
else {$edited_res_money = $mmw['resetmoney'];}
if($mmw[reset_system]=='yes') {$resetzen = $edited_res_money * ($info[10] + 1);}
else {$resetzen = $edited_res_money;}
if($info[9] < $mmw['resetlevel']) {$reset = "Need $mmw[resetlevel] level!";}
elseif( $all_money < $resetzen) {$reset = "Need ".number_format(substr($resetzen, 0, -6))."kk Zen!";}
else {$reset = "<form action='' method='post' name='reset' id='reset'>Price: ".number_format(substr($resetzen, 0, -6))."kk Zen! $cs_memb_reset_proc <br><input name='reset_char' type='hidden' id='reset_char' value='$char_set'><input type='submit' name='Submit' value='Reset'></form>";}

if($info[11] <= 0) {$addpoint="No Up Points Found!";}
elseif($info[11] >= 1) {$addpoint="<form action='' method='post' name='stats' id='stats'>You Have: $info[11]<br><input name='stats_char' type='hidden' id='stats_char' value='$char_set'> $add_stats <input type='submit' name='Submit' value='Add Point' onclick='return ask_stats()'></form>";}

if($all_money < $mmw['pkmoney']) {$pkclear="Need ".number_format(substr($mmw['pkmoney'], 0, -6))."kk Zen!";}
elseif($info[13] <= 3) {$pkclear="No Pk Status Found!";}
elseif($info[13] > 3) {$pkclear="<form action='' method='post' name='clearpk' id='clearpk'>Price: ".number_format(substr($mmw['pkmoney'], 0, -6))."kk Zen!<br><input name='clearpk_char' type='hidden' id='clearpk_char' value='$char_set'><input type='submit' name='Submit' value='Pk Clear'></form>";}

if($info[9] < 6) {$move="Need 6 level!";}
elseif($all_money < $mmw['warp_zen']) {$move="Need ".number_format(substr($mmw['warp_zen'], 0, -6))."kk Zen!";}
else {$move="<form action='' method='post' name='warp' id='warp'>Price: ".number_format(substr($mmw['warp_zen'], 0, -6))."kk Zen!<br><input name='warp_char' type='hidden' id='warp_char' value='$char_set'> $locations <input type='submit' name='Submit' value='Move'></form>";}
?>

      <table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
       <tr>
	<td valign="top">
	<table width="100%" class="sort-table" cellpadding="0" cellspacing="0">
          <tr>
            <td width="20%" align="right">Name:</td>
            <td width="50%"><span class="level<?echo $_SESSION['char_ctlcode'];?>"><?echo $char_set;?></span></td>
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
            <td align="right">Experience:</td>
            <td><?echo $info[16];?></td>
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
            <td align="right">Up Point:</td>
            <td><?echo $info[11];?></td>
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
            <td align="right">Zen:</td>
            <td><?echo number_format($info[14]);?></td>
          </tr>
          <tr>
            <td align="right">Kills:</td>
            <td><?echo $info[12];?> (<?echo pkstatus($info[13]);?>)</td>
          </tr>
          <tr>
            <td align="right">Location:</td>
            <td><?echo map($info[8]);?></td>
          </tr>
	</table>
	</td>
	<td valign="top" align="center" width="100">
		<?echo char_class($info[1],img);?><br><br>
		<div style="cursor:pointer" onclick="expandit('menu_1')"><b>Reset</b></div>
		<div id="menu_1" style="display:none;padding-bottom:4px;"><?echo $reset;?></div>
		<div style="cursor:pointer" onclick="expandit('menu_2')"><b>Add Point</b></div>
		<div id="menu_2" style="display:none;padding-bottom:4px;"><?echo $addpoint;?></div>
		<div style="cursor:pointer" onclick="expandit('menu_3')"><b>Pk Clear</b></div>
		<div id="menu_3" style="display:none;padding-bottom:4px;"><?echo $pkclear;?></div>
		<div style="cursor:pointer" onclick="expandit('menu_4')"><b>Move</b></div>
		<div id="menu_4" style="display:none;padding-bottom:4px;"><?echo $move;?><div>
	</td>
       </tr>
      </table>

<?}elseif($acc_online_check=="1"){echo "$die_start Account Is Online, Must Be Logged Off! $die_end";}else{echo "$die_start Stupid Hacker! :@ $die_end";}?>