<?php
// All Tested and Work 100%!
// Decode By Vaflan v1.2
// http://tk3.clan.su
// For MyMuWeb

$size = 40;
$pixelSize = $size/8;
$img = ImageCreate($size,$size);
$hex = $_GET['decode'];
if(@preg_match('/[^a-zA-Z0-9]/',$hex) || $hex == '')
	{$hex = '0044450004445550441551554515515655555566551551660551166000566600';}
else
	{$hex = stripslashes($hex);}

for ($y=0;$y<8;$y++){
    for ($x=0;$x<8;$x++){
        $offset=($y*8)+$x;

	if(substr($hex, $offset, 1) == '0'){$c1 = "255"; $c2 = "255"; $c3 = "255";} // BackGround WebSite Color
	elseif(substr($hex, $offset, 1) == '1'){$c1 = "0"; $c2 = "0"; $c3 = "0";}
	elseif(substr($hex, $offset, 1) == '2'){$c1 = "128"; $c2 = "128"; $c3 = "128";}
	elseif(substr($hex, $offset, 1) == '3'){$c1 = "255"; $c2 = "255"; $c3 = "255";}
	elseif(substr($hex, $offset, 1) == '4'){$c1 = "255"; $c2 = "0"; $c3 = "0";}
	elseif(substr($hex, $offset, 1) == '5'){$c1 = "255"; $c2 = "128"; $c3 = "0";}
	elseif(substr($hex, $offset, 1) == '6'){$c1 = "255"; $c2 = "255"; $c3 = "0";}
	elseif(substr($hex, $offset, 1) == '7'){$c1 = "128"; $c2 = "255"; $c3 = "0";}
	elseif(substr($hex, $offset, 1) == '8'){$c1 = "0"; $c2 = "255"; $c3 = "0";}
	elseif(substr($hex, $offset, 1) == '9'){$c1 = "0"; $c2 = "255"; $c3 = "128";}
	elseif(substr($hex, $offset, 1) == 'a'){$c1 = "0"; $c2 = "255"; $c3 = "255";}
	elseif(substr($hex, $offset, 1) == 'b'){$c1 = "0"; $c2 = "128"; $c3 = "255";}
	elseif(substr($hex, $offset, 1) == 'c'){$c1 = "0"; $c2 = "0"; $c3 = "255";}
	elseif(substr($hex, $offset, 1) == 'd'){$c1 = "128"; $c2 = "0"; $c3 = "255";}
	elseif(substr($hex, $offset, 1) == 'e'){$c1 = "255"; $c2 = "0"; $c3 = "255";}
	elseif(substr($hex, $offset, 1) == 'f'){$c1 = "255"; $c2 = "0"; $c3 = "128";}
	else{$c1 = "255"; $c2 = "255"; $c3 = "255";}

	$row[$x] = $x*$pixelSize;
	$row[$y] = $y*$pixelSize;
	$row2[$x] = $row[$x] + $pixelSize;
	$row2[$y] = $row[$y] + $pixelSize;
	$color[$y][$x] = imagecolorallocate($img, $c1, $c2, $c3);
	imagefilledrectangle($img, $row[$x], $row[$y], $row2[$x], $row2[$y], $color[$y][$x]);
    }
}

Header("Content-type: image/png");
Header("Pragma: no-cache");
Imagepng($img);
Imagedestroy($img);
?>