<?PHP
// This is ChatBox by Vaflan
// For MyMuWeb Engine

session_start();
header("Cache-control: private");
header("Cache-control: max-age=3600");
@date_default_timezone_set('Europe/Helsinki');
include("config.php");
include("includes/banned.php");
include("includes/sql_check.php");
include("includes/xss_check.php");
include("includes/mmw-func.php");
include("includes/engine.php");
mmw("includes/security.mmw");
// Drop
if(isset($_GET[delete])) {
 $id = preg_replace("/[^0-9]/",'',$_GET[delete]);
 if($mmw[status_rules][$_SESSION[mmw_status]][chat_delete] == 1) {
    mssql_query("DELETE FROM MMW_chatbox WHERE f_id='$id'");
 }
}
?>
<html>
<head>
	<title>ChatBox - <?echo $mmw[webtitle];?></title>
	<meta http-equiv="refresh" content="<?echo $mmw[chat_autoreload];?>">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<script type="text/javascript" src="scripts/functions.js">//script_by_vaflan</script>
	<script type="text/javascript" src="scripts/jquery.js">//script_by_vaflan</script>
	<link href="<?echo $mmw[theme_dir];?>/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="<?echo $mmw[theme_dir];?>/favicon.ico" rel="shortcut icon">
	<style>body {background: transparent none;}</style>
</head>
<table width="100%" height="380" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td valign="top">
   <div style="width: 100%; height: 380px; overflow:auto; padding: 2px; border-right: 1px solid #<?echo $media_color;?>;">
<?
$result = mssql_query("SELECT TOP $mmw[chat_max_post] * FROM MMW_chatbox order by f_id DESC");
$num = mssql_num_rows($result);
if($num < 1) {echo mmw_lang_no_message;}
else {
 for($i=0; $i<$num; $i++) {
  $row = mssql_fetch_assoc($result);
  $time = date("H:i:s", $row[f_date]);
  $day = date("d.m.Y", $row[f_date]);

  if(date("d.m.Y") == $day) {$day = mmw_lang_today;}
  if(date("d.m.Y",time()-86400) == $day) {$day = mmw_lang_yesterday;}
  $message = smile($row[f_message]);

  $character_result = mssql_query("Select name,CtlCode From Character WHERE name='$row[f_char]'");
  $character_row = mssql_fetch_row($character_result);

  $option = '';
  if($mmw[status_rules][$_SESSION[mmw_status]][chat_delete] == 1)
   {$option .= " <a href=\"?delete=$row[f_id]\" title=\"Delete\" onclick=\"return confirmLink(this,'".mmw_lang_request_delete."');\"><img src='images/delete.png' border='0' align='center'></a> ";}

  echo "<div style='border-bottom: 1px dashed #$media_color; padding: 2px;'>$option<span title='$day'>[$time]</span> <a href=\"javascript://\" class=\"level$character_row[1]\" onclick=\"var msg=parent.document.getElementById('message');if(msg.value=='".mmw_lang_message."')msg.value='';msg.value=msg.value+' $row[f_char] ';\">$row[f_char]</a>: $message</div>";
 }
}
?>
   </div>
  </td>
  <td valign="top" width="130" align="right">
   <div style="width: 100%; height: 380px; overflow:auto; padding: 2px;">
<?
$result = mssql_query("SELECT online_char FROM MMW_online WHERE online_date>'$timeout' AND online_char!=''");
$num = mssql_num_rows($result);
echo '<b>' . mmw_lang_who_is_on_web . '</b><br>';
if($num < 1) {echo mmw_lang_there_is_nobody;}
else {
 for($i=0; $i<$num; $i++) {
  $acc_online = mssql_fetch_row($result);
  $character_result = mssql_query("Select name,CtlCode,clevel,reset From Character WHERE name='$acc_online[0]'");
  $character_row = mssql_fetch_row($character_result);

  $title = "";
  echo "<a href='javascript://' onclick='parent.window.location=\"index.php?op=character&character=$character_row[0]\";' class='level$character_row[1]' title='$title'>$character_row[0] [$character_row[3]/$character_row[2]]</a><br>";
 }
}
?>
   </div>
  </td>
 </tr>
</table>
</html>