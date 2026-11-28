<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// ADS and PopUnder in Web
$adsFile = '../ADS.txt';
$popUnderFile = '../PopUnder.txt';

if (isset($_POST['ads'])) {
	if (file_put_contents($adsFile, $_POST['ads'])) {
		echo $mmw['warning']['green'] . 'ADS SuccessFully Edited!';
		writelog('a_ads', 'ADS Has Been <b style="color:#F00">Edited</b> Author: ' . $_SESSION['admin']['account']);
	} else {
		echo $mmw['warning']['red'] . 'ADS fail Edited!';
	}
}

if (isset($_POST['popunder'])) {
	if (file_put_contents($popUnderFile, $_POST['popunder'])) {
		echo $mmw['warning']['green'] . 'PopUnder SuccessFully Edited!';
		writelog('a_ads', 'PopUnder Has Been <b style="color:#F00">Edited</b> Author: ' . $_SESSION['admin']['account']);
	} else {
		echo $mmw['warning']['red'] . 'PopUnder fail Edited!';
	}
}

$popUnderRead = str_replace(array('&', '<'), array('&amp;', '&lt;'), @file_get_contents($popUnderFile));
$adsRead = str_replace(array('&', '<'), array('&amp;', '&lt;'), @file_get_contents($adsFile));
?>
<fieldset class="content">
	<legend><?php echo $adsFile; ?></legend>
	<form method="post" action="" style="margin:0;text-align:center">
		<textarea name="ads" style="width:90%;height:160px"><?php echo $adsRead; ?></textarea><br>
		<input style="font-weight:bold" type="submit" value="Edit">
		<input type="reset" value="Reset">
	</form>
</fieldset>
<fieldset class="content">
	<legend><?php echo $popUnderFile; ?></legend>
	<form method="post" action="" style="margin:0;text-align:center">
		<textarea name="popunder" style="width:90%;height:160px"><?php echo $popUnderRead; ?></textarea><br>
		<input style="font-weight:bold" type="submit" value="Edit">
		<input type="reset" value="Reset">
	</form>
</fieldset>