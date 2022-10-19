<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

if (isset($_POST['log_name'])) {
	unlink(__DIR__ . '/../logs/' . $_POST['log_name']);
	echo $mmw['warning']['green'] . 'Log ' . $logfile . ' SuccessFully Deleted!';
}

$logList = array(
	'admin' => '',
	'other' => ''
);
if ($dh = opendir(__DIR__ . '/../logs')) {
	while (($file = readdir($dh)) !== false) {
		$format = substr($file, -3);
		if (in_array($format, array('htm', 'php'))) {
			$file_name = substr($file, 0, -4);
			$logGroup = (substr($file, 0, 2) === 'a_') ? 'admin' : 'other';
			$clear_log = '<form action="" method="post"><input type="hidden" name="log_name" value="' . $file . '"><input type="submit" value="Clear"></form>';
			$logList[$logGroup] .= '<tr><td width="50%"><a href="javascript:window.open(\'readlog.php?log=' . $file_name . '\',\'MyMuWeb\',\'width=800,height=540,left=10,top=10,scrollbars=1\');">' . $file_name . '</a> [' . filesize('../logs/' . $file) . ' byte]</td><td align="right">' . $clear_log . '</td></tr>';

		}
	}
	closedir($dh);
}
?>
<fieldset class="content">
	<legend>All Exect Logs</legend>
	<?php if (!empty($logList['admin'])) { ?>
		<b>Logs By Admin Panel</b>
		<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			<?php echo $logList['admin']; ?>
		</table>
	<?php } ?>
	<?php if (!empty($logList['other'])) { ?>
		<b>Logs By Main Web</b>
		<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			<?php echo $logList['other']; ?>
		</table>
	<?php } ?>
</fieldset>
