<?php
/**
 * Full Forum by Vaflan
 * @var array $mmw
 * @var string $okey_start
 * @var string $okey_end
 * @var string $die_start
 * @var string $die_end
 * @var string $rowbr
 */

require_once __DIR__ . '/../includes/forum_catalog.php';

function drawOptionButton($id, $type, $label, $action = '')
{
	$icon = default_img($type . '.png');
	return <<<HTML
<form action="{$action}" method="post" name="{$type}_{$id}">
	<input name="f_id_{$type}" type="hidden" value="{$id}">
	<img src="{$icon}" onclick="document.{$type}_{$id}.submit()" alt="{$type}" title="{$label}">
</form>
HTML;
}

if (isset($_SESSION['user']) && !empty($_SESSION['character'])) {
	$new_topic = '<a href="?forum=add">' . mmw_lang_new_topic . '</a>';
} elseif (isset($_SESSION['user'])) {
	$new_topic = mmw_lang_cant_add_no_char;
} else {
	$new_topic = mmw_lang_guest_must_be_logged_on;
}

$language = array(
	'new_message' => mmw_lang_new_message
);

echo <<<HTML
	<div style="text-align:right;padding:2px;">
		[ <a href="?op=forum&c=new">{$language['new_message']}</a> &#8226; {$new_topic} ]
	</div>
HTML;

$id_forum = clean_var(stripslashes($_GET['forum']));
if ($id_forum === 'add' && !empty($_SESSION['character'])) {
	if (isset($_POST['subject'])) {
		if (empty($_POST['subject']) || empty($_POST['text']) || empty($_POST['catalog'])) {
			echo $die_start . mmw_lang_left_blank . $die_end;
		} else {
			$title = bugsend(stripslashes($_POST['subject']));
			$text = bugsend(stripslashes($_POST['text']));
			$catalog = intval($_POST['catalog']);
			$date = time();
			mssql_query("INSERT INTO dbo.MMW_forum ([f_id],[f_catalog],[f_title],[f_text],[f_created],[f_date],[f_char],[f_lastchar]) VALUES ('{$mmw['rand_id']}','{$catalog}','{$title}','{$text}','{$date}','{$date}','{$_SESSION['character']}','{$_SESSION['character']}')");
			echo $okey_start . mmw_lang_topic_sent . $okey_end;
		}
		echo $rowbr;
	}

	$forum_catalog = '';
	foreach ($mmw['forum_catalog'] as $key => $value) {
		if ($value[2] == 0 || $mmw['status_rules'][$_SESSION['mmw_status']]['forum_add']) {
			$forum_catalog .= '<option value="' . $key . '">' . $value[0] . '</option>';
		}
	}
	?>
	<form method="POST" name="forum" action="" style="margin:0">
		<table class="sort-table" style="margin:0 auto;border:0;padding:0">
			<tr>
				<td align="right" width="110"><?php echo mmw_lang_forum_catalog; ?>:</td>
				<td><select name="catalog" size="1"><?php echo $forum_catalog; ?></select></td>
			</tr>
			<tr>
				<td align="right"><?php echo mmw_lang_topic_name; ?>:</td>
				<td>
					<input type='text' size='35' name='subject' maxlength='32' value='<?php echo $_POST['subject']; ?>'>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo mmw_lang_bb_code; ?>:</td>
				<td>
					[br] - [hr] - <b>[b][/b]</b> - <i>[i][/i]</i> - <u>[u][/u]</u> - <s>[s][/s]</s> -
					<span style='text-decoration: overline'>[o][/o]</span> <br> <sup>[sup][/sup]</sup> - <sub>[sub][/sub]</sub>
					-
					[c]<b>.::.</b>[/c] - [l]<b>::..</b>[/l] - [r]<b>..::</b>[/r] <br> [color=#][/color] -
					[size=#][/size] - [url=#][/url] <br> [img]#[/img] - [video]YouTube.com #[/video]
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo mmw_lang_topic_text; ?>:</td>
				<td><textarea rows="8" cols="40" name="text"><?php echo $_POST['text']; ?></textarea></td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<input type="submit" value="<?php echo mmw_lang_add_topic; ?>">
					<input type="reset" value="<?php echo mmw_lang_renew; ?>">
				</td>
			</tr>
		</table>
	</form>
	<?php
} elseif ($id_forum !== 'add' && !empty($id_forum)) {
	$get_topic = mssql_query("SELECT
		f.f_id,
		f.f_char,
		f.f_title,
		f.f_text,
		f.f_date,
		f.f_lastchar,
		f.f_status,
		f.f_created,
		f.f_views,
		f.f_catalog,
		c.CtlCode,
		mi.avatar,
		mi.country,
		mi.gender
			FROM dbo.MMW_forum AS f
			LEFT JOIN dbo.Character AS c ON c.Name COLLATE DATABASE_DEFAULT = f.f_char COLLATE DATABASE_DEFAULT
			LEFT JOIN dbo.MEMB_INFO AS mi ON mi.memb___id COLLATE DATABASE_DEFAULT = c.AccountID COLLATE DATABASE_DEFAULT
				WHERE f.f_id = '{$id_forum}'");
	if ($row = mssql_fetch_row($get_topic)) {
		$topic_img = 'f_'
			. ($row[8] >= $mmw['forum_topic_hot'] ? 'hot' : 'norm')
			. '_'
			. ($row[4] > strtotime('-' . $mmw['forum_of_new']) ? 'new' : 'nonew')
			. '.gif';
		if ($row[6] == 1) {
			$topic_img = 'f_closed_nonew.gif';
		}

		$avatar = !empty($row[11])
			? '<img src="' . $row[11] . '" width="110" alt="' . $row[1] . '" border="0">'
			: '<img src="' . default_img('no_avatar.jpg') . '" width="110" alt="No avatar" border="0">';
		$country = country($row[12]);
		$gender = gender($row[13]);

		$option = '';
		if ($mmw['status_rules'][$_SESSION['mmw_status']]['forum_delete'] || $_SESSION['character'] === $row[1]) {
			$option .= drawOptionButton($row[0], 'delete', mmw_lang_delete, '?op=forum&c=' . $row[9]);
		}
		if ($mmw['status_rules'][$_SESSION['mmw_status']]['forum_status']) {
			$option .= !empty($row[6])
				? drawOptionButton($row[0], 'open', mmw_lang_open, '?op=forum&c=' . $row[9])
				: drawOptionButton($row[0], 'close', mmw_lang_close, '?op=forum&c=' . $row[9]);
		}
		?>
		<table class="aBlock" style="width:100%">
			<tr>
				<td style="padding:2px;" width="110" valign="top" align="center">
					<a href="?op=character&character=<?php echo $row[1]; ?>"><?php echo $avatar; ?></a><br>
					<?php echo mmw_lang_char; ?>: <a href="?op=character&character=<?php echo $row[1]; ?>" class="level<?php echo $row[10]; ?>">
						<b><?php echo $row[1]; ?></b>
					</a><br>
					<?php echo mmw_lang_country; ?>: <?php echo $country; ?><br>
					<?php echo mmw_lang_gender; ?>: <?php echo $gender; ?><br>
				</td>
				<td style="padding:4px;" valign="top">
					<img src="<?php echo default_img($topic_img); ?>" align="bottom">
					<big><b><?php echo $row[2]; ?></b></big>
					<small><span title="<?php echo mmw_lang_date; ?>">(<?php echo date('d.m.Y, H:i', $row[7]); ?>)</span></small>
					<?php echo $option; ?>
					<div class="sizedforum"><?php echo bbcode($row[3]); ?></div>
				</td>
			</tr>
		</table>
		<?php
		$quantityComment = comment_module(2, $id_forum, !empty($row[6]));

		$lastCommentResult = mssql_query("SELECT TOP 1 c_char,c_date FROM dbo.MMW_comment WHERE c_id_blog=2 AND c_id_code='{$id_forum}' ORDER BY c_date DESC");
		$comment_info = ($lastCommentRow = mssql_fetch_row($lastCommentResult))
			? "[f_date]='$lastCommentRow[1]',[f_lastchar]='$lastCommentRow[0]',"
			: "[f_date]='$row[7]',[f_lastchar]='$row[1]',";

		$newViews = empty($row[8]) ? 1 : 'f_views + 1';
		mssql_query("UPDATE dbo.MMW_forum SET {$comment_info} [f_views]={$newViews},[f_comments]={$quantityComment} WHERE f_id='{$id_forum}'");
	} else {
		echo $die_start . 'No Topic' . $die_end;
	}
} elseif (isset($_SESSION['user'])) {
	echo $die_start . 'Sorry, you can`t add comment, need Character!' . $die_end;
} else {
	echo $die_start . 'Hello hacker!' . $die_end;
}