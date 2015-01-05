<?php
ob_start();
session_start();
header("Cache-control: private");
header("Cache-control: max-age=3600");
@date_default_timezone_set('Europe/Helsinki');
$_SESSION['TimeStart'] = gettimeofday();

require('config.php');
include('includes/mmw.php');
include('includes/sql_check.php');
include('includes/xss_check.php');
include('includes/engine.php');



// To Look After All
if($mmw[look_after_all] > 0) {
 writelog('look_after_all', '<b>'.urlencode('http://'.$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI']).'</b>');
}

// Check For Installed
if(!is_file('includes/installed.php')) {
 jump('install.php');
}

// Start Header
if(is_file($mmw['theme_dir'].'/header.php')) {
 include($mmw['theme_dir'].'/header.php');
}
else {
 die($mmw['die']['start'].'ErroR Theme!<br>Can\'t find <b>'.$mmw['theme_dir'].'/header.php</b>!'.$mmw['die']['end']);
}

// Start Body
if(isset($_GET['news'])) {
 include('modules/news_full.php');
}
elseif(isset($_GET['forum'])) {
 include('modules/forum_full.php');
}
elseif(isset($_GET['op'])) {
 $op = preg_replace("/[^a-zA-Z0-9_-]/", '', $_GET['op']);
 if(is_file('modules/'.$op.'.php')) {include('modules/'.$op.'.php');}
 elseif(is_file('modules/'.$op.'.mmw')) {mmw('modules/'.$op.'.mmw');}
 else {echo $die_start.'Request is False!<br><a href="http://geoiptool.com/en/?ip='.$_SERVER['REMOTE_ADDR'].'">Now we have your IP Address!</a>'.$die_end;}
}
else {
 $exe = end(explode('.', $mmw['home_page']));
 switch($exe) {
  case 'php': include('modules/'.$mmw['home_page']); break;
  case 'mmw': mmw('modules/'.$mmw['home_page']); break;
  default: echo @file_get_contents('modules/'.$mmw['home_page']); break;
 }
}

// Start Pop Under
if($mmw['popunder'] > 0) {
 if($mmw['popunder_check'] > 0 && empty($_SESSION['user'])) {
  mmw('includes/popunder.mmw');
 }
 elseif($mmw['popunder_check'] < 1) {
  mmw('includes/popunder.mmw');
 }
}
else {
 echo '<!-- MyMuWeb PopUnder Turn Off -->';
}

// ADS by Vaflan
if(filectime('includes/installed.php')+86400 < time()) {
 $mmwads = substr(md5(date("H")),0,6);
 echo '<div style="height:60px; margin-top:2px;"><div style="position:absolute;">'
  .'<script type="text/javascript">google_ad_client="pub-4674738152966972"; google_ad_slot="4128955460"; google_ad_width=468; google_ad_height=60;</script>'
  .'<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>'
  .'</div></div>';
}

// Start Footer
if(is_file($mmw['theme_dir'].'/footer.php')) {
 include($mmw['theme_dir'].'/footer.php');
}
else {
 die($mmw['die']['start'].'ErroR Theme!<br>Can\'t find <b>'.$mmw['theme_dir'].'/footer.php</b>!'.$mmw['die']['die']);
}

mssql_close($mssql_connect);
ob_end_flush();
?>