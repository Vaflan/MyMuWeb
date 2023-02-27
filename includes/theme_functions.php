<?php /** @var array $mmw */

/////// Start Language ///////
function language()
{
	global $mmw;
	$language = mmw_lang_language;
	$languageList = '';
	if ($dh = opendir('lang/')) {
		while (($file = readdir($dh)) !== false) {
			$format = substr($file, -3);
			$name = substr($file, 0, -4);
			if ($format === 'php') {
				$selected = ($mmw['language'] === $name)
					? ' selected'
					: '';
				$languageList .= '<option value="' . $name . '"' . $selected . '>' . $name . '</option>';
			}
		}
		closedir($dh);
	}

	echo <<<HTML
<form name="language" method="post" action="">
	<select name="set_lang" onChange="event.target.parentElement.submit();" title="{$language}">
		{$languageList}
	</select>
</form>
HTML;
}
/////// End Language ///////


/////// Start Theme ///////
function theme()
{
	global $mmw;
	$theme = mmw_lang_theme;
	$themeList = '';
	if ($mmw['themes_auto']) {
		$dir = 'themes/';
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				$type = filetype($dir . $file);
				if ($type === 'dir' && $file !== '.' && $file !== '..') {
					include $dir . $file . '/info.php';
					$selected = ($mmw['theme'] === $file)
						? ' selected'
						: '';
					$themeList .= '<option value="' . $file . '"' . $selected . '>' . $mmw['thm_name'] . '</option>';
				}
			}
			require $dir . $mmw['theme'] . '/info.php';
			closedir($dh);
		}
	} else {
		foreach ($mmw['themes'] as $row) {
			$selected = ($mmw['theme'] === $row[0])
				? ' selected'
				: '';
			$themeList .= '<option value="' . $row[0] . '"' . $selected . '>' . $row[1] . '</option>';
		}
	}
	echo <<<HTML
<form name="theme" method="post" action="">
	<select name="set_theme" onChange="event.target.parentElement.submit();" title="{$theme}">
		{$themeList}
	</select>
</form>
HTML;
}
/////// End Theme ///////


/////// Start Menu //////
function menu($style = null)
{
	global $mmw;
	require __DIR__ . '/menu.php';
	if (empty($style)) {
		$style = '<a href="$1">$2</a><br>';
	}

	foreach ($mmw['menu'] as $i => $row) {
		$replace = str_replace(
			array('%id%', '%name%', '%url%'),
			array($i, $row[0], $row[1]),
			$style
		);
		echo preg_replace(
				'/\[url=(.*)]\[name=(.*)]/is',
				$replace,
				'[url=' . $row[1] . '][name=' . $row[0] . ']'
			) . PHP_EOL;
	}
}
/////// End Menu ///////


/////// Start Login Form ///////
function login_form()
{
	global $mmw, $rowbr;
	if (isset($_SESSION['user'])) {
		/* Select Account information */
		$accountQuery = mssql_query("SELECT memb_name AS name, avatar FROM dbo.MEMB_INFO WHERE memb___id='{$_SESSION['user']}'");
		$accountInfo = mssql_fetch_assoc($accountQuery);
		if (empty($accountInfo['name'])) {
			$accountInfo['name'] = $_SESSION['user'];
		}
		if (empty($accountInfo['avatar'])) {
			$accountInfo['avatar'] = default_img('no_avatar.jpg');
		}

		/* Select Char */
		$characterQuery = mssql_query("SELECT name FROM dbo.Character WHERE AccountID='{$_SESSION['user']}'");
		$setCharacter = '';
		if (mssql_num_rows($characterQuery)) {
			$setCharacter = '<form name="char" method="post" action=""><select name="set_char" onChange="event.target.parentElement.submit();" title="' . mmw_lang_character_panel . '">';
			while ($row = mssql_fetch_row($characterQuery)) {
				$selected = ($_SESSION['character'] === $row[0])
					? ' selected'
					: '';
				$setCharacter .= '<option value="' . $row[0] . '"' . $selected . '> ' . $row[0] . ' </option>';
			}
			$setCharacter .= '</select></form>';
		}

		/* Mail Check */
		if ($mmw['inner_mail']) {
			$msg = mssql_query("SELECT
				fmail.bRead
					FROM dbo.T_FriendMain AS fmain
					JOIN dbo.T_FriendMail AS fmail ON fmail.GUID = fmain.GUID
					WHERE fmain.Name='{$_SESSION['character']}'");
			$msg_num = mssql_num_rows($msg);
			$msg_new_num = 0;
			if (!empty($msg_num)) {
				while ($msg_row = mssql_fetch_row($msg)) {
					if (empty($msg_row[0])) {
						$msg_new_num++;
					}
				}
			}
			$msg_full = ($mmw['private_message']['num'] <= $msg_num)
				? '<u style="color:red">Full!</u>'
				: '';
		}

		/* End Form */
		require __DIR__ . '/acc_menu.php';
		if ($msg_new_num > 0) {
			echo '<script>setInterval("flashIt(\'upmess\',\'#FFF\')", 500)</script>';
		}
	} else {
		/* No Login */
		$language = array(
			'account' => mmw_lang_account,
			'password' => mmw_lang_password,
			'lost_pass' => mmw_lang_lost_pass,
			'login' => mmw_lang_login,
		);

		echo <<<HTML
<form action="" method="post" name="login_account">
	<input type="hidden" name="login" value="login">
	{$language['account']}<br>
	<input name="account" type="text" title="{$language['account']}" size="15" maxlength="10"><br>
	{$language['password']}<br>
	<input name="password" type="password" title="{$language['password']}" size="15" maxlength="10"><br>
	<a href="?op=lostpass">{$language['lost_pass']}</a> <input type="submit" value="{$language['login']}" title="{$language['login']}">
</form>
HTML;
	}
}
/////// End Login Form ///////


/////// Start Online Char ///////
function who_online($return = false)
{
	global $mmw;
	$timeout = time() - $mmw['timeout_online'];
	$query = mssql_query("SELECT
			c.name,
			c.CtlCode
		FROM dbo.MMW_online AS o
		LEFT JOIN dbo.Character AS c ON c.name COLLATE DATABASE_DEFAULT = o.online_char COLLATE DATABASE_DEFAULT
		WHERE o.online_date > '{$timeout}'");

	$guestsCount = 0;
	$characterList = array();
	$totalOnWeb = mssql_num_rows($query);
	if ($totalOnWeb) {
		while ($row = mssql_fetch_row($query)) {
			if (empty($row[0])) {
				$guestsCount++;
			} else {
				$characterList[] = '<a href="?op=character&character='. $row[0] .'" class="level' . $row[1] . '">' . $row[0] . '</a>';
			}
		}
	} else {
		$characterList[] = mmw_lang_there_is_nobody;
	}
	$whoOnline = mmw_lang_total_on_web . ': ' . $totalOnWeb
		. '<br>' . mmw_lang_total_guest . ': ' . $guestsCount
		. '<br>' . mmw_lang_total_accounts . ': ' . count($characterList)
		. '<hr class="hr-online-acc">' . implode(', ', $characterList);

	if (empty($return)) {
		echo $whoOnline;
	}
	return $whoOnline;
}

/** @deprecated Support 0.7 */
$who_online = who_online(true);
/////// END Online Char ///////


/////// Start Last in Forum ///////
function last_in_forum($top = null)
{
	global $mmw;
	if (empty($top)) {
		$top = $mmw['last_in_forum'];
	}
	$result = mssql_query("SELECT TOP {$top} f_id, f_title, f_text FROM dbo.MMW_forum ORDER BY f_date DESC");
	$forum_post = mssql_num_rows($result);
	if (empty($forum_post)) {
		echo mmw_lang_no_topics_in_forum;
	} else {
		$index = 1;
		while ($row = mssql_fetch_row($result)) {
			$row[2] = htmlentities($row[2]);
			echo "{$index}. <a href=\"?forum={$row[0]}\" title=\"{$row[2]}\">{$row[1]}</a><br>" . PHP_EOL;
			$index++;
		}
	}
}
/////// END Last in Forum ///////


/////// Start Voting ///////
function voting($return = false)
{
	global $mmw;
	$votingIndicator = ($mmw['votes_check'] === 'acc')
		? (isset($_SESSION['user']) ? $_SESSION['user'] : null)
		: $_SERVER['REMOTE_ADDR'];

	$query = mssql_query("SELECT TOP 1 ID,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM dbo.MMW_votemain ORDER BY NEWID()");
	if ($row = mssql_fetch_row($query)) {
		$voteList = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
		$alreadyVoted = 0;
		$queryRows = mssql_query("SELECT who, answer FROM dbo.MMW_voterow WHERE id_vote='{$row[0]}'");
		$totalNumberVotes = mssql_num_rows($queryRows);
		while ($answerRow = mssql_fetch_row($queryRows)) {
			if ($answerRow[0] === $votingIndicator) {
				$alreadyVoted = $answerRow[1];
			}
			$voteList[$answerRow[1]]++;
		}

		$voting = '<form name="voting" method="post" action=""><b>' . $row[1] . '</b><br>';
		for ($index = 1; $index < 7; $index++) {
			$answerLabel = $row[$index + 1];
			if (!empty($answerLabel)) {
				if (!empty($votingIndicator) && empty($alreadyVoted)) {
					$voting .= '<div class="answer"><label><input type="radio" name="answer" value="'. $index . '"> ' . $answerLabel . '</label></div>';
				} else {
					$voteCount = $voteList[$index];
					$img_file = default_img('bar.jpg');
					$size = @getimagesize($img_file);
					$img_width = ($voteCount > 0) ? ceil(100 * $voteCount / $totalNumberVotes) : 1;
					$voting .= '<div class="answer">' . $index . '. ' . $answerLabel . ' (' . $voteCount . ')</div>';
					$voting .= '<div class="answer"><img src="' . $img_file . '" height="' . $size[1] . '" width="' . $img_width . '%" alt="bar"></div>';
				}
			}
		}

		$voting .= '<div style="text-align:center">';
		if (!empty($votingIndicator) && empty($alreadyVoted)) {
			$voting .= '<input name="id_vote" type="hidden" value="' . $row[0] . '"><input type="submit" value="' . mmw_lang_to_vote . '">';
		} else {
			$voting .= mmw_lang_all_answers . ': <b>' . $totalNumberVotes . '</b>';
		}
		$voting .= '</div></form>';
	} else {
		$voting = mmw_lang_no_vote;
	}

	if (empty($return)) {
		echo $voting;
	}
	return $voting;
}

/** @deprecated Support 0.7 */
$voting = voting(true);
/////// END Voting ///////


/////// Start Statisitcs ///////
function statisitcs($style = 'default')
{
	global $mmw, $back_color, $text_color;

	if ($style === 'cscw') {
		$dataCSCW = mssql_fetch_assoc(
			mssql_query("SELECT CASTLE_OCCUPY, OWNER_GUILD FROM dbo.MuCastle_DATA")
		) ?: [];
		try {
			$dataCW = mssql_fetch_assoc(
				mssql_query("SELECT CRYWOLF_OCCUFY FROM dbo.MuCrywolf_DATA")
			);
			$dataCSCW += $dataCW ?: [];
		} catch (Exception $ignored) {
			// Do nothing
		}

		$dataCSCW['CASTLE_OCCUPY'] = empty($dataCSCW['CASTLE_OCCUPY'])
			? '<span style="color: red">Not captured</span>'
			: '<span style="color: green">Captured</span>';

		$dataCSCW['OWNER_GUILD'] = empty($dataCSCW['OWNER_GUILD'])
			? '<a href="?op=castlesiege">No Guild</a>'
			: '<a href="?op=guild&guild=' . $dataCSCW['OWNER_GUILD'] . '">' . $dataCSCW['OWNER_GUILD'] . '</a>';

		$dataCSCW['CRYWOLF_OCCUFY'] = empty($dataCSCW['CASTLE_OCCUPY'])
			? '<span style="color: red">Captured</span>'
			: '<span style="color: green">Protected</span>';

		echo 'Castle Siege: ' . $dataCSCW['CASTLE_OCCUPY'] . '<br>' . PHP_EOL
			. 'Owner Guild: ' . $dataCSCW['OWNER_GUILD'] . '<br>' . PHP_EOL
			. 'Cry Wolf: ' . $dataCSCW['CRYWOLF_OCCUFY']. '<br>' . PHP_EOL;
		return true;
	}

	$withoutGM = !empty($mmw['gm_show'])
		? ' WHERE CtlCode < 8'
		: '';

	$activeDate = date('m/d/Y', strtotime('-1 month'));
	$query = mssql_query("SELECT
		count(*) AS total,
		(SELECT count(*) AS total FROM dbo.MEMB_INFO WHERE bloc_code=1) AS total_blocked,
		(SELECT count(*) FROM dbo.Character {$withoutGM}) AS total_characters,
		(SELECT count(*) FROM dbo.Guild WHERE G_Name!='{$mmw['gm_guild']}') AS total_guilds,
		(SELECT count(*) FROM dbo.MEMB_STAT WHERE ConnectTM>='{$activeDate}') AS account_active,
		(SELECT count(*) FROM dbo.MEMB_STAT WHERE ConnectStat=1) AS account_online
	FROM dbo.MEMB_INFO");
	$data = mssql_fetch_assoc($query);

	$total_accounts = $data['total'];
	$total_banneds = $data['total_blocked'];
	$total_characters = $data['total_characters'];
	$total_guilds = $data['total_guilds'];
	$actives_acc = $data['account_active'];
	$users_connected = $data['account_online'];

	$serverQuery = mssql_query("SELECT
		mmw_s.Name,
		mmw_s.experience,
		mmw_s.drops,
		mmw_s.gsport,
		mmw_s.ip,
		mmw_s.version,
		mmw_s.type,
		mmw_s.maxplayer,
		ms.total_online
	FROM dbo.MMW_servers AS mmw_s
	LEFT JOIN (SELECT ServerName, count(ServerName) AS total_online FROM dbo.MEMB_STAT WHERE ConnectStat=1 GROUP BY ServerName) AS ms
		ON ms.ServerName COLLATE DATABASE_DEFAULT = mmw_s.Name COLLATE DATABASE_DEFAULT
	ORDER BY mmw_s.display_order");
	$server = array();
	if (empty($_ENV['mmw_cache']['server_cache']) || $_ENV['mmw_cache']['server_cache']['timeout'] + $mmw['server_timeout'] < time()) {
		$_ENV['mmw_cache']['server_cache'] = array();
	}
	while ($row = mssql_fetch_assoc($serverQuery)) {
		if (!$row['total_online']) {
			$row['total_online'] = 0;
		}
		$serverAddress = $row['ip'] . ':' . $row['gsport'];
		if (!isset($_ENV['mmw_cache']['server_cache'][$serverAddress])) {
			$_ENV['mmw_cache']['server_cache'][$serverAddress] = false;
			$_ENV['mmw_cache']['server_cache']['timeout'] = time();
			if ($check = @fsockopen($row['ip'], $row['gsport'], $errorCode, $errorMessage, 0.5)) {
				$_ENV['mmw_cache']['server_cache'][$serverAddress] = true;
				fclose($check);
			}
		}
		$status = $_ENV['mmw_cache']['server_cache'][$serverAddress];

		$row['html_status'] = '<img src="' . default_img($status ? 'online.gif' : 'offline.gif') . '" width="6" height="6" alt="status"> '
			. '<span class="' . ($status ? 'online' : 'offline') . '">' . ($status ? mmw_lang_serv_online : mmw_lang_serv_offline) . '</span>';

		$server[] = $row;
	}

	switch ($style) {
		case 'main':
			$labels = array(
				'on_server' => mmw_lang_on_server,
				'version' => mmw_lang_version,
				'experience' => mmw_lang_experience,
				'drops' => mmw_lang_drops,
			);

			echo '<style>@import url(images/main/style.css);</style>';
			foreach ($server as $index => $row) {
				$bar = ceil($row['total_online'] * 10 / $row['maxplayer']);
				echo <<<HTML
<table border="0" cellSpacing="0" cellPadding="0" width="193"><tr><td height="26" style="background:url('images/main/{$bar}.png');cursor:pointer;" onmouseover="this.className='effect80'" onmouseup="this.className='effect80'" onmousedown="this.className='effect70'" onmouseout="this.className=''" onclick="expandit('main{$index}')" align="center">
<div class="main1" align="center">{$row['Name']} ({$row['type']})</div></td></tr><tr><td id="main{$index}" style="display:none;">
<table border="0" cellSpacing="0" cellPadding="0" width="100%"><tr><td class="maintl"></td><td class="maintc"></td><td class="maintr"></td></tr><tr><td class="maincl"></td><td class="mainc">
<div><span class="main2">{$labels['on_server']}:</span><span class="main3">{$row['total_online']}</span></div><div><span class="main2">{$labels['version']}:</span><span class="main3">{$row['version']}</span></div><div><span class="main2">{$labels['experience']}:</span><span class="main3">{$row['experience']}</span></div><div><span class="main2">{$labels['drops']}:</span><span class="main3">{$row['drops']}</span></div>
</td><td class="maincr"></td></tr><tr><td class="mainbl"></td><td class="mainbc"></td><td class="mainbr"></td></tr></table></td></tr></table>
HTML;
			}
			return true;
		case 'blink':
		case 'fullblink':
			if ($style === 'fullblink') {
				echo '<script src="scripts/textfader.js"></script>';
			}
			$data = array(
				mmw_lang_total_accounts . ': ' . $total_accounts . '<br>'
				. mmw_lang_total_characters . ': ' . $total_characters . '<br>'
				. mmw_lang_total_banneds . ': ' . $total_banneds . '<br>'
				. mmw_lang_total_actives . ': ' . $actives_acc . '<br>'
				. mmw_lang_total_guilds . ': ' . $total_guilds . '<br>'
				. mmw_lang_total_users_online . ': ' . $users_connected
			);
			foreach ($server as $row) {
				$data[] = $row['Name'] . '<br>'
					. mmw_lang_version . ': ' . $row['version'] . '<br>'
					. mmw_lang_experience . ': ' . $row['experience'] . '<br>'
					. mmw_lang_drops . ': ' . $row['drops'] . '<br>'
					. mmw_lang_type . ': ' . $row['type'] . '<br>'
					. $row['html_status'];
			}

			$_ENV['fader'] = isset($_ENV['fader']) ? ++$_ENV['fader'] : 1;
			$json = json_encode($data);
			echo <<<HTML
<div id="statistics"></div>
<script>
var throbStep = 0;
function throbFade(index) {
	fade(index, Math.floor(throbStep / 2), !(throbStep % 2));
	setTimeout('throbFade(' + index + ');', (throbStep % 2) ? 100 : 4000);
	if(++throbStep > fader[index].message.length * 2 - 1) {
		throbStep = 0;
	}
}
fader[{$_ENV['fader']}] = new FadeObj({$_ENV['fader']}, 'statistics', '{$back_color}', '{$text_color}', 30, 30, false);
fader[{$_ENV['fader']}].message = {$json};
setTimeout('throbFade({$_ENV['fader']});', 1000);
</script>
HTML;
			return true;
		case 'default':
			foreach ($server as $row) {
				$helpLink = mmw_lang_version . ': ' . $row['version'] . '<br>'
					. mmw_lang_experience . ': ' . $row['experience'] . '<br>'
					. mmw_lang_drops . ': ' . $row['drops'] . '<br>'
					. mmw_lang_type . ': ' . $row['type'];

				echo '<span class="helplink" title="'. $helpLink .'">' . $row['Name'] . ': ' . $row['html_status'] . '</span><br>'
					. mmw_lang_on_server . ' ' . $row['total_online'] . ' ' . mmw_lang_char . '<br>';
			}
			echo PHP_EOL . mmw_lang_total_users_online . ': ' . $users_connected . '<br>'
				. mmw_lang_total_accounts . ': ' . $total_accounts . '<br>'
				. mmw_lang_total_characters . ': ' . $total_characters . '<br>'
				. mmw_lang_total_banneds . ': ' . $total_banneds . '<br>'
				. mmw_lang_total_actives . ': ' . $actives_acc . '<br>'
				. mmw_lang_total_guilds . ': ' . $total_guilds . '<br>';
			return true;
	}

	return false;
}
/////// End Statisitcs ///////


/////// Start TOP List ///////
function top_list($what = null, $top = null)
{
	global $mmw;
	if (empty($what)) {
		$what = 'char';
	}
	if (empty($top)) {
		$top = '5';
	}
	$withoutGM = !empty($mmw['gm_show'])
		? ' WHERE CtlCode < 8'
		: '';

	echo '<table border="0" width="100%" cellspacing="0" cellpadding="0">';

	switch ($what) {
		case 'char':
			$isReset = false;
			$list = '';
			$index = 1;

			$query = mssql_query("SELECT TOP {$top} Name,cLevel,{$mmw['reset_column']} FROM dbo.Character {$withoutGM} ORDER BY {$mmw['reset_column']} desc, cLevel DESC");
			while($row = mssql_fetch_assoc($query)) {
				if (!empty($row[$mmw['reset_column']])) {
					$isReset = true;
				}
				$topResult = $isReset
					? '<span title="'. mmw_lang_level .': ' . $row['cLevel'] . '">' . $row[$mmw['reset_column']] . '</span>'
					: $row['cLevel'];
				$list .= '<tr><td>' . ($index++) . '</td><td><a href="?op=character&character=' . $row['Name'] . '">' . $row['Name'] . '</a></td><td align="center">' . $topResult . '</td></tr>';
			}
			echo '<tr><td width="14"><b>#</b></td><td><b>' . mmw_lang_character . '</b></td><td align="right" width="10"><b>' . ($isReset ? mmw_lang_reset : mmw_lang_level) . '</b></td></td></tr>' . $list;

			break;
		case 'pk':
			$query = mssql_query("SELECT TOP {$top} Name,PKcount FROM dbo.Character {$withoutGM} ORDER BY pkcount DESC");
			echo '<tr><td width="14"><b>#</b></td><td><b>' . mmw_lang_character . '</b></td><td align="right" width="10"><b>' . mmw_lang_killed . '</b></td></td></tr>';

			$index = 1;
			while ($row = mssql_fetch_assoc($query)) {
				echo '<tr><td>' . ($index++) . '</td><td><a href="?op=character&character=' . $row['Name'] . '">' . $row['Name'] . '</a></td><td align="center">' . $row['PKcount'] . '</td></tr>';
			}

			break;
		case 'guild':
			$query = mssql_query("SELECT TOP {$top} G_Name,G_Score FROM dbo.Guild WHERE G_Name!='{$mmw['gm_guild']}' ORDER BY G_score DESC");
			echo '<tr><td width="14"><b>#</b></td><td><b>' . mmw_lang_guild . '</b></td><td align="right" width="10"><b>' . mmw_lang_score . '</b></td></td></tr>';

			$index = 1;
			while ($row = mssql_fetch_assoc($query)) {
				echo '<tr><td>' . ($index++) . '</td><td><a href="?op=guild&guild=' . $row['G_Name'] . '">' . $row['G_Name'] . '</a></td><td align="center">' . $row['G_Score'] . '</td></tr>';
			}
			break;
		case 'ref':
			$query = mssql_query("SELECT TOP {$top} ref_acc,count(ref_acc) AS total FROM dbo.MEMB_INFO WHERE ref_acc<>'' GROUP BY ref_acc ORDER BY total DESC");
			echo '<tr><td width="14"><b>#</b></td><td><b>' . mmw_lang_account . '</b></td><td align="right" width="10"><b>' . mmw_lang_referral . '</b></td></td></tr>';

			$index = 1;
			while ($row = mssql_fetch_assoc($query)) {
				echo '<tr><td>' . ($index++) . '</td><td><a href="?op=profile&profile=' . $row['ref_acc'] . '">' . $row['ref_acc'] . '</a></td><td align="center">' . $row['total'] . '</td></tr>';
			}
			break;
		case 'best':
			$strongRow = mssql_fetch_assoc(mssql_query("SELECT TOP 1 Name FROM dbo.Character {$withoutGM} ORDER BY strength DESC, dexterity DESC, vitality DESC, energy DESC, Leadership DESC"));
			$strong = empty($strongRow['Name'])
				? '---'
				: '<a href="?op=character&character=' . $strongRow['Name'] . '">' . $strongRow['Name'] . '</a>';
			echo '<tr><td width="100%"><b>' . mmw_lang_very_strong . ': ' . $strong . '</b>';

			$withoutGMAnd = str_replace('WHERE', 'AND', $withoutGM);
			if (empty($mmw['characters_class'])) {
				$mmw['characters_class'] = 7;
			}
			for ($i = 0; $i < $mmw['characters_class']; $i++) {
				$class = $i * 16;
				$classRow = mssql_fetch_assoc(mssql_query("SELECT TOP 1 Name FROM dbo.Character WHERE (class BETWEEN $class AND " . ($class + 15) . ") {$withoutGMAnd} ORDER BY strength DESC, dexterity DESC, vitality DESC, energy DESC, Leadership DESC"));
				$strongClass = empty($classRow['Name'])
					? '---'
					: '<a href="?op=character&character=' . $classRow['Name'] . '">' . $classRow['Name'] . '</a>';
				echo '<br>&raquo; ' . char_class($class, 'full') . ': ' . $strongClass;
			}

			$gamerRow = mssql_fetch_assoc(mssql_query("SELECT TOP 1
					ms.memb___id,
					ac.GameIDC
				FROM dbo.MEMB_STAT AS ms
				LEFT JOIN dbo.AccountCharacter AS ac ON ac.Id COLLATE DATABASE_DEFAULT = ms.memb___id COLLATE DATABASE_DEFAULT
				WHERE ms.ConnectStat = '1' ORDER BY ms.ConnectTM"));
			$gamer = empty($gamerRow['GameIDC'])
				? '---'
				: '<a href="?op=character&character=' . $gamerRow['GameIDC'] . '">' . $gamerRow['GameIDC'] . '</a>';

			$guildRow = mssql_fetch_assoc(mssql_query("SELECT TOP 1 G_Name FROM dbo.Guild WHERE G_Name!='{$mmw['gm_guild']}' ORDER BY G_Score DESC"));
			$bestGuild = empty($guildRow['G_Name'])
				? '---'
				: '<a href="?op=guild&guild=' . $guildRow['G_Name'] . '">' . $guildRow['G_Name'] . '</a>';

			echo '<br><b>' . mmw_lang_best_gamer . ': ' . $gamer . '</b><br><b>' . mmw_lang_best_guild . ': ' . $bestGuild . '</b></td></tr>';
			break;
	}
	echo '</table>';
}
/////// End TOP List ///////


/////// Start Pop Under //////
/**
 * @deprecated Remove this code from template
 */
function popunder()
{
	echo '<!-- OLD ENGINE POPUNDER THEME OF MMW (need delete from theme "popunder($mmw[\'popunder\'],$mmw[\'popunder_check\']);") -->';
}
/////// End Pop Under ///////


/////// Start MP3 Player //////
function mp3_player()
{
	/** @noinspection PhpUnusedLocalVariableInspection */
	global $media_color, $text_color, $mmw;
	if ($mmw['mp3_player']) {
		require __DIR__ . '/../media/player.php';
	}
}
/////// End MP3 Player ///////


/////// Start MMW End //////
function end_mmw()
{
	global $mmw;
	$timeStart = unserialize(TIME_START);
	$timeEnd = gettimeofday();
	$execTime = ($timeEnd['sec'] + ($timeEnd['usec'] / 1000000)) - ($timeStart['sec'] + ($timeStart['usec'] / 1000000));
	echo 'MyMuWeb ' . $mmw['version'] . ' by Vaflan. Generation Time: ' . substr($execTime, 0, 5) . 's.';
}
/////// End MMW End ///////
