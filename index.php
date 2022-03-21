<?PHP
ob_start();
session_start();
header("Cache-control: private");
header("Cache-control: max-age=3600");
$_SESSION[TimeStart] = gettimeofday();
require("config.php");
include("includes/banned.php");
include("includes/sql_check.php");
include("includes/xss_check.php");
include("includes/mmw-func.php");
include("includes/engine.php");
include("includes/format.php");

// To Look After All
if($mmw[look_after_all] == 'yes') {
 writelog("look_after_all","<b>".urldecode('http://'.$_SERVER["SERVER_ADDR"].$_SERVER["REQUEST_URI"])."</b>");
}

// Check For Installed
if(is_file("includes/installed.php")) {
 include("includes/installed.php");
}
else {
 header('Location: install.php');
}

// Start Header
if(is_file("$mmw[theme_dir]/header.php")) {
 include("$mmw[theme_dir]/header.php");
}
else {
 die("$sql_die_start ErroR Theme!<br>Cant find <b>$mmw[theme_dir]/header.php</b>! $sql_die_end");
}

// Start Body
if(isset($_GET[news])) {
 include("modules/news_full.php");
}
elseif(isset($_GET[forum])) {
 include("modules/forum_full.php");
}
elseif(isset($_GET[op])) {
 $op = preg_replace("/[^a-zA-Z0-9_-]/",'',$_GET[op]);
 if(is_file("modules/$op.php")) {include("modules/$op.php");}
 elseif(is_file("modules/$op.mmw")) {mmw("modules/$op.mmw");}
 else {echo "$die_start Request is False!<br><a href=' http://geoiptool.com/en/?ip=$_SERVER[REMOTE_ADDR]'>Now we have your IP Address!</a> $die_end";}
}
else {
 include("modules/news.php");
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