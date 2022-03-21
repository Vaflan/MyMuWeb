<?PHP
$result = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_id from MMW_news order by news_date desc");

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td align="center">#</td>
<td align="left">Title</td>
<td align="left">Author</td>
<td align="left">Category</td>
<td align="left">Date</td>
<td align="center">Edit</td>
<td align="center">Delete</td>
</tr></thead>
';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;
$news_table_edit = "<form action='' method='post' name='edit_news' id='edit_news'>
	<input name='edit_news' type='hidden' id='edit_news' value='$row[4]'>
	<input name='Edit' type='submit' id='Edit' value='Edit'>
</form>";
$news_table_delete = "<form action='' method='post' name='delete_news' id='delete_news'>
	<input name='delete_news' type='hidden' id='delete_news' value='$row[4]'>
	<input name='Delete' type='submit' id='Delete' value='Delete'>
</form>";

$row[0] = substr($row[0],0,15);
$row[3] = date("H:i, d.m.Y",$row[3]);

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$row[0]...</td>
<td align='left'>$row[1]</td>
<td align='left'>$row[2]</td>
<td align='left'>$row[3]</td>
<td align='center'>$news_table_edit</td>
<td align='center'>$news_table_delete</td>
</tr>";
}
?>
</table>