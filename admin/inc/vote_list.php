<?PHP
$result = mssql_query("SELECT ID,question,answer1,answer2,answer3,answer4,answer5,answer6,add_date from MMW_votemain order by add_date desc");

echo '
<fieldset>
<legend>Votes List</legend>
<table class="sort-table" id="table-1" border="0" cellpadding="0" cellspacing="0" width="500">  
<thead>
<tr>
<td aling=left>#</td>
<td aling=left>Question</td>
<td aling=left>Answers</td>
<td aling=left>Votes</td>
<td aling=left>Date</td>
<td aling=left>Edit</td>
<td aling=left>Delete</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;

$table_edit = "<table width='40' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='edit' id='edit'>
      <input name='edit' type='hidden' id='edit' value='$row[0]'>
      <input type='submit' value='Edit' class='button'>
    </form></td>
  </tr>
</table>";

$table_delete = "<table width='60' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='85'><form action='' method='post' name='delete' id='delete'>
      <input name='delete_id_vote' type='hidden' id='delete_id_vote' value='$row[0]'>
      <input type='submit' value='Delete' class='button'>
    </form></td>
  </tr>
</table>";

$all_answers = 0;
for($c=2; $c < 8; ++$c) {
   if($row[$c]!=' ' && isset($row[$c])) {$all_answers = $all_answers +1;}
}

$all_votes_res = mssql_query("SELECT ID_vote FROM MMW_voterow WHERE ID_vote='$row[0]'");
$all_votes = mssql_num_rows($all_votes_res);

echo "<tbody><tr>
<td align=left class=text_statistics>$rank.</td>
<td align=left class=text_statistics>$row[1]</td>
<td align=left class=text_statistics>$all_answers</td>
<td align=left class=text_statistics>$all_votes</td>
<td align=left class=text_statistics>".date("d.m.Y H:i:s", $row[8])."</td>
<td align=left class=text_statistics>$table_edit</td>
<td align=left class=text_statistics>$table_delete</td>
</tr></tbody>";
}
?>
</table>
</fieldset>