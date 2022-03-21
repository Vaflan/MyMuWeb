<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}
if(isset($_POST["edit_news_done"])) {edit_news($_POST['edit_news_title'],$_POST['edit_news_autor'],$_POST['category'],$_POST['news_id'],$_POST['edit_news_row_1'],$_POST['edit_news_row_2'],$_POST['edit_news_row_3']);}
if(isset($_POST["delete_news"])) {delete_news($_POST['delete_news']);}
if(isset($_POST["add_new_news"])) {add_new_news($_POST['news_title'],$_POST['category'],$_POST['news_row_1'],$_POST['news_row_2'],$_POST['news_row_3'],$_SESSION['a_admin_login']);}					  
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
			<?include_once("admin/inc/news_list.php");?>
		</fieldset>
		</td>
	</tr>
</table>