<?PHP
$search = stripslashes($_POST['character_search']);
$search_type = stripslashes($_POST['search_type']);

if($_POST['search_type']==0){$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid,ctlcode from Character where name='$search'");}
if($_POST['search_type']==1){$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid,ctlcode  from Character where name like '%$search%'");}

echo '
<br><span class=normal_text>Search Character Results</span><br><br>
<table class="sort-table" id="table-1" height="30" border="0" cellpadding="0" cellspacing="0">                
<thead><tr>
<td>#</td>
<td>Name</td>
<td>Account</td>
<td>Level</td>
<td>Resets</td>
<td>Class</td>
<td>Mode</td>
<td>Status</td>
<td>Edit</td>
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

if($row[1] == 0){$row[1] ='DW';}
if($row[1] == 1){$row[1] ='SM';}
if($row[1] == 16){$row[1] ='DK';}
if($row[1] == 17){$row[1] ='BK';}
if($row[1] == 32){$row[1] ='ELF';}
if($row[1] == 33){$row[1] ='ME';}
if($row[1] == 48){$row[1] ='MG';}
if($row[1] == 64){$row[1] ='DL';}

if($_SESSION[a_admin_level] > 3) {
$character_table_edit = "<table width='40' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='character_edit' id='character_edit'>
      <input name='Edit' type='submit' id='Edit' value='Edit' class='button'>
      <input name='character_search_edit' type='hidden' id='character_search_edit' value=$row[0]>
    </form></td>
  </tr>
</table>";
}
else {
$character_table_edit = "Can't";
}

echo "<tbody><tr>
<td align=left class=text_statistics>$rank</td>
<td align=left class=text_statistics>$row[0]</td>
<td align=left class=text_statistics><a href='?op=acc&acc=$row[8]'>$row[8]</a></td>
<td align=left class=text_statistics>$row[2]</td>
<td align=left class=text_statistics>$row[3]</td>
<td align=left class=text_statistics>$row[1]</td>
<td align=left class=text_statistics>$row[9]</td>
<td align=left class=text_statistics>$status[0]</td>
<td align=left class=text_statistics>$character_table_edit</td>
</tr></tbody>";
}?>
</table>