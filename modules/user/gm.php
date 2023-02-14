<?PHP
if(isset($_POST[hex_wh])){require("includes/character.class.php");option::edit_warehouse($_POST[hex_wh]); echo $rowbr;}
if(isset($_POST[gm_msg])){require("includes/character.class.php");option::gm_msg($_POST[gm_msg]); echo $rowbr;}
if(isset($_POST[gm_block])){require("includes/character.class.php");option::gm_block($_POST[acc_mode]); echo $rowbr;}
 if($_SESSION[mmw_status] < 1) { Die("HACKER DETECTED!");}

  echo'<table class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="100" align="right">Your Level:</td>
      <td><b>'.$_SESSION["mmw_status"].' ('.$mmw[status_rules][$_SESSION[mmw_status]][name].')</b></td>
    </tr>
    <tr>
      <td align="right">Security Code:</td>
      <td><b>'.$mmw[admin_securitycode].'</b></td>
    </tr>
    <tr>
      <td align="right">Admin Area:</td>
      <td><a target="_blank" href="admin.php">Enter</a></td>
    </tr>
  </table>';


echo $rowbr;

if($mmw[status_rules][$_SESSION[mmw_status]][hex_wh] == 1) {
 echo "<center><b>HEX Ware House Can Edit!</b></center>" . $rowbr;
 //HEX WH
 mssql_query("declare @vault varbinary(1920); set @vault=(SELECT Items FROM warehouse where AccountId='$login'); print @vault;");
 $vault = substr(mssql_get_last_message(),2);
 $result = mssql_query("SELECT Money,extMoney FROM warehouse WHERE accountid='$login'");
 $row = mssql_fetch_row($result);
?>
<form name='edit_wh' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='90%'>           
	<tr>
          <td align="center" colspan="2"><textarea name="hex_wh" rows="12" style="width: 100%;"><?echo $vault;?></textarea></td>
	</tr>
	<tr>
          <td align="center"><?echo mmw_lang_ware_house;?>: <input name='Money' type='text' value='<?echo $row[0];?>' size='14'></td>
          <td align="center"><?echo mmw_lang_extra_ware_house;?>: <input name='extMoney' type='text' value='<?echo $row[1];?>' size='14'></td>
	</tr>
	<tr>
          <td align="center" colspan="2"><input name='submit' type='submit' value='Submit'> <input name='reset' type='reset' value='Renew'></td>
	</tr>
  </table>
</form>
<?
echo $rowbr;
}


if($mmw[status_rules][$_SESSION[mmw_status]][gm_msg] == 1) {
 echo "<center><b>GameMaster Chat In Game!</b></center>" . $rowbr;
 if(isset($_POST[gm_msg])) {$gm_msg = $_POST[gm_msg];}
 else {$gm_msg = "$char: TEXT";}
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
<?
echo $rowbr;
}


if($mmw[status_rules][$_SESSION[mmw_status]][gm_block] == 1) {
 echo "<center><b>Set Block and UnBlock acc!</b></center>" . $rowbr;
 $result = mssql_query("SELECT memb___id FROM MEMB_INFO WHERE bloc_code='1' ORDER BY block_date ASC");
 if(@mssql_num_rows($result) <= 0) {$blocked = "<option value=''>No Account</option>";}
 else {
  for($i=0;$i<mssql_num_rows($result);++$i) {
   $row = mssql_fetch_row($result);
   $blocked .= "<option value='$row[0]'>$row[0]</option>";
  }
 }
?>
<script language="javascript">
function select_block() {
 var select = document.form_gm_block_acc.acc_mode.value;
 document.getElementById('block0').style.display = 'none';
 document.getElementById('block1').style.display = 'none';
 document.getElementById('block'+select).style.display = '';
}
</script>

<form name='form_gm_block_acc' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'>
	<tr>
	  <td align="right">Mode:</td>
	  <td><select name="acc_mode" size="1" onChange="select_block();"><option value='1'>Blocked</option><option value='0'>UnBlock</option></select></td>
	</tr>
    <tbody id="block1">
	<tr>
          <td align="right"><?echo mmw_lang_account;?>:</td>
          <td><input name='account' type='text' value='' size='12' maxlength='10'></td>
	</tr>
	<tr>
          <td align="right"><?echo mmw_lang_character;?>:</td>
          <td><input name='character' type='text' value='' size='12' maxlength='10'></td>
	</tr>
	<tr>
	  <td align="right">Block Time:</td>
	  <td><select name="unblock_time" size="1"><option value='0'>Forever</option><option value='1800'>30 m</option><option value='3600'>1 h</option><option value='21600'>6 h</option><option value='43200'>12 h</option><option value='86400'>1 day</option><option value='172800'>2 day</option><option value='259200'>3 day</option><option value='432000'>5 day</option><option value='864000'>10 day</option><option value='2592000'>30 day</option></select></td>
	</tr>
	<tr>
	  <td align="right">Block Date:</td>
	  <td><select name="block_date" size="1"><option value='0'>Not Select Day</option><option value='no'>Has been Blocked</option><option value='yes'>Today <?echo date("H:i");?></option></select></td>
	</tr>
	<tr>
	  <td align="right">Block Reason:</td>
	  <td><input name="block_reason" type="text" value="" size="17" maxlength="200"></td>
	</tr>
    </tbody>
    <tbody id="block0" style="display:none;">
	<tr>
          <td align="right"><?echo mmw_lang_account;?>:</td>
          <td><select name="account_unblock" size="1"><?echo $blocked;?></select></td>
	</tr>
    </tbody>
	<tr>
          <td colspan="2" align="center"><input name='submit' type='submit' value='Submit'> <input type='hidden' name='gm_block' value='gm_bock'> <input name='reset' type='reset' value='Renew'></td>
	</tr>
  </table>
</form>
<?
echo $rowbr;
}
?>

<center><a href="http://mmw.clan.su"><i>Thank Vaflan For This MMW!</i></a></center>
