<?PHP
$id_forum = clean_var(stripslashes($_GET['forum']));

if($id_forum == "add" && isset($_SESSION['user']) && isset($_SESSION['char_set'])) {
if(isset($_POST['subject'])) {require("includes/character.class.php"); option::forum_send($_POST['subject'],$_POST['text']); echo $rowbr;}
?>

<form method="POST" name="forum" action="" style="margin:0px">
  <table border="0" width="400" cellspacing="0" cellpadding="0" class="sort-table" align="center">
    <tr>
	<td align="right"><?echo mmw_lang_topic_title;?>:</td>
	<td><input type='text' size='35' name='subject' maxlength='32' value='<?echo $_POST['subject'];?>'></td>
    </tr>
    <tr>
	<td align="right"><?echo mmw_lang_topic_text;?>:</td>
	<td><textarea rows="8" cols="40" name="text"><?echo $_POST['text'];?></textarea></td>
    </tr>
    <tr>
	<td align="right"><?echo mmw_lang_new_topic;?>:</td>
	<td><input type="submit" value="<?echo mmw_lang_add_topic;?>"> &nbsp; <input type="reset" value="<?echo mmw_lang_renew;?>"></td>
    </tr>
    <tr>
	<td colspan="2">
<?echo mmw_lang_bb_code;?>:<br>
[br] - [hr] - <b>[b][/b]</b> - <i>[i][/i]</i> - <u>[u][/u]</u> - <s>[s][/s]</s> - <span style='text-decoration: overline'>[o][/o]</span> - <sup>[sup][/sup]</sup> - <sub>[sub][/sub]</sub> - 
[c]<b>.::.</b>[/c] - [l]<b>::..</b>[/l] - [r]<b>..::</b>[/r] - [color=#][/color] - [size=#][/size] - <a href="#">[url=#][/url]</a> - [img]#[/img]
	</td>
    </tr>
  </table>
</form>
<?}
elseif(isset($id_forum) && $id_forum != "add") {
$get_forum = mssql_query("SELECT f_id,f_char,f_title,f_text,f_date,f_lostchar,f_status FROM MMW_forum WHERE f_id='$id_forum'");

  if(mssql_num_rows($get_forum) == 0) {echo 'No Topic';}
  else {
	$row = mssql_fetch_row($get_forum);
	$now_date = time();

	$result_char = mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$row[1]'");
	$row_char = mssql_fetch_row($result_char);
	$result_acc = mssql_query("SELECT country,gender,avatar FROM memb_info WHERE memb___id='$row_char[0]'");
	$row_acc = mssql_fetch_row($result_acc);

	if($row_acc[2] != "" && $row_acc[2] != " ") {$avatar_c_e="<img src='$row_acc[2]' width='110' alt='$row[1]' border='0'>";}
	else {$avatar_c_e="<img src='images/no_avatar.jpg' width='110' alt='No Аватор' border='0'>";}

	if($_SESSION['mmw_status'] >= $mmw[forum_can_delete] || $_SESSION['char_set'] == $row[1])
	{$delete = "<form action='?op=forum' method='post' name='delete_$row[0]'><input name='f_id_delete' type='hidden' value='$row[0]'><a href='javascript://' title='".mmw_lang_delete."'><img src='images/delete.png' border='0' onclick='delete_$row[0].submit()'></a></form>";}
	else {$delete = '';}
	if($_SESSION['mmw_status'] >= $mmw[forum_can_status] && $row[6]==0)
	{$close = "<form action='?op=forum' method='post' name='close_$row[0]'><input name='f_id_close' type='hidden' value='$row[0]'><a href='javascript://' title='".mmw_lang_close."'><img src='images/close.png' border='0' onclick='close_$row[0].submit()'></a></form>";}
	elseif($_SESSION['mmw_status'] >= $mmw[forum_can_status] && $row[6]==1)
	{$close = "<form action='?op=forum' method='post' name='open_$row[0]'><input name='f_id_open' type='hidden' value='$row[0]'><a href='javascript://' title='".mmw_lang_open."'><img src='images/open.png' border='0' onclick='open_$row[0].submit()'></a></form>";}
	else {$close = '';}

	if($row[6]==1) {$status = 'closed';}
	elseif($now_date - 86400 < $row[4] && $row[5]=='') {$status = 'hot';}
	elseif($now_date < $row[4] + 259200 && $row[5]=='') {$status = 'hot_no';}
	elseif($now_date - 259200 > $row[4]) {$status = 'old';}
	else {$status = 'normal';}

      echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="aBlock">
	<tr><td style="padding:2px;" width="110" valign="top" align="center">
	<a href="?op=character&character='.$row[1].'">'.$avatar_c_e.'</a><br/>
	'.mmw_lang_char.': <a href="?op=character&character='.$row[1].'" class="level'.$row_char[1].'"><b>'.$row[1].'</b></a></td>
	<td style="padding:4px;" valign="top"><img src="images/f_'.$status.'.gif" align="top"> <big><b>'.$row[2].'</b></big> '.$delete.' '.$close.' <div class="sizedforum">'.bbcode($row[3]).'</div></td></tr>
	</table>
      ';

	$c_id_blog = "2";
	$c_id_code = $id_forum;
	if($row[6]==1) {$c_add_close = "yes";}
	include("includes/comment.php");
  }

  $result = mssql_query("SELECT TOP 1 c_char,c_date FROM MMW_comment WHERE c_id_blog='$c_id_blog' AND c_id_code='$c_id_code' ORDER BY c_date DESC");
  if(mssql_num_rows($result) != 0) {
    $row = mssql_fetch_row($result);
    mssql_query("Update MMW_forum set [f_date]='$row[1]',[f_lostchar]='$row[0]' where f_id='$c_id_code'");
  }
}
elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
echo "$die_start Sorry, you can't add comment, need Character! $die_end";
}
else {
echo "$die_start Error! by Vaflan ;) $die_end";
}
?>