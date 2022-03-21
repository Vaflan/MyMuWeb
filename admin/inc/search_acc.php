<?PHP
$search = clean_var(stripslashes($_POST['account_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==0){$result = mssql_query("SELECT memb___id,memb__pwd,bloc_code,country,gender from MEMB_INFO where memb___id='$search'");}
if($_POST['search_type']==1){$result = mssql_query("SELECT memb___id,memb__pwd,bloc_code,country,gender from MEMB_INFO where memb___id like '%$search%'");}

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Account</td>
<td align="left">Mode</td>
<td align="left">Country</td>
<td align="left">Gender</td>
<td align="center">Status</td>
<td align="center">Edit</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;

$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[0]'");
$status = mssql_fetch_row($status_reults);

if($status[0] == 0){$status[0] ='<img src=images/offline.gif>';}
if($status[0] == 1){$status[0] ='<img src=images/online.gif>';}

if($row[2] == 0){ $row[2] ='Normal';}
if($row[2] == 1){ $row[2] ="<table><tr><td bgcolor='yellow'><font color='#000000' size='1'>Blocked</font></td></tr></table>";}

if($row[4] == 'male'){$row[4] = "<img src='images/male.gif'>";}
elseif($row[4] == 'female'){$row[4] = "<img src='images/female.gif'>";}
elseif($row[4] == NULL){$row[4] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #113</font></td></tr></table>";}
if($row[3] == NULL){$row[3] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #112</font></td></tr></table>";}
if($row[1] == NuLL){$row[1] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #111</font></td></tr></table>";}

if($row[3] == '0'){$country = "Not Set";}
else{$country = country($row[3]);}

$account_table_edit = "<form action='' method='post' name='account_edit' id='account_edit'>
	<input name='Edit' type='submit' id='Edit' value='Edit'>
	<input name='account_search_edit' type='hidden' id='account_search_edit' value=$row[0]>
</form>";

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$row[0]</td>
<td align='left'>$row[2]</td>
<td align='left'>$country</td>
<td align='left'>$row[4]</td>
<td align='center'>$status[0]</td>
<td align='center'>$account_table_edit</td>
</tr>";
}
?>
</table>