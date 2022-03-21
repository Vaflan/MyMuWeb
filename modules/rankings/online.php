<?PHP
$top_rank = clean_var(stripslashes($_POST['top_rank']));
?>
    <br><?echo mmw_lang_top." $top_rank ".mmw_lang_characters;?><br>&nbsp;</br>
          <table class="sort-table" border="0" cellpadding="0" cellspacing="0">                
          <thead><tr>
          <td>#</td>
          <td><?echo mmw_lang_character;?></td>
          <td><?echo mmw_lang_reset;?></td>
          <td><?echo mmw_lang_level;?></td>
          <td><?echo mmw_lang_class;?></td>
          <td><?echo mmw_lang_server;?></td>
          <td><?echo mmw_lang_connect_date;?></td>
          </tr></thead>

<?
$result = mssql_query("Select TOP $top_rank memb___id,ServerName,CONNECTTM from MEMB_STAT where ConnectStat='1' ORDER BY CONNECTTM ASC");
$row_num = mssql_num_rows($result);
if($row_num==0) {
 echo '<tr><td colspan="7">'.mmw_lang_all_characters_is_offline.'</td></tr>';
}

for($i=0;$i < $row_num;++$i) {
             $row = mssql_fetch_row($result);
             $rank = $i+1;
             $idc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[0]'");
             $idc = mssql_fetch_row($idc_reults);
             $char_reults = mssql_query("Select Name,Class,Reset,cLevel,AccountID from Character where name='$idc[0]'");
             $char = mssql_fetch_row($char_reults);

echo 	"<tbody><tr>
            <td>$rank</td>
            <td><img src=./images/online.gif width=6 height=6> <a href=?op=character&character=$char[0]>$char[0]</a></td>
            <td>$char[2]</td>
            <td>$char[3]</td>
            <td>".char_class($char[1],off)."</td>
            <td>$row[1]</td>
            <td>".time_format($row[2],"d M Y, H:i")."</td>
            </tr></tbody>";
}
?>
</table>