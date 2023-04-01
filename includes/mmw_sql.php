<?php
/*
	It's bridge from mssql to pdo
	Copyright by Ruslans Jermakovics [Vaflan]
	Version of bridge 3.0 - 00:00 08.03.2023
	Insert to config.php: require_once __DIR__ . '/includes/mmwsql.php';
*/

if (!function_exists('mssql_connect')) {
	defined('MSSQL_ASSOC') or define('MSSQL_ASSOC', 1, false);
	defined('MSSQL_NUM') or define('MSSQL_NUM', 2, false);
	defined('MSSQL_BOTH') or define('MSSQL_BOTH', 3, false);

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_connect($servername = null, $username = null, $password = null, $new_link = false)
	{
		global $mmwsql;

		$mmwsql = array(
			'connect' => true,
			'host' => $servername,
			'user' => $username,
			'pass' => $password,
			'driver' => $mmwsql['driver'] ?: 'odbc:Driver={SQL Server};Server={%host%};Database={%dbnm%};',
		);
		// Example Linux with dblib: $mmwsql['driver'] = 'dblib:host=%host%;dbname=%dbnm%';

		if (!extension_loaded('pdo')) {
			throw new Exception('PDO extension not loaded. Please open php.ini and add pdo extension');
		}

		return $mmwsql['connect'];
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_select_db($database_name, $link_identifier = null)
	{
		global $mmwsql;

		$mmwsql['dbnm'] = $database_name;
		if ($link_identifier) {
			$mmwsql['connect'] = new PDO(
				str_replace(
					array_map(static function ($value) {
						return '%' . $value . '%';
					}, array_keys($mmwsql)),
					array_values($mmwsql),
					$mmwsql['driver']
				),
				$mmwsql['user'],
				$mmwsql['pass']
			);
			$mmwsql['list'] = array();
		}

		return $mmwsql['connect'];
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_query($query, $link_identifier = null, $batch_size = 0)
	{
		global $mmwsql;

		$lastQuery = end($mmwsql['list']);
		if ($lastQuery['id']) {
			$lastQuery['id']->closeCursor();
		}

		$mmwsql['last_query'] = $query;
		$mmwsql['list'][] = array(
			'id' => $mmwsql['connect']->query($query),
			'query' => $query,
		);
		$resourceId = end($mmwsql['list'])['id'];
		if ($resourceId === false) {
			throw new Exception(mssql_get_last_message() . PHP_EOL . $query);
		}

		return $resourceId;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_fetch_row($result)
	{
		return mssql_fetch_array($result, MSSQL_NUM);
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_fetch_assoc($result_id)
	{
		/** @var $result_id PDOStatement */

		// Important BOTH! mssql_fetch_assoc have issue, hack by Vaflan .!..
		if ($data = $result_id->fetch(PDO::FETCH_BOTH)) {
			return $data;
		}

		return false;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_fetch_array($result, $result_type = MSSQL_BOTH)
	{
		/** @var $result PDOStatement */
		switch ($result_type) {
			case MSSQL_NUM:
				$pdoFetch = PDO::FETCH_NUM;
				break;
			case MSSQL_ASSOC:
				$pdoFetch = PDO::FETCH_ASSOC;
				break;
			default:
				$pdoFetch = PDO::FETCH_BOTH;
		}

		return $result->fetch($pdoFetch) ?: false;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_num_rows($result)
	{
		global $mmwsql;

		/** @var $result PDOStatement */
		$count = $result->rowCount();
		if ($count === -1) {
			//trigger_error('[mssql_num_rows] PDO cant return correct row count');
			$result->closeCursor();
			$countQuery = preg_replace('/^SELECT(.*?)FROM/is', 'SELECT COUNT(*) FROM', $result->queryString);
			if (strpos($countQuery, 'ORDER BY') !== false) {
				$countQuery = substr($countQuery, 0, strpos($countQuery, 'ORDER BY'));
			}
			$count = (int)$mmwsql['connect']->query($countQuery)->fetchColumn();
			$result->execute();
		}

		return $count;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_result($result, $row = 0, $field = 0)
	{
		/** @var $result PDOStatement */

		/* PDO result haven't rows params, hack by Vaflan .!.. */
		$i = 0;
		while ($rows = $result->fetch(PDO::FETCH_BOTH)) {
			if ($i == $row) {
				foreach ($rows as $k => $v) {
					if ($k == $field) {
						return $v;
					}
				}
			}
			$i++;
		}

		return false;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_get_last_message()
	{
		global $mmwsql;

		$errorInfo = $mmwsql['connect']->errorInfo();

		return $errorInfo[2] ?: reset($errorInfo);
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_num_fields($result)
	{
		/** @var $result PDOStatement */
		return $result->columnCount();
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_close($link_identifier)
	{
		global $mmwsql;

		$isCurrentConnection = ($link_identifier === $mmwsql['connect']);
		unset($mmwsql['connect']);

		return $isCurrentConnection;
	}
}