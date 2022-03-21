<?PHP // This is Header Theme ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?echo $mmw[webtitle];?></title>
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<script type="text/javascript" src="scripts/functions.js">//script_by_vaflan</script>
	<script type="text/javascript" src="scripts/textfader.js">//script_by_vaflan</script>
	<script type="text/javascript" src="scripts/jquery.js">//script_by_vaflan</script>
	<link href="<?echo $mmw[theme_dir];?>/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="<?echo $mmw[theme_dir];?>/favicon.ico" rel="shortcut icon">
</head>
<body style="background: #5f1100 url(<?echo $mmw[theme_img];?>/background.png) repeat-x; margin:20px; padding:0px;">

<div align="center">
  <a href="<?echo $mmw[serverwebsite];?>" title="<?echo mmw_lang_home_page ." $mmw[servername]";?>"><img src="<?echo $mmw[theme_img];?>/logo.png" border="0"></a>
</div>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="background:url(<?echo $mmw[theme_img];?>/bg_body.png) repeat; border: 1px solid #000000;">
   <tr>
      <td width="160" valign="top" style="padding:4px;">
 <!-- Block -->

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_1')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_1.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_account_panel;?></td>
	   </tr>
	   <tr id="block_1">
	      <td colspan="2" valign="top" class="block_bg">
		<?login_form();?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_2')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_2.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_menu;?></td>
	   </tr>
	   <tr id="block_2">
	      <td colspan="2" valign="top" class="block_bg">
		<?menu("<a href='$1'><img src='$mmw[theme_img]/right.png'> $2</a><br/>");?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_3')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_3.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_statistic;?></td>
	   </tr>
	   <tr id="block_3">
	      <td colspan="2" valign="top" class="block_bg">
		<script type="text/javascript">
		function throbFade() {
		  fade(2, Math.floor(throbStep / 2), (throbStep % 2) ? false : true);
		  setTimeout("throbFade();", (throbStep % 2) ? 100 : 4000);
		  if (++throbStep > fader[2].message.length * 2 - 1) throbStep = 0;
		}
		fader[2] = new fadeObj(2, 'statistics', '<?echo $back_color;?>', '<?echo $text_color;?>', 30, 30, false); <?statisitcs('blink');?> 
		var throbStep = 0;
		setTimeout("throbFade();", 1000);
		</script>
		<div id="statistics"></div>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_4')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_4.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_server_time;?></td>
	   </tr>
	   <tr id="block_4">
	      <td colspan="2" valign="top" class="block_bg">
		<?include('includes/times.php');?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_5')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_5.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_last_in_forum;?></td>
	   </tr>
	   <tr id="block_5">
	      <td colspan="2" valign="top" class="block_bg">
		<?last_in_forum($mmw[last_in_forum]);?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_6')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_6.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_who_is_on_web;?></td>
	   </tr>
	   <tr id="block_6">
	      <td colspan="2" valign="top" class="block_bg">
		<?echo $who_online;?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_7')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_7.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_voting;?></td>
	   </tr>
	   <tr id="block_7">
	      <td colspan="2" valign="top" class="block_bg">
		<?echo $voting;?>
	      </td>
	   </tr>
	</table>

      <?echo $rowbr;?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000000;">
	   <tr style="cursor:pointer" onclick="expandit('block_8')">
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);"><img src="<?echo $mmw[theme_img];?>/anime_8.gif" border="0" height="26"></td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_ads_banners;?></td>
	   </tr>
	   <tr id="block_8">
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
	   <tr style="cursor:pointer" onclick="expandit('block_body')">
	      <td width="28" height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png);" align="center"><img src="<?echo $mmw[theme_img];?>/mu.png" border="0" height="26"></td>
	      <td style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-left:4px;"> <a href="<?echo $mmw[serverwebsite];?>"><?echo mmw_lang_home_page;?></a> &gt; <a href="?op=info"><?echo $mmw[servername];?></a> <?curent_module();?> </td>
	      <td height="26" style="background:url(<?echo $mmw[theme_img];?>/block.png); padding-right:4px;" align="right"><?echo mmw_lang_language;?>: <?language($mmw[language]);?></td>
	   </tr>
	   <tr id="block_body">
	      <td colspan="3" valign="top" class="block_bg">