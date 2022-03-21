<?PHP
if(isset($_GET['sort'])){$_POST['sort']=$_GET['sort']; $_POST['top_rank']='100';}
if($_POST[top_rank] != ''){$select_top[$_POST[top_rank]]=" selected";} else{$select_top[100]=" selected";}
if($_POST[top_rank] != 'all'){$select_sort[$_POST[sort]]=" selected";} else{$select_sort['all']=" selected";}
?>

<table class='sort-table' align='center' border='0' cellpadding='0' cellspacing='0'> 
	<tr>
          <td>
          <form action="" method="post" name="rankings">
		<?echo mmw_lang_top;?>:
                      <select name="top_rank">
                        <option value="10"<?echo $select_top[10];?>>10</option>
                        <option value="25"<?echo $select_top[25];?>>25</option>
                        <option value="50"<?echo $select_top[50];?>>50</option>
                        <option value="100"<?echo $select_top[100];?>>100</option>
                      </select> 
		<?echo mmw_lang_select_sort;?>:
                      <select name="sort">
                        <option value="all"<?echo $select_sort['all'];?>><?echo mmw_lang_all_characters;?></option>
                        <option value="pk"<?echo $select_sort['pk'];?>><?echo mmw_lang_all_killers;?></option>
                        <option value="guild"<?echo $select_sort['guilds'];?>><?echo mmw_lang_all_guilds;?></option>
                        <option value="dw"<?echo $select_sort['dw'];?>><?echo mmw_lang_only;?> DW's-GrM's</option>
                        <option value="dk"<?echo $select_sort['dk'];?>><?echo mmw_lang_only;?> DK's-BM's</option>
                        <option value="elf"<?echo $select_sort['elf'];?>><?echo mmw_lang_only;?> ELF's-HE's</option>
                        <option value="mg"<?echo $select_sort['mg'];?>><?echo mmw_lang_only;?> MG's-DM's</option>
                        <option value="dl"<?echo $select_sort['dl'];?>><?echo mmw_lang_only;?> DL's-LE's</option>
                        <option value="sum"<?echo $select_sort['sum'];?>><?echo mmw_lang_only;?> Sum's-Dim's</option>
                        <option value="online"<?echo $select_sort['online'];?>><?echo mmw_lang_online_characters;?></option>
                      </select> 
		<input type="submit" name="Submit" value="<?echo mmw_lang_show_now;?>">
          </form>
          </td>
	</tr>
</table>

<?echo $rowbr;?>

<center>
<? 
if(!isset($_POST['sort'])){include("modules/rankings/character.php");}
elseif($_POST['sort']==online){include("modules/rankings/online.php");}
elseif($_POST['sort']==guild){include("modules/rankings/guild.php");}
elseif($_POST['sort']==pk){include("modules/rankings/pk.php");}
else{include("modules/rankings/character.php");}
?>
</center>