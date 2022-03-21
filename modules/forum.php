<?PHP
// Forum engine by Vaflan
if(isset($_POST['f_id_delete'])){require("includes/character.class.php"); option::forum_delete($_POST['f_id_delete']);}
if(isset($_POST['f_id_close'])){require("includes/character.class.php"); option::forum_status($_POST['f_id_close'],'1');}
if(isset($_POST['f_id_open'])){require("includes/character.class.php"); option::forum_status($_POST['f_id_open'],'0');}

if(isset($_SESSION['char_set']) && $_SESSION['char_set']!=' ' && isset($_SESSION['user'])) {$new_topic = '<a href="?forum=add">'.mmw_lang_new_topic.'</a>';}
elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {$new_topic = mmw_lang_cant_add_no_char;}
else {$new_topic = mmw_lang_guest_must_be_logged_on;}
?>
<div style="text-align:right;padding:2px;">[ <a href="?op=forum&c=new"><?echo mmw_lang_new_message;?></a> &#8226; <?echo $new_topic;?> ]</div>
<?
if(empty($_GET[c])) {
 include('includes/forum_catalog.php');
?>
<table class="sort-table" border="0" cellpadding="0" cellspacing="0" width="100%">                
 <thead><tr>
  <td width="20"></td>
  <td align="left"><small><?echo mmw_lang_forum;?></small></td>
  <td align="center" width="60"><small><?echo mmw_lang_topics;?></small></td>
  <td align="center" width="60"><small><?echo mmw_lang_answers;?></small></td>
  <td align="left" width="160"><small><?echo mmw_lang_updates;?></small></td>
 </tr></thead>
<?
 foreach($mmw[forum_catalog] as $key => $value) {
  $result = mssql_query("SELECT count(f_id),sum(f_comments) FROM MMW_forum WHERE f_catalog='$key'");
  $row = mssql_fetch_row($result);
  if(empty($row[1])) {$row[1] = 0;}

  $forum_img = 'c_nonew.gif';
  if($row[0] > 0) {
   $post_row = mssql_fetch_row( mssql_query("SELECT TOP 1 f_id,f_title,f_date,f_lastchar FROM MMW_forum WHERE f_catalog='$key' ORDER BY f_date DESC") );
   $lastchar_row = mssql_fetch_row( mssql_query("Select CtlCode From Character WHERE name='$post_row[3]'") );
   $last_forum = "<a href='?forum=$post_row[0]#last_comment' title='".mmw_lang_last_message."'>".date("D, d.m.Y, H:i", $post_row[2])."</a> <a href='?forum=$post_row[0]#last_comment' title='".mmw_lang_last_message."'><img src='".default_img('last_comment.gif')."' border='0'></a><br>";
   $last_forum .= mmw_lang_topic.": <a href='?forum=$post_row[0]'>$post_row[1]</a><br>";
   $last_forum .= mmw_lang_message_from.": <a href='?op=character&character=$post_row[3]' class='level$lastchar_row[0]'>$post_row[3]</a>";
   if($post_row[2]+$mmw[forum_of_new] > time()) {$forum_img = 'c_new.gif';}
  }
  else {
   $last_forum = mmw_lang_no_message;
  }
?>
 <tr>
  <td align="center"><img src="<?echo default_img($forum_img);?>"></td>
  <td align="left"><a href="?op=forum&c=<?echo $key;?>"><b><?echo $value[0];?></b></a><br><small><?echo $value[1];?></small></td>
  <td align="center"><?echo $row[0];?></td>
  <td align="center"><?echo $row[1];?></td>
  <td align="left"><small><?echo $last_forum;?></small></td>
 </tr>
<?}?>
</table>
<?
 $total_result = mssql_query("SELECT count(f_id),sum(f_comments) FROM MMW_forum");
 $total_row = mssql_fetch_row($total_result);
 if(empty($total_row[1])) {$total_row[1] = 0;}
 echo $rowbr . mmw_lang_total_topic .": $total_row[0] &nbsp; ".mmw_lang_total_comment.": $total_row[1]";
}
else {
 if($_GET[c] == 'new') {$sort = "f_date>'".(time()-$mmw[forum_of_new])."'";}
 else {$sort = "f_catalog='".preg_replace("/[^0-9]/",'',$_GET[c])."'";}
?>
<table class="sort-table" border="0" cellpadding="0" cellspacing="0" width="100%">                
 <thead><tr>
  <td width="20"></td>
  <td align="left"><small><?echo mmw_lang_topics;?></small></td>
  <td align="center" width="60"><small><?echo mmw_lang_answers;?></small></td>
  <td align="center" width="60"><small><?echo mmw_lang_views;?></small></td>
  <td align="center" width="70"><small><?echo mmw_lang_author_topic;?></small></td>
  <td align="left" width="160"><small><?echo mmw_lang_updates;?></small></td>
 </tr></thead>
<?
 $result = mssql_query("SELECT f_id,f_char,f_title,f_text,f_date,f_lastchar,f_status,f_comments,f_views FROM MMW_forum WHERE $sort ORDER BY f_date DESC");
 for($i=0;$i<mssql_num_rows($result);$i++) {
  $row = mssql_fetch_row($result);
  $topic_img = 'f_norm_nonew.gif';

  $character_row = mssql_fetch_row( mssql_query("Select CtlCode From Character WHERE name='$row[1]'") );
  $lastchar_row = mssql_fetch_row( mssql_query("Select CtlCode From Character WHERE name='$row[5]'") );
  $last_forum = "<a href='?forum=$row[0]#last_comment' title='".mmw_lang_last_message."'>".date("D, d.m.Y, H:i", $row[4])."</a> <a href='?forum=$row[0]#last_comment' title='".mmw_lang_last_message."'><img src='".default_img('last_comment.gif')."' border='0'></a><br>";
  $last_forum .= mmw_lang_message_from.": <a href='?op=character&character=$row[5]' class='level$lastchar_row[0]'>$row[5]</a>";

  if($row[7]>=$mmw[forum_topic_hot]) {$topic_img = 'f_hot_nonew.gif';}
  if($row[4]+$mmw[forum_of_new] > time()) {$topic_img = 'f_norm_new.gif';}
  if($row[4]+$mmw[forum_of_new] > time() && $row[7]>=$mmw[forum_topic_hot]) {$topic_img = 'f_hot_new.gif';}
  if($row[6] == 1) {$topic_img = 'f_closed_nonew.gif';}

  $option = '';
  if($mmw[status_rules][$_SESSION[mmw_status]][forum_delete]==1 || $_SESSION['char_set'] == $row[1])
   {$option.=" <form action='' method='post' name='delete_$row[0]'><input name='f_id_delete' type='hidden' value='$row[0]'><img src='".default_img('delete.png')."' border='0' onclick='delete_$row[0].submit()' title='".mmw_lang_delete."'></form> ";}
  if($mmw[status_rules][$_SESSION[mmw_status]][forum_status] == 1 && $row[6] == 1)
   {$option.=" <form action='' method='post' name='open_$row[0]'><input name='f_id_open' type='hidden' value='$row[0]'><img src='".default_img('open.png')."' border='0' onclick='open_$row[0].submit()' title='".mmw_lang_open."'></form> ";}
  if($mmw[status_rules][$_SESSION[mmw_status]][forum_status] == 1 && $row[6] == 0)
   {$option.=" <form action='' method='post' name='close_$row[0]'><input name='f_id_close' type='hidden' value='$row[0]'><img src='".default_img('close.png')."' border='0' onclick='close_$row[0].submit()' title='".mmw_lang_close."'></form> ";}
?>
 <tr>
  <td align="center"><img src="<?echo default_img($topic_img);?>"></td>
  <td align="left"><a href="?forum=<?echo $row[0];?>"><b><?echo $row[2];?></b></a> <?echo $option;?></td>
  <td align="center"><?echo $row[7];?></td>
  <td align="center"><?echo $row[8];?></td>
  <td align="center"><a href="?op=character&character=<?echo $row[1];?>" class="level<?echo $character_row[0];?>"><?echo $row[1];?></a></td>
  <td align="left"><small><?echo $last_forum;?></small></td>
 </tr>
<?}
 if($i<1) {echo "<tr><td colspan='6' align='center'><b>".mmw_lang_no_topics_in_forum."</b></td></tr>";}
?>
</table>
<?
 $total_result = mssql_query("SELECT count(f_id),sum(f_comments) FROM MMW_forum WHERE $sort");
 $total_row = mssql_fetch_row($total_result);
 if(empty($total_row[1])) {$total_row[1] = 0;}
 echo $rowbr . mmw_lang_total_topic .": $total_row[0] &nbsp; ".mmw_lang_total_comment.": $total_row[1]";
}?>