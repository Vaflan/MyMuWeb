<?
$get_news = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_id,news_eng,news_rus from MMW_News order by news_date desc");

for($i=0; $i < mssql_num_rows($get_news); ++$i)
         {
          $row = mssql_fetch_row($get_news);
          $rank = $i+1;
          $date = date("d.m.Y", $row[3]);
	if($row[5][1]!=''){$news_eng="<div><u>English:</u></div>".bbcode(substr($row[5],0,$mmw[long_news_txt]))." ...";} else{$news_eng="";}
	if($row[6][1]!=''){$news_rus="<div><u>Russian:</u></div>".bbcode(substr($row[6],0,$mmw[long_news_txt]))." ...";} else{$news_rus="";}
	$comm_result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_id_blog='1' AND c_id_code='$row[4]'");
	$comm_num = mssql_num_rows($comm_result);

echo    '<div class="brdiv"></div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
        <tr><td>
        <div class="eTitle"><a href="?news='.$row[4].'">'.$row[0].'</a></div>
        <div class="eMessage">'.$news_eng.$news_rus.'</div>
        <div class="eDetails">Category: '.$row[2].' | Author: <a href="?op=profile&profile='.$row[1].'">'.$row[1].'</a> | Date: <span title="'.$date.'">'.$date.'</span> | Total Comment: <a href="?news='.$row[4].'">'.$comm_num.'</a></div>
        </td></tr></table>';
      }
?>