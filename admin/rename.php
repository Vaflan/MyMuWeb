<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

if (isset($_POST['name_char'])) {
	$name_char = $_POST['name_char'];
	$rename_char = $_POST['rename_char'];
	$date = date('d-m-Y H:i');
	$name_check = mssql_query("SELECT Name FROM dbo.Character WHERE name='{$rename_char}'");
	$check_char = mssql_num_rows($name_check);
	if (empty($name_char) || empty($rename_char)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif ($check_char > 0) {
		echo $mmw['warning']['red'] . 'Character Is Already In Use, Please Choose Another!';
	} else {
		mssql_query("UPDATE dbo.AccountCharacter SET [GameID1]='$rename_char' WHERE [GameID1]='$name_char'");
		mssql_query("UPDATE dbo.AccountCharacter SET [GameID2]='$rename_char' WHERE [GameID2]='$name_char'");
		mssql_query("UPDATE dbo.AccountCharacter SET [GameID3]='$rename_char' WHERE [GameID3]='$name_char'");
		mssql_query("UPDATE dbo.AccountCharacter SET [GameID4]='$rename_char' WHERE [GameID4]='$name_char'");
		mssql_query("UPDATE dbo.AccountCharacter SET [GameID5]='$rename_char' WHERE [GameID5]='$name_char'");
		mssql_query("UPDATE dbo.Character SET [Name]='$rename_char' WHERE [Name]='$name_char'");
		mssql_query("UPDATE dbo.CharPreview SET [Name]='$rename_char' WHERE [Name]='$name_char'");
		mssql_query("UPDATE dbo.Guild SET [G_Master]='$rename_char' WHERE [G_Master]='$name_char'");
		mssql_query("UPDATE dbo.GuildMember SET [Name]='$rename_char' WHERE [Name]='$name_char'");
		mssql_query("UPDATE dbo.MEMB_INFO SET [char_SET]='$rename_char' WHERE [char_set]='$name_char'");
		mssql_query("UPDATE dbo.MMW_comment SET [c_char]='$rename_char' WHERE [c_char]='$name_char'");
		mssql_query("UPDATE dbo.MMW_forum SET [f_char]='$rename_char' WHERE [f_char]='$name_char'");
		mssql_query("UPDATE dbo.MMW_forum SET [f_lastchar]='$rename_char' WHERE [f_lastchar]='$name_char'");
		mssql_query("UPDATE dbo.MMW_market SET [item_char]='$rename_char' WHERE [item_char]='$name_char'");
		mssql_query("UPDATE dbo.OptionData SET [Name]='$rename_char' WHERE [Name]='$name_char'");
		mssql_query("UPDATE dbo.T_CGuid SET [Name]='$rename_char' WHERE [Name]='$name_char'");
		mssql_query("UPDATE dbo.T_FriendList SET [FriendName]='$rename_char' WHERE [FriendName]='$name_char'");
		mssql_query("UPDATE dbo.T_FriendMail SET [FriendName]='$rename_char' WHERE [FriendName]='$name_char'");
		mssql_query("UPDATE dbo.T_FriendMain SET [Name]='$rename_char' WHERE [Name]='$name_char'");
		mssql_query("UPDATE dbo.T_WaitFriend SET [FriendName]='$rename_char' WHERE [FriendName]='$name_char'");

		echo $mmw['warning']['green'] . $name_char . ' Rename to ' . $rename_char . ' SuccessFully Edited!';
		writelog('a_rename_char', '<b style="color:#F00">' . $name_char . '</b> Renamed to <b>' . $rename_char . '</b>');
	}
}
?>

<fieldset class="content">
	<legend>Rename Character</legend>
	<form action="" method="post" name="search_">
		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td width="42%" align="right">Character</td>
				<td><input type="text" name="name_char" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>" size="17" maxlength="10"></td>
			</tr>
			<tr>
				<td align="right">Rename To</td>
				<td><input type="text" name="rename_char" size="17" maxlength="10"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Rename Character">
				</td>
			</tr>
		</table>
	</form>
</fieldset>
