<?php
/**
 * MMW News 1.3
 * @var array $mmw
 * @var string $rowbr
 */

$news_id = clean_var(stripslashes($_GET['news']));
$get_news = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_row_1,news_row_2,news_row_3 FROM dbo.MMW_News WHERE news_id='{$news_id}'");

$language = array(
	'category' => mmw_lang_category,
	'author' => mmw_lang_author,
	'date' => mmw_lang_date,
	'total_comment' => mmw_lang_total_comment,
);

while ($row = mssql_fetch_row($get_news)) {
	$date = date('H:i:s d.m.Y', $row[3]);
	if (!empty($row[4])) {
		$news_row_1 = $mmw['news_row_1'] . $row[4] . $mmw['news_row_end'];
	}
	if (!empty($row[5])) {
		$news_row_2 = $mmw['news_row_2'] . $row[5] . $mmw['news_row_end'];
	}
	if (!empty($row[6])) {
		$news_row_3 = $mmw['news_row_3'] . $row[6] . $mmw['news_row_end'];
	}

	$content = bbcode($news_row_1 . $news_row_2 . $news_row_3);

	echo <<<HTML
<div class="eBlock" style="width:100%;border:0;padding:0">
	<div class="eTitle">{$row[0]}</div>
	<div class="eMessage">{$content}</div>
	<div class="eDetails">{$language['category']}: {$row[2]} | {$language['author']}: {$row[1]} | {$language['date']}: <span title="{$date}">{$date}</span></div>
</div>
HTML;
}

comment_module(1, $news_id);
