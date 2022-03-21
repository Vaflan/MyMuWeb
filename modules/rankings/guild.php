<?
$top_rank=stripslashes($_POST['top_rank']);
$top_rank=clean_var($top_rank);
?>
<br><span class="normal_text_white">Top <?echo $top_rank;?> Guilds</span></br><br>&nbsp;</br>
           <table class="sort-table" id="table-1" height="30" cellspacing="0" cellpadding="0" border="0">
           <thead><tr>
           <td class=thead2>#</td>
           <td class=thead2 title="Name Of Guild">Name</td>
           <td class=thead2>Score</td>
           <td class=thead2>Master</td>
           <td class=thead2>Members</td>
           <td class=thead2>Logo</td>
           </tr></thead>
<?
$result = mssql_query("SELECT TOP $top_rank G_Name,G_Score,G_Master,Number,G_Mark from pl_guild WHERE G_Name!='$mmw[gm_guild]' order by G_score desc, Number desc");
$row_num = mssql_num_rows($result);
if($row_num==0) {
 echo '<tr><td colspan="6">No Guild</td></tr>';
}

for($i=0;$i < $row_num;++$i)
     {
          $row = mssql_fetch_row($result);
          if($row[1]==NULL || $row[1]<0)
		{mssql_query("UPDATE guild SET [G_Score]='0' WHERE G_Name='$row[0]'");$row[1]="0";}
          $rank = $i+1;
          $logo = urlencode(bin2hex($row[4]));

echo "<tbody><tr> 
            <td>$rank</td>
            <td><a href=index.php?op=guild&guild=$row[0]>$row[0]</a></td>
            <td>$row[1]</td>
            <td><a href=index.php?op=character&character=$row[2]>$row[2]</a></td>
            <td>$row[3]</td>
            <td title='Guild Logo'><a class=helpLink href=? onclick=\"showHelpTip(event, '<img src=\'decode.php?decode=$logo\' height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height=20 width=20 broder=0></a></td>
            </tr></tbody>";    
       }
?>
</table>