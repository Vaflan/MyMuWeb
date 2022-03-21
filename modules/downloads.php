<?PHP
// Download List For MMW
// By Vaflan

$get_links = mssql_query("SELECT l_name,l_address,l_description,l_size,l_date from MMW_Links order by l_date desc");

for($i=0;$i < mssql_num_rows($get_links);++$i) {
$row = mssql_fetch_row($get_links);

echo	"<table cellpadding='1' width='100%' class='aBlock'><tr>
	<td><a href='$row[1]' target='_blank'><b><big>$row[0]</big></b></a></td><td align='right'>".mmw_lang_date.": ".date("Y-m-d H:i:s",$row[4])."</td></tr>
	<tr><td colspan='2'>".mmw_lang_download." $row[0] <a href='$row[1]' target='_blank'><b>".mmw_lang_from_here."</b></a><br>".mmw_lang_description.": $row[2]<br>".mmw_lang_file_size.": $row[3]</td></tr>
	</table> $rowbr";
 }
?>
