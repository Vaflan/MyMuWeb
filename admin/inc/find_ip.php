<?PHP
$search_ip = clean_var(stripslashes($_POST['ip']));
$search_acc = clean_var(stripslashes($_POST['acc']));
$search_char = clean_var(stripslashes($_POST['char']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($search_type == 1) {
 if(!empty($search_ip)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where ip like '%$search_ip%'");}
 elseif(!empty($search_acc)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where memb___id like '%$search_acc%'");}
 else {$result = mssql_query("SELECT accountid,name from Character where name like '%$search_char%'");}
}
else {
 if(!empty($search_ip)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where ip='$search_ip'");}
 elseif(!empty($search_acc)) {$result = mssql_query("SELECT memb___id from MEMB_STAT where memb___id='$search_acc'");}
 else {$result = mssql_query("SELECT accountid,name from Character where name='$search_char'");}
}

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Character</td>
<td align="left">Account</td>
<td align="left">IP</td>
<td align="left">Date Connect</td>
<td align="center">Status</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);$i++) {
$row = mssql_fetch_row($result);
$rank = $i+1;

if(!empty($search_char)) {
 $get_char_name = $row[1];
}
else {
 $get_char_result = mssql_query("Select GameIDC from AccountCharacter where Id='$row[0]'");
 $get_char_done = mssql_fetch_row($get_char_result);
 $get_char_name = $get_char_done[0];
}

$get_ip_result = mssql_query("Select ip,CONNECTTM,ConnectStat from MEMB_STAT where memb___id='$row[0]'");
$get_ip_done = mssql_fetch_row($get_ip_result);

if($get_ip_done[0] == NULL){$get_ip_done[0] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #120</font></td></tr></table>";}
if($get_ip_done[2] == 0){$get_ip_done[2] ='<img src=images/Offline.gif>';}
if($get_ip_done[2] == 1){$get_ip_done[2] ='<img src=images/Online.gif>';}

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$get_char_name</td>
<td align='left'>$row[0]</td>
<td align='left'>$get_ip_done[0]</td>
<td align='left'>".time_format($get_ip_done[1],"d.m.Y H:i")."</td>
<td align='center'>$get_ip_done[2]</td>
</tr>";
}?>
</table>