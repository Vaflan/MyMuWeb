<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// ADS and PopUnder in Web
$ads_file = 'ads.txt';
$popunder_file = 'popunder.txt';

if(isset($_POST[ads])) {
 $new_db = stripslashes($_POST[ads]);
 $fp = fopen($ads_file,"w");
 fputs($fp, $new_db);
 fclose($fp);
 echo "$warning_green ADS SuccessFully Edited!";

 $log_dat = "ADS Has Been <font color=#FF0000>Edited</font> Author: $_SESSION[a_admin_login]";
 writelog("a_ads",$log_dat);
}
if(isset($_POST[popunder])) {
 $new_db = stripslashes($_POST[popunder]);
 $fp = fopen($popunder_file,"w");
 fputs($fp, $new_db);
 fclose($fp);
 echo "$warning_green PopUnder SuccessFully Edited!";

 $log_dat = "PopUnder Has Been <font color=#FF0000>Edited</font> Author: $_SESSION[a_admin_login]";
 writelog("a_ads",$log_dat);
}

$popunder_size = @filesize($popunder_file);
if($popunder_size > 0) {
 $popunder_open = @fopen($popunder_file,'r');
 $popunder_read = @fread($popunder_open,$popunder_size);
 @fclose($popunder_open);
}
$ads_size = @filesize($ads_file);
if($ads_size > 0) {
 $ads_open = @fopen($ads_file,'r');
 $ads_read = @fread($ads_open,$ads_size);
 @fclose($ads_open);
}
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>ADS</legend>
			<form method="post" name="ads" action="" style="margin:0px">
			<center>
			 <textarea name="ads" style="width:90%;height:160px;"><?echo $ads_read;?></textarea><br>
			 <input style="font-weight:bold;" type="submit" value="Edit">  <input type="reset" value="Reset">
			</center>
			</form>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td align="center">
		<fieldset>
		<legend>PopUnder</legend>
			<form method="post" name="popunder" action="" style="margin:0px">
			<center>
			 <textarea name="popunder" style="width:90%;height:160px;"><?echo $popunder_read;?></textarea><br>
			 <input style="font-weight:bold;" type="submit" value="Edit">  <input type="reset" value="Reset">
			</center>
			</form>
		</fieldset>
		</td>
	</tr>
</table>