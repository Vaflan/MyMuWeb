<?PHP
$get_links = mssql_query("SELECT link_name,link_address,link_description,link_date from MMW_Links order by link_date desc");

for($i=0;$i < mssql_num_rows($get_links);++$i) {
$row = mssql_fetch_row($get_links);

echo	"<table cellpadding='1' width='100%' class='aBlock'><tr>
	<td><a href='$row[1]' target='_blank'><b><big>$row[0]</big></b></a></td><td align='right'>".mmw_lang_date.": $row[3]</td></tr>
	<tr><td colspan='2'>".mmw_lang_download." $row[0] <a href='$row[1]' target='_blank'><b>".mmw_lang_from_here."</b></a><br>".mmw_lang_description.": $row[2]</td></tr>
	</table> $rowbr";
 }
?>
