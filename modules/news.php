<?PHP
// MMW News 1.2
// By Vaflan

if(!isset($_GET['pg'])) {$pg = '1';}
else {$pg = clean_var(stripslashes($_GET['pg']));}
$from = (($pg * $mmw[max_post_news]) - $mmw[max_post_news]);

$totals = mssql_num_rows( mssql_query("SELECT news_id FROM MMW_News") );
$total_pgs = ceil($totals / $mmw[max_post_news]);
$now_total = $pg * $mmw[max_post_news];
if($totals < $now_total) {$now_total = $totals;}

$get_news = mssql_query("SELECT TOP $now_total news_title,news_autor,news_category,news_date,news_id,news_row_1,news_row_2,news_row_3 FROM MMW_News order by news_date desc");

for($i=0; $i < $now_total; ++$i) {
  $row = mssql_fetch_row($get_news);
  if($i >= $from) {
    if($row[5]!=' ' && $row[5]!=NULL && $mmw[long_news_txt]!=0) {$news_row_1 = $mmw[news_row_1].substr($row[5],0,$mmw[long_news_txt])." <a href='?news=$row[4]'>...</a>";}
    elseif($row[5]!=' ' && $row[5]!=NULL && $mmw[long_news_txt]==0) {$news_row_1 = $mmw[news_row_1].$row[5];}
    else {$news_row_1 = '';}
    if($row[6]!=' ' && $row[6]!=NULL && $mmw[long_news_txt]!=0) {$news_row_2 = $mmw[news_row_2].substr($row[6],0,$mmw[long_news_txt])." <a href='?news=$row[4]'>...</a>";}
    elseif($row[6]!=' ' && $row[6]!=NULL && $mmw[long_news_txt]==0) {$news_row_2 = $mmw[news_row_2].$row[6];}
    else {$news_row_2 = '';}
    if($row[7]!=' ' && $row[7]!=NULL && $mmw[long_news_txt]!=0) {$news_row_3 = $mmw[news_row_3].substr($row[7],0,$mmw[long_news_txt])." <a href='?news=$row[4]'>...</a>";}
    elseif($row[7]!=' ' && $row[7]!=NULL && $mmw[long_news_txt]==0) {$news_row_3 = $mmw[news_row_3].$row[7];}
    else {$news_row_3 = '';}
    $comm_result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_id_blog='1' AND c_id_code='$row[4]'");
    $comm_num = mssql_num_rows($comm_result);
    $date = date("d.m.Y", $row[3]);
    $time = date("H:i:s", $row[3]);

    echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
	<tr><td>
	<div class="eTitle"><a href="?news='.$row[4].'" class="eTitleLink">'.$row[0].'</a></div>
	<div class="eMessage">'.bbcode($news_row_1.$news_row_2.$news_row_3).'</div>
        <div class="eDetails">'.mmw_lang_category.': '.$row[2].' | '.mmw_lang_author.': '.$row[1].' | '.mmw_lang_date.': <span title="'.$time.'">'.$date.'</span> | '.mmw_lang_total_comment.': <a href="?news='.$row[4].'">'.$comm_num.'</a></div>
        </td></tr></table>';
    if($i < $now_total - 1) {echo $rowbr;}
  }
}


// Page Creator
if($pg > 1) {
  $prev = ($pg - 1); // Previous Link
  $paginator = "<a href='?op=news&pg=$prev' title='Previos'><img src='".default_img("left.png")."' border='0'></a> ";
}
for($i = 1; $i <= $total_pgs; $i++) { /// Numbers
  if(($pg) == $i) {$paginator .= ' <b>'.$i.'</b> ';}
  else {$paginator .=' <a href="?op=news&pg='.$i.'">'.$i.'</a> '; }
}
if($pg < $total_pgs) {
  $next = ($pg + 1); // Next Link
  $paginator .= " <a href='?op=news&pg=$next' title='Next'><img src='".default_img("right.png")."' border='0'></a>";
}
if($paginator != NULL) {echo $rowbr . "<center>[ $paginator ]</center>";}
?>