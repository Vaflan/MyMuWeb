<?php
/**
 * @var array $mmw
 * @var string $die_start
 * @var string $die_end
 * @var string $okey_start
 * @var string $okey_end
 * @var string $rowbr
 */

$characterGUID = current(mssql_fetch_row(mssql_query("SELECT GUID FROM dbo.T_FriendMain WHERE Name='{$_SESSION['character']}'")));

if (isset($_POST['delete_msg_inbox'])) {
	$messageId = intval($_POST['delete_msg_inbox']);

	if (mssql_query("DELETE FROM dbo.T_FriendMail WHERE GUID='{$characterGUID}' AND MemoIndex='{$messageId}'")) {
		mssql_query("UPDATE dbo.T_FriendMain SET
			[MemoTotal]=(SELECT COUNT(*) FROM dbo.T_FriendMail WHERE GUID='{$characterGUID}')
				WHERE GUID='{$characterGUID}'
		");
		echo $okey_start . mmw_lang_message_deleted . $okey_end;
	} else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
	echo $rowbr;
}

if (isset($_POST['new_message'])) {
	$toCharacter = stripslashes($_POST['new_message']);
	$subject = utf_to_win(stripslashes($_POST['subject']));
	$context = utf_to_win(stripslashes($_POST['msg']));

	$toCharacterResult = mssql_query("SELECT GUID, MemoCount FROM dbo.T_FriendMain WHERE Name='{$toCharacter}'");
	$toCharacterRow = mssql_fetch_row($toCharacterResult);
	$toGUID = intval($toCharacterRow[0]);
	$memoIndex = $toCharacterRow[1] + 1;

	if (empty($toCharacter) || empty($subject)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif (strlen($subject) >= 50) {
		echo $die_start . mmw_lang_subject_max_length . $die_end;
	} elseif (empty($toGUID)) {
		echo $die_start . mmw_lang_character_does_not_exist . $die_end;
	} elseif ($toCharacterResult) {
		$date = date('Ymd\TH:i:s');
		$context = '0x' . bin2hex($context);

		$characterClass = current(mssql_fetch_row(mssql_query("SELECT Class FROM dbo.Character WHERE Name='{$_SESSION['character']}'")));
		$characterPhoto = char_class($characterClass, 'photo');

		$query = "INSERT INTO dbo.T_FriendMail (MemoIndex, GUID, FriendName, wDate, Subject, bRead, Memo, Photo, Dir, Act)
			VALUES ({$memoIndex},{$toGUID},'{$_SESSION['character']}','{$date}','{$subject}',0,{$context},{$characterPhoto},143,2)";
		if (mssql_query($query)) {
			mssql_query("UPDATE dbo.T_FriendMain SET
			[MemoCount]=[MemoCount]+1, [MemoTotal]=(SELECT COUNT(*) FROM dbo.T_FriendMail WHERE GUID='{$toGUID}')
				WHERE GUID='{$toGUID}'
			");
			echo $okey_start . mmw_lang_message_sent . ' ' . $toCharacter . $okey_end;
		} else {
			echo $die_start . 'ErroR Query ' . $context . $die_end;
		}
	} else {
		echo $die_start . 'It does not work in an old version!' . $die_end;
	}
	echo $rowbr;
}

// Start View Msg
if (isset($_POST['view_msg_inbox'])) {
	$messageId = intval($_POST['view_msg_inbox']);
	$view_msg_sql = mssql_query("SELECT MemoIndex,FriendName,Subject,wDate,Memo,bRead FROM dbo.T_FriendMail WHERE GUID='{$characterGUID}' AND MemoIndex='{$messageId}'");
	$view_msg_row = mssql_fetch_row($view_msg_sql);
	if (empty($view_msg_row[5])) {
		mssql_query("UPDATE dbo.T_FriendMail SET [bRead]=1 WHERE GUID='{$characterGUID}' AND MemoIndex='{$messageId}'");
	}
	?>
	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
		<tr>
			<td style="text-align:right;width:30px"><?php echo mmw_lang_msg_from; ?>:</td>
			<td>
				<a href="?op=character&character=<?php echo $view_msg_row[1]; ?>"><?php echo $view_msg_row[1]; ?></a>
				<?php if ($view_msg_row[1] !== 'Guard') : ?>
					<form action="?op=user&u=mail&to=<?php echo $view_msg_row[1]; ?>" method="post" name="view_msg_re">
						<input name="Reply" type="submit" value="<?php echo mmw_lang_reply; ?>">
						<input name="send_msg_subject" type="hidden" value="<?php echo win_to_utf($view_msg_row[2]); ?>">
					</form>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_title; ?>:</td>
			<td><?php echo win_to_utf($view_msg_row[2]); ?></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_text; ?>:</td>
			<td><?php echo win_to_utf($view_msg_row[4]); ?></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_date; ?>:</td>
			<td><?php echo time_format($view_msg_row[3], 'd M Y, H:i'); ?></td>
		</tr>
	</table>
	<?php
	echo $rowbr;
}
// End View Msg

// Start Send Msg
if (!empty($_GET['to'])) {
	$send_to = clean_var(stripslashes($_GET['to']));
	$send_msg_subject = '';
	if (isset($_POST['subject'])) {
		$send_msg_subject = $_POST['subject'];
	} elseif (isset($_POST['send_msg_subject'])) {
		$send_msg_subject = 'RE: ' . $_POST['send_msg_subject'];
	}
	?>
	<form action="" method="post">
		<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:300px">
			<tr>
				<td style="text-align:right;width:70px"><?php echo mmw_lang_msg_to; ?>:</td>
				<td><?php echo $send_to; ?></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_title; ?>:</td>
				<td>
					<input name="subject" type="text" style="width:100%" value="<?php echo $send_msg_subject; ?>">
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_text; ?>:</td>
				<td>
					<textarea name="msg" style="width:100%" rows="5"
							  onChange="CheckMsgLength(this,<?php echo $mmw['private_message']['length']; ?>)"
							  onKeyUp="CheckMsgLength(this,<?php echo $mmw['private_message']['length']; ?>)"><?php echo $_POST['msg']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo mmw_lang_message; ?>:</td>
				<td>
					<input type="submit" value="<?php echo mmw_lang_send_message; ?>">
					<input name="new_message" type="hidden" value="<?php echo $send_to; ?>">
					<input type="reset" value="<?php echo mmw_lang_renew; ?>">
				</td>
			</tr>
		</table>
	</form>
	<?php
	echo $rowbr;
}
// End Send Msg


// List Message
if ($inbox_msg = mssql_query("SELECT MemoIndex,FriendName,Subject,wDate,bRead FROM dbo.T_FriendMail WHERE GUID='{$characterGUID}' ORDER BY MemoIndex DESC")) {
	$inbox_msg_num = mssql_num_rows($inbox_msg);
} else {
	$inbox_msg_num = 0;
	echo $die_start . mmw_lang_error_mail_table . $die_end . $rowbr;
}
?>
<table class="sort-table" style="margin:0 auto;border:0;padding:4px">
	<thead>
	<tr>
		<td style="text-align:center;width:20px"><?php echo mmw_lang_status; ?></td>
		<td style="width:50px"><?php echo mmw_lang_msg_from; ?></td>
		<td><?php echo mmw_lang_title; ?></td>
		<td style="width:112px"><?php echo mmw_lang_date; ?></td>
		<td style="text-align:center;width:30px"><?php echo mmw_lang_view; ?></td>
		<td style="text-align:center;width:40px"><?php echo mmw_lang_delete; ?></td>
	</tr>
	</thead>
	<tbody>
	<?php
	if ($inbox_msg_num > 0) {
		while ($select_msg = mssql_fetch_row($inbox_msg)) {
			$messageStatus = empty($select_msg[4])
				? 'msg_unread.gif'
				: 'msg_read.gif';
			?>
			<tr>
				<td style="text-align:center">
					<img src="<?php echo default_img($messageStatus); ?>" alt="status">
				</td>
				<td><a href="?op=character&character=<?php echo $select_msg[1]; ?>"><?php echo $select_msg[1]; ?></a></td>
				<td><?php echo win_to_utf($select_msg[2]); ?></td>
				<td><?php echo time_format($select_msg[3], 'd M Y, H:i'); ?></td>
				<td style="text-align:center">
					<form action="" method="post">
						<input name="View" type="submit" value="<?php echo mmw_lang_view; ?>">
						<input name="view_msg_inbox" type="hidden" value="<?php echo $select_msg[0]; ?>">
					</form>
				</td>
				<td style="text-align:center">
					<form action="" method="post">
						<input name="Delete" type="submit" value="<?php echo mmw_lang_delete; ?>">
						<input name="delete_msg_inbox" type="hidden" value="<?php echo $select_msg[0]; ?>">
					</form>
				</td>
			</tr>
<?php
		}
	} else {
		echo '<tr><td colspan="6" style="text-align:center">' . mmw_lang_no_message . '</td></tr>';
	}
	?>
	</tbody>
</table>
