<?php
function addBanner($post) {
	extract($post);
	$banner_fileName = '';
	if ($_FILES['banner_file']["name"]) {
		$fileNameHandler = $_FILES['banner_file']["name"];
		$file_newName = 'af_banner_' . date("mdyHis");
		$banner_fileName = uploadPhoto('../../uploads/affiliate_banners/', $_FILES['banner_file'], $file_newName);
	}
	
	$sql_1 = sprintf("
		INSERT INTO affiliate_banners SET 
		banner_title = '%s',
		banner_path = '%s',
		banner_width_px = '%s', 
		banner_height_px= '%s'", 
		mysql_real_escape_string($bannerTitle), 
		mysql_real_escape_string($banner_fileName), 
		mysql_real_escape_string($banner_width), 
		mysql_real_escape_string($banner_height)
	);

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

function updateBanner($post) {
	extract($post);

	$bannerTitle = mysql_real_escape_string($banner_title);
	$banner_fileName = '';
	$old_banner_fileName = $old_banner_filename;

	if ($_FILES['banner_file']["name"]) {
		$fileNameHandler = $_FILES['banner_file']["name"];
		$file_newName = 'af_banner_' . date("mdyHis");
		$banner_fileName = uploadPhoto('../../uploads/affiliate_banners/', $_FILES['banner_file'], $file_newName);
		@unlink('../../uploads/affiliate_banners/' . $old_banner_filename);
		
		$sql_1 = sprintf("
			UPDATE affiliate_banners  SET   
			banner_title = '%s', 
			banner_path = '%s',
			banner_width_px = '%s', banner_height_px= '%s'
			WHERE affiliate_banner_id= '%s' ", 
			mysql_real_escape_string($bannerTitle), 
			mysql_real_escape_string($banner_fileName), 
			mysql_real_escape_string($banner_width), 
			mysql_real_escape_string($banner_height),
			mysql_real_escape_string($banner_id)
		);
	} else
		$sql_1 = sprintf("
			UPDATE affiliate_banners  SET   
			banner_title = '%s',
			banner_width_px = '%s', 
			banner_height_px= '%s'
			WHERE affiliate_banner_id= '%s' ",
			mysql_real_escape_string($bannerTitle), 
			mysql_real_escape_string($banner_width), 
			mysql_real_escape_string($banner_height),
			mysql_real_escape_string($banner_id) 
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

function getBanner($banner_id = '') {
	if ($banner_id == '')
		$sql = "SELECT * FROM affiliate_banners ORDER BY affiliate_banner_id ASC";
	else
		$sql = "SELECT * FROM affiliate_banners WHERE affiliate_banner_id = '$banner_id'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function deleteBanner($banner_id) {
	$sql = "DELETE FROM affiliate_banners WHERE affiliate_banner_id = '$banner_id'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}