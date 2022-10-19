<?php
/*
Plugin Name: Anti-XSS attack
Plugin URI: http://maxsite.org/anti-xss-attack
Description: Защита/предупреждение XSS-атак (в модификации Макса/maxsite.org ). Адаптирован для WP 2.5.
Author: Yuri 'Bela' Belotitski
Version: 0.5 beta @ 02.06.2008
Author URI: http://www.portal.khakrov.ua/
Modified by Vaflan 19.10.2010
*/

if (isset($_SERVER['HTTP_REFERER'])) {
	$parse = parse_url($_SERVER['HTTP_REFERER']);

	if ($parse['host'] > $_SERVER['HTTP_HOST']) {
		if ($_POST) {
			die('<div style="color:red;font-weight:bold;">Achtung! XSS attack!</div>');
		}
		if ($_GET) {
			die('<div style="color:maroon;font-weight:bold;">Achtung! XSS attack?</div>Confirm transition: <a href="' . $_SERVER['REQUEST_URI'] . '">' . $_SERVER['REQUEST_URI'] . '</a><script>window.location=\'' . $_SERVER['REQUEST_URI'] . '\';</script>');
		}
	}
}
