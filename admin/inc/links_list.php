<?PHP
$result = mssql_query("SELECT link_name,link_address,link_description,link_id,link_date from MMW_links order by link_date desc");

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td aling="center">#</td>
<td aling="left">Name</td>
<td aling="left">Address</td>
<td aling="left">Description</td>
<td aling="left">Date</td>
<td aling="center">Edit</td>
<td aling="center">Delete</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;
$table_edit = "<form action='' method='post' name='edit_link' id='edit_link'>
	<input name='Edit' type='submit' id='Edit' value='Edit'>
	<input name='edit_link' type='hidden' id='edit_link' value='$row[3]'>
</form>";

$table_delete = "<form action='' method='post' name='delete_link' id='delete_link'>
	<input name='Delete' type='submit' id='Delete' value='Delete'>
	<input name='delete_link' type='hidden' id='delete_link' value='$row[3]'>
</form>";

$row[0] = substr($row[0],0,8);
$row[1] = substr($row[1],0,14);
$row[2] = substr($row[2],0,14);

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$row[0]...</td>
<td align='left'>$row[1]...</td>
<td align='left'>$row[2]...</td>
<td align='left'>$row[4]</td>
<td align='center'>$table_edit</td>
<td align='center'>$table_delete</td>
</tr>";
}
?>
</table>