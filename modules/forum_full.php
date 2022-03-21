<?
$id_forum = clean_var(stripslashes($_GET['forum']));

if($id_forum == "add" && isset($_SESSION['user']) && isset($_SESSION['char_set'])) {
echo $rowbr;?>
<big><b>Add Topic</b></big>
<?if(isset($_POST['title']) && isset($_POST['text'])){require("includes/character.class.php"); option::forum_send($_POST['title'],$_POST['text']);}?>
<br>
<form method="POST" name="forum" action="" style="margin:0px">
<table border="0" width="100%" cellspacing="1" cellpadding="2">
<tr><td>Topic Title<font color="red">*</font> :</td>
<td><input type='text' size='35' style='width:100%;' name='title' maxlength='32' value='<?echo $_POST['title'];?>'></td></tr>
<tr><td colspan="2"><textarea rows="8" cols="40" name="text" style="width:100%;"><?echo $_POST['text'];?></textarea></td></tr>
<tr><td align="center" colspan="2"><input style="font-weight:bold;" type="submit" value="Add"> &nbsp; <input type="reset" value="Reset"></td></tr>
</table>
</form>
<hr>BB Code:
<div align=center>
[br] - [hr] - <b>[b][/b]</b> - <i>[i][/i]</i> - <u>[u][/u]</u> - <s>[s][/s]</s> - <span style='text-decoration: overline'>[o][/o]</span> - <sup>[sup][/sup]</sup> - <sub>[sub][/sub]</sub>
<br>[c]<b>.::.</b>[/c] - [l]<b>::..</b>[/l] - [r]<b>..::</b>[/r] - [color=#][/color] - [size=#][/size] - <a href="#">[url=#][/url]</a> - [img]#[/img]
</div><?}
elseif(isset($id_forum) && $id_forum != "add") {
$get_forum = mssql_query("SELECT f_id,f_char,f_title,f_text,f_date,f_lostchar FROM MMW_forum WHERE f_id='$id_forum'");

  if(mssql_num_rows($get_forum) == 0){echo 'No Topic';}
  else
  {
    $row = mssql_fetch_row($get_forum);

	$result_char = mssql_query("SELECT AccountID,CtlCode FROM Character WHERE Name='$row[1]'");
	$row_char = mssql_fetch_row($result_char);
	$result_acc = mssql_query("SELECT country,gender,avatar FROM memb_info WHERE memb___id='$row_char[0]'");
	$row_acc = mssql_fetch_row($result_acc);

	if($row_acc[2] != "" && $row_acc[2] != " ") {$avatar_c_e="<img src='$row_acc[2]' width='110' alt='$row[1]' border='0'>";}
	else {$avatar_c_e="<img src='images/no_avatar.jpg' width='110' alt='No Аватор' border='0'>";}

      echo '
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="eBlock">
	<tr><td style="padding:2px;" width="110" valign="top" align="center">
	<a href="?op=character&character='.$row[1].'" class="level'.$row_char[1].'">
	'.$avatar_c_e.'<br/><b>' . $row[1] . '</b></a></td>
	<td style="padding:4px;" valign="top"><big><b>'.$row[2].'</b></big><br/>'.bbcode($row[3]).'</td></tr>
	</table>
      ';

	$c_id_blog = "2";
	$c_id_code = $id_forum;
	include("includes/comment.php");
  }

  $result = mssql_query("SELECT TOP 1 c_char,c_date FROM MMW_comment WHERE c_id_blog='$c_id_blog' AND c_id_code='$c_id_code' ORDER BY c_date DESC");
  if(mssql_num_rows($result) != 0) {
    $row = mssql_fetch_row($result);
    mssql_query("Update MMW_forum set [f_date]='$row[1]',[f_lostchar]='$row[0]' where f_id='$c_id_code'");
  }
}
elseif(isset($_SESSION['pass']) && isset($_SESSION['user'])) {
echo "$die_start Sorry, you can't add comment, need Character! $die_end";
}
else {
echo "$die_start Error! by Vaflan ;) $die_end";
}
?>