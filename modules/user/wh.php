<?if($acc_online_check=="0"){

if(isset($_POST["zen"])){require("includes/character.class.php");option::warehouse($_POST["from_wh"],$_POST["to_wh"],$_POST["zen"]); echo $divbr;}

$result = mssql_query("SELECT AccountID,Money,extMoney FROM warehouse WHERE accountid='$login'");
$row = mssql_fetch_row($result);

if($row[0]!="" && $row[0]!=" ") {
// Money
if($row[2]=="" || $row[2]==" ") {$row[2]="0";}
echo "
<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='300'>           
	<tr>
          <td title='Name'>Name</td>
          <td title='Zen'>Zen</td>
          <td width='42' title='Max Zen'>Max Zen</td>
	</tr>
	<tr>
            <td>Extra Ware House</td>
            <td style='color:#CCCCCC;'>".number_format($row[2])."</td>
            <td>~</td>
	</tr>
	<tr>
            <td>Ware House</td>
            <td>".number_format($row[1])."</td>
            <td>2kkk</td>
	</tr>
	";

	$select_form = "<option value='ewh'>Extra Ware House</option><option value='wh0'>Ware House</option>";

$result = mssql_query("SELECT AccountID,Name,Money FROM character WHERE accountid='$login'");
for($i=0;$i < mssql_num_rows($result);++$i)
  {
	$row = mssql_fetch_row($result);
echo "
	<tr>
            <td>$row[1]</td>
            <td>".number_format($row[2])."</td>
            <td>2kkk</td>
	</tr>
";

	$select_form = $select_form . "<option value='ch$row[1]'>$row[1]</option>";
  }
?>
</table>

<?echo $rowbr;?>

<form name='send_money' method='post' action=''>
  <table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0' width='300'>           
	<tr>
          <td>From</td>
          <td><select name='from_wh'><?echo $select_form;?></select></td>
	</tr>
	<tr>
          <td>To</td>
          <td><select name='to_wh'><?echo $select_form;?></select></td>
	</tr>
	<tr>
          <td>Zen</td>
          <td><input name='zen' type='text' id='zen' value='0' maxlength='10' size='14'> <input name='submit' type='submit' value='Send'></td>
	</tr>
  </table>
</form>

<?}else{echo "$die_start Please, check Vault Keeper in Game! $die_end";}?>

<?}elseif($acc_online_check=="1"){echo "$die_start Account Is Online, Must Be Logged Off! $die_end";}else{echo "$die_start Stupid Hacker! :@ $die_end";}?>