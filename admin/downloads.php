<?PHP
if(isset($_POST["edit_link_done"])) {edit_link($_POST['link_name'],$_POST['link_address'],$_POST['link_description'],$_POST['link_size'],$_POST['link_id']);}
if(isset($_POST["delete_link"])) {delete_link($_POST["delete_link"]);}
if(isset($_POST["new_link"])) {new_link($_POST['link_name'],$_POST['link_address'],$_POST['link_description'],$_POST['link_size']);}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>

<?
if(isset($_POST["edit_link"])) {
$link_id = clean_var(stripslashes($_POST['edit_link']));
$get_edit_link = mssql_query("Select link_name,link_address,link_description,link_size from MMW_links where link_id='$link_id'");
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
			<?include_once("admin/inc/links_list.php");?>
		</fieldset>
		</td>
	</tr> 
</table> 