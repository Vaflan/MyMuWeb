<?PHP
if(isset($_SESSION['char_set']) && isset($_SESSION['pass']) && isset($_SESSION['user'])) {
echo '<div align="right">[ <a href="?forum=add">'.mmw_lang_new_topic.'</a> ]</div>';
if(isset($_POST['f_id_delete'])){require("includes/character.class.php"); option::forum_delete($_POST['f_id_delete']);}
}
else {
echo '<div align="right">[ '.mmw_lang_guest_must_be_logged_on.' ]</div>';
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
?>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
	<tr>
		<td><b><?echo mmw_lang_topic_name;?></b></td>
		<td align="center" width="60"><b><?echo mmw_lang_comments;?></b></td>
		<td align="center" width="100"><b><?echo mmw_lang_author;?></b></td>
		<td align="center" width="100"><b><?echo mmw_lang_lost_message;?></b></td>
	</tr>
<?
  if($total_post == 0) {
	echo '<tr><td colspan="4">'.mmw_lang_no_topics_in_forum.'</td></tr>';
  }

  for($i = 0; $i < $total_post; $i++) {
      $row = mssql_fetch_row($result);
      $now_date = time();

      if($char_info[$row[1]][0] == '') {
	$result_char = mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$row[1]'");
	$char_info[$row[1]] = mssql_fetch_row($result_char);
      }
      if($char_info[$row[4]][0] == '') {
	$result_char = mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$row[4]'");
	$char_info[$row[4]] = mssql_fetch_row($result_char);
      }

	$comm_result = mssql_query("SELECT c_id FROM MMW_comment WHERE c_id_blog='2' AND c_id_code='$row[0]'");
	$comm_num = mssql_num_rows($comm_result);

      if($comm_num!=0 && $row[4]!="") {
	$lost_date = $now_date-$row[3];
	if($lost_date<60) {$lost_date = $lost_date . ' s.';}
	elseif($lost_date<3600) {$lost_date = ceil($lost_date / 60) . ' m.';}
	elseif($lost_date<86400) {$lost_date = ceil($lost_date / 3600) . ' h.';}
	else {$lost_date = ceil($lost_date / 86400) . ' d.';}
	$lost_comm = '<a href="?op=character&character='.$row[4].'" class="level'.$char_info[$row[4]][1].'">'.$row[4].'</a>, '.$lost_date;
	}
      else {$lost_comm = '';}

	if($_SESSION['admin'] >= $mmw[forum_can_delete] || $_SESSION['char_set'] == $row[1])
	{$delete = "<form action='' method='post' name='delete_$row[0]'><input name='f_id_delete' type='hidden' value='$row[0]'><a href='javascript://' title='".mmw_lang_delete."'><img src='images/delete.png' border='0' onclick='delete_$row[0].submit()'></a></form>";}
	else {$delete = '';}

      echo '
        <tr>
	<td><a href="?forum='.$row[0].'">'.$row[2].'</a> '.$delete.'</td>
        <td align="center"><a href="?forum='.$row[0].'">'.$comm_num.'</a></td>
        <td align="center"><a href="?op=character&character='.$row[1].'" class="level'.$char_info[$row[1]][1].'">'.$row[1].'</a></td>
	<td align="center">'.$lost_comm.'</td>
	</tr>
           ';
  }
?>
</table>
<?echo mmw_lang_total_topic .": $total_post &nbsp; ".mmw_lang_total_comment.": $total_comm_post";?>