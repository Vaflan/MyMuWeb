<?php
ob_start();
session_start();
header('Connection: Keep-Alive');
header('Cache-Control: Private');
define('TIME_START', serialize(gettimeofday()), false);

/**
 * @var array $mmw
 * @var string $die_start
 * @var string $die_end
 * @var resource $mssql_connect
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/sql_check.php';
require_once __DIR__ . '/includes/xss_check.php';
require_once __DIR__ . '/includes/engine.php';

// To Look After All
if ($mmw['look_after_all']) {
	writelog('look_after_all', '<b>' . urlencode('//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '</b>');
}

// Check For Installed
if (!is_file(__DIR__ . '/includes/installed.php')) {
	jump('install.php');
}

// Start Header
if (is_file($mmw['theme_dir'] . '/header.php')) {
	require_once $mmw['theme_dir'] . '/header.php';
} else {
	die($mmw['die']['start'] . 'Theme error!<br>Can`t find <b>' . $mmw['theme_dir'] . '/header.php</b>!' . $mmw['die']['end']);
}

// Start Body
$moduleDirectory = __DIR__ . '/modules/';
if (isset($_GET['news'])) {
	require_once $moduleDirectory . 'news_full.php';
} elseif (isset($_GET['forum'])) {
	require_once $moduleDirectory . 'forum_full.php';
} elseif (isset($_GET['op'])) {
	$op = preg_replace('/[^\w_-]/', '', $_GET['op']);
	if (is_file($moduleDirectory . $op . '.php')) {
		require_once $moduleDirectory . $op . '.php';
	} elseif (is_file($moduleDirectory . $op . '.mmw')) {
		mmw($moduleDirectory . $op . '.mmw');
	} elseif (is_file($moduleDirectory . $op . '.html')) {
		echo file_get_contents($moduleDirectory . $op . '.html');
	} else {
		echo $die_start . 'Request is False!<br><a href="https://geoiptool.com/en/?ip=' . $_SERVER['REMOTE_ADDR'] . '">Now we have your IP Address!</a>' . $die_end;
	}
} else {
	$splitFileName = explode('.', $mmw['home_page']);
	switch (end($splitFileName)) {
		case 'php':
			require_once $moduleDirectory . $mmw['home_page'];
			break;
		case 'mmw':
			mmw($moduleDirectory . $mmw['home_page']);
			break;
		default:
			echo @file_get_contents($moduleDirectory . $mmw['home_page']);
			break;
	}
}

// Start Pop Under
if ($mmw['popunder']) {
	if (!$mmw['popunder_check'] || ($mmw['popunder_check'] && empty($_SESSION['user']))) {
		mmw('includes/pop_under.mmw');
	}
}

// ADS for Vaflan
if (filectime(__DIR__ . '/includes/installed.php') + 604800 < time()) {
	echo <<<HTML
<div style="margin-top:2px;position:relative;">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4674738152966972"
		 crossorigin="anonymous"></script>
</div>
HTML;
}

// Start Footer
if (is_file($mmw['theme_dir'] . '/footer.php')) {
	require_once $mmw['theme_dir'] . '/footer.php';
} else {
	die($mmw['die']['start'] . 'Theme error!<br>Can`t find <b>' . $mmw['theme_dir'] . '/footer.php</b>!' . $mmw['die']['die']);
}

if (!empty($_ENV['mmw_cache'])) {
	$data = json_encode($_ENV['mmw_cache']);
	if ($_ENV['mmw_cache_raw'] !== $data && is_writable(__DIR__ . '/includes/mmw_cache.dat')) {
		file_put_contents(__DIR__ . '/includes/mmw_cache.dat', $data);
	}
}
mssql_close($mssql_connect);
ob_end_flush();
