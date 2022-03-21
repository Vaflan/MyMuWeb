<?PHP
if(isset($_POST[hexwh_run])){require("includes/character.class.php");option::edit_warehouse($_POST[hexwh_run]); echo $rowbr;}
if(isset($_POST[gm_msg])){require("includes/character.class.php");option::gm_msg($_POST[gm_msg]); echo $rowbr;}
?>

  <table class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="100" align="right">Your Level:</td>
      <td><b><?echo $_SESSION['admin'];?> (<?echo admin_level($_SESSION['admin']);?>)</b></td>
    </tr>
    <tr>
      <td align="right">Security Code:</td>
      <td><b><?echo $mmw[admin_securitycode];?></b></td>
    </tr>
    <tr>
      <td align="right">Admin Area:</td>
      <td><a target="_blank" href="admin.php">Enter</a></td>
    </tr>
  </table>

<?
echo $rowbr;

if($_SESSION['admin'] >= $mmw[hex_wh_can]) {
echo "<center><b>HEX Ware House Can Edit!</b></center>" . $rowbr;
//HEX WH
$query = "declare @vault varbinary(1920); 
		set @vault=(SELECT Items FROM warehouse where AccountId='$login'); print @vault;";
$result = mssql_query($query);
$vault = substr(mssql_get_last_message(),2);
?>
<form name='edit_wh' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'>           
	<tr>
          <td><textarea name="hexwh_run" cols="80" rows="12"><?echo $vault;?></textarea></td>
	</tr>
	<tr>
          <td align="center"><input name='submit' type='submit' value='Submit'> <input name='reset' type='reset' value='Renew'></td>
	</tr>
  </table>
</form>
<?
echo $rowbr;
}

if($_SESSION['admin'] >= $mmw[gm_msg_send]) {
 if(isset($_POST[gm_msg])) {$gm_msg = $_POST[gm_msg];}
 else {$gm_msg = "$char: TEXT";}
echo "<center><b>GameMaster Chat In Game!</b></center>" . $rowbr;
?>
<form name='form_gm_msg' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'>           
	<tr>
          <td><input name='gm_msg' type='text' value='<?echo $gm_msg;?>' size='60' maxlength='40'></td>
	</tr>
	<tr>
          <td align="center"><input name='submit' type='submit' value='Submit'> <input name='reset' type='reset' value='Renew'></td>
	</tr>
  </table>
</form>
<?}

echo $rowbr;
?>

<center><a href="http://tk3.clan.su"><i>Thank Vaflan For This MMW!</i></a></center>