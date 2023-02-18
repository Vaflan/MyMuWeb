<?php
if (isset($_GET['sort'])) {
	$_POST['sort'] = $_GET['sort'];
}
if (empty($_POST['sort'])) {
	$_POST['sort'] = 'all';
}
if (empty($_POST['top_rank'])) {
	$_POST['top_rank'] = 100;
}

$topCount = array(10, 25, 50, 100);

$topRank = array(
	'all' => mmw_lang_all_characters,
	'pk' => mmw_lang_all_killers,
	'guild' => mmw_lang_all_guilds,
	'online' => mmw_lang_online_characters,
);

if ($mmw['gens']) {
	$topRank['gens'] = 'Durpian vs Vanert';
}

for ($classGroup=0; $classGroup<$mmw['characters_class']; $classGroup++) {
	$classLevel = $classGroup * 16;
	$class = char_class($classLevel, null);
	$higClass = char_class($classLevel + 6);
	$topRank[$class['group']] = mmw_lang_only . " {$class['off']}'s-{$higClass}'s";
}
?>

<table class="sort-table" style="margin:0 auto;border:0;padding:0">
	<tr>
		<td>
			<form action="?op=rankings" method="post" name="rankings">
				<?php echo mmw_lang_top; ?>:
				<select name="top_rank">
					<?php
					foreach ($topCount as $count) {
						$selected = ($count === (int)$_POST['top_rank']) ? 'selected' : '';
						echo '<option ' . $selected . '>' . $count . '</option>';
					}
					?>
				</select>
				<?php echo mmw_lang_select_sort; ?>:
				<select name="sort">
					<?php
					foreach ($topRank as $value => $label) {
						$selected = ($value === $_POST['sort']) ? 'selected' : '';
						echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
					}
					?>
				</select>
				<input type="submit" value="<?php echo mmw_lang_show_now; ?>">
			</form>
		</td>
	</tr>
</table>

<?php echo $rowbr; ?>

<div style="text-align:center">
	<?php
	$rankingModule = preg_replace('/[^\w_-]/', '', $_POST['sort']);
	if (is_file('modules/rankings/' . $rankingModule . '.php')) {
		require_once 'modules/rankings/' . $rankingModule . '.php';
	} elseif (is_file('modules/rankings/' . $rankingModule . '.mmw')) {
		mmw('modules/rankings/' . $rankingModule . '.mmw');
	} else {
		require_once 'modules/rankings/character.php';
	}
	?>
</div>
