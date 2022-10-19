<?php
// BackUp Web System v1.0 by Vaflan
// Only for MyMuWeb MSSQL 2000 Year
$backup = '%database%_%year%-%month%-%day%.bak';
$dir = __DIR__ . '/../includes/backup/';

if ($_POST['backup'] === 'new') {
	$file = str_replace(
		array('%database%', '%year%', '%month%', '%day%'),
		array($mmw['sql']['database'], date('Y'), date('m'), date('d')),
		$backup
	);
	$query = "BACKUP DATABASE [{$mmw['sql']['database']}] 
		TO DISK = N'{$dir}{$file}' WITH NAME = N'{$mmw['sql']['database']} BackUp',
		INIT, NOFORMAT, NOSKIP, NOREWIND, NOUNLOAD, STATS = 10";
	if (@mssql_query($query)) {
		echo $mmw['warning']['green'] . 'New BackUp ' . $file . ' DataBase successFully created!';
		writelog('a_backup', 'BackUp Has Been <b style="color:#F00">Created New</b> ' . $dir . $file . ' DataBase');
	} else {
		echo $mmw['warning']['red'] . 'New BackUp ' . $file . ' DataBase has been error!';
	}
}
if (isset($_POST['restore'])) {
	$query = "USE master; RESTORE DATABASE MuOnline FROM DISK='{$dir}{$_POST['restore']}'; USE {$mmw['sql']['database']};";
	if (@mssql_query($query)) {
		echo $mmw['warning']['green'] . 'BackUp ' . $_POST['restore'] . ' DataBase successFully restored!';
		writelog('a_backup', 'BackUp Has Been <b style="color:#F00">Restored</b> ' . $dir . $_POST['restore'] . ' DataBase');
	} else {
		echo $mmw['warning']['red'] . 'Restore BackUp ' . $_POST['restore'] . ' DataBase has been error!';
	}
}
if (isset($_POST['delete'])) {
	unlink($dir . $_POST['delete']);
	echo $mmw['warning']['green'] . 'BackUp ' . $_POST['delete'] . ' DataBase successFully deleted!';
	writelog('a_backup', 'BackUp Has Been <b style="color:#F00">Deleted</b> ' . $dir . $_POST['delete'] . ' DataBase');
}
?>
<fieldset class="content">
	<legend>Back Up - DataBase</legend>
	<?php
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file, -3) === 'bak') {
				?>
				<div style="padding:4px;text-align:left">
					<span style="float:right">
						<form action="" method="post">
							<input type="hidden" name="restore" value="<?php echo $file; ?>">
							<input type="submit" value="Restore">
						</form>
						<form action="" method="post">
							<input type="hidden" name="delete" value="<?php echo $file; ?>">
							<input type="submit" value="Delete">
						</form>
					</span>
					<?php echo $file; ?> [<?php echo filesize($dir . $file); ?> byte]
				</div>
				<?php
			}
		}
		closedir($dh);
	}
	?>

	<form action="" method="post" style="text-align:center">
		<input name="backup" type="hidden" value="new">
		<input type="submit" value="Creat New Back Up - <?php echo $mmw['sql']['database']; ?> DataBase">
	</form>
</fieldset>