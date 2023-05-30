<?php
/** MyMuWeb Account menu
 * @var $mmw array
 * @var $accountInfo array
 * @var $setCharacter string
 * @var $rowbr string
 * @var $msg_full string
 * @var $msg_new_num int
 * @var $msg_num int
 */

$language = array(
	'hello' => mmw_lang_hello,
	'character_panel' => mmw_lang_character_panel,
	'mail' => mmw_lang_mail,
	'account_panel' => mmw_lang_account_panel,
	'ware_house' => mmw_lang_ware_house,
	'gm_options' => mmw_lang_gm_options,
	'logout' => mmw_lang_logout,
);



echo <<<HTML
		{$language['hello']} <b>{$accountInfo['name']}</b>!<br>
		{$rowbr}
		<img src="{$accountInfo['avatar']}" width="110" alt="Avatar"><br>
		{$rowbr}
HTML;


// Character Options
if (!empty($_SESSION['character'])) {
	echo <<<HTML
		{$setCharacter}<br>
		<a href="?op=user&u=char"><b>{$language['character_panel']}</b></a><br>
HTML;

	if ($mmw['inner_mail']) {
		echo <<<HTML
		<a href="?op=user&u=mail" id="upmess"><b>{$language['mail']} [{$msg_new_num}/{$msg_num}] {$msg_full}</b></a><br>
HTML;
	}
}


// Account Options
echo <<<HTML
		<a href="?op=user&u=acc"><b>{$language['account_panel']}</b></a><br>
		<a href="?op=user&u=wh"><b>{$language['ware_house']}</b></a><br>
HTML;


// GameMaster Options
if ($mmw['status_rules'][$_SESSION['mmw_status']]['gm_option'] == 1) {
	echo <<<HTML
		<a href="?op=user&u=gm"><b>{$language['gm_options']}</b></a><br>
HTML;
}


echo <<<HTML
		{$rowbr}
		<form action="" method="post" name="logout_account">
			<input type="hidden" name="logout" value="logout">
			<input type="submit" title="{$language['logout']}" value="{$language['logout']}">
		</form>
HTML;
