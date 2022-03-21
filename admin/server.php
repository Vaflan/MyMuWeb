<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Server List
if(isset($_POST["new_server"])) {
 $post_name = $_POST['name'];
 $post_version = $_POST['version'];
 $post_experience = $_POST['experience'];
 $post_drops = $_POST['drops'];
 $post_maxplayer = $_POST['maxplayer'];
 $post_gsport = $_POST['gsport'];
 $post_serverip = $_POST['serverip'];
 $post_order = $_POST['order'];
 $post_type = $_POST['servertype'];
 if(empty($post_name) || empty($post_version) || empty($post_experience) || empty($post_drops) || empty($post_gsport) || empty($post_serverip) || empty($post_order) || empty($post_type) || empty($post_maxplayer)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 elseif(ereg('[^0-9]', $post_order)) {echo "$warning_red Error: Please Use Only Numbers At Displaying Order!  <br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("INSERT INTO MMW_servers(name,experience,drops,gsport,ip,display_order,version,type,maxplayer) VALUES ('$post_name','$post_experience','$post_drops','$post_gsport','$post_serverip','$post_order','$post_version','$post_type','$post_maxplayer')");
  echo "$warning_green $post_name Server SuccessFully Added!";
  writelog("a_server","New Server Named: $_POST[name] Has Been <font color=#FF0000>Added</font>");
 }
}
if(isset($_POST["edit_server"])) {
 $name = $_POST['name'];
 $version = $_POST['version'];
 $experience = $_POST['experience'];
 $drops = $_POST['drops'];
 $maxplayer = $_POST['maxplayer'];
 $gsport = $_POST['gsport'];
 $serverip = $_POST['serverip'];
 $order = $_POST['order'];
 $old_name = $_POST['old_name_server'];
 $server_type = $_POST['servertype'];
 if(empty($name) || empty($version) || empty($experience) || empty($drops) || empty($server_type) || empty($gsport) || empty($serverip) || empty($order) || empty($old_name) || empty($maxplayer)){echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("Update MMW_servers set [name]='$name',[experience]='$experience',[drops]='$drops',[gsport]='$gsport',[ip]='$serverip',[display_order]='$order',[version]='$version',[type]='$server_type',[maxplayer]='$maxplayer' where [name]='$old_name'");
  echo "$warning_green $old_name Server SuccessFully Edited!";
  writelog("a_server","Server Named: $_POST[name] Has Been <font color=#FF0000>Edited</font>");
 }
}
if(isset($_POST["server_name_delete"])) {
 $post_server_name_delete = $_POST["server_name_delete"];
 if(empty($post_server_name_delete)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("DELETE FROM MMW_servers WHERE name='$post_server_name_delete'");
  echo "$warning_green $post_server_name_delete Server SuccessFully Deleted!";
  writelog("a_server","Server Named: $_POST[server_name_delete] Has Been <font color=#FF0000>Deleted</font>");
 }
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>

<?
if(isset($_POST["server_name_edit"])) {
 $srv_edit= stripslashes($_POST['server_name_edit']);
 $result_edit_server = mssql_query("SELECT Name,experience,drops,gsport,ip,version,display_order,type,maxplayer from MMW_servers where name='$srv_edit'");
 $edit_server = mssql_fetch_row($result_edit_server);
?>
		<legend>Edit Server</legend>
			<form action="" method="post">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Name</td>
			    <td><input name="name" type="text" id="name" value="<?echo $edit_server[0];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Version</td>
			    <td><input name="version" type="text" id="version" value="<?echo $edit_server[5];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Experience</td>
			    <td><input name="experience" type="text" id="experience" value="<?echo $edit_server[1];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Drops</td>
			    <td><input name="drops" type="text" id="drops" value="<?echo $edit_server[2];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Type</td>
			    <td><select name="servertype" class="select" id="servertype"><option value="PVP">PVP</option><option value="Non-PVP">Non-PVP</option></select> <small>Curent: <?echo $edit_server[7];?></small></td>
			  </tr>
			  <tr>
			    <td align="right">Max Players</td>
			    <td><input name="maxplayer" type="text" id="maxplayer" value="<?echo $edit_server[8];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Gs Port</td>
			    <td><input name="gsport" type="text" id="gsport" value="<?echo $edit_server[3];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Server IP</td>
			    <td><input name="serverip" type="text" id="serverip" value="<?echo $edit_server[4];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Display Order</td>
			    <td><input name="order" type="text" id="order" value="<?echo $edit_server[6];?>" size="2" maxlength="2"> <input name="edit_server" type="hidden" value="edit_server"> <input name="old_name_server" type="hidden" value="<?echo $edit_server[0];?>"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Edit Server"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
<?}else{?>
		<legend>Add Server</legend>
			<form action="" method="post" name="new_server_form" id="new_server_form">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			  <tr>
			    <td width="42%" align="right">Name</td>
			    <td><input name="name" type="text" id="name" maxlength="20"></td>
			  </tr>
			  <tr>
			    <td align="right">Version</td>
			    <td><input name="version" type="text" id="version"></td>
			  </tr>
			  <tr>
			    <td align="right">Experience</td>
			    <td><input name="experience" type="text" id="experience"></td>
			  </tr>
			  <tr>
			    <td align="right">Drops</td>
			    <td><input name="drops" type="text" id="drops"></td>
			  </tr>
			  <tr>
			    <td align="right">Type</td>
			    <td><select name="servertype" class="select" id="servertype"><option value="PVP">PVP</option><option value="Non-PVP">Non-PVP</option></select></td>
			  </tr>
			  <tr>
			    <td align="right">Max Players</td>
			    <td><input name="maxplayer" type="text" id="maxplayer"></td>
			  </tr>
			  <tr>
			    <td align="right">Gs Port</td>
			    <td><input name="gsport" type="text" id="gsport"></td>
			  </tr>
			  <tr>
			    <td align="right">Server IP</td>
			    <td><input name="serverip" type="text" id="serverip"></td>
			  </tr>
			  <tr>
			    <td align="right">Display Order</td>
			    <td><input name="order" type="text" id="order" size="2" maxlength="2"> <input name="new_server" type="hidden" id="new_server" value="new_server"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="New Server"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
<?}?>
		</td>
	</tr>
	<tr>
		<td align="center">
		<fieldset>
		<legend>Server List</legend>

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Name</td>
  <td align="left">Version</td>
  <td align="left">Experience</td>
  <td align="left">Drops</td>
  <td align="left">Type</td>
  <td align="left">Status</td>
  <td align="center">Edit</td>
  <td align="center">Delete</td>
 </tr></thead>
<?
$result = mssql_query("SELECT Name,experience,drops,gsport,ip,version,display_order,type from MMW_servers order by display_order asc");
for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;
 if($check=@fsockopen($row[4],$row[3],$ERROR_NO,$ERROR_STR,(float)0.3)) {
  $status_done = '<span class="online"><b>Online</b></span>';
  fclose($check);
 }
 else {
  $status_done = '<span class="offline"><b>Offline</b></span>'; 
 } 

 $server_table_edit = "<form action='' method='post'><input type='submit' value='Edit'><input name='server_name_edit' type='hidden' value='$row[0]'></form>";
 $server_table_delete = "<form action='' method='post'><input type='submit' value='Delete'><input name='server_name_delete' type='hidden' value='$row[0]'></form>";
?>
 <tr>
  <td align='center'><?echo $row[6];?>.</td>
  <td align='left'><?echo $row[0];?></td>
  <td align='left'><?echo $row[5];?></td>
  <td align='left'><?echo $row[1];?></td>
  <td align='left'><?echo $row[2];?></td>
  <td align='left'><?echo $row[7];?></td>
  <td align='left'><?echo $status_done;?></td>
  <td align='center'><?echo $server_table_edit;?></td>
  <td align='center'><?echo $server_table_delete;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
</table>
