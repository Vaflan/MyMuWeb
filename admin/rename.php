<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

if(isset($_POST["name_char"])){
 $name_char = $_POST['name_char'];
 $rename_char = $_POST['rename_char'];
 $date = date('d-m-Y H:i');
 $name_check = mssql_query("SELECT Name FROM Character WHERE name='$rename_char'"); 
 $check_char = mssql_num_rows($name_check);
 if(empty($name_char) ||  empty($rename_char)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif($check_char > 0) {echo "$warning_red Character Is Already In Use, Please Choose Another!";}
 else {
  @mssql_query("Update AccountCharacter set [GameID1]='$rename_char' WHERE [GameID1]='$name_char'");
  @mssql_query("Update AccountCharacter set [GameID2]='$rename_char' WHERE [GameID2]='$name_char'");
  @mssql_query("Update AccountCharacter set [GameID3]='$rename_char' WHERE [GameID3]='$name_char'");
  @mssql_query("Update AccountCharacter set [GameID4]='$rename_char' WHERE [GameID4]='$name_char'");
  @mssql_query("Update AccountCharacter set [GameID5]='$rename_char' WHERE [GameID5]='$name_char'");
  @mssql_query("Update Character set [Name]='$rename_char' WHERE [Name]='$name_char'");
  @mssql_query("Update CharPreview set [Name]='$rename_char' WHERE [Name]='$name_char'");
  @mssql_query("Update Guild set [G_Master]='$rename_char' WHERE [G_Master]='$name_char'");
  @mssql_query("Update GuildMember set [Name]='$rename_char' WHERE [Name]='$name_char'");
  @mssql_query("Update MEMB_INFO set [char_set]='$rename_char' WHERE [char_set]='$name_char'");
  @mssql_query("Update MMW_comment set [c_char]='$rename_char' WHERE [c_char]='$name_char'");
  @mssql_query("Update MMW_forum set [f_char]='$rename_char' WHERE [f_char]='$name_char'");
  @mssql_query("Update MMW_forum set [f_lostchar]='$rename_char' WHERE [f_lostchar]='$name_char'");
  @mssql_query("Update MMW_market set [item_char]='$rename_char' WHERE [item_char]='$name_char'");
  @mssql_query("Update OptionData set [Name]='$rename_char' WHERE [Name]='$name_char'");
  @mssql_query("Update T_CGuid set [Name]='$rename_char' WHERE [Name]='$name_char'");
  @mssql_query("Update T_FriendList set [FriendName]='$rename_char' WHERE [FriendName]='$name_char'");
  @mssql_query("Update T_FriendMail set [FriendName]='$rename_char' WHERE [FriendName]='$name_char'");
  @mssql_query("Update T_FriendMain set [Name]='$rename_char' WHERE [Name]='$name_char'");
  @mssql_query("Update T_WaitFriend set [FriendName]='$rename_char' WHERE [FriendName]='$name_char'");

  echo "$warning_green $name_char Rename to $rename_char SuccessFully Edited!";
  writelog("a_rename_char","<font color=#FF0000>$name_char</font> Renamed to <b>$rename_char</b>");
 }
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Rename Character</legend>
			<form action="" method="post" name="search_" id="search_">
			<table width="100%" border="0" cellspacing="2" cellpadding="0">
			  <tr>
			    <td width="42%" align="right">Character</td>
			    <td><input name="name_char" type="text" id="name_char" size="17" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td align="right">Rename To</td>
			    <td><input name="rename_char" type="text" id="rename_char" size="17" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Rename Character"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
</table>