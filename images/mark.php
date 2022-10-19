<?php
// All Tested and Work 100%!
// Decode By Vaflan v2.1 For MyMuWeb
// http://www.mymuweb.ru/

header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: max-age=86400');
header('Content-type: image/png');
header('Pragma: no-cache');

define('ROW_COUNT', 8);

$hex = $_GET['decode'];
if (empty($hex) || preg_match('/[^a-fA-F0-9]/', $hex)) {
	$hex = '0044450004445550441551554515515655555566551551660551166000566600';
}

$size = 40;
$pixelSize = $size / ROW_COUNT;
$img = imagecreate($size, $size);

$colorData = array(
	'0' => array('250', '250', '250', '127'),
	'1' => array('0', '0', '0', '0'),
	'2' => array('128', '128', '128', '0'),
	'3' => array('255', '255', '255', '0'),
	'4' => array('255', '0', '0', '0'),
	'5' => array('255', '128', '0', '0'),
	'6' => array('255', '255', '0', '0'),
	'7' => array('128', '255', '0', '0'),
	'8' => array('0', '255', '0', '0'),
	'9' => array('0', '255', '128', '0'),
	'a' => array('0', '255', '255', '0'),
	'b' => array('0', '128', '255', '0'),
	'c' => array('0', '0', '255', '0'),
	'd' => array('128', '0', '255', '0'),
	'e' => array('255', '0', '255', '0'),
	'f' => array('255', '0', '128', '0'),
);

for ($y = 0; $y < ROW_COUNT; $y++) {
	for ($x = 0; $x < ROW_COUNT; $x++) {
		$offset = ($y * ROW_COUNT) + $x;

		$c = $colorData[substr($hex, $offset, 1)];

		$row[$x] = $x * $pixelSize;
		$row[$y] = $y * $pixelSize;
		$row2[$x] = $row[$x] + $pixelSize;
		$row2[$y] = $row[$y] + $pixelSize;
		$color[$y][$x] = ImageColorAllocateAlpha($img, $c[0], $c[1], $c[2], $c[3]);
		ImageFilleDrectangle($img, $row[$x], $row[$y], $row2[$x], $row2[$y], $color[$y][$x]);
	}
}

imagepng($img);
imagedestroy($img);
