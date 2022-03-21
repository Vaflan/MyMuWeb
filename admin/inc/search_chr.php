<?PHP
$search = clean_var(stripslashes($_POST['character_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==0){$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid,ctlcode from Character where name='$search'");}
if($_POST['search_type']==1){$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid,ctlcode  from Character where name like '%$search%'");}

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Name</td>
<td align="left">Account</td>
<td align="left">Level</td>
<td align="left">Resets</td>
<td align="left">Class</td>
<td align="center">Status</td>
<td align="center">Edit</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;

$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[8]'");
$status = mssql_fetch_row($status_reults);

if($status[0] == 0){$status[0] ='<img src=images/offline.gif>';}
if($status[0] == 1){$status[0] ='<img src=images/online.gif>';}

if($row[9] == 1){$row[9] = "<table><tr><td bgcolor='yellow'><font color='#000000' size='1'>Blocked</font></td></tr></table>";}
elseif($row[9] == 32 || $row[9] == 8){$row[9] = "<table><tr><td bgcolor='blue'><font color='#FFFFFF' size='1'>GM</font></td></tr></table>";}
elseif($row[9] == 0){$row[9] = "Normal";}

if($_SESSION[a_admin_level] > 3) {
$character_table_edit = "<form action='' method='post' name='character_edit' id='character_edit'>
	<input name='Edit' type='submit' id='Edit' value='Edit'>
	<input name='character_search_edit' type='hidden' id='character_search_edit' value='$row[0]'>
</form>";
}
else {
$character_table_edit = "Can't";
}

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$row[0]</td>
<td align='left'><a href='?op=acc&acc=$row[8]'>$row[8]</a></td>
<td align='left'>$row[2]</td>
<td align='left'>$row[3]</td>
<td align='left'>".char_class($row[1])."</td>
<td align='center'>$status[0]</td>
<td align='center'>$character_table_edit</td>
</tr>";
}?>
</table>