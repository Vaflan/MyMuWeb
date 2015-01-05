<?PHP
// MMW News 1.2
// By Vaflan

$news_id = clean_var(stripslashes($_GET[news]));
$get_news = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_row_1,news_row_2,news_row_3 from MMW_News where news_id='$news_id'");

for($i=0; $i < mssql_num_rows($get_news); $i++) {
  $row = mssql_fetch_row($get_news);
  $date = date("H:i:s d.m.Y", $row[3]);
  if($row[4] != ' ' && $row[4] != NULL) {$news_row_1 = $mmw[news_row_1].$row[4].$mmw[news_row_end];}
  if($row[5] != ' ' && $row[5] != NULL) {$news_row_2 = $mmw[news_row_2].$row[5].$mmw[news_row_end];}
  if($row[6] != ' ' && $row[6] != NULL) {$news_row_3 = $mmw[news_row_3].$row[6].$mmw[news_row_end];}

echo    '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
        <tr><td style="padding:0px;">
        <div class="eTitle">'.$row[0].'</div>
        <div class="eMessage">'.bbcode($news_row_1.$news_row_2.$news_row_3).'</div>
        <div class="eDetails">'.mmw_lang_category.': '.$row[2].' | '.mmw_lang_author.': '.$row[1].' | '.mmw_lang_date.': <span title="'.$date.'">'.$date.'</span>
        </div>
        </td></tr></table>';
}

$c_id_blog=1;
$c_id_code=$news_id;
include("includes/comment.php");
?>