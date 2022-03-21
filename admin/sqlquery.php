<?PHP
if(isset($query_result)) {
$log_dat = "Query: <b>$sqlquery_query</b> Has Been <font color=#FF0000>Injection</font>";
writelog("sql_query",$log_dat);
}
echo $query_result;
?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
	<tr>
		<td align="center">
		<fieldset>
		<legend>SQL Query</legend>
			<form action="" method="post" name="new_server_form" id="new_server_form">
			<table width="100%" border="0" cellspacing="4" cellpadding="0">
			  <tr>
			    <td align="center"><textarea style="Width: 100%; Height: 140px;" name="sqlquery_query"><?echo $sqlquery_query;?></textarea></td>
			  </tr>
			  <tr>
			    <td align="center"><input type="submit" name="Submit" value="New SQL Query"> <input name="sql_query_true" type="hidden" id="sql_query_true" value="sql_query_true"> <input type="reset" name="Reset" value="Reset"></td>
			  </tr>
			</table>
			</form>
		</fieldset>
		</td>
	</tr>
</table>

<div class="sized">
<?if(isset($query_result)) {sqlquery_result($sqlquery_query,$sqlquery_result);}?>
</div>