<?php
include_once ("../config/config.php");
$task = $_REQUEST['task'];
if ($task == "login") {
	extract($_POST);
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password2);
	$whereClause = "email='{$email}' AND password = MD5('{$password}') AND is_affiliate = 0"; 
	$resLoginQuery = $objDb->SelectTable(USERS, "*", "$whereClause");
	if ( mysql_num_rows($resLoginQuery) > 0 ) {
		$row = mysql_fetch_array($resLoginQuery);
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['userName'] = $row['u_name'];
		$_SESSION['email'] = $row['email'];
		if ($return_url != '') {
			header("location:../" . base64_decode($return_url));
		} else {
			include 'func.cart.php';
			if (get_cart_count() > 0) {
				$url = siteURL . "cart.php";
				echo "<meta http-equiv='Refresh' content='0; URL=$url' />";
			} else {
				header("location:../index.php?p=update_account");
			}
		}
		exit ;
	} else {
		$str = base64_encode('Sorry, Invalid login / password entered.');
		header("location:../index.php?p=login&msg=err&str=" . $str);
	}
} else {
	header("location:../index.php");
}