<?PHP
$search = clean_var(stripslashes($_POST['ip_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==0){$result = mssql_query("SELECT accountid,name from Character where name='$search'");}
if($_POST['search_type']==1){$result = mssql_query("SELECT accountid,name from Character where name like '%$search%'");}

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Name</td>
<td align="left">Account</td>
<td align="left">IP</td>
<td align="left">Date Connect</td>
<td align="center">Status</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;

$get_ip_exec = mssql_query("Select ip,CONNECTTM,ConnectStat from MEMB_STAT where memb___id='$row[0]'");
$get_ip_done = mssql_fetch_row($get_ip_exec);

if($get_ip_done[0] == NULL){$get_ip_done[0] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #120</font></td></tr></table>";}
if($get_ip_done[2] == 0){$get_ip_done[2] ='<img src=images/Offline.gif>';}
if($get_ip_done[2] == 1){$get_ip_done[2] ='<img src=images/Online.gif>';}

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$row[1]</td>
<td align='left'>$row[0]</td>
<td align='left'>$get_ip_done[0]</td>
<td align='left'>".time_format($get_ip_done[1],"d.m.Y H:i")."</td>
<td align='center'>$get_ip_done[2]</td>
</tr>";
}?>
</table>