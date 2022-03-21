<table class="sort-table" id="table-1" height="30" cellspacing="0" cellpadding="0" border="0" width="100%">
<thead><tr>
<td class=thead2>#</td>
<td class=thead2 title="Name Of Character">Name</td>
<td class=thead2>Reset</td>
<td class=thead2>Level</td>
<td class=thead2>Class</td>
<td class=thead2>Status</td>
</tr></thead>
<?
$result = mssql_query("SELECT name,G_Status from guildmember where g_name='$guild_get' order by G_Status desc");
for($i=0;$i < mssql_num_rows($result);++$i)
{
$row = mssql_fetch_row($result);
$sql_character = mssql_query("Select clevel,reset,class,AccountID from character where name='$row[0]'");
$character_show = mssql_fetch_row($sql_character);

             $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$character_show[3]'");
             $status = mssql_fetch_row($status_reults);
             $statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$character_show[3]'");
             $statusdc = mssql_fetch_row($statusdc_reults);

             if($status[0] == 1 && $statusdc[0] == $row[0]) 
		{$status[0] ='<img src=./images/online.gif width=6 height=6>';}
             elseif($status[0] == 1 && $statusdc[0] != $row[0]) 
		{$status[0] ='<img src=./images/sleep.gif width=6 height=6>';}
             else {$status[0] ='<img src=./images/offline.gif width=6 height=6>';}

if($row[1] == 0){$row[1] ='Guild Member';}
if($row[1] == 32){$row[1] ='Battle Master';}
if($row[1] == 64){$row[1] ='Assistant Guild Master';}
if($row[1] == 128){$row[1] ='Guild Master';}

$rank = $i+1;
echo "<tbody><tr> 
<td>$rank</td>
<td>$status[0] <a href=?op=character&character=$row[0]>$row[0]</a></td>
<td>$character_show[1]</td>
<td>$character_show[0]</td>
<td>".char_class($character_show[2],off)."</td>
<td>$row[1]</td>
</tr></tbody>";    
}            
?>

</table>