<?php

/////// Start Time Format ///////
function time_format($date,$format) {
$formated_time = "d M Y, T";

if($date[1]==" ") {
$day = $date[0];
$month = substr($date,2,3);
$year = substr($date,6,4);
$time = substr($date,10);
}
else {
$day = substr($date,0,2);
$month = substr($date,3,3);
$year = substr($date,7,4);
$time = substr($date,11);
}

if($month=='ÿíâ') {$month="Jan";} elseif($month=='ôåâ') {$month="Feb";}
elseif($month=='ìàð') {$month="Mar";} elseif($month=='àïð') {$month="Apr";}
elseif($month=='ìàé') {$month="May";} elseif($month=='èþí') {$month="Jun";}
elseif($month=='èþë') {$month="Jul";} elseif($month=='àâã') {$month="Aug";}
elseif($month=='ñåí') {$month="Sep";} elseif($month=='îêò') {$month="Oct";}
elseif($month=='íîÿ') {$month="Nov";} else {$month="Dec";}

$formated_time = str_replace("d",$day,$formated_time);
$formated_time = str_replace("M",$month,$formated_time);
$formated_time = str_replace("Y",$year,$formated_time);
$formated_time = str_replace("T",$time,$formated_time);

$end_time = date($format, strtotime($formated_time));
return $end_time;
}
/////// End Time Format ///////






/////// Start Date Formats ///////
function date_formats($stime, $etime, $format='short') {
		if (is_numeric($stime)) {$diff = $etime - $stime;}
		else {$diff = $etime - strtotime($stime);}
	
		$time = '';
		$seconds = 0;
		$hours = 0;
		$minutes = 0;

		if($diff % 86400 <= 0)  //there are 86,400 seconds in a day
		    {$days = $diff / 86400;}

		if($diff % 86400 > 0)   {   
			$rest = ($diff % 86400);
			$days = ($diff - $rest) / 86400;
			  
		       if( $rest % 3600 > 0 )
		       {   $rest1 = ($rest % 3600);
		           $hours = ($rest - $rest1) / 3600;
				  
		           if( $rest1 % 60 > 0 )
		           {   $rest2 = ($rest1 % 60);
		               $minutes = ($rest1 - $rest2) / 60;
		               $seconds = $rest2;
		           }else {
		               $minutes = $rest1 / 60;
					}
		       } else {
		           $hours = $rest / 3600; 
			   }
		}

		$times = (($days > 0) ? $days .' days ' : '' ). (($hours > 0 ) ? $hours .'h ' :'' ). $minutes .'m '.$seconds.'s';
		if ($format =='long') 	$times = (($days > 0) ? $days .' Days ' : '' ). (($hours > 0 && $hours != 12) ? $hours .' Hours ' :'' ). $minutes .' Minutes ';//.$seconds.' seconds';
		return $times;
}
/////// END Date Formats ///////






/////// Start BBCode Formats ///////
function bbcode($text) {
$bbcode = array(
"/\[br\]/is" => "<br>",
"/\[hr\]/is" => "<hr>",
"/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
"/\[i\](.*?)\[\/i\]/is" => "<i>$1</i>",
"/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>",
"/\[s\](.*?)\[\/s\]/is" => "<s>$1</s>",
"/\[o\](.*?)\[\/o\]/is" => "<span style='text-decoration: overline'>$1</span>",
"/\[c\](.*?)\[\/c\]/is" => "<div align=center>$1</div>",
"/\[l\](.*?)\[\/l\]/is" => "<div align=left>$1</div>",
"/\[r\](.*?)\[\/r\]/is" => "<div align=right>$1</div>",
"/\[sup\](.*?)\[\/sup\]/is" => "<sup>$1</sup>",
"/\[sub\](.*?)\[\/sub\]/is" => "<sub>$1</sub>",
"/\[img\](.*?)\[\/img\]/is" => "<img src=$1 border=0>",
"/\[color\=(.*?)\](.*?)\[\/color\]/is" => "<font color='$1'>$2</font>",
"/\[url\=(.*?)\](.*?)\[\/url\]/is" => "<a target='_blank' href='$1'>$2</a>"
);
$text = preg_replace(array_keys($bbcode), array_values($bbcode), $text);
return $text;
}
/////// END BBCode Formats ///////





/////// Start Smile Formats ///////
function smile($smile) {
   $smile = str_replace(" &gt;( "," <img src=images/smile/angry.gif border=0> ",$smile);
   $smile = str_replace(" :D "," <img src=images/smile/biggrin.gif border=0> ",$smile);
   $smile = str_replace(" B) "," <img src=images/smile/cool.gif border=0> ",$smile);
   $smile = str_replace(" ;( "," <img src=images/smile/cry.gif border=0> ",$smile);
   $smile = str_replace(" &lt;_&lt; "," <img src=images/smile/dry.gif border=0> ",$smile);
   $smile = str_replace(" ^_^ "," <img src=images/smile/happy.gif border=0> ",$smile);
   $smile = str_replace(" :( "," <img src=images/smile/sad.gif border=0> ",$smile);
   $smile = str_replace(" :) "," <img src=images/smile/smile.gif border=0> ",$smile);
   $smile = str_replace(" :o "," <img src=images/smile/surprised.gif border=0> ",$smile);
   $smile = str_replace(" :p "," <img src=images/smile/tongue.gif border=0> ",$smile);
   $smile = str_replace(" &#37;) "," <img src=images/smile/wacko.gif border=0> ",$smile);
   $smile = str_replace(" ;) "," <img src=images/smile/wink.gif border=0> ",$smile);
return $smile;
}
/////// END Smile Formats ///////





/////// Start BugText Formats ///////
function bugsend($bug_send) {
 $bug_send = str_replace("<","&lt;",$bug_send);
 $bug_send = str_replace(">","&gt;",$bug_send);
 $bug_send = str_replace("!","&#33;",$bug_send);
 $bug_send = str_replace("%","&#37;",$bug_send);
 $bug_send = str_replace('\\\"',"&quot;",$bug_send);
 $bug_send = str_replace(" +$"," ",$bug_send);
 $bug_send = str_replace(" +"," ",$bug_send);
 $bug_send = str_replace("^ +"," ",$bug_send);
 $bug_send = str_replace("\r"," ",$bug_send);
 $bug_send = str_replace("\n","[br]",$bug_send);
return $bug_send;
}
/////// END Smile Formats ///////





/////// Start Country Formats ///////
function country($country) {
if($country==1){$country = "Albania";}
elseif($country==2){$country = "Algeria";}
elseif($country==3){$country = "Angola";}
elseif($country==4){$country = "Argentina";}
elseif($country==5){$country = "Armenia";}
elseif($country==6){$country = "Australia";}
elseif($country==7){$country = "Austria";}
elseif($country==8){$country = "Azerbaijan";}
elseif($country==9){$country = "Bahamas";}
elseif($country==10){$country = "Bahrain";}
elseif($country==11){$country = "Bangladesh";}
elseif($country==12){$country = "Belarus";}
elseif($country==13){$country = "Belgium";}
elseif($country==14){$country = "Bolivia";}
elseif($country==15){$country = "Botswana";}
elseif($country==16){$country = "Brazil";}
elseif($country==17){$country = "Brunei";}
elseif($country==18){$country = "Bulgaria";}
elseif($country==19){$country = "Burkina Faso";}
elseif($country==20){$country = "Cameroon";}
elseif($country==21){$country = "Canada";}
elseif($country==22){$country = "Chile";}
elseif($country==23){$country = "China";}
elseif($country==24){$country = "Colombia";}
elseif($country==25){$country = "Congo (Brazzaville)";}
elseif($country==26){$country = "Congo DR";}
elseif($country==27){$country = "Costa Rica";}
elseif($country==28){$country = "Cote dIvoire";}
elseif($country==29){$country = "Croatia";}
elseif($country==30){$country = "Cuba";}
elseif($country==31){$country = "Czech Republic";}
elseif($country==32){$country = "Denmark";}
elseif($country==33){$country = "Dominican Republic";}
elseif($country==34){$country = "Ecuador";}
elseif($country==35){$country = "Egypt";}
elseif($country==36){$country = "El Salvador";}
elseif($country==37){$country = "Estonia";}
elseif($country==38){$country = "Ethiopia";}
elseif($country==39){$country = "Finland";}
elseif($country==40){$country = "France";}
elseif($country==41){$country = "Gabon";}
elseif($country==42){$country = "Gambia";}
elseif($country==43){$country = "Germany";}
elseif($country==44){$country = "Greece";}
elseif($country==45){$country = "Guatemala";}
elseif($country==46){$country = "Guinea";}
elseif($country==47){$country = "Guinea-Bissau";}
elseif($country==48){$country = "Guyana";}
elseif($country==49){$country = "Haiti";}
elseif($country==50){$country = "Honduras";}
elseif($country==51){$country = "Hong Kong";}
elseif($country==52){$country = "Hungary";}
elseif($country==53){$country = "Iceland";}
elseif($country==54){$country = "India";}
elseif($country==55){$country = "Indonesia";}
elseif($country==56){$country = "Iran";}
elseif($country==57){$country = "Iraq";}
elseif($country==58){$country = "Ireland";}
elseif($country==59){$country = "Israel";}
elseif($country==60){$country = "Italy";}
elseif($country==61){$country = "Jamaica";}
elseif($country==62){$country = "Japan";}
elseif($country==63){$country = "Jordan";}
elseif($country==64){$country = "Kazakstan";}
elseif($country==65){$country = "Kenya";}
elseif($country==66){$country = "Korea";}
elseif($country==67){$country = "Korea, South";}
elseif($country==68){$country = "Kuwait";}
elseif($country==69){$country = "Latvia";}
elseif($country==70){$country = "Lebanon";}
elseif($country==71){$country = "Liberia";}
elseif($country==72){$country = "Libya";}
elseif($country==73){$country = "Lithuania";}
elseif($country==74){$country = "Luxembourg";}
elseif($country==75){$country = "Madagascar";}
elseif($country==76){$country = "Malawi";}
elseif($country==77){$country = "Malaysia";}
elseif($country==78){$country = "Mali";}
elseif($country==79){$country = "Malta";}
elseif($country==80){$country = "Mexico";}
elseif($country==81){$country = "Moldova";}
elseif($country==82){$country = "Mongolia";}
elseif($country==83){$country = "Morocco";}
elseif($country==84){$country = "Mozambique";}
elseif($country==85){$country = "Myanmar (Burma)";}
elseif($country==86){$country = "Namibia";}
elseif($country==87){$country = "Netherlands";}
elseif($country==88){$country = "New Zealand";}
elseif($country==89){$country = "Nicaragua";}
elseif($country==90){$country = "Niger";}
elseif($country==91){$country = "Nigeria";}
elseif($country==92){$country = "Norway";}
elseif($country==93){$country = "Oman";}
elseif($country==94){$country = "Pakistan";}
elseif($country==95){$country = "Panama";}
elseif($country==96){$country = "Papua New Guinea";}
elseif($country==97){$country = "Paraguay";}
elseif($country==98){$country = "Peru";}
elseif($country==99){$country = "Philippines";}
elseif($country==100){$country = "Poland";}
elseif($country==101){$country = "Portugal";}
elseif($country==102){$country = "Qatar";}
elseif($country==103){$country = "Romania";}
elseif($country==104){$country = "Russia";}
elseif($country==105){$country = "Saudi Arabia";}
elseif($country==106){$country = "Senegal";}
elseif($country==107){$country = "Serbia";}
elseif($country==108){$country = "Sierra Leone";}
elseif($country==109){$country = "Singapore";}
elseif($country==110){$country = "Slovakia";}
elseif($country==111){$country = "Slovenia";}
elseif($country==112){$country = "Somalia";}
elseif($country==113){$country = "South Africa";}
elseif($country==114){$country = "Spain";}
elseif($country==115){$country = "Sri Lanka";}
elseif($country==116){$country = "Sudan";}
elseif($country==117){$country = "Suriname";}
elseif($country==118){$country = "Sweden";}
elseif($country==119){$country = "Switzerland";}
elseif($country==120){$country = "Syria";}
elseif($country==121){$country = "Taiwan";}
elseif($country==122){$country = "Tanzania";}
elseif($country==123){$country = "Thailand";}
elseif($country==124){$country = "Togo";}
elseif($country==125){$country = "Trinidad";}
elseif($country==126){$country = "Tunisia";}
elseif($country==127){$country = "Turkey";}
elseif($country==128){$country = "Uganda";}
elseif($country==129){$country = "Ukraine";}
elseif($country==130){$country = "United Arab Emirates";}
elseif($country==131){$country = "United Kingdom";}
elseif($country==132){$country = "United States";}
elseif($country==133){$country = "Uruguay";}
elseif($country==134){$country = "Venezuela";}
elseif($country==135){$country = "Vietnam";}
elseif($country==136){$country = "Yemen";}
elseif($country==137){$country = "Zambia";}
elseif($country==138){$country = "Zimbabwe";}
else{$country = "Unknow";}
return $country;
}
/////// END Country Formats ///////









/////// Start Map Formats ///////
function map($map) {
if($map == 0){$map = 'Lorencia';}
elseif($map == 1){$map = 'Dungeon';}
elseif($map == 2){$map = 'Devias';}
elseif($map == 3){$map = 'Noria';}
elseif($map == 4){$map = 'LostTower';}
elseif($map == 6){$map = 'Stadium';}
elseif($map == 7){$map = 'Atlans';}
elseif($map == 8){$map = 'Tarkan';}
elseif($map == 9){$map = 'Devil Square';}
elseif($map == 10){$map = 'Icarus';}
elseif($map == 11){$map = 'Blood Castle 1';}
elseif($map == 12){$map = 'Blood Castle 2';}
elseif($map == 13){$map = 'Blood Castle 3';}
elseif($map == 14){$map = 'Blood Castle 4';}
elseif($map == 15){$map = 'Blood Castle 5';}
elseif($map == 16){$map = 'Blood Castle 6';}
elseif($map == 17){$map = 'Blood Castle 7';}
elseif($map == 18){$map = 'Chaos Castle 1';}
elseif($map == 19){$map = 'Chaos Castle 2';}
elseif($map == 20){$map = 'Chaos Castle 3';}
elseif($map == 21){$map = 'Chaos Castle 4';}
elseif($map == 22){$map = 'Chaos Castle 5';}
elseif($map == 23){$map = 'Chaos Castle 6';}
elseif($map == 24){$map = 'Kalima 1';}
elseif($map == 25){$map = 'Kalima 2';}
elseif($map == 26){$map = 'Kalima 3';}
elseif($map == 27){$map = 'Kalima 4';}
elseif($map == 28){$map = 'Kalima 5';}
elseif($map == 29){$map = 'Kalima 6';}
elseif($map == 30){$map = 'Valley Of Loren';}
elseif($map == 31){$map = 'Lands Of Trials';}
elseif($map == 32){$map = 'Devil Square';}
elseif($map == 33){$map = 'Aida';}
elseif($map == 34){$map = 'CryWolf';}
else{$map = 'Unknow';}
return $map;
}
/////// END Map Formats ///////








/////// Start PK Status Formats ///////
function pkstatus($pkstatus) {
if($pkstatus == 1){$pkstatus = 'Hero';}
elseif($pkstatus == 2){$pkstatus = 'Commoner';}
elseif($pkstatus == 3){$pkstatus = 'Normal';}
elseif($pkstatus == 4){$pkstatus = 'Outlaw Warning';}
elseif($pkstatus == 5){$pkstatus = '1 Outlaw';}
elseif($pkstatus == 6){$pkstatus = '2 Outlaw';}
else{$pkstatus = 'Unknow';}
return $pkstatus;
}
/////// END PK Status Formats ///////








/////// Start Class Formats ///////
function char_class($class,$style) {
if($style==full) {
if($class == 0){$class = 'Dark Wizard';}
elseif($class == 1){$class = 'Soul Master';}
elseif($class == 16){$class = 'Dark Knight';}
elseif($class == 17){$class = 'Blade Knight';}
elseif($class == 32){$class = 'Fairy Elf';}
elseif($class == 33){$class = 'Muse Elf';}
elseif($class == 48){$class = 'Magic Gladiator';}
elseif($class == 64){$class = 'Dark Lord';}
else{$class = 'Unknow';}
}
elseif($style==img) {
if($class == 0 || $class == 1){$class = '<img src=images/char/dw.gif>';}
elseif($class == 16 || $class == 17){$class = '<img src=images/char/dk.gif>';}
elseif($class == 32 || $class == 33){$class = '<img src=images/char/elf.gif>';}
elseif($class == 48){$class = '<img src=images/char/mg.gif>';}
elseif($class == 64){$class = '<img src=images/char/dl.gif>';}
else{$class = 'Unknow';}
}
else {
if($class == 0){$class = 'DW';}
elseif($class == 1){$class = 'SM';}
elseif($class == 16){$class = 'DK';}
elseif($class == 17){$class = 'BK';}
elseif($class == 32){$class = 'Elf';}
elseif($class == 33){$class = 'ME';}
elseif($class == 48){$class = 'MG';}
elseif($class == 64){$class = 'DL';}
else{$class = 'Unknow';}
}
return $class;
}
/////// END Class Formats ///////







/////// Start Win to UTF Formats ///////
function win_to_utf($s) {
 for($i=0, $m=strlen($s); $i<$m; $i++) {
	$c=ord($s[$i]);
	if ($c<=127) {$t.=chr($c); continue; }
	if ($c>=192 && $c<=207) {$t.=chr(208).chr($c-48); continue; }
	if ($c>=208 && $c<=239) {$t.=chr(208).chr($c-48); continue; }
	if ($c>=240 && $c<=255) {$t.=chr(209).chr($c-112); continue; }
	if ($c==184) { $t.=chr(209).chr(209); continue; };
	if ($c==168) { $t.=chr(208).chr(129); continue; }; 
 }
return $t;
}
/////// END Win to UTF Formats ///////







/////// Start UTF to Win Formats ///////
function utf_to_win($str) {
$str=strtr($str,array("Ð°"=>"à","Ð±"=>"á","Ð²"=>"â","Ð³"=>"ã","Ð´"=>"ä","Ðµ"=>"å","Ñ‘"=>"¸",
"Ð¶"=>"æ","Ð·"=>"ç",
"Ð¸"=>"è","Ð¹"=>"é","Ðº"=>"ê","Ð»"=>"ë","Ð¼"=>"ì","Ð½"=>"í","Ð¾"=>"î","Ð¿"=>"ï",
"Ñ€"=>"ð","Ñ"=>"ñ","Ñ‚"=>"ò","Ñƒ"=>"ó","Ñ„"=>"ô","Ñ…"=>"õ","Ñ†"=>"ö",
"Ñ‡"=>"÷","Ñˆ"=>"ø","Ñ‰"=>"ù","ÑŠ"=>"ú","Ñ‹"=>"û","ÑŒ"=>"ü",
"Ñ"=>"ý","ÑŽ"=>"þ","Ñ"=>"ÿ",
"Ð"=>"À","Ð‘"=>"Á","Ð’"=>"Â","Ð“"=>"Ã","Ð”"=>"Ä",
"Ð•"=>"Å","Ð"=>"¨","Ð–"=>"Æ","Ð—"=>"Ç","Ð?"=>"È","Ð™"=>"É","Ðš"=>"Ê","Ð›"=>"Ë",
"Ðœ"=>"Ì","Ð"=>"Í","Ðž"=>"Î","ÐŸ"=>"Ï","Ð "=>"Ð",
"Ð¡"=>"Ñ","Ð¢"=>"Ò","Ð£"=>"Ó","Ð¤"=>"Ô","Ð¥"=>"Õ",
"Ð¦"=>"Ö","Ð§"=>"×","Ð¨"=>"Ø","Ð©"=>"Ù","Ðª"=>"Ú","Ð«"=>"Û",
"Ð¬"=>"Ü","Ð "=>"Ý","Ð®"=>"Þ","Ð¯"=>"ß"));
return $str;
}
/////// END UTF to Win Formats ///////
?> 