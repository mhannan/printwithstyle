<?php
function addEnvelop($post) {
	extract($post);
	$envelopName = mysql_real_escape_string($title);
	$envelop_price = mysql_real_escape_string($envelop_price_per_card);
	if ($envelop_price == '')
		$envelop_price = '0.00';

	$extra_envelop_price = mysql_real_escape_string($extra_envelop_price);
	if ($extra_envelop_price == '')
		$extra_envelop_price = '0.00';

	$picFileName = '';
	// will be updated after picture upload

	if ($_FILES['picture']["name"]) {
		$fileNameHandler = $_FILES['picture']["name"];
		$file_newName = 'envelop_' . date("mdyHis");
		$picFileName = uploadPhoto('../../uploads/card_envelops/', $_FILES['picture'], $file_newName);
	}

	$sql_1 = sprintf("
		INSERT INTO card_envelops  SET   
		envelop_title = '%s',   
		envelop_price_per_card = '%s',
		extra_envelop_price = '%s',   
		envelop_picture = '%s'", 
		$envelopName, $envelop_price, $extra_envelop_price, $picFileName
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

function updateEnvelop($post) {
	extract($post);
	$envelopName = mysql_real_escape_string($title);

	$envelop_price = mysql_real_escape_string($envelop_price_per_card);
	if ($envelop_price == '')
		$envelop_price = '0.00';

	$extra_envelop_price = mysql_real_escape_string($extra_envelop_price);
	if ($extra_envelop_price == '')
		$extra_envelop_price = '0.00';

	$picFileName = $oldEnvelop_filename;
	// will be updated after picture upload, currently initialized with old value

	if ($_FILES['picture']["name"]) {
		$fileNameHandler = $_FILES['picture']["name"];
		$file_newName = 'envelop_' . date("mdyHis");
		$picFileName = uploadPhoto('../../uploads/card_envelops/', $_FILES['picture'], $file_newName);
		@unlink('../../uploads/card_envelops/' . $oldEnvelop_filename);
	}

	$sql_1 = sprintf("
		UPDATE card_envelops   SET   
		envelop_title = '%s',   
		envelop_price_per_card = '%s',
		extra_envelop_price = '%s',   
		envelop_picture = '%s' 
		WHERE envelop_id='%s'", 
		$envelopName, $envelop_price, $extra_envelop_price, $picFileName, $envelopId
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

function getEnvelops_info($envelop_id = '') {
	if ($envelop_id == '')
		$sql = "SELECT * FROM card_envelops ORDER BY envelop_title ASC";
	else
		$sql = "SELECT * FROM card_envelops WHERE envelop_id = '{$envelop_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function getTplDimensions_optionsHTML() {
	$res = getTplDimensions();
	$output = "";
	while ($rec = mysql_fetch_array($res)) {
		$output .= "<option value='{$rec['tpl_dimension']}'>{$rec['tpl_dimension']}</option>";
	}
	return $output;
}

function deleteEnvelop($envelop_id) {
	$sql = "DELETE FROM card_envelops WHERE envelop_id = '{$envelop_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}