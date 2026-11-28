<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Request for Administrator
$requestFile = '../logs/request.htm';

if (isset($_POST['clean'])) {
	$fp = fopen($requestFile, 'w');
	fputs($fp, '<hr>');
	fclose($fp);
	echo $mmw['warning']['green'] . 'Request SuccessFully Cleaned!';
	writelog('a_request', 'Request Has Been <b style="color:#F00">Cleaned</b> Author: ' . $_SESSION['admin']['account']);
}
?>
<fieldset class="content">
	<legend>Request from Accounts</legend>
	<form method="post" action="" style="margin:0; text-align:center">
		<?php echo @file_get_contents($requestFile); ?>
		<input type="hidden" value="clean" name="clean">
		<input type="submit" style="font-weight:bold" value="Clean">
	</form>
</fieldset>
