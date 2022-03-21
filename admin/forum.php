<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Editor Forum Catalog for Administrator
$forum_catalog = 'includes/forum_catalog.php';
if(isset($_POST[forum])) {
 include($forum_catalog);
 $array_list = "<?PHP\n\$mmw[forum_catalog] = array(\n";
 foreach($mmw[forum_catalog] as $key => $value) {
  if(!empty($_POST["key$key"])) {
	$id = $_POST["key$key"];
	$name = $_POST["name$key"];
	$notice = $_POST["notice$key"];
	$status = $_POST["status$key"];
	$array_list .= " $id => array('$name','$notice',$status),\n";
  }
 }
 if(!empty($_POST[keynew])) {
	$array_list .= " $_POST[keynew] => array('$_POST[namenew]','$_POST[noticenew]',$_POST[statusnew]),\n";
 }
 $array_list .= ");\n?>";

 $code = str_replace('<','&#60;',str_replace("\n",' ',$array_list));

 $fd = fopen($forum_catalog, "w");
 fwrite($fd, $array_list);
 fclose($fd);
 echo "$warning_green Forum Catalog SuccessFully Edited!";
 writelog("a_forum","Forum Catalog Has Been <font color=#FF0000>Edited</font> Array: $code");
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Editor Forum Catalog for Administrator</legend>

<form method="post" name="forum" action="" style="margin:0px">
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Name</td>
  <td align="left">Notice</td>
  <td align="left">Add</td>
  <td align="center" width="40">Topics</td>
  <td align="center" width="40">Delete</td>
 </tr></thead>
<?
include($forum_catalog);
foreach($mmw[forum_catalog] as $key => $value) {
 $result = mssql_query("SELECT count(f_id) FROM MMW_forum WHERE f_catalog='$key'");
 $row = mssql_fetch_row($result);
 $status = '';
 if($value[2]==1) {$status[1] = "selected";} else {$status[0] = "selected";}
?>
 <tr id="catalog<?echo $key;?>">
  <td align="center"><input type="text" name="key<?echo $key;?>" value="<?echo $key;?>" size="1"></td>
  <td align="left"><input type="text" name="name<?echo $key;?>" value="<?echo $value[0];?>" style="width: 100%;"></td>
  <td align="left"><input type="text" name="notice<?echo $key;?>" value="<?echo $value[1];?>" style="width: 100%;"></td>
  <td align="left"><select name="status<?echo $key;?>" style="width: 100%;"><option value="0" <?echo $status[0];?>>All Members</option><option value="1" <?echo $status[1];?>>Only GM</option></select></td>
  <td align="center"><?echo $row[0];?></td>
  <td align="center"><input type="button" value="Delete" onclick="document.getElementById('catalog<?echo $key;?>').innerHTML='';"></td>
 </tr>
<?}?>
 <tr id="catalognew">
  <td align="center"><input type="text" name="keynew" value="" size="1"></td>
  <td align="left"><input type="text" name="namenew" value="" style="width: 100%;"></td>
  <td align="left"><input type="text" name="noticenew" value="" style="width: 100%;"></td>
  <td align="left"><select name="statusnew" style="width: 100%;"><option value="0">All Members</option><option value="1">Only GM</option></select></td>
  <td align="center">New</td>
  <td align="center"><input type="button" value="Delete" onclick="document.getElementById('catalognew').innerHTML='';"></td>
 </tr>
</table>
 <div style="text-align:center;"><input type="submit" value=" Save Forum "> <input type="hidden" name="forum" value="forum"> <input type="button" value=" Renew Forum " onclick="window.location='?op=forum';"></div>
</form>

		</fieldset>
		</td>
	</tr>
</table>