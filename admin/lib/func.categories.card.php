<?php
function getCard_info($card_id = '') {
	if ($card_id == '') {
		$sql = "SELECT * FROM cards ORDER BY cat_id ASC";
	} else {
		$sql = "
			SELECT cards.card_id, cards.*, categories.cat_id, categories.* FROM cards 
			LEFT JOIN categories ON ( cards.cat_id = categories.cat_id ) 
			WHERE cards.card_id = '$card_id'";
	}
	$rSet = mysql_query($sql);
	return $rSet;
}

function getCards_by_cat_id($cat_id = '') {
	if ($cat_id == '')
		$sql = "SELECT * FROM cards LEFT JOIN categories ON(cards.cat_id = categories.cat_id) ORDER BY cards.sort_order ASC";
	else
		$sql = "SELECT * FROM cards LEFT JOIN categories ON(cards.cat_id = categories.cat_id) WHERE cards.cat_id = '{$cat_id}'  ORDER BY cards.sort_order ASC";
	$rSet = mysql_query($sql);
	return $rSet;
}

function getCardPapers($card_id) {
	$sql = "
		SELECT * FROM cards_and_papertype_relation_with_pricing AS cpr 
		LEFT JOIN paper_types AS p ON(cpr.paper_id = p.paper_id) 
		WHERE cpr.card_id='{$card_id}'
		GROUP BY cpr.paper_id";
	$res = mysql_query($sql);
	return $res;
}

function add_price_per_quantity($post) {
	extract($post);
	if ($quantity_txt == "" || $quantity_price == "")
		return false;
	$sql = "
     	INSERT INTO 
     		cards_and_papertype_relation_with_pricing 
     	SET 
     		quantity='" . mysql_real_escape_string($quantity_txt) . "',
     		price='" . mysql_real_escape_string($quantity_price) . "',
     		card_id= '" . mysql_real_escape_string($card_id) . "',
     		paper_id='" . mysql_real_escape_string($paper_type_id) . "'
     	";
	if (mysql_query($sql) or die(mysql_error()))
		return true;
	else
		return false;
}

function saveCard_config($card_id, $card_settings) {
	$sql = "
	UPDATE cards SET 
		card_settings = '".mysql_real_escape_string($card_settings)."', is_active = 1
	WHERE 
		card_id = $card_id
	";
	$returnData = array();
	if (mysql_query($sql) or die(" saveCard_config<br/>$sql<br/>" . mysql_error())) {
		$returnData[0] = '1';
		return $returnData;
	} else {
		$returnData[0] = '0';
		return $returnData;
	}

}

function card_paper_relation_prices_per_quantities($card_id, $paper_id) {
	$sql = "
		SELECT * FROM cards_and_papertype_relation_with_pricing
		WHERE card_id='{$card_id}' AND paper_id='{$paper_id}' AND quantity != '' AND price != ''";
	$res = mysql_query($sql);
	return $res;
}

function del_price_per_quantity($relation_item_id) {
	$sql = "DELETE FROM cards_and_papertype_relation_with_pricing WHERE card_paper_relation_id='{$relation_item_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function addCard($post) {
	extract($post);
	$card_title = mysql_real_escape_string($card_title);
	$card_code = mysql_real_escape_string($card_code);
	$card_size_width = mysql_real_escape_string($card_size_width);
	$card_size_height = mysql_real_escape_string($card_size_height);
	$card_size = $card_size_width . ' inch-' . $card_size_height . ' inch';

	$cardBgFileName = $cardSampleFileName = $cardThumnailPath = "";

	if ($_FILES['card_bg']["name"]) {
		$fileNameHandler = $_FILES['card_bg']["name"];
		$file_newName = $cat_id . '_' . date("mdyHis");
		$cardBgFileName = uploadPhoto('../../uploads/blank_cards/', $_FILES['card_bg'], $file_newName);
	}
	if ($_FILES['card_sample_bg']["name"]) {
		$fileNameHandler = $_FILES['card_sample_bg']["name"];
		$file_newName = $cat_id . '_' . date("mdyHis");
		$cardSampleFileName = uploadPhoto('../../uploads/sample_cards/', $_FILES['card_sample_bg'], $file_newName);
	}
	if (!$_FILES['card_thumbnail_path']["error"]) {// admin select new sample card
		$fileNameHandler = $_FILES['card_thumbnail_path']["name"];
		$file_newName = $cat_id . '_' . date("mdyHis");
		$cardThumnailPath = uploadPhoto('../../uploads/sample_cards/', $_FILES['card_thumbnail_path'], $file_newName);
	}
	$files_sql = "";
	if ($cardBgFileName != "")
		$files_sql = ", card_bg_path ='" . $cardBgFileName . "'";
	if ($cardSampleFileName != "")
		$files_sql .= ", card_sample_path ='" . $cardSampleFileName . "'";
	if ($cardThumnailPath != "")
		$files_sql .= ", card_thumbnail_path = '{$cardThumnailPath}'";

	$have_photo = isset($have_photo) ? 1 : 0;
	$sample_request = isset($sample_request) ? 1 : 0;

	$sql_1 = "
		INSERT INTO cards SET 
		card_title = '{$card_title}',
		cat_id='{$cat_id}',
		card_description = '{$card_description}',
		card_code = '{$card_code}',
		have_photo = {$have_photo},
		content_area_of_card = {$sample_request},
		card_size = '{$card_size}' " . $files_sql;

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
		$card_inserted_id = mysql_insert_id();
		foreach ($paperTypes as $value) {
			$card_paper_relation = "INSERT INTO cards_and_papertype_relation_with_pricing
                                                SET card_id='" . $card_inserted_id . "', paper_id='" . $value . "'";
			mysql_query($card_paper_relation) or die(mysql_error());
		}

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

function updateCard($post) {
	//var_dump($post);
	//die;
	extract($post);
	$card_title = mysql_real_escape_string($card_title);
	$card_code = mysql_real_escape_string($card_code);
	$card_size_width = mysql_real_escape_string($card_size_width);
	$card_size_height = mysql_real_escape_string($card_size_height);
	$card_size = trim($card_size_width) . ' inch-' . trim($card_size_height) . ' inch';

	// remove old uploaded Sample card files if exits
	$card_oldFileSql = "SELECT card_bg_path, card_sample_path FROM cards WHERE card_id = '" . $card_id . "'";
	$res = mysql_query($card_oldFileSql);
	$rec = mysql_fetch_array($res);

	$cardBgFileName = $cardSampleFileName = $cardThumnailPath = "";
	if (!$_FILES['card_bg']["error"]) {// admin selects new blank card
		/* delete old blank card here */
		if ($rec['card_bg_path'] != '') {
			@unlink('../../uploads/blank_cards/' . $rec['card_bg_path']);
		}
		$fileNameHandler = $_FILES['card_bg']["name"];
		$file_newName = $cat_id . '_' . date("mdyHis");
		$cardBgFileName = uploadPhoto('../../uploads/blank_cards/', $_FILES['card_bg'], $file_newName);
	}
	if (!$_FILES['card_sample_bg']["error"]) {// admin select new sample card
		/* delete old sample card here */
		if ($rec['card_sample_path'] != '') {
			@unlink('../../uploads/sample_cards/' . $rec['card_sample_path']);
		}

		$fileNameHandler = $_FILES['card_sample_bg']["name"];
		$file_newName = $cat_id . '_' . date("mdyHis");
		$cardSampleFileName = uploadPhoto('../../uploads/sample_cards/', $_FILES['card_sample_bg'], $file_newName);
	}

	if (!$_FILES['card_thumbnail_path']["error"]) {// admin select new sample card
		/* delete old sample card here */
		if ($rec['card_thumbnail_path'] != '') {
			@unlink('../../uploads/sample_cards/' . $rec['card_thumbnail_path']);
		}

		$fileNameHandler = $_FILES['card_thumbnail_path']["name"];
		$file_newName = $cat_id . '_' . date("mdyHis");
		$cardThumnailPath = uploadPhoto('../../uploads/sample_cards/', $_FILES['card_thumbnail_path'], $file_newName);
	}

	//card_thumbnail_path
	$files_sql = "";
	if ($cardBgFileName != "")
		$files_sql = ", card_bg_path = '{$cardBgFileName}'";
	if ($cardSampleFileName != "")
		$files_sql .= ", card_sample_path = '{$cardSampleFileName}'";
	if ($cardThumnailPath != "")
		$files_sql .= ", card_thumbnail_path = '{$cardThumnailPath}'";

	$have_photo = isset($have_photo) ? 1 : 0;
	$sample_request = isset($sample_request) ? 1 : 0;
	$is_active = isset($is_active) ? 1 : 0;

	$sql_1 = "
	UPDATE cards SET 
	card_title = '{$card_title}', 
	card_code= '{$card_code}',
	card_description = '{$card_description}',
	have_photo = {$have_photo},
	content_area_of_card = {$sample_request},
	is_active = {$is_active},
	card_size = '{$card_size}' " . $files_sql . " 
	WHERE card_id = '{$card_id}'";
	
	/* update paper types */
	foreach($paperTypes as $pt) {
		$sql = "SELECT * FROM cards_and_papertype_relation_with_pricing WHERE paper_id = '{$pt}' AND card_id='{$card_id}'";
		$rSet = mysql_query($sql);
		if ( mysql_num_rows($rSet) < 1 ){
			$sql = "INSERT INTO cards_and_papertype_relation_with_pricing SET paper_id = '{$pt}', card_id='{$card_id}'";
			mysql_unbuffered_query($sql);
		}
	}

	$returnData = array();
	if (mysql_query($sql_1) or die(mysql_error())) {
		$okmsg = base64_encode("Information updated successfully");
		$returnData[0] = "1";
		$returnData[1] = $okmsg;
	} else {
		$errmsg = base64_encode("Unable to update information due to : " . mysql_error());
		$returnData[0] = "0";
		$returnData[1] = $errmsg;
	}
	return $returnData;

}

function deleteCard($card_id) {
	//1). first remove file that exists
	$card_oldFileSql = "SELECT card_bg_path, card_sample_path FROM cards WHERE card_id = '{$card_id}'";
	$res = mysql_query($card_oldFileSql);
	$rec = mysql_fetch_array($res);
	if ($rec['card_bg_path'] != '')
		@unlink('../../uploads/blank_cards/' . $rec['card_bg_path']);
	if ($rec['card_sample_path'] != '')
		@unlink('../../uploads/sample_cards/' . $rec['card_sample_path']);

	// 2). Remvoe card+pricing relations
	$removeSql = "DELETE FROM cards_and_papertype_relation_with_pricing WHERE card_id='{$card_id}'";
	mysql_query($removeSql);

	$sql = "DELETE FROM cards WHERE card_id = '{$card_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}