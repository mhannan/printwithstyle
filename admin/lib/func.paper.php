<?php
function getPaper_info($paper_id = '') {
	if ($paper_id == '')
		$sql = "SELECT * FROM paper_types ORDER BY paper_id ASC";
	else
		$sql = "SELECT * FROM paper_types WHERE paper_id = '{$paper_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function getPapers_in_HtmlElement($elementName = 'paper_type[]', $elementId = 'paper_type', $class = 'paperTypeClass', $htmlType = 'checkbox') {
	$papers_res = getPaper_info();
	$returnable_html = "";
	if (mysql_num_rows($papers_res) == 0)
		return "<span style='color:red'>Unable to find paper types please define paper types first</span>";

	while ($row = mysql_fetch_array($papers_res)) {
		if ($htmlType == 'checkbox') {
			$returnable_html .= '<div ><input type="checkbox" value="' . $row["paper_id"] . '" name="' . $elementName . '" class="' . $class . '">&nbsp;' . $row['paper_name'] . ' ( ' . $row['paper_color_name'] . ' - ' . $row['paper_weight'] . ')</div>';
		}
	}
	return $returnable_html;
	//."<div style='clear:both'></div>";
}

function getPapers_in_HtmlElement_asSelected($elementName = 'paper_type[]', $elementId = 'paper_type', $class = 'paperTypeClass', $htmlType = 'checkbox', $card_id) {
	$papers_res = getPaper_info();
	$returnable_html = "";
	if (mysql_num_rows($papers_res) == 0)
		return "<span style='color:red'>Unable to find paper types please define paper types first</span>";

	while ($row = mysql_fetch_array($papers_res)) {
		if ($htmlType == 'checkbox') {
			if (paper_card_relation_exist($row['paper_id'], $card_id))
				$returnable_html .= '<div ><input type="checkbox" checked="checked" value="' . $row["paper_id"] . '" name="' . $elementName . '" class="' . $class . '">&nbsp;' . $row['paper_name'] . ' ( ' . $row['paper_color_name'] . ' - ' . $row['paper_weight'] . ')</div>';
			else
				$returnable_html .= '<div ><input type="checkbox" value="' . $row["paper_id"] . '" name="' . $elementName . '" class="' . $class . '">&nbsp;' . $row['paper_name'] . ' ( ' . $row['paper_color_name'] . ' - ' . $row['paper_weight'] . ')</div>';
		}
	}
	return $returnable_html;
	//."<div style='clear:both'></div>";
}

function paper_card_relation_exist($paper_id, $card_id) {
	$sql = "SELECT * FROM cards_and_papertype_relation_with_pricing WHERE paper_id = '{$paper_id}' AND card_id='{$card_id}'";
	$rSet = mysql_query($sql);
	if (mysql_num_rows($rSet) > 0)
		return true;
	else
		return false;
}

function addPaper($post) {
	extract($post);
	$paper_name = mysql_real_escape_string($paper_name);
	$paper_color = mysql_real_escape_string($paper_color);
	$paper_weight = mysql_real_escape_string($paper_weight);

	$sql_1 = sprintf("
		INSERT INTO paper_types 
		(paper_name, paper_color_name, paper_weight )
		VALUES ('%s','%s','%s')", 
		$paper_name, $paper_color, $paper_weight
	);

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

function updatePaper($post) {
	extract($post);
	$paper_name = mysql_real_escape_string($paper_name);
	$paper_color = mysql_real_escape_string($paper_color);
	$paper_weight = mysql_real_escape_string($paper_weight);
	$paper_id = mysql_real_escape_string($paper_id);

	$sql_1 = sprintf("
		UPDATE paper_types SET 
		paper_name = '%s' , paper_color_name='%s', paper_weight='%s'
		WHERE paper_id = '%s' ", 
		$paper_name, $paper_color, $paper_weight, $paper_id
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

function deletePaper($paper_id) {
	$sql = "DELETE FROM paper_types WHERE paper_id = '{$paper_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}