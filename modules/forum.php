<?
if(isset($_SESSION['char_set']) && isset($_SESSION['pass']) && isset($_SESSION['user'])) {
echo '<div align="right">[ <a href="?forum=add">New Topic</a> ]</div>';
if(isset($_POST['f_id_delete'])){require("includes/character.class.php"); option::forum_delete($_POST['f_id_delete']);}
}
else {
echo '<div align="right">[ For "New Topic" Need Login! ]</div>';
}

$result = mssql_query("SELECT f_id FROM MMW_forum ORDER BY f_date ASC");
  for ($i = $mmw[max_post_forum]; $i < mssql_num_rows($result); $i++)
  {
      $row = mssql_fetch_row($result);
      mssql_query("Delete from MMW_forum where f_id='$row[0]'");
      mssql_query("Delete from MMW_comment where c_id_code='$row[0]'");
  }

$result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_id_blog='2'");
$total_comm_post = mssql_num_rows($result);

$result = mssql_query("SELECT f_id,f_char,f_title,f_date,f_lostchar FROM MMW_forum ORDER BY f_date DESC");
$total_post = mssql_num_rows($result);
  if($total_post == 0){echo 'No Topic';}
?>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
	<tr>
		<td><b>Name Topic</b></td>
		<td align="center" width="80"><b>Comment</b></td>
		<td align="center" width="86"><b>Author</b></td>
		<td align="center" width="86"><b>Lost Message</b></td>
	</tr>
<?
  for ($i = 0; $i < $total_post; $i++)
  {
      $row = mssql_fetch_row($result);
      $now_date = time();
      $num = $i+1;

	$comm_result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_id_blog='2' AND c_id_code='$row[0]'");
	$comm_num = mssql_num_rows($comm_result);

      if($comm_num!=0 && $row[4]!=""){
	$lost_date = $now_date-$row[3];
	if($lost_date<60) {$lost_date = $lost_date . ' s.';}
	elseif($lost_date<3600) {$lost_date = ceil($lost_date / 60) . ' m.';}
	elseif($lost_date<86400) {$lost_date = ceil($lost_date / 3600) . ' h.';}
	else {$lost_date = ceil($lost_date / 86400) . ' d.';}
	$lost_comm = '<a href="?op=character&character='.$row[4].'">'.$row[4].'</a>, '.$lost_date;
	}
      else {$lost_comm = '';}

	if($_SESSION['admin'] >= $mmw[forum_can_delete] || $_SESSION['char_set'] == $row[1])
	{$edit = "<form action='' method='post' name='delete$num' id='delete$num'><input name='f_id_delete' type='hidden' id='f_id_delete' value='$row[0]'><a href='javascript://'><img src='images/delete.png'  border='0' onclick='delete$num.submit()'></a></form>";}
	else {$edit = '';}

      echo '
        <tr>
	<td style="padding:0px;"><a href="?forum='.$row[0].'">'.$row[2].'</a> '.$edit.'</td>
        <td align="center">'.$comm_num.'</td>
        <td align="center"><a href="?op=character&character='.$row[1].'">'.$row[1].'</a></td>
	<td align="center">'.$lost_comm.'</td>
	</tr>
           ';
  }
?>
</table>
Total Forum Post: <?echo $total_post;?> &nbsp; Total Comment Post: <?echo $total_comm_post;?>