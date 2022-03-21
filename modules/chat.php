<?PHP
// Chat Module © by Vaflan

if($_POST['send']=='send' && isset($_SESSION[char_set])) {
 $date = time();
 $char = stripslashes($_SESSION[char_set]);
 $message = bugsend(stripslashes($_POST['message']));
 $timeout = $_SESSION[chat_date] + $mmw[chat_timeout];

 if($timeout > $date) {
  echo '<script language="javascript">alert(" '.mmw_lang_antiflood.' '.($timeout-$date).' sec. ");</script>';
 }
 elseif($message != $_SESSION[chat_message]) {
  mssql_query("INSERT INTO MMW_chatbox (f_char,f_message,f_date) VALUES ('$char','$message','$date')");
  $_SESSION[chat_message] = $message;
  $_SESSION[chat_date] = $date;
 }
 else {
  jump('?op=chat');
 }
}
?>
<script language="Javascript" type="text/javascript">
function check_chat() {
 if(document.chat.message.value == '' || document.chat.message.value == '<?echo mmw_lang_message;?>') {
  alert(" <?echo mmw_lang_empty_message;?> ");
  return false;
 }
 document.chat.submit();
 return true;
}
</script>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:0px solid #000000;" align="center">
 <tr>
  <td style="border:0px solid #000000; padding:2px;" width="100%">
	<iframe src="chatbox.php" id="chatbox" style="width:100%; height:400px;" frameborder="0" hspace="0" vspace="0" allowtransparency="true"></iframe>
  </td>
 </tr>
 <tr>
  <td align="center">
<?if(isset($_SESSION[char_set]) && $_SESSION[char_set]!=' ' && isset($_SESSION[user])) {?>
<form action="" method="post" name="chat">
 <input type="button" style="width:60px;height:18px;" value="<?echo mmw_lang_smiles;?>" onclick="expandit('smilebox');">
 <input type="text" id="message" name="message" style="width:200px;height:16px;" value="<?echo mmw_lang_message;?>" onclick="if(this.value=='<?echo mmw_lang_message;?>')this.value='';">
 <input type="submit" style="width:100px;height:18px;font-weight: bold;" value="<?echo mmw_lang_send;?>" onclick="return check_chat();">
 <input type="reset" style="width:100px;height:18px;" value="<?echo mmw_lang_renew;?>" onclick="document.getElementById('chatbox').src='chatbox.php?r=refrash';">
 <input type="hidden" name="send" value="send">
</form><br>
<div style="position:absolute;display:none;padding:4px;" id="smilebox">
 <script type='text/javascript'>function smile(ico) {var text = document.chat.message;if(text.value=='<?echo mmw_lang_message;?>') {text.value='';}text.value = text.value + ico;}</script>
 <table cellpadding="3" id="tooltip"><tr>
  <td align="center"><a href="JavaScript: smile(' >( ');"><img src="images/smile/angry.gif" title="angry"></a></td>
  <td align="center"><a href="JavaScript: smile(' :D ');"><img src="images/smile/biggrin.gif" title="biggrin"></a></td>
  <td align="center"><a href="JavaScript: smile(' B) ');"><img src="images/smile/cool.gif" title="cool"></a></td>
  </tr><tr>
  <td align="center"><a href="JavaScript: smile(' ;( ');"><img src="images/smile/cry.gif" title="cry"></a></td>
  <td align="center"><a href="JavaScript: smile(' <_< ');"><img src="images/smile/dry.gif" title="dry"></a></td>
  <td align="center"><a href="JavaScript: smile(' ^_^ ');"><img src="images/smile/happy.gif" title="happy"></a></td>
  </tr><tr>
  <td align="center"><a href="JavaScript: smile(' :( ');"><img src="images/smile/sad.gif" title="sad"></a></td>
  <td align="center"><a href="JavaScript: smile(' :) ');"><img src="images/smile/smile.gif" title="smile"></a></td>
  <td align="center"><a href="JavaScript: smile(' :o ');"><img src="images/smile/surprised.gif" title="surprised"></a></td>
  </tr><tr>
  <td align="center"><a href="JavaScript: smile(' :p ');"><img src="images/smile/tongue.gif" title="tongue"></a></td>
  <td align="center"><a href="JavaScript: smile(' %) ');"><img src="images/smile/wacko.gif" title="wacko"></a></td>
  <td align="center"><a href="JavaScript: smile(' ;) ');"><img src="images/smile/wink.gif" title="wink"></a></td>
  </tr>
 </table>
</div>
<?}
elseif(isset($_SESSION[pass]) && isset($_SESSION[user])) {
 echo $die_start . mmw_lang_cant_add_no_char . $die_end;
}
else {
 echo '<div align="center">'.mmw_lang_guest_must_be_logged_on.'<br />[ <a href="?op=register">'.mmw_lang_register.'</a> | <a href="?op=login">'.mmw_lang_login.'</a> ]</div>';
}?>
  </td>
 </tr>
</table>