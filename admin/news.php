<?PHP
if (isset($_POST["edit_news_done"])){edit_news($_POST['edit_news_title'],$_POST['edit_news_autor'],$_POST['category'],$_POST['news_id'],$_POST['edit_news_eng'],$_POST['edit_news_rus']);}
if (isset($_POST["delete_news"])){delete_news($_POST['news_id']);}
if (isset($_POST["add_new_news"])){add_new_news($_POST['news_title'],$_POST['news_autor'],$_POST['category'],$_POST['news_eng'],$_POST['news_rus']);}					  
?>

<table width="500" border="0" align="center" cellpadding="0" cellspacing="4">

<?
if (isset($_POST["edit_news"])) {
$news_id = stripslashes($_POST['news_id']);
$get_edit_news = mssql_query("Select news_title,news_autor,news_category,news_eng,news_rus from MMW_news where news_id='$news_id'");
$get_edit_news_ = mssql_fetch_row($get_edit_news);
$news_eng = $get_edit_news_[3]; $news_rus = $get_edit_news_[4];

echo '                                  <tr>
                                          <td align="center">
                                              <fieldset>
                                              <legend>Edit News</legend>
                                                    <form action="" method="post" name="edit_news_form" id="edit_news_form">
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="4">
                                                          <tr>
                                                            <td width="63" scope="row"><div align="right"  class="text_administrator">News Title </div></td>
                                                            <td scope="row"><input name="edit_news_title" type="text" id="edit_news_title" size="40" maxlength="100" value="'.$get_edit_news_[0].'"></td>
                                                          </tr>
                                                          <tr>
                                                            <td scope="row"><div align="right" class="text_administrator">Author</div></td>
                                                            <td scope="row"><input name="edit_news_autor" type="text" id="edit_news_autor" size="20" maxlength="20" value="'.$get_edit_news_[1].'">
                                                                            <input name="edit_news_done" type="hidden" id="edit_news_done" value="edit_news_done">
                                                                            <input name="news_id" type="hidden" id="news_id" value="'.$news_id.'"></td>
                                                          </tr>
                                                          <tr>
                                                            <td scope="row"><div align="right" class="text_administrator">Category</div></td>
                                                            <td scope="row"><select name="category" id="category">
                                                              <option value="NEWS">NEWS</option>
                                                              <option value="ANNOUNCEMENT">ANNOUNCEMENT</option>
                                                              <option value="PATCH">PATCH</option>
                                                              <option value="RULES">RULES</option>
                                                              <option value="EVENT">EVENT</option>
                                                            </select><span class="text_administrator">Curent('.$get_edit_news_[2].')</span></td>
                                                          </tr>
                                                        </table>
                                                        <table width="100%" border="0" align="center">
                                                          <tr>
                                                            <td align="center">
								English:<br><textarea style="Width: 465px; Height: 120px;" name="edit_news_eng">'.$get_edit_news_[3].'</textarea><br>
								Russian:<br><textarea style="Width: 465px; Height: 120px;" name="edit_news_rus">'.$get_edit_news_[4].'</textarea><br>  
                                                            </td>
                                                          </tr>
                                                        </table>
                                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
                                                          <tr>
                                                            <td width="50%" scope="row" align="right"><input type="submit" name="Submit" value="Add News" class="button"></td>
                                                            <td width="50%" scope="row" align="left"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                                          </tr>
                                                        </table>
                                                    </form>
                                              </fieldset>
                                          </td>
                                        </tr>';
}else{
echo '                                  <tr>
                                          <td align="center">
                                              <fieldset>
                                              <legend>Add New News </legend>
                                                    <form action="" method="post" name="new_news_form" id="new_news_form">
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="4">
                                                          <tr>
                                                            <td width="63" scope="row"><div align="right"  class="text_administrator">News Title </div></td>
                                                            <td scope="row"><input name="news_title" type="text" id="news_title" size="40" maxlength="100"></td>
                                                          </tr>
                                                          <tr>
                                                            <td scope="row"><div align="right" class="text_administrator">Author</div></td>
                                                            <td scope="row"><input name="news_autor" type="text" id="news_autor" size="20" maxlength="20"><input name="add_new_news" type="hidden" id="add_new_news" value="add_new_news"></td>
                                                          </tr>
                                                          <tr>
                                                            <td scope="row"><div align="right" class="text_administrator">Category</div></td>
                                                            <td scope="row"><select name="category" id="category">
                                                              <option value="NEWS">NEWS</option>
                                                              <option value="ANNOUNCEMENT">ANNOUNCEMENT</option>
                                                              <option value="PATCH">PATCH</option>
                                                              <option value="RULES">RULES</option>
                                                              <option value="EVENT">EVENT</option>
                                                            </select></td>
                                                          </tr>
                                                        </table>
                                                        <table width="100%" border="0" align="center">
                                                          <tr>
                                                            <td align="center">
								English:<br><textarea style="Width: 465px; Height: 120px;" name="news_eng"></textarea><br>
								Russian:<br><textarea style="Width: 465px; Height: 120px;" name="news_rus"></textarea><br>  
                                                            </td>
                                                          </tr>
                                                        </table>
                                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
                                                          <tr>
                                                            <td width="50%" scope="row" align="right"><input type="submit" name="Submit" value="Add News" class="button"></td>
                                                            <td width="50%" scope="row" align="left"><input type="reset" name="Reset" value="Reset" class="button"></td>
                                                          </tr>
                                                        </table>
                                                    </form>
                                              </fieldset>
                                          </td>
                                        </tr>';
}?>
	<tr>
		<td>
			<?include_once("admin/inc/news_list.php");?>
		</td>
	</tr>
</table>