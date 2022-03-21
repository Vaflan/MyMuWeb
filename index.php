<?PHP
session_start();
header("Cache-control: private");
include("config.php");
include("includes/sql_check.php");
include("includes/functions.php");
include("includes/formats.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?echo $mmw['webtitle'];?></title>
<script type="text/javascript" src="scripts/calc_price.js">//script_by_vaflan</script>
<script type="text/javascript" src="scripts/functions.js">//script_by_vaflan</script>
<script type="text/javascript" src="scripts/helptip.js">//script_by_vaflan</script>
<link href="images/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="images/favicon.ico">
</head>
<body style="background-image: url(images/back.jpg); margin:10px; padding:0px;">

<div align="center">
<a href="." title="Home Page <?echo $mmw[servername];?>"><img src="images/logo.jpg" width="694" height="200" border="0"></a><br/><br/>
</div>

<table width="694" border="0" align="center" cellpadding="0" cellspacing="0" style="background:url(images/back_03.jpg) repeat;">
  <tr>
    <td colspan="3"><img src="images/back_02.png" width="694" height="27"></td>
  </tr>
  <tr>
    <td width="17" style="background-image:url(images/back_04.jpg); background-repeat:repeat-y;">&nbsp;</td>
    <td width="660" valign="top">


	<table width="648" border="0" cellspacing="0" cellpadding="0">
	 <tr>
	  <td width="136" valign="top" style="padding-left:8px;padding-right:8px;">
		<!-- LEFT -->

     <!-- || -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000">
<!-- LOGIN -->
<?if(isset($_SESSION['pass']) && isset($_SESSION['user'])){?>
Hello <b><?echo $_SESSION[user];?></b>!<br>
<div class='brdiv'></div>
<?if(isset($_SESSION['char_set'])) { echo $setchar;?><br>
<a href='?op=user&u=char'><b>Character Panel</b></a><br>
<a href='?op=user&u=mail' id='upmess'><b>Mail [<?echo "$msg_new_num/$msg_num";?>]</b></a><br><?}?>
<a href='?op=user&u=acc'><b>Account Panel</b></a><br>
<a href='?op=user&u=wh'><b>Ware House</b></a><br>
<?if($_SESSION['admin'] >= $mmw[gm_option_open]) {?>
<a href='?op=user&u=gm'><b>GM Options</b></a><br><?}?>
<div class='brdiv'></div>
<form action='' method='post' name='logout_account' id='logout_account'>
<input name='logoutaccount' type='hidden' id='logoutaccount' value='logoutaccount'>
<input name='Logout!' type='submit' id='Logout!' title='Logout' value='Logout'><br>
</form>
<?if($msg_new_num>0){?>
<script type="text/javascript">
function flashit(id,cl){
var c = document.getElementById(id);
if (c.style.color=='red'){c.style.color = cl;}
else {c.style.color = 'red';}}
setInterval("flashit('upmess','#FFFFFF')",500)</script>
<?}?>
<?}else{?>
<form action='' method='post' name='login_account' id='login_account'>
Username<br><input name='login' type='text' id='login' title='Username' size='15' maxlength='10'>
<input name='account_login' type='hidden' id='account_login' value='account_login'><br>
Password<br><input name='pass' type='password' id='pass' title='Password' size='15' maxlength='10'>
<div class='brdiv'></div>
<input name='Submit' type='submit' value='Login' title='Login'> 
<a href='?op=lostpass'>Lost Pass</a>
</form>
<?}?>
<!-- /END LOGIN -->
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>
     <!-- // -->

<div class="brdiv"></div>

     <!-- || -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000">
                <table width="110" border="0" align="left" cellpadding="0" cellspacing="4">
                  <tr>
                    <td width="10"><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td width="100" class="link_menu"><a href="?op=news">Home</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=downloads">Downloads</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=info"><b>Information</b></a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=statistics">Statistics</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=castlesiege">Castle Siege</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=rankings">Rankings</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=register"><b>Register</b></a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=search">Search</a></td>
                  </tr>
                  <tr>
                    <td><img src="images/arrow.jpg" width="9" height="9"></td>
                    <td class="link_menu"><a href="?op=forum"><b>Forum</b></a></td>
                  </tr>
                </table>
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>
     <!-- // -->

<div class="brdiv"></div>

     <!-- || -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000">
		<script type="text/javascript" src="scripts/textfader.js"></script>
		<script type="text/javascript">
		function throbFade() {
		  fade(2, Math.floor(throbStep / 2), (throbStep % 2) ? false : true);
		  setTimeout("throbFade();", (throbStep % 2) ? 100 : 4000);
		  if (++throbStep > fader[2].message.length * 2 - 1) throbStep = 0;
		}
		fader[2] = new fadeObj(2, 'statistics', 'FFFFFF', 'CCCCCC', 30, 30, false); <?statisitcs();?> 
		var throbStep = 0;
		setTimeout("throbFade();", 1000);
		</script>
		<div id="statistics"></div>
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>
     <!-- // -->

<div class="brdiv"></div>

     <!-- || -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000">
		Who is on Web:<br>
		<?echo $who_online;?>
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>
     <!-- // -->

<div class="brdiv"></div>

     <!-- || -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000">
		<? include('includes/times.php');?>
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>
     <!-- // -->

<div class="brdiv"></div>

     <!-- || -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000" align="center">
		<? include('ads.txt');?>
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>
     <!-- // -->

		<!-- /LEFT -->
	  </td>
	  <td valign="top">
		<!-- BODY -->

	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15" valign="top"><img src="images/content/top_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/top_mid.jpg) repeat-x;"><img src="images/content/top_mid.jpg"></td>
            <td width="15" valign="top"><img src="images/content/top_right_corner.gif" width="15" height="15"></td>
          </tr>
          <tr>
            <td valign="top" style="background:url(images/content/left.jpg) #000000 repeat-y;">&nbsp;</td>
            <td valign="top" bgcolor="#000000">
	<!-- Center -->
                <div class="link_content"><a href=".">Home</a> &gt; <a href="?op=info"><? echo($mmw['servername']); ?></a> <?curent_module();?></div> 
<?
if(isset($_GET['news'])){
	include("modules/news_full.php");
}
elseif(isset($_GET['forum'])){
	include("modules/forum_full.php");
}
elseif(isset($_GET['op'])){
	$op = clean_var(str_replace("..","",$_GET['op']));
	if(is_file("modules/".$op.".php")){include("modules/$op.php");}
	else {echo "$die_start Death Hacke! :@ Now I have your IP!<br>by Vaflan ;) $die_end";}
}
else {
	include("modules/news.php");
}
?>
	<!-- /Center -->
            </td>
            <td valign="top" style="background:url(images/content/right.jpg) repeat-y;">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><img src="images/content/down_left_corner.gif" width="15" height="15"></td>
            <td style="background:url(images/content/down_mid.jpg) repeat-x;"><img src="images/content/down_mid.jpg"></td>
            <td valign="top"><img src="images/content/down_right_corner.gif" width="15" height="15"></td>
          </tr>
	</table>

		<!-- /BODY -->
	  </td>
	 </tr>
	</table>

    </td>
    <td width="17" style="background:url(images/back_05.jpg) repeat-y;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><img src="images/back_06.png" width="694" height="27"></td>
  </tr>
</table>
<br/>
<center>
MyMuWeb 0.2. Copyright TK3 © 2006-<?echo date('Y');?>. Design and PHP+SQL by Vaflan.<br>
</center>
</body>
</html>