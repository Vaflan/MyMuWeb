<? 
if (isset($_POST["edit_link_done"])){edit_link($_POST['link_name'],$_POST['link_address'],$_POST['link_description'],$_POST['link_id']);}
if (isset($_POST["delete_link"])){delete_link($_POST['link_id']);}
if (isset($_POST["add_new_link"])){add_new_link($_POST['link_name'],$_POST['link_address'],$_POST['link_description']);}
?>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td align="center">
<?
if(isset($_POST["edit_link"])) {
$link_id = stripslashes($_POST['link_id']);
$link_id = clean_Var($link_id);
$get_edit_link = mssql_query("Select link_name,link_address,link_description from MMW_links where link_id='$link_id'");
$get_edit_link_ = mssql_fetch_row($get_edit_link);

echo '
<fieldset>
<legend>Edit Link</legend>
<form action="" method="post" name="new_link_form" id="new_link_form">
        <table width="277" border="0" cellpadding="0" cellspacing="4">
          <tr>
            <td width="96" scope="row"><div align="right"  class="text_administrator">Link Name</div></td>
            <td width="169" scope="row"><input name="link_name" type="text" id="link_name" size="20" maxlength="100" value="'.$get_edit_link_[0].'"></td>
          </tr>
          <tr>
            <td scope="row"><div align="right" class="text_administrator">Link Address</div></td>
            <td scope="row"><input name="link_address" type="text" id="link_address" size="20" maxlength="100" value="'.$get_edit_link_[1].'">
                <input name="edit_link_done" type="hidden" id="edit_link_done" value="edit_link_done">
                <input name="link_id" type="hidden" id="link_id" value="'.$link_id.'">
            </td>
          </tr>
          <tr>
            <td scope="row"><div align="right" class="text_administrator">Description</div></td>
            <td scope="row"><textarea name="link_description" id="link_description">'.$get_edit_link_[2].'</textarea></td>
          </tr>
        </table>
        <table width="200" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr>
            <td width="111" scope="row" align="right"><input type="submit" name="Submit" value="Edit Link" class="button"></td>
            <td width="77" scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
          </tr>
        </table>
    </form>
</fieldset>';
}else{
echo '
<fieldset><legend>New Link</legend>
<form action="" method="post" name="new_link_form" id="new_link_form">
        <table width="277" border="0" cellpadding="0" cellspacing="4">
          <tr>
            <td width="96" scope="row"><div align="right"  class="text_administrator">Link Name</div></td>
            <td width="169" scope="row"><input name="link_name" type="text" id="link_name" size="20" maxlength="100"></td>
          </tr>
          <tr>
            <td scope="row"><div align="right" class="text_administrator">Link Address</div></td>
            <td scope="row"><input name="link_address" type="text" id="link_address" size="20" maxlength="100">
                <input name="add_new_link" type="hidden" id="add_new_link" value="add_new_link"></td>
          </tr>
          <tr>
            <td scope="row"><div align="right" class="text_administrator">Description</div></td>
            <td scope="row"><textarea name="link_description" id="link_description">Link Description</textarea></td>
          </tr>
        </table>
        <table width="200" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr>
            <td width="111" scope="row" align="right"><input type="submit" name="Submit" value="Add Link" class="button"></td>
            <td width="77" scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
          </tr>
        </table>
    </form>
</fieldset>';
}?>
    </td>
  </tr>
</table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td scope="row" align="center">
        <? include_once("admin/inc/links_manager.php"); ?>
    </td>
  </tr>
</table>
