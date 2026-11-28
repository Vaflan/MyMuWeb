<?php
/**
 * @var string $die_start
 * @var string $die_end
 * @var string $rowbr
 */

if ($_GET['login'] === 'false') {
	echo $die_start . mmw_lang_acc_pass_incorrect . $die_end . $rowbr;
}
?>

<form action="" method="post" name="login_account">
	<table class="sort-table" style="margin:0 auto;border:0;padding:0;width:250px">
		<tr>
			<td style="width:100px;text-align:right"><?php echo mmw_lang_account; ?></td>
			<td>
				<input name="login" type="text" title="<?php echo mmw_lang_account; ?>" size="15" maxlength="10">
			</td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo mmw_lang_password; ?></td>
			<td>
				<input name="pass" type="password" title="<?php echo mmw_lang_password; ?>" size="15" maxlength="10">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;height:24px">
				<input type="submit" value="<?php echo mmw_lang_login; ?>" title="<?php echo mmw_lang_login; ?>">
				<input type="hidden" name="account_login" value="account_login">
			</td>
		</tr>
	</table>
</form>

<div style="text-align:center">
	<a href="?op=register"><?php echo mmw_lang_new_account; ?></a> ::
	<a href="?op=lostpass"><?php echo mmw_lang_lost_pass; ?></a>
</div>