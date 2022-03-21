<?PHP
if($mmw[castle_siege] == 'yes') {
 if($_SESSION[castle_kesh][timeout] + $mmw[server_timeout] < time()) {
  if($check=@fsockopen($mmw[gs_cs_ip],$mmw[gs_cs_port],$ERROR_NO,$ERROR_STR,(float)0.3)) {fclose($check); $_SESSION[castle_kesh][status] = 1;}
  else {$_SESSION[castle_kesh][status] = 0;}
  $_SESSION[castle_kesh][timeout] = time();
 }
 if($_SESSION[castle_kesh][status]==1) {$cs_status = '<span class="online">'.mmw_lang_is_opened.'</span>';}
 else {$cs_status = '<span class="offline">'.mmw_lang_is_closed.'</span>';}

 $query = mssql_query("SELECT owner_guild,siege_start_date,siege_end_date,money,tax_hunt_zone FROM MuCastle_DATA");
 $row = mssql_fetch_row($query);
 $cs_guild_row = mssql_fetch_row( mssql_query("SELECT g_master,g_mark FROM Guild WHERE G_Name='$row[0]'") );
 if($row[0]!="" && $row[0]!=" ") {
  $cs_guild = "<a href='?op=guild&guild=$row[0]'>$row[0]</a>";
  $cs_guild_master = "<a href='?op=character&character=$cs_guild_row[0]'>$cs_guild_row[0]</a>";
  $logo = urlencode(bin2hex($cs_guild_row[1]));
  $cs_guild_mark = "<a class='helpLink' href='javascript://' title='<img src=decode.php?decode=$logo height=60 width=60>'><img src='decode.php?decode=$logo' height='10' width='10' broder='0'></a>";
 }
 else {
  $cs_guild = "None";
  $cs_guild_master = "None";
 }

 if($mmw[mix_cs_memb_reset]=="yes") {
  if($mmw[max_zen_cs_reset]>$row[3]) {$edited_zen_cs = $row[3];}
  else{$edited_zen_cs = $mmw[max_zen_cs_reset];}
  $cs_memb_reset_zen = ( substr($mmw['resetmoney'], 0, -6) * ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ) ) / 100;
  $cs_memb_reset_proc = ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] );
 }

 // LoaD MuCastleData.dat
 server_file($mmw[mu_castle_data],1,1);
 $mucastledata = $_SESSION[server_file][$mmw[mu_castle_data]][1];

 function week2str($num) {
  if($num[1]==0) {$result=mmw_lang_week_mon;}
  if($num[1]==1) {$result=mmw_lang_week_tue;}
  if($num[1]==2) {$result=mmw_lang_week_wed;}
  if($num[1]==3) {$result=mmw_lang_week_thu;}
  if($num[1]==4) {$result=mmw_lang_week_fri;}
  if($num[1]==5) {$result=mmw_lang_week_sat;}
  if($num[1]==6) {$result=mmw_lang_week_sun;}
  echo $result;
 }
 function array2time($array) {
  if($array[2]<9 && strlen($array[2])<2) {$array[2] = "0$array[2]";}  
  if($array[3]<9 && strlen($array[3])<2) {$array[3] = "0$array[3]";}
  echo "$array[2]:$array[3]";
 }
 function array2sec($array) {
  $result = ($array[1]*24*60*60) + ($array[2]*60*60) + ($array[3]*60);
  return $result;
 }

 $now_time = time();
 $cs_start = time_format($row[1],"d M Y");
 $cs_end = time_format($row[2],"d M Y");
 if(strtotime($cs_start)+array2sec($mucastledata[2]) > $now_time) {$cs_period = mmw_lang_register_for_attack;}
 elseif(strtotime($cs_start)+array2sec($mucastledata[4]) > $now_time) {$cs_period = mmw_lang_sing_of_lord;}
 elseif(strtotime($cs_start)+array2sec($mucastledata[6]) > $now_time) {$cs_period = mmw_lang_information;}
 elseif(strtotime($cs_start)+array2sec($mucastledata[7]) > $now_time) {$cs_period = mmw_lang_ready_for_attack;}
 elseif(strtotime($cs_start)+array2sec($mucastledata[8]) > $now_time) {$cs_period = mmw_lang_attack_castle_siege;}
 else {$cs_period = 'Truce';}
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
<td valign="top">

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='90%'> 
	<tr>
          <td width="118">Castle Siege:</td>
          <td><?echo $cs_status;?></td>
	</tr>          
	<tr>
          <td><?echo mmw_lang_owner_guild;?>:</td>
          <td><?echo $cs_guild_mark;?> <?echo $cs_guild;?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_king_of_castle;?>:</td>
          <td><?echo $cs_guild_master;?></td>
	</tr>
	<?if($mmw[mix_cs_memb_reset]=="yes") {?><tr>
          <td><?echo mmw_lang_reset_for_members;?>:</td>
          <td>-<?echo $cs_memb_reset_proc;?>% (<?echo $cs_memb_reset_zen;?>kk Zen)</td>
	</tr><?}?>
	<tr>
          <td><?echo mmw_lang_tax_hunt_zone;?>:</td>
          <td><?echo number_format($row[4]);?> Zen</td>
	</tr>
	<tr>
          <td><?echo mmw_lang_start_siege;?>:</td>
          <td><?echo $cs_start;?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_next_siege;?>:</td>
          <td><?echo $cs_end;?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_now_period;?>:</td>
          <td><?echo $cs_period;?></td>
	</tr>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='90%'>           
	<tr>
          <td width="118"><?echo mmw_lang_register_for_attack;?>:</td>
          <td><?week2str($mucastledata[1]);?>.<?array2time($mucastledata[1]);?> - <?week2str($mucastledata[2]);?>.<?array2time($mucastledata[2]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_sing_of_lord;?>:</td>
          <td><?week2str($mucastledata[3]);?>.<?array2time($mucastledata[3]);?> - <?week2str($mucastledata[4]);?>.<?array2time($mucastledata[4]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_information;?>:</td>
          <td><?week2str($mucastledata[5]);?>.<?array2time($mucastledata[5]);?> - <?week2str($mucastledata[6]);?>.<?array2time($mucastledata[6]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_ready_for_attack;?>:</td>
          <td><?week2str($mucastledata[6]);?>.<?array2time($mucastledata[6]);?> - <?week2str($mucastledata[7]);?>.<?array2time($mucastledata[7]);?></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_attack_castle_siege;?>:</td>
          <td><?week2str($mucastledata[7]);?>.<?array2time($mucastledata[7]);?> - <?week2str($mucastledata[8]);?>.<?array2time($mucastledata[8]);?></td>
	</tr>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='90%'>           
	<tr><td><?echo mmw_lang_registered_guilds_for_attack;?></td></tr>
<?
$cs_reg_query = mssql_query("SELECT SEQ_NUM,REG_SIEGE_GUILD,REG_MARKS,IS_GIVEUP FROM MuCastle_REG_SIEGE ORDER BY SEQ_NUM DESC"); 
$cs_reg_num = mssql_num_rows($cs_reg_query);
if($cs_reg_num>0) {
 for ($i=0; $i<$cs_reg_num; ++$i) {
  $cs_row_reg = mssql_fetch_row($cs_reg_query);
  echo "<tr><td>$cs_row_reg[0]. <a href=?op=guild&guild=$cs_row_reg[1]>$cs_row_reg[1]</a> (Sing of Lord: $cs_row_reg[2])</td></tr>";
 }
}
else {echo "<tr><td>".mmw_lang_no_guilds."</td></tr>";}?>
</table>

</td>
<td width="200" align="right" valign="top">
<img src="<?echo default_img("castlesiege.png");?>" title="Castle Siege">
</td>
</tr></table>
<?
}
else {
	echo '<center><b>' . mmw_lang_is_closed . '</b></center>';
}?>