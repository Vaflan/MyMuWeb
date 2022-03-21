<?
$search = clean_var(stripslashes($_POST['character_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==1)
{$result = mssql_query("SELECT * from guild where G_Name='$search' order by G_score desc");}
if($_POST['search_type']==0)
{$result = mssql_query("SELECT * from guild where G_Name like '%$search%' order by G_score desc");}
$row_num = mssql_num_rows($result);
?>
<br>Search Guild Results</br><br>&nbsp;</br>
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
if($row_num==0) {
 echo '<tr><td colspan="6">Not Find!</td></tr>';
}

for($i=0;$i < $row_num;++$i)
     {
          $rank = $i+1;
          $row = mssql_fetch_row($result);
          if($row[2]==NULL){$row[2]="0";}
          $result2 = mssql_query("Select count(*) from GuildMember where G_name='$row[0]'");
          $row2 = mssql_fetch_row($result2);
          $logo = urlencode(bin2hex($row[1]));

echo "<tbody><tr> 
            <td>$rank</td>
            <td><a href=index.php?op=guild&guild=$row[0]>$row[0]</a></td>
            <td>$row[2]</td>
            <td><a href=index.php?op=character&character=$row[3]>$row[3]</a></td>
            <td>$row2[0]</td>
            <td title='Guild Logo' align='center'><a class=helpLink href=? onclick=\"showHelpTip(event, '<img src=\'decode.php?decode=$logo\' height=60 width=60>',false); return false\"><img src='decode.php?decode=$logo' height=10 width=10 broder=0></a></td>
            </tr></tbody>";    
       }
?>
</table>