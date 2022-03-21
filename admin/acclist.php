<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Account List + Delete not connected...
if(isset($_POST["delete_acc"])) {
 $account = $_POST["delete_acc"];
 if(empty($account)) {
  echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  $sql_online_check = mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='$account'");
  $check_connect = mssql_num_rows($sql_online_check);
  if($check_connect==0) {
   mssql_query("Delete from MEMB_INFO where memb___id='$account'");
   mssql_query("Delete from VI_CURR_INFO where memb___id='$account'");
   mssql_query("Delete from warehouse where AccountID='$account'");

   echo "$warning_green Account $account SuccessFully Deleted!";
   writelog("a_del_acc","Account $account Has Been <font color=#FF0000>Deleted</font>");
  }
  else {
   echo "$warning_red Account Has Been connected!";
  }
 }
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Account List</legend>

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Account</td>
  <td align="left">Mode</td>
  <td align="left">Reg Date</td>
  <td align="left">Login Date</td>
  <td align="left">Char</td>
  <td align="center">Status</td>
  <td align="center">Delete</td>
 </tr></thead>
<?
$result = mssql_query("SELECT memb___id,bloc_code,appl_days from MEMB_INFO ORDER BY appl_days ASC");
for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $status_reults = mssql_query("Select ConnectStat,ConnectTM from MEMB_STAT where memb___id='$row[0]'");
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

 $table_delete = "<form action='' method='post' name='delete_acc' id='delete_acc'><input name='Delete' type='submit' id='Delete' value='Delete'><input name='delete_acc' type='hidden' id='delete_acc' value='$row[0]'></form>";
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><a href=?op=acc&acc=<?echo $row[0];?>><?echo $row[0];?></a></td>
  <td align='left'><?echo $row[1];?></td>
  <td align='left'><?echo time_format($row[2],"d.m.Y H:i");?></td>
  <td align='left'><?echo time_format($status[1],"d.m.Y H:i");?></td>
  <td align='left'><?echo $char_numb;?></td>
  <td align='center'><?echo $status[0];?></td>
  <td align='center'><?echo $table_delete;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
</table>