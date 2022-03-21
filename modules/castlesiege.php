<?PHP
if($mmw[castle_siege] == 'yes') {
if($check=@fsockopen($mmw[gs_cs_ip],$mmw[gs_cs_port],$ERROR_NO,$ERROR_STR,(float)0.3)){fclose($check); $cs_status = '<span class="online">'.mmw_lang_is_opened.'</span>';}
else{$cs_status = '<span class="offline">'.mmw_lang_is_closed.'</span>';}

$query = mssql_query("SELECT owner_guild,siege_start_date,siege_end_date,money,tax_hunt_zone FROM MuCastle_DATA");
$row = mssql_fetch_row($query);
$cs_guild_row = mssql_fetch_row( mssql_query("SELECT g_master,g_mark FROM Guild WHERE G_Name='$row[0]'") );
if($row[0]!="" && $row[0]!=" ") {
	$cs_guild = $row[0];
	$cs_guild_master = $cs_guild_row[0];
	$logo = urlencode(bin2hex($cs_guild_row[1]));
	$cs_guild_mark = "<a class='helpLink' href='javascript://' title='<img src=decode.php?decode=$logo height=60 width=60>'><img src='decode.php?decode=$logo' height='10' width='10' broder='0'></a>";
}
else {
	$cs_guild = "None";
	$cs_guild_master = "None";
}

if($mmw[mix_cs_memb_reset]=="yes") {
if($mmw[max_zen_cs_reset]>$row[3]){$edited_zen_cs = $row[3];} else{$edited_zen_cs = $mmw[max_zen_cs_reset];}
$cs_memb_reset_zen = ( substr($mmw['resetmoney'], 0, -6) * ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] ) ) / 100;
$cs_memb_reset_proc = ceil( substr($edited_zen_cs, 0, -6) / $mmw[num_for_mix_cs_reset] );
}

$now_time = time();
$cs_start = time_format($row[1],"d M Y");
$cs_end = time_format($row[2],"d M Y");
if( strtotime($cs_start)+86400 > $now_time ) {$cs_period = mmw_lang_register_for_attack;} //0 00:00 - 0 23:59
elseif( (strtotime($cs_start)+432000) > $now_time ) {$cs_period = mmw_lang_sing_of_lord;} //1 00:00 - 4 23:59
elseif( (strtotime($cs_start)+500400) > $now_time ) {$cs_period = mmw_lang_information;} //5 00:00 - 5 19:00
elseif( (strtotime($cs_start)+586800) > $now_time ) {$cs_period = mmw_lang_ready_for_attack;} //5 19:00 - 6 19:00
elseif( (strtotime($cs_start)+594000) > $now_time ) {$cs_period = mmw_lang_attack_castle_siege;} //6 19:00 - 6 21:00
else {$cs_period="Truce";}
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
<td valign="top">

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='276'> 
	<tr>
          <td width="118">Castle Siege:</td>
          <td><?echo $cs_status;?></td>
	</tr>          
	<tr>
          <td><?echo mmw_lang_owner_guild;?>:</td>
          <td><?echo $cs_guild_mark;?> <a href="?op=guild&guild=<?echo $cs_guild;?>"><?echo $cs_guild;?></a></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_king_of_castle;?>:</td>
          <td><a href="?op=character&character=<?echo $cs_guild_master;?>"><?echo $cs_guild_master;?></a></td>
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

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='276'>           
	<tr>
          <td width="118"><?echo mmw_lang_register_for_attack;?>:</td>
          <td><?echo mmw_lang_week_mon;?>.00:00 - <?echo mmw_lang_week_mon;?>.23:59</td>
	</tr>
	<tr>
          <td><?echo mmw_lang_sing_of_lord;?>:</td>
          <td><?echo mmw_lang_week_tue;?>.00:00 - <?echo mmw_lang_week_fri;?>.23:59</td>
	</tr>
	<tr>
          <td><?echo mmw_lang_information;?>:</td>
          <td><?echo mmw_lang_week_sat;?>.00:00 - <?echo mmw_lang_week_sat;?>.19:00</td>
	</tr>
	<tr>
          <td><?echo mmw_lang_ready_for_attack;?>:</td>
          <td><?echo mmw_lang_week_sat;?>.19:00 - <?echo mmw_lang_week_sun;?>.19:00</td>
	</tr>
	<tr>
          <td><?echo mmw_lang_attack_castle_siege;?>:</td>
          <td><?echo mmw_lang_week_sun;?>.19:00 - <?echo mmw_lang_week_sun;?>.21:00</td>
	</tr>
</table>

<?echo $rowbr;?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='276'>           
	<tr><td><?echo mmw_lang_registered_guilds_for_attack;?></td></tr>
<?
$cs_reg_query = mssql_query("SELECT SEQ_NUM,REG_SIEGE_GUILD,REG_MARKS,IS_GIVEUP FROM MuCastle_REG_SIEGE ORDER BY SEQ_NUM DESC"); 
$cs_reg_num = mssql_num_rows($cs_reg_query);
if($cs_reg_num > 0){
 for ($i=0; $i < $cs_reg_num; ++$i) {
 $cs_row_reg = mssql_fetch_row($cs_reg_query);
 echo "<tr><td>$cs_row_reg[0]. <a href=?op=guild&guild=$cs_row_reg[1]>$cs_row_reg[1]</a> (Sing of Lord: $cs_row_reg[2])</td></tr>";
 }
}
else {echo "<tr><td>".mmw_lang_no_guilds."</td></tr>";}?>
</table>

</td>
<td width="200" align="right" valign="top">
<img src="images/castlesiege.png" alt="Castle Siege">
</td>
</tr></table>
<?
}
else {
	echo '<center><b>' . mmw_lang_is_closed . '</b></center>';
}?>