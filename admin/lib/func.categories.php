<?php
function getCategory_info($category_id = '') {
	if ($category_id == '')
		$sql = "SELECT * FROM categories ORDER BY cat_id ASC";
	else
		$sql = "SELECT * FROM categories WHERE cat_id = '{$category_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function category_cardscount($category_id = '') {
	$sql = "SELECT * FROM cards WHERE cat_id='{$category_id}'";
	$res = mysql_query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

function addCategory($post) {
	extract($post);
	$category_title = mysql_real_escape_string($category_title);
	$sql_1 = sprintf("INSERT INTO categories (cat_title ) VALUES ('%s')", $category_title);
	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
		$okmsg = base64_encode("Information added successfully");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to add information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;
}

function updateCategory($post) {
	extract($post);
	$category_title = mysql_real_escape_string($category_title);
	$category_id = $category_id;
	$sql_1 = sprintf("UPDATE categories SET cat_title= '%s' WHERE cat_id='%s'", $category_title, $category_id);

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
		$okmsg = base64_encode("Information successfully updated");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;

}

function deleteCategory($category_id) {
	$sql = "DELETE FROM categories WHERE cat_id = '{$category_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}