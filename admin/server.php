<?
if(isset($_POST["server_name_delete"])){delete_server($_POST["server_name_delete"]);}
if(isset($_POST["new_server"])){add_new_server($_POST['name'],$_POST['version'],$_POST['experience'],$_POST['drops'],$_POST['gsport'],$_POST['serverip'],$_POST['order'],$_POST['server_type']);}
if(isset($_POST["do_edit_server"])){edit_server($_POST['name'],$_POST['version'],$_POST['experience'],$_POST['drops'],$_POST['server_type'],$_POST['gsport'],$_POST['serverip'],$_POST['order'],$_POST['old_name_server']);}
?>
<table width="260" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td scope="row" align="center">
<?
if(isset($_POST["server_name_edit"])) {
$srv_edit= stripslashes($_POST['server_name_edit']);
$result_edit_server = mssql_query("SELECT Name,experience,drops,gsport,ip,version,display_order,type from MMW_servers where name='$srv_edit'");
$edit_server = mssql_fetch_row($result_edit_server);

echo '
					<fieldset>
					 <legend>Edit Server</legend>
                                                              <form action="" method="post" name="edit_server_form" id="edit_server_form">
                                                                    <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                                                      <tr>
                                                                        <td width="67" scope="row"><div align="right"  class="text_administrator">Name</div></td>
                                                                        <td width="158" scope="row"><input name="name" type="text" id="name" value="'.$edit_server[0].'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right"  class="text_administrator">Version</div></td>
                                                                        <td width="158" scope="row"><input name="version" type="text" id="version" value="'.$edit_server[5].'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right"  class="text_administrator">Experience</div></td>
                                                                        <td width="158" scope="row"><input name="experience" type="text" id="experience" value="'.$edit_server[1].'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right"  class="text_administrator">Drops</div></td>
                                                                        <td width="158" scope="row"><input name="drops" type="text" id="drops" value="'.$edit_server[2].'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right"  class="text_administrator">Type</div></td>
                                                                        <td width="158" scope="row"><select name="server_type"  class="select" id="server_type"><option value="PVP">PVP</option><option value="NON PVP">NON PVP</option></select> <span class="text_administrator">Curent('.$edit_server[7].')</span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right"  class="text_administrator">Gs Port </div></td>
                                                                        <td width="158" scope="row"><input name="gsport" type="text" id="gsport" value="'.$edit_server[3].'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right"  class="text_administrator">Server ip </div></td>
                                                                        <td width="158" scope="row"><input name="serverip" type="text" id="serverip" value="'.$edit_server[4].'"></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td scope="row"><div align="right" class="text_administrator">Display Order </div></td>
                                                                        <td scope="row"><input name="order" type="text" id="order" value="'.$edit_server[6].'" size="2" maxlength="2">
                                                                        <input name="do_edit_server" type="hidden" id="do_edit_server" value="do_edit_server">
                                                                        <input name="old_name_server" type="hidden" id="old_name_server" value="'.$edit_server[0].'"></td>
                                                                      </tr>
                                                                    </table>
                                                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
                                                                      <tr>
                                                                        <td width="111" scope="row" align="right"><input type="submit" name="Submit" value="Edit Server" class="button"></td>
                                                                        <td width="77" scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                                                      </tr>
                                                                    </table>
                                                              </form>
					</fieldset>
';}
else{
echo '
                                  <fieldset>
                                  <legend>Add New Server</legend>
                                  <form action="" method="post" name="new_server_form" id="new_server_form">
                                          <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                            <tr>
                                              <td width="75" scope="row"><div align="right" class="text_administrator">Name</div></td>
                                              <td width="164" scope="row"><input name="name" type="text" id="name" maxlength="20"></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right" class="text_administrator">Version</div></td>
                                              <td scope="row"><input name="version" type="text" id="version"></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right" class="text_administrator">Experience</div></td>
                                              <td scope="row"><input name="experience" type="text" id="experience"></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right"  class="text_administrator">Drops</div></td>
                                              <td scope="row"><input name="drops" type="text" id="drops"></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right"  class="text_administrator">Type</div></td>
                                              <td scope="row"><select name="server_type" class="select" id="server_type"><option value="PVP">PVP</option><option value="NON PVP">NON PVP</option></select></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right"  class="text_administrator">Gs Port </div></td>
                                              <td scope="row"><input name="gsport" type="text" id="gsport"></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right"  class="text_administrator">Server ip </div></td>
                                              <td scope="row"><input name="serverip" type="text" id="serverip"></td>
                                            </tr>
                                            <tr>
                                              <td scope="row"><div align="right" class="text_administrator">Display Order </div></td>
                                              <td scope="row"><input name="order" type="text" id="order" size="2" maxlength="2">
                                                  <input name="new_server" type="hidden" id="new_server" value="new_server"></td>
                                            </tr>
                                          </table>
                                          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
                                            <tr>
                                              <td width="111" scope="row" align="right"><input type="submit" name="Submit" value="New Server" class="button"></td>
                                              <td width="77" scope="row"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                            </tr>
                                          </table>
                                  </form>
                                  </fieldset>';
}
?>
    </td>
  </tr>
</table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td scope="row" align="center">
        <?include_once("admin/inc/server_manager.php");?>
    </td>
  </tr>
</table>
