<?php
function addAlbumTpl($post) {
	extract($post);
	$tplTitle = mysql_real_escape_string($tplTitle);
	$templateHtml = mysql_real_escape_string($pageHtml_txt);
	$templateElementCounter = $totalPgElements;
	$templateDimension = $appliedTemplateDimension;

	$tplFileName = '';
	// will be updated after picture upload

	if ($_FILES['tpl_preview']["name"]) {
		$fileNameHandler = $_FILES['tpl_preview']["name"];
		$file_newName = 'albumTpl_' . date("mdyHis");
		$tplFileName = uploadPhoto('../../uploads/core/tpl_shots/', $_FILES['tpl_preview'], $file_newName);
	}

	/* tpl_leftside_html,	tpl_rightside_html */

	$packages_ids_str = ",";
	// value in this column will be like: ,1,2,3,..., means we could run ',3,' like query
	foreach ($package_types as $packageId)
		$packages_ids_str .= $packageId . ',';

	$sql_1 = sprintf("
		INSERT INTO album_templates SET 
		tpl_name = '%s',
		tpl_screenshot_path = '%s',
		tpl_for_packages = '%s',
		tpl_html = '%s', 
		tpl_objects_count = '%s',
		tpl_dimension = '%s'", 
		mysql_real_escape_string($tplTitle), 
		mysql_real_escape_string($tplFileName), 
		mysql_real_escape_string($packages_ids_str), 
		mysql_real_escape_string($templateHtml), 
		mysql_real_escape_string($templateElementCounter), 
		mysql_real_escape_string($templateDimension));

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
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

function updateAlbumTpl($post) {
	extract($post);
	$tplId = $tpl_id;

	$tplTitle = mysql_real_escape_string($tplTitle);
	$templateHtml = mysql_real_escape_string($pageHtml_txt);
	$templateElementCounter = $totalPgElements;
	$templateDimension = $appliedTemplateDimension;

	$tplFileName = '';

	if ($_FILES['tpl_preview']["name"] && $_FILES['tpl_preview']["name"] != "") {
		$fileNameHandler = $_FILES['tpl_preview']["name"];
		$file_newName = 'albumTpl_' . date("mdyHis");
		$tplFileName = uploadPhoto('../../uploads/core/tpl_shots/', $_FILES['tpl_preview'], $file_newName);
	}

	$packages_ids_str = ",";
	// value in this column will be like: ,1,2,3,..., means we could run ',3,' like query
	foreach ($package_types as $packageId)
		$packages_ids_str .= $packageId . ',';

	if ($tplFileName != "")
		$sql_1 = sprintf("
			UPDATE album_templates  SET   
			tpl_name = '%s',
			tpl_screenshot_path = '%s', 
			tpl_for_packages = '%s',
			tpl_html = '%s', 
			tpl_objects_count = '%s',
			tpl_dimension = '%s' 
			WHERE tpl_id = '%s'", 
			mysql_real_escape_string($tplTitle), 
			mysql_real_escape_string($tplFileName), 
			mysql_real_escape_string($packages_ids_str), 
			mysql_real_escape_string($templateHtml), 
			mysql_real_escape_string($templateElementCounter), 
			mysql_real_escape_string($templateDimension), 
			mysql_real_escape_string($tplId));
	else
		$sql_1 = sprintf("
			UPDATE album_templates  SET   
			tpl_name = '%s',
			tpl_for_packages = '%s',
			tpl_html = '%s', 
			tpl_objects_count = '%s',
			tpl_dimension = '%s' 
			WHERE tpl_id = '%s'", 
			mysql_real_escape_string($tplTitle), 
			mysql_real_escape_string($packages_ids_str), 
			mysql_real_escape_string($templateHtml), 
			mysql_real_escape_string($templateElementCounter), 
			mysql_real_escape_string($templateDimension), 
			mysql_real_escape_string($tplId)
		);
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

function getAlbumTpl_info($tpl_id = '') {
	if ($tpl_id == '')
		$sql = "SELECT * FROM album_templates ORDER BY tpl_id ASC";
	else
		$sql = "SELECT * FROM album_templates WHERE tpl_id = '$tpl_id'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function getTplDimensions() {
	$sql = "SELECT DISTINCT(tpl_dimension) AS tpl_dimension FROM album_templates";
	$res = mysql_query($sql);
	return $res;
}

function getTplDimensions_optionsHTML() {
	$res = getTplDimensions();
	$output = "";
	while ($rec = mysql_fetch_array($res)) {
		$output .= "<option value='" . $rec['tpl_dimension'] . "'>" . $rec['tpl_dimension'] . "</option>";
	}
	return $output;
}

function deleteTpl($tpl_id) {
	$sql = "DELETE FROM album_templates WHERE tpl_id = '$tpl_id'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}