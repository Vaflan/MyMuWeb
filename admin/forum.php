<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Editor Forum Catalog for Administrator
$forum_catalog = __DIR__ . '/../includes/forum_catalog.php';
include $forum_catalog;

if (isset($_POST['forum'])) {
	$forumList = array();

	$mmw['forum_catalog']['new'] = array();
	foreach ($mmw['forum_catalog'] as $key => $value) {
		if (empty($_POST['key' . $key])) {
			continue;
		}
		$id = $_POST['key' . $key];
		$name = $_POST['name' . $key];
		$notice = $_POST['notice' . $key];
		$status = $_POST['status' . $key];
		$forumList[] = "\t{$id} => array('{$name}', '{$notice}', {$status})";
	}

	$forumList = implode(',' . PHP_EOL, $forumList);
	$forumData = <<<PHP
<?php
\$mmw['forum_catalog'] = array(
{$forumList}
);
PHP;
	$code = str_replace(array(PHP_EOL, '<'), array(' ', '&#60;'), $forumList);

	file_put_contents($forum_catalog, $forumData);
	echo $mmw['warning']['green'] . 'Forum Catalog SuccessFully Edited!';
	writelog('a_forum', 'Forum Catalog Has Been <b style="color:#F00">Edited</b> Array: ' . $code);
	include $forum_catalog;
}
?>
<fieldset class="content">
	<legend>Forum Catalog</legend>

	<form method="post" name="forum" action="" style="margin:0">
		<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
			<thead>
			<tr>
				<td align="center">#</td>
				<td>Name</td>
				<td>Notice</td>
				<td>Add</td>
				<td align="center" width="40">Topics</td>
				<td align="center" width="40">Delete</td>
			</tr>
			</thead>
			<?php
			foreach ($mmw['forum_catalog'] as $key => $value) {
				$result = mssql_query("SELECT count(f_id) FROM dbo.MMW_forum WHERE f_catalog='{$key}'");
				$row = mssql_fetch_row($result);
				?>
				<tr id="catalog<?php echo $key; ?>">
					<td align="center">
						<input type="text" name="key<?php echo $key; ?>" value="<?php echo $key; ?>" size="1">
					</td>
					<td>
						<input type="text" name="name<?php echo $key; ?>" value="<?php echo $value[0]; ?>" style="width:100%">
					</td>
					<td>
						<input type="text" name="notice<?php echo $key; ?>" value="<?php echo $value[1]; ?>" style="width:100%">
					</td>
					<td>
						<select name="status<?php echo $key; ?>" style="width:100%">
							<option value="0">All Members</option>
							<option value="1" <?php echo ($value[2] == 1) ? 'selected' : ''; ?>>Only GM</option>
						</select></td>
					<td align="center"><?php echo $row[0]; ?></td>
					<td align="center">
						<input type="button" value="Delete" onclick="document.getElementById('catalog<?php echo $key; ?>').innerHTML='';">
					</td>
				</tr>
			<?php } ?>
			<tr id="catalognew">
				<td align="center"><input type="text" name="keynew" value="" size="1"></td>
				<td><input type="text" name="namenew" value="" style="width:100%"></td>
				<td><input type="text" name="noticenew" value="" style="width:100%"></td>
				<td>
					<select name="statusnew" style="width:100%">
						<option value="0">All Members</option>
						<option value="1">Only GM</option>
					</select></td>
				<td align="center">New</td>
				<td align="center">
					<input type="button" value="Delete" onclick="document.getElementById('catalognew').innerHTML='';">
				</td>
			</tr>
		</table>
		<div style="text-align:center">
			<input type="submit" value="Save Forum">
			<input type="hidden" name="forum" value="forum">
			<input type="button" value="Renew forum" onclick="window.location='?op=forum';">
		</div>
	</form>

</fieldset>