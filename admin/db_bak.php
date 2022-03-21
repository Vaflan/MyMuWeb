<?PHP
include("config.php");

$query = "Select AccountID,extMoney FROM warehouse";

$sql = mssql_query($query);

$num = mssql_num_rows($sql);

for($i=0; $i < $num; ++$i) {
	$row = mssql_fetch_row($sql);

	$db = $db . "\$acc[$i] = \"$row[0]\"; \$ewh[$i] = \"$row[1]\";\n";
 }

		$file="db.php";

$db = "<?PHP\n include(\"config.php\"); \n \$total_row = \"$num\"; \n " . $db;
$db = $db . " \n \n for(\$i=0; \$i < \$total_row; ++\$i) {mssql_query(\"UPDATE warehouse SET [extMoney]='\$ewh[\$i]' WHERE AccountID='\$acc[\$i]'\");} ?>";
$db = $db . "<?\n if(\$i = \$total_row){echo \"\$okey_start DB save! \$okey_end\";} \n?>";


		$fp = fopen($file, 'w');
		fputs($fp, $db);
		fclose($fp);

echo "$okey_start db.php created! ;) $okey_end";
?>