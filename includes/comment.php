<?php
/**
 * Comment for MyMuWeb by Vaflan
 * @var array $mmw
 * @var string $rowbr
 * @var string $die_start
 * @var string $die_end
 * @var string $okey_start
 * @var string $okey_end
 * @var int $c_id_blog
 * @var string $c_id_code
 */

if (isset($_POST['c_message'])) {
	echo $rowbr;

	$result = mssql_query("SELECT TOP 1 c_date FROM dbo.MMW_comment WHERE c_char='{$_SESSION['character']}' ORDER BY c_date DESC");
	$row = mssql_fetch_row($result);
	$date = time();

	if (isset($_SESSION['last_comment']) && $_SESSION['last_comment'] === $_POST['c_message']) {
		// Do nothing
	} elseif (empty($_POST['c_message'])) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif (empty($_SESSION['character'])) {
		echo $die_start . mmw_lang_cant_add_no_char . $die_end;
	} elseif (($timeout = $row[0] + $mmw['comment_time_out']) > $date) {
		$needTime = $timeout - $date;
		echo $die_start . mmw_lang_cant_sent_comment_need_wait . " $needTime sec. $die_end";
	} else {
		$_SESSION['last_comment'] = $_POST['c_message'];
		$bug_send = bugsend(stripslashes($_POST['c_message']));
		mssql_query("INSERT INTO dbo.MMW_comment(c_id_blog,c_id_code,c_char,c_text,c_date) VALUES ('{$c_id_blog}','{$c_id_code}','{$_SESSION['character']}','{$bug_send}','{$date}')");
		echo $okey_start . mmw_lang_comment_sent . $okey_end;
	}
}

if (isset($_POST['c_id_delete'])) {
	echo $rowbr;

	$c_id = intval($_POST['c_id_delete']);
	if (empty($c_id)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} else {
		$result = mssql_query("SELECT c_char FROM dbo.MMW_comment WHERE c_id='{$c_id}'");
		$row = mssql_fetch_row($result);

		if (empty($row)) {
			echo $die_start . 'Error: Comment not found!' . $die_end;
		} elseif ($row[0] === $_SESSION['character'] || $mmw['status_rules'][$_SESSION['mmw_status']]['comment_delete'] == 1) {
			mssql_query("DELETE from dbo.MMW_comment WHERE c_id='{$c_id}'");
			echo $okey_start . mmw_lang_comment_deleted . $okey_end;
		} else {
			echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
		}
	}
}


$result = mssql_query("SELECT
	mc.c_id,
	mc.c_char,
	mc.c_text,
	mc.c_date,
	c.AccountID,
	c.CtlCode,
	mi.country,
	mi.gender,
	mi.avatar,
	mi.hide_profile,
	cc.total_comments
FROM dbo.MMW_comment AS mc
	LEFT JOIN dbo.Character AS c ON c.Name COLLATE DATABASE_DEFAULT = mc.c_char COLLATE DATABASE_DEFAULT
	LEFT JOIN dbo.MEMB_INFO AS mi ON mi.memb___id COLLATE DATABASE_DEFAULT = c.AccountID COLLATE DATABASE_DEFAULT
	LEFT JOIN (SELECT c_char, count(c_char) AS total_comments FROM dbo.MMW_comment GROUP BY c_char) AS cc ON cc.c_char = mc.c_char
WHERE c_id_blog = '{$c_id_blog}'
  AND c_id_code = '{$c_id_code}'
ORDER BY c_date");
$quantityComment = mssql_num_rows($result);

$language = array(
	'total_comment' => mmw_lang_total_comment,
	'add_comment' => mmw_lang_add_comment,
	'delete' => mmw_lang_delete,
	'country' => mmw_lang_country,
	'gender' => mmw_lang_gender,
	'comments' => mmw_lang_comments,
	'date' => mmw_lang_date,
);

echo <<<HTML
	<div style="line-height:25px;">
		<div style="float:right">[ <a href="#add_comment">{$language['add_comment']}</a> ]</div>
		{$language['total_comment']}: <b>{$quantityComment}</b>
	</div>
HTML;

$num = 1;
while ($row = mssql_fetch_assoc($result)) {
	if ($num === $quantityComment) {
		echo '<a name="last_comment"></a>';
	}

	$time_c = date('H:i:s', $row['c_date']);
	$day_c = date('d.m.Y', $row['c_date']);
	$row['c_text'] = bbcode(smile($row['c_text']));
	$row['country'] = country($row['country']);
	$row['gender'] = gender($row['gender']);

	$avatar = empty($row['avatar'])
		? '<img src="' . default_img('no_avatar.jpg') . '" width="110" alt="No avatar">'
		: '<img src="' . $row['avatar'] . '" width="110" alt="' . $row['c_char'] . '">';
	if (empty($row['hide_profile'])) {
		$avatar = '<a href="?op=profile&profile=' . $row['AccountID'] . '">' . $avatar . '</a>';
	}

	$edit = '';
	if ($_SESSION['character'] === $row['c_char']
		|| $mmw['status_rules'][$_SESSION['mmw_status']]['comment_delete'] == 1
	) {
		$imgButton = default_img('delete.png');
		$edit = <<<HTML
<form action="" method="post" name="delete{$num}">
	<input type="hidden" name="c_id_delete" value="{$row['c_id']}">
	<a href="javascript:document.delete{$num}.submit()" title="{$language['delete']}">
		<img src="{$imgButton}" alt="button">
	</a>
</form>
HTML;
	}

	echo <<<HTML
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="aBlock">
		<tr>
		<td style="padding:2px;" width="110" valign="top" align="center">{$avatar}</td>
		<td style="padding:4px;" valign="top"><div class="sizedcomment">{$row['c_text']}</div></td>
		<td style="padding:2px;" align="center" width="114" valign="top">
			<div class="aRight">№{$num}</div>
			<a class="level{$row['CtlCode']}" href="?op=character&character={$row['c_char']}">{$row['c_char']}</a><br>
			{$language['country']}: {$row['country']}<br>
			{$language['gender']}: {$row['gender']}<br>
			{$language['comments']}: {$row['total_comments']}<br>
			<span title="{$time_c}"><i>{$language['date']}: {$day_c}</i></span><br>
			{$edit}
		</td>
		</tr>
	</table>
	<br />
HTML;

	$num++;
}


if (empty($_SESSION['user'])) {
	echo '<div style="text-align:center">' . mmw_lang_guest_must_be_logged_on . '<br />[ <a href="?op=register">' . mmw_lang_register . '</a> | <a href="?op=login">' . mmw_lang_login . '</a> ]</div>';
} elseif (!empty($c_add_close)) {
	echo $die_start . mmw_lang_comment_close . $die_end;
} elseif (empty($_SESSION['character'])) {
	echo $die_start . mmw_lang_cant_add_no_char . $die_end;
} else {
	?>
	<form action="" method="post" name="add_comment" id="add_comment">
		<div class="aBlock">
			<div style="float:right;width:86px;padding:2px;">
				<script>
					function smile(icon) {
						document.add_comment.c_message.value += icon;
					}
				</script>
				<table cellpadding="3" class="smiles" style="border:0;float:right;">
					<tr>
						<?php $index = 0; foreach(emojiList(true) as $key => $img) : ?>
						<td>
							<a href="javascript:smile('<?php echo $key; ?>');"><?php echo $img; ?></a>
						</td>
						<?php if($index % 3 === 2) : ?></tr><tr><?php endif; ?>
						<?php $index++; endforeach; ?>
					</tr>
				</table>
			</div>
			<div style="margin-right:94px;padding:2px;">
				<textarea style="height:110px;width:100%;" rows="8" name="c_message" cols="30"></textarea>
			</div>
			<div style="padding:4px;text-align:center">
				<input type="submit" value="<?php echo mmw_lang_add_comment; ?>">
			</div>
		</div>
	</form>
	<?php
}