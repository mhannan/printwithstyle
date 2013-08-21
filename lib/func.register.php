<?php
include_once ("../config/config.php");
include_once ('lib/func.user.affiliate.php');

$task = $_REQUEST['task'];
if ($task == "customer_register") {
	extract($_POST);
	if ($password != $c_password) {
		header("location:../index.php?p=register&msg=errr");
		exit ;
	}
	if ( !filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {
		return FALSE;
	}
	$user_email = mysql_real_escape_string($user_email);
	if (mysql_num_rows($objDb->SelectTable(USERS, "*", "email='{$user_email}' AND is_affiliate = 0") ) > 0) {
		header("location:../index.php?p=register&msg=alr1");
		exit ;
	} else {
		
		$fname = mysql_real_escape_string($fname);
		$password = mysql_real_escape_string($password);
		$contact_name = mysql_real_escape_string($contact_name);
		$contact_phone = mysql_real_escape_string($contact_phone);
		$address = mysql_real_escape_string($address);
		$role = mysql_real_escape_string($role);
		$city = mysql_real_escape_string($city);
		$country = mysql_real_escape_string($country);
		$region = mysql_real_escape_string($region);
		$user_status = mysql_real_escape_string($user_status);
		
		$cols = "u_name,email,password,contact_name,contact_phone,	contact_address ,designation,city,country,region,user_status";
		$values = "'$fname','$user_email',md5('$password'),'$contact_name','$contact_phone','$address','$role','$city','$country','$region','$user_status'";
		$id_user = $objDb->insert_record(USERS, $cols, $values);

		/*************** For affiliate visitor converting to registration ***********/
		if (isset($_SESSION['customer_affiliate_visit_log_id']) && $_SESSION['customer_affiliate_visit_log_id'] != '') {
			//1). log entry as registration
			//2). remove this entry from visitor log (as this is now registered entry), so double commission on two seprate activities shoudl not go to Affiliate
			update_affiliate_state('registration', $_SESSION['customer_affiliate_id'], $id_user);
			// we arleady ahve this session variable set in HEADER.PHP
		}
		/****************************************************************************/

		/* set session variables on successfully registration */
		include 'func.cart.php';
		if ( get_cart_count() ) {
			$_SESSION['user_id'] = $id_user;
			$_SESSION['userName'] = $fname;
			$_SESSION['email'] = $user_email;
			$url = siteURL . "cart.php";
			echo "<meta http-equiv='Refresh' content='0; URL=$url' />";
		} else {
			header("location:../index.php?p=thankyou_register&msg=succ");
		}
		exit ;
	}
} else {
	header("location:index.php");
}