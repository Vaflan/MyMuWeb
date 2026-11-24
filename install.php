<?php
define('CUSTOM_IP_ADDRESS', '192.168.0.101', false);

/** @var array $mmw */
require_once __DIR__ . '/config.php';
$page = intval($_GET['page']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>MyMuWeb <?php echo $mmw['version']; ?> Install by Vaflan</title>
	<style type="text/css">.buttonFlow {position: absolute; bottom: 0;}</style>
	<link href="themes/default/favicon.ico" rel="shortcut icon">
</head>
<body>
<?php echo $mmw['die']['start']; ?>

<?php if (!in_array($_SERVER['REMOTE_ADDR'], array(CUSTOM_IP_ADDRESS, '127.0.0.1', $_SERVER['SERVER_ADDR']))) : ?>
	<!-- Access deny -->
	Install only For IP: 127.0.0.1 or LocalHost<br>
	<a href="//127.0.0.1/install.php">Go To Normal Install</a>
	<?php die($mmw['die']['end'] . '</body></html>'); endif; ?>

<?php if ($page < 2) : ?>
	<small>Install page 1</small><br>
	<b>Welcome to installer MMW <?php echo $mmw['version']; ?>!</b><br>
	Next page you install tables and columns<br>
	<?php if (file_exists('includes/installed.php')) : ?>
		<span style="color: red">
		<b>WARNING!</b><br>
		The site has already been installed.
	</span><br>
	<?php endif; ?>
	<div class="buttonFlow">
		<button onclick="window.location.href='?page=2'">Next &#8594;</button>
		<button onclick="window.location.href='/'">Cancel &#215;</button>
	</div>

<?php elseif ($page === 2) : ?>
	<small>Install page 2</small><br>
	<?php
	$md5Selector[$mmw['md5']] = ' selected';
	$columnDataType = @current(mssql_fetch_row(mssql_query("SELECT data_type FROM information_schema.columns WHERE table_name='MEMB_INFO' AND column_name='memb__pwd'")));
	$md5Info = ($columnDataType === 'varbinary')
		? array('Database uses MD5 column!', 'Yes')
		: array('Database does not support MD5!', 'No');
	?>
	<form name="set_md5" method="post" action="?page=3">
		<label>
			Change database COLLATE
			<select name="collate" title="Set COLLATE" style="margin:0;padding:0;">
				<option value="false">No</option>
				<option value="true">Yes</option>
			</select>
		</label><br>
		<label>
			In "config.php" Now MD5:
			<select name="md5" title="Set MD5 Option" style="margin:0;padding:0;">
				<option value="false"<?php echo $md5Selector[false]; ?>>No</option>
				<option value="true"<?php echo $md5Selector[true]; ?>>Yes</option>
			</select>
		</label><br>
		<b style="color:red;"><?php echo $md5Info[0]; ?></b><br>
		Please Choose MD5 - <?php echo $md5Info[1]; ?>.
		<div class="buttonFlow">
			<button type="submit">Next &#8594;</button>
		</div>
	</form>

<?php elseif ($page === 3) : ?>
	<small>Install page 3</small><br>

	<?php
	if (($_POST['md5'] === 'true' && !$mmw['md5']) || ($_POST['md5'] === 'false' && $mmw['md5'])) {
		$configFile = 'config.php';
		$configData = file_get_contents($configFile);
		$configData = preg_replace('/\$mmw\[\'md5\'] = (true|false);/', "\$mmw['md5'] = {$_POST['md5']};", $configData);
		file_put_contents($configFile, $configData);
		$mmw['md5'] = $_POST['md5'];
	}
	@file_put_contents('includes/installed.php', "<?php\n// MyMuWeb Installed Date\n\$mmw['installed'] = '" . time() . "';\n");
	?>
	<b>Tables and columns install end!</b>
	[<a href="#" onclick="document.getElementById('install_log').style.display=''">Show</a>]<br>
	On the next page you can choose the site administrator<br>
	<div class="buttonFlow">
		<button onclick="window.location.href='?page=4'">Next &#8594;</button>
	</div>
	<?php $withoutEnd = true;
	echo $mmw['die']['end']; ?>
	<div id="install_log" style="display:none;margin:0 auto;width:300px;">
		<label>
		<textarea cols="120" style="width:100%;height:120px;margin-left:-4px;">
	<?php
	$queryList = array();

	if ($_POST['collate'] === 'true') {
		// DECODE DATABASE
		$queryList['decode_database'] = array(
			"ALTER DATABASE {$mmw['sql']['database']} SET SINGLE_USER WITH ROLLBACK IMMEDIATE",
			"ALTER DATABASE {$mmw['sql']['database']} COLLATE SQL_Latin1_General_CP1_CI_AS",
			"ALTER DATABASE {$mmw['sql']['database']} SET MULTI_USER"
		);
	}

	// CREAT TABLES
	$queryList['load_db_mmw'] = @file_get_contents('includes/db_mmw.sql');

	// INSERT INTO TABLES
	$queryList['add_news'] = "INSERT INTO MMW_news(news_title,news_autor,news_category,news_date,news_row_1,news_row_2,news_id) VALUES ('MyMuWeb " . $mmw['version'] . " by Vaflan','Vaflan','NEWS','" . time() . "','[color=red]This Is MyMuWeb " . $mmw['version'] . " By Vaflan.[/color][br]If you see news, Your site works.[br][i]Thanks For the Use of MyMuWeb![/i]','[color=green]Этот MyMuWeb " . $mmw['version'] . " От Vaflan.[/color][br]Если ты видишь новость, Твой Сайт Работает.[br][i]Спасибо За Использование MyMuWeb![/i]','MyMuWeb')";
	$queryList['add_server'] = "INSERT INTO MMW_servers(name,experience,drops,gsport,ip,display_order,version,type,maxplayer) VALUES ('Server 100x','100x','30%','55901','127.0.0.1','1','1.04.05','Non-PVP','1000')";
	$queryList['add_link'] = "INSERT INTO MMW_links(l_name,l_address,l_description,l_id,l_size,l_date) VALUES ('MuOnline Media Main','media/main.mp3','This Is Test Link','MyMuWeb','1,13 MB','" . time() . "')";

	// ADD COLUMNS
	$queryList['add_column'] = array(
		"ALTER TABLE MEMB_INFO ADD country int not null default 0",
		"ALTER TABLE MEMB_INFO ADD gender varchar(10)",
		"ALTER TABLE MEMB_INFO ADD age int not null default 0",
		"ALTER TABLE MEMB_INFO ADD y varchar(100)",
		"ALTER TABLE MEMB_INFO ADD msn varchar(100)",
		"ALTER TABLE MEMB_INFO ADD icq varchar(100)",
		"ALTER TABLE MEMB_INFO ADD skype varchar(100)",
		"ALTER TABLE MEMB_INFO ADD avatar varchar(100)",
		"ALTER TABLE MEMB_INFO ADD hide_profile int not null default 0",
		"ALTER TABLE MEMB_INFO ADD ref_acc varchar(10)",
		"ALTER TABLE MEMB_INFO ADD ref_check int not null default 0",
		"ALTER TABLE MEMB_INFO ADD block_date int not null default 0",
		"ALTER TABLE MEMB_INFO ADD blocked_by varchar(100)",
		"ALTER TABLE MEMB_INFO ADD unblock_time int not null default 0",
		"ALTER TABLE MEMB_INFO ADD block_reason nvarchar(100)",
		"ALTER TABLE MEMB_INFO ADD ip nvarchar(15)",
		"ALTER TABLE MEMB_INFO ADD mmw_status int not null default 0",
		"ALTER TABLE MEMB_INFO ADD mmw_coin int not null default 0",
		"ALTER TABLE warehouse ADD extMoney bigint null default 0",
		"ALTER TABLE Character ADD {$mmw['reset_column']} int not null default 0",
		"ALTER TABLE Character ADD Leadership int not null default 0",
		"ALTER TABLE Guild ADD G_Union int not null default 0",
		"ALTER TABLE GuildMember ADD G_Status tinyint not null default 0",
	);

	// CHANGE COLUMN DATA TYPE
	$queryList['change_column'] = array(
		"ALTER TABLE MEMB_INFO ALTER COLUMN gender varchar(10)",
		"ALTER TABLE warehouse ALTER COLUMN extMoney bigint not null"
	);


	/* Install DataBase */
	echo 'Installation start' . PHP_EOL;

	$selectedDatabase = mssql_query('USE ' . $mmw['sql']['database']);
	echo $selectedDatabase
		? 'use_' . $mmw['sql']['database'] . ' - Done!' . PHP_EOL
		: 'use_' . $mmw['sql']['database'] . ' - Error!' . PHP_EOL;

	if ($selectedDatabase) {
		foreach ($queryList as $queryName => $query) {
			try {
				if (is_array($query)) {
					foreach ($query as $i => $singleQuery) {
						echo mssql_query($singleQuery)
							? $queryName . '_' . $i . ' - Done!' . PHP_EOL
							: $queryName . '_' . $i . ' - Error!' . PHP_EOL;
					}
				} else {
					echo mssql_query($query)
						? $queryName . ' - Done!' . PHP_EOL
						: $queryName . ' - Error!' . PHP_EOL;
				}
			} catch (Exception $exception) {
				echo $exception . PHP_EOL;
			}
			echo ' -----' . PHP_EOL;
		}

		if ($mmw['md5']) {
			$md5_encrypt_create = <<<SQL
CREATE FUNCTION [dbo].[fn_md5] (@data VARCHAR(10), @data2 VARCHAR(10))
RETURNS BINARY(16) AS
BEGIN
	DECLARE @hash BINARY(16)
	EXEC master.dbo.XP_MD5_EncodeKeyVal @data, @data2, @hash OUT
	RETURN @hash
END
SQL;
			echo mssql_query($md5_encrypt_create)
				? 'md5_encrypt_create - Done!' . PHP_EOL
				: 'md5_encrypt_create - Error!' . PHP_EOL;
			echo mssql_query("USE [master]")
				? 'use_master - Done!' . PHP_EOL
				: 'use_master - Error!' . PHP_EOL;
			echo mssql_query("EXEC sp_addextendedproc 'XP_MD5_EncodeKeyVal', 'WZ_MD5_MOD.dll'")
				? 'exec_md5_dll - Done!' . PHP_EOL
				: 'exec_md5_dll - Error!' . PHP_EOL;
			echo ' -----' . PHP_EOL;

			echo mssql_query('USE ' . $mmw['sql']['database'])
				? 'use_' . $mmw['sql']['database'] . ' - Done!' . PHP_EOL
				: 'use_' . $mmw['sql']['database'] . ' - Error!' . PHP_EOL;
			echo ' -----' . PHP_EOL;
		}

		echo '    Finished!';
	}
	?>
		</textarea>
		</label><br>
		[<a href="#" onclick="document.getElementById('install_log').style.display='none'">Close</a>]
	</div>

<?php elseif ($page == 4) : ?>
	<small>Install page 4</small><br>

	<b>Select user for admin!</b><br>
	<form name="admin" method="post" action="?page=5">
		<label>
			<select name="user">
				<option value="">Please select</option>
				<option value="reg">Need register</option>
				<?php
				$query = mssql_query("SELECT memb___id FROM dbo.MEMB_INFO");
				while ($row = mssql_fetch_array($query)) {
					echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
				}
				?>
			</select>
		</label>
		<div class="buttonFlow">
			<button type="submit">Next &#8594;</button>
		</div>
	</form>

<?php elseif ($page == 5) : ?>
	<small>Install page 5</small><br>
	<?php
	$account = $_POST['user'];
	?>

	<?php if (empty($account)) : ?>
		<b>User not selected!</b><br>
		If you need Admin, go back<br>
		<div class="buttonFlow">
			<button onclick="window.location.href='?page=4'">Back &#8592;</button>
			<button onclick="window.location.href='/'">Cancel &#215;</button>
		</div>
	<?php elseif ($account === 'reg') : ?>
		<form name="admin" method="post" action="">
			<label style="margin:4px 0;display:block;">
				Account:
				<input name="user" type="text" size="12" maxlength="10" value="">
			</label>
			<label>
				Password:
				<input name="pass" type="text" size="12" maxlength="10" value="">
			</label>
			<div class="buttonFlow">
				<button type="submit">Create account</button>
			</div>
		</form>
	<?php else : ?>
		<?php
		if (isset($_POST['pass'])) {
			$passwordQuery = ($mmw['md5'])
				? "[dbo].[fn_md5]('{$_POST['pass']}', '{$account}')"
				: "'{$_POST['pass']}'";
			mssql_query("INSERT INTO dbo.MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,mail_addr,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,fpas_ques,fpas_answ,country,gender,hide_profile,ref_acc) VALUES ('{$account}',{$passwordQuery},'Admin','1234','admin@mymuweb.ru',GETDATE(),GETDATE(),'2008-12-20','2008-12-20','1','0','0','WhoYouAre','admin','0','male','0','0')");
		}
		mssql_query("UPDATE dbo.MEMB_INFO SET [mmw_status]=10 WHERE memb___id='{$account}'");
		?>
		<b>Admin created!</b><br>
		Now <i><?php echo $account; ?></i> is the admin in the MyMuWeb<br>
		<div class="buttonFlow">
			<button onclick="window.location.href='/'">Go to main page</button>
		</div>
	<?php endif; ?>

<?php else : ?>
	Complete mistake!
<?php endif; ?>

<?php if (empty($withoutEnd)) echo $mmw['die']['end']; ?>
</body>
</html>