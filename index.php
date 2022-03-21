<?PHP
ob_start();
session_start();
header("Cache-control: private");
$timeStart=gettimeofday();
$timeStart_uS=$timeStart["usec"];
$timeStart_S=$timeStart["sec"];
include("config.php");
include("includes/sql_check.php");
include("includes/xss_check.php");
include("includes/functions.php");
include("includes/formats.php");
include("menu.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?echo $mmw[webtitle];?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<script type="text/javascript" src="scripts/functions.js">//script_by_vaflan</script>
	<script type="text/javascript" src="scripts/textfader.js">//script_by_vaflan</script>
	<script type="text/javascript" src="scripts/helptip.js">//script_by_vaflan</script>
	<link href="images/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="images/favicon.ico" rel="shortcut icon" />
</head>
<body style="background: #2f2f2f url(images/background.png) repeat-x; margin:20px; padding:0px;">

<div align="center">
  <a href="<?echo $mmw[serverwebsite];?>" title="<?echo mmw_lang_home_page ." $mmw[servername]";?>"><img src="images/logo.png" border="0"></a>
</div>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="background:url(images/bg_body.png) repeat; border: 1px solid #000000;">
   <tr>
      <td width="160" valign="top" style="padding:4px;">
 <!-- Block -->

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_1.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_account_panel;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
<!-- LOGIN -->
<?if(isset($_SESSION[pass]) && isset($_SESSION[user])){
echo mmw_lang_hello . " <b>$_SESSION[user]</b>!<br> $rowbr";
if(isset($_SESSION[char_set])) {
echo " $setchar <br>
<a href='?op=user&u=char'><b>".mmw_lang_character_panel."</b></a><br>
<a href='?op=user&u=mail' id='upmess'><b>".mmw_lang_mail." [$msg_new_num/$msg_num] $msg_full</b></a><br>";}
echo "<a href='?op=user&u=acc'><b>".mmw_lang_account_panel."</b></a><br>
<a href='?op=user&u=wh'><b>".mmw_lang_ware_house."</b></a><br>";
if($_SESSION[admin] >= $mmw[gm_option_open]) {
echo "<a href='?op=user&u=gm'><b>".mmw_lang_gm_options."</b></a><br>";}
echo "$rowbr
<form action='' method='post' name='logout_account'>
<input name='logoutaccount' type='hidden' value='logoutaccount'>
<input name='Logout!' type='submit' title='".mmw_lang_logout."' value='".mmw_lang_logout."'><br>
</form>";
if($msg_new_num>0){?>
<script type="text/javascript">
function flashit(id,cl){
var c = document.getElementById(id);
if (c.style.color=='red'){c.style.color = cl;}
else {c.style.color = 'red';}}
setInterval("flashit('upmess','#FFFFFF')",500)</script>
<?}
}
else {
echo "<form action='' method='post' name='login_account'>
".mmw_lang_account."<br><input name='login' type='text' title='".mmw_lang_account."' size='15' maxlength='10'>
<input name='account_login' type='hidden' value='account_login'><br>
".mmw_lang_password."<br><input name='pass' type='password' title='".mmw_lang_password."' size='15' maxlength='10'>
$rowbr <input name='Submit' type='submit' value='".mmw_lang_login."' title='".mmw_lang_login."'> 
<a href='?op=lostpass'>".mmw_lang_lost_pass."</a>
</form>";
}?>
<!-- /END LOGIN -->
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_2.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_menu;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
<?// Menu
for($i=0; $i < count($menu); ++$i) {
//Switch Castle Siege
 if($mmw[castle_siege]=='yes' && $menu[$i][0] == mmw_lang_castle_siege) {
   echo '<img src="images/right.png"> <a href="'.$menu[$i][1].'">'.$menu[$i][0]."</a> <br/>\n";
 }
 elseif($menu[$i][0] != mmw_lang_castle_siege) {
   echo '<img src="images/right.png"> <a href="'.$menu[$i][1].'">'.$menu[$i][0]."</a> <br/>\n";
 }
}
?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_3.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_statistic;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
		<script type="text/javascript">
		function throbFade() {
		  fade(2, Math.floor(throbStep / 2), (throbStep % 2) ? false : true);
		  setTimeout("throbFade();", (throbStep % 2) ? 100 : 4000);
		  if (++throbStep > fader[2].message.length * 2 - 1) throbStep = 0;
		}
		fader[2] = new fadeObj(2, 'statistics', 'CCCCCC', '000000', 30, 30, false); <?statisitcs();?> 
		var throbStep = 0;
		setTimeout("throbFade();", 1000);
		</script>
		<div id="statistics"></div>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_4.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_server_time;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
		<?include('includes/times.php');?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_5.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_last_in_forum;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
		<?echo $last_in_forum;?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_6.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_who_is_on_web;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
		<?echo $who_online;?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_7.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_voting;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
		<?echo $voting;?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td height="26" style="background:url(images/block.png);"><img src="images/anime_8.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_ads_banners;?></td>
	   </tr>
	   <tr>
	      <td colspan="2" valign="top" class="block_bg">
		<?include('ads.txt');?>
	      </td>
	   </tr>
	</table>

 <!-- /Block -->
      </td>
      <td valign="top" style="padding-right:4px; padding-top:4px; padding-bottom:4px;">
 <!-- Body -->

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr>
	      <td width="28" height="26" style="background:url(images/block.png);" align="center"><img src="images/mu.png" border="0" height="26"></td>
	      <td style="background:url(images/block.png); padding-left:4px;"> <a href="<?echo $mmw[serverwebsite];?>"><?echo mmw_lang_home_page;?></a> &gt; <a href="?op=info"><?echo $mmw[servername];?></a> <?curent_module();?> </td>
	      <td height="26" style="background:url(images/block.png); padding-right:4px;" align="right"><?echo mmw_lang_language;?>: <?language();?></td>
	   </tr>
	   <tr>
	      <td colspan="3" valign="top" class="block_bg">
<?
if(isset($_GET[news])) {
	include("modules/news_full.php");
}
elseif(isset($_GET[forum])) {
	include("modules/forum_full.php");
}
elseif(isset($_GET[op])) {
	$op = clean_var(str_replace("..","",$_GET[op]));
	if(is_file("modules/".$op.".php")){include("modules/$op.php");}
	else {echo "$die_start Death Hacke! :@ Now I have your IP!<br>by Vaflan ;) $die_end";}
}
else {
	include("modules/news.php");
}
?>
	      </td>
	   </tr>
	</table>

<?if($mmw[mp3_player]=='yes'){include('media/player.php');}?>

 <!-- /Body -->
      </td>
   </tr>
   <tr>
      <td colspan="2" height="30" align="right" valign="bottom" style="background:url(images/footer.png); padding-right:2px;">
 <!-- Footer -->
<?
$timeEnd=gettimeofday();
$timeEnd_uS=$timeEnd["usec"];
$timeEnd_S=$timeEnd["sec"];
$ExecTime_S=($timeEnd_S+($timeEnd_uS/1000000))-($timeStart_S+($timeStart_uS/1000000));
?>
			MyMuWeb 0.4. Design and PHP+SQL by Vaflan. Generation Time: <?echo substr($ExecTime_S,0,5);?>s.
 <!-- /Footer -->
      </td>
   </tr>
</table>

</body>
</html>
<?
mssql_close($connect_mssql);
ob_end_flush();
?>