<?php
function save_guest($post, $objDb) {
	extract($post);
	
		$columns = 'customer_id, recipient_address';
		//$values = $_SESSION['user_id'] . ',"' . mysql_real_escape_string($guestName) . '","' . mysql_real_escape_string($guestAddr) . '","' . mysql_real_escape_string($phone) . '"';
		
		$contactArr = array();
		$contactArr['_name'] = mysql_real_escape_string($guestName);
		$contactArr['_address'] = mysql_real_escape_string($guestAddr);
		$contactArr['_city'] = mysql_real_escape_string($guestCity);
		$contactArr['_state'] = mysql_real_escape_string($guestState);
		$contactArr['_zip'] = mysql_real_escape_string($guestZip);
		$contactArr['_country'] = mysql_real_escape_string($guestCountry);
		
	if ($guest_id == '0') {
		
		$values = $_SESSION['user_id'] . ',"' . serialize($contactArr) . '"';
		if ($objDb->InsertTable('customer_guests', $columns, $values))
			return true;
		else
			return false;
		
	} elseif ($guest_id > 0) {
		$updateStr = "recipient_address = '" . serialize($contactArr) . "'";
		$where = 'customer_id = "' . $_SESSION['user_id'] . '" AND guest_id="' . $guest_id . '"';
		if ($objDb->UpdateTable('customer_guests', $updateStr, $where))
			return true;
		else
			return false;
	}
}

function getCustomer_guests($customer_id, $objDb) {
	$res = $objDb->SelectTable('customer_guests', '*', 'customer_id="' . $customer_id . '"', 'guest_name');
	return $res;
}

function deleteGuest($gid, $customer_id, $objDb) {
	$res = $objDb->DeleteTable('customer_guests', 'guest_id= "' . $gid . '" AND customer_id="' . $customer_id . '"');
	return $res;
}