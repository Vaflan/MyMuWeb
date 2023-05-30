<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Votes Script by Vaflan
if (isset($_POST['new_id_vote'])) {
	$question = $_POST['question'];
	$answer1 = trim($_POST['answer1']);
	$answer2 = trim($_POST['answer2']);
	$answer3 = trim($_POST['answer3']);
	$answer4 = trim($_POST['answer4']);
	$answer5 = trim($_POST['answer5']);
	$answer6 = trim($_POST['answer6']);
	$time = time();
	if (empty($question)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("INSERT INTO dbo.MMW_votemain(question,answer1,answer2,answer3,answer4,answer5,answer6,add_date) VALUES ('$question','$answer1','$answer2','$answer3','$answer4','$answer5','$answer6','$time')");
		echo $mmw['warning']['green'] . 'Vote SuccessFully Added!';
		writelog('a_vote', 'Vote: ' . $question . ' Has Been <b style="color:#F00">Added</b>');
	}
}
if (isset($_POST['edit_id_vote'])) {
	$idVote = $_POST['edit_id_vote'];
	$question = $_POST['question'];
	$answer1 = trim($_POST['answer1']);
	$answer2 = trim($_POST['answer2']);
	$answer3 = trim($_POST['answer3']);
	$answer4 = trim($_POST['answer4']);
	$answer5 = trim($_POST['answer5']);
	$answer6 = trim($_POST['answer6']);
	if (empty($idVote) || empty($question)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("UPDATE dbo.MMW_votemain SET [question]='$question',[answer1]='$answer1',[answer2]='$answer2',[answer3]='$answer3',[answer4]='$answer4',[answer5]='$answer5',[answer6]='$answer6' WHERE [id]='{$idVote}'");
		echo $mmw['warning']['green'] . 'Vote SuccessFully Edited!';
		writelog('a_vote', 'Vote: ' . print_r($_POST, true) . ' Has Been <b style="color:#F00">Edited</b>');
	}
}
if (isset($_POST['delete_id_vote'])) {
	$idVote = $_POST['delete_id_vote'];
	if (empty($idVote)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("DELETE FROM dbo.MMW_votemain WHERE id='$idVote'");
		mssql_query("DELETE FROM dbo.MMW_voterow WHERE id_vote='$idVote'");
		echo $mmw['warning']['green'] . 'Vote SuccessFully Deleted!';
		writelog('a_vote', 'ID Vote: ' . $idVote . ' Has Been <b style="color:#F00">Deleted</b>');
	}
}
?>
<fieldset class="content">
	<?php
	if (isset($_POST['edit'])) {
		$edit = clean_var(stripslashes($_POST['edit']));
		$query = mssql_query("SELECT id,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM dbo.MMW_votemain WHERE id='{$edit}'");
		$edit_row = mssql_fetch_row($query);
		?>
		<legend>Edit Vote</legend>
		<form action="" method="post" name="edit_form" id="edit_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
				<tr>
					<td width="42%" align="right">Question</td>
					<td><input name="question" type="text" id="question" value="<?php echo $edit_row[1]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Answer 1</td>
					<td><input name="answer1" type="text" id="answer1" value="<?php echo $edit_row[2]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Answer 2</td>
					<td><input name="answer2" type="text" id="answer2" value="<?php echo $edit_row[3]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Answer 3</td>
					<td><input name="answer3" type="text" id="answer3" value="<?php echo $edit_row[4]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Answer 4</td>
					<td><input name="answer4" type="text" id="answer4" value="<?php echo $edit_row[5]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Answer 5</td>
					<td><input name="answer5" type="text" id="answer5" value="<?php echo $edit_row[6]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Answer 6</td>
					<td><input name="answer6" type="text" id="answer6" value="<?php echo $edit_row[7]; ?>">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Edit">
						<input type="hidden" name="edit_id_vote" value="<?php echo $edit_row[0]; ?>">
						<input type="reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
	<?php } else {
		?>
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
					<td colspan="2" align="center">
						<input type="submit" value="New" class="button">
						<input type="hidden" name="new_id_vote" value="new">
						<input type="reset" value="Reset" class="button">
					</td>
				</tr>
			</table>
		</form>
	<?php } ?>
</fieldset>
<fieldset class="content">
	<legend>Server List</legend>

	<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
		<thead>
		<tr>
			<td align="center">#</td>
			<td>Question</td>
			<td>Answers</td>
			<td>Votes</td>
			<td>Date</td>
			<td align="center">Edit</td>
			<td align="center">Delete</td>
		</tr>
		</thead>
		<?php
		$rank = 1;
		$result = mssql_query("SELECT id,question,answer1,answer2,answer3,answer4,answer5,answer6,add_date FROM dbo.MMW_votemain ORDER BY add_date DESC");
		while ($row = mssql_fetch_row($result)) {
			$all_answers = 0;
			for ($c = 2; $c < 8; ++$c) {
				if (!empty($row[$c])) {
					$all_answers++;
				}
			}
			$all_votes = mssql_num_rows(mssql_query("SELECT id_vote FROM dbo.MMW_voterow WHERE id_vote='{$row[0]}'"));
			?>
			<tr>
				<td align="center"><?php echo $rank++; ?>.</td>
				<td><?php echo $row[1]; ?></td>
				<td><?php echo $all_answers; ?></td>
				<td><?php echo $all_votes; ?></td>
				<td><?php echo date('d.m.Y H:i:s', $row[8]); ?></td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="edit" value="<?php echo $row[0]; ?>">
						<input type="submit" value="Edit">
					</form>
				</td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="delete_id_vote" value="<?php echo $row[0]; ?>">
						<input type="submit" value="Delete">
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>

</fieldset>
