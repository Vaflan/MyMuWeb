<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Server List
if (isset($_POST['new_server'])) {
	$post_name = $_POST['name'];
	$post_version = $_POST['version'];
	$post_experience = $_POST['experience'];
	$post_drops = $_POST['drops'];
	$post_maxplayer = $_POST['maxplayer'];
	$post_gsport = $_POST['gsport'];
	$post_serverip = $_POST['serverip'];
	$post_order = $_POST['order'];
	$post_type = $_POST['servertype'];
	if (empty($post_name) || empty($post_version) || empty($post_experience) || empty($post_drops) || empty($post_gsport) || empty($post_serverip) || empty($post_order) || empty($post_type) || empty($post_maxplayer)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_order)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Displaying Order! <br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("INSERT INTO dbo.MMW_servers(name,experience,drops,gsport,ip,display_order,version,type,maxplayer) VALUES ('$post_name','$post_experience','$post_drops','$post_gsport','$post_serverip','$post_order','$post_version','$post_type','$post_maxplayer')");
		echo $mmw['warning']['green'] . $post_name . ' Server SuccessFully Added!';
		writelog('a_server', 'New Server Named: ' . $_POST['name'] . ' Has Been <b style="color:#F00">Added</b>');
	}
}
if (isset($_POST['edit_server'])) {
	$old_name = $_POST['old_name_server'];
	$name = $_POST['name'];
	$version = $_POST['version'];
	$experience = $_POST['experience'];
	$drops = $_POST['drops'];
	$maxplayer = $_POST['maxplayer'];
	$gsport = $_POST['gsport'];
	$serverip = $_POST['serverip'];
	$order = $_POST['order'];
	$server_type = $_POST['servertype'];
	if (empty($name) || empty($version) || empty($experience) || empty($drops) || empty($server_type) || empty($gsport) || empty($serverip) || empty($order) || empty($old_name) || empty($maxplayer)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $order)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Displaying Order! <br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("Update dbo.MMW_servers set [name]='$name',[experience]='$experience',[drops]='$drops',[gsport]='$gsport',[ip]='$serverip',[display_order]='$order',[version]='$version',[type]='$server_type',[maxplayer]='$maxplayer' where [name]='$old_name'");
		echo $mmw['warning']['green'] . $old_name . ' Server SuccessFully Edited!';
		writelog('a_server', 'Server Named: ' . $_POST['name'] . ' Has Been <b style="color:#F00">Edited</b>');
	}
}
if (isset($_POST['server_name_delete'])) {
	if (empty($_POST['server_name_delete'])) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("DELETE FROM dbo.MMW_servers WHERE name='{$_POST['server_name_delete']}'");
		echo $mmw['warning']['green'] . $_POST['server_name_delete'] . ' Server SuccessFully Deleted!';
		writelog('a_server', 'Server Named: ' . $_POST['server_name_delete'] . ' Has Been <b style="color:#F00">Deleted</b>');
	}
}


if (isset($_POST['server_name_edit'])) {
	$serverNameEdit = stripslashes($_POST['server_name_edit']);
	$query = mssql_query("SELECT Name,experience,drops,gsport,ip,version,display_order,type,maxplayer FROM dbo.MMW_servers WHERE name='{$serverNameEdit}'");
	$editServer = mssql_fetch_row($query);
}
?>
<fieldset class="content">
	<legend><?php echo $editServer ? 'Edit' : 'Add'; ?> Server</legend>
	<form action="" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			<tr>
				<td width="42%" align="right">Name</td>
				<td><input type="text" name="name" maxlength="20" value="<?php echo $editServer[0]; ?>"></td>
			</tr>
			<tr>
				<td align="right">Version</td>
				<td><input type="text" name="version" value="<?php echo $editServer[5]; ?>">
				</td>
			</tr>
			<tr>
				<td align="right">Experience</td>
				<td><input type="text" name="experience" value="<?php echo $editServer[1]; ?>"></td>
			</tr>
			<tr>
				<td align="right">Drops</td>
				<td><input type="text" name="drops" value="<?php echo $editServer[2]; ?>"></td>
			</tr>
			<tr>
				<td align="right">Type</td>
				<td>
					<select name="servertype" class="select">
						<option value="PVP">PVP</option>
						<option value="Non-PVP">Non-PVP</option>
					</select>
					<?php if ($editServer) : ?>
						<small>Current: <?php echo $editServer[7]; ?></small>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td align="right">Max Players</td>
				<td><input type="text" name="maxplayer" value="<?php echo $editServer[8]; ?>"></td>
			</tr>
			<tr>
				<td align="right">Gs Port</td>
				<td><input type="text" name="gsport" value="<?php echo $editServer[3]; ?>">
				</td>
			</tr>
			<tr>
				<td align="right">Server IP</td>
				<td><input type="text" name="serverip" value="<?php echo $editServer[4]; ?>"></td>
			</tr>
			<tr>
				<td align="right">Display Order</td>
				<td>
					<input type="text" name="order" value="<?php echo $editServer[6]; ?>" size="2" maxlength="2">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php if ($editServer) : ?>
						<input type="hidden" name="old_name_server" value="<?php echo $editServer[0]; ?>">
						<input type="submit" name="edit_server" value="Edit Server">
					<?php else: ?>
						<input type="submit" name="new_server" value="Add Server">
					<?php endif; ?>
					<input type="reset" value="Reset">
				</td>
			</tr>
		</table>
	</form>
</fieldset>

<fieldset class="content">
	<legend>Server List</legend>
	<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
		<thead>
		<tr>
			<td align="center">#</td>
			<td>Name</td>
			<td>Version</td>
			<td>Experience</td>
			<td>Drops</td>
			<td>Type</td>
			<td>Status</td>
			<td align="center">Edit</td>
			<td align="center">Delete</td>
		</tr>
		</thead>
		<?php
		$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,display_order,type FROM dbo.MMW_servers ORDER BY display_order");
		while ($row = mssql_fetch_row($result)) {
			$statusSocket = '<span class="offline"><b>Offline</b></span>';
			if ($check = @fsockopen($row[4], $row[3], $errorCode, $errorMessage, 0.3)) {
				$statusSocket = '<span class="online"><b>Online</b></span>';
				fclose($check);
			}
			?>
			<tr>
				<td align="center"><?php echo $row[6]; ?>.</td>
				<td><?php echo $row[0]; ?></td>
				<td><?php echo $row[5]; ?></td>
				<td><?php echo $row[1]; ?></td>
				<td><?php echo $row[2]; ?></td>
				<td><?php echo $row[7]; ?></td>
				<td><?php echo $statusSocket; ?></td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="server_name_edit" value="<?php echo $row[0]; ?>">
						<input type="submit" value="Edit">
					</form>
				</td>
				<td align="center">
					<form action="" method="post">
						<input type="hidden" name="server_name_delete" value="<?php echo $row[0]; ?>">
						<input type="submit" value="Delete">
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>
</fieldset>
