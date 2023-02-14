<?PHP
// PHP Script By Vaflan
// For MyMuWeb
// Ver. 1.7

$search = clean_var(stripslashes($_POST['search']));
if (!empty($search)) {$result = mssql_query("SELECT TOP 30 * from guild where G_Name like '%$search%' order by G_score desc");} else {
$result = mssql_query("SELECT TOP 30 * from guild where G_Name like '$search' order by G_score desc"); }
$row_num = mssql_num_rows($result);
?>
<br><?echo mmw_lang_search_guild_results;?></br><br>&nbsp;</br>
           <table class="sort-table" cellspacing="0" cellpadding="0" border="0">
           <thead><tr>
           <td>#</td>
           <td><?echo mmw_lang_guild;?></td>
           <td><?echo mmw_lang_score;?></td>
           <td><?echo mmw_lang_master;?></td>
           <td><?echo mmw_lang_members;?></td>
           <td><?echo mmw_lang_logo;?></td>
           </tr></thead>
<?
if($row_num==0) {
 echo '<tr><td colspan="6">'.mmw_lang_cant_find.'</td></tr>';
}

for($i=0;$i < $row_num;++$i) {
          $rank = $i+1;
          $row = mssql_fetch_row($result);
          if($row[2]==NULL){$row[2]="0";}
          $result2 = mssql_query("Select count(*) from GuildMember where G_name='$row[0]'");
          $row2 = mssql_fetch_row($result2);
          $logo = urlencode(bin2hex($row[1]));

echo "<tbody><tr> 
            <td>$rank</td>
            <td><a href=?op=guild&guild=$row[0]>$row[0]</a></td>
            <td>$row[2]</td>
            <td><a href=?op=character&character=$row[3]>$row[3]</a></td>
            <td>$row2[0]</td>
            <td align='center'><a class=helpLink href=? onclick=\"showHelpTip(event, '<img src=\'decode.php?decode=$logo\' height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height=10 width=10 broder=0></a></td>
            </tr></tbody>";    
}
?>
</table>