<?php
/**
 * Chat Module by Vaflan
 * @var array $mmw
 * @var string $die_start
 * @var string $die_end
 */

if (!empty($_SESSION['character']) && $_POST['send'] === 'send') {
	$date = time();
	$message = bugsend(stripslashes($_POST['message']));
	$timeout = $_SESSION['chat_date'] + $mmw['chat_timeout'];

	if ($timeout > $date) {
		echo '<script>alert(\'' . mmw_lang_antiflood . ' ' . ($timeout - $date) . ' sec.\');</script>';
	} elseif ($message !== $_SESSION['chat_message']) {
		mssql_query("INSERT INTO dbo.MMW_chatbox (f_char,f_message,f_date) VALUES ('{$_SESSION['character']}','{$message}','{$date}')");
		$_SESSION['chat_message'] = $message;
		$_SESSION['chat_date'] = $date;
	} else {
		jump('?op=chat');
	}
}
?>
<script>
	function check_chat() {
		if (document.chat.message.value.trim() === '' || document.chat.message.value === '<?php echo mmw_lang_message;?>') {
			alert('<?php echo mmw_lang_empty_message;?>');
			return false;
		}
		return true;
	}
	function smile(icon) {
		var text = document.chat.message;
		if (text.value === '<?php echo mmw_lang_message;?>') {
			text.value = '';
		}
		text.value = text.value + icon;
	}
</script>

<div style="padding:2px;">
	<iframe src="chatbox.php" id="chatbox" style="width:100%;height:400px;border:0" hspace="0" vspace="0" allowtransparency="true"></iframe>
</div>

<div style="text-align:center">
	<?php if (!empty($_SESSION['character'])) { ?>
		<form action="" method="post" name="chat">
			<input type="button" style="width:60px;height:18px;" value="<?php echo mmw_lang_smiles; ?>"
				   onclick="expandit('smilebox');">
			<input type="text" id="message" name="message" style="width:200px;height:16px;"
				   value="<?php echo mmw_lang_message; ?>"
				   onclick="if(this.value==='<?php echo mmw_lang_message; ?>')this.value='';">
			<input type="submit" style="width:100px;height:18px;font-weight:bold;"
				   value="<?php echo mmw_lang_send; ?>" onclick="return check_chat()">
			<input type="reset" style="width:100px;height:18px;" value="<?php echo mmw_lang_renew; ?>"
				   onclick="document.getElementById('chatbox').src='chatbox.php?r=refrash';">
			<input type="hidden" name="send" value="send">
		</form><br>
		<div style="position:absolute;padding:4px;display:none;z-index:1;" id="smilebox">
			<table cellpadding="3" id="tooltip">
				<tr>
					<td>
						<a href="javascript:smile(' >( ');"><img src="images/smile/angry.gif" title="angry"></a>
					</td>
					<td>
						<a href="javascript:smile(' :D ');"><img src="images/smile/biggrin.gif" title="biggrin"></a>
					</td>
					<td>
						<a href="javascript:smile(' B) ');"><img src="images/smile/cool.gif" title="cool"></a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="javascript:smile(' ;( ');"><img src="images/smile/cry.gif" title="cry"></a>
					</td>
					<td>
						<a href="javascript:smile(' <_< ');"><img src="images/smile/dry.gif" title="dry"></a>
					</td>
					<td>
						<a href="javascript:smile(' ^_^ ');"><img src="images/smile/happy.gif" title="happy"></a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="javascript:smile(' :( ');"><img src="images/smile/sad.gif" title="sad"></a>
					</td>
					<td>
						<a href="javascript:smile(' :) ');"><img src="images/smile/smile.gif" title="smile"></a>
					</td>
					<td>
						<a href="javascript:smile(' :o ');"><img src="images/smile/surprised.gif" title="surprised"></a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="javascript:smile(' :p ');"><img src="images/smile/tongue.gif" title="tongue"></a>
					</td>
					<td>
						<a href="javascript:smile(' %) ');"><img src="images/smile/wacko.gif" title="wacko"></a>
					</td>
					<td>
						<a href="javascript:smile(' ;) ');"><img src="images/smile/wink.gif" title="wink"></a>
					</td>
				</tr>
			</table>
		</div>
	<?php
	} elseif (isset($_SESSION['user'])) {
		echo $die_start . mmw_lang_cant_add_no_char . $die_end;
	} else {
		echo '<div style="text-align:center">' . mmw_lang_guest_must_be_logged_on . '<br />[ <a href="?op=register">' . mmw_lang_register . '</a> | <a href="?op=login">' . mmw_lang_login . '</a> ]</div>';
	} ?>
</div>