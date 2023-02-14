<?PHP
if(isset($_POST[search_type])) {$search_select[$_POST[search_type]]="selected";} else {$search_select[char]="selected";}
?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'> 
	<tr>
          <td>
             <form action="" method="post" name="search">
		<?echo mmw_lang_search_type.": <select name='search_type'><option value='char' $search_select[char]>".mmw_lang_character."</option><option value='guild' $search_select[guild]>".mmw_lang_guild."</option></select>";?>
		<?echo mmw_lang_search.": <input name='search' type='text' size='16' maxlength='10' value='$_POST[search]'> <input type='submit' name='Submit' value='".mmw_lang_show_now."'>";?>
             </form>
          </td>
	</tr>
</table>

<?echo $rowbr;?>

<center>
<?
if(isset($_POST["search"])){
 if($_POST['search_type'] == 'guild') {include("modules/rankings/search_guild.php");}
 else {include("modules/rankings/search_char.php");}
}
?>
</center>