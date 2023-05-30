<?php
/**
 * Forum engine by Vaflan
 * @var array $mmw
 * @var string $okey_start
 * @var string $okey_end
 * @var string $die_start
 * @var string $die_end
 * @var string $rowbr
 */

require_once __DIR__ . '/../includes/forum_catalog.php';

function drawLastComment($postId, $postName, $timestamp, $characterName, $characterCode)
{
	$date = date('D, d.m.Y, H:i', $timestamp);
	$icon = default_img('last_comment.gif');

	return '<a href="?forum=' . $postId . '#last_comment" title="' . mmw_lang_last_message . '">' . $date . ' <img src="' . $icon . '" border="0"></a><br>'
		. mmw_lang_topic . ': <a href="?forum=' . $postId . '">' . $postName . '</a><br>'
		. mmw_lang_message_from . ': <a href="?op=character&character=' . $characterName . '" class="level' . $characterCode . '">' . $characterName . '</a>';
}

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

if (isset($_POST['f_id_delete'])) {
	$f_id = clean_var(stripslashes($_POST['f_id_delete']));
	$result = mssql_query("SELECT f_char FROM dbo.MMW_forum WHERE f_id='{$f_id}'");
	$row = mssql_fetch_row($result);

	if (empty($f_id)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif ($row[0] === $_SESSION['character'] || $mmw['status_rules'][$_SESSION['mmw_status']]['forum_delete']) {
		mssql_query("DELETE FROM dbo.MMW_forum WHERE f_id='{$f_id}'");
		mssql_query("DELETE FROM dbo.MMW_comment WHERE c_id_code='{$f_id}'");
		echo $okey_start . mmw_lang_topic_deleted . $okey_end;
	} else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
}

if (isset($_POST['f_id_close']) || isset($_POST['f_id_open'])) {
	$f_id = clean_var(stripslashes(isset($_POST['f_id_close']) ? $_POST['f_id_close'] : $_POST['f_id_open']));
	$f_status = $_POST['f_id_close'] ? 1 : 0;

	if (empty($f_id)) {
		echo $die_start . mmw_lang_left_blank . $die_end;
	} elseif ($mmw['status_rules'][$_SESSION['mmw_status']]['forum_status']) {
		mssql_query("UPDATE dbo.MMW_forum SET f_status='{$f_status}' where f_id='{$f_id}'");
		echo $okey_start . mmw_lang_topic_status . $okey_end;
	} else {
		echo $die_start . mmw_lang_cant_or_alread_delete . $die_end;
	}
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

if (empty($_GET['c'])) {
	?>
	<table class="sort-table" style="border:0;padding:0;width:100%">
		<thead>
		<tr>
			<td width="30"></td>
			<td><small><?php echo mmw_lang_forum; ?></small></td>
			<td style="text-align:center" width="60"><small><?php echo mmw_lang_topics; ?></small></td>
			<td style="text-align:center" width="60"><small><?php echo mmw_lang_answers; ?></small></td>
			<td width="160"><small><?php echo mmw_lang_updates; ?></small></td>
		</tr>
		</thead>
		<?php
		foreach ($mmw['forum_catalog'] as $key => $value) {
			$result = mssql_query("SELECT count(f_id), sum(f_comments) FROM dbo.MMW_forum WHERE f_catalog='{$key}'");
			$row = mssql_fetch_row($result);

			$forum_img = 'c_nonew.gif';
			$last_forum = mmw_lang_no_message;

			if (!empty($row[0])) {
				$post_row = mssql_fetch_row(mssql_query("SELECT TOP 1
					f.f_id,
					f.f_title,
					f.f_date,
					f.f_lastchar,
					c.CtlCode
					FROM dbo.MMW_forum AS f
					LEFT JOIN dbo.Character AS c ON c.Name COLLATE DATABASE_DEFAULT = f.f_lastchar COLLATE DATABASE_DEFAULT
						WHERE f.f_catalog = {$key}
						ORDER BY f.f_date DESC"));
				if ($post_row[2] > strtotime('-' . $mmw['forum_of_new'])) {
					$forum_img = 'c_new.gif';
				}
				$last_forum = drawLastComment($post_row[0], $post_row[1], $post_row[2], $post_row[3], $post_row[4]);
			}

			if (empty($row[1])) {
				$row[1] = 0;
			}
			?>
			<tr>
				<td style="text-align:center"><img src="<?php echo default_img($forum_img); ?>"></td>
				<td>
					<a href="?op=forum&c=<?php echo $key; ?>"><b><?php echo $value[0]; ?></b></a><br>
					<small><?php echo $value[1]; ?></small>
				</td>
				<td style="text-align:center"><?php echo $row[0]; ?></td>
				<td style="text-align:center"><?php echo $row[1]; ?></td>
				<td><small><?php echo $last_forum; ?></small></td>
			</tr>
			<?php
		} ?>
	</table>
	<?php
} else {
	$sort = ($_GET['c'] === 'new')
		? "f.f_date > " . strtotime('-' . $mmw['forum_of_new'])
		: "f.f_catalog = " . intval($_GET['c']);
	?>
	<table class="sort-table" style="border:0;padding:0;width:100%">
		<thead>
		<tr>
			<td width="20"></td>
			<td><small><?php echo mmw_lang_topics; ?></small></td>
			<td style="text-align:center" width="60"><small><?php echo mmw_lang_answers; ?></small></td>
			<td style="text-align:center" width="60"><small><?php echo mmw_lang_views; ?></small></td>
			<td style="text-align:center" width="70"><small><?php echo mmw_lang_author_topic; ?></small></td>
			<td width="160"><small><?php echo mmw_lang_updates; ?></small></td>
		</tr>
		</thead>
		<?php
		$result = mssql_query("SELECT
			f.f_id,
			f.f_char,
			f.f_title,
			f.f_text,
			f.f_date,
			f.f_lastchar,
			f.f_status,
			f.f_comments,
			f.f_views,
			cc.CtlCode AS createdCtlCode,
			lc.CtlCode AS lastCtlCode
			FROM dbo.MMW_forum AS f
			LEFT JOIN dbo.Character AS cc ON cc.Name COLLATE DATABASE_DEFAULT = f.f_char COLLATE DATABASE_DEFAULT
			LEFT JOIN dbo.Character AS lc ON lc.Name COLLATE DATABASE_DEFAULT = f.f_char COLLATE DATABASE_DEFAULT
				WHERE {$sort}
				ORDER BY f.f_date DESC");
		$count = mssql_num_rows($result);
		while ($row = mssql_fetch_row($result)) {
			$last_forum = drawLastComment($row[0], $row[2], $row[4], $row[5], $row[10]);

			$topic_img = 'f_'
				. ($row[7] >= $mmw['forum_topic_hot'] ? 'hot' : 'norm')
				. '_'
				. ($row[4] > strtotime('-' . $mmw['forum_of_new']) ? 'new' : 'nonew')
				. '.gif';
			if ($row[6] == 1) {
				$topic_img = 'f_closed_nonew.gif';
			}

			if (empty($row[7])) {
				$row[7] = 0;
			}
			if (empty($row[8])) {
				$row[8] = 0;
			}

			$option = '';
			if ($mmw['status_rules'][$_SESSION['mmw_status']]['forum_delete'] || $_SESSION['character'] === $row[1]) {
				$option .= drawOptionButton($row[0], 'delete', mmw_lang_delete);
			}
			if ($mmw['status_rules'][$_SESSION['mmw_status']]['forum_status']) {
				$option .= !empty($row[6])
					? drawOptionButton($row[0], 'open', mmw_lang_open)
					: drawOptionButton($row[0], 'close', mmw_lang_close);
			}
			?>
			<tr>
				<td style="text-align:center"><img src="<?php echo default_img($topic_img); ?>"></td>
				<td>
					<a href="?forum=<?php echo $row[0]; ?>"><b><?php echo $row[2]; ?></b></a> <?php echo $option; ?>
				</td>
				<td style="text-align:center"><?php echo $row[7]; ?></td>
				<td style="text-align:center"><?php echo $row[8]; ?></td>
				<td style="text-align:center">
					<a href="?op=character&character=<?php echo $row[1]; ?>" class="level<?php echo $row[9]; ?>">
						<?php echo $row[1]; ?>
					</a>
				</td>
				<td><small><?php echo $last_forum; ?></small></td>
			</tr>
			<?php
		}

		if (empty($count)) {
			echo '<tr><td colspan="6" style="text-align:center;font-weight:bold;height:30px">' . mmw_lang_no_topics_in_forum . '</td></tr>';
		}
		?>
	</table>
	<?php
}

$extendWhere = !empty($_GET['c']) ? ' WHERE ' . $sort : '';
$totalResult = mssql_query("SELECT count(f_id), sum(f_comments) FROM dbo.MMW_forum AS f" . $extendWhere);
$totalRow = mssql_fetch_row($totalResult);
if (empty($totalRow[1])) {
	$totalRow[1] = 0;
}
echo $rowbr . mmw_lang_total_topic . ': ' . $totalRow[0] . ' &nbsp; ' . mmw_lang_total_comment . ': ' . $totalRow[1];
