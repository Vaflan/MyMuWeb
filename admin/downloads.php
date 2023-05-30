<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Download List
if (isset($_POST['new_link'])) {
	$link_name = $_POST['link_name'];
	$link_address = $_POST['link_address'];
	$link_description = $_POST['link_description'];
	$link_size = $_POST['link_size'];
	$link_time = time();
	if (empty($link_name) || empty($link_address) || empty($link_description) || empty($link_size)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("INSERT INTO dbo.MMW_links(l_name,l_address,l_description,l_size,l_date,l_id) VALUES ('{$link_name}','{$link_address}','{$link_description}','{$link_size}','{$link_time}','{$mmw['rand_id']}')");
		echo $mmw['warning']['green'] . 'Link SuccessFully Added!';
		writelog('a_link', 'Link ' . $_POST['link_name'] . ' Has Been <b style="color:#F00">Added</b>');
	}
}
if (isset($_POST['edit_link_done'])) {
	$link_name = $_POST['link_name'];
	$link_address = $_POST['link_address'];
	$link_description = $_POST['link_description'];
	$link_size = $_POST['link_size'];
	$link_id = $_POST['link_id'];
	$link_time = time();
	if (empty($link_name) || empty($link_address) || empty($link_description) || empty($link_size) || empty($link_id)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("UPDATE dbo.MMW_links SET [l_name]='{$link_name}',[l_address]='{$link_address}',[l_description]='{$link_description}',[l_size]='{$link_size}',[l_date]='{$link_time}' WHERE l_id='{$link_id}'");
		echo $mmw['warning']['green'] . 'Link SuccessFully Edited!';
		writelog('a_link', 'Link ' . $_POST['link_name'] . ' Has Been <b style="color:#F00">Edited</b>');
	}
}
if (isset($_POST['delete_link'])) {
	if (empty($_POST['delete_link'])) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("DELETE FROM dbo.MMW_links WHERE l_id='{$_POST['delete_link']}'");
		echo $mmw['warning']['green'] . 'Link SuccessFully Deleted!';
		writelog('a_link', 'Link ' . $link_name . ' Has Been <b style="color:#F00">Deleted</b>');
	}
}
?>
<fieldset class="content">

	<?php
	if (isset($_POST['edit_link'])) {
		$linkId = clean_var(stripslashes($_POST['edit_link']));
		$query = mssql_query("SELECT l_name,l_address,l_description,l_size FROM dbo.MMW_links WHERE l_id='{$linkId}'");
		$get_edit_link_ = mssql_fetch_row($query);
		?>
		<legend>Edit Link</legend>
		<form action="" method="post" name="new_link_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
				<tr>
					<td width="42%" align="right">Link Name</td>
					<td>
						<input name="link_name" type="text" size="20" maxlength="100" value="<?php echo $get_edit_link_[0]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Link Address</td>
					<td>
						<input name="link_address" type="text" size="20" maxlength="100" value="<?php echo $get_edit_link_[1]; ?>">
						<input name="edit_link_done" type="hidden" value="edit_link_done">
						<input name="link_id" type="hidden" value="<?php echo $linkId; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Link Size</td>
					<td>
						<input name="link_size" type="text" size="20" maxlength="100" value="<?php echo $get_edit_link_[3]; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">Description</td>
					<td>
						<textarea name="link_description"><?php echo $get_edit_link_[2]; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Edit Link">
						<input type="reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
	<?php } else {
		?>
		<legend>New Link</legend>
		<form action="" method="post" name="new_link_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
				<tr>
					<td width="42%" align="right">Link Name</td>
					<td><input name="link_name" type="text" size="20" maxlength="100"></td>
				</tr>
				<tr>
					<td align="right">Link Address</td>
					<td><input name="link_address" type="text" size="20" maxlength="100">
						<input name="new_link" type="hidden" value="new_link"></td>
				</tr>
				<tr>
					<td align="right">Link Size</td>
					<td><input name="link_size" type="text" size="20" maxlength="100"></td>
				</tr>
				<tr>
					<td align="right">Description</td>
					<td><textarea name="link_description">Link Description</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Add Link">
						<input type="reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
	<?php } ?>
</fieldset>
<fieldset class="content">
	<legend>Links List</legend>

	<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
		<thead>
		<tr>
			<td align="center">#</td>
			<td>Name</td>
			<td>Address</td>
			<td>Description</td>
			<td>Date</td>
			<td align="center">Edit</td>
			<td align="center">Delete</td>
		</tr>
		</thead>
		<?php
		$rank = 1;
		$result = mssql_query("SELECT l_name,l_address,l_description,l_id,l_date FROM dbo.MMW_links ORDER BY l_date DESC");
		while ($row = mssql_fetch_row($result)) {
			?>
			<tr>
				<td align="center"><?php echo $rank++; ?>.</td>
				<td><?php echo substr($row[0], 0, 8); ?>...</td>
				<td><?php echo substr($row[1], 0, 14); ?>...</td>
				<td><?php echo substr($row[2], 0, 14); ?>...</td>
				<td><?php echo date('Y-m-d H:i:s', $row[4]); ?></td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="edit_link" value="<?php echo $row[3]; ?>">
						<input type="submit" value="Edit">
					</form>
				</td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="delete_link" value="<?php echo $row[3]; ?>">
						<input type="submit" value="Delete">
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>

</fieldset>
