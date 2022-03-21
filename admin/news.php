<?PHP if($_SESSION['a_admin_level'] < 1) {die("Security Admin Panel is Turn On"); exit();}

// For News module MMW
if(isset($_POST["add_new_news"])) {
 $news_title = $_POST['news_title'];
 $news_category = $_POST['category'];
 $news_row_1 = bugsend($_POST['news_row_1']);
 $news_row_2 = bugsend($_POST['news_row_2']);
 $news_row_3 = bugsend($_POST['news_row_3']);
 $news_autor = $_SESSION['a_admin_login'];
 $time = time();
 if(empty($news_title) || empty($news_category)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("INSERT INTO MMW_news(news_title,news_autor,news_category,news_date,news_row_1,news_row_2,news_row_3,news_id) VALUES ('$_POST[news_title]','$_SESSION[a_admin_login]','$_POST[category]','$time','$news_row_1','$news_row_2','$news_row_3','$mmw[rand_id]')");
  echo "$warning_green News SuccessFully Added!";
  writelog("a_news","News: $_POST[news_title] Has Been <font color=#FF0000>Added</font> Author: $_SESSION[a_admin_login]");
 }
}
if(isset($_POST["edit_news_done"])) {
 $news_title = $_POST['edit_news_title'];
 $news_autor = $_POST['edit_news_autor'];
 $news_cateogry = $_POST['category'];
 $news_id = $_POST['news_id'];
 $news_row_1 = bugsend($_POST['edit_news_row_1']);
 $news_row_2 = bugsend($_POST['edit_news_row_2']);
 $news_row_3 = bugsend($_POST['edit_news_row_3']);
 if(empty($news_title) || empty($news_autor) || empty($news_cateogry) ||  empty($news_id)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>";}
 else {
  mssql_query("UPDATE MMW_news SET [news_title]='$_POST[edit_news_title]',[news_autor]='$_POST[edit_news_autor]',[news_category]='$_POST[category]',[news_row_1]='$news_row_1',[news_row_2]='$news_row_2',[news_row_3]='$news_row_3' WHERE [news_id]='$_POST[news_id]'");
  echo "$warning_green News SuccessFully Edited!";
  writelog("a_news","News: $_POST[edit_news_title] Has Been <font color=#FF0000>Edited</font> Author: $_POST[edit_news_autor]");
 }
}
if(isset($_POST["delete_news"])) {
 $news_id = $_POST['delete_news'];
 if(empty($news_id)) {echo "$warning_red Error: Some Fields Were Left Blank!<br><a href='javascript:history.go(-1)'>Go Back.</a>"; }
 else {
  mssql_query("DELETE FROM MMW_news WHERE news_id='$news_id'");
  mssql_query("DELETE FROM MMW_comment WHERE c_id_code='$news_id'");
  echo "$warning_green News SuccessFully Deleted!";
  writelog("a_news","News: $_POST[news_title] Has Been <font color=#FF0000>Deleted</font>");
 }
}
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>

<?
if (isset($_POST["edit_news"])) {
$news_id = stripslashes($_POST['edit_news']);
$get_edit_news = mssql_query("Select news_title,news_autor,news_category,news_row_1,news_row_2,news_row_3 from MMW_news where news_id='$news_id'");
$get_edit_news_ = mssql_fetch_row($get_edit_news);
$news_row_1 = str_replace("[br]","\n",$get_edit_news_[3]);
$news_row_2 = str_replace("[br]","\n",$get_edit_news_[4]);
$news_row_3 = str_replace("[br]","\n",$get_edit_news_[5]);
?>
		<legend>Edit News</legend>
			<form action="" method="post" name="edit_news_form" id="edit_news_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td align="center" colspan="3">
				Author <input name="edit_news_autor" type="text" id="edit_news_autor" size="20" maxlength="20" value="<?echo $get_edit_news_[1];?>"> <input name="edit_news_done" type="hidden" id="edit_news_done" value="edit_news_done"> <input name="news_id" type="hidden" id="news_id" value="<?echo $news_id;?>"> Curent Category: <b><?echo $get_edit_news_[2];?></b> <br> 
				News Title <input name="edit_news_title" type="text" id="edit_news_title" maxlength="100" value="<?echo $get_edit_news_[0];?>">
				Category <select name="category" id="category"><option value="News">News</option><option value="Announcement">Announcement</option><option value="Patch">Patch</option><option value="Rules">Rules</option><option value="Event">Event</option></select>
			    </td>
			  </tr>
			  <tr>
			    <td align="center">
				News Row 1<br><textarea style="Width: 170px; Height: 120px;" name="edit_news_row_1"><?echo $news_row_1;?></textarea>
			    </td>
			    <td align="center">
				News Row 2<br><textarea style="Width: 170px; Height: 120px;" name="edit_news_row_2"><?echo $news_row_2;?></textarea>
			    </td>
			    <td align="center">
				News Row 3<br><textarea style="Width: 170px; Height: 120px;" name="edit_news_row_3"><?echo $news_row_3;?></textarea>
			    </td>
			  </tr>
			  <tr>
			    <td align="center" colspan="3">
				<input type="submit" name="Submit" value="Add News">
				<input type="reset" name="Reset" value="Reset">
			    </td>
			  </tr>
			</table>
			</form>
<?}else{?>
		<legend>Add News</legend>
			<form action="" method="post" name="new_news_form" id="new_news_form">
			<table width="100%" border="0" cellpadding="0" cellspacing="4" align="center">
			  <tr>
			    <td align="center" colspan="3">
				Title <input name="news_title" type="text" id="news_title" maxlength="100"> <input name="add_new_news" type="hidden" id="add_new_news" value="add_new_news">
				Category <select name="category" id="category"><option value="News">News</option><option value="Announcement">Announcement</option><option value="Patch">Patch</option><option value="Rules">Rules</option><option value="Event">Event</option></select></td>
			  </tr>
			  <tr>
			    <td align="center">
				News Row 1<br><textarea style="Width: 170px; Height: 120px;" name="news_row_1"></textarea>
			    </td>
			    <td align="center">
				News Row 2<br><textarea style="Width: 170px; Height: 120px;" name="news_row_2"></textarea>
			    </td>
			    <td align="center">
				News Row 3<br><textarea style="Width: 170px; Height: 120px;" name="news_row_3"></textarea>
			    </td>
			  </tr>
			  <tr>
			    <td align="center" colspan="3">
				<input type="submit" name="Submit" value="Add News">
				<input type="reset" name="Reset" value="Reset">
			    </td>
			  </tr>
			</table>
			</form>
<?}?>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td align="center">
		<fieldset>
		<legend>News List</legend>

<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
 <thead><tr>
  <td align="center">#</td>
  <td align="left">Title</td>
  <td align="left">Author</td>
  <td align="left">Category</td>
  <td align="left">Date</td>
  <td align="center">Edit</td>
  <td align="center">Delete</td>
 </tr></thead>
<?
$result = mssql_query("SELECT news_title,news_autor,news_category,news_date,news_id from MMW_news order by news_date desc");
for($i=0;$i < mssql_num_rows($result);++$i) {
 $row = mssql_fetch_row($result);
 $rank = $i+1;
 $news_table_edit = "<form action='' method='post'><input name='edit_news' type='hidden' value='$row[4]'><input type='submit' value='Edit'></form>";
 $news_table_delete = "<form action='' method='post'><input name='delete_news' type='hidden' value='$row[4]'><input  type='submit' value='Delete'></form>";

 $row[0] = substr($row[0],0,15);
 $row[3] = date("H:i, d.m.Y",$row[3]);
?>
 <tr>
  <td align='center'><?echo $rank;?>.</td>
  <td align='left'><?echo $row[0];?>...</td>
  <td align='left'><?echo $row[1];?></td>
  <td align='left'><?echo $row[2];?></td>
  <td align='left'><?echo $row[3];?></td>
  <td align='center'><?echo $news_table_edit;?></td>
  <td align='center'><?echo $news_table_delete;?></td>
 </tr>
<?}?>
</table>

		</fieldset>
		</td>
	</tr>
</table>