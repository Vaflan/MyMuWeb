<?PHP
$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,display_order,type from MMW_servers order by display_order asc");

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Name</td>
<td align="left">Version</td>
<td align="left">Experience</td>
<td align="left">Drops</td>
<td align="left">Type</td>
<td align="left">Status</td>
<td align="center">Edit</td>
<td align="center">Delete</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;
if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.3)) { 
	fclose($check); 
	$status_done = '<span class="online"><b>Online</b></span>'; 
}
else {
	$status_done = '<span class="offline"><b>Offline</b></span>'; 
} 

$server_table_edit = "<form action='' method='post' name='edit_server' id='edit_server'>
	<input name='Edit' type='submit' id='Edit' value='Edit'>
	<input name=server_name_edit type=hidden id=server_name_edit value='$row[0]'>
</form>";

$server_table_delete = "<form action='' method='post' name='delete_server' id='delete_server'>
	<input name='Delete' type='submit' id='Delete' value='Delete' class='button' onclick='return ask_delete_server()'>
	<input name=server_name_delete type=hidden id=server_name_delete value='$row[0]'>
</form>";

echo "<tr>
<td align='center'>$row[6].</td>
<td align='left'>$row[0]</td>
<td align='left'>$row[5]</td>
<td align='left'>$row[1]</td>
<td align='left'>$row[2]</td>
<td align='left'>$row[7]</td>
<td align='left'>$status_done</td>
<td align='center'>$server_table_edit</td>
<td align='center'>$server_table_delete</td>
</tr>";
}
?>
</table>