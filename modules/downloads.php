<?php
/**
 * Download List For MMW
 * @var string $rowbr
 */

$language = array(
	'date' => mmw_lang_date,
	'download' => mmw_lang_download,
	'from_here' => mmw_lang_from_here,
	'description' => mmw_lang_description,
	'file_size' => mmw_lang_file_size,
);

$query = mssql_query("SELECT l_name,l_address,l_description,l_size,l_date FROM dbo.MMW_Links ORDER BY l_date DESC");
while ($row = mssql_fetch_row($query)) {
	$date = date('Y-m-d H:i:s', $row[4]);

	echo <<<HTML
	<table cellpadding="1" width="100%" class="aBlock">
		<tr>
			<td><a href="{$row[1]}" target="_blank"><b><big>{$row[0]}</big></b></a></td>
			<td align="right">{$language['date']}: {$date}</td>
		</tr>
		<tr>
			<td colspan="2">
				{$language['download']} {$row[0]} <a href="{$row[1]}" target="_blank"><b>{$language['from_here']}</b></a><br>
				{$language['description']}: {$row[2]}<br>{$language['file_size']}: {$row[3]}
			</td>
		</tr>
	</table>
	{$rowbr}
HTML;
}
