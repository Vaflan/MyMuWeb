<?
$get_links = mssql_query("SELECT link_name,link_address,link_description,link_date from MMW_Links order by link_date desc");

for($i=0;$i < mssql_num_rows($get_links);++$i)
 {
$row = mssql_fetch_row($get_links);
$rank = $i+1;

echo	"<div class='brdiv'></div>
	<table cellpadding='1' width='100%' class='eBlock'><tr>
	<td align='left' class='link_menu'><a href='$row[1]' target='_blank'>$row[0]</a></td><td align='right'>Date $row[3]</td></tr>
	<tr><td colspan='2'>Download $row[0] From <a href='$row[1]' target='_blank'><b>HERE</b></a><br>Description: $row[2]</td></tr>
	</table>";
 }
?>
