<?php
function getCountryTitle_byId($countryID) {
	$res = mysql_query("SELECT * FROM countries WHERE country_id='" . mysql_real_escape_string($countryID) . "'");
	$rec = mysql_fetch_array($res);
	return $rec['country_name'];
}

function getCountryNameArray_byId($countryID) {
	$res = mysql_query("SELECT * FROM countries WHERE country_id='" . mysql_real_escape_string($countryID) . "'");
	$rec = mysql_fetch_array($res);
	$countryArray = array();
	$countryArray[0] = $rec['country_name'];
	$countryArray[1] = $rec['code'];
	return $countryArray;
}

function getCountries_selectList($nameOfDropDownField = '', $idOfDropDownField = '', $selectedCountry_id = '') {
	$res = mysql_query("SELECT * FROM countries") or die(mysql_error());
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

function getAdminProfile_phone() {
	$sql = "SELECT * FROM admin WHERE user_id='1'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	return $row;
}