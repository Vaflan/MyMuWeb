<?php
// This is modified Admin area For MyMuWeb Engine
// Creator =Master=, Edit by Vaflan

session_start();
header('Cache-Control: no-store, no-cache, must-revalidate');

/** @var array $mmw */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/sql_check.php';
require_once __DIR__ . '/../includes/xss_check.php';
require_once __DIR__ . '/../includes/functions.php';


// Start Login System
if (isset($_POST['admin_login'])) {
	$account = clean_var($_POST['account']);
	$password = clean_var($_POST['password']);
	$security = $_POST['security'];

	if (!empty($account) && !empty($password) && $security === $mmw['admin_security_code']) {
		$passwordValue = ($mmw['md5'])
			? "[dbo].[fn_md5]('{$password}', '{$account}')"
			: "'{$password}'";

		$row = mssql_fetch_assoc(mssql_query("SELECT memb___id, mmw_status FROM dbo.MEMB_INFO WHERE memb___id='{$account}' AND memb__pwd={$passwordValue}"));
		if ($row['memb___id'] === $account && $mmw['status_rules'][$row['mmw_status']]['admin_panel']) {
			$_SESSION['admin'] = array(
				'account' => $account,
				'password' => $password,
				'security' => $security,
				'level' => $row['mmw_status']
			);
			die("<script>alert('Welcome {$row['memb___id']}, Press Ok To Enter The Admin Control Panel!'); window.location='.';</script>");
		}
	}
	die("<script>alert('{$_SERVER['REMOTE_ADDR']} Ups!\\nUsername, Password or Security Code is Invalid!'); window.location='.';</script>");
}


// Check Login
if (isset($_SESSION['admin']['account'], $_SESSION['admin']['level'])) {
	$account = $_SESSION['admin']['account'];
	$password = $_SESSION['admin']['password'];
	$security = $_SESSION['admin']['security'];
	$level = $_SESSION['admin']['level'];

	$passwordValue = ($mmw['md5'])
		? "[dbo].[fn_md5]('{$password}', '{$account}')"
		: "'{$password}'";

	$checkRow = mssql_fetch_assoc(mssql_query("SELECT memb___id, mmw_status FROM dbo.MEMB_INFO WHERE memb___id='{$account}' AND memb__pwd={$passwordValue}"));

	if ($mmw['admin_security_code'] !== $security || $account !== $checkRow['memb___id'] || $level !== $checkRow['mmw_status'] || !$mmw['status_rules'][$level]['admin_panel']) {
		session_destroy();
		die("<script>alert('Dear {$_SERVER['REMOTE_ADDR']},\\nDon\\'t try to do the fucking things!'); window.location='{$mmw['serverwebsite']}';</script>");
	}
}


// Logout
if (isset($_REQUEST['logout'])) {
	session_destroy();
	die("<script>alert('You Have Logged Out From Your Admin Control Panel, Press Ok To Go To The Main WebSite!'); window.location='{$mmw['serverwebsite']}';</script>");
}


// Check admin file
if (substr($_SERVER['SCRIPT_FILENAME'], -15) != 'admin/index.php') {
	die($mmw['die']['start'] . '<b>Incorrect filename admin panel!</b><br>You should: admin/index.php' . $mmw['die']['end']);
}


// Check Admin Panel
if ($mmw['check_admin_panel']) {
	writelog('a_check_admin_panel', '<b>' . '//' . $_SERVER['SERVER_ADDR'] . urlencode($_SERVER['REQUEST_URI']) . '</b>');
}

$css = is_file('../themes/' . $mmw['theme'] . '/admin.css')
	? '../themes/' . $mmw['theme'] . '/admin.css'
	: 'assets/admin.css';
?>
<html lang="en">
<head>
	<title>MyMuWeb Administrator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>">
	<link href="<?php echo '../themes/' . $mmw['theme'] . '/favicon.ico'; ?>" rel="shortcut icon">
	<script>var mmw_version = '<?php echo $mmw['version'];?>';</script>
</head>
<body>
<div class="admin-area">
	<?php if (isset($_SESSION['admin']['account'])) : ?>
		<table style="width:800px;border:0;padding:0;margin:0 auto">
			<tr>
				<td class="login-stats" style="text-align:center">
					<div>
						<form action="" method="post" name="admin_logout">
							<?php echo $mmw['warning']['red']; ?> You are logged in
							<b><?php echo $_SESSION['admin']['login'] . ' ' . $mmw['status_rules'][$_SESSION['admin']['level']]['name'] . ' (Level: ' . $_SESSION['admin']['level'] . ')'; ?></b>
							<input name="logout" type="hidden" value="logout">
							<input type="submit" title="Logout" value="Logout">
						</form>
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;height:20px">
					<a href="?op=home">Home</a> |
					<a href="?op=sqlquery">SQL Query</a> |
					<a href="?op=backup">Back Up</a> |
					<a href="?op=server">Server</a> |
					<a href="?op=news">News</a> |
					<a href="?op=downloads">Downloads</a> |
					<a href="?op=votes">Votes</a> |
					<a href="?op=forum">Forum</a> |
					<a href="?op=ads">ADS</a> |
					<a href="?op=request">Request</a><br>
					<a href="?op=rename">Rename Character</a> |
					<a href="?op=char">Search Character</a> |
					<a href="?op=acc">Search Account</a> |
					<a href="?op=acclist">Account List</a> |
					<a href="?op=banip">Ban IP</a> |
					<a href="?op=findip">Find IP</a> |
					<a href="?op=logs">Logs</a>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;padding-top:10px">
					<?php
					if (is_file($_GET['op'] . '.php')) {
						include_once $_GET['op'] . '.php';
					} elseif (is_file($_GET['op'] . '.mmw')) {
						mmw($_GET['op'] . '.mmw');
					} else {
						include_once 'home.php';
					}
					?>
				</td>
			</tr>
		</table>
	<?php else : ?>
		<script>
			function check_admin_form() {
				if (document.admin_form.account.value === '') {
					alert('Please Enter Admin Username.');
					return false;
				}
				if (document.admin_form.password.value === '') {
					alert('Please Enter Admin Password.');
					return false;
				}
				if (document.admin_form.security.value === '') {
					alert('Please Enter Admin SecurityCode.');
					return false;
				}
				document.admin_form.submit();
			}
		</script>
		<div class="login-header"></div>
		<div style="text-align:center;padding:4px">
			<?php echo $mmw['warning']['red']; ?> Welcome <?php echo $_SERVER['REMOTE_ADDR']; ?>
		</div>
		<form action="" method="post" name="admin_form" id="admin_form">
			<table style="width:292px;border:0;margin:0 auto" cellpadding="0" cellspacing="4">
				<tr>
					<td style="text-align:right">Admin Account</td>
					<td style="width:144px"><input name="account" type="text" size="15" maxlength="10"></td>
				</tr>
				<tr>
					<td style="text-align:right">Admin Password</td>
					<td><input name="password" type="password" size="15" maxlength="10"></td>
				</tr>
				<tr>
					<td style="text-align:right">Admin SecurityCode</td>
					<td>
						<input name="security" type="password" size="8" maxlength="10">
						<input name="admin_login" type="hidden" id="admin_login" value="admin_login">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="submit" name="login" value="Login" onclick="return check_admin_form()">
						<input type="reset" value="Reset">
					</td>
				</tr>
			</table>
		</form>
	<?php endif; ?>
	<div class="copyright">MyMuWeb <?php echo $mmw['version']; ?>. Design and PHP+SQL by Vaflan.</div>
</div>
</body>
</html>