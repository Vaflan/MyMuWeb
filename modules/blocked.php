<center><?echo mmw_lang_blocked_accounts;?><br>&nbsp;</br></center>

<table class="sort-table" height="30" border="0" cellpadding="0" cellspacing="0" align="center">                
	<thead><tr>
          <td>#</td>
          <td><?echo mmw_lang_account;?></td>
          <td><?echo mmw_lang_toblocked;?></td>
          <td><?echo mmw_lang_unblocked;?></td>
          <td><?echo mmw_lang_blocked_by;?></td>
          <td><?echo mmw_lang_information;?></td>
          </tr>
	</thead>
<?
$result = mssql_query("Select memb___id,block_date,unblock_time,blocked_by from MEMB_INFO where bloc_code='1' ORDER BY block_date ASC");
$row_num = mssql_num_rows($result);
if($row_num==0) {
 echo "<tr><td colspan='6'>".mmw_lang_no_blocked_accounts."</td></tr>";
}

for($i=0;$i < $row_num;++$i) {
	$row = mssql_fetch_row($result);
	$rank = $i+1;

	if($row[1] > 0) {$date = date("d M Y, H:i",$row[1]);}
	else {$date = mmw_lang_for_ever;}

	if($row[2] > 0) {$to = date("d M Y, H:i",$row[1]+$row[2]);}
	else {$to = mmw_lang_never;}

	if($row[3] != '' && $row[3] != '0') {$by_who = "<a href='?op=profile&profile=$row[3]'>$row[3]</a>";}
	else {$by_who = "Unknow";}

echo 	"<tbody><tr>
            <td>$rank</td>
            <td><a href='?op=profile&profile=$row[0]'>$row[0]</a></td>
            <td>$date</td>
            <td>$to</td>
            <td>$by_who</td>
            <td><a href='?op=checkacc&w=block&n=$row[0]'>".mmw_lang_show_now."</a></td>
            </tr></tbody>";
}
?>
</table>