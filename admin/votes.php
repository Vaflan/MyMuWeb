<?
if(isset($_POST["delete_id_vote"])){delete_vote($_POST["delete_id_vote"]);}
if(isset($_POST["new_id_vote"])){add_vote($_POST['question'],$_POST['answer1'],$_POST['answer2'],$_POST['answer3'],$_POST['answer4'],$_POST['answer5'],$_POST['answer6']);}
if(isset($_POST["edit_id_vote"])){edit_vote($_POST["edit_id_vote"],$_POST['question'],$_POST['answer1'],$_POST['answer2'],$_POST['answer3'],$_POST['answer4'],$_POST['answer5'],$_POST['answer6']);}
?>
<table width="260" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td align="center">
<?
if(isset($_POST["edit"])) {
$edit = stripslashes($_POST['edit']);
$edit_result = mssql_query("SELECT ID,question,answer1,answer2,answer3,answer4,answer5,answer6 FROM MMW_votemain WHERE ID='$edit'");
$edit_row = mssql_fetch_row($edit_result);

echo '
                                  <fieldset>
                                  <legend>Edit Vote</legend>
                                  <form action="" method="post" name="edit_form" id="edit_form">
                                          <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                            <tr>
                                              <td><div align="right" class="text_administrator">Question</div></td>
                                              <td><input name="question" type="text" id="question" value="'.$edit_row[1].'"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 1</div></td>
                                              <td><input name="answer1" type="text" id="answer1" value="'.$edit_row[2].'"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 2</div></td>
                                              <td><input name="answer2" type="text" id="answer2" value="'.$edit_row[3].'"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 3</div></td>
                                              <td><input name="answer3" type="text" id="answer3" value="'.$edit_row[4].'"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 4</div></td>
                                              <td><input name="answer4" type="text" id="answer4" value="'.$edit_row[5].'"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 5</div></td>
                                              <td><input name="answer5" type="text" id="answer5" value="'.$edit_row[6].'"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 6</div></td>
                                              <td><input name="answer6" type="text" id="answer6" value="'.$edit_row[7].'"></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" align="center"><input type="submit" value="Edit" class="button"> <input name="edit_id_vote" type="hidden" value="'.$edit_row[0].'"> <input type="reset" name="Reset" value="Reset" class="button"></td>
                                            </tr>
                                          </table>
                                  </form>
                                  </fieldset>
';}
else{
echo '
                                  <fieldset>
                                  <legend>Add New Vote</legend>
                                  <form action="" method="post" name="new_form" id="new_form">
                                          <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                            <tr>
                                              <td><div align="right" class="text_administrator">Question</div></td>
                                              <td><input name="question" type="text" id="question" maxlength="100"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 1</div></td>
                                              <td><input name="answer1" type="text" id="answer1"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 2</div></td>
                                              <td><input name="answer2" type="text" id="answer2"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 3</div></td>
                                              <td><input name="answer3" type="text" id="answer3"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 4</div></td>
                                              <td><input name="answer4" type="text" id="answer4"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 5</div></td>
                                              <td><input name="answer5" type="text" id="answer5"></td>
                                            </tr>
                                            <tr>
                                              <td><div align="right" class="text_administrator">Answer 6</div></td>
                                              <td><input name="answer6" type="text" id="answer6"></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" align="center"><input type="submit" value="New" class="button"> <input name="new_id_vote" type="hidden" value="new"> <input type="reset" name="Reset" value="Reset" class="button"></td>
                                            </tr>
                                          </table>
                                  </form>
                                  </fieldset>';
}
?>
    </td>
  </tr>
</table>

<table width="560" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td scope="row" align="center">
        <?include_once("admin/inc/vote_list.php");?>
    </td>
  </tr>
</table>
