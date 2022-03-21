<?PHP
// Full Forum by Vaflan
if(isset($_SESSION['char_set']) && $_SESSION['char_set']!=' ' && isset($_SESSION['user'])) {$new_topic = '<a href="?forum=add">'.mmw_lang_new_topic.'</a>';}
elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {$new_topic = mmw_lang_cant_add_no_char;}
else {$new_topic = mmw_lang_guest_must_be_logged_on;}
?>
<div style="text-align:right;padding:2px;">[ <a href="?op=forum&c=new"><?echo mmw_lang_new_message;?></a> &#8226; <?echo $new_topic;?> ]</div>
<?
$id_forum = clean_var(stripslashes($_GET['forum']));
if($id_forum == "add" && isset($_SESSION['user']) && isset($_SESSION['char_set'])) {
 if(isset($_POST['subject'])) {require("includes/character.class.php"); option::forum_send($_POST['subject'],$_POST['text'],$_POST['catalog']); echo $rowbr;}
 include('includes/forum_catalog.php');
 foreach($mmw[forum_catalog] as $key => $value) {
  if($value[2]==0 || $mmw[status_rules][$_SESSION[mmw_status]][forum_add]==1)
   {$forum_catalog .= "<option value='$key'>$value[0]</option>";}
 }
?>
<form method="POST" name="forum" action="" style="margin:0px">
  <table border="0" cellspacing="0" cellpadding="0" class="sort-table" align="center">
    <tr>
	<td align="right" width="110"><?echo mmw_lang_forum_catalog;?>:</td>
	<td><select name="catalog" size="1"><?echo $forum_catalog;?></select></td>
    </tr>
    <tr>
	<td align="right"><?echo mmw_lang_topic_name;?>:</td>
	<td><input type='text' size='35' name='subject' maxlength='32' value='<?echo $_POST['subject'];?>'></td>
    </tr>
    <tr>
	<td align="right"><?echo mmw_lang_bb_code;?>:</td>
	<td>[br] - [hr] - <b>[b][/b]</b> - <i>[i][/i]</i> - <u>[u][/u]</u> - <s>[s][/s]</s> - <span style='text-decoration: overline'>[o][/o]</span> <br> <sup>[sup][/sup]</sup> - <sub>[sub][/sub]</sub> - 
	[c]<b>.::.</b>[/c] - [l]<b>::..</b>[/l] - [r]<b>..::</b>[/r] <br> [color=#][/color] - [size=#][/size] - [url=#][/url] <br> [img]#[/img] - [video]YouTube.com #[/video]
	</td>
    </tr>
    <tr>
	<td align="right"><?echo mmw_lang_topic_text;?>:</td>
	<td><textarea rows="8" cols="40" name="text"><?echo $_POST['text'];?></textarea></td>
    </tr>
    <tr>
	<td align="center" colspan="2"><input type="submit" value="<?echo mmw_lang_add_topic;?>"> <input type="reset" value="<?echo mmw_lang_renew;?>"></td>
    </tr>
  </table>
</form>
<?}
elseif(isset($id_forum) && $id_forum != "add") {
 $get_topic = mssql_query("SELECT f_id,f_char,f_title,f_text,f_date,f_lastchar,f_status,f_created,f_views FROM MMW_forum WHERE f_id='$id_forum'");
 if(mssql_num_rows($get_topic) == 0) {echo "$die_start No Topic $die_end";}
 else {
  $row = mssql_fetch_row($get_topic);
  $now_date = time();
  $topic_img = 'f_norm_nonew.gif';

  $row_char = mssql_fetch_row( mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$row[1]'") );
  $row_acc = mssql_fetch_row( mssql_query("SELECT country,gender,avatar FROM memb_info WHERE memb___id='$row_char[0]'") );

  if(!empty($row_acc[2]) && $row_acc[2]!=' ') {$avatar_c_e="<img src='$row_acc[2]' width='110' alt='$row[1]' border='0'>";}
  else {$avatar_c_e="<img src='".default_img('no_avatar.jpg')."' width='110' alt='No Аватор' border='0'>";}

  $option = '';
  if($mmw[status_rules][$_SESSION[mmw_status]][forum_delete]==1 || $_SESSION['char_set'] == $row[1])
   {$option.=" <form action='?op=forum' method='post' name='delete_$row[0]'><input name='f_id_delete' type='hidden' value='$row[0]'><img src='".default_img('delete.png')."' border='0' onclick='delete_$row[0].submit()' title='".mmw_lang_delete."' align='bottom'></form> ";}
  if($mmw[status_rules][$_SESSION[mmw_status]][forum_status] == 1 && $row[6] == 1)
   {$option.=" <form action='?op=forum' method='post' name='open_$row[0]'><input name='f_id_open' type='hidden' value='$row[0]'><img src='".default_img('open.png')."' border='0' onclick='open_$row[0].submit()' title='".mmw_lang_open."' align='bottom'></form> ";}
  if($mmw[status_rules][$_SESSION[mmw_status]][forum_status] == 1 && $row[6] == 0)
   {$option.=" <form action='?op=forum' method='post' name='close_$row[0]'><input name='f_id_close' type='hidden' value='$row[0]'><img src='".default_img('close.png')."' border='0' onclick='close_$row[0].submit()' title='".mmw_lang_close."' align='bottom'></form> ";}

  if($row[8]>=$mmw[forum_topic_hot]) {$topic_img = 'f_hot_nonew.gif';}
  if($row[4]+$mmw[forum_of_new] > time()) {$topic_img = 'f_norm_new.gif';}
  if($row[4]+$mmw[forum_of_new] > time() && $row[8]>=$mmw[forum_topic_hot]) {$topic_img = 'f_hot_new.gif';}
  if($row[6] == 1) {$topic_img = 'f_closed_nonew.gif';}
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="aBlock">
 <tr>
  <td style="padding:2px;" width="110" valign="top" align="center"><a href="?op=character&character=<?echo $row[1];?>"><?echo $avatar_c_e;?></a><br/><?echo mmw_lang_char;?>: <a href="?op=character&character=<?echo $row[1];?>" class="level<?echo $row_char[1];?>"><b><?echo $row[1];?></b></a></td>
  <td style="padding:4px;" valign="top"><img src="<?echo default_img($topic_img);?>" align="bottom"> <big><b><?echo $row[2];?></b></big> <small><span title="<?echo mmw_lang_date;?>">(<?echo date("d.m.Y, H:i", $row[7]);?>)</span></small> <?echo $option;?><div class="sizedforum"><?echo bbcode($row[3]);?></div></td>
 </tr>
</table>
<?
  $c_id_blog = "2";
  $c_id_code = $id_forum;
  if($row[6]==1) {$c_add_close = "yes";}
  include("includes/comment.php");

  $lastcomment_result = mssql_query("SELECT TOP 1 c_char,c_date FROM MMW_comment WHERE c_id_blog='$c_id_blog' AND c_id_code='$c_id_code' ORDER BY c_date DESC");
  if(mssql_num_rows($lastcomment_result) > 0) {$lastcomment_row = mssql_fetch_row($lastcomment_result); $comment_info = "[f_date]='$lastcomment_row[1]',[f_lastchar]='$lastcomment_row[0]',";}
  else {$comment_info = "[f_date]='$row[7]',[f_lastchar]='$row[1]',";}
  if($row[8] < 1) {$new_views = 1;} else {$new_views = "f_views+1";}
  mssql_query("UPDATE MMW_forum SET $comment_info [f_views]=$new_views,[f_comments]=$comm_num WHERE f_id='$c_id_code'");
 }
}
elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
 echo "$die_start Sorry, you can't add comment, need Character! $die_end";
}
else {
 echo "$die_start Error! by Vaflan ;) $die_end";
}
?>