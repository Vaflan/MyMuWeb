<?
$news_id = clean_var(stripslashes($_GET[news]));
$get_news = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_eng,news_rus from MMW_News where news_id='$news_id'");

for($i=0;$i < mssql_num_rows($get_news);++$i)
         {
          $row = mssql_fetch_row($get_news);
          $date = date("H:i:s d.m.Y", $row[3]);
	$news_eng="<div><u>English:</u></div>".bbcode($row[4]);
	$news_rus="<div><u>Russian:</u></div>".bbcode($row[5]);

echo    '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
        <tr><td style="padding:0px;">
        <div class="eTitle" style="text-align:left;">'.$row[0].'</div>
        <div class="eMessage" style="text-align:left;clear:both;padding-top:2px;padding-bottom:2px;">'.$news_eng.$news_rus.'</div>
        <div class="eDetails" style="clear:both;">&nbsp; Category: '.$row[2].' | Author: <a href="?op=profile&profile='.$row[1].'">'.$row[1].'</a> | Date: <span title="'.$date.'">'.$date.'</span>
        </div>
        </td></tr></table>';
      }

	$c_id_blog=1;
	$c_id_code=$news_id;
	include("includes/comment.php");
?>