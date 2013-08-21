<?php
class clsDatabaseManager {
	var $strTableName;
	var $strColumns;
	var $strWhere;
	var $strOrderBy;
	var $strGroupBy;
	var $nLimit;
	var $nLimitEnd;
	function SelectTable($strTableName, $strColumns = ' * ', $strWhere = '', $strOrderBy = '', $strGroupBy = '', $nLimit = "", $nLimitEnd = "") {
		if ($strWhere != '')
			$strQry = 'SELECT DISTINCT ' . $strColumns . ' FROM ' . $strTableName . ' WHERE ' . $strWhere;
		else
			$strQry = 'SELECT DISTINCT ' . $strColumns . ' FROM ' . $strTableName;

		if ($strGroupBy != '')
			$strQry .= ' Group BY ' . $strGroupBy;

		if ($strOrderBy != '')
			$strQry .= ' ORDER BY ' . $strOrderBy;

		if ($nLimitEnd != "")
			$strQry .= ' LIMIT ' . $nLimit . ',' . $nLimitEnd;
		elseif ($nLimit != "")
			$strQry .= ' LIMIT ' . $nLimit;
		$result = mysql_query($strQry) or die("Unable to select, Error: " . mysql_error());
		return $result;

	}

	function DeleteTable($strTableName, $strWhere = '')	{
		if ($strWhere == '')
			die('Cannot delete all rows in the table');
		$strQry = "DELETE FROM {$strTableName} WHERE {$strWhere}";
		mysql_query($strQry) or die("Unable to delete, Error: " . mysql_error());

		return mysql_affected_rows();
	}

	
	function DeleteAllTable($strTableName) {
		$strQry = 'DELETE FROM ' . $strTableName;
		mysql_query($strQry) or die("Unable to delete, Error: " . mysql_error());
		return mysql_affected_rows();
	}

	function UpdateTable($strTableName, $strUpdateData = '', $strWhere = '') {
		if ($strWhere == '')
			die('Cannot update all rows in the table');
		if ($strUpdateData == '')
			die('What to update?');
		$strQry = 'UPDATE ' . $strTableName . ' SET ' . $strUpdateData . ' WHERE ' . $strWhere;
		
		mysql_query($strQry) or die("Unable to update, Error: " . mysql_error());
		return mysql_affected_rows();
	}

	function InsertTable($strTableName, $strColumns = '', $strValues = '') {
		if ($strValues == '')
			die('What to insert?');
		if ($strColumns == '')
			$strQry = 'INSERT INTO ' . $strTableName . ' VALUES(' . $strValues . ')';
		else
			$strQry = 'INSERT INTO ' . $strTableName . '(' . $strColumns . ') VALUES(' . $strValues . ')';
		
		mysql_query($strQry) or die("Unable to insert, Error: " . mysql_error());
		return mysql_affected_rows();
	}

	function InsertSelect($strTableName, $strColumns = '', $strQuery = '') {
		if ($strQuery == '')
			error('What to insert?');
		if ($strQuery == '')
			error('Nothing to select!');
		if ($strColumns == '')
			$strQry = 'INSERT INTO ' . $strTableName . ' ' . $strQuery;
		else
			$strQry = 'INSERT INTO ' . $strTableName . '(' . $strColumns . ') ' . $strQuery;

		mysql_query($strQry) or die("Unable to insert, Error: " . mysql_error());
		return mysql_affected_rows();
	}

	function InsertAutoTable($strTableName, $strColumns = '', $strValues = '') {

		if ($strValues == '')
			die('What to insert?');
		if ($strColumns == '')
			$strQry = 'INSERT INTO ' . $strTableName . ' VALUES(' . $strValues . ')';
		else
			$strQry = 'INSERT INTO ' . $strTableName . '(' . $strColumns . ') VALUES(' . $strValues . ')';

		mysql_query($strQry) or die("Unable to insert auto, Error: " . mysql_error());
		return mysql_insert_id();
	}

	function GetTableFields($strTableName) {
		$strFields = "";
		$strQry = 'SHOW COLUMNS FROM ' . $strTableName;

		$rsTableFields = mysql_query($strQry) or die("Unable to select fields Error: " . mysql_error());
		if (mysql_num_rows($rsTableFields) > 0) {
			while ($objTableFields = mysql_fetch_object($rsTableFields)) {
				$strFields = $strFields . $objTableFields -> Field . ",";
			}
			$strFields = substr($strFields, 0, strlen($strFields) - 1);
			return $strFields;
		} else
			return false;
	}

	function GetTableData($TabelName, $SortField, $SordOrder = 'ASC') {
		$rsSql = mysql_query("SELECT * FROM `" . $TabelName . "` ORDER BY `" . $SortField . "` " . $SordOrder . "") or die(mysql_error());
		if (mysql_num_rows($rsSql) > 0)
			return $rsSql;
		else
			return false;
	}

	function insert_record($strTableName, $strColumns = '', $strValues = '')//returns current row id
	{
		if ($strValues == '')
			die('What to insert?');
		if ($strColumns == '')
			$strQry = 'INSERT INTO ' . $strTableName . ' VALUES(' . $strValues . ')';
		else
			$strQry = 'INSERT INTO ' . $strTableName . '(' . $strColumns . ') VALUES(' . $strValues . ')';
		mysql_query($strQry);
		return mysql_insert_id();
	}

	function select_table_join($sql, $where = '', $orderBy = '', $limit = '') {
		if ($where != '')
			$sql .= " WHERE $where";

		if ($orderBy != '')
			$sql .= " ORDER BY $orderBy";

		if ($limit != '')
			$sql .= " LIMIT $limit";

		$rsSql = mysql_query($sql) or die(mysql_error() . $sql);
		if (mysql_num_rows($rsSql) > 0)
			return $rsSql;
		else
			return false;
	}
}