<?PHP
// All Tested and Work 100%!
// Decode By Vaflan v2.0 For MyMuWeb
// http://www.mymuweb.ru/

Header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
//Header("Cache-control: max-age=86400");
Header("Content-type: image/png");
Header("Pragma: no-cache");

$size = 40;
$pixelSize = $size/8;
$img = ImageCreate($size,$size);
$hex = stripslashes($_GET['decode']);
if(@preg_match('/[^a-fA-F0-9]/',$hex) || empty($hex))
	{$hex = '0044450004445550441551554515515655555566551551660551166000566600';}

for($y=0;$y<8;$y++) {
    for($x=0;$x<8;$x++) {
        $offset=($y*8)+$x;

	if(substr($hex,$offset,1) == '0'){$c = array('250','250','250','127');} // BackGround WebSite Color
	elseif(substr($hex,$offset,1) == '1'){$c = array('0','0','0','0');}
	elseif(substr($hex,$offset,1) == '2'){$c = array('128','128','128','0');}
	elseif(substr($hex,$offset,1) == '3'){$c = array('255','255','255','0');}
	elseif(substr($hex,$offset,1) == '4'){$c = array('255','0','0','0');}
	elseif(substr($hex,$offset,1) == '5'){$c = array('255','128','0','0');}
	elseif(substr($hex,$offset,1) == '6'){$c = array('255','255','0','0');}
	elseif(substr($hex,$offset,1) == '7'){$c = array('128','255','0','0');}
	elseif(substr($hex,$offset,1) == '8'){$c = array('0','255','0','0');}
	elseif(substr($hex,$offset,1) == '9'){$c = array('0','255','128','0');}
	elseif(substr($hex,$offset,1) == 'a'){$c = array('0','255','255','0');}
	elseif(substr($hex,$offset,1) == 'b'){$c = array('0','128','255','0');}
	elseif(substr($hex,$offset,1) == 'c'){$c = array('0','0','255','0');}
	elseif(substr($hex,$offset,1) == 'd'){$c = array('128','0','255','0');}
	elseif(substr($hex,$offset,1) == 'e'){$c = array('255','0','255','0');}
	elseif(substr($hex,$offset,1) == 'f'){$c = array('255','0','128','0');}
	else{$c = array('255','255','255','0');}

	$row[$x] = $x*$pixelSize;
	$row[$y] = $y*$pixelSize;
	$row2[$x] = $row[$x] + $pixelSize;
	$row2[$y] = $row[$y] + $pixelSize;
	$color[$y][$x] = ImageColorAllocateAlpha($img, $c[0], $c[1], $c[2], $c[3]);
	ImageFilleDrectangle($img, $row[$x], $row[$y], $row2[$x], $row2[$y], $color[$y][$x]);
    }
}

ImagePNG($img);
ImageDestroy($img);
?>