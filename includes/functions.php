<?php
// Functions by Vaflan For MyMuWeb

/////// Start Clean Var ///////
function clean_var($var) {
 $var = stripslashes($var);
 //$var = str_replace(";","&#59;",$var);
 $var = str_replace("*","&#42;",$var);
 $var = str_replace("%","&#37;",$var);
 $var = str_replace("'","&#39;",$var);
 $var = str_replace(",","&#44;",$var);
 //$var = str_replace(".","&#46;",$var);
 //$var = str_replace(":","&#58;",$var);
 $var = str_replace("`","&#96;",$var);
 return $var;
}
/////// End Clean Var ///////





/////// Start Write Logs ///////
function writelog($logfile,$text) {
 $dir = 'logs/';
 if(substr($_SERVER['SCRIPT_FILENAME'], -15) == 'admin/index.php') {$dir = '../logs/';}
 $fp = fopen($dir.$logfile.'.php','a');
 fputs($fp, $text.', All Those On <i>'.date('d.m.Y H:i:s').'</i> By <u>'.$_SERVER['REMOTE_ADDR'].'</u>'." \n");
 fclose($fp);
}
/////// End Write Logs ///////





/////// Start Jump Link ///////
function jump($url) {
   header('Location: '.$url.'');
   echo '<script language="JavaScript">window.location=\''.$url.'\';</script>';
}
/////// End Jump Link ///////





/////// Start Time Format ///////
function time_format($date, $format) {
 // Support SQL 2000(Rus) and 2005
 $formated_time = "d M Y, T";
 $date_row = explode(" ",$date);

 if(!preg_match("/^\d*$/",$date_row[1])) {
  $day = $date_row[0];
  $month = $date_row[1];
  $year = $date_row[2];
  if(empty($date_row[4])) {$time = $date_row[3];}
  else {$time = $date_row[4];}

  if($month=='ˇÌ‚' || $month=='—è–Ω–≤' || $month=='Ô≠¢') {$month="Jan";}
  if($month=='ÙÂ‚' || $month=='—Ñ–µ–≤' || $month=='‰•¢') {$month="Feb";}
  if($month=='Ï‡' || $month=='–º–∞—Ä' || $month=='¨†‡') {$month="Mar";}
  if($month=='‡Ô' || $month=='–∞–ø—Ä' || $month=='†Ø‡') {$month="Apr";}
  if($month=='Ï‡È' || $month=='–º–∞–π' || $month=='¨†©') {$month="May";}
  if($month=='Ë˛Ì' || $month=='–∏—é–Ω' || $month=='®Ó≠') {$month="Jun";}
  if($month=='Ë˛Î' || $month=='–∏—é–ª' || $month=='®Ó´') {$month="Jul";}
  if($month=='‡‚„' || $month=='–∞–≤–≥' || $month=='†¢£') {$month="Aug";}
  if($month=='ÒÂÌ' || $month=='—Å–µ–Ω' || $month=='·•≠') {$month="Sep";}
  if($month=='ÓÍÚ' || $month=='–æ–∫—Ç' || $month=='Æ™‚') {$month="Oct";}
  if($month=='ÌÓˇ' || $month=='–Ω–æ—è' || $month=='≠ÆÔ') {$month="Nov";}
  if($month=='‰ÂÍ' || $month=='–¥–µ–∫') {$month="Dec";}
 }
 else {
  $day = $date_row[1];
  $month = $date_row[0];
  $year = $date_row[2];
  $time = $date_row[4];
 }

 $formated_time = str_replace("d", $day, $formated_time);
 $formated_time = str_replace("M", $month, $formated_time);
 $formated_time = str_replace("Y", $year, $formated_time);
 $formated_time = str_replace("T", $time, $formated_time);

 $end_time = date($format, strtotime($formated_time));
 return $end_time;
}
/////// End Time Format ///////





/////// Start Date Formats ///////
function date_formats($stime, $etime, $format='short') {
 if(is_numeric($stime)) {$diff = $etime - $stime;}
 else {$diff = $etime - strtotime($stime);}

 $time = '';
 $seconds = 0;
 $hours = 0;
 $minutes = 0;

 if($diff % 86400 <= 0)  //there are 86,400 seconds in a day
  {$days = $diff / 86400;}

 if($diff % 86400 > 0) {   
  $rest = ($diff % 86400);
  $days = ($diff - $rest) / 86400;
		  
  if($rest % 3600 > 0) {
   $rest1 = ($rest % 3600);
   $hours = ($rest - $rest1) / 3600;
   if($rest1 % 60 > 0) {
    $rest2 = ($rest1 % 60);
    $minutes = ($rest1 - $rest2) / 60;
    $seconds = $rest2;
   }
   else {
    $minutes = $rest1 / 60;
   }
  }
  else {
   $hours = $rest / 3600; 
  }
 }
 $times = (($days > 0) ? $days .' days ' : '' ). (($hours > 0 ) ? $hours .'h ' :'' ). $minutes .'m '.$seconds.'s';
 if($format =='long') $times = (($days > 0) ? $days .' Days ' : '' ). (($hours > 0 && $hours != 12) ? $hours .' Hours ' :'' ). $minutes .' Minutes ';//.$seconds.' seconds';
 return $times;
}
/////// END Date Formats ///////





/////// Start Now Module //////
function curent_module() {
 $cur_module = preg_replace("/[^a-zA-Z0-9_-]/", '', $_GET['op']);
 if(isset($_GET['news'])) {echo '&gt; <a href="?op=news">'.mmw_lang_news.'</a>';} 
 elseif(isset($_GET['forum'])) {echo '&gt; <a href="?op=forum">'.mmw_lang_forum.'</a>';}
 else {echo '&gt; <a href="?op='.$cur_module.'">'.ucfirst($cur_module).'</a>';}

 if($cur_module=='user') {		  
  if($cur_module=='user' and !isset($_GET['u'])) {echo ' &gt; <a href="?op=user&u=acc">'.mmw_lang_account_panel.'</a>';}
  else {echo ' &gt; <a href="?op=user&u='.$_GET['u'].'">'.ucfirst($_GET['u']).'</a>';}
 }
}
/////// End Now Module ///////





/////// Start Default IMG //////
function default_img($src) {
 global $mmw;
 if(is_file($mmw['theme_img'].'/'.$src)) {return $mmw['theme_img'].'/'.$src;}
 else {return 'images/'.$src;}
}
/////// End Default IMG ///////





/////// Start BBCode Formats ///////
function bbcode($text) {
 $bbcode = array(
  "/\[br\]/is" => "<br>",
  "/\[hr\]/is" => "<hr>",
  "/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
  "/\[i\](.*?)\[\/i\]/is" => "<i>$1</i>",
  "/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>",
  "/\[s\](.*?)\[\/s\]/is" => "<s>$1</s>",
  "/\[o\](.*?)\[\/o\]/is" => "<span style=\"text-decoration: overline;\">$1</span>",
  "/\[c\](.*?)\[\/c\]/is" => "<div align=\"center\">$1</div>",
  "/\[l\](.*?)\[\/l\]/is" => "<div align=\"left\">$1</div>",
  "/\[r\](.*?)\[\/r\]/is" => "<div align=\"right\">$1</div>",
  "/\[center\](.*?)\[\/center\]/is" => "<div align=\"center\">$1</div>",
  "/\[left\](.*?)\[\/left\]/is" => "<div align=\"left\">$1</div>",
  "/\[right\](.*?)\[\/right\]/is" => "<div align=\"right\">$1</div>",
  "/\[sup\](.*?)\[\/sup\]/is" => "<sup>$1</sup>",
  "/\[sub\](.*?)\[\/sub\]/is" => "<sub>$1</sub>",
  "/\[img\](.*?)\[\/img\]/is" => "<img src=\"$1\" border=\"0\">",
  "/\[color\=(.*?)\](.*?)\[\/color\]/is" => "<font color=\"$1\">$2</font>",
  "/\[font\=(.*?)\](.*?)\[\/font\]/is" => "<font face=\"$1\">$2</font>",
  "/\[size\=(.*?)\](.*?)\[\/size\]/is" => "<span style=\"font-size: $1 pt;\">$2</span>",
  "/\[url\=(.*?)\](.*?)\[\/url\]/is" => "<a target=\"_blank\" href=\"$1\">$2</a>",
  "/\[video\]http:\/\/www.youtube.com\/watch\?v=(.*?)\[\/video\]/is" => "<embed src=\"http://www.youtube.com/v/$1&hl=ru_RU&fs=1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" width=\"480\" height=\"385\"></embed>",
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
 $smile = str_replace(" (hello) "," <img src=images/smile/hello.gif border=0> ",$smile);
 $smile = str_replace(" (boo) "," <img src=images/smile/bo.gif border=0> ",$smile);
 return $smile;
}
/////// END Smile Formats ///////





/////// Start BugText Formats ///////
function bugsend($bug) {
 $bug = str_replace("<","&lt;",$bug);
 $bug = str_replace(">","&gt;",$bug);
 //$bug = str_replace("&","&amp;",$bug);
 $bug = str_replace('"',"&quot;",$bug);
 //$bug = str_replace("/","&#47;",$bug);
 $bug = str_replace("?","&#63;",$bug);
 //$bug = str_replace("ó","&mdash;",$bug);
 $bug = str_replace("'","&apos;",$bug);
 $bug = str_replace("!","&#33;",$bug);
 $bug = str_replace("$","&#36;",$bug);
 $bug = str_replace("%","&#37;",$bug);
 $bug = str_replace("*","&#42;",$bug);
 $bug = str_replace("+","&#43;",$bug);
 $bug = str_replace("\n","[br]",$bug);
 $bug = str_replace("\r","&nbsp;",$bug);
 $bug = str_replace(chr(hexdec('5c')),"&#92;",$bug);
 return $bug;
}
/////// END BugText Formats ///////





/////// Start Zen Formats ///////
function zen_format($money, $format=NULL) {
 if($format == 'small') {
    $money_check = substr($money, -3);
    if($money_check=='000') {
	$money = substr($money, 0, -3) . 'k';
	$money_check = substr($money, -4);
	if($money_check=='000k') {
	    $money = substr($money, 0, -4) . 'kk';
	    $money_check = substr($money, -5);
	    if($money_check=='000kk') {
		$money = substr($money, 0, -5) . 'kkk';
		$money_check = substr($money, -6);
	   	if($money_check=='000kkk') {
		    $money = substr($money, 0, -6) . 'kkkk';
	   	}
	    }
	}
    }
 }
 else {
  $money = number_format($money);
 }
 return $money;
}
/////// END Zen Formats ///////





/////// Start Img resize ///////
function img_resize($img_src, $sizew, $sizeh, $save_dir, $save_name) {
 $save_dir .= (substr($save_dir,-1) != "/") ? "/" : "";
 $gis = GetImageSize($img_src);
 $type = $gis[2];
 switch($type) {
  case 1: $imorig = imagecreatefromgif($img_src); break;
  case 2: $imorig = imagecreatefromjpeg($img_src); break;
  case 3: $imorig = imagecreatefrompng($img_src); break;
  default:  $imorig = imagecreatefromjpeg($img_src);
 }

 $width = imageSX($imorig);
 $height = imageSY($imorig);
 if($gis[0] <= $sizew && $gis[1] <= $sizeh) {
  if(is_file($save_dir.$save_name)){unlink($save_dir.$save_name);}
  rename($img_src,$save_dir.$save_name);	
 }
 else {
  // if(is_file($img_src)) {unlink($img_src);}

  // ‰ÎËÌ‡ ËÒıÓ‰ÌÓÈ Í‡ÚËÌÍË
  $edited_width = $sizew;
  $new_height = $height * $sizew / $width;
  // ‚˚ÒÓÚ‡ ËÒıÓ‰ÌÓÈ Í‡ÚËÌÍË
  if($sizeh<$new_height) {$edited_height = $sizeh; $edited_width = $sizew * $sizeh / $new_height;}
  else {$edited_height = $new_height;}
	                      
  $im = imagecreate($edited_width, $edited_height);
  $im = imagecreatetruecolor($edited_width,$edited_height);
  if(imagecopyresampled($im, $imorig, 0, 0, 0, 0, $edited_width, $edited_height, $width, $height)) {
   if(imagejpeg($im, $save_dir.$save_name)) {return true;}
   else {return false;}
  }
 }   
}
/////// END Img resize ///////





/////// Start Points Formats ///////
function point_format($str=NULL) {
 if($str < 0) {$str = 32768 + (32768 + $str);}
 return $str;
}
/////// END Points Formats ///////





/////// Start Country Formats ///////
function country($country) {
 switch($country) {
  case 1: $country = "Albania"; break;
  case 2: $country = "Algeria"; break;
  case 3: $country = "Angola"; break;
  case 4: $country = "Argentina"; break;
  case 5: $country = "Armenia"; break;
  case 6: $country = "Australia"; break;
  case 7: $country = "Austria"; break;
  case 8: $country = "Azerbaijan"; break;
  case 9: $country = "Bahamas"; break;
  case 10: $country = "Bahrain"; break;
  case 11: $country = "Bangladesh"; break;
  case 12: $country = "Belarus"; break;
  case 13: $country = "Belgium"; break;
  case 14: $country = "Bolivia"; break;
  case 15: $country = "Botswana"; break;
  case 16: $country = "Brazil"; break;
  case 17: $country = "Brunei"; break;
  case 18: $country = "Bulgaria"; break;
  case 19: $country = "Burkina Faso"; break;
  case 20: $country = "Cameroon"; break;
  case 21: $country = "Canada"; break;
  case 22: $country = "Chile"; break;
  case 23: $country = "China"; break;
  case 24: $country = "Colombia"; break;
  case 25: $country = "Congo (Brazzaville)"; break;
  case 26: $country = "Congo DR"; break;
  case 27: $country = "Costa Rica"; break;
  case 28: $country = "Cote dIvoire"; break;
  case 29: $country = "Croatia"; break;
  case 30: $country = "Cuba"; break;
  case 31: $country = "Czech Republic"; break;
  case 32: $country = "Denmark"; break;
  case 33: $country = "Dominican Republic"; break;
  case 34: $country = "Ecuador"; break;
  case 35: $country = "Egypt"; break;
  case 36: $country = "El Salvador"; break;
  case 37: $country = "Estonia"; break;
  case 38: $country = "Ethiopia"; break;
  case 39: $country = "Finland"; break;
  case 40: $country = "France"; break;
  case 41: $country = "Gabon"; break;
  case 42: $country = "Gambia"; break;
  case 43: $country = "Germany"; break;
  case 44: $country = "Greece"; break;
  case 45: $country = "Guatemala"; break;
  case 46: $country = "Guinea"; break;
  case 47: $country = "Guinea-Bissau"; break;
  case 48: $country = "Guyana"; break;
  case 49: $country = "Haiti"; break;
  case 50: $country = "Honduras"; break;
  case 51: $country = "Hong Kong"; break;
  case 52: $country = "Hungary"; break;
  case 53: $country = "Iceland"; break;
  case 54: $country = "India"; break;
  case 55: $country = "Indonesia"; break;
  case 56: $country = "Iran"; break;
  case 57: $country = "Iraq"; break;
  case 58: $country = "Ireland"; break;
  case 59: $country = "Israel"; break;
  case 60: $country = "Italy"; break;
  case 61: $country = "Jamaica"; break;
  case 62: $country = "Japan"; break;
  case 63: $country = "Jordan"; break;
  case 64: $country = "Kazakstan"; break;
  case 65: $country = "Kenya"; break;
  case 66: $country = "Korea"; break;
  case 67: $country = "Korea, South"; break;
  case 68: $country = "Kuwait"; break;
  case 69: $country = "Latvia"; break;
  case 70: $country = "Lebanon"; break;
  case 71: $country = "Liberia"; break;
  case 72: $country = "Libya"; break;
  case 73: $country = "Lithuania"; break;
  case 74: $country = "Luxembourg"; break;
  case 75: $country = "Madagascar"; break;
  case 76: $country = "Malawi"; break;
  case 77: $country = "Malaysia"; break;
  case 78: $country = "Mali"; break;
  case 79: $country = "Malta"; break;
  case 80: $country = "Mexico"; break;
  case 81: $country = "Moldova"; break;
  case 82: $country = "Mongolia"; break;
  case 83: $country = "Morocco"; break;
  case 84: $country = "Mozambique"; break;
  case 85: $country = "Myanmar (Burma)"; break;
  case 86: $country = "Namibia"; break;
  case 87: $country = "Netherlands"; break;
  case 88: $country = "New Zealand"; break;
  case 89: $country = "Nicaragua"; break;
  case 90: $country = "Niger"; break;
  case 91: $country = "Nigeria"; break;
  case 92: $country = "Norway"; break;
  case 93: $country = "Oman"; break;
  case 94: $country = "Pakistan"; break;
  case 95: $country = "Panama"; break;
  case 96: $country = "Papua New Guinea"; break;
  case 97: $country = "Paraguay"; break;
  case 98: $country = "Peru"; break;
  case 99: $country = "Philippines"; break;
  case 100: $country = "Poland"; break;
  case 101: $country = "Portugal"; break;
  case 102: $country = "Qatar"; break;
  case 103: $country = "Romania"; break;
  case 104: $country = "Russia"; break;
  case 105: $country = "Saudi Arabia"; break;
  case 106: $country = "Senegal"; break;
  case 107: $country = "Serbia"; break;
  case 108: $country = "Sierra Leone"; break;
  case 109: $country = "Singapore"; break;
  case 110: $country = "Slovakia"; break;
  case 111: $country = "Slovenia"; break;
  case 112: $country = "Somalia"; break;
  case 113: $country = "South Africa"; break;
  case 114: $country = "Spain"; break;
  case 115: $country = "Sri Lanka"; break;
  case 116: $country = "Sudan"; break;
  case 117: $country = "Suriname"; break;
  case 118: $country = "Sweden"; break;
  case 119: $country = "Switzerland"; break;
  case 120: $country = "Syria"; break;
  case 121: $country = "Taiwan"; break;
  case 122: $country = "Tanzania"; break;
  case 123: $country = "Thailand"; break;
  case 124: $country = "Togo"; break;
  case 125: $country = "Trinidad"; break;
  case 126: $country = "Tunisia"; break;
  case 127: $country = "Turkey"; break;
  case 128: $country = "Uganda"; break;
  case 129: $country = "Ukraine"; break;
  case 130: $country = "United Arab Emirates"; break;
  case 131: $country = "United Kingdom"; break;
  case 132: $country = "United States"; break;
  case 133: $country = "Uruguay"; break;
  case 134: $country = "Venezuela"; break;
  case 135: $country = "Vietnam"; break;
  case 136: $country = "Yemen"; break;
  case 137: $country = "Zambia"; break;
  case 138: $country = "Zimbabwe"; break;
  default: $country = "Unknow"; break;
 }
 return $country;
}
/////// END Country Formats ///////





/////// Start Map Formats ///////
function map($map) {
 switch($map) {
  case 0: $map = 'Lorencia'; break;
  case 1: $map = 'Dungeon'; break;
  case 2: $map = 'Devias'; break;
  case 3: $map = 'Noria'; break;
  case 4: $map = 'LostTower'; break;
  case 5: $map = 'PlaceOfExil'; break;
  case 6: $map = 'Stadium'; break;
  case 7: $map = 'Atlans'; break;
  case 8: $map = 'Tarkan'; break;
  case 9: $map = 'Devil Square'; break;
  case 10: $map = 'Icarus'; break;
  case 11: $map = 'Blood Castle 1'; break;
  case 12: $map = 'Blood Castle 2'; break;
  case 13: $map = 'Blood Castle 3'; break;
  case 14: $map = 'Blood Castle 4'; break;
  case 15: $map = 'Blood Castle 5'; break;
  case 16: $map = 'Blood Castle 6'; break;
  case 17: $map = 'Blood Castle 7'; break;
  case 18: $map = 'Chaos Castle 1'; break;
  case 19: $map = 'Chaos Castle 2'; break;
  case 20: $map = 'Chaos Castle 3'; break;
  case 21: $map = 'Chaos Castle 4'; break;
  case 22: $map = 'Chaos Castle 5'; break;
  case 23: $map = 'Chaos Castle 6'; break;
  case 24: $map = 'Kalima 1'; break;
  case 25: $map = 'Kalima 2'; break;
  case 26: $map = 'Kalima 3'; break;
  case 27: $map = 'Kalima 4'; break;
  case 28: $map = 'Kalima 5'; break;
  case 29: $map = 'Kalima 6'; break;
  case 30: $map = 'Valley Of Loren'; break;
  case 31: $map = 'Lands Of Trials'; break;
  case 32: $map = 'Devil Square'; break;
  case 33: $map = 'Aida'; break;
  case 34: $map = 'CryWolf'; break;
  case 36: $map = 'Kalima 7'; break;
  case 37: $map = 'Kantru 1'; break;
  case 38: $map = 'Kantru 2'; break;
  case 39: $map = 'Kantru 3'; break;
  case 40: $map = 'Silent'; break;
  case 41: $map = 'Refuge'; break;
  case 42: $map = 'Barracks'; break;
  case 45: $map = 'Illusion 1'; break;
  case 46: $map = 'Illusion 2'; break;
  case 47: $map = 'Illusion 3'; break;
  case 48: $map = 'Illusion 4'; break;
  case 49: $map = 'Illusion 5'; break;
  case 50: $map = 'Illusion 6'; break;
  case 51: $map = 'Elbeland'; break;
  case 52: $map = 'Blood Castle 8'; break;
  case 53: $map = 'Chaos Castle 7'; break;
  case 56: $map = 'Swamp Of Calmness'; break;
  case 57: $map = 'Raklion'; break;
  default: $map = 'Unknow'; break;
 }
 return $map;
}
/////// END Map Formats ///////





/////// Start PK Status Formats ///////
function pkstatus($pkstatus) {
 switch($pkstatus) {
  case 1: $pkstatus = 'Hero'; break;
  case 2: $pkstatus = 'Commoner'; break;
  case 3: $pkstatus = 'Normal'; break;
  case 4: $pkstatus = 'Outlaw Warning'; break;
  case 5: $pkstatus = '1 Outlaw'; break;
  case 6: $pkstatus = '2 Outlaw'; break;
  default: $pkstatus = 'Unknow'; break;
 }
 return $pkstatus;
}
/////// END PK Status Formats ///////





/////// Start Guild Status Formats ///////
function guild_status($num) {
 switch($num) {
  case 0: $num = mmw_lang_guild_member; break;
  case 32: $num = mmw_lang_battle_master; break;
  case 64: $num = mmw_lang_assistant_guild_master; break;
  case 128: $num = mmw_lang_guild_master; break;
  default: $num = 'Unknow'; break;
 }
 return $num;
}
/////// END Guild Status Formats ///////





/////// Start CtlCode Formats ///////
function CtlCode($num) {
 switch($num) {
  case 0: $result = 'Member'; break;
  case 1: $result = 'Blocked'; break;
  case 8: $result = 'Game Master'; break;
  case 32: $result = 'Game Master'; break;
  default: $result = 'Unknow'; break;
 }
 return $result;
}
/////// END CtlCode Formats ///////





/////// Start Gender Formats ///////
function gender($gender) {
 if($gender=='male') {$gender = mmw_lang_male.' <img src="images/male.gif">';}
 elseif($gender=='female') {$gender = mmw_lang_female.' <img src="images/female.gif">';}
 else {$gender = 'Unknow';}
 return $gender;
}
/////// END Gender Formats ///////





/////// Start Class Formats ///////
function char_class($class, $style='off') {
 if($class == 0){$class_row1 = array('off'=>'DW','full'=>'Dark Wizard');}
 elseif($class == 1){$class_row1 = array('off'=>'SM','full'=>'Soul Master');}
 elseif($class == 2 || $class == 3){$class_row1 = array('off'=>'GrM','full'=>'Grand Master');}
 elseif($class == 16){$class_row1 = array('off'=>'DK','full'=>'Dark Knight');}
 elseif($class == 17){$class_row1 = array('off'=>'BK','full'=>'Blade Knight');}
 elseif($class == 18 || $class == 19){$class_row1 = array('off'=>'BM','full'=>'Blade Master');}
 elseif($class == 32){$class_row1 = array('off'=>'Elf','full'=>'Fairy Elf');}
 elseif($class == 33){$class_row1 = array('off'=>'ME','full'=>'Muse Elf');}
 elseif($class == 34 || $class == 35){$class_row1 = array('off'=>'HE','full'=>'High Elf');}
 elseif($class == 48){$class_row1 = array('off'=>'MG','full'=>'Magic Gladiator');}
 elseif($class == 49 || $class == 50){$class_row1 = array('off'=>'DM','full'=>'Duel Master');}
 elseif($class == 64){$class_row1 = array('off'=>'DL','full'=>'Dark Lord');}
 elseif($class == 65 || $class == 66){$class_row1 = array('off'=>'LE','full'=>'Lord Emperor');}
 elseif($class == 80){$class_row1 = array('off'=>'Sum','full'=>'Summoner');}
 elseif($class == 81){$class_row1 = array('off'=>'Bsum','full'=>'Bloody Summoner');}
 elseif($class == 82 || $class == 83){$class_row1 = array('off'=>'Dim','full'=>'Dimension Master');}
 elseif($class == 96){$class_row1 = array('off'=>'RF','full'=>'Rage Fighter');}
 elseif($class == 97 || $class == 98){$class_row1 = array('off'=>'FM','full'=>'First Master');}
 else{$class_row1 = array('off'=>'Unknow','full'=>'Unknow');}

 if($class >= 0 && $class <= 15){$class_row2 = array('img'=>'char/dw.gif','photo'=>'0x00FFFFFFFFFF000000F80000F0FFFFFF');}
 elseif($class >= 16 && $class <= 31){$class_row2 = array('img'=>'char/dk.gif','photo'=>'0x20FFFFFFFFFF000000F80000F0FFFFFF');}
 elseif($class >= 32 && $class <= 47){$class_row2 = array('img'=>'char/ef.gif','photo'=>'0x40FFFFFFFFFF000000F80000F0FFFFFF');}
 elseif($class >= 48 && $class <= 63){$class_row2 = array('img'=>'char/mg.gif','photo'=>'0x60FFFFFFFFFF000000F80000F0FFFFFF');}
 elseif($class >= 64 && $class <= 79){$class_row2 = array('img'=>'char/dl.gif','photo'=>'0x80FFFFFFFFFF000000F80000F0FFFFFF');}
 elseif($class >= 80 && $class <= 95){$class_row2 = array('img'=>'char/sm.gif','photo'=>'0xA0FFFFFFFFFF000000F80000F0FFFFFF');}
 elseif($class >= 96 && $class <= 112){$class_row2 = array('img'=>'char/rf.gif','photo'=>'0xC0FFFFFFFFFF000000F80000F0FFFFFF');}
 else{$class_row2 = array('img'=>'Unknow','photo'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');}

 return $class_row1[$style].$class_row2[$style];
}
/////// END Class Formats ///////





/////// Start Win to UTF Formats ///////
function win_to_utf($str=NULL) {
 $str = iconv("cp1251", "UTF-8", $str);
 return str_replace("–∞", "a", $str);
}
function utf_to_win($str=NULL) {
 return iconv("UTF-8", "cp1251//IGNORE", $str);
}
/////// END UTF to Win Formats ///////





/////// Start Guard MMW Message Info ///////
function guard_mmw_mess($to, $text) {
 $date = date("m/d/y H:i:s");
 $msg_to_sql = @mssql_query("SELECT GUID,MemoCount FROM T_FriendMain WHERE Name='$to'");
 $msg_to_row = @mssql_fetch_row($msg_to_sql);
 $mail_total_sql = @mssql_query("SELECT bRead FROM T_FriendMail WHERE GUID='$msg_to_row[0]'");
 $mail_total_num = @mssql_num_rows($mail_total_sql);
 $msg_id = $msg_to_row[1] + 1;
 $msg_text = utf_to_win($text);
 @mssql_query("INSERT INTO T_FriendMail (MemoIndex, GUID, FriendName, wDate, Subject, bRead, Memo, Dir, Act, Photo) VALUES ('$msg_id','$msg_to_row[0]','Guard','$date','MMW Message!','0',CAST('$msg_text' AS VARBINARY(1000)),'143','2',0x3061FF99999F12490400000060F0)");
 @mssql_query("UPDATE T_FriendMain set [MemoCount]='$msg_id',[MemoTotal]='$mail_total_num' WHERE Name='$to'");
}
/////// Start Guard MMW Message Info ///////





/////// Start FreeHex Formats ///////
function free_hex($size,$str,$style=NULL) {
 if($size == 20) {$hex = 'FFFFFFFFFFFFFFFFFFFF';} // 0.97 - 1.02
 elseif($size == 32) {$hex = 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';} // 1.02+
 else {
  for($a=0; $a<$size; ++$a) {
   $hex .= 'F';
  }
 }
 if(isset($style) && $style!='') {$hex = str_replace('F',$style,$hex);}
  for($i=0; $i<$str; ++$i) {
   $result .= $hex;
  }
 return $result;
}
/////// END FreeHex Formats ///////
?>