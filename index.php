<?PHP
ob_start();
session_start();
header("Cache-control: private");
header("Cache-control: max-age=3600");
@date_default_timezone_set('Europe/Helsinki');
$_SESSION[TimeStart] = gettimeofday();
require_once("config.php");
require_once("includes/banned.php");
require_once("includes/sql_check.php");
require_once("includes/xss_check.php");
require_once("includes/mmw-func.php");
require_once("includes/engine.php");

// To Look After All
if($mmw[look_after_all] == 'yes') {
 writelog("look_after_all","<b>".urldecode('http://'.$_SERVER["SERVER_ADDR"].$_SERVER["REQUEST_URI"])."</b>");
}

// Check For Installed
if(is_file("includes/installed.php")) {
 require_once("includes/installed.php");
}
else {
 header('Location: install.php');
}

// Start Header
if(is_file("$mmw[theme_dir]/header.php")) {
 require_once("$mmw[theme_dir]/header.php");
}
else {
 die("$sql_die_start ErroR Theme!<br>Cant find <b>$mmw[theme_dir]/header.php</b>! $sql_die_end");
}

// Start Body
if(isset($_GET['op'])) {
switch($_GET['op']) {
  case 'news': $op='news'; break;
  case 'user': $op='user'; break;
  case 'character': $op='character'; break;
  case 'register': $op='register'; break;
  case 'downloads': $op='downloads'; break;
  case 'info': $op='information'; break;
  case 'castlesiege': $op='castlesiege'; break;
  case 'statistics': $op='statistics'; break;
  case 'rankings': $op='rankings'; break;
  case 'login': $op='login'; break;
  case 'forum': $op='forum'; break;
  case 'alliance'; $op='alliance'; break;
  case 'blocked'; $op='blocked'; break;
  case 'gallery'; $op='gallery'; break;
  case 'profile'; $op='profile'; break;
  case 'chat'; $op='chat'; break;
  case 'checkacc': $op='checkacc'; break;
  case 'guild'; $op='guild'; break;
  case 'lostpass'; $op='lostpass'; break;
  case 'search'; $op='search'; break;
  default: $op=''.$mmw["home_page"].'';
}
if(is_file("modules/$op.php")) {
 require_once("modules/$op.php");
}
elseif(is_file("modules/$op.mmw")) {
mmw("modules/$op.mmw");}
}
elseif(isset($_GET['news'])) {
 require_once("modules/news_full.php");
}
elseif(isset($_GET['forum'])) {
 require_once("modules/forum_full.php");
}
else {
 require_once("modules/news.php");
}

// Start Pop Under
if($mmw[popunder]=='yes' && $mmw[popunder_check]=='yes' && empty($_SESSION[user])) {
 mmw("includes/popunder.mmw");
}
elseif($mmw[popunder]=='yes' && $mmw[popunder_check]!='yes') {
 mmw("includes/popunder.mmw");
}
else {
 echo "<!-- MyMuWeb PopUnder Turn Off -->";
}

// ADS by Vaflan
if($mmw['thm_name']!='Default' && $mmw['thm_version']!='2.0' && $mmw['thm_creator']!='Vaflan') {
echo '<div style="text-align:center;padding:2px;">';
echo '<script type="text/javascript">google_ad_client="pub-4674738152966972"; google_ad_slot="4128955460"; google_ad_width=468; google_ad_height=60;</script>';
echo '<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
echo '</div>';}

// Start Footer
if(is_file("$mmw[theme_dir]/footer.php")) {
 include("$mmw[theme_dir]/footer.php");
}
else {
 die("$sql_die_start ErroR Theme!<br>Cant find <b>$mmw[theme_dir]/footer.php</b>! $sql_die_end");
}

mssql_close($mssql_connect);
ob_end_flush();
?>