<?PHP
// PHP Script By Vaflan
// For MyMuWeb
// Ver. 1.7

$top_rank = clean_var(stripslashes($_POST['top_rank']));
?>
    <br><?echo mmw_lang_top." $top_rank ".mmw_lang_killers;?><br>&nbsp;</br>
            <table class="sort-table" border="0" cellpadding="0" cellspacing="0">                
            <thead><tr>
            <td>#</td>
            <td><?echo mmw_lang_character;?></td>
            <td><?echo mmw_lang_killed;?></td>
            <td><?echo mmw_lang_reset;?></td>
            <td><?echo mmw_lang_level;?></td>	
            <td><?echo mmw_lang_class;?></td>
            </tr></thead>
<?
if($mmw['gm']=='no'){$no_gm_in_top = "and ctlcode!='32' and ctlcode!='8'";}
$result = @mssql_query("SELECT TOP $top_rank Name,Class,Reset,cLevel,AccountID,PKcount from Character where pkcount>0 $no_gm_in_top order by pkcount desc");
$row_num = @mssql_num_rows($result);
if($row_num==0) {
 echo '<tr><td colspan="6">'.mmw_lang_no_characters.'</td></tr>';
}

for($i=0;$i < $row_num;++$i)
{
$row = mssql_fetch_row($result);
$rank = $i+1;

$status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[4]'");
$status = mssql_fetch_row($status_reults);
$statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[4]'");
$statusdc = mssql_fetch_row($statusdc_reults);

if($status[0] == 1 && $statusdc[0] == $row[0]) {$status[0] ='<img src='.default_img('online.gif').' width=6 height=6>';}
else {$status[0] ='<img src='.default_img('offline.gif').' width=6 height=6>';}

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