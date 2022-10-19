<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// For News module MMW
if (isset($_POST['add_new_news'])) {
	$news_title = $_POST['news_title'];
	$news_category = $_POST['category'];
	$news_row_1 = bugsend($_POST['news_row_1']);
	$news_row_2 = bugsend($_POST['news_row_2']);
	$news_row_3 = bugsend($_POST['news_row_3']);
	$news_autor = $_SESSION['admin']['account'];
	$time = time();
	if (empty($news_title) || empty($news_category)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("INSERT INTO dbo.MMW_news(news_title,news_autor,news_category,news_date,news_row_1,news_row_2,news_row_3,news_id) VALUES ('{$_POST['news_title']}','{$_SESSION['admin']['account']}','{$_POST['category']}','{$time}','{$news_row_1}','{$news_row_2}','{$news_row_3}','{$mmw['rand_id']}')");
		echo $mmw['warning']['green'] . 'News SuccessFully Added!';
		writelog('a_news', 'News: ' . $_POST['news_title'] . ' Has Been <b style="color:#F00">Added</b> Author: ' . $_SESSION['admin']['account']);
	}
}
if (isset($_POST['edit_news_done'])) {
	$news_title = $_POST['edit_news_title'];
	$news_autor = $_POST['edit_news_autor'];
	$news_cateogry = $_POST['category'];
	$news_id = $_POST['news_id'];
	$news_row_1 = bugsend($_POST['edit_news_row_1']);
	$news_row_2 = bugsend($_POST['edit_news_row_2']);
	$news_row_3 = bugsend($_POST['edit_news_row_3']);
	if (empty($news_title) || empty($news_autor) || empty($news_cateogry) || empty($news_id)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("UPDATE dbo.MMW_news SET [news_title]='{$_POST['edit_news_title']}',[news_autor]='{$_POST['edit_news_autor']}',[news_category]='{$_POST['category']}',[news_row_1]='{$news_row_1}',[news_row_2]='{$news_row_2}',[news_row_3]='{$news_row_3}' WHERE [news_id]='{$_POST['news_id']}'");
		echo $mmw['warning']['green'] . 'News SuccessFully Edited!';
		writelog('a_news', 'News: ' . $_POST['edit_news_title'] . ' Has Been <b style="color:#F00">Edited</b> Author: ' . $_POST['edit_news_autor']);
	}
}
if (isset($_POST['delete_news'])) {
	$news_id = $_POST['delete_news'];
	if (empty($news_id)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("DELETE FROM dbo.MMW_news WHERE news_id='$news_id'");
		mssql_query("DELETE FROM dbo.MMW_comment WHERE c_id_code='$news_id'");
		echo $mmw['warning']['green'] . 'News SuccessFully Deleted!';
		writelog('a_news', 'News: ' . $_POST['news_title'] . ' Has Been <b style="color:#F00">Deleted</b>');
	}
}
?>

<fieldset class="content">
	<?php
	if (isset($_POST['edit_news'])) {
		$newsId = stripslashes($_POST['edit_news']);
		$query = mssql_query("SELECT news_title,news_autor,news_category,news_row_1,news_row_2,news_row_3 from dbo.MMW_news where news_id='{$newsId}'");
		$get_edit_news_ = mssql_fetch_row($query);
		$news_row_1 = str_replace('[br]', "\n", $get_edit_news_[3]);
		$news_row_2 = str_replace('[br]', "\n", $get_edit_news_[4]);
		$news_row_3 = str_replace('[br]', "\n", $get_edit_news_[5]);
		?>
		<legend>Edit News</legend>
		<form action="" method="post" name="edit_news_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
				<tr>
					<td align="center" colspan="3">
						Author <input name="edit_news_autor" type="text" size="20" maxlength="20" value="<?php echo $get_edit_news_[1]; ?>">
						<input name="edit_news_done" type="hidden" value="edit_news_done">
						<input name="news_id" type="hidden" value="<?php echo $newsId; ?>"> Curent
						Category: <b><?php echo $get_edit_news_[2]; ?></b> <br>
						News Title <input name="edit_news_title" type="text" maxlength="100" value="<?php echo $get_edit_news_[0]; ?>">
						Category <select name="category">
							<option value="News">News</option>
							<option value="Announcement">Announcement</option>
							<option value="Patch">Patch</option>
							<option value="Rules">Rules</option>
							<option value="Event">Event</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="center">
						News Row 1<br>
						<textarea style="width:170px;height:120px" name="edit_news_row_1"><?php echo $news_row_1; ?></textarea>
					</td>
					<td align="center">
						News Row 2<br>
						<textarea style="width:170px;height:120px" name="edit_news_row_2"><?php echo $news_row_2; ?></textarea>
					</td>
					<td align="center">
						News Row 3<br>
						<textarea style="width:170px;height:120px" name="edit_news_row_3"><?php echo $news_row_3; ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<input type="submit" value="Add News">
						<input type="reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
	<?php } else { ?>
		<legend>Add News</legend>
		<form action="" method="post" name="new_news_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
				<tr>
					<td align="center" colspan="3">
						Title <input name="news_title" type="text" maxlength="100">
						<input name="add_new_news" type="hidden" value="add_new_news">
						Category <select name="category">
							<option value="News">News</option>
							<option value="Announcement">Announcement</option>
							<option value="Patch">Patch</option>
							<option value="Rules">Rules</option>
							<option value="Event">Event</option>
						</select></td>
				</tr>
				<tr>
					<td align="center">
						News Row 1<br>
						<textarea style="width:170px;height:120px" name="news_row_1"></textarea>
					</td>
					<td align="center">
						News Row 2<br>
						<textarea style="width:170px;height:120px" name="news_row_2"></textarea>
					</td>
					<td align="center">
						News Row 3<br>
						<textarea style="width:170px;height:120px" name="news_row_3"></textarea>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<input type="submit" value="Add News">
						<input type="reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
	<?php } ?>
</fieldset>

<fieldset class="content">
	<legend>News List</legend>

	<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
		<thead>
		<tr>
			<td align="center">#</td>
			<td>Title</td>
			<td>Author</td>
			<td>Category</td>
			<td>Date</td>
			<td align="center">Edit</td>
			<td align="center">Delete</td>
		</tr>
		</thead>
		<?php
		$rank = 1;
		$result = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_id FROM dbo.MMW_news ORDER BY news_date desc");
		while ($row = mssql_fetch_row($result)) {
			?>
			<tr>
				<td align="center"><?php echo $rank++; ?>.</td>
				<td><?php echo substr($row[0], 0, 15); ?>...</td>
				<td><?php echo $row[1]; ?></td>
				<td><?php echo $row[2]; ?></td>
				<td><?php echo date('H:i, d.m.Y', $row[3]); ?></td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="edit_news" value="<?php echo $row[4]; ?>">
						<input type="submit" value="Edit"></form>
				</td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="delete_news" value="<?php echo $row[4]; ?>">
						<input type="submit" value="Delete">
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>

</fieldset>
