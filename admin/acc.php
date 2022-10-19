<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// Account Editor
if (isset($_POST['edit_account_done'])) {
	$post_account = stripslashes($_POST['edit_account_done']);
	$post_pwd = $_POST['new_pwd'];
	$post_mode = intval($_POST['mode']);
	$post_email = $_POST['email'];
	$post_secret_question = stripslashes($_POST['secret_question']);
	$post_secret_answer = stripslashes($_POST['secret_answer']);
	$post_unblock_time = intval($_POST['unblock_time']);
	$post_block_date = $_POST['block_date'];
	$post_block_reason = stripslashes($_POST['block_reason']);
	$post_admin_level = intval($_POST['admin_level']);

	$online_check = mssql_fetch_row(mssql_query("SELECT ConnectStat FROM dbo.MEMB_STAT WHERE memb___id='{$post_account}'"));
	if (empty($post_account) || empty($post_email) || empty($post_secret_question) || empty($post_secret_answer)) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} elseif ($online_check[0] != 0) {
		echo $mmw['warning']['red'] . 'Error: Account ' . $post_account . ' must be offline!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		$new_pass = $block_menu = '';
		if (!empty($post_unblock_time)) {
			$block_menu .= "[unblock_time]={$post_unblock_time},";
		}
		if ($post_block_date !== 'no') {
			$post_block_date = ($post_block_date === 'yes')
				? time()
				: 0;
			$block_menu .= "[block_date]='{$post_block_date}',[blocked_by]='{$_SESSION['admin']['account']}',";
		}
		$block_menu .= "[block_reason]='{$post_block_reason}',";

		if (!empty($post_pwd)) {
			$new_pass = ($mmw['md5'])
				? "[memb__pwd] = [dbo].[fn_md5]('{$post_pwd}', '{$post_account}'),"
				: "[memb__pwd] = '{$post_pwd}',";
		}

		mssql_query("UPDATE dbo.MEMB_INFO SET $new_pass $block_menu [bloc_code]='$post_mode',[mail_addr]='$post_email',[fpas_ques]='$post_secret_question',[fpas_answ]='$post_secret_answer',[mmw_status]='$post_admin_level' WHERE memb___id='{$post_account}'");
		echo $mmw['warning']['green'] . 'Account ' . $post_account . ' SuccessFully Edited!';
		writelog('edit_acc', "Account {$_POST['account']} Has Been <font color=#FF0000>Edited</font> with the next->New Password:$_POST[new_pwd]|E-mail:$_POST[email]|Secret Question:$_POST[secret_question]|Secret Answer:$_POST[secret_answer]|Admin Level:$_POST[admin_level]");
	}
}

if (isset($_POST['edit_acc_wh_done'])) {
	$post_account = stripslashes($_POST['edit_acc_wh_done']);
	$post_warehouse = preg_replace('/[^\d]+/', '', $_POST['wh']);
	$post_ext_warehouse = preg_replace('/[^\d]+/', '', $_POST['extrawh']);

	if (empty($post_account) || $post_warehouse < 0 || $post_ext_warehouse < 0) {
		echo $mmw['warning']['red'] . 'Error: Some Fields Were Left Blank!<br><a href="javascript:history.go(-1)">Go Back.</a>';
	} else {
		mssql_query("UPDATE dbo.warehouse SET [Money]={$post_warehouse},[extMoney]={$post_ext_warehouse} WHERE AccountID='{$post_account}'");
		echo $mmw['warning']['green'] . 'Acc Ware House ' . $post_account . ' SuccessFully Edited!';
		writelog('a_edit_acc_wh', 'Account <b>' . $post_account . '</b> Has Been <b style="color:#F00">Edited</b> with the next-> Extra WH: ' . $post_ext_warehouse . ' | WH: ' . $post_warehouse);
	}
}

if (isset($_GET['acc'])) {
	$account_edit = stripslashes($_GET['acc']);
	$get_account = mssql_query("SELECT
		mi.memb___id,
		mi.memb_name,
		mi.sno__numb,
		mi.bloc_code,
		mi.country,
		mi.gender,
		mi.mail_addr,
		mi.fpas_ques,
		mi.fpas_answ,
		mi.appl_days,
		mi.block_date,
		mi.unblock_time,
		mi.blocked_by,
		mi.block_reason,
		mi.mmw_status,
		ms.ConnectStat
		FROM dbo.MEMB_INFO AS mi
			LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = mi.memb___id
			WHERE mi.memb___id = '{$account_edit}'");
	$get_account_done = mssql_fetch_array($get_account);

	$mode = '<option value="0">Normal</option><option value="1">Blocked</option>';
	if ($get_account_done[3] == 1) {
		$mode = '<option value="1">Blocked</option><option value="0">Normal</option>';
	}

	if ($get_account_done[1] === null) {
		$get_account_done[1] = '<span style="background:red;color:white;border:1px solid black;">Error #111</span>';
	}
	if ($get_account_done[4] === null) {
		$get_account_done[4] = '<span style="background:red;color:white;border:1px solid black;">Error #112</span>';
	}
	if ($get_account_done[5] === null) {
		$get_account_done[5] = '<span style="background:red;color:white;border:1px solid black;">Error #113</span>';
	}
	if ($get_account_done[9] === null) {
		$get_account_done[9] = '<span style="background:red;color:white;border:1px solid black;">Error #114</span>';
	}

	$get_wh = mssql_query("SELECT AccountID,Money,extMoney FROM dbo.warehouse WHERE accountid='{$account_edit}'");
	$get_acc_wh = mssql_fetch_row($get_wh);
	$get_acc_wh_num = mssql_num_rows($get_wh);
	if (empty($get_acc_wh[1])) {
		$get_acc_wh[1] = 0;
	}
	if (empty($get_acc_wh[2])) {
		$get_acc_wh[2] = 0;
	}

	if ($get_account_done[5] === 'male') {
		$gender = 'Male';
	} elseif ($get_account_done[5] === 'female') {
		$gender = 'Female';
	}

	$get_chr = mssql_query("SELECT GameID1,GameID2,GameID3,GameID4,GameID5,GameIDC FROM dbo.AccountCharacter WHERE Id='{$account_edit}'");
	$get_acc_chr = mssql_fetch_row($get_chr);
	$online_stats = '<i style="color:#0F0">Online</i>';
	$offline_stats = '<i style="color:#F00">Offline</i>';

	for ($index = 0; $index < 5; $index++) {
		$get_acc_chr[$index] = trim($get_acc_chr[$index]);
		$get_acc_chr_online[$index] = ($get_acc_chr[$index] == $get_acc_chr[5] && $get_account_done['ConnectStat'])
			? $online_stats
			: $offline_stats;

		$get_acc_chr[$index] = !empty($get_acc_chr[$index])
			? "<a href='?op=char&chr=$get_acc_chr[$index]'>$get_acc_chr[$index]</a>"
			: '_ _ _';
	}
	?>
	<fieldset class="content">
		<legend>Account <?php echo $get_account_done[0]; ?></legend>
		<form action="" method="post" name="edit_account_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
				<tr>
					<td width="42%" align="right">Account</td>
					<td><a href="?op=acc&acc=<?php echo $get_account_done[0]; ?>"><?php echo $get_account_done[0]; ?></a></td>
				</tr>
				<tr>
					<td align="right">Name</td>
					<td><?php echo $get_account_done[1]; ?></td>
				</tr>
				<tr>
					<td align="right">Application day</td>
					<td><?php echo $get_account_done[9]; ?></td>
				</tr>
				<tr>
					<td align="right">New Password</td>
					<td>
					<span id="pswrd">
						<button style="font-size:10px;padding:0 6px"
								onclick="document.getElementById('pswrd').innerHTML='<input type=text name=new_pwd size=12 maxlength=10>';return false;">
							CHANGE
						</button>
					</span>
					</td>
				</tr>
				<tr>
					<td align="right">Mode</td>
					<td><select name="mode" size="1"><?php echo $mode; ?></select></td>
				</tr>
				<?php if ($get_account_done[3] == 1) : ?>
					<tr>
						<?php if ($get_account_done[11]) : ?>
							<td align="right">
								From <?php echo date('H:i, d.m.Y', $get_account_done[10]); ?>
							</td>
							<td>
								to <?php echo date('H:i, d.m.Y', $get_account_done[10] + $get_account_done[11]); ?>
							</td>
						<?php else: ?>
							<td></td>
							<td>Forever</td>
						<?php endif; ?>
					</tr>
				<?php endif; ?>
				<tr>
					<td align="right">Block Time</td>
					<td>
						<select name="unblock_time" size="1">
							<option value="0">Forever</option>
							<option value="1800">30 m</option>
							<option value="3600">1 h</option>
							<option value="21600">6 h</option>
							<option value="43200">12 h</option>
							<option value="86400">1 day</option>
							<option value="172800">2 day</option>
							<option value="259200">3 day</option>
							<option value="432000">5 day</option>
							<option value="864000">10 day</option>
							<option value="2592000">30 day</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Block Date</td>
					<td>
						<select name="block_date" size="1">
							<option value="0">Not Select Day</option>
							<?php if ($get_account_done[10]) : ?>
								<option value="no"><?php echo date('H:i, d.m.Y', $get_account_done[10]); ?></option>
							<?php endif; ?>
							<option value="yes">Today <?php echo date('H:i'); ?></option>
						</select>
					</td>
				</tr>
				<?php if (!empty($get_account_done[12]) && $get_account_done[12] != ' ') : ?>
					<tr>
						<td align="right">Blocked By</td>
						<td><span class="text_administrator"><?php echo $get_account_done[12]; ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td align="right">Block Reason</td>
					<td>
						<input type="text" name="block_reason" value="<?php echo $get_account_done[13]; ?>" size="17" maxlength="200">
					</td>
				</tr>
				<tr>
					<td align="right">E-mail address</td>
					<td>
						<input type="text" name="email" value="<?php echo $get_account_done[6]; ?>" size="17" maxlength="50">
					</td>
				</tr>
				<tr>
					<td align="right">Secret Question</td>
					<td>
						<input type="text" name="secret_question" value="<?php echo $get_account_done[7]; ?>" size="10" maxlength="50">
					</td>
				</tr>
				<tr>
					<td align="right">Secret Answer</td>
					<td>
						<input type="text" name="secret_answer" value="<?php echo $get_account_done[8]; ?>" size="10" maxlength="10">
					</td>
				</tr>
				<tr>
					<td align="right">Country</td>
					<td><span class="text_administrator"><?php echo country($get_account_done[4]); ?></td>
				</tr>
				<tr>
					<td align="right">Gender</td>
					<td><?php echo $gender; ?></td>
				</tr>
				<tr>
					<td align="right">Admin Level</td>
					<td>
						<select name="admin_level" size="1">
							<?php
							foreach ($mmw['status_rules'] as $id => $data) {
								$selected = ($get_account_done[14] == $id)
									? ' selected'
									: '';
								echo '<option value="' . $id . '"' . $selected . '>' . $data['name'] . '</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Edit Account">
						<input type="hidden" name="edit_account_done" value="<?php echo $get_account_done[0]; ?>">
						<input type="reset" value="Reset"></td>
				</tr>
			</table>
		</form>
	</fieldset>
	<?php if ($get_acc_wh_num > 0) : ?>
		<fieldset class="content">
			<legend>Ware House <?php echo $get_account_done[0]; ?></legend>
			<form action="" method="post">
				<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
					<tr>
						<td width="42%" align="right">Ware House</td>
						<td><input name="wh" type="text" value="<?php echo $get_acc_wh[1]; ?>" size="12" maxlength="10">
						</td>
					</tr>
					<tr>
						<td align="right">Extra Ware House</td>
						<td><input name="extrawh" type="text" value="<?php echo $get_acc_wh[2]; ?>" size="12"></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" value="Edit Ware House">
							<input type="hidden" name="edit_acc_wh_done" value="<?php echo $get_account_done[0]; ?>">
							<input type="reset" value="Reset">
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
	<?php endif; ?>
	<fieldset class="content">
		<legend>Character's <?php echo $get_account_done[0]; ?></legend>
		<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
			<tr>
				<td align="center"><?php echo $get_acc_chr[0]; ?></td>
				<td align="center"><?php echo $get_acc_chr[1]; ?></td>
				<td align="center"><?php echo $get_acc_chr[2]; ?></td>
				<td align="center"><?php echo $get_acc_chr[3]; ?></td>
				<td align="center"><?php echo $get_acc_chr[4]; ?></td>
			</tr>
			<tr>
				<td align="center"><?php echo $get_acc_chr_online[0]; ?></td>
				<td align="center"><?php echo $get_acc_chr_online[1]; ?></td>
				<td align="center"><?php echo $get_acc_chr_online[2]; ?></td>
				<td align="center"><?php echo $get_acc_chr_online[3]; ?></td>
				<td align="center"><?php echo $get_acc_chr_online[4]; ?></td>
			</tr>
		</table>
	</fieldset>
<?php } ?>

	<fieldset class="content">
		<legend>Search Account</legend>
		<form action="" method="post">
			<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
				<tr>
					<td width="42%" align="right">Account</td>
					<td>
						<input name="search_account" type="text" size="17" maxlength="10">
					</td>
				</tr>
				<tr>
					<td align="right">Search type</td>
					<td>
						<label>
							<input type="radio" name="search_type" value="1" checked>
							<span class="normal_text">Partial Match</span></label>
						<br>
						<label>
							<input type="radio" name="search_type" value="0">
							<span class="normal_text">Exact Match</span></label>
						<br></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Search Account">
					</td>
				</tr>
			</table>
		</form>
	</fieldset>

<?php if (isset($_POST['search_account'])) : ?>
	<fieldset class="content">
		<legend>Search Account Results</legend>

		<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
			<thead>
			<tr>
				<td align="center">#</td>
				<td>Account</td>
				<td>Mode</td>
				<td>Country</td>
				<td>Gender</td>
				<td align="center">Status</td>
				<td align="center">Edit</td>
			</tr>
			</thead>
			<?php
			$search = clean_var(stripslashes($_POST['search_account']));

			$queryBuildWhere = !empty($_POST['search_type'])
				? "LIKE '%{$search}%'"
				: "= '{$search}'";
			$result = mssql_query("SELECT
				mi.memb___id,mi.memb__pwd,mi.bloc_code,mi.country,mi.gender,ms.ConnectStat
				FROM dbo.MEMB_INFO AS mi
				LEFT JOIN dbo.MEMB_STAT AS ms ON ms.memb___id = mi.memb___id
					WHERE mi.memb___id {$queryBuildWhere}");

			$rank = 1;
			while ($row = mssql_fetch_row($result)) {
				if ($row[5] == 0) {
					$status = '<img src="../images/offline.gif" alt="offline">';
				}
				if ($row[5] == 1) {
					$status = '<img src="../images/online.gif" alt="online">';
				}
				if ($row[5] === null) {
					$status = '<img src="../images/death.gif" alt="death">';
				}

				if ($row[2] == 0) {
					$row[2] = 'Normal';
				}
				if ($row[2] == 1) {
					$row[2] = '<span style="background:yellow;color:black;border:1px solid black;">Blocked</span>';
				}

				if ($row[4] === 'male') {
					$row[4] = '<img src="../images/male.gif" alt="male">';
				} elseif ($row[4] === 'female') {
					$row[4] = '<img src="../images/female.gif" alt="female">';
				} elseif ($row[4] === null) {
					$row[4] = '<span style="background:red;color:white;border:1px solid black;">Error #113</span>';
				}

				if ($row[3] === null) {
					$row[3] = '<span style="background:red;color:white;border:1px solid black;">Error #112</span>';
				}
				if ($row[1] === null) {
					$row[1] = '<span style="background:red;color:white;border:1px solid black;">Error #111</span>';
				}

				if ($row[3] == '0') {
					$country = 'Not Set';
				} else {
					$country = country($row[3]);
				}
				?>
				<tr>
					<td align="center"><?php echo $rank++; ?>.</td>
					<td><a href=?op=acc&acc=<?php echo $row[0]; ?>><?php echo $row[0]; ?></a></td>
					<td><?php echo $row[2]; ?></td>
					<td><?php echo $country; ?></td>
					<td><?php echo $row[4]; ?></td>
					<td align="center"><?php echo $status; ?></td>
					<td align="center">
						<form action="" method="get">
							<input type="hidden" name="op" value="acc">
							<input type="hidden" name="acc" value="<?php echo $row[0]; ?>">
							<input type="submit" value="Edit">
						</form>
					</td>
				</tr>
			<?php } ?>
		</table>

	</fieldset>
<?php endif; ?>