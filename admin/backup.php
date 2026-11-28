<?php
// BackUp Web System v1.0 by Vaflan
// Only for MyMuWeb MSSQL 2000 Year
$backup = '%database%_%year%-%month%-%day%.bak';
$dir = __DIR__ . '/../includes/backup/';

if (isset($_POST['backup']) && $_POST['backup'] === 'new') {
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
	// SECURITY FIX: the posted name was concatenated into both a file path and a
	// quoted string inside RESTORE DATABASE, so a traversal sequence reached
	// arbitrary paths and a quote broke out of the literal. Accept a plain .bak
	// file name only.
	$restoreFile = basename($_POST['restore']);
	if (preg_match('/^[\w\-]+\.bak$/i', $restoreFile)) {
		$query = "USE master; RESTORE DATABASE MuOnline FROM DISK='{$dir}{$restoreFile}'; USE {$mmw['sql']['database']};";
		if (@mssql_query($query)) {
			echo $mmw['warning']['green'] . 'BackUp ' . $restoreFile . ' DataBase successFully restored!';
			writelog('a_backup', 'BackUp Has Been <b style="color:#F00">Restored</b> ' . $dir . $restoreFile . ' DataBase');
		} else {
			echo $mmw['warning']['red'] . 'Restore BackUp ' . $restoreFile . ' DataBase has been error!';
		}
	} else {
		echo $mmw['warning']['red'] . 'Invalid backup file name!';
	}
}
if (isset($_POST['delete'])) {
	// SECURITY FIX: same traversal problem on the delete path.
	$deleteFile = basename($_POST['delete']);
	if (preg_match('/^[\w\-]+\.bak$/i', $deleteFile)) {
		unlink($dir . $deleteFile);
		echo $mmw['warning']['green'] . 'BackUp ' . $deleteFile . ' DataBase successFully deleted!';
		writelog('a_backup', 'BackUp Has Been <b style="color:#F00">Deleted</b> ' . $dir . $deleteFile . ' DataBase');
	} else {
		echo $mmw['warning']['red'] . 'Invalid backup file name!';
	}
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