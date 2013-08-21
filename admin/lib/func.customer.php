<?php
function createCustomer($post) {
	extract($post);
	$firstName = mysql_real_escape_string($firstName);
	$lastName = mysql_real_escape_string($lastName);
	$password = mysql_real_escape_string($pswd1Txt);
	$pin = mysql_real_escape_string($pinTxt);
	$occupation = mysql_real_escape_string($occupationTxt);
	$occupation_info = mysql_real_escape_string($occupationDetailTxt);
	$dob = mysql_real_escape_string($dobTxt);
	$email = mysql_real_escape_string($emailTxt);
	$phone = mysql_real_escape_string($phoneTxt);
	$mobile = mysql_real_escape_string($cellTxt);
	$address = mysql_real_escape_string($adrTxt);
	$city = mysql_real_escape_string($cityTxt);
	$countryId = mysql_real_escape_string($countryTxt);

	$sql = sprintf("
		INSERT INTO customers SET 
		first_name = '%s', 
		last_name = '%s' , 
		user_password = '%s' , 
		user_phone = '%s' , 
		user_email = '%s' , 
		user_country = '%s', 
		user_city = '%s' , 
		user_mobile = '%s' , 
		user_address = '%s'",
		$firstName, 
		$lastName, 
		$password, 
		$phone, 
		$email, 
		$countryId, 
		$city, 
		$mobile, 
		$address
	);
	if (mysql_query($sql)) {
		return true;
	} else
		return false;
}

function getCustomers() {
	$sql = "SELECT * FROM register_users";
	if ($res = mysql_query($sql) or die(mysql_error()))
		return $res;
	else
		return false;
}