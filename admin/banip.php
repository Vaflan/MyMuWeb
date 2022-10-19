<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Ban System by Vaflan
$banIpFile = __DIR__ . '/../includes/banip.dat';

if (isset($_POST['base'])) {
	file_put_contents($banIpFile, stripslashes($_POST['base']));
	echo $mmw['warning']['green'] . 'Ban IP list SuccessFully Edited!';
	writelog('a_banip', 'Ban IP Has Been <b style="color:#F00">Edited</b> Author: ' . $_SESSION['admin']['account']);
}
$banIpData = @file_get_contents($banIpFile);
?>
<script>
function add_banip() {
	var reason = '';
	if (document.banner_from.reason.value !== 'Reason') {
		reason = ' | ' + document.banner_from.reason.value;
	}
	var add = document.banner_from.ip.value + reason + '\n';
	document.banner_from.base.value = add + document.banner_from.base.value;
	if (confirm('IP has been add, save ip to base of banip?')) {
		document.banner_from.submit();
	}
}
</script>

<fieldset class="content">
	<legend>Banned IP</legend>
	<form action="" method="post" name="banner_from" id="banner_from">
		<input type="text" name="ip" id="ip" value="127.0.0.1" maxlength="15" size="15">
		<input type="text" name="reason" id="reason" value="Reason" size="35">
		<input type="button" value="ADD" class="button" onclick="return add_banip();"><br>
		<textarea name="base" id="base" style="width:330px;height:160px"><?php echo $banIpData; ?></textarea><br>
		<input type="submit" value="Save" class="button">
		<input type="reset" value="Reset" class="button">
	</form>
</fieldset>
