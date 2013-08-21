<?php
function getLatestVisits_byAffiliatID($affiliate_user_id, $limit = '', $dateFilterSql = '') {
	$sql_limit = '';
	if ($limit != '')
		$sql_limit = " LIMIT " . $limit;

	$sql = "SELECT * FROM affiliates_activity_log WHERE affiliate_id='" . mysql_real_escape_string($affiliate_user_id) . "' AND activity_type='visitor' " . $sql_limit . ' ' . $dateFilterSql;
	$res = mysql_query($sql);
	return $res;
}

function getLatestRegistered_byAffiliatID($affiliate_user_id, $limit = '', $dateFilterSql = '') {
	$sql_limit = '';
	if ($limit != '')
		$sql_limit = " LIMIT " . $limit;

	$sql = "
		SELECT * FROM affiliates_activity_log AS lg LEFT JOIN register_users AS ru
		ON(lg.registered_user_id = ru.id)
		WHERE lg.affiliate_id='" . $affiliate_user_id . "' AND lg.activity_type='registration' " . $sql_limit . ' ' . $dateFilterSql;
	$res = mysql_query($sql);
	return $res;
}

function getLatestSalesCommission_byAffiliatID($affiliate_user_id, $limit = '', $dateFilterSql = '') {
	$sql_limit = '';
	if ($limit != '')
		$sql_limit = " LIMIT " . $limit;

	$sql = "
		SELECT * FROM affiliates_activity_log AS lg LEFT JOIN register_users AS ru
		ON(lg.registered_user_id = ru.id)
		WHERE lg.affiliate_id='" . $affiliate_user_id . "' AND lg.activity_type='order' " . $sql_limit . ' ' . $dateFilterSql;
	$res = mysql_query($sql);
	return $res;
}

// ########    Affiliate_profile   TABLE not being used any more in system   ######################
function get_current_commission_balance($affiliate_user_id) {
	$sql = "SELECT balance FROM affiliate_account WHERE user_id='" . $affiliate_user_id . "'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	return $row['balance'];
}

function getAffiliate_banner() {
	$sql = "SELECT * FROM affiliate_banners";
	return mysql_query($sql);
}

/****************************************/

// LOG TRACKING

function update_affiliate_state($action_type, $affiliate_id, $registered_customer_id = '') {

	$sql1 = "SELECT * FROM aff_commission_setting LIMIT 1";
	$res1 = mysql_query($sql1);
	$row = mysql_fetch_array($res1);

	if ($action_type == 'visit') {
		$sql_dup = "
			SELECT * FROM affiliates_activity_log WHERE
			affiliate_id = '$affiliate_id' AND
			visitor_ip = '" . $_SERVER['REMOTE_ADDR'] . "'";
		// we are checking globally so if even Registeration activity log exists then we will skip to enter this
		$dup_res = mysql_query($sql_dup);
		if (mysql_num_rows($dup_res) == 0) {
			$sql = "
				INSERT INTO affiliates_activity_log SET
				affiliate_id = '$affiliate_id' ,
				activity_type = 'visitor' ,
				registered_user_id = '$registered_customer_id' ,
				order_id = '' ,
				commission_earned = '" . $row['commission_on_registration'] . "' ,
				activity_time = NOW() ,
				visitor_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ,
				is_commission_paid = '0'
			";
			if (mysql_query($sql)) {
				return mysql_insert_id();
			} else {
				return false;
			}
		}
	} elseif ($action_type == 'registration') {
		$sql_dup = "
			SELECT * FROM affiliates_activity_log WHERE
			affiliate_id = '$affiliate_id' AND
			visitor_ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND
			activity_type = 'registration'
		";
		// we only need to check this 'activity_type' here as we want to avoide visit+sale log
		$dup_res = mysql_query($sql_dup);
		if (mysql_num_rows($dup_res) == 0) {
			$sql = "
				INSERT INTO affiliates_activity_log SET
				affiliate_id = '$affiliate_id' ,
				activity_type = 'registration' ,
				registered_user_id = '' ,
				order_id = '' ,
				commission_earned = '" . $row['commission_on_visit'] . "' ,
				activity_time = NOW() ,
				visitor_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ,
				is_commission_paid = '0'
			";
			if (mysql_query($sql)) {
				// delete the visit log entry as this is now the registration entry
				$delSql = "
					DELETE FROM affiliates_activity_log WHERE
					affiliate_id = '$affiliate_id' AND
					visitor_ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND
					activity_type = 'visitor'
				";
				mysql_query($delSql);
			} else
				return false;
		}
	}
}