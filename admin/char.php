<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Character Editor
if (isset($_POST['edit_character_done'])) {
	$post_character = stripslashes($_POST['edit_character_done']);
	$post_level = $_POST['level'];
	$post_reset = $_POST['reset'];
	$post_zen = $_POST['zen'];
	$post_gm = $_POST['gm'];
	$post_strength = $_POST['strength'];
	$post_agility = $_POST['agility'];
	$post_vitality = $_POST['vitality'];
	$post_energy = $_POST['energy'];
	$post_command = $_POST['command'];
	$post_leveluppoint = $_POST['leveluppoint'];
	$post_pklevel = $_POST['pklevel'];
	$post_pktime = $_POST['pktime'];
	$post_mapnumber = $_POST['mapnumber'];
	$post_mapposx = $_POST['mapposx'];
	$post_mapposy = $_POST['mapposy'];
	$post_class = $_POST['class'];

	$get_account = mssql_query("SELECT accountid,Name FROM dbo.Character WHERE Name='{$post_character}'");
	$get_account_done = mssql_fetch_row($get_account);

	$online_check = mssql_query("SELECT
		ConnectStat,
		GameIDC
			FROM dbo.MEMB_STAT
			LEFT JOIN dbo.AccountCharacter ON Id COLLATE DATABASE_DEFAULT = memb___id COLLATE DATABASE_DEFAULT
			WHERE memb___id='{$get_account_done[0]}'");
	$oc_row = mssql_fetch_row($online_check);

	if (empty($post_character) || empty($post_level) || empty($post_strength) || empty($post_agility) || empty($post_vitality) || empty($post_energy)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif ($oc_row[0] != 0 && $oc_row[2] == $get_account_done[1]) {
		echo $mmw['warning']['red'] . 'Error: Character Must Be Logged Off!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_level)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Level!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_reset)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Reset!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_zen)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Zen!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_leveluppoint)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Level Up Point!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_pklevel)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At PK Level!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_pktime)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At PK Time!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_mapnumber)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Map Number!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_mapposx)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Map x!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif (!preg_match('/\d+/', $post_mapposy)) {
		echo $mmw['warning']['red'] . 'Error: Please Use Only Numbers At Map y!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("UPDATE dbo.Character SET [clevel]='$post_level',[{$mmw['reset_column']}]='$post_reset',[money]='$post_zen',[CtlCode]='$post_gm',[strength]='$post_strength',[dexterity]='$post_agility',[vitality]='$post_vitality',[energy]='$post_energy',[leadership]='$post_command',[LevelUpPoint]='$post_leveluppoint',[PkLevel]='$post_pklevel',[PkTime]='$post_pktime',[mapnumber]='$post_mapnumber',[mapposx]='$post_mapposx',[mapposy]='$post_mapposy',[class]='$post_class' WHERE Name='{$post_character}'");
		echo $mmw['warning']['green'] . 'Character ' . $post_character . ' SuccessFully Edited!';
		writelog('a_edit_char', "Character {$_POST['character']} Has Been <b style=\"color:#F00\">Edited</b> with the next->Level:$_POST[level]|Reset:$_POST[reset]|Zen:$_POST[zen]|Strengh:$_POST[strength]|Agiltiy:$_POST[agility]|Vitality:$_POST[vitality]|Energy:$_POST[energy]|Command:$_POST[command]|LevelUpPoint:$_POST[leveluppoint]|ResTime:$_POST[restime]|PkLevel:$_POST[pklevel]|PkTime:$_POST[pktime]|MapNumber:$_POST[mapnumber]|MapX:$_POST[mapposx]|Mapy:$_POST[mapposy]");
	}
}

if (isset($_GET['chr'])) {
	$character_edit = stripslashes($_GET['chr']);
	$get_character = mssql_query("SELECT accountid,clevel,{$mmw['reset_column']},money,strength,dexterity,vitality,energy,leadership,CtlCode,LevelUpPoint,PkLevel,PkTime,mapnumber,mapposx,mapposy,Class FROM dbo.Character WHERE Name='{$character_edit}'");
	$get_character_done = mssql_fetch_row($get_character);

	$mode[$get_character_done[9]] = 'selected';
	$class[$get_character_done[16]] = 'selected';

	$online_check = mssql_query("SELECT
		ConnectStat,
		GameIDC
			FROM dbo.MEMB_STAT
			LEFT JOIN dbo.AccountCharacter ON Id COLLATE DATABASE_DEFAULT = memb___id COLLATE DATABASE_DEFAULT
			WHERE memb___id='{$get_character_done[0]}'");
	$oc_row = mssql_fetch_row($online_check);

	$acc_status = ($oc_row[0] == '1')
		? '<span style="color:#0F0">Online</span>'
		: '<span style="color:#F00">Offline</span>';
	$character_status = ($oc_row[0] == '1' && $oc_row[1] == $character_edit)
		? '<span style="color:#0F0">Online</span>'
		: '<span style="color:#F00">Offline</span>';
	?>
<fieldset class="content">
	<legend>Character <?php echo $get_character_done[0]; ?></legend>
	<form action="" method="post" name="edit_character_form">
		<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			<tr>
				<td width="42%" align="right">Account</td>
				<td>
					<a href="?op=acc&acc=<?php echo $get_character_done[0]; ?>"><?php echo $get_character_done[0]; ?></a>
					<?php echo $acc_status; ?>
				</td>
			</tr>
			<tr>
				<td align="right">Character</td>
				<td><?php echo $character_edit; ?> <?php echo $character_status; ?></td>
			</tr>
			<tr>
				<td align="right">Level</td>
				<td>
					<input type="text" name="level" value="<?php echo $get_character_done[1]; ?>" maxlength="3" size="3">
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo $mmw['reset_column']; ?></td>
				<td>
					<input type="text" name="reset" value="<?php echo $get_character_done[2]; ?>" maxlength="3" size="3">
				</td>
			</tr>
			<tr>
				<td align="right">Level Up Point</td>
				<td>
					<input type="text" name="leveluppoint" value="<?php echo $get_character_done[10]; ?>" maxlength="5" size="5">
				</td>
			</tr>
			<tr>
				<td align="right">Zen</td>
				<td>
					<input type="text" name="zen" value="<?php echo $get_character_done[3]; ?>" maxlength="10" size="12">
				</td>
			</tr>
			<tr>
				<td align="right">Class</td>
				<td>
					<select name="class" size="1">
						<option value=<?php echo $get_character_done[16]; ?>>
							undefined: [<?php echo $get_character_done[16]; ?>]
						</option>
						<?php for ($classGroup=0; $classGroup<$mmw['characters_class']; $classGroup++) : ?>
							<?php $classLevel = $classGroup * 16; ?>
							<option value=<?php echo $classLevel; ?> <?php echo $class[$classLevel]; ?>>
								<?php echo char_class($classLevel) . ' [' . $classLevel . ']'; ?>
							</option>
							<?php if (char_class($classLevel + 1, 'level')) : ?>
							<option value=<?php echo $classLevel + 1; ?> <?php echo $class[$classLevel + 1]; ?>>
								<?php echo char_class($classLevel + 1) . ' [' . ($classLevel + 1) . ']'; ?>
							</option>
							<?php endif; ?>
							<option value=<?php echo $classLevel + 3; ?> <?php echo $class[$classLevel + 3]; ?>>
								<?php echo char_class($classLevel + 3) . ' [' . ($classLevel + 3) . ']'; ?>
							</option>
							<option value=<?php echo $classLevel + 7; ?> <?php echo $class[$classLevel + 7]; ?>>
								<?php echo char_class($classLevel + 7) . ' [' . ($classLevel + 7) . ']'; ?>
							</option>
						<?php endfor; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">Mode</td>
				<td><select name="gm" size="1">
						<option value=0 <?php echo $mode[0]; ?>><?php echo ctlCode(0); ?></option>
						<option value=1 <?php echo $mode[1]; ?>><?php echo ctlCode(1); ?></option>
						<option value=8 <?php echo $mode[8]; ?>><?php echo ctlCode(8); ?></option>
						<option value=32 <?php echo $mode[32]; ?>><?php echo ctlCode(32); ?></option>
					</select></td>
			</tr>
			<tr>
				<td align="right">Strength</td>
				<td>
					<input type="text" name="strength" value="<?php echo $get_character_done[4]; ?>" maxlength="5" size="5">
				</td>
			</tr>
			<tr>
				<td align="right">Agility</td>
				<td>
					<input type="text" name="agility" value="<?php echo $get_character_done[5]; ?>" maxlength="5" size="5">
				</td>
			</tr>
			<tr>
				<td align="right">Vitality</td>
				<td>
					<input type="text" name="vitality" value="<?php echo $get_character_done[6]; ?>" maxlength="5" size="5">
				</td>
			</tr>
			<tr>
				<td align="right">Energy</td>
				<td>
					<input type="text" name="energy" value="<?php echo $get_character_done[7]; ?>" maxlength="5" size="5">
				</td>
			</tr>
			<tr>
				<td align="right">Command</td>
				<td>
					<input type="text" name="command" value="<?php echo $get_character_done[8]; ?>" maxlength="5" size="5">
				</td>
			</tr>
			<tr>
				<td align="right">Pk Level, Time</td>
				<td>
					<input type="text" name="pklevel" value="<?php echo $get_character_done[11]; ?>" maxlength="2" size="2">
					<input type="text" name="pktime" value="<?php echo $get_character_done[12]; ?>" maxlength="3" size="3">
				</td>
			</tr>
			<tr>
				<td align="right">Map, x, y</td>
				<td><input type="text" name="mapnumber" value="<?php echo $get_character_done[13]; ?>" maxlength="2" size="2">
					<input type="text" name="mapposx" value="<?php echo $get_character_done[14]; ?>" maxlength="3" size="3">
					<input type="text" name="mapposy" value="<?php echo $get_character_done[15]; ?>" maxlength="3" size="3">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Edit Character">
					<input type="hidden" name="edit_character_done" value="<?php echo $character_edit; ?>">
					<input type="reset" value="Reset"></td>
			</tr>
		</table>
	</form>
	</fieldset>
<?php } ?>

	<fieldset class="content">
	<legend>Search Character</legend>
	<form action="" method="post">
		<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			<tr>
				<td width="42%" align="right">Character</td>
				<td><input type="text" name="search_character" size="17" maxlength="10"></td>
			</tr>
			<tr>
				<td align="right">Search type</td>
				<td>
					<label>
						<input type="radio" name="search_type" value="1" checked>
						<span class="normal_text">Partial Match</span>
					</label>
					<br>
					<label>
						<input type="radio" name="search_type" value="0">
						<span class="normal_text">Exact Match</span>
					</label>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Search Character">
				</td>
			</tr>
		</table>
	</form>
	</fieldset>

<?php if (isset($_POST['search_character'])) : ?>
	<fieldset class="content">
		<legend>Search Character Result</legend>

		<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
			<thead>
			<tr>
				<td align="center">#</td>
				<td>Name</td>
				<td>Account</td>
				<td>Mode</td>
				<td>Reset / Level</td>
				<td>Class</td>
				<td align="center">Status</td>
				<td align="center">Edit</td>
			</tr>
			</thead>
			<?php
			$search = clean_var(stripslashes($_POST['search_character']));
			$search_type = $_POST['search_type'];

			$queryBuildWhere = !empty($_POST['search_type'])
				? "LIKE '%{$search}%'"
				: "= '{$search}'";
			$result = mssql_query("SELECT Name,Class,cLevel,{$mmw['reset_column']},strength,dexterity,vitality,energy,accountid,CtlCode FROM dbo.Character WHERE Name {$queryBuildWhere}");

			$rank = 1;
			while ($row = mssql_fetch_row($result)) {
				$status_result = mssql_query("SELECT ConnectStat FROM dbo.MEMB_STAT WHERE memb___id='{$row[8]}'");
				$status = mssql_fetch_row($status_result);

				if ($status[0] == 0) {
					$status = '<img src="../images/offline.gif" alt="offline">';
				}
				if ($status[0] == 1) {
					$status = '<img src="../images/online.gif" alt="online">';
				}
				if ($status[0] === null) {
					$status = '<img src="../images/death.gif" alt="death">';
				}

				if ($row[9] == 1) {
					$row[9] = '<span style="background:yellow;color:black;border:1px solid black;">Blocked</span>';
				} elseif ($row[9] == 32 || $row[9] == 8) {
					$row[9] = '<span style="background:blue;color:white;border:1px solid black;">GM</span>';
				} elseif ($row[9] == 0) {
					$row[9] = 'Normal';
				}
				?>
				<tr>
					<td align="center"><?php echo $rank++; ?>.</td>
					<td><a href="?op=char&chr=<?php echo $row[0]; ?>"><?php echo $row[0]; ?></a></td>
					<td><a href="?op=acc&acc=<?php echo $row[8]; ?>"><?php echo $row[8]; ?></a></td>
					<td><?php echo $row[9]; ?></td>
					<td><?php echo $row[3] . ' / ' . $row[2]; ?></td>
					<td><?php echo char_class($row[1]); ?></td>
					<td align="center"><?php echo $status; ?></td>
					<td align="center">
						<form action="" method="get">
							<input type="submit" value="Rename">
							<input type="hidden" name="op" value="rename">
							<input type="hidden" name="name" value="<?php echo $row[0]; ?>">
						</form>
						<form action="" method="get">
							<input type="submit" value="Edit">
							<input type="hidden" name="op" value="char">
							<input type="hidden" name="chr" value="<?php echo $row[0]; ?>">
						</form>
					</td>
				</tr>
			<?php } ?>
		</table>

	</fieldset>
<?php endif; ?>