<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Votes Script by Vaflan
if(isset($_POST["new_id_vote"])) {
 $question = $_POST['question'];
 $answer1 = $_POST['answer1'];
 $answer2 = $_POST['answer2'];
 $answer3 = $_POST['answer3'];
 $answer4 = $_POST['answer4'];
 $answer5 = $_POST['answer5'];
 $answer6 = $_POST['answer6'];
 if(empty($question)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  $time = time();
  mssql_query("INSERT INTO MMW_votemain(question,answer1,answer2,answer3,answer4,answer5,answer6,add_date) VALUES ('$question','$answer1','$answer2','$answer3','$answer4','$answer5','$answer6','$time')");
  echo "$warning_green Vote SuccessFully Added!";
  writelog("a_vote","Vote: $question Has Been <font color=#FF0000>Added</font>");
 }
}
if(isset($_POST["edit_id_vote"])) {
 $id_vote = $_POST["edit_id_vote"];
 $question = $_POST['question'];
 $answer1 = $_POST['answer1'];
 $answer2 = $_POST['answer2'];
 $answer3 = $_POST['answer3'];
 $answer4 = $_POST['answer4'];
 $answer5 = $_POST['answer5'];
 $answer6 = $_POST['answer6'];
 if(empty($id_vote) || empty($question)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("Update MMW_votemain set [question]='$question',[answer1]='$answer1',[answer2]='$answer2',[answer3]='$answer3',[answer4]='$answer4',[answer5]='$answer5',[answer6]='$answer6' where [ID]='$id_vote'");
  echo "$warning_green $old_name Server SuccessFully Edited!";
  writelog("a_vote","Vote: $id_vote ([question]='$question',[answer1]='$answer1',[answer2]='$answer2',[answer3]='$answer3',[answer4]='$answer4',[answer5]='$answer5',[answer6]='$answer6') Has Been <font color=#FF0000>Edited</font>");
 }
}
if(isset($_POST["delete_id_vote"])) {
 $id_vote = $_POST["delete_id_vote"];
 if(empty($id_vote)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("DELETE FROM MMW_votemain WHERE ID='$id_vote'");
  mssql_query("DELETE FROM MMW_voterow WHERE id_vote='$id_vote'");
  echo "$warning_green Vote SuccessFully Deleted!";
  writelog("a_vote","Id Vote: $id_vote Has Been <font color=#FF0000>Deleted</font>");
 }
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
<?
if(isset($_POST["edit"])) {
 $edit = clean_var(stripslashes($_POST['edit']));
 $edit_result = mssql_query("SELECT ID,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM MMW_votemain WHERE ID='$edit'");
 $edit_row = mssql_fetch_row($edit_result);
?>
		<legend>Edit Vote</legend>
			<form action="" method="post" name="edit_form" id="edit_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Question</td>
			    <td><input name="question" type="text" id="question" value="<?echo $edit_row[1];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 1</td>
			    <td><input name="answer1" type="text" id="answer1" value="<?echo $edit_row[2];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 2</td>
			    <td><input name="answer2" type="text" id="answer2" value="<?echo $edit_row[3];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 3</td>
			    <td><input name="answer3" type="text" id="answer3" value="<?echo $edit_row[4];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 4</td>
			    <td><input name="answer4" type="text" id="answer4" value="<?echo $edit_row[5];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 5</td>
			    <td><input name="answer5" type="text" id="answer5" value="<?echo $edit_row[6];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 6</td>
			    <td><input name="answer6" type="text" id="answer6" value="<?echo $edit_row[7];?>"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" value="Edit"> <input name="edit_id_vote" type="hidden" value="<?echo $edit_row[0];?>"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
<?}else{?>
		<legend>Add Vote</legend>
			<form action="" method="post" name="new_form" id="new_form">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Question</td>
			    <td><input name="question" type="text" id="question" maxlength="100"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 1</td>
			    <td><input name="answer1" type="text" id="answer1"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 2</td>
			    <td><input name="answer2" type="text" id="answer2"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 3</td>
			    <td><input name="answer3" type="text" id="answer3"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 4</td>
			    <td><input name="answer4" type="text" id="answer4"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 5</td>
			    <td><input name="answer5" type="text" id="answer5"></td>
			  </tr>
			  <tr>
			    <td align="right">Answer 6</td>
			    <td><input name="answer6" type="text" id="answer6"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" value="New" class="button"> <input name="new_id_vote" type="hidden" value="new"> <input type="reset" name="Reset" value="Reset" class="button"></td>
			  </tr>
			</table>
			</form>
<?}?>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Server List</legend>

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Question</td>
  <td align="left">Answers</td>
  <td align="left">Votes</td>
  <td align="left">Date</td>
  <td align="center">Edit</td>
  <td align="center">Delete</td>
 </tr></thead>
<?
$result = mssql_query("SELECT ID,question,answer1,answer2,answer3,answer4,answer5,answer6,add_date from MMW_votemain order by add_date desc");
for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;
 $table_edit = "<form action='' method='post'><input name='edit' type='hidden' value='$row[0]'><input type='submit' value='Edit'></form>";
 $table_delete = "<form action='' method='post'><input name='delete_id_vote' type='hidden' value='$row[0]'><input type='submit' value='Delete'></form>";

 $all_answers = 0;
 for($c=2; $c < 8; ++$c) {
  if($row[$c]!=' ' && isset($row[$c])) {$all_answers = $all_answers +1;}
 }

 $all_votes_res = mssql_query("SELECT ID_vote FROM MMW_voterow WHERE ID_vote='$row[0]'");
 $all_votes = mssql_num_rows($all_votes_res);
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><?echo $row[1];?></td>
  <td align='left'><?echo $all_answers;?></td>
  <td align='left'><?echo $all_votes;?></td>
  <td align='left'><?echo date("d.m.Y H:i:s", $row[8]);?></td>
  <td align='center'><?echo $table_edit;?></td>
  <td align='center'><?echo $table_delete;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
</table>
