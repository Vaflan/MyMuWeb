<?PHP
$top_rank = clean_var(stripslashes($_POST['top_rank']));
?>
<br><?echo mmw_lang_top." $top_rank ".mmw_lang_guilds;?><br>&nbsp;</br>
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
$result = mssql_query("SELECT TOP $top_rank G_Name,G_Score,G_Master,G_Mark FROM Guild WHERE G_Name!='$mmw[gm_guild]' order by G_score desc");
$row_num = mssql_num_rows($result);
if($row_num==0) {
 echo '<tr><td colspan="6">'.mmw_lang_no_guilds.'</td></tr>';
}

for($i=0;$i < $row_num;++$i)
     {
	$row = mssql_fetch_row($result);
	if($row[1]==NULL || $row[1]<0)
		{mssql_query("UPDATE guild SET [G_Score]='0' WHERE G_Name='$row[0]'");$row[1]="0";}
	$rank = $i+1;
	$logo = urlencode(bin2hex($row[3]));

	$members = mssql_num_rows( mssql_query("SELECT name FROM Guildmember WHERE G_Name='$row[0]'") );

echo "<tbody><tr> 
            <td>$rank</td>
            <td><a href=index.php?op=guild&guild=$row[0]>$row[0]</a></td>
            <td>$row[1]</td>
            <td><a href=index.php?op=character&character=$row[2]>$row[2]</a></td>
            <td>$members</td>
            <td><a class=helpLink href=? onclick=\"showHelpTip(event, '<img src=\'decode.php?decode=$logo\' height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height=20 width=20 broder=0></a></td>
            </tr></tbody>";    
       }
?>
</table>