<?php
include_once ("../config/config.php");
include ("../admin/classes/upload_class.php");
include ("../admin/lib/photo.upload.php");
$profile_pic_sql = "";
if ($_FILES['profile_pic']["name"]) {
	$fileNameHandler = $_FILES['profile_pic']["name"];
	$file_newName = date("mdyHis");
	$profile_pic_file_name = uploadPhoto('../uploads/customer_profile_pics/', $_FILES['profile_pic'], $file_newName);
	$profile_pic_sql = ", profile_pic_path = '" . $profile_pic_file_name . "'";
}
$task = $_REQUEST['task'];
if ($task == "updateaccount") {
	extract($_POST);
	$user_id = $_SESSION['user_id'];
	$fname = mysql_real_escape_string($fname);
	$user_email = mysql_real_escape_string($user_email); 
	$password = mysql_real_escape_string($password); 
	$contact_phone = mysql_real_escape_string($contact_phone); 
	$contact_address = mysql_real_escape_string($contact_address);  
	$city = mysql_real_escape_string($city); 
	$country = mysql_real_escape_string($country);
	
	if ( empty($password) === FALSE ) {
		$objDb->UpdateTable(USERS, "u_name='$fname',email='$user_email',password=MD5('$password'),contact_phone='$contact_phone',contact_address='$address',city='$city',country='$country' " . $profile_pic_sql, "id='$user_id'");
	} else {
		$objDb->UpdateTable(USERS, "u_name='$fname',email='$user_email',contact_phone='$contact_phone',contact_address='$address',city='$city',country='$country' " . $profile_pic_sql, "id='$user_id'");	
	}
	header("location:../index.php?p=update_account&msg=succ");
	exit ;
}

header("location:index.php");
