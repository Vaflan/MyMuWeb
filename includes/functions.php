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

	if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date_row[0], $matches) && $matches) {
		$unixTimestamp = strtotime($date);
		return ($format !== null)
			? date($format, $unixTimestamp)
			: $unixTimestamp;
	} elseif (preg_match('/^\d+$/', $date_row[1], $matches) && $matches) {
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
	if (isset($_GET['op'])) {
		$currentModule = preg_replace('/[^\w_-]/', '', $_GET['op']);
	} else {
		global $mmw;
		$splitFileName = explode('.', $mmw['home_page']);
		$currentModule = reset($splitFileName);
	}

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
		if (isset($_GET['u'])) {
			$currentUserModule = $_GET['u'];
			$userLabel = defined('mmw_lang_' . $currentUserModule)
				? constant('mmw_lang_' . $currentUserModule)
				: ucfirst($currentUserModule);

			echo ' &gt; <a href="?op=user&u=' . $currentUserModule . '">' . $userLabel . '</a>';
		} else {
			echo ' &gt; <a href="?op=user&u=acc">' . mmw_lang_account_panel . '</a>';
		}
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
		'/\[video\].*youtube.com\/watch[^=]+=(.*?)\[\/video\]/is' => '<iframe width="416" height="234" src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>',
	);
	$text = preg_replace(array_keys($bbCode), array_values($bbCode), $text);
	return $text;
}

/////// END BBCode Formats ///////


/////// Start Smile Formats ///////
function emojiList($smallList = false)
{
	static $smiles = array(
		' >( ' => ' <img src=images/smile/angry.gif alt=angry border=0> ',
		' :D ' => ' <img src=images/smile/biggrin.gif alt=biggrin border=0> ',
		' B) ' => ' <img src=images/smile/cool.gif alt=cool border=0> ',
		' ;( ' => ' <img src=images/smile/cry.gif alt=cry border=0> ',
		' <_< ' => ' <img src=images/smile/dry.gif alt=dry border=0> ',
		' ^_^ ' => ' <img src=images/smile/happy.gif alt=happy border=0> ',
		' :( ' => ' <img src=images/smile/sad.gif alt=sad border=0> ',
		' :) ' => ' <img src=images/smile/smile.gif alt=smile border=0> ',
		' :o ' => ' <img src=images/smile/surprised.gif alt=surprised border=0> ',
		' :p ' => ' <img src=images/smile/tongue.gif alt=tongue border=0> ',
		' %) ' => ' <img src=images/smile/wacko.gif alt=wacko border=0> ',
		' ;) ' => ' <img src=images/smile/wink.gif alt=wink border=0> ',
		' (hello) ' => ' <img src=images/smile/hello.gif alt=hello border=0> ',
		' (boo) ' => ' <img src=images/smile/boo.gif alt=boo border=0> ',
		' (bb) ' => ' <img src=images/smile/bb.gif alt=bodybuilding border=0> ',
	);
	return $smallList
		? array_slice($smiles, 0, 12)
		: $smiles;
}
function smile($content = '')
{
	$smiles = emojiList();

	// Special Characters in HTML
	$content = str_replace(
		array(
			' &gt;( ',
			' &lt;_&lt; ',
			' &#37;) ',
		),
		array(
			$smiles[' >( '],
			$smiles[' <_< '],
			$smiles[' %) '],
		),
		$content
	);
	return str_replace(array_keys($smiles), array_values($smiles), $content);
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
function map($map, $getList = false)
{
	$locations = [
		0 => 'Lorencia',
		1 => 'Dungeon',
		2 => 'Devias',
		3 => 'Noria',
		4 => 'LostTower',
		5 => 'PlaceOfExil',
		6 => 'Arena',
		7 => 'Atlans',
		8 => 'Tarkan',
		9 => 'Devil Square',
		10 => 'Icarus',
		11 => 'Blood Castle 1',
		12 => 'Blood Castle 2',
		13 => 'Blood Castle 3',
		14 => 'Blood Castle 4',
		15 => 'Blood Castle 5',
		16 => 'Blood Castle 6',
		17 => 'Blood Castle 7',
		18 => 'Chaos Castle 1',
		19 => 'Chaos Castle 2',
		20 => 'Chaos Castle 3',
		21 => 'Chaos Castle 4',
		22 => 'Chaos Castle 5',
		23 => 'Chaos Castle 6',
		24 => 'Kalima 1',
		25 => 'Kalima 2',
		26 => 'Kalima 3',
		27 => 'Kalima 4',
		28 => 'Kalima 5',
		29 => 'Kalima 6',
		30 => 'Valley Of Loren',
		31 => 'Lands Of Trials',
		32 => 'Devil Square',
		33 => 'Aida',
		34 => 'Crywolf Fortress',
		36 => 'Kalima 7',
		37 => 'Kanturu',
		38 => 'Kanturu 2',
		39 => 'Kanturu 3',
		40 => 'Silent',
		41 => 'Refuge',
		42 => 'Barracks',
		45 => 'Ilusion Temple 1',
		46 => 'Ilusion Temple 2',
		47 => 'Ilusion Temple 3',
		48 => 'Ilusion Temple 4',
		49 => 'Ilusion Temple 5',
		50 => 'Ilusion Temple 6',
		51 => 'Elbeland',
		52 => 'Blood Castle 8',
		53 => 'Chaos Castle 7',
		56 => 'Swamp of Calmness',
		57 => 'Raklion',
		58 => 'Raklion Boss',
		62 => 'Santa\'s Village',
		63 => 'Vulcanus',
		64 => 'Duel Arena',
		65 => 'Doppelganger',
		66 => 'Doppelganger',
		67 => 'Doppelganger',
		68 => 'Doppelganger',
		69 => 'Imperial Guardian',
		70 => 'Imperial Guardian',
		71 => 'Imperial Guardian',
		72 => 'Imperial Guardian',
		79 => 'Loren Market',
		80 => 'Karutan 1',
		81 => 'Karutan 2',
		82 => 'Doppelganger',
		91 => 'Acheron',
		92 => 'Acheron',
		95 => 'Debenter',
		96 => 'Debenter',
		97 => 'Chaos Castle',
		98 => 'Ilusion Temple 7',
		99 => 'Ilusion Temple 8',
		100 => 'Uruk Mountain',
		101 => 'Uruk Mountain',
		102 => 'Tormented Square',
		103 => 'Tormented Square',
		104 => 'Tormented Square',
		105 => 'Tormented Square',
		106 => 'Tormented Square',
		110 => 'Nars',
		112 => 'Ferea',
		113 => 'Nixie Lake',
		114 => 'Quest Zone',
		115 => 'Labyrinth',
		116 => 'Deep Dungeon',
		117 => 'Deep Dungeon',
		118 => 'Deep Dungeon',
		119 => 'Deep Dungeon',
		120 => 'Deep Dungeon',
		121 => 'Quest Zone',
		122 => 'Swamp of Darkness',
		123 => 'Kubera Mine',
		124 => 'Kubera Mine',
		125 => 'Kubera Mine',
		126 => 'Kubera Mine',
		127 => 'Kubera Mine',
		128 => 'Atlans Abyss',
		129 => 'Atlans Abyss 2',
		130 => 'Atlans Abyss 3',
		131 => 'Scorched Canyon',
		132 => 'Crimson Flame Icarus',
		133 => 'Temple of Arnil',
		134 => 'Aida Gray',
		135 => 'Old Kethotum',
		136 => 'Burning Kethotum',
	];
	if ($getList) {
		return $locations;
	}
	return isset($locations[$map])
		? $locations[$map]
		: 'unknown';
}

/////// END Map Formats ///////


/////// Start PK Status Formats ///////
function pkstatus($pkStatus)
{
	switch ($pkStatus) {
		case 0:
			return 'Normal';
		case 1:
		case 2:
			return 'Hero';
		case 3:
			return 'Commoner';
		case 4:
			return 'Warning';
		case 5:
			return 'Murder';
		case 6:
			return 'Outlaw';
		default:
			return 'unknown';
	}
}

/////// END PK Status Formats ///////


/////// Start Guild Status Formats ///////
function guild_status($num)
{
	switch ($num) {
		case 0:
			return mmw_lang_guild_member;
		case 32:
			return mmw_lang_battle_master;
		case 64:
			return mmw_lang_assistant_guild_master;
		case 128:
			return mmw_lang_guild_master;
		default:
			return 'unknown';
	}
}

/////// END Guild Status Formats ///////


/////// Start CtlCode Formats ///////
function ctlCode($num)
{
	switch ($num) {
		case 0:
			return 'Normal';
		case 1:
			return 'Blocked';
		case 8:
			return 'GM Invisible';
		case 32:
			return 'Game Master';
		default:
			return 'unknown';
	}
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
	/**
	 * ### Season 6:
	 * level1: 0
	 * level2: +1 [skip: MG/DL/RF]
	 * level3: +2 [include: DM/LE/FM]
	 */
	static $groupedClasses = array(
		0 => array('group' => 'dw', 'img' => 'char/DW.gif', 'photo' => '0x00FFFFFFFFFF000000F80000F0FFFFFF'),
		1 => array('group' => 'dk', 'img' => 'char/DK.gif', 'photo' => '0x20FFFFFFFFFF000000F80000F0FFFFFF'),
		2 => array('group' => 'fe', 'img' => 'char/EF.gif', 'photo' => '0x40FFFFFFFFFF000000F80000F0FFFFFF'),
		3 => array('group' => 'mg', 'img' => 'char/MG.gif', 'photo' => '0x60FFFFFFFFFF000000F80000F0FFFFFF'),
		4 => array('group' => 'dl', 'img' => 'char/DL.gif', 'photo' => '0x80FFFFFFFFFF000000F80000F0FFFFFF'),
		5 => array('group' => 'sm', 'img' => 'char/SM.gif', 'photo' => '0xA0FFFFFFFFFF000000F80000F0FFFFFF'),
		6 => array('group' => 'rf', 'img' => 'char/RF.gif', 'photo' => '0xC0FFFFFFFFFF000000F80000F0FFFFFF'),
		7 => array('group' => 'gl', 'img' => 'char/.gif', 'photo' => '0xE0FFFFFFFFFF000000F80000F0FFFFFF'),
		8 => array('group' => 'rw', 'img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF'),
		9 => array('group' => 'sl', 'img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF'),
		10 => array('group' => 'gc', 'img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF'),
		11 => array('group' => 'lw', 'img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF'),
		12 => array('group' => 'lm', 'img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF'),
		13 => array('group' => 'ik', 'img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF'),
	);

	$class = intval($class);
	$group = intval($class / 16);

	switch (true) {
		case ($class === 0):
			$result = array('off' => 'DW', 'full' => 'Dark Wizard', 'level' => 1);
			break;
		case ($class === 1):
			$result = array('off' => 'SM', 'full' => 'Soul Master', 'level' => 2);
			break;
		case ($class === 2 || $class === 3):
			$result = array('off' => 'GrM', 'full' => 'Grand Master', 'level' => 3);
			break;
		case ($class === 7):
			$result = array('off' => 'SW', 'full' => 'Soul Wizard', 'level' => 4);
			break;

		case ($class === 16):
			$result = array('off' => 'DK', 'full' => 'Dark Knight', 'level' => 1);
			break;
		case ($class === 17):
			$result = array('off' => 'BK', 'full' => 'Blade Knight', 'level' => 2);
			break;
		case ($class === 18 || $class === 19):
			$result = array('off' => 'BM', 'full' => 'Blade Master', 'level' => 3);
			break;
		case ($class === 23):
			$result = array('off' => 'DrK', 'full' => 'Dragon Knight', 'level' => 4);
			break;

		case ($class === 32):
			$result = array('off' => 'FE', 'full' => 'Fairy Elf', 'level' => 1);
			break;
		case ($class === 33):
			$result = array('off' => 'ME', 'full' => 'Muse Elf', 'level' => 2);
			break;
		case ($class === 34 || $class === 35):
			$result = array('off' => 'HE', 'full' => 'High Elf', 'level' => 3);
			break;
		case ($class === 39):
			$result = array('off' => 'NE', 'full' => 'Noble Elven', 'level' => 4);
			break;

		case ($class === 48):
			$result = array('off' => 'MG', 'full' => 'Magic Gladiator', 'level' => 1);
			break;
		case ($class === 49 || $class === 50):
			$result = array('off' => 'DM', 'full' => 'Duel Master', 'level' => 3);
			break;
		case ($class === 54 || $class === 55):
			$result = array('off' => 'MK', 'full' => 'Magic Knight', 'level' => 4);
			break;

		case ($class === 64):
			$result = array('off' => 'DL', 'full' => 'Dark Lord', 'level' => 1);
			break;
		case ($class === 65 || $class === 66):
			$result = array('off' => 'LE', 'full' => 'Lord Emperor', 'level' => 3);
			break;
		case ($class === 70 || $class === 71):
			$result = array('off' => 'ER', 'full' => 'Empire Roar', 'level' => 4);
			break;

		case ($class === 80):
			$result = array('off' => 'Sum', 'full' => 'Summoner', 'level' => 1);
			break;
		case ($class === 81):
			$result = array('off' => 'BSum', 'full' => 'Bloody Summoner', 'level' => 2);
			break;
		case ($class === 82 || $class === 83):
			$result = array('off' => 'DiM', 'full' => 'Dimension Master', 'level' => 3);
			break;
		case ($class === 87):
			$result = array('off' => 'DS', 'full' => 'Dimension Summoner', 'level' => 4);
			break;

		case ($class === 96):
			$result = array('off' => 'RF', 'full' => 'Rage Fighter', 'level' => 1);
			break;
		case ($class === 97 || $class === 98):
			$result = array('off' => 'FM', 'full' => 'Fist Master', 'level' => 3);
			break;
		case ($class === 102 || $class === 103):
			$result = array('off' => 'FB', 'full' => 'Fists Blazer', 'level' => 4);
			break;

		case ($class === 112):
			$result = array('off' => 'GL', 'full' => 'Grow Lancer', 'level' => 1);
			break;
		case ($class === 114 || $class === 115):
			$result = array('off' => 'ML', 'full' => 'Mirage Lancer', 'level' => 3);
			break;
		case ($class === 118 || $class === 119):
			$result = array('off' => 'ShL', 'full' => 'Shining Lancer', 'level' => 4);
			break;

		case ($class === 128):
			$result = array('off' => 'RW', 'full' => 'Rune Wizard', 'level' => 1);
			break;
		case ($class === 129):
			$result = array('off' => 'RSM', 'full' => 'Rune Spell Master', 'level' => 2);
			break;
		case ($class === 130 || $class === 131):
			$result = array('off' => 'GRM', 'full' => 'Grand Rune Master', 'level' => 3);
			break;
		case ($class === 135):
			$result = array('off' => 'MRW', 'full' => 'Majestic Rune Wizard', 'level' => 4);
			break;

		case ($class === 144):
			$result = array('off' => 'SL', 'full' => 'Slayer', 'level' => 1);
			break;
		case ($class === 145):
			$result = array('off' => 'RS', 'full' => 'Royal Slayer', 'level' => 2);
			break;
		case ($class === 146 || $class === 147):
			$result = array('off' => 'MS', 'full' => 'Master Slayer', 'level' => 3);
			break;
		case ($class === 151):
			$result = array('off' => 'St', 'full' => 'Slaughterer', 'level' => 4);
			break;

		case ($class === 160):
			$result = array('off' => 'GC', 'full' => 'Gun Crusher', 'level' => 1);
			break;
		case ($class === 161):
			$result = array('off' => 'GB', 'full' => 'Gun Breaker', 'level' => 2);
			break;
		case ($class === 162 || $class === 163):
			$result = array('off' => 'MGB', 'full' => 'Master Gun Breaker', 'level' => 3);
			break;
		case ($class === 167):
			$result = array('off' => 'HGC', 'full' => 'High Gun Crusher', 'level' => 4);
			break;

		case ($class === 176):
			$result = array('off' => 'LiW', 'full' => 'Light Wizard', 'level' => 1);
			break;
		case ($class === 177):
			$result = array('off' => 'LiM', 'full' => 'Light Master', 'level' => 2);
			break;
		case ($class === 178 || $class === 179):
			$result = array('off' => 'ShW', 'full' => 'Shining Wizard', 'level' => 3);
			break;
		case ($class === 183):
			$result = array('off' => 'LuW', 'full' => 'Luminous Wizard', 'level' => 4);
			break;

		case ($class === 192):
			$result = array('off' => 'Lem', 'full' => 'Lemuria Mage', 'level' => 1);
			break;
		case ($class === 193):
			$result = array('off' => 'Wam', 'full' => 'Warmage', 'level' => 2);
			break;
		case ($class === 194 || $class === 195):
			$result = array('off' => 'Arm', 'full' => 'Archmage', 'level' => 3);
			break;
		case ($class === 199):
			$result = array('off' => 'MyM', 'full' => 'Mystic Mage', 'level' => 4);
			break;

		case ($class === 208):
			$result = array('off' => 'IK', 'full' => 'Illusion Knight', 'level' => 1);
			break;
		case ($class === 210 || $class === 211):
			$result = array('off' => 'MK', 'full' => 'Mirage Knight', 'level' => 3);
			break;
		case ($class === 213 || $class === 214):
			$result = array('off' => 'IM', 'full' => 'Illusion Master', 'level' => 4);
			break;

		default:
			$result = array('off' => '??', 'full' => 'Unknown', 'level' => 0);
	}
	$result += isset($groupedClasses[$group])
		? $groupedClasses[$group]
		: array('img' => 'char/.gif', 'photo' => '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');

	if ($style === null) {
		return $result;
	}
	return isset($result[$style])
		? $result[$style]
		: '';
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
