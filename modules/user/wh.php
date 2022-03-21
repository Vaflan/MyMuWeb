<?if($acc_online_check=="0") {

if(isset($_POST["zen"])){require("includes/character.class.php");option::warehouse($_POST["from_wh"],$_POST["to_wh"],$_POST["zen"]); echo $rowbr;}
if(isset($_GET[item]) && isset($_POST[item_pirce])){require("includes/character.class.php");option::item_sell($_GET[item],$_POST[item_pirce]); echo $rowbr;}

$result = @mssql_query("SELECT AccountID,Money,extMoney FROM warehouse WHERE accountid='$login'");

if(@mssql_num_rows($result) > 0) {
 $row = mssql_fetch_row($result);
 if(empty($row[1]) || $row[1]==" ") {$row[1]="0";}
 if(empty($row[2]) || $row[2]==" ") {$row[2]="0";}
?>
<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='300'>
   <thead>
	<tr>
          <td><?echo mmw_lang_where;?></td>
          <td>Zen</td>
          <td width='50'>Max Zen</td>
	</tr>
   </thead>
	<tr>
            <td><?echo mmw_lang_extra_ware_house;?></td>
            <td><?echo number_format($row[2]);?></td>
            <td>~</td>
	</tr>
	<tr>
            <td><?echo mmw_lang_ware_house;?></td>
            <td><?echo number_format($row[1]);?></td>
            <td><?echo zen_format($mmw[max_char_wh_zen],'small');?></td>
	</tr>
<?
 $select_form = "<option value='ewh'>".mmw_lang_extra_ware_house."</option><option value='wh0'>".mmw_lang_ware_house."</option>";

 $result = mssql_query("SELECT AccountID,Name,Money FROM character WHERE accountid='$login'");
 for($i=0;$i < mssql_num_rows($result);++$i) {
  $row = mssql_fetch_row($result);
?>
	<tr>
            <td><?echo $row[1];?></td>
            <td><?echo number_format($row[2]);?></td>
            <td><?echo zen_format($mmw[max_char_wh_zen],'small');?></td>
	</tr>
<?
  $select_form = $select_form . "<option value='ch$row[1]'>$row[1]</option>";
 }
?>
</table>

<?echo $rowbr;?>

<form name='send_money' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='300'>           
	<tr>
          <td><?echo mmw_lang_zen_from;?></td>
          <td><select name='from_wh'><?echo $select_form;?></select></td>
	</tr>
	<tr>
          <td><?echo mmw_lang_zen_to;?></td>
          <td><select name='to_wh'><?echo $select_form;?></select></td>
	</tr>
	<tr>
          <td>Zen</td>
          <td><input name='zen' type='text' value='0' maxlength='10' size='14'> <input name='submit' type='submit' value='<?echo mmw_lang_send;?>'></td>
	</tr>
  </table>
</form>

<?}else{echo $die_start . mmw_lang_check_vault_keeper_in_game . $die_end;}?>

<?}elseif($acc_online_check=="1"){echo $die_start . mmw_lang_account_is_online_must_be_logged_off . $die_end;}else{echo "$die_start I find you Hacker! :) $die_end";}?>