<?PHP
require('config.php');

$result = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_id from MMW_news order by news_date desc");
echo '
<fieldset><legend>News List</legend>
<table class="sort-table" id="table-1" height="0" border="0" cellpadding="0" cellspacing="0" width="500">                
<thead><tr>
<td aling=left>#</td>
<td aling=left>Title</td>
<td aling=left>Author</td>
<td aling=left>Category</td>
<td aling=left>Date</td>
<td aling=left>Edit</td>
<td aling=left>Delete</td>
</tr></thead>
';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;
$news_table_edit = "<table width='40' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='edit_news' id='edit_news'>
      <input name='news_id' type='hidden' id='news_id' value=$row[4]>
      <input name='edit_news' type='hidden' id='edit_news' value=$row[4]>
      <input name='Edit' type='submit' id='Edit' value='Edit' class='button'>
    </form></td>
  </tr>
</table>
";
$news_table_delete = "<table width='60' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='delete_news' id='delete_news'>
      <input name='news_id' type='hidden' id='news_id' value=$row[4]>
      <input name='delete_news' type='hidden' id='delete_news' value=$row[4]>
      <input name='Delete' type='submit' id='Delete' value='Delete' class='button'>
    </form></td>
  </tr>
</table>
";
$row[0] = substr($row[0],0,10);
$row[3] = date("H:i, d.m.Y",$row[3]);

echo "<tbody><tr>
<td align=left class=text_statistics>$rank.</td>
<td align=left class=text_statistics>$row[0]...</td>
<td align=left class=text_statistics>$row[1]</td>
<td align=left class=text_statistics>$row[2]</td>
<td align=left class=text_statistics>$row[3]</td>
<td align=left class=text_statistics>$news_table_edit</td>
<td align=left class=text_statistics>$news_table_delete</td>
</tr></tbody>";
}
?>
</table>
</fieldset>