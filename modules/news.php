<?PHP
if(!isset($_GET['pg'])) {$pg = 1;}
else {$pg = clean_var(stripslashes($_GET['pg']));}
$from = (($pg * $mmw[max_post_news]) - $mmw[max_post_news]);

$totals = mssql_num_rows( mssql_query("SELECT news_id FROM MMW_News") );
$total_pgs = ceil($totals / $mmw[max_post_news]);
$now_total = $pg * $mmw[max_post_news];
if($totals < $now_total) {$now_total = $totals;}

//$result = mysql_query("SELECT * FROM news ORDER BY `ID` DESC LIMIT $from, $mmw[max_post_news]") or die(mysql_error());
$get_news = mssql_query("SELECT TOP $now_total news_title,news_autor,news_category,news_date,news_id,news_eng,news_rus FROM MMW_News order by news_date desc");

for($i=0; $i < $now_total; ++$i) {
	$row = mssql_fetch_row($get_news);
	if($i >= $from){
	$date = date("d.m.Y", $row[3]);
	if($row[5][1]!=''){$news_eng="<div><u>English:</u></div>".bbcode(substr($row[5],0,$mmw[long_news_txt]))." <a href='?news=$row[4]'>...</a>";} else{$news_eng="";}
	if($row[6][1]!=''){$news_rus="<div><u>Russian:</u></div>".bbcode(substr($row[6],0,$mmw[long_news_txt]*2))." <a href='?news=$row[4]'>...</a>";} else{$news_rus="";}
	$comm_result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_id_blog='1' AND c_id_code='$row[4]'");
	$comm_num = mssql_num_rows($comm_result);

	echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
        <tr><td>
        <div class="eTitle"><a href="?news='.$row[4].'" class="eTitleLink">'.$row[0].'</a></div>
        <div class="eMessage">'.$news_eng.$news_rus.'</div>
        <div class="eDetails">'.mmw_lang_category.': '.$row[2].' | '.mmw_lang_author.': <a href="?op=profile&profile='.$row[1].'">'.$row[1].'</a> | '.mmw_lang_date.': <span title="'.$date.'">'.$date.'</span> | '.mmw_lang_total_comment.': <a href="?news='.$row[4].'">'.$comm_num.'</a></div>
        </td></tr></table>' . $rowbr;
	}
}

if($pg > 1){ $prev = ($pg - 1); // Previous Link
$paginator = "<a href='?op=news&pg=$prev'><img src='images/left.png' border='0'></a> ";}
for($i = 1; $i <= $total_pgs; $i++){ /// Numbers
if(($pg) == $i) { $paginator .= ' <b>'.$i.'</b> '; } else {
$paginator .=' <a href="?op=news&pg='.$i.'">'.$i.'</a> '; }}
if($pg < $total_pgs){ $next = ($pg + 1); // Next Link
$paginator .= " <a href='?op=news&pg=$next'><img src='images/right.png' border='0'></a>";}

echo $rowbr . "<center>[ $paginator ]</center>";
?>