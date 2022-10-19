<?php
$searchType = array(
	'char' => mmw_lang_character,
	'acc' => mmw_lang_account,
	'guild' => mmw_lang_guild,
);
?>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<tr>
		<td>
			<form action="" method="post" name="search">
				<?php echo mmw_lang_search_type; ?>:
				<select name="search_type">
					<?php
					foreach ($searchType as $value => $label) {
						$selected = ($value === $_POST['search_type']) ? 'selected' : '';
						echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
					}
					?>
				</select>
				<?php echo mmw_lang_search; ?>:
				<input name="search" type="text" size="16" maxlength="10" value="<?php echo $_POST['search']; ?>">
				<input type="submit" value="<?php echo mmw_lang_show_now; ?>">
			</form>
		</td>
	</tr>
</table>

<?php echo $rowbr; ?>

<div style="text-align:center">
	<?php
	switch ($_POST['search_type']) {
		case 'guild':
			require_once 'modules/rankings/search_guild.php';
			break;
		case 'acc':
			require_once 'modules/rankings/search_acc.php';
			break;
		case 'char':
			require_once 'modules/rankings/search_char.php';
			break;
		default:
			break;
	}
	?>
</div>
