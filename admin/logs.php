<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}
if(isset($_POST["log_name"])) {clear_logs($_POST["log_name"]);}

if($dh = opendir('logs')) {
     while (($file = readdir($dh)) !== false) {
	  $format = substr($file, -3);
	  if($format == 'php') {
		$num = $num + 1;
		$file_name = substr($file, 0, -4);
		if($_SESSION[a_admin_level] > 6)
		 {$clear_log = '<form action="" method="post" name="clear11" id="clear11"><input name="log_name" type="hidden" id="log_name" value="'.$file_name.'"> <input type="submit" name="Submit" value="Clear"></form>';}

		if(substr($file_name,0,2)=='a_') {
		 $admin_logs .= '<tr><td width="50%"><a href="logs.php?log='.$file_name.'" target="_blank">'.$file_name.'</a> ['.filesize("logs/$file").' byte]</td><td align="right">'.$clear_log.'</td></tr>';
		}
		else {
		 $other_logs .= '<tr><td width="50%"><a href="logs.php?log='.$file_name.'" target="_blank">'.$file_name.'</a> ['.filesize("logs/$file").' byte]</td><td align="right">'.$clear_log.'</td></tr>';
		}
	  }
     }
     closedir($dh);
}
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>All Exect Logs</legend>
		 <?if(!empty($admin_logs)) {?>
			<b>Logs By Admin Panel</b>
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
				<?echo $admin_logs;?>
			</table>
		 <?}?>
		 <?if(!empty($other_logs)) {?>
			<b>Logs By Main Web</b>
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
				<?echo $other_logs;?>
			</table>
		 <?}?>
		</fieldset>
		</td>
	</tr>
</table>