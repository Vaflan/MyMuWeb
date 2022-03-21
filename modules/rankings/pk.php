    <br>Top <?echo $top_rank;?> Killers<br>&nbsp;</br>
            <table class="sort-table" id="table-1" height="30" border="0" cellpadding="0" cellspacing="0">                
            <thead><tr>
            <td class=thead2>#</td>
            <td class=thead2 title="Name Of Character">Name</td>
            <td class=thead2>Killed</td>
            <td class=thead2>Level</td>
            <td class=thead2>Reset</td>	
            <td class=thead2>Class</td>
            </tr></thead>
<?
$top_rank = clean_var(stripslashes($_POST['top_rank']));

$result = mssql_query("SELECT TOP $top_rank Name,Class,cLevel,Reset,AccountID,PKcount from Character where pkcount>0 order by pkcount desc");
$row_num = mssql_num_rows($result);
if($row_num==0) {
 echo '<tr><td colspan="6">No Characters</td></tr>';
}

for($i=0;$i < $row_num;++$i)
{
$row = mssql_fetch_row($result);
$rank = $i+1;

$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[4]'");
$status = mssql_fetch_row($status_reults);
$statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[4]'");
$statusdc = mssql_fetch_row($statusdc_reults);

if($status[0] == 1 && $statusdc[0] == $row[0]) 
	{$status[0] ='<img src=./images/online.gif width=6 height=6>';}
elseif($status[0] == 1 && $statusdc[0] != $row[0]) 
	{$status[0] ='<img src=./images/sleep.gif width=6 height=6>';}
else {$status[0] ='<img src=./images/offline.gif width=6 height=6>';}

echo "<tbody><tr>
            <td>$rank</td>
            <td>$status[0] <a href=index.php?op=character&character=$row[0]>$row[0]</a></td>
            <td>$row[5]</td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td>".char_class($row[1],off)."</td>
            </tr></tbody>";
}
?>
</table>