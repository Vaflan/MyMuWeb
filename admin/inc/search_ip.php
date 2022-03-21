<?PHP
require('config.php');

$search = stripslashes($_POST['ip_search']);
$search_type = stripslashes($_POST['search_type']);

if($_POST['search_type']==0){$result = mssql_query("SELECT accountid,ctlcode,name from Character where name='$search'");}
if($_POST['search_type']==1){$result = mssql_query("SELECT accountid,ctlcode,name from Character where name like '%$search%'");}

echo '
<br><span class=normal_text>Search Character ip Results</span><br><br>
<table class="sort-table" id="table-1" height="30" border="0" cellpadding="0" cellspacing="0">                
<thead><tr>
<td>#</td>
<td>Name</td>
<td>Account</td>
<td>IP</td>
<td>Mode</td>
<td>Date Connect</td>
<td>Status</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;

$get_ip_exec = mssql_query("Select ip,CONNECTTM,ConnectStat from MEMB_STAT where memb___id='$row[0]'");
$get_ip_done = mssql_fetch_row($get_ip_exec);

if($row[1] == 1){$row[1] = "<table><tr><td bgcolor='yellow'><font color='#000000' size='1'>Blocked</font></td></tr></table>";}
elseif($row[1] == 32 || $row[1] == 8){$row[1] = "<table><tr><td bgcolor='blue'><font color='#FFFFFF' size='1'>GM</font></td></tr></table>";}
elseif($row[1] == 0){$row[1] = "Normal";}

if($get_ip_done[0] == NULL){$get_ip_done[0] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #120</font></td></tr></table>";}
if($get_ip_done[2] == 0){$get_ip_done[2] ='<img src=images/Offline.gif>';}
if($get_ip_done[2] == 1){$get_ip_done[2] ='<img src=images/Online.gif>';}

echo "<tbody><tr>
<td align=left class=text_statistics>$rank</td>
<td align=left class=text_statistics>$row[2]</td>
<td align=left class=text_statistics>$row[0]</td>
<td align=left class=text_statistics>$get_ip_done[0]</td>
<td align=left class=text_statistics>$row[1]</td>
<td align=left class=text_statistics>$get_ip_done[1]</td>
<td align=left class=text_statistics>$get_ip_done[2]</td>
</tr></tbody>";
}?>
</table>