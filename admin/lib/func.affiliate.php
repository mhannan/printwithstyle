<?php
function saveCommissionSetting($post) {
	extract($post);
	$visitor_com = '0.00';
	$registration_com = '0.00';
	$sale_com = '0.00';
	if ($visit_commission != '' && $visit_commission > 0.00)
		$visitor_com = $visit_commission;

	if ($registration_commission != '' && $registration_commission > 0.00)
		$registration_com = $registration_commission;

	if ($sale_commission != '' && $sale_commission > 0.00)
		$sale_com = $sale_commission;

	$sql = "
		UPDATE aff_commission_setting SET
		commission_on_visit = '".mysql_real_escape_string($visitor_com)."' ,
		commission_on_registration = '".mysql_real_escape_string($registration_com)."' ,
		commission_on_sale_in_percent = '".mysql_real_escape_string($sale_com)."'
	";
	if (mysql_query($sql))
		return true;
	else
		return false;

}

function getCommissionSetting() {
	$sql = "SELECT * FROM aff_commission_setting LIMIT 1";
	$res = mysql_query($sql);
	return mysql_fetch_array($res);
}

/************************************************/
function createAffiliate($post) {
	extract($post);
	$firstname = mysql_real_escape_string($firstname);
	$lastname = mysql_real_escape_string($lastname);
	$password = mysql_real_escape_string($password);
	$email = mysql_real_escape_string($email);
	
	$dup_check = "SELECT * FROM register_users WHERE email = '" . $email . "'";
	$res = mysql_query($dup_check);
	if (mysql_num_rows($res) > 0)
		return false;

	$sql = "
		INSERT INTO register_users SET  
		u_name = '{$firstname} {$lastname}',
		email = '{$email}',
		`password`= '{$password}',
		is_affiliate='1'
	";
	mysql_query($sql);
	$user_id = mysql_insert_id();

	$sql_profile = "
		INSERT INTO affiliate_account SET user_id = '{$user_id}', balance = 0.00, last_modified = NOW()";

	if (mysql_query($sql_profile)) {
		return true;
	} else
		return false;

}

function updateAffiliate($post) {
	extract($post);
	$firstname = mysql_real_escape_string($firstname);
	$lastname = mysql_real_escape_string($lastname);
	$password = mysql_real_escape_string($password);
	$email = mysql_real_escape_string($email);
	
	if ( isset($change_pw) ) {
		$sql = sprintf("
			UPDATE customers SET 
				first_name = '%s', 
				last_name = '%s' ,
				password = '%s', 
				email = '%s' 
			WHERE 
				customer_id='%s'",
			$firstname, $lastname, $password, $email, $affiliate_id);
	} else {
		$sql = sprintf("
			UPDATE customers SET 
			first_name = '%s', 
			last_name = '%s' ,
			email = '%s' 
			WHERE customer_id='%s'",
		$firstname, $lastname, $email, $affiliate_id);
	}
	if (mysql_query($sql)) {
		return true;
	} else
		return false;
}

function getAffiliates($affiliate_id = '') {
	if (isset($affiliate_id) && $affiliate_id != "") {
		$sql = "
		SELECT * FROM register_users AS ru 
		LEFT JOIN affiliate_account AS acc ON(ru.id=acc.user_id) 
		WHERE ru.is_affiliate='1' AND ru.id='{$affiliate_id}'";
	} else {
		$sql = "
		SELECT * FROM register_users AS ru 
		LEFT JOIN affiliate_account AS acc ON(ru.id=acc.user_id) 
		WHERE ru.is_affiliate='1'";
	}
	if ($res = mysql_query($sql) or die(mysql_error()))
		return $res;
	else
		return false;
}

function deleteAffiliate($affiliate_id) {
	$sql = "DELETE FROM customers WHERE customer_id = '$affiliate_id'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

/********************************* Affiliate Logs *********************************/
function getAffiliate_visits_count($affiliate_user_id) {
	$sql = "SELECT * FROM affiliates_activity_log WHERE activity_type='visitor' AND affiliate_id='{$affiliate_user_id}'";
	$res = mysql_query($sql);
	return mysql_num_rows($res);
}

function getAffiliate_regs_count($affiliate_user_id) {
	$sql = "SELECT * FROM affiliates_activity_log WHERE activity_type='registration' AND affiliate_id='{$affiliate_user_id}'";
	$res = mysql_query($sql);
	return mysql_num_rows($res);
}

function getAffiliate_orders_count($affiliate_user_id) {
	$sql = "SELECT * FROM affiliates_activity_log WHERE activity_type='order' AND affiliate_id='{$affiliate_user_id}'";
	$res = mysql_query($sql);
	return mysql_num_rows($res);
}

function getVisits_byAffiliatID($affiliate_user_id, $dateFilterSql = '') {
	$sql = "SELECT * FROM affiliates_activity_log WHERE affiliate_id='{$affiliate_user_id}' AND activity_type='visitor' " . $dateFilterSql;
	$res = mysql_query($sql);
	return $res;
}

function getLatestRegistered_byAffiliatID($affiliate_user_id, $dateFilterSql = '') {
	$sql = "
		SELECT * FROM affiliates_activity_log AS lg 
		LEFT JOIN register_users AS ru ON(lg.registered_user_id = ru.id)
		WHERE lg.affiliate_id='{$affiliate_user_id}' AND lg.activity_type='registration' " . $dateFilterSql;
	$res = mysql_query($sql);
	return $res;
}

function getLatestSalesCommission_byAffiliatID($affiliate_user_id, $dateFilterSql = '') {
	$sql = "
		SELECT * FROM affiliates_activity_log AS lg 
		LEFT JOIN register_users AS ru ON(lg.registered_user_id = ru.id)
		WHERE lg.affiliate_id='{$affiliate_user_id}' AND lg.activity_type='order' " . $dateFilterSql;
	$res = mysql_query($sql);
	return $res;
}