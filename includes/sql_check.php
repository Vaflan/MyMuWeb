<?php
// Anti-SQL Injection from MuWeb.org
function xw_sanitycheck($str)
{
	// SECURITY FIX: this used to be
	//   return (strpos($str, "'") != false) ? str_replace("'", '&#39;', $str) : $str;
	// strpos() returns 0 when the first character is a quote, and 0 != false is
	// false, so any value beginning with "'" was returned completely unescaped.
	// secure() feeds this function from $_GET, $_REQUEST, $_POST and $_COOKIE,
	// so every quoted string context in the application was injectable.
	// The data arriving here is raw request data and has not been escaped yet,
	// so it must always be escaped.
	return str_replace("'", '&#39;', $str);
}

function secure($str)
{
	// Case of an array
	if (is_array($str)) {
		foreach ($str as $id => $value) {
			$str[$id] = secure($value);
		}
	} else {
		$str = xw_sanitycheck($str);
	}

	return $str;
}

// Get Filter 
$xweb_AI = @array_keys($_GET);
$i = 0;
while ($i < count($xweb_AI)) {
	$_GET[$xweb_AI[$i]] = secure($_GET[$xweb_AI[$i]]);
	$i++;
}
unset($xweb_AI);

// Request Filter 
$xweb_AI = @array_keys($_REQUEST);
$i = 0;
while ($i < count($xweb_AI)) {
	$_REQUEST[$xweb_AI[$i]] = secure($_REQUEST[$xweb_AI[$i]]);
	$i++;
}
unset($xweb_AI);

// Post Filter 
$xweb_AI = @array_keys($_POST);
$i = 0;
while ($i < count($xweb_AI)) {
	$_POST[$xweb_AI[$i]] = secure($_POST[$xweb_AI[$i]]);
	$i++;
}

// Cookie Filter (do we have a login system?) 
$xweb_AI = @array_keys($_COOKIE);
$i = 0;
while ($i < count($xweb_AI)) {
	$_COOKIE[$xweb_AI[$i]] = secure($_COOKIE[$xweb_AI[$i]]);
	$i++;
}
// End 
