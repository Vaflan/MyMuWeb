<?php
$hour = date('H');
$minutes = date('i');
$dayOutOfTime = $hour . $minutes;

$bct = ($minutes >= 30)
	? $hour + 1
	: $hour;

if ($dayOutOfTime < 145) {
	$cct = 1;
} elseif ($dayOutOfTime < 345) {
	$cct = 3;
} elseif ($dayOutOfTime < 545) {
	$cct = 5;
} elseif ($dayOutOfTime < 745) {
	$cct = 7;
} elseif ($dayOutOfTime < 945) {
	$cct = 9;
} elseif ($dayOutOfTime < 1145) {
	$cct = 11;
} elseif ($dayOutOfTime < 1345) {
	$cct = 13;
} elseif ($dayOutOfTime < 1545) {
	$cct = 15;
} elseif ($dayOutOfTime < 1745) {
	$cct = 17;
} elseif ($dayOutOfTime < 1945) {
	$cct = 19;
} elseif ($dayOutOfTime < 2145) {
	$cct = 21;
} else {
	$cct = 23;
}

if ($dayOutOfTime < 100) {
	$dst = 1;
} elseif ($dayOutOfTime < 300) {
	$dst = 3;
} elseif ($dayOutOfTime < 500) {
	$dst = 5;
} elseif ($dayOutOfTime < 700) {
	$dst = 7;
} elseif ($dayOutOfTime < 900) {
	$dst = 9;
} elseif ($dayOutOfTime < 1100) {
	$dst = 11;
} elseif ($dayOutOfTime < 1300) {
	$dst = 13;
} elseif ($dayOutOfTime < 1500) {
	$dst = 15;
} elseif ($dayOutOfTime < 1700) {
	$dst = 17;
} elseif ($dayOutOfTime < 1900) {
	$dst = 19;
} elseif ($dayOutOfTime < 2100) {
	$dst = 21;
} else {
	$dst = 23;
}
?>

<span class="helpLink" id="time" title="<?php echo mmw_lang_server_time; ?>">
	<?php echo date('d.m.Y H:i:s'); ?>
</span><br>
Devil Square: <span id="dstime">Error: Turn on JavaScript</span><br>
Blood Castle: <span id="bctime">Error: Turn on JavaScript</span><br>
Chaos Castle: <span id="cctime">Error: Turn on JavaScript</span><br>

<script src="scripts/timejs.js"></script>
<script>
	var serverDate = new Date('<?php echo date('F d, Y H:i:s', time() + 1);?>');

	function padLength(what) {
		return (what.toString().length === 1) ? '0' + what : what;
	}

	function displayTime() {
		serverDate.setSeconds(serverDate.getSeconds() + 1);
		months = serverDate.getMonth() + 1;
		var dateString = padLength(serverDate.getDate()) + '.' + padLength(months) + '.' + serverDate.getFullYear();
		var timeString = padLength(serverDate.getHours()) + ':' + padLength(serverDate.getMinutes()) + ':' + padLength(serverDate.getSeconds());
		document.getElementById('time').innerHTML = dateString + ' ' + timeString;
	}
	setInterval('displayTime()', 1000);

	dstime('<?php echo $dst;?>', '00');
	bctime('<?php echo $bct;?>', '30');
	cctime('<?php echo $cct;?>', '45');
</script>
