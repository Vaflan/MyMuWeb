<?
if(isset($_POST[sql_query])) {$sql_query=stripslashes($_POST[sql_query]);}
else {$sql_query="UPDATE table SET [row]='?' WHERE [row]='?'";}

if(isset($_POST["sql_query_true"])) {
	if(mssql_query($sql_query))
		{echo "All done!";}
	else
		{echo "Error: $sql_query";}
}
?>

<table width="400" border="0" align="center" cellpadding="0" cellspacing="4">
  <tr>
    <td scope="row">
			<fieldset>
			<legend>SQL Query</legend>
                                  <form action="" method="post" name="new_server_form" id="new_server_form">
                                          <table width="100%" border="0" cellspacing="4" cellpadding="0">
                                            <tr>
                                              <td scope="row" align="center"><textarea style="Width: 385px; Height: 120px;" name="sql_query"><?echo $sql_query;?></textarea></td>
                                            </tr>
                                            <tr>
                                              <td scope="row" align="center"><input type="submit" name="Submit" value="New SQL Query" class="button"> <input name="sql_query_true" type="hidden" id="sql_query_true" value="sql_query_true"> <input type="reset" name="Reset" value="Reset" class="button"></td>
                                            </tr>
                                          </table>
                                  </form>
			</fieldset>
    </td>
  </tr>
</table>