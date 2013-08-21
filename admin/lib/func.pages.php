<?php
function addPage($post) {
	extract($post);
	$pageName = mysql_real_escape_string($pageName);
	$pageSlug = mysql_real_escape_string($pageSlug);
	$pageContent = mysql_real_escape_string($pageContent);
	$picFileName = '';
	
	if ($_FILES['page_banner']["name"]) {
		$fileNameHandler = $_FILES['page_banner']["name"];
		$file_newName = 'pbanner_' . date("mdyHis");
		$picFileName = uploadPhoto('../../uploads/page_banner/', $_FILES['page_banner'], $file_newName);
	}

	$sql = sprintf("
		INSERT INTO pages  SET  
		page_name = '%s',   
		page_slug = '%s', 
		page_content = '%s', 
		banner_image='%s', 
		banner_position='%s'", 
		$pageName, $pageSlug, $pageContent, $picFileName, $banner_position
	);

	$returnData = array();
	if (mysql_query($sql) or die(mysql_error())) {
		$okmsg = base64_encode("Information successfully added");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;
}

function updatePage($post) {
	extract($post);
	$pageName = mysql_real_escape_string($pageName);
	$pageSlug = mysql_real_escape_string($pageSlug);
	$pageContent = mysql_real_escape_string($pageContent);
	$page_id = mysql_real_escape_string($page_id);

	$picFileName = $oldpic;
	// will be updated after picture upload, initialization to retain old image

	if ($_FILES['page_banner']["name"]) {
		$fileNameHandler = $_FILES['page_banner']["name"];
		$file_newName = 'pbanner_' . date("mdyHis");
		$picFileName = uploadPhoto('../../uploads/page_banner/', $_FILES['page_banner'], $file_newName);
		@unlink('../../uploads/page_banner/' . $oldpic);
	}

	$sql = sprintf("
		UPDATE pages  SET  
		page_name = '%s',   
		page_slug = '%s', 
		page_content = '%s', 
		banner_image='%s', 
		banner_position='%s'
		WHERE page_id='%s'", 
		$pageName, $pageSlug, $pageContent, $picFileName, $banner_position, $page_id
	);

	$returnData = array();
	if (mysql_query($sql) or die(mysql_error())) {
		$okmsg = base64_encode("Information successfully added");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;
}

function getPages_info($page_id = '') {
	if ($page_id == '')
		$sql = "SELECT * FROM pages ORDER BY page_id ASC";
	else
		$sql = "SELECT * FROM pages WHERE page_id = '{$page_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function deletePage($page_id) {
	$sql = "DELETE FROM pages WHERE page_id = '{$page_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}