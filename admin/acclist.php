<?if(isset($_POST["delete_acc"])) {delete_acc($_POST['account']);}?>

<table width="660" border="0" align="center" cellpadding="0" cellspacing="4">
<tr>
<td align="center">
<fieldset>
<legend>Account List</legend>

<table class="sort-table" id="table-1" width="100%" border="0" cellpadding="0" cellspacing="0">                
<thead><tr>
<td>#</td>
<td>Account</td>
<td>Mode</td>
<td>Reg Date</td>
<td>Login Date</td>
<td>Char</td>
<td>Status</td>
<td>Delete</td>
</tr></thead>

<?
$result = mssql_query("SELECT memb___id,bloc_code,appl_days,date_online,country from MEMB_INFO ORDER BY appl_days ASC");

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[0]'");
$status_check = mssql_num_rows($status_reults);
$status = mssql_fetch_row($status_reults);

if($status[0] == 0){ $status[0] ='<img src=images/offline.gif>';}
if($status[0] == 1){ $status[0] ='<img src=images/online.gif>';}
if($status_check == 0){ $status[0] ='<img src=images/death.gif>';}
if($row[1] == 0){$row[1] ='Normal';}
if($row[1] == 1){$row[1] ="<table><tr><td bgcolor='yellow'><font color='#000000' size='1'>Blocked</font></td></tr></table>";}
if($row[1] == NuLL){$row[1] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #111</font></td></tr></table>";}
if($row[2] == NULL){$row[2] = "<table><tr><td bgcolor='FF0000'><font color='#FFFFFF' size='1'>Error #112</font></td></tr></table>";}
$rank = $i+1;

$acctinfo = mssql_query("Select Name from Character where AccountID='$row[0]'");
$char_numb = mssql_num_rows($acctinfo);

$table_delete = "<table width='60' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='delete_acc' id='delete_acc'>
      <input name='Delete' type='submit' id='Delete' value='Delete' class='button'>
      <input name='account' type='hidden' id='account' value='$row[0]'>
      <input name='delete_acc' type='hidden' id='delete_acc' value='$row[0]'>
    </form></td>
  </tr>
</table>";

echo "<tbody><tr>
<td class=text_statistics>$rank</td>
<td class=text_statistics><a href=?op=acc&acc=$row[0]>$row[0]</a></td>
<td class=text_statistics>$row[1]</td>
<td class=text_statistics>".time_format($row[2],"d.m.Y H:i")."</td>
<td class=text_statistics>".date("d.m.Y H:i",$row[3])."</td>
<td class=text_statistics>$char_numb</td>
<td class=text_statistics>$status[0]</td>
<td class=text_statistics>$table_delete</td>
</tr></tbody>";
}
?>
</table>

</fieldset>
</td></tr>
</table>