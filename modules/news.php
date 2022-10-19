<?php
/**
 * MMW News 1.3
 * @var array $mmw
 * @var string $rowbr
 */

$page = !empty($_GET['pg'])
	? intval($_GET['pg'])
	: 1;
$from = (($page * $mmw['max_post_news']) - $mmw['max_post_news']);

$totals = current(mssql_fetch_row(mssql_query("SELECT count(*) FROM dbo.MMW_News")));
$total_pgs = ceil($totals / $mmw['max_post_news']);
$now_total = $page * $mmw['max_post_news'];
if ($totals < $now_total) {
	$now_total = $totals;
}

$get_news = mssql_query("SELECT TOP {$now_total} n.news_title,
	n.news_autor,
	n.news_category,
	n.news_date,
	n.news_id,
	n.news_row_1,
	n.news_row_2,
	n.news_row_3,
	c.comments
		FROM dbo.MMW_News AS n
		LEFT JOIN (SELECT c_id_code, count(*) AS comments FROM dbo.MMW_comment WHERE c_id_blog = 1 GROUP BY c_id_code) AS c ON c.c_id_code = n.news_id
		ORDER BY n.news_date DESC");

$language = array(
	'category' => mmw_lang_category,
	'author' => mmw_lang_author,
	'date' => mmw_lang_date,
	'total_comment' => mmw_lang_total_comment,
);

for ($i = 0; $i < $now_total; ++$i) {
	$row = mssql_fetch_row($get_news);
	if ($i >= $from) {
		if (!empty($row[5])) {
			$news_row_1 = !empty($mmw['long_news_txt'])
				? $mmw['news_row_1'] . substr($row[5], 0, $mmw['long_news_txt']) . ' <a href="?news=' . $row[4] . '">...</a>'
				: $mmw['news_row_1'] . $row[5];
		} else {
			$news_row_1 = '';
		}
		if (!empty($row[6])) {
			$news_row_2 = !empty($mmw['long_news_txt'])
				? $mmw['news_row_2'] . substr($row[6], 0, $mmw['long_news_txt']) . ' <a href="?news=' . $row[4] . '">...</a>'
				: $mmw['news_row_2'] . $row[6];
		} else {
			$news_row_2 = '';
		}
		if (!empty($row[7])) {
			$news_row_3 = !empty($mmw['long_news_txt'])
				? $mmw['news_row_3'] . substr($row[7], 0, $mmw['long_news_txt']) . ' <a href="?news=' . $row[4] . '">...</a>'
				: $mmw['news_row_3'] . $row[7];
		} else {
			$news_row_3 = '';
		}
		$comm_num = intval($row[8]);
		$date = date('d.m.Y', $row[3]);
		$time = date('H:i:s', $row[3]);
		$content = bbcode($news_row_1 . $news_row_2 . $news_row_3);

		echo <<<HTML
<div class="eBlock" style="width:100%;border:0;padding:0">
	<div class="eTitle"><a href="?news={$row[4]}" class="eTitleLink">{$row[0]}</a></div>
	<div class="eMessage">{$content}</div>
	<div class="eDetails">{$language['category']}: {$row[2]} | {$language['author']}: {$row[1]} | {$language['date']}: <span title="{$time}">{$date}</span> | {$language['total_comment']}: <a href="?news={$row[4]}">{$comm_num}</a></div>
</div>
HTML;
		if ($i < $now_total - 1) {
			echo $rowbr;
		}
	}
}


// Page Creator
$paginator = array();
if ($page > 1) {
	$prev = ($page - 1);
	$paginator[] = '<a href="?op=news&pg=' . $prev . '" title="Previos"><img src="' . default_img('left.png') . '"></a>';
}
for ($i = 1; $i <= $total_pgs; $i++) {
	$paginator[] = ($page === $i)
		? ' <b>' . $i . '</b> '
		: ' <a href="?op=news&pg=' . $i . '">' . $i . '</a> ';
}
if ($page < $total_pgs) {
	$next = ($page + 1);
	$paginator[] = '<a href="?op=news&pg=' . $next . '" title="Next"><img src="' . default_img('right.png') . '"></a>';
}

if (!empty($paginator)) {
	echo $rowbr . '<div style="text-align:center">[ ' . implode(' ', $paginator) . ' ]</div>';
}
