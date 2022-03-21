<?PHP
// SQL Query
// By Vaflan For MMW

if(isset($_SESSION['a_admin_login'],$_SESSION['a_admin_pass'],$_SESSION['a_admin_security'],$_SESSION['a_admin_level'])){

   if(isset($_POST[sqlquery_query])) {$sqlquery_query = $_POST[sqlquery_query];}
   else {$sqlquery_query = "UPDATE table SET [column]=? WHERE [column]=?\n\nSELECT * FROM table WHERE [column]=?\n\ndeclare @hex varbinary(1920); set @hex=(SELECT Items FROM warehouse where AccountId='?'); print @hex;";}

   if(isset($_POST["sql_query_true"])) {
	if($sqlquery_result = mssql_query($sqlquery_query))
		{$query_result = "$warning_green Query done!";}
	else
		{$query_result = "$warning_red Error: $sqlquery_query";}
   }

   function sqlquery_result($sql_query,$sql_result) {
	$substr_query = substr($sql_query, 0, 6);
	if($substr_query == 'SELECT' || $substr_query == 'Select' || $substr_query == 'select') {
	   echo "<br><b>Result:</b><br>";
	   echo "<table border='1' cellspacing='0' cellpadding='2'><tr><td>\n";
	   $num = mssql_num_rows($sql_result);
	   $column = mssql_num_fields($sql_result);
	   for($i=0;$i < $num; ++$i) {
		$row = mssql_fetch_row($sql_result);
		   for($c=0;$c < $column;++$c) {
			echo $row[$c];
			if($c < $column - 1){echo "</td><td>\n";}
		   }
		if($i < $num - 1){echo "</td></tr>\n\n<tr><td>";}
	   }
	   echo "</td></tr></table>\n";
	}
	if($substr_query == 'DECLAR' || $substr_query == 'Declar' || $substr_query == 'declar') {
	   mssql_query($sql_query);
	   echo "<br><b>Result:</b><br>\n";
	   echo "<textarea style='width:540; height:260;'>".mssql_get_last_message()."</textarea>\n";
	}
   }

}
?>