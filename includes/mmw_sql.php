<?php
/*
	It's bridge from mssql to odbc
	Copyright by Ruslans Jermakovics [Vaflan]
	Version of bridge 2.0 - 23:39 08.04.2022
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
		);

		if (!extension_loaded('odbc')) {
			throw new Exception('ODBC extension not loaded. Please open php.ini and add odbc extension (extension=odbc)');
		}

		return true;
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
			return $mmwsql['connect'] = odbc_connect('Driver={SQL Server};Server={' . $mmwsql['host'] . '};Database={' . $mmwsql['dbnm'] . '};', $mmwsql['user'], $mmwsql['pass']);
		}
		return false;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_query($query, $link_identifier = null, $batch_size = 0)
	{
		global $mmwsql;
		$mmwsql['last_query'] = $query;
		$mmwsql['list'][] = array(
			'id' => @odbc_exec($link_identifier ? $link_identifier : $mmwsql['connect'], $query),
			'query' => $query,
		);
		$resourceId = end($mmwsql['list'])['id'];
		if ($resourceId === false) {
			throw new Exception(odbc_errormsg() . PHP_EOL . $query);
		}
		return $resourceId;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_fetch_row($result)
	{
		/* ODBC fetch_row have issue, hack by Vaflan .!.. */
		return mssql_fetch_array($result, MSSQL_NUM);
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_fetch_assoc($result_id)
	{
		if ($result = odbc_fetch_array($result_id)) {
			return $result;
		}
		return false;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_fetch_array($result, $result_type = MSSQL_BOTH)
	{
		$rows = mssql_fetch_assoc($result);
		if ($rows) {
			switch ($result_type) {
				case MSSQL_BOTH:
					return array_merge($rows, array_values($rows));
				case MSSQL_NUM:
					return array_values($rows);
				case MSSQL_ASSOC:
					return $rows;
			}
		}
		return false;
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_num_rows($result)
	{
		return odbc_num_rows($result);
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_result($result, $row = 0, $field = 0)
	{
		/* ODBC result haven't rows params, hack by Vaflan .!.. */
		$i = 0;
		while ($rows = @odbc_fetch_array($result)) {
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
		return odbc_errormsg($mmwsql['connect']);
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_num_fields($result)
	{
		return odbc_num_fields($result);
	}

	/**
	 * @deprecated After PHP 5.2
	 * @removed 7.0
	 */
	function mssql_close($link_identifier)
	{
		global $mmwsql;
		odbc_close($mmwsql['connect']);
		return $link_identifier === $mmwsql['connect'];
	}
}