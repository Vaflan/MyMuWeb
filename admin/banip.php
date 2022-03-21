<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}

$banip_file = 'includes/banip.dat';

if(isset($_POST['base'])) {
 $fd = fopen($banip_file, "w");
 fwrite($fd, stripslashes($_POST['base']));
 fclose($fd);
 echo "$warning_green Ban IP list SuccessFully Edited!";

 $log_dat = "Ban IP Has Been <font color=#FF0000>Edited</font> Author: $_SESSION[a_admin_login]";
 writelog("a_banip",$log_dat);
}

$banip_open = @fopen($banip_file,'r');
$banip_read = @fread($banip_open,@filesize($banip_file));
@fclose($banip_open);
?>
<script language="javascript">
function add_banip() {
 reason = '';
 if(document.banner_from.reason.value != 'Reason') {
  reason = ' | ' + document.banner_from.reason.value;
 }
 add = document.banner_from.ip.value + reason + '\n';
 document.banner_from.base.value = add + document.banner_from.base.value;
 var request_save = confirm("IP has been add, save ip to base of banip?");
 if(request_save) {// by Vaflan
  document.banner_from.submit();
 }
}
</script>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>Banned IP</legend>
			<form action="" method="post" name="banner_from" id="banner_from">
			 <input name="ip" type="text" id="ip" value="127.0.0.1" maxlength="15" size="15"> <input name="reason" type="text" id="reason" value="Reason" size="35"> <input type="button" value="ADD" class="button" onclick="return add_banip();"><br>
			 <textarea name="base" id="base" style="width:330px; height: 160px;"><?echo $banip_read;?></textarea><br>
			 <input type="submit" value="Save" class="button"> <input type="reset" name="Reset" value="Reset" class="button">
			</form>
		</fieldset>
		</td>
	</tr>
</table>