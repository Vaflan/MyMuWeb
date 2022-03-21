<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}
if(isset($_POST["server_name_delete"])){delete_server($_POST["server_name_delete"]);}
if(isset($_POST["new_server"])){add_new_server($_POST['name'],$_POST['version'],$_POST['experience'],$_POST['drops'],$_POST['maxplayer'],$_POST['gsport'],$_POST['serverip'],$_POST['order'],$_POST['servertype']);}
if(isset($_POST["do_edit_server"])){edit_server($_POST['name'],$_POST['version'],$_POST['experience'],$_POST['drops'],$_POST['maxplayer'],$_POST['gsport'],$_POST['serverip'],$_POST['order'],$_POST['old_name_server'],$_POST['servertype']);}
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
			<form action="" method="post" name="edit_server_form" id="edit_server_form">
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
			    <td><input name="order" type="text" id="order" value="<?echo $edit_server[6];?>" size="2" maxlength="2"> <input name="do_edit_server" type="hidden" id="do_edit_server" value="do_edit_server"> <input name="old_name_server" type="hidden" id="old_name_server" value="<?echo $edit_server[0];?>"></td>
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
			<?include_once("admin/inc/server_list.php");?>
		</fieldset>
		</td>
	</tr>
</table>
