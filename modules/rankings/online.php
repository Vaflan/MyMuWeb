<?
$top_rank=stripslashes($_POST['top_rank']);
$top_rank=clean_var($top_rank);
?>
    <br>Top <?echo $top_rank;?> Characters<br>&nbsp;</br>
          <table class="sort-table" id="table-1" height="30" border="0" cellpadding="0" cellspacing="0">                
          <thead><tr>
          <td class=thead2>#</td>
          <td class=thead2>Name</td>
          <td class=thead2>Reset</td>
          <td class=thead2>Level</td>
          <td class=thead2>Class</td>
          <td class=thead2>Server</td>
          <td class=thead2>Connect Date</td>
          </tr></thead>

<?
$result = mssql_query("Select TOP $top_rank memb___id,ServerName,CONNECTTM from MEMB_STAT where ConnectStat='1' ORDER BY CONNECTTM ASC");
$row_num = mssql_num_rows($result);
if($row_num==0) {
 echo '<tr><td colspan="7">All User is Offline</td></tr>';
}

for($i=0;$i < $row_num;++$i) {
             $row = mssql_fetch_row($result);
             $rank = $i+1;
             $idc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[0]'");
             $idc = mssql_fetch_row($idc_reults);
             $char_reults = mssql_query("Select Name,Class,cLevel,Reset,AccountID from Character where name='$idc[0]'");
             $char = mssql_fetch_row($char_reults);

echo 	"<tbody><tr>
            <td>$rank</td>
            <td><img src=./images/online.gif width=6 height=6> <a href=?op=character&character=$char[0]>$char[0]</a></td>
            <td>$char[3]</td>
            <td>$char[2]</td>
            <td>".char_class($char[1],off)."</td>
            <td>$row[1]</td>
            <td>".time_format($row[2],"d M Y, H:i")."</td>
            </tr></tbody>";
}
?>
</table>