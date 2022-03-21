<?PHP
if($mmw[admin_check] < 1) {die("$die_start Security Admin Panel is Turn On $die_end");}

// Test
$sqlquery_query = "UPDATE table SET [column]=? WHERE [column]=?\n\nSELECT * FROM table WHERE [column]=?\n\ndeclare @hex varbinary(1920); set @hex=(SELECT Items FROM warehouse where AccountId='?'); print @hex;";

if(isset($_POST[sql_query_true])) {
 $sqlquery_query = str_replace("\'",'',$_POST[sqlquery_query]);
 $sqlquery_result = @mssql_query($sqlquery_query);
 if($sqlquery_result) {
  $query_result = "$warning_green Query done!";
  $log_dat = "Query: <b>$sqlquery_query</b> Has Been <font color=#FF0000>Injection</font>";
  writelog("a_sql_query",$log_dat);
 }
 else {
  $query_result = "$warning_red Error: $sqlquery_query";
 }
}

function sqlquery_result($sql_query,$sql_result) {
   $substr_query = substr($sql_query, 0, 6);
   if($substr_query == 'SELECT' || $substr_query == 'Select' || $substr_query == 'select') {
	$sql_query_array = preg_split("/[\s,]+/", $sql_query);
	if($sql_query_array[1] == '*') {
		$sql_column_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns where TABLE_NAME='$sql_query_array[3]'";
		$sql_column_query_result = @mssql_query($sql_column_query);
	}
	if($sql_query_array[3] == '*') {
		$sql_column_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns where TABLE_NAME='$sql_query_array[5]'";
		$sql_column_query_result = @mssql_query($sql_column_query);
	}
	echo "<br><b>Result:</b><br><div class='sized'>";
	echo "<table border='1' cellspacing='0' cellpadding='2'><tr><td><b>\n";
	$num = mssql_num_rows($sql_result);
	$column = mssql_num_fields($sql_result);
	for($i=0; $i < $num; $i++) {
		$row = mssql_fetch_row($sql_result);
		if($i == 0) {
			for($cn=0;$cn < $column; $cn++) {
				if(isset($sql_column_query)) {
					$sql_column_query_row = @mssql_fetch_row($sql_column_query_result);
					echo $sql_column_query_row[0];
				}
				elseif($sql_query_array[1] == 'TOP') {echo $sql_query_array[3+$cn];}
				else {echo $sql_query_array[1+$cn];}
				if($cn < $column - 1) {echo "</b></td><td><b>\n";}
			}
			echo "</b></td></tr>\n\n<tr><td>";
		}
		for($c=0; $c < $column; $c++) {
			echo $row[$c];
			if($c < $column - 1) {echo "</td><td>\n";}
		}
		if($i < $num - 1) {echo "</td></tr>\n\n<tr><td>";}
	}
	echo "</td></tr></table>\n</div>";
   }
   if($substr_query == 'DECLAR' || $substr_query == 'Declar' || $substr_query == 'declar') {
	mssql_query($sql_query);
	echo "<br><b>Result:</b><br>\n";
	echo "<textarea style='width:540; height:260;'>".mssql_get_last_message()."</textarea>\n";
   }
   if($substr_query == 'UPDATE' || $substr_query == 'Update' || $substr_query == 'update') {
	echo "<br><b>Result:</b><br>\n";
	echo $sql_query;
   }
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

<?if(isset($query_result)) {sqlquery_result($sqlquery_query,$sqlquery_result);}?>