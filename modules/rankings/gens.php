<?php
// 'Gens Stats' Ver. 1.100226 By Vaflan
// For MyMuWeb 0.7+
if($mmw['gm']=='no'){$no_gm_in_top = "and ctlcode!='32' and ctlcode!='8'";}
?>
    <br><b>Durpian vs Vanert&nbsp;</b><br>&nbsp;</br>

<table border="0" cellpadding="2" cellspacing="0" align="center">
 <tr>
  <td width="50%">
<?php
$query = "SELECT Name,SCFGensContribution,AccountID FROM Character WHERE SCFGensFamily='1' $no_gm_in_top ORDER by SCFGensContribution DESC";
$points = @mssql_fetch_row(mssql_query("SELECT sum(SCFGensContribution) FROM Character WHERE SCFGensFamily='1'"));
$result = @mssql_query($query);
$row_num = @mssql_num_rows($result);
if(empty($points[0])) {$points[0] = 0;}
if(empty($row_num)) {$row_num = 0;}
?>
<table class="sort-table" border="0" cellpadding="0" cellspacing="0">                
 <thead><tr><td>#</td><td><?echo mmw_lang_character.' ('.$row_num.')';?></td><td><?echo mmw_lang_score.' ('.$points[0].')';?></td></tr></thead>
<?php
if($row_num == 0) {
 echo '<tr><td colspan="3">'.mmw_lang_no_characters.'</td></tr>';
}
for($i=0;$i < $row_num;++$i) {
 $rank = $i+1;
 $row = mssql_fetch_row($result);

 $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[2]'");
 $status = mssql_fetch_row($status_reults);
 $statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[2]'");
 $statusdc = mssql_fetch_row($statusdc_reults);

 if($status[0] == 1 && $statusdc[0] == $row[0]) {$status ='<img src='.default_img('online.gif').' width=6 height=6>';}
 else {$status ='<img src='.default_img('offline.gif').' width=6 height=6>';}

echo " <tbody><tr><td>$rank</td><td>$status <a href=index.php?op=character&character=$row[0]>$row[0]</a></td><td>$row[1]</td></tr></tbody>";
}
?>
</table>
  </td>
  <td width="50%">
<?php
$query = "SELECT Name,SCFGensContribution,AccountID FROM Character WHERE SCFGensFamily='2' $no_gm_in_top ORDER by SCFGensContribution DESC";
$points = @mssql_fetch_row(mssql_query("SELECT sum(SCFGensContribution) FROM Character WHERE SCFGensFamily='2'"));
$result = @mssql_query($query);
$row_num = @mssql_num_rows($result);
if(empty($points[0])) {$points[0] = 0;}
if(empty($row_num)) {$row_num = 0;}
?>
<table class="sort-table" border="0" cellpadding="0" cellspacing="0">                
 <thead><tr><td>#</td><td><?echo mmw_lang_character.' ('.$row_num.')';?></td><td><?echo mmw_lang_score.' ('.$points[0].')';?></td></tr></thead>
<?php
if($row_num == 0) {
 echo '<tr><td colspan="3">'.mmw_lang_no_characters.'</td></tr>';
}
for($i=0;$i < $row_num;++$i) {
 $rank = $i+1;
 $row = mssql_fetch_row($result);

 $status_reults = mssql_query("Select ConnectStat from MEMB_STAT where memb___id='$row[2]'");
 $status = mssql_fetch_row($status_reults);
 $statusdc_reults = mssql_query("Select GameIDC from AccountCharacter where Id='$row[2]'");
 $statusdc = mssql_fetch_row($statusdc_reults);

 if($status[0] == 1 && $statusdc[0] == $row[0]) {$status ='<img src='.default_img('online.gif').' width=6 height=6>';}
 else {$status ='<img src='.default_img('offline.gif').' width=6 height=6>';}

echo " <tbody><tr><td>$rank</td><td>$status <a href=index.php?op=character&character=$row[0]>$row[0]</a></td><td>$row[1]</td></tr></tbody>";
}
?>
</table>
  </td>
 </tr>
</table>
