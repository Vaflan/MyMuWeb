<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// Request for Administrator
$request = 'admin/request.htm';

if(isset($_POST[clean])) {
 $fp = fopen($request,"w");
 fputs($fp, '<hr>');
 fclose($fp);
 echo "$warning_green Request SuccessFully Cleaned!";
 writelog("a_request","Request Has Been <font color=#FF0000>Cleaned</font> Author: $_SESSION[a_admin_login]");
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Request for Administrator</legend>
			<form method="post" name="ads" action="" style="margin:0px">
			<center>
			 <?echo @implode('', @file($request));?>
			 <input type="hidden" value="clean" name="clean"> <input style="font-weight:bold;" type="submit" value="Clean">
			</center>
			</form>
		</fieldset>
		</td>
	</tr>
</table>