<?php if (empty($_SESSION['admin']['level'])) {
	die('<u style="color:red">/!\</u> Access Denied!');
}

// SQL Query Analyzer by Vaflan
$exampleQuery = "UPDATE table SET [column]=? WHERE [column]=?\n\nSELECT * FROM table WHERE [column]=?\n\nSELECT CAST(Items AS varbinary(1920)) FROM warehouse WHERE AccountID='?'";

if (isset($_POST['sql_query_true'])) {
	$sqlQuery = str_replace(array('\"', '\''), array('"', ''), $_POST['sql_query']);
	if ($sqlQueryResult = mssql_query($sqlQuery)) {
		$queryResult = $mmw['warning']['green'] . 'Query done!';
		writelog('a_sql_query', 'Query: <b>' . $sqlQuery . '</b> Has Been <span style="color:red">Injection</span>');
	} else {
		$queryResult = $mmw['warning']['red'] . 'Error: ' . $sqlQuery;
	}
}

function sql_query_result($sqlQuery, $sqlResult)
{
	$substrQuery = strtolower(substr($sqlQuery, 0, 6));
	if ($substrQuery === 'select') {
		$sql_query_array = preg_split('/[\s,]+/', preg_replace('/\stop\s\d+\s/i', ' ', $sqlQuery));
		if ($sql_query_array[1] === '*') {
			$sql_column_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns where TABLE_NAME='$sql_query_array[3]'";
			$sql_column_query_result = mssql_query($sql_column_query);
		}
		echo '<div style="margin:15px;font-weight:bold">Result:</div><div class="sized">';
		echo '<table border="1" cellspacing="0" cellpadding="2"><thead><tr>' . PHP_EOL;
		$count = mssql_num_rows($sqlResult);
		$column = mssql_num_fields($sqlResult);
		for ($i = 0; $i < $count; $i++) {
			$row = mssql_fetch_row($sqlResult);
			if ($i === 0) {
				for ($cn = 0; $cn < $column; $cn++) {
					echo '<th>';
					if (isset($sql_column_query)) {
						$sql_column_query_row = mssql_fetch_row($sql_column_query_result);
						echo $sql_column_query_row[0];
					} else {
						echo $sql_query_array[1 + $cn];
					}
					echo '</th>' . PHP_EOL;
				}
				echo '</tr></thead><tbody>' . PHP_EOL;
			}
			echo '<tr><td>' . implode('</td><td>', $row) . '</td></tr>' . PHP_EOL;
		}
		echo '</tbody></table>' . PHP_EOL . '</div>';
	}
	if ($substrQuery === 'insert') {
		echo '<br><b>Result:</b><br>' . PHP_EOL
			. '<textarea style="width:540px;height:260px">' . mssql_get_last_message() . '</textarea>';
	}
	if ($substrQuery === 'update') {
		echo '<br><b>Result:</b><br>' . PHP_EOL
			. $sqlQuery;
	}
}

if (isset($queryResult)) {
	echo $queryResult;
}
?>

	<fieldset class="content">
		<legend>SQL Query</legend>
		<form method="post" action="">
			<input type="hidden" name="sql_query_true" value="sql_query_true">
			<div style="text-align:center;padding:4px">
				<textarea style="width:100%;height:140px" name="sql_query"><?php
					echo isset($sqlQuery) ? $sqlQuery : $exampleQuery;
					?></textarea>
			</div>
			<div style="text-align:center;padding:4px">
				<input type="submit" value="New SQL Query">
				<input type="reset" value="Reset">
			</div>
		</form>
	</fieldset>

<?php
if (isset($queryResult)) {
	sql_query_result($sqlQuery, $sqlQueryResult);
}