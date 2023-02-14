<?if($acc_online_check=="0"){

if(empty($char_set)) {jump('?op=user');}

if(isset($_POST["reset_char"])) {require("includes/character.class.php");option::reset($char_set); echo $rowbr;}
if(isset($_POST["stats_char"])) {require("includes/character.class.php");option::add_stats($char_set); echo $rowbr;}
if(isset($_POST["clearpk_char"])) {require("includes/character.class.php");option::clear_pk($char_set); echo $rowbr;}
if(isset($_POST["move_char"])) {require("includes/character.class.php");option::move($char_set); echo $rowbr;}
if(isset($_POST["change_class_char"])) {require("includes/character.class.php");option::change_class($char_set); echo $rowbr;}

$char_results = mssql_query("SELECT Name,class,strength,dexterity,vitality,energy,money,accountid,mapnumber,clevel,reset,LevelUpPoint,pkcount,pklevel,money,leadership,experience,ctlcode FROM Character WHERE Name='$char_set'"); 
$info = mssql_fetch_row($char_results);

$wh_result = mssql_query("SELECT AccountID,extMoney FROM warehouse WHERE accountid='$login'");
$wh_row = mssql_fetch_row($wh_result); if($wh_row[1]=="" || empty($wh_row[1])) {$wh_row[1]="0";}
$all_money = $info[14] + $wh_row[1];

$guildm_results = mssql_query("Select G_name from GuildMember where name='$char_set'");
$guildm = mssql_fetch_row($guildm_results);
if($guildm[0]==NULL || $guildm[0]==" ") {$guild_end = mmw_lang_no_guild;}
else {
 $guild_results = mssql_query("Select G_name,g_mark from Guild where g_name='$guildm[0]'");
 $guild_row = mssql_fetch_row($guild_results);
 $logo = urlencode(bin2hex($guild_row[1]));
 $guild_end = "<img src='decode.php?decode=$logo' height='10' width='10' class='helpLink' title='<img src=decode.php?decode=$logo height=60 width=60>'> <a href='?op=guild&guild=$guildm[0]'>$guildm[0]</a>";
	if($mmw[mix_cs_memb_reset]=="yes") {
	$cs_query = mssql_query("SELECT owner_guild,money FROM MuCastle_DATA");
	$cs_row = mssql_fetch_row($cs_query);
		if($cs_row[0]==$guildm[0]){
		if($mmw[max_zen_cs_reset]>$cs_row[1]){$edited_zen_cs = $cs_row[1];} else{$edited_zen_cs = $mmw[max_zen_cs_reset];}
		$cs_memb_reset_zen = ( substr($mmw['reset_money'], 0, -6) * ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ) ) / 100;
		$cs_memb_reset_proc = '<br>'.mmw_lang_you_have.': -'.ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ).'%';
		}
	}
}

if($info[1] >= 0 && $info[1] <= 15) {$reset_level = $mmw[reset_level_dw];}
if($info[1] >= 16 && $info[1] <= 31) {$reset_level = $mmw[reset_level_dk];}
if($info[1] >= 32 && $info[1] <= 47) {$reset_level = $mmw[reset_level_elf];}
if($info[1] >= 48 && $info[1] <= 63) {$reset_level = $mmw[reset_level_mg];}
if($info[1] >= 64 && $info[1] <= 79) {$reset_level = $mmw[reset_level_dl];}
if($info[1] >= 80 && $info[1] <= 95) {$reset_level = $mmw[reset_level_sum];}
if($info[1] >= 96 && $info[1] <= 112) {$reset_level = $mmw[reset_level_rf];}

if($info[12]==NULL || $info[12]==" "){$info[12] = mmw_lang_no_kills;}


include("includes/move.php");
$locations = '<select name="map" style="width:76px" size="1"><option value="maps">'.mmw_lang_select_map.'</option>';
for($i=0; $i < count($move); ++$i) {
	$locations .= "<option value='$i'>".map($move[$i][0])."</option>\n";
}
$locations .= '</select>';
              

$add_stats = 'Strength <input name="str" type="text" size="5" maxlength="5"><br>';
$add_stats = $add_stats.'Agility <input name="agi" type="text" size="5" maxlength="5"><br>';
$add_stats = $add_stats.'Vitality <input name="vit" type="text" size="5" maxlength="5"><br>';
$add_stats = $add_stats.'Energy <input name="ene" type="text" size="5" maxlength="5"><br>';
if($info[1] >= 64 && $info[1] <= 79){$add_stats = $add_stats.'Command <input name="com" type="text" size="5" maxlength="5"><br>';}

if($mmw[mix_cs_memb_reset]=="yes" && $cs_row[0]==$guildm[0]) {$edited_res_money = $mmw['reset_money'] - ($cs_memb_reset_zen * 1000000);}
else {$edited_res_money = $mmw['reset_money'];}
if($mmw[reset_system]=='yes') {$resetzen = $edited_res_money * ($info[10] + 1);}
else {$resetzen = $edited_res_money;}
if($mmw[reset_limit_price] != '0' && $mmw[reset_limit_price] <= $resetzen) {$resetzen = $mmw[reset_limit_price];}

if($info[9] < $reset_level) {$reset = mmw_lang_need." $reset_level ".mmw_lang_level.'!';}
elseif( $all_money < $resetzen) {$reset = mmw_lang_need.' '.zen_format($resetzen).' Zen!';}
else {$reset = "<form action='' method='post' name='reset'>".mmw_lang_price.': '.zen_format($resetzen)." Zen! $cs_memb_reset_proc <br><input name='reset_char' type='hidden' value='$char_set'><input type='submit' name='Submit' value='".mmw_lang_reset."'></form>";}

if($info[11] <= 0) {$addpoint = mmw_lang_no_up_point_found;}
elseif($info[11] >= 1) {$addpoint = "<form action='' method='post' name='stats'>".mmw_lang_you_have.": $info[11]<br><input name='stats_char' type='hidden' value='$char_set'> $add_stats <input type='submit' name='Submit' value='".mmw_lang_add_point."'></form>";}

if($all_money < $mmw['pkmoney']) {$pkclear = mmw_lang_need.' '.zen_format($mmw['pkmoney'])." Zen!";}
elseif($info[13] <= 3) {$pkclear = mmw_lang_no_pk_status_found;}
elseif($info[13] > 3) {$pkclear = "<form action='' method='post' name='clearpk'>".mmw_lang_price.': '.zen_format($mmw['pkmoney'])." Zen!<br><input name='clearpk_char' type='hidden' value='$char_set'><input type='submit' name='Submit' value='".mmw_lang_pk_clear."'></form>";}

if($info[9] < 6) {$move = mmw_lang_need_6_level;}
elseif($all_money < $mmw['move_zen']) {$move = mmw_lang_need.' '.zen_format($mmw['move_zen']).' Zen!';}
else {$move="<form action='' method='post' name='move'>".mmw_lang_price.': '.zen_format($mmw['move_zen'])." Zen!<br><input name='move_char' type='hidden' value='$char_set'>$locations<br><input type='submit' name='Submit' value='".mmw_lang_move."'></form>";}


if($mmw[change_class] == 'yes') {
	include("includes/change_class.php");
	$change_class_form = '<select name="class" style="width:76px" size="1"><option value="class">'.mmw_lang_select_class.'</option>';
	for($i=0; $i < count($class_list); ++$i) {
		$change_class_form .= "<option value='$i'>".char_class($class_list[$i][0])." - ".zen_format($class_list[$i][1])." Zen</option>\n";
	}
	$change_class_form .= '</select>';
	$change_class = "<form action='' method='post' name='change_class'>".mmw_lang_class_price."<br><input name='change_class_char' type='hidden' value='$char_set'>$change_class_form<br><input type='submit' name='Submit' value='".mmw_lang_change."'></form>";
}
?>

      <table border="0" cellpadding="0" cellspacing="0" align="center">
       <tr>
	<td valign="top">
	<table width="240" class="sort-table" cellpadding="0" cellspacing="0">
          <tr>
            <td align="right"><?echo mmw_lang_character;?>:</td>
            <td><span class="level<?echo $info[17];?>"><?echo $char_set;?></span></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_status;?>:</td>
            <td><?echo ctlcode($info[17]);?></td>
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
            <td align="right"><?echo mmw_lang_experience;?>:</td>
            <td><?echo $info[16];?></td>
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
            <td align="right"><?echo mmw_lang_up_point;?>:</td>
            <td><?echo $info[11];?></td>
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
            <td align="right">Zen:</td>
            <td><?echo number_format($info[14]);?></td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_kills;?>:</td>
            <td><?echo $info[12];?> (<?echo pkstatus($info[13]);?>)</td>
          </tr>
          <tr>
            <td align="right"><?echo mmw_lang_map_name;?>:</td>
            <td><?echo map($info[8]);?></td>
          </tr>
	</table>
	</td>
	<td valign="top" align="center" style="padding-left:2px;">
		<?echo "<img src='".default_img(char_class($info[1],img))."' title='".char_class($info[1],full)."'>";?><br><br>
		<?if($mmw[reset] == 'yes') {?>
		<div class="div-menu-out" onclick="expandit('menu_1')" onmouseover="tclass=this.className;this.className='div-menu-over';" onmouseout="this.className=tclass;"><?echo mmw_lang_reset;?></div>
		<div id="menu_1" style="display:none;padding-bottom:4px;"><?echo $reset;?></div><?}?>
		<?if($mmw[add_point] == 'yes') {?>
		<div class="div-menu-out" onclick="expandit('menu_2')" onmouseover="tclass=this.className;this.className='div-menu-over';" onmouseout="this.className=tclass;"><?echo mmw_lang_add_point;?></div>
		<div id="menu_2" style="display:none;padding-bottom:4px;"><?echo $addpoint;?></div><?}?>
		<?if($mmw[pk_clear] == 'yes') {?>
		<div class="div-menu-out" onclick="expandit('menu_3')" onmouseover="tclass=this.className;this.className='div-menu-over';" onmouseout="this.className=tclass;"><?echo mmw_lang_pk_clear;?></div>
		<div id="menu_3" style="display:none;padding-bottom:4px;"><?echo $pkclear;?></div><?}?>
		<?if($mmw[move] == 'yes') {?>
		<div class="div-menu-out" onclick="expandit('menu_4')" onmouseover="tclass=this.className;this.className='div-menu-over';" onmouseout="this.className=tclass;"><?echo mmw_lang_move;?></div>
		<div id="menu_4" style="display:none;padding-bottom:4px;"><?echo $move;?></div><?}?>
		<?if($mmw[change_class] == 'yes') {?>
		<div class="div-menu-out" onclick="expandit('menu_5')" onmouseover="tclass=this.className;this.className='div-menu-over';" onmouseout="this.className=tclass;"><?echo mmw_lang_change_class;?></div>
		<div id="menu_5" style="display:none;padding-bottom:4px;"><?echo $change_class;?></div><?}?>
	</td>
       </tr>
      </table>

<?}elseif($acc_online_check=="1"){echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;}else{echo "$die_start I find you Hacker! :) $die_end";}?>