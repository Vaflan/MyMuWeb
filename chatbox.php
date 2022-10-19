<?php
// This is ChatBox by Vaflan
// For MyMuWeb Engine

session_start();
header('Cache-Control: no-store, no-cache, must-revalidate');

/** @var array $mmw */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/sql_check.php';
require_once __DIR__ . '/includes/xss_check.php';
require_once __DIR__ . '/includes/engine.php';

// Drop
if(isset($_GET['delete'])) {
	$id = intval($_GET['delete']);
	if($mmw['status_rules'][$_SESSION['mmw_status']]['chat_delete'] == 1) {
		mssql_query("DELETE FROM dbo.MMW_chatbox WHERE f_id='{$id}'");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ChatBox - <?php echo $mmw['webtitle']; ?></title>
	<meta http-equiv="refresh" content="<?php echo $mmw['chat_auto_reload']; ?>">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo $mmw['theme_dir']; ?>/style.css" rel="stylesheet" type="text/css" media="all">
	<link href="<?php echo $mmw['theme_dir']; ?>/favicon.ico" rel="shortcut icon">
	<style>
		body {
			background: transparent none;
		}
		.button-delete img {
			vertical-align: bottom;
			border: 0;
		}
	</style>
	<script>
		function setNameToMessage(name) {
			var msg = parent.document.getElementById('message');
			if (msg.value === '<?php echo mmw_lang_message; ?>') {
				msg.value = '';
			}
			msg.value = msg.value.trim() + ' ' + name + ' ';
		}
	</script>
</head>
<table width="100%" height="380" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">
			<div style="width:100%;height:380px;overflow:auto;padding:2px;border-right:1px solid #<?php echo $media_color; ?>;">
				<?php
				$result = mssql_query("SELECT TOP {$mmw['chat_max_post']} * FROM dbo.MMW_chatbox ORDER BY f_id DESC");
				if (mssql_num_rows($result)) {
					$today = date('d.m.Y');
					$yesterday = date('d.m.Y', strtotime('-1 day'));
					$buttonRequestToDelete = mmw_lang_request_delete;
					while ($row = mssql_fetch_assoc($result)) {
						$time = date('H:i:s', $row['f_date']);
						$day = date('d.m.Y', $row['f_date']);
						if ($day === $today) {
							$day = mmw_lang_today;
						} elseif ($day === $yesterday) {
							$day = mmw_lang_yesterday;
						}
						$message = smile($row['f_message']);

						$character_result = mssql_query("SELECT Name, CtlCode FROM dbo.Character WHERE NAME='{$row['f_char']}'");
						$character_row = mssql_fetch_row($character_result);

						$option = '';
						if ($mmw['status_rules'][$_SESSION['mmw_status']]['chat_delete'] == 1) {
							$option .= <<<OPTION
<a href="?delete={$row['f_id']}" title="Delete" onclick="return confirm('{$buttonRequestToDelete}');" class="button-delete">
	<img src="images/delete.png" alt="delete">
</a>
OPTION;
						}
						echo <<<HTML
<div style="border-bottom: 1px dashed #{$media_color}; padding: 2px;">
	{$option}
	<span title="{$day}">[{$time}]</span>
	<a href="javascript:void(0)" class="level{$character_row[1]}" onclick="setNameToMessage('{$row['f_char']}');">{$row['f_char']}</a>:
	{$message}
</div>
HTML;
					}
				} else {
					echo mmw_lang_no_message;
				}
				?>
			</div>
		</td>
		<td valign="top" width="130" align="right">
			<div style="width: 100%; height: 380px; overflow: auto; padding: 2px;">
				<?php
				$result = mssql_query("SELECT
					c.name,
					c.CtlCode,
					c.clevel,
					c.{$mmw['reset_column']}
						FROM dbo.MMW_online AS o
						JOIN dbo.Character AS c ON c.name COLLATE DATABASE_DEFAULT = o.online_char COLLATE DATABASE_DEFAULT
							WHERE o.online_date > '{$timeout}'");
				$num = mssql_num_rows($result);
				echo '<b>' . mmw_lang_who_is_on_web . '</b>';
				if ($num < 1) {
					echo '<div>' . mmw_lang_there_is_nobody . '</div>';
				} else {
					while ($row = mssql_fetch_row($result)) {
						echo <<<HTML
<div>
	<a href="javascript:void(0)" onclick="parent.window.location='?op=character&character=$row[0]'" class="level{$row[1]}">
		{$row[0]} [{$row[3]}/{$row[2]}]
	</a>
</div>
HTML;
					}
				}
				?>
			</div>
		</td>
	</tr>
</table>
</html>