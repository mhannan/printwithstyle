<?php
function validate_login($user_email, $user_pswd) {
	$user_email = mysql_real_escape_string($user_email);
	$user_pswd = mysql_real_escape_string($user_pswd);
	$query_res = mysql_query("SELECT * FROM admin WHERE user_email = '{$user_email}' AND user_password='{$user_pswd}'");
	$rec_count = mysql_num_rows($query_res);
	if ($rec_count > 0) {
		$rec = mysql_fetch_array($query_res);
		session_start();
		$_SESSION['admin_id'] = $rec['user_id'];
		$_SESSION['admin_name'] = $rec['first_name'] . $rec['last_name'];
		return true;
	} else
		return false;
}

function validusersession() {
	$query_res = mysql_query("SELECT * FROM admin WHERE user_id = '{$_SESSION['admin_id']}'");
	$rec_count = mysql_num_rows($query_res);
	if ($rec_count > 0)
		return true;
	else
		return false;
}

function setAgentPermission($post) {
	$userRs = getUsers();
	while ($user = mysql_fetch_array($userRs)) {
		$user_id = $user['user_id'];
		mysql_query("DELETE FROM permissions WHERE agent_id = '{$user['user_id']}'");

		/* MANAGE CUSTOMERS */
		if (isset($post['view_customer'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['view_customer'][$user_id]} ' , date_created = NOW()");

		if (isset($post['create_customer'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['create_customer'][$user_id]}' , date_created = NOW()");
		if (isset($post['update_customer'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['update_customer'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_customer'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['delete_customer'][$user_id]}' , date_created = NOW()");

		if (isset($post['show_indexMargin'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['show_indexMargin'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_premiumIndex'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['update_premiumIndex'][$user_id]}' , date_created = NOW()");

		if (isset($post['dontShowOverViewCustomerPg_premiumIndex'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['dontShowOverViewCustomerPg_premiumIndex'][$user_id]}' , date_created = NOW()");

		/* MANAGE SUPPLIERS */
		if (isset($post['view_supplier'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['view_supplier'][$user_id]}' , date_created = NOW()");

		if (isset($post['create_supplier'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['create_supplier'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_supplier'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['update_supplier'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_supplier'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['delete_supplier'][$user_id]}' , date_created = NOW()");

		if (isset($post['view_nomination'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['view_nomination'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_nomination'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['update_nomination'][$user_id]}' , date_created = NOW()");

		if (isset($post['view_rate'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['view_rate'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_rate'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['delete_rate'][$user_id]}' , date_created = NOW()");

		if (isset($post['view_location'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['view_location'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_location'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['update_location'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_location'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['delete_location'][$user_id]}' , date_created = NOW()");

		if (isset($post['manage_invoice'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['manage_invoice'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_invoice'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['update_invoice'][$user_id]}' , date_created = NOW()");

		if (isset($post['manage_user'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['manage_user'][$user_id]}' , date_created = NOW()");

		if (isset($post['manage_permission'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['manage_permission'][$user_id]}' , date_created = NOW()");

		if (isset($post['manage_settings'][$user_id]))
			mysql_query("INSERT INTO permissions SET agent_id = '{$user_id}' , allowed_action = '{$post['manage_settings'][$user_id]}' , date_created = NOW()");
	}
	return true;
}

function setAdminPermission($post) {
	$userRs = getAdmin_users();
	while ($user = mysql_fetch_array($userRs)) {
		$user_id = $user['user_id'];
		mysql_query("DELETE FROM permissions WHERE admin_id = '" . $user['user_id'] . "'");

		/* MANAGE ADMIN USERS */
		if (isset($post['view_admins'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['view_admins'][$user_id]}' , date_created = NOW()");

		if (isset($post['create_admins'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['create_admins'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_admins'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['update_admins'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_admins'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['delete_admins'][$user_id]}' , date_created = NOW()");

		/* MANAGE AGENTS */
		if (isset($post['view_agent'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['view_agent'][$user_id]}' , date_created = NOW()");

		if (isset($post['create_agent'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['create_agent'][$user_id]}' , date_created = NOW()");

		if (isset($post['update_agent'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['update_agent'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_agent'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['delete_agent'][$user_id]}' , date_created = NOW()");

		/* MANAGE PERMISSIONS */
		if (isset($post['manage_permission'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['manage_permission'][$user_id]}' , date_created = NOW()");

		/* MANAGE BANK ACCOUNTS */

		if (isset($post['view_bankaccounts'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['view_bankaccounts'][$user_id]}' , date_created = NOW()");

		if (isset($post['add_bankaccounts'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['add_bankaccounts'][$user_id]}' , date_created = NOW()");

		if (isset($post['edit_bankaccounts'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['edit_bankaccounts'][$user_id]}' , date_created = NOW()");

		if (isset($post['delete_bankaccounts'][$user_id]))
			mysql_query("INSERT INTO permissions SET admin_id = '{$user_id}' , allowed_action = '{$post['delete_bankaccounts'][$user_id]}' , date_created = NOW()");

	}
	return true;
}

function checkPermission($user_id, $action, $userType = '') {
	if (isset($userType) && $userType == 'admin')
		$sql = "SELECT *  FROM `permissions` WHERE `admin_id` = {$user_id} AND `allowed_action` LIKE '{$action}'";
	else
		$sql = "SELECT *  FROM `permissions` WHERE `agent_id` = {$user_id} AND `allowed_action` LIKE '{$action}'";

	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if (mysql_num_rows($rs) > 0)
		return true;
	else
		return false;
}

function userInfo_rec($user_id = '') {
	if ($user_id == "")
		$query_res = mysql_query("SELECT * FROM admin WHERE user_id = '{$_SESSION['admin_id']}'");
	else
		$query_res = mysql_query("SELECT * FROM admin WHERE user_id ='{$user_id}'");

	$rec = mysql_fetch_array($query_res);
	return $rec;
}

function getAdmin_users($user_id = '') {
	if ($user_id == '')
		$sql = "SELECT * FROM admin ORDER BY user_id ASC";
	else
		$sql = "SELECT * FROM admin WHERE user_id = '{$user_id}'";
	$rSet = mysql_query($sql);
	return $rSet;
}

function createAdminUser($post) {
	extract($post);
	$firstName = mysql_real_escape_string($firstname);
	$lastName = mysql_real_escape_string($lastname);
	$password = mysql_real_escape_string($password);
	$phone = mysql_real_escape_string($phone_no);
	$email = mysql_real_escape_string($email);
	$countryId = mysql_real_escape_string($countryTxt);
	$city = mysql_real_escape_string($city);
	$mobile = mysql_real_escape_string($mobile);
	$address = mysql_real_escape_string($address);
	$sql = sprintf("
		INSERT INTO admin SET 
		first_name = '%s', 
		last_name = '%s' , 
		user_password = '%s' , 
		user_phone = '%s' , 
		user_email = '%s' ,
		user_country = '%s', 
		user_city = '%s' , 
		user_mobile = '%s' , 
		user_address = '%s'", 
		$firstName, $lastName, $password, $phone, $email, $countryId, $city, $mobile, $address
	);
	if (mysql_query($sql))
		return true;
	else
		return false;

}

function update_admin($post) {
	// print_r($post); exit;
	$fName = mysql_real_escape_string($post['firstname']);
	$lName = mysql_real_escape_string($post['lastname']);
	$Email = mysql_real_escape_string($post['email']);
	$user_id = mysql_real_escape_string($post['admin_id']);
	$Phone = mysql_real_escape_string($post['phone_no']);
	$Address = mysql_real_escape_string($post['address']);
	$Mobile = mysql_real_escape_string($post['mobile']);
	$Country = mysql_real_escape_string(@$post['countryTxt']);
	$State = mysql_real_escape_string(@$post['state']);
	$City = mysql_real_escape_string($post['city']);
	$Password = mysql_real_escape_string($post['admin_password']);

	if (isset($post['change_pw']) && $Password != "") {
		$isChange_psw = mysql_real_escape_string($post['change_pw']);
		$sql_1 = sprintf("
			UPDATE admin SET 
			first_name='%s', 
			last_name='%s', 
			user_email='%s', 
			user_password='%s',
			user_address='%s', 
			user_phone='%s', 
			user_mobile='%s', 
			user_country='%s',
			user_city='%s', 
			state='%s' 
			WHERE user_id='%s'", 
			$fName, $lName, $Email, $Password, $Address, $Phone, $Mobile, $Country, $City, $State, $user_id
		);
	} else {
		$sql_1 = sprintf("
			UPDATE admin SET 
			first_name='%s', 
			last_name='%s', 
			user_email='%s', 
			user_address='%s', 
			user_phone='%s', 
			user_mobile='%s', 
			user_country='%s',
			user_city='%s', 
			state='%s' 
			WHERE user_id='%s'", 
			$fName, $lName, $Email, $Address, $Phone, $Mobile, $Country, $City, $State, $user_id
		);
	}
	$returnData = array();
	if ( mysql_query($sql_1) ) {
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

function deleteAdminUser($user_id) {
	$sql = "DELETE FROM admin WHERE user_id = '{$user_id}'";
	if (mysql_query($sql))
		return true;
	else
		return false;
}