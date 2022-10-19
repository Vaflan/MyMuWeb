<?php
/**
 * @var string $die_start
 * @var string $die_end
 */

/** @deprecated Use $_SESSION['user'] */
$login = $_SESSION['user'];
/** @deprecated Use $_SESSION['user'] */
$account = $login;
/** @deprecated Use $_SESSION['character'] */
$char = $_SESSION['character'];
/** @deprecated Use $_SESSION['character'] */
$character = $char;

$acc_online_check = (int)@current(mssql_fetch_row(mssql_query("SELECT ConnectStat FROM dbo.MEMB_STAT WHERE memb___id='{$account}'")));

$userModule = preg_replace('/[^\w_-]/', '', $_GET['u']);
if (empty($userModule)) {
	require_once 'modules/user/acc.php';
} elseif (is_file('modules/user/' . $userModule . '.php')) {
	require_once 'modules/user/' . $userModule . '.php';
} elseif (is_file('modules/user/' . $userModule . '.mmw')) {
    mmw('modules/user/' . $userModule . '.mmw');
} else {
    echo $die_start . 'Empty Page, Go Back!' . $die_end;
}
