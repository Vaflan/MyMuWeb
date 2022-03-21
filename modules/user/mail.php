<?if($_GET[op]!='user') {echo "$die_start Access Denied! $die_end";}

if(isset($_POST["delete_msg_inbox"])) {require("includes/character.class.php");option::delete_msg($char_set); echo $rowbr;}
if(isset($_POST["new_message"])) {require("includes/character.class.php");option::send_msg($char_set); echo $rowbr;}

// Start View Msg
if(isset($_POST["view_msg_inbox"])) {
$view_msg_inbox = clean_var(stripslashes($_POST["view_msg_inbox"]));
$view_msg_sql = mssql_query("SELECT MemoIndex,FriendName,Subject,wDate,memo,bRead FROM T_FriendMail WHERE GUID='$char_guid' and MemoIndex='$view_msg_inbox'"); 
$view_msg_row = mssql_fetch_row($view_msg_sql);
 if($view_msg_row[1]!='Guard') {
$view_msg_re ="
<form action='?op=user&u=mail&to=$view_msg_row[1]' method='post' name='view_msg_re'>
<input name='Reply' type='submit' value='".mmw_lang_reply."'>
<input name='send_msg_subject' type='hidden' value='".win_to_utf($view_msg_row[2])."'>
</form>";
 }

//test
$query = "declare @vault varbinary(13); 
		set @vault=(SELECT Photo FROM T_FriendMail where GUID='$char_guid' and MemoIndex='$view_msg_inbox'); print @vault;";
//$result = mssql_query($query);
//$vault = substr(mssql_get_last_message(),0);
//echo 'Photo: ' . $vault;

echo "
  <table width='300' class='sort-table' border='0' cellspacing='0' cellpadding='0' align='center'>
    <tr>
      <td align='right' width='30'>".mmw_lang_msg_from.":</td>
      <td><a href='?op=character&character=$view_msg_row[1]'>$view_msg_row[1]</a> $view_msg_re</td>
    </tr>
    <tr>
      <td align='right'>".mmw_lang_title.":</td>
      <td>".win_to_utf($view_msg_row[2])."</td>
    </tr>
    <tr>
      <td align='right'>".mmw_lang_text.":</td>
      <td>".win_to_utf($view_msg_row[4])."</td>
    </tr>
    <tr>
      <td align='right'>".mmw_lang_date.":</td>
      <td>".time_format($view_msg_row[3],"d M Y, H:i")."</td>
    </tr>
  </table>";

	if($view_msg_row[5]==0){
	mssql_query("UPDATE T_FriendMail SET [bRead]='1' WHERE GUID='$char_guid' and MemoIndex='$view_msg_inbox'");
	}
echo $rowbr;
}
// End View Msg


// Start Send Msg
if(isset($_GET['to']) && $_GET['to']!='') {
$send_to = clean_var(stripslashes($_GET['to']));
if(isset($_POST[subject])) {$send_msg_subject = $_POST[subject];}
elseif(isset($_POST[send_msg_subject])) {$send_msg_subject = "RE: ".$_POST[send_msg_subject];}
?>
<form action="" method="post" name="new_request">
  <table width="300" class="sort-table" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" width="30"><?echo mmw_lang_msg_to;?>:</td>
      <td><?echo $send_to;?></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_title;?>:</td>
      <td><input name='subject' type='text' size='30' maxlength='30' value='<?echo $send_msg_subject;?>'></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_text;?>:</td>
      <td><textarea name="msg" cols="40" rows="5" onFocus="CheckLeng(this,<?echo $mmw[max_length_private_message];?>)" onBlur="CheckLeng(this,<?echo $mmw[max_length_private_message];?>)" onChange="CheckLeng(this,<?echo $mmw[max_length_private_message];?>)" onKeyDown="CheckLeng(this,<?echo $mmw[max_length_private_message];?>)" onKeyUp="CheckLeng(this,<?echo $mmw[max_length_private_message];?>)"><?echo $_POST[msg];?></textarea></td>
    </tr>
    <tr>
      <td align="right"><?echo mmw_lang_message;?>:</td>
      <td><input type='submit' name='Submit' value='<?echo mmw_lang_send_message;?>'> <input name='new_message' type='hidden' value='<?echo $send_to;?>'> <input type='reset' name='Reset' value='<?echo mmw_lang_renew;?>'></td>
    </tr>
  </table>
</form>
<?
echo $rowbr;
}
// End Send Msg


// List Message
$inbox_msg = mssql_query("SELECT MemoIndex,FriendName,Subject,wDate,bRead,photo FROM T_FriendMail WHERE GUID='$char_guid' ORDER BY MemoIndex DESC"); 
$inbox_msg_num = mssql_num_rows($inbox_msg);

echo '
<table class="sort-table" height="0" border="0" cellpadding="4" cellspacing="0" align="center">                
<thead><tr>
<td width="50">'.mmw_lang_msg_from.'</td>
<td>'.mmw_lang_title.'</td>
<td width=112>'.mmw_lang_date.'</td>
<td width=30 aling=center>'.mmw_lang_view.'</td>
<td width=40 aling=center>'.mmw_lang_delete.'</td>
<td width=20 aling=center>'.mmw_lang_status.'</td>
</tr></thead>
';

if($inbox_msg_num > 0){
for($i=0;$i < $inbox_msg_num;++$i) {
$select_msg = mssql_fetch_row($inbox_msg);

$msg_table_view ="
<form action='' method='post' name='view_msg'>
<input name='View' type='submit' value='".mmw_lang_view."'>
<input name='view_msg_inbox' type='hidden' value='$select_msg[0]'>
</form>";

$msg_table_delete ="
<form action='' method='post' name='delete_msg_inbox'>
<input name='Delete' type='submit' value='".mmw_lang_delete."'>
<input name='delete_msg_inbox' type='hidden' value='$select_msg[0]'>
</form>";

if($select_msg[4]=='0') {$img_msg ='<img src=images/msg_unread.gif>';}
if($select_msg[4]=='1') {$img_msg ='<img src=images/msg_read.gif>';}

echo "<tbody><tr>
<td><a href='?op=character&character=$select_msg[1]'>$select_msg[1]</a></td>
<td>".win_to_utf($select_msg[2])."</td>
<td>".time_format($select_msg[3],"d M Y, H:i")."</td>
<td align=center>$msg_table_view</td>
<td align=center>$msg_table_delete</td>
<td align=center>$img_msg</td>
</tr></tbody>";
 }
}

else {echo '<tbody><tr><td align="center" colspan="6">'.mmw_lang_no_message.'</td></tr></tbody>';}
?>
</table>