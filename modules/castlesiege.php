<?
if($check=@fsockopen($mmw[gs_cs_ip],$mmw[gs_cs_port],$ERROR_NO,$ERROR_STR,(float)0.5)){fclose($check); $cs_status = '<span class="online">Open</span>';}
else{$cs_status = '<span class="offline">Close</span>';}

$query = mssql_query("SELECT owner_guild,siege_start_date,siege_end_date,money,tax_hunt_zone FROM MuCastle_DATA");
$row = mssql_fetch_row($query);
$cs_guild_row = mssql_fetch_row( mssql_query("SELECT g_master,g_mark FROM Guild WHERE G_Name='$row[0]'") );
if($row[0]!="" && $row[0]!=" ") {
	$cs_guild = $row[0];
	$cs_guild_master = $cs_guild_row[0];
	$logo = urlencode(bin2hex($cs_guild_row[1]));
	$cs_guild_mark = "<a class='helpLink' href='#' onclick=\"showHelpTip(event,'<img src=decode.php?decode=$logo height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height='10' width='10' broder='0'></a>";
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
if( strtotime($cs_start)+86400 > $now_time ) {$cs_period="Register for Attack";} //0 00:00 - 0 23:59
elseif( (strtotime($cs_start)+432000) > $now_time ) {$cs_period="Sing of Lord";} //1 00:00 - 4 23:59
elseif( (strtotime($cs_start)+500400) > $now_time ) {$cs_period="Information";} //5 00:00 - 5 19:00
elseif( (strtotime($cs_start)+586800) > $now_time ) {$cs_period="Ready for Attack";} //5 19:00 - 6 19:00
elseif( (strtotime($cs_start)+594000) > $now_time ) {$cs_period="Attack to Castle Siege";} //6 19:00 - 6 21:00
else {$cs_period="Truce";}
?>

<div class="brdiv"></div>

<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
<td valign="top">

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='250'> 
	<tr>
          <td width="100">Castle Siege:</td>
          <td><?echo $cs_status;?></td>
	</tr>          
	<tr>
          <td width="100">Owner Guild:</td>
          <td><?echo $cs_guild_mark;?> <a href="?op=guild&guild=<?echo $cs_guild;?>"><?echo $cs_guild;?></a></td>
	</tr>
	<tr>
          <td>King of Castle:</td>
          <td><a href="?op=character&character=<?echo $cs_guild_master;?>"><?echo $cs_guild_master;?></a></td>
	</tr>
	<?if($mmw[mix_cs_memb_reset]=="yes") {?><tr>
          <td>Reset for Member's:</td>
          <td>-<?echo $cs_memb_reset_proc;?>% (<?echo $cs_memb_reset_zen;?>kk Zen)</td>
	</tr><?}?>
	<tr>
          <td>Tax Hunt Zone:</td>
          <td><?echo number_format($row[4]);?> Zen</td>
	</tr>
	<tr>
          <td>Start Siege:</td>
          <td><?echo $cs_start;?></td>
	</tr>
	<tr>
          <td>End Siege:</td>
          <td><?echo $cs_end;?></td>
	</tr>
	<tr>
          <td>Now Period:</td>
          <td><?echo $cs_period;?></td>
	</tr>
</table>

<div class="brdiv"></div>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='250'>           
	<tr>
          <td width="100">Register for Attack:</td>
          <td>Mon. 00:00 - Mon. 23:59</td>
	</tr>
	<tr>
          <td>Sing of Lord:</td>
          <td>Tue. 00:00 - Fri. 23:59</td>
	</tr>
	<tr>
          <td>Information:</td>
          <td>Sat. 00:00 - Sat. 19:00</td>
	</tr>
	<tr>
          <td>Ready for Attack:</td>
          <td>Sat. 19:00 - Sun. 19:00</td>
	</tr>
	<tr>
          <td>Attack Castle Siege:</td>
          <td>Sun. 19:00 - Sun. 21:00</td>
	</tr>
</table>

<div class="brdiv"></div>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='250'>           
	<tr><td>Guild's Registered for Attack</td></tr>
<?
$cs_reg_query = mssql_query("SELECT SEQ_NUM,REG_SIEGE_GUILD,REG_MARKS,IS_GIVEUP FROM MuCastle_REG_SIEGE ORDER BY SEQ_NUM DESC"); 
$cs_reg_num = mssql_num_rows($cs_reg_query);
if($cs_reg_num > 0){
 for ($i=0; $i < $cs_reg_num; ++$i) {
 $cs_row_reg = mssql_fetch_row($cs_reg_query);
 echo "<tr><td>$cs_row_reg[0]. <a href=?op=guild&guild=$cs_row_reg[1]>$cs_row_reg[1]</a> (Sing of Lord: $cs_row_reg[2])</td></tr>";
 }
}
else {?><tr><td>No Guild's</td></tr><?}?>
</table>

</td>
<td width="200" align="right" valign="top">
<img src="images/castlesiege.png" alt="Castle Siege">
</td>
</tr></table>