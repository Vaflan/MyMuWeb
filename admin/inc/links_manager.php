<?PHP
$result = mssql_query("SELECT link_name,link_address,link_description,link_id,link_date from MMW_links order by link_date desc");

echo '
<fieldset>
<legend>Links List</legend>
<table class="sort-table" id="table-1" border="0" cellpadding="0" cellspacing="0" width="500">  
<thead>
<tr>
<td aling=left>#</td>
<td aling=left>Name</td>
<td aling=left>Address</td>
<td aling=left>Description</td>
<td aling=left>Date</td>
<td aling=left>Edit</td>
<td aling=left>Delete</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;
$table_edit = "<table width='40' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='edit_link' id='edit_link'>
      <input name='Edit' type='submit' id='Edit' value='Edit' class='button'>
      <input name='link_id' type='hidden' id='link_id' value='$row[3]'>
      <input name='edit_link' type='hidden' id='edit_link' value='$row[3]'>
    </form></td>
  </tr>
</table>";

$table_delete = "<table width='60' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='delete_link' id='delete_link'>
      <input name='Delete' type='submit' id='Delete' value='Delete' class='button'>
      <input name='link_id' type='hidden' id='link_id' value='$row[3]'>
      <input name='delete_link' type='hidden' id='delete_link' value='$row[3]'>
    </form></td>
  </tr>
</table>";

$row[0] = substr($row[0],0,6);
$row[1] = substr($row[1],0,10);
$row[2] = substr($row[2],0,12);
echo "<tbody><tr>
<td align=left class=text_statistics>$rank.</td>
<td align=left class=text_statistics>$row[0]...</td>
<td align=left class=text_statistics>$row[1]...</td>
<td align=left class=text_statistics>$row[2]...</td>
<td align=left class=text_statistics>$row[4]</td>
<td align=left class=text_statistics>$table_edit</td>
<td align=left class=text_statistics>$table_delete</td>
</tr></tbody>";
}
?>
</table>
</fieldset>