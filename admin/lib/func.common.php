<?php
function getCountryTitle_byId($countryID) {
	$res = mysql_query("SELECT * FROM countries WHERE country_id='{$countryID}'");
	$rec = mysql_fetch_array($res);
	return $rec['country_name'];
}

function getCountryNameArray_byId($countryID) {
	$res = mysql_query("SELECT * FROM countries WHERE country_id='{$countryID}'");
	$rec = mysql_fetch_array($res);
	$countryArray = array();
	$countryArray[0] = $rec['country_name'];
	$countryArray[1] = $rec['code'];
	return $countryArray;
}

function getCountries_selectList($nameOfDropDownField = '', $idOfDropDownField = '', $selectedCountry_id = '') {
	$res = mysql_query("SELECT * FROM countries");
	$dropDownSelectList = "<option value='0'>-- Select Country --</option>";
	while ($countryRec = mysql_fetch_array($res)) {
		$selected = "";
		if ($countryRec['country_id'] == $selectedCountry_id)
			$selected = "selected = 'selected'";
		$dropDownSelectList .= "<option value='" . $countryRec['country_id'] . "' $selected >" . $countryRec['country_name'] . "</option>";
	}

	$fieldName = "";
	$fieldID = "";
	if ($nameOfDropDownField != "") {
		$fieldName = $nameOfDropDownField;
		$fieldID = $nameOfDropDownField;
	}
	if ($idOfDropDownField != "")
		$fieldID = $nameOfDropDownField;

	if ($fieldName != "")
		return "<select name='$fieldName' id='$fieldID'>" . $dropDownSelectList . "</select>";
	else
		return $dropDownSelectList;
}

function getFontsList() {
	$res = mysql_query("SELECT * FROM fonts");
	return $res;
}

function generate_fonts_HTML_element($name = '', $id = '', $element = 'dropdown', $selected = NULL)// $element: checkbox/dropdown
{
	$elementName = 'font_items';
	$elementID = 'font_items';
	if ($name != '')
		$elementName = $name;
	if ($id != '')
		$elementID = $id;

	$res = getFontsList();
	$i = 0;

	$html = "";
	while ($row = mysql_fetch_array($res)) {
		if ($element == 'dropdown') {
			$sel = $row['font_id'] == $selected ? 'selected="selected"' : NULL;
			$html .= "<option value='" . $row['font_id'] . "' style='font-family:\'" . $row['font_label'] . "\'' $sel> " . $row['font_label'] . " </option>";
		} else {
			if ( $selected == 'ALL' )  {
				$chk = ' checked="checked" ';
			} else {
				$chk = isset($selected) && is_array($selected) && in_array($row['font_id'], $selected) ? ' checked="checked" ' : NULL;
			}
			$html .= "
			<input type='checkbox' $chk name='$elementName' id='$elementID' value='{$row['font_id']}'>
				<span style='font-family:{$row['font_label']}'>{$row['font_label']}
			</span>
			<br>";
		}
		$i++;
	}

	if ($i == 0)
		return '<span style="color:red">Unable to generate fonts</span>';
	else {
		if ($element == 'dropdown')
			return "<select name='" . $elementName . "' id='" . $elementID . "'>" . $html . "</select>";
		else
			return $html;
	}
}