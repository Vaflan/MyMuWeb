<?
if(isset($_POST[hexwh_run])){require("includes/character.class.php");option::edit_warehouse($_POST[hexwh_run]); echo $divbr;}
if(isset($_POST[gm_msg])){require("includes/character.class.php");option::gm_msg($_POST[gm_msg]); echo $divbr;}


if($_SESSION['admin'] >= $mmw[hex_wh_can]) {
echo "<center><b>HEX Ware House Can Edit!</b></center>".$divbr;
//HEX WH
$query = "declare @vault varbinary(1920); 
		set @vault=(SELECT Items FROM warehouse where AccountId='$login'); print @vault;";
$result = mssql_query($query);
$vault = substr(mssql_get_last_message(),2);
//echo $vault;
?>
<form name='edit_wh' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'>           
	<tr>
          <td><textarea name="hexwh_run" cols="80" rows="12" id="hexwh_run"><?echo $vault;?></textarea></td>
	</tr>
	<tr>
          <td align="center"><input name='submit' type='submit' value='Submit'> <input name='reset' type='reset' value='Reset'></td>
	</tr>
  </table>
</form>
<?
echo $divbr;
}

if($_SESSION['admin'] >= $mmw[gm_msg_send]) {
 if(isset($_POST[gm_msg])) {$gm_msg = $_POST[gm_msg];}
 else {$gm_msg = "$char: TEXT";}
echo "<center><b>GameMaster Chat In Game!</b></center>".$divbr;
?>
<form name='form_gm_msg' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'>           
	<tr>
          <td><input name='gm_msg' type='text' id='gm_msg' value='<?echo $gm_msg;?>' size='60' maxlength='40'></td>
	</tr>
	<tr>
          <td align="center"><input name='submit' type='submit' value='Submit'> <input name='reset' type='reset' value='Reset'></td>
	</tr>
  </table>
</form>
<?}?>