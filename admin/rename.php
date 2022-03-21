<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}
if(isset($_POST["name_char"])){rename_char($_POST['name_char'],$_POST['rename_char']);}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Rename Character</legend>
			<form action="" method="post" name="search_" id="search_">
			<table width="100%" border="0" cellspacing="2" cellpadding="0">
			  <tr>
			    <td width="42%" align="right">Character</td>
			    <td><input name="name_char" type="text" id="name_char" size="17" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td align="right">Rename To</td>
			    <td><input name="rename_char" type="text" id="rename_char" size="17" maxlength="10"></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><input type="submit" name="Submit" value="Rename Character"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
</table>