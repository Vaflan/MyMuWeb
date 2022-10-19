<?php
// Functions by Vaflan For MyMuWeb

/////// Start Clean Var ///////
function clean_var($var)
{
	$filter = array(
		'*' => '&#42;',
		'%' => '&#37;',
		'\'' => '&#39;',
		',' => '&#44;',
		'`' => '&#96;',
		//';' => '&#59;',
		//'.' => '&#46;',
		//':' => '&#58;',
	);
	return str_replace(array_keys($filter), array_values($filter), stripslashes($var));
}

/////// End Clean Var ///////


/////// Start Write Logs ///////
function writelog($logFile, $text)
{
	$dir = __DIR__ . '/../logs/';
	$row = $text . ', All Those On <i>' . date('d.m.Y H:i:s') . '</i> By <u>' . $_SERVER['REMOTE_ADDR'] . '</u>' . PHP_EOL;

	$fp = fopen($dir . $logFile . '.php', 'a');
	fputs($fp, $row);
	fclose($fp);
}

/////// End Write Logs ///////


/////// Start Jump Link ///////
function jump($url)
{
	@header('Location: ' . $url);
	die('<meta http-equiv="refresh" content="1;url=' . $url . '" /><script>window.location=\'' . $url . '\';</script>');
}

/////// End Jump Link ///////


/////// Start MMW ///////
if (!function_exists('mmw')) {
	/**
	 * ## Accepts files with .mmw extension only
	 * ![Example](http://mmw.clan.su/_fr/18/1415799.png)
	 * @see http://mymuweb.ru/forum/10-1882-1
	 * @param string $patch
	 * @return void
	 */
	function mmw($patch)
	{
		// do something here
	}
}
/////// End MMW ///////


/////// Start Time Format ///////
function time_format($date, $format = 'd.m.Y H:i')
{
	// Support SQL 2000(Rus) and 2005
	$formattedTime = 'd M Y, T';
	$date_row = explode(' ', $date);

	if (!preg_match('/^\d+$/', $date_row[1])) {
		$day = $date_row[0];
		$month = $date_row[1];
		$year = $date_row[2];
		$time = empty($date_row[4])
			? $date_row[3]
			: $date_row[4];

		switch ($month) {
			case 'янв':
				$month = 'Jan';
			case 'фев':
				$month = 'Feb';
				break;
			case 'мар':
				$month = 'Mar';
				break;
			case 'апр':
				$month = 'Apr';
				break;
			case 'май':
				$month = 'May';
				break;
			case 'июн':
				$month = 'Jun';
				break;
			case 'июл':
				$month = 'Jul';
				break;
			case 'авг':
				$month = 'Aug';
				break;
			case 'сен':
				$month = 'Sep';
				break;
			case 'окт':
				$month = 'Oct';
				break;
			case 'ноя':
				$month = 'Nov';
				break;
			case 'дек':
				$month = 'Dec';
				break;
		}
	} else {
		$day = $date_row[1];
		$month = $date_row[0];
		$year = $date_row[2];
		$time = $date_row[4];
	}

	$formattedTime = str_replace(
		array('d', 'M', 'Y', 'T'),
		array($day, $month, $year, $time),
		$formattedTime
	);

	return ($format === null)
		? strtotime($formattedTime)
		: date($format, strtotime($formattedTime));
}

/////// End Time Format ///////


/////// Start Date Formats ///////
function date_formats($sTime, $eTime, $format = 'short')
{
	$diff = is_numeric($sTime)
		? $eTime - $sTime
		: $eTime - strtotime($sTime);

	$seconds = 0;
	$hours = 0;
	$minutes = 0;

	// there are 86,400 seconds in a day
	if ($diff % 86400 <= 0) {
		$days = $diff / 86400;
	}

	if ($diff % 86400 > 0) {
		$rest = ($diff % 86400);
		$days = ($diff - $rest) / 86400;

		if ($rest % 3600 > 0) {
			$rest1 = ($rest % 3600);
			$hours = ($rest - $rest1) / 3600;
			if ($rest1 % 60 > 0) {
				$rest2 = ($rest1 % 60);
				$minutes = ($rest1 - $rest2) / 60;
				$seconds = $rest2;
			} else {
				$minutes = $rest1 / 60;
			}
		} else {
			$hours = $rest / 3600;
		}
	}

	return ($format === 'long')
		? ($days ? $days . ' days ' : '') . ($hours ? $hours . ' hours ' : '') . $minutes . ' minutes '
		: ($days ? $days . ' days ' : '') . ($hours ? $hours . 'h ' : '') . $minutes . 'm ' . $seconds . 's';
}

/////// END Date Formats ///////


/////// Start Week 2 String ///////
function week2str($num)
{
	switch ($num[1]) {
		case 0:
			return mmw_lang_week_mon;
		case 1:
			return mmw_lang_week_tue;
		case 2:
			return mmw_lang_week_wed;
		case 3:
			return mmw_lang_week_thu;
		case 4:
			return mmw_lang_week_fri;
		case 5:
			return mmw_lang_week_sat;
		default:
			return mmw_lang_week_sun;
	}
}

/////// END Week 2 String ///////


/////// Start Now Module //////
function current_module()
{
	$currentModule = preg_replace('/[^\w_-]/', '', $_GET['op']);
	if (isset($_GET['news'])) {
		echo '&gt; <a href="?op=news">' . mmw_lang_news . '</a>';
	} elseif (isset($_GET['forum'])) {
		echo '&gt; <a href="?op=forum">' . mmw_lang_forum . '</a>';
	} else {
		$label = defined('mmw_lang_' . $currentModule)
			? constant('mmw_lang_' . $currentModule)
			: ucfirst($currentModule);
		echo '&gt; <a href="?op=' . $currentModule . '">' . $label . '</a>';
	}

	if ($currentModule === 'user') {
		echo !isset($_GET['u'])
			? ' &gt; <a href="?op=user&u=acc">' . mmw_lang_account_panel . '</a>'
			: ' &gt; <a href="?op=user&u=' . $_GET['u'] . '">' . ucfirst($_GET['u']) . '</a>';
	}
}

/** @deprecated Use current_module() */
function curent_module()
{
	current_module();
}

/////// End Now Module ///////


/////// Start Default IMG //////
function default_img($src)
{
	global $mmw;
	return is_file($mmw['theme_img'] . '/' . $src)
		? $mmw['theme_img'] . '/' . $src
		: 'images/' . $src;
}

/////// End Default IMG ///////


/////// Start BBCode Formats ///////
function bbcode($text)
{
	$bbCode = array(
		'/\[br\]/is' => '<br>',
		'/\[hr\]/is' => '<hr>',
		'/\[b\](.*?)\[\/b\]/is' => '<b>$1</b>',
		'/\[i\](.*?)\[\/i\]/is' => '<i>$1</i>',
		'/\[u\](.*?)\[\/u\]/is' => '<u>$1</u>',
		'/\[s\](.*?)\[\/s\]/is' => '<s>$1</s>',
		'/\[o\](.*?)\[\/o\]/is' => '<span style="text-decoration: overline;">$1</span>',
		'/\[c\](.*?)\[\/c\]/is' => '<div style="text-align:center">$1</div>',
		'/\[l\](.*?)\[\/l\]/is' => '<div style="text-align:left">$1</div>',
		'/\[r\](.*?)\[\/r\]/is' => '<div style="text-align:right">$1</div>',
		'/\[center\](.*?)\[\/center\]/is' => '<div style="text-align:center">$1</div>',
		'/\[left\](.*?)\[\/left\]/is' => '<div style="text-align:left">$1</div>',
		'/\[right\](.*?)\[\/right\]/is' => '<div style="text-align:right">$1</div>',
		'/\[sup\](.*?)\[\/sup\]/is' => '<sup>$1</sup>',
		'/\[sub\](.*?)\[\/sub\]/is' => '<sub>$1</sub>',
		'/\[img\](.*?)\[\/img\]/is' => '<img src="$1" alt="img" border="0">',
		'/\[color\=(.*?)\](.*?)\[\/color\]/is' => '<span style="color:$1">$2</span>',
		'/\[font\=(.*?)\](.*?)\[\/font\]/is' => '<span style="font:$1">$2</span>',
		'/\[size\=(.*?)\](.*?)\[\/size\]/is' => '<span style="font-size:$1 pt;">$2</span>',
		'/\[url\=(.*?)\](.*?)\[\/url\]/is' => '<a target="_blank" href="$1">$2</a>',
		'/\[video\].*youtube.com\/watch\?v=(.*?)\[\/video\]/is' => '<iframe width="416" height="234" src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>',
	);
	$text = preg_replace(array_keys($bbCode), array_values($bbCode), $text);
	return $text;
}

/////// END BBCode Formats ///////


/////// Start Smile Formats ///////
function smile($smile)
{
	$smile = str_replace(' &gt;( ', ' <img src=images/smile/angry.gif alt=angry border=0> ', $smile);
	$smile = str_replace(' :D ', ' <img src=images/smile/biggrin.gif alt=biggrin border=0> ', $smile);
	$smile = str_replace(' B) ', ' <img src=images/smile/cool.gif alt=cool border=0> ', $smile);
	$smile = str_replace(' ;( ', ' <img src=images/smile/cry.gif alt=cry border=0> ', $smile);
	$smile = str_replace(' &lt;_&lt; ', ' <img src=images/smile/dry.gif alt=dry border=0> ', $smile);
	$smile = str_replace(' ^_^ ', ' <img src=images/smile/happy.gif alt=happy border=0> ', $smile);
	$smile = str_replace(' :( ', ' <img src=images/smile/sad.gif alt=sad border=0> ', $smile);
	$smile = str_replace(' :) ', ' <img src=images/smile/smile.gif alt=smile border=0> ', $smile);
	$smile = str_replace(' :o ', ' <img src=images/smile/surprised.gif alt=surprised border=0> ', $smile);
	$smile = str_replace(' :p ', ' <img src=images/smile/tongue.gif alt=tongue border=0> ', $smile);
	$smile = str_replace(' &#37;) ', ' <img src=images/smile/wacko.gif alt=wacko border=0> ', $smile);
	$smile = str_replace(' ;) ', ' <img src=images/smile/wink.gif alt=wink border=0> ', $smile);
	$smile = str_replace(' (hello) ', ' <img src=images/smile/hello.gif alt=hello border=0> ', $smile);
	$smile = str_replace(' (boo) ', ' <img src=images/smile/bo.gif alt=bo border=0> ', $smile);
	return $smile;
}

/////// END Smile Formats ///////


/////// Start BugText Formats ///////
function bugsend($bug)
{
	$bug = str_replace('<', '&lt;', $bug);
	$bug = str_replace('>', '&gt;', $bug);
	//$bug = str_replace('&','&amp;',$bug);
	$bug = str_replace('"', '&quot;', $bug);
	//$bug = str_replace('/','&#47;',$bug);
	$bug = str_replace('?', '&#63;', $bug);
	//$bug = str_replace('—','&mdash;',$bug);
	$bug = str_replace('\'', '&apos;', $bug);
	$bug = str_replace('!', '&#33;', $bug);
	$bug = str_replace('$', '&#36;', $bug);
	$bug = str_replace('%', '&#37;', $bug);
	$bug = str_replace('*', '&#42;', $bug);
	$bug = str_replace('+', '&#43;', $bug);
	$bug = str_replace("\n", '[br]', $bug);
	$bug = str_replace("\r", '&nbsp;', $bug);
	$bug = str_replace(chr(hexdec('5c')), '&#92;', $bug);
	return $bug;
}

/////// END BugText Formats ///////


/////// Start Zen Formats ///////
function zen_format($money, $format = null)
{
	if (in_array($format, array('small', 'k'))) {
		preg_match('/0+$/', $money, $match);
		if (!empty($match[0])) {
			$k = floor(strlen($match[0]) / 3);
			$money = substr($money, 0, -3 * $k) . str_repeat('k', $k);
		}
	} else {
		$money = number_format($money);
	}
	return $money;
}

/////// END Zen Formats ///////


/////// Start Img resize ///////
function img_resize($imgSrc, $sizeW, $sizeH, $saveDir, $saveName)
{
	$saveDir .= (substr($saveDir, -1) != '/') ? '/' : '';
	$gis = getimagesize($imgSrc);
	$type = $gis[2];
	switch ($type) {
		case 1:
			$imOrig = imagecreatefromgif($imgSrc);
			break;
		case 3:
			$imOrig = imagecreatefrompng($imgSrc);
			break;
		default:
			$imOrig = imagecreatefromjpeg($imgSrc);
	}

	$width = imagesx($imOrig);
	$height = imagesy($imOrig);
	if ($gis[0] <= $sizeW && $gis[1] <= $sizeH) {
		if (is_file($saveDir . $saveName)) {
			unlink($saveDir . $saveName);
		}
		rename($imgSrc, $saveDir . $saveName);
		return true;
	}

	// длина исходной картинки
	$editedWidth = $sizeW;
	$newHeight = $height * $sizeW / $width;
	// высота исходной картинки
	if ($sizeH < $newHeight) {
		$editedHeight = $sizeH;
		$editedWidth = $sizeW * $sizeH / $newHeight;
	} else {
		$editedHeight = $newHeight;
	}

	$im = imagecreatetruecolor($editedWidth, $editedHeight);
	if (imagecopyresampled($im, $imOrig, 0, 0, 0, 0, $editedWidth, $editedHeight, $width, $height)) {
		return imagejpeg($im, $saveDir . $saveName);
	}
	return false;
}

/////// END Img resize ///////


/////// Start Points Formats ///////
function point_format($string = null)
{
	if ($string < 0) {
		$string = 32768 + (32768 + $string);
	}
	return $string;
}

/////// END Points Formats ///////


/////// Start Country Formats ///////
function country($country, $getList = false)
{
	$countries = array(
		1 => 'Albania',
		2 => 'Algeria',
		3 => 'Angola',
		4 => 'Argentina',
		5 => 'Armenia',
		6 => 'Australia',
		7 => 'Austria',
		8 => 'Azerbaijan',
		9 => 'Bahamas',
		10 => 'Bahrain',
		11 => 'Bangladesh',
		12 => 'Belarus',
		13 => 'Belgium',
		14 => 'Bolivia',
		15 => 'Botswana',
		16 => 'Brazil',
		17 => 'Brunei',
		18 => 'Bulgaria',
		19 => 'Burkina Faso',
		20 => 'Cameroon',
		21 => 'Canada',
		22 => 'Chile',
		23 => 'China',
		24 => 'Colombia',
		25 => 'Congo (Brazzaville)',
		26 => 'Congo DR',
		27 => 'Costa Rica',
		28 => 'Cote dIvoire',
		29 => 'Croatia',
		30 => 'Cuba',
		31 => 'Czech Republic',
		32 => 'Denmark',
		33 => 'Dominican Republic',
		34 => 'Ecuador',
		35 => 'Egypt',
		36 => 'El Salvador',
		37 => 'Estonia',
		38 => 'Ethiopia',
		39 => 'Finland',
		40 => 'France',
		41 => 'Gabon',
		42 => 'Gambia',
		43 => 'Germany',
		44 => 'Greece',
		45 => 'Guatemala',
		46 => 'Guinea',
		47 => 'Guinea-Bissau',
		48 => 'Guyana',
		49 => 'Haiti',
		50 => 'Honduras',
		51 => 'Hong Kong',
		52 => 'Hungary',
		53 => 'Iceland',
		54 => 'India',
		55 => 'Indonesia',
		56 => 'Iran',
		57 => 'Iraq',
		58 => 'Ireland',
		59 => 'Israel',
		60 => 'Italy',
		61 => 'Jamaica',
		62 => 'Japan',
		63 => 'Jordan',
		64 => 'Kazakstan',
		65 => 'Kenya',
		66 => 'Korea',
		67 => 'Korea, South',
		68 => 'Kuwait',
		69 => 'Latvia',
		70 => 'Lebanon',
		71 => 'Liberia',
		72 => 'Libya',
		73 => 'Lithuania',
		74 => 'Luxembourg',
		75 => 'Madagascar',
		76 => 'Malawi',
		77 => 'Malaysia',
		78 => 'Mali',
		79 => 'Malta',
		80 => 'Mexico',
		81 => 'Moldova',
		82 => 'Mongolia',
		83 => 'Morocco',
		84 => 'Mozambique',
		85 => 'Myanmar (Burma)',
		86 => 'Namibia',
		87 => 'Netherlands',
		88 => 'New Zealand',
		89 => 'Nicaragua',
		90 => 'Niger',
		91 => 'Nigeria',
		92 => 'Norway',
		93 => 'Oman',
		94 => 'Pakistan',
		95 => 'Panama',
		96 => 'Papua New Guinea',
		97 => 'Paraguay',
		98 => 'Peru',
		99 => 'Philippines',
		100 => 'Poland',
		101 => 'Portugal',
		102 => 'Qatar',
		103 => 'Romania',
		104 => 'Russia',
		105 => 'Saudi Arabia',
		106 => 'Senegal',
		107 => 'Serbia',
		108 => 'Sierra Leone',
		109 => 'Singapore',
		110 => 'Slovakia',
		111 => 'Slovenia',
		112 => 'Somalia',
		113 => 'South Africa',
		114 => 'Spain',
		115 => 'Sri Lanka',
		116 => 'Sudan',
		117 => 'Suriname',
		118 => 'Sweden',
		119 => 'Switzerland',
		120 => 'Syria',
		121 => 'Taiwan',
		122 => 'Tanzania',
		123 => 'Thailand',
		124 => 'Togo',
		125 => 'Trinidad',
		126 => 'Tunisia',
		127 => 'Turkey',
		128 => 'Uganda',
		129 => 'Ukraine',
		130 => 'United Arab Emirates',
		131 => 'United Kingdom',
		132 => 'United States',
		133 => 'Uruguay',
		134 => 'Venezuela',
		135 => 'Vietnam',
		136 => 'Yemen',
		137 => 'Zambia',
		138 => 'Zimbabwe'
	);
	if ($getList) {
		return $countries;
	}
	return isset($countries[$country])
		? $countries[$country]
		: 'unknown';
}

/////// END Country Formats ///////


/////// Start Map Formats ///////
function map($map)
{
	switch ($map) {
		case 0:
			$map = 'Lorencia';
			break;
		case 1:
			$map = 'Dungeon';
			break;
		case 2:
			$map = 'Devias';
			break;
		case 3:
			$map = 'Noria';
			break;
		case 4:
			$map = 'LostTower';
			break;
		case 5:
			$map = 'PlaceOfExil';
			break;
		case 6:
			$map = 'Stadium';
			break;
		case 7:
			$map = 'Atlans';
			break;
		case 8:
			$map = 'Tarkan';
			break;
		case 9:
			$map = 'Devil Square';
			break;
		case 10:
			$map = 'Icarus';
			break;
		case 11:
			$map = 'Blood Castle 1';
			break;
		case 12:
			$map = 'Blood Castle 2';
			break;
		case 13:
			$map = 'Blood Castle 3';
			break;
		case 14:
			$map = 'Blood Castle 4';
			break;
		case 15:
			$map = 'Blood Castle 5';
			break;
		case 16:
			$map = 'Blood Castle 6';
			break;
		case 17:
			$map = 'Blood Castle 7';
			break;
		case 18:
			$map = 'Chaos Castle 1';
			break;
		case 19:
			$map = 'Chaos Castle 2';
			break;
		case 20:
			$map = 'Chaos Castle 3';
			break;
		case 21:
			$map = 'Chaos Castle 4';
			break;
		case 22:
			$map = 'Chaos Castle 5';
			break;
		case 23:
			$map = 'Chaos Castle 6';
			break;
		case 24:
			$map = 'Kalima 1';
			break;
		case 25:
			$map = 'Kalima 2';
			break;
		case 26:
			$map = 'Kalima 3';
			break;
		case 27:
			$map = 'Kalima 4';
			break;
		case 28:
			$map = 'Kalima 5';
			break;
		case 29:
			$map = 'Kalima 6';
			break;
		case 30:
			$map = 'Valley Of Loren';
			break;
		case 31:
			$map = 'Lands Of Trials';
			break;
		case 32:
			$map = 'Devil Square';
			break;
		case 33:
			$map = 'Aida';
			break;
		case 34:
			$map = 'CryWolf';
			break;
		case 36:
			$map = 'Kalima 7';
			break;
		case 37:
			$map = 'Kantru 1';
			break;
		case 38:
			$map = 'Kantru 2';
			break;
		case 39:
			$map = 'Kantru 3';
			break;
		case 40:
			$map = 'Silent';
			break;
		case 41:
			$map = 'Refuge';
			break;
		case 42:
			$map = 'Barracks';
			break;
		case 45:
			$map = 'Illusion 1';
			break;
		case 46:
			$map = 'Illusion 2';
			break;
		case 47:
			$map = 'Illusion 3';
			break;
		case 48:
			$map = 'Illusion 4';
			break;
		case 49:
			$map = 'Illusion 5';
			break;
		case 50:
			$map = 'Illusion 6';
			break;
		case 51:
			$map = 'Elbeland';
			break;
		case 52:
			$map = 'Blood Castle 8';
			break;
		case 53:
			$map = 'Chaos Castle 7';
			break;
		case 56:
			$map = 'Swamp Of Calmness';
			break;
		case 57:
			$map = 'Raklion';
			break;
		default:
			$map = 'unknown';
			break;
	}
	return $map;
}

/////// END Map Formats ///////


/////// Start PK Status Formats ///////
function pkstatus($pkStatus)
{
	switch ($pkStatus) {
		case 1:
			$pkStatus = 'Hero';
			break;
		case 2:
			$pkStatus = 'Commoner';
			break;
		case 3:
			$pkStatus = 'Normal';
			break;
		case 4:
			$pkStatus = 'Outlaw Warning';
			break;
		case 5:
			$pkStatus = '1 Outlaw';
			break;
		case 6:
			$pkStatus = '2 Outlaw';
			break;
		default:
			$pkStatus = 'unknown';
			break;
	}
	return $pkStatus;
}

/////// END PK Status Formats ///////


/////// Start Guild Status Formats ///////
function guild_status($num)
{
	switch ($num) {
		case 0:
			$num = mmw_lang_guild_member;
			break;
		case 32:
			$num = mmw_lang_battle_master;
			break;
		case 64:
			$num = mmw_lang_assistant_guild_master;
			break;
		case 128:
			$num = mmw_lang_guild_master;
			break;
		default:
			$num = 'unknown';
			break;
	}
	return $num;
}

/////// END Guild Status Formats ///////


/////// Start CtlCode Formats ///////
function ctlCode($num)
{
	switch ($num) {
		case 0:
			$result = 'Member';
			break;
		case 1:
			$result = 'Blocked';
			break;
		case 8:
		case 32:
			$result = 'Game Master';
			break;
		default:
			$result = 'unknown';
			break;
	}
	return $result;
}

/////// END CtlCode Formats ///////


/////// Start Gender Formats ///////
function gender($gender)
{
	switch ($gender) {
		case 'male':
			return mmw_lang_male . ' <img src="' . default_img('male.gif') . '" alt="male">';
		case 'female':
			return mmw_lang_female . ' <img src="' . default_img('female.gif') . '" alt="female">';
		default:
			return 'unknown';
	}
}

/////// END Gender Formats ///////


/////// Start Class Formats ///////
function char_class($class, $style = 'off')
{
	if ($class == 0) {
		$class_row = array('off' => 'DW', 'full' => 'Dark Wizard');
	} elseif ($class == 1) {
		$class_row = array('off' => 'SM', 'full' => 'Soul Master');
	} elseif ($class == 2 || $class == 3) {
		$class_row = array('off' => 'GrM', 'full' => 'Grand Master');
	} elseif ($class == 16) {
		$class_row = array('off' => 'DK', 'full' => 'Dark Knight');
	} elseif ($class == 17) {
		$class_row = array('off' => 'BK', 'full' => 'Blade Knight');
	} elseif ($class == 18 || $class == 19) {
		$class_row = array('off' => 'BM', 'full' => 'Blade Master');
	} elseif ($class == 32) {
		$class_row = array('off' => 'Elf', 'full' => 'Fairy Elf');
	} elseif ($class == 33) {
		$class_row = array('off' => 'ME', 'full' => 'Muse Elf');
	} elseif ($class == 34 || $class == 35) {
		$class_row = array('off' => 'HE', 'full' => 'High Elf');
	} elseif ($class == 48) {
		$class_row = array('off' => 'MG', 'full' => 'Magic Gladiator');
	} elseif ($class == 49 || $class == 50) {
		$class_row = array('off' => 'DM', 'full' => 'Duel Master');
	} elseif ($class == 64) {
		$class_row = array('off' => 'DL', 'full' => 'Dark Lord');
	} elseif ($class == 65 || $class == 66) {
		$class_row = array('off' => 'LE', 'full' => 'Lord Emperor');
	} elseif ($class == 80) {
		$class_row = array('off' => 'Sum', 'full' => 'Summoner');
	} elseif ($class == 81) {
		$class_row = array('off' => 'BSum', 'full' => 'Bloody Summoner');
	} elseif ($class == 82 || $class == 83) {
		$class_row = array('off' => 'Dim', 'full' => 'Dimension Master');
	} elseif ($class == 96) {
		$class_row = array('off' => 'RF', 'full' => 'Rage Fighter');
	} elseif ($class == 97 || $class == 98) {
		$class_row = array('off' => 'FM', 'full' => 'Fist Master');
	} else {
		$class_row = array('off' => 'unknown', 'full' => 'unknown');
	}

	switch (intval($class / 16)) {
		case 0:
			$group_row = array('img' => 'char/dw.gif', 'photo' => '0x00FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		case 1:
			$group_row = array('img' => 'char/dk.gif', 'photo' => '0x20FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		case 2:
			$group_row = array('img' => 'char/ef.gif', 'photo' => '0x40FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		case 3:
			$group_row = array('img' => 'char/mg.gif', 'photo' => '0x60FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		case 4:
			$group_row = array('img' => 'char/dl.gif', 'photo' => '0x80FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		case 5:
			$group_row = array('img' => 'char/sm.gif', 'photo' => '0xA0FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		case 6:
			$group_row = array('img' => 'char/rf.gif', 'photo' => '0xC0FFFFFFFFFF000000F80000F0FFFFFF');
			break;
		default:
			$group_row = array('img' => 'unknown', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');
			break;
	}

	return (isset($class_row[$style]) ? $class_row[$style] : '')
		. (isset($group_row[$style]) ? $group_row[$style] : '');
}

/////// END Class Formats ///////


/////// Start Win to UTF Formats ///////
function win_to_utf($str = null)
{
	$str = iconv('cp1251', 'UTF-8', $str);
	return str_replace('а', 'a', $str);
}

function utf_to_win($str = null)
{
	return iconv('UTF-8', 'cp1251//IGNORE', $str);
}

/////// END UTF to Win Formats ///////


/////// Start Guard MMW Message Info ///////
function guard_mmw_mess($to, $text)
{
	$date = date('m/d/y H:i:s');
	$msg_to_sql = mssql_query("SELECT GUID, MemoCount FROM dbo.T_FriendMain WHERE Name='{$to}'");
	$msg_to_row = mssql_fetch_row($msg_to_sql);
	$mail_total_sql = mssql_query("SELECT bRead FROM dbo.T_FriendMail WHERE GUID='{$msg_to_row[0]}'");
	$mail_total_num = mssql_num_rows($mail_total_sql);
	$msg_id = $msg_to_row[1] + 1;
	$msg_text = utf_to_win($text);
	mssql_query("INSERT INTO dbo.T_FriendMail (MemoIndex, GUID, FriendName, wDate, Subject, bRead, Memo, Dir, Act, Photo) VALUES ('{$msg_id}','{$msg_to_row[0]}','Guard','{$date}','MMW Message!','0',CAST('{$msg_text}' AS VARBINARY(1000)),'143','2',0x3061FF99999F12490400000060F0)");
	mssql_query("UPDATE dbo.T_FriendMain set [MemoCount]='{$msg_id}',[MemoTotal]='{$mail_total_num}' WHERE Name='{$to}'");
}

/////// Start Guard MMW Message Info ///////


/////// Start FreeHex Formats ///////
/**
 * @noinspection SpellCheckingInspection
 */
function free_hex($size, $cells, $style = 'F')
{
	if ($size === 20 && $style === 'F') {
		$hex = 'FFFFFFFFFFFFFFFFFFFF';
	} // 0.97 - 1.02
	elseif ($size === 32 && $style === 'F') {
		$hex = 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
	} // 1.02+
	else {
		$hex = str_repeat($style, $size);
	}
	return str_repeat($hex, $cells);
}

/////// END FreeHex Formats ///////


/////// Start Comment module ///////
/**
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUnusedLocalVariableInspection
 */
function comment_module($c_id_blog, $c_id_code, $c_add_close = false)
{
	global $mmw, $okey_start, $okey_end, $die_start, $die_end, $rowbr;
	require __DIR__ . '/comment.php';

	return isset($quantityComment)
		? $quantityComment
		: 0;
}

/////// END Comment module ///////


/////// Start Comment module ///////
function remove_utf8_bom($text)
{
	if (!is_string($text)) {
		return $text;
	}

	/** @noinspection SpellCheckingInspection */
	$bom = pack('H*', 'EFBBBF');

	return preg_replace("/^$bom/", '', $text);
}
/////// END Comment module ///////
