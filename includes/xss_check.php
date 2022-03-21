<?php
/*
Plugin Name: Anti-XSS attack
Plugin URI: http://maxsite.org/anti-xss-attack
Description: Защита/предупреждение XSS-атак (в модификации Макса/maxsite.org ). Адаптирован для WP 2.5.
Author: Yuri 'Bela' Belotitski
Version: 0.5 beta @ 02.06.2008
Author URI: http://www.portal.khakrov.ua/
*/


function htauth() 
{
    if (strpos($_SERVER['REQUEST_URI'], 'wp-admin') === false ) return;
    if (strpos($_SERVER['REQUEST_URI'], 'async-upload.php') != false ) return;
    
    $p = parse_url($_SERVER['HTTP_REFERER']);
    $p = $p['host'];
    
    if ( $p != $_SERVER['HTTP_HOST'] )
    {
        if ($_POST) die('<b><font color="red">Achtung! XSS attack!</font></b>');
        if ($_GET)  die('<b><font color="maroon">Achtung! XSS attack?</font></b><br>Confirm transition: <a href="' 
                        . $_SERVER['REQUEST_URI'] . '">' 
                        . $_SERVER['REQUEST_URI'] . '</a>');
    }
}

htauth();

?>