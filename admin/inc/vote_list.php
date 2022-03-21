<?PHP
$result = mssql_query("SELECT ID,question,answer1,answer2,answer3,answer4,answer5,answer6,add_date from MMW_votemain order by add_date desc");

echo '
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
<thead><tr>
<td aling="center">#</td>
<td aling="left">Question</td>
<td aling="left">Answers</td>
<td aling="left">Votes</td>
<td aling="left">Date</td>
<td aling="center">Edit</td>
<td aling="center">Delete</td>
</tr></thead>';

for($i=0;$i < mssql_num_rows($result);++$i) {
$row = mssql_fetch_row($result);
$rank = $i+1;
$table_edit = "<form action='' method='post' name='edit' id='edit'>
	<input name='edit' type='hidden' id='edit' value='$row[0]'>
	<input type='submit' value='Edit'>
</form>";

$table_delete = "<form action='' method='post' name='delete' id='delete'>
	<input name='delete_id_vote' type='hidden' id='delete_id_vote' value='$row[0]'>
	<input type='submit' value='Delete'>
</form>";

$all_answers = 0;
for($c=2; $c < 8; ++$c) {
   if($row[$c]!=' ' && isset($row[$c])) {$all_answers = $all_answers +1;}
}

$all_votes_res = mssql_query("SELECT ID_vote FROM MMW_voterow WHERE ID_vote='$row[0]'");
$all_votes = mssql_num_rows($all_votes_res);

echo "<tr>
<td align='center'>$rank.</td>
<td align='left'>$row[1]</td>
<td align='left'>$all_answers</td>
<td align='left'>$all_votes</td>
<td align='left'>".date("d.m.Y H:i:s", $row[8])."</td>
<td align='center'>$table_edit</td>
<td align='center'>$table_delete</td>
</tr>";
}
?>
</table>