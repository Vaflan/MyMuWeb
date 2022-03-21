<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Download List
if(isset($_POST["new_link"])) {
 $link_name = $_POST['link_name'];
 $link_address = $_POST['link_address'];
 $link_description = $_POST['link_description'];
 $link_size = $_POST['link_size'];
 if(empty($link_name) || empty($link_address) || empty($link_description) || empty($link_size)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("INSERT INTO MMW_links(l_name,l_address,l_description,l_size,l_date,l_id) VALUES ('$link_name','$link_address','$link_description','$link_size','".time()."','$mmw[rand_id]')");
  echo "$warning_green Link SuccessFully Added!";
  writelog("a_link","Link $_POST[link_name] Has Been <font color=#FF0000>Added</font>");
 }
}
if(isset($_POST["edit_link_done"])) {
 $link_name = $_POST['link_name'];
 $link_address = $_POST['link_address'];
 $link_description = $_POST['link_description'];
 $link_size = $_POST['link_size'];
 $link_id = $_POST['link_id'];
 if(empty($link_name) || empty($link_address) || empty($link_description) || empty($link_size) || empty($link_id)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("Update MMW_links set [l_name]='$link_name',[l_address]='$link_address',[l_description]='$link_description',[l_size]='$link_size',[l_date]='".time()."' where l_id='$link_id'");
  echo "$warning_green Link SuccessFully Edited!";
  writelog("a_link","Link $_POST[link_name] Has Been <font color=#FF0000>Edited</font>");
 }
}
if(isset($_POST["delete_link"])) {
 $link_id = $_POST["delete_link"];
 if(empty($link_id)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("DELETE FROM MMW_links WHERE l_id='$link_id'");
  echo "$warning_green Link SuccessFully Deleted!";
  writelog("a_link","Link $link_name Has Been <font color=#FF0000>Deleted</font>");
 }
}
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>

<?
if(isset($_POST["edit_link"])) {
 $link_id = clean_var(stripslashes($_POST['edit_link']));
 $get_edit_link = mssql_query("Select l_name,l_address,l_description,l_size from MMW_links where l_id='$link_id'");
 $get_edit_link_ = mssql_fetch_row($get_edit_link);
?>
		<legend>Edit Link</legend>
			<form action="" method="post" name="new_link_form" id="new_link_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Link Name</td>
			    <td><input name="link_name" type="text" id="link_name" size="20" maxlength="100" value="<?echo $get_edit_link_[0];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Link Address</td>
			    <td><input name="link_address" type="text" id="link_address" size="20" maxlength="100" value="<?echo $get_edit_link_[1];?>"> <input name="edit_link_done" type="hidden" id="edit_link_done" value="edit_link_done"> <input name="link_id" type="hidden" id="link_id" value="<?echo $link_id;?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Link Size</td>
			    <td><input name="link_size" type="text" id="link_size" size="20" maxlength="100" value="<?echo $get_edit_link_[3];?>"></td>
			  </tr>
			  <tr>
			    <td align="right">Description</td>
			    <td><textarea name="link_description" id="link_description"><?echo $get_edit_link_[2];?></textarea></td>
			  </tr>
			  <tr> 
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Edit Link"> <input type="reset" name="Reset" value="Reset"></td> 
			  </tr> 
			</table> 
			</form> 
<?}else{?>
		<legend>New Link</legend> 
			<form action="" method="post" name="new_link_form" id="new_link_form"> 
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td width="42%" align="right">Link Name</td>
			    <td><input name="link_name" type="text" id="link_name" size="20" maxlength="100"></td> 
			  </tr> 
			  <tr> 
			    <td align="right">Link Address</td>
			    <td><input name="link_address" type="text" id="link_address" size="20" maxlength="100"> <input name="new_link" type="hidden" id="new_link" value="new_link"></td> 
			  </tr> 
			  <tr> 
			    <td align="right">Link Size</td>
			    <td><input name="link_size" type="text" id="link_size" size="20" maxlength="100"></td> 
			  </tr> 
			  <tr> 
			    <td align="right">Description</td>
			    <td><textarea name="link_description" id="link_description">Link Description</textarea></td> 
			  </tr> 
			  <tr> 
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Add Link"> <input type="reset" name="Reset" value="Reset"></td> 
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
		<legend>Links List</legend>

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Name</td>
  <td align="left">Address</td>
  <td align="left">Description</td>
  <td align="left">Date</td>
  <td align="center">Edit</td>
  <td align="center">Delete</td>
 </tr></thead>
<?
$result = mssql_query("SELECT l_name,l_address,l_description,l_id,l_date from MMW_links order by l_date desc");
for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;
 $table_edit = "<form action='' method='post'><input type='submit' value='Edit'><input name='edit_link' type='hidden' value='$row[3]'></form>";

 $table_delete = "<form action='' method='post'><input type='submit' value='Delete'><input name='delete_link' type='hidden' value='$row[3]'></form>";

 $row[0] = substr($row[0],0,8);
 $row[1] = substr($row[1],0,14);
 $row[2] = substr($row[2],0,14);
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><?echo $row[0];?>...</td>
  <td align='left'><?echo $row[1];?>...</td>
  <td align='left'><?echo $row[2];?>...</td>
  <td align='left'><?echo date("Y-m-d H:i:s",$row[4]);?></td>
  <td align='center'><?echo $table_edit;?></td>
  <td align='center'><?echo $table_delete;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr> 
</table> 