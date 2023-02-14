<?PHP
// PHP Script By Vaflan
// For MyMuWeb
// Ver. 1.7

$search = clean_var(stripslashes($_POST['search']));

if (!empty($search)) {$result = mssql_query("SELECT TOP 30 Name,Class,reset,cLevel,strength,dexterity,vitality,energy,accountid from Character where name like '%$search%'");} else {
$result = mssql_query("SELECT TOP 30 Name,Class,reset,cLevel,strength,dexterity,vitality,energy,accountid from Character where name like '$search'");}
$row_num = mssql_num_rows($result);
?>
<br><?echo mmw_lang_search_character_results;?></br><br>&nbsp;</br>
            <table class="sort-table" border="0" cellpadding="0" cellspacing="0">                
            <thead><tr>
            <td>#</td>
            <td><?echo mmw_lang_character;?></td>
            <td><?echo mmw_lang_reset;?></td>
            <td><?echo mmw_lang_level;?></td>
            <td><?echo mmw_lang_class;?></td>
            <td><?echo mmw_lang_status;?></td>
            </tr></thead>
<?
if($row_num==0) {
 echo '<tr><td colspan="6">'.mmw_lang_cant_find.'</td></tr>';
}

for($i=0;$i < $row_num;++$i) {
 $row = mssql_fetch_row($result);

 $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[8]'");
 $status = mssql_fetch_row($status_reults);
 if($status[0] == 0){$status[0] ='<img src='.default_img('offline.gif').' width=6 height=6>';}
 if($status[0] == 1){$status[0] ='<img src='.default_img('online.gif').' width=6 height=6 >';}

 $rank = $i+1;

 echo "<tbody><tr>
            <td>$rank</td>
            <td><a href=?op=character&character=$row[0]>$row[0]</a></td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td>".char_class($row[1],off)."</td>
            <td>$status[0]</td>
            </tr></tbody>";
}
?>
</table>