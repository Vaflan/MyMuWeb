<?
$search = clean_var(stripslashes($_POST['character_search']));
$search_type = clean_var(stripslashes($_POST['search_type']));

if($_POST['search_type']==1)
{$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid from Character where name='$search'");}
if($_POST['search_type']==0)
{$result = mssql_query("SELECT Name,Class,cLevel,reset,strength,dexterity,vitality,energy,accountid from Character where name like '%$search%'");}
?>
<br>Search Character Results<br>&nbsp;</br>
            <table class="sort-table" id="table-1" height=30 border="0" cellpadding="0" cellspacing="0">                
            <thead><tr>
            <td class=thead2>#</td>
            <td class=thead2 title="Name Of Character">Name</td>
            <td class=thead2>Level</td>
            <td class=thead2>Reset</td>
            <td class=thead2>Class</td>
            <td class=thead2>Status</td>
            </tr></thead>
<?
for($i=0;$i < mssql_num_rows($result);++$i)
{
$row = mssql_fetch_row($result);

$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[8]'");
$status = mssql_fetch_row($status_reults);
if($status[0] == 0){$status[0] ='<img src=./images/Offline.gif width=6 height=6>';}
if($status[0] == 1){$status[0] ='<img src=./images/Online.gif width=6 height=6 >';}

$rank = $i+1;

echo "<tbody><tr>
            <td>$rank</td>
            <td><a href=index.php?op=character&character=$row[0]>$row[0]</a></td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td>".char_class($row[1],off)."</td>
            <td>$status[0]</td>
            </tr></tbody>";
}
?>
</table>