<?php
function validate_user($objDb) {
	if ( isset($_SESSION['email'] ) ) {
		$whereClause = "email='" . mysql_real_escape_string($_SESSION['email']) . "' AND id = '" . $_SESSION['user_id'] . "'";
		$resLoginQuery = $objDb->SelectTable(USERS, "*", "$whereClause");
		if (mysql_num_rows($resLoginQuery) > 0)
			return true;
		else
			return false;
	} else
		return false;
}

function recoverPswd($userEmail) 
{
	 if ( filter_var( $userEmail, FILTER_VALIDATE_EMAIL ) ) 
	  {
		$newPswd = time();
		$sql = "UPDATE register_users SET password = MD5('".$newPswd."') WHERE email='" . mysql_real_escape_string($userEmail) . "'";
		/*$sql = "SELECT * FROM register_users WHERE email='" . mysql_real_escape_string($userEmail) . "'";
		  $res = mysql_query($sql);
		  if (mysql_num_rows($res) > 0) */
		if (mysql_query($sql)) 
		{
		  $sql2 = "SELECT * FROM register_users WHERE email='" . mysql_real_escape_string($userEmail) . "'";
		  $res = mysql_query($sql2);
		  $row = mysql_fetch_array($res);
												
		  $message = " Dear <b>{$row['u_name']},</b><br/>
			      A request to recover your SendWithStyle account password has been placed.<br/>
				Your account password has been changed.<br/>
				Please find below your account information:<br/>
				<div style='border:1px solid #888; background-color:#ddd; margin:10px; padding:5px;'>
				   <b>Login: </b>{$userEmail}<br/>
				   <b>Password: </b>{$newPswd}
				</div>
				<span style='font-size:11px'>**Note: If you have not request for password recovery then ignore this email.</span>";
		  if (sendEmail($userEmail, 'Account Password Recovery - Send With Style', $message)) 
			{
				return true;
			}
		  return true;
		} 
		else 
		   return false;
				
	  } 
	 else 
	   return false;
	
}

// Send Email
function sendEmail($to, $subject, $message) {
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: ' . ADMIN_FROM . ' < ' . ADMIN_EMAIL . ' >' . "\r\n";
	if (mail($to, $subject, $message, $headers))
		return true;
	else
		return false;
}

/************************************************************************/
//          Affiliate User Login            //

function register_affiliate($post) {
	extract($post);
	if ( filter_var( $userEmailTxt, FILTER_VALIDATE_EMAIL ) ) {
		$dup_check = "SELECT * FROM register_users WHERE email = '" . mysql_real_escape_string($userEmailTxt) . "' AND is_affiliate = 1";
		$res = mysql_query($dup_check);
		if (mysql_num_rows($res) > 0)
			return false;
	
		$sql = "
			INSERT INTO register_users SET  
			u_name = '" . mysql_real_escape_string($fName_txt) . ' ' . mysql_real_escape_string($lName_txt) . "' , 
			email = '" . mysql_real_escape_string($userEmailTxt) . "' , 
			`password`= MD5('" . mysql_real_escape_string($password) . "'), 
			is_affiliate='1'
		";
		if (mysql_query($sql)) {
			$user_id = mysql_insert_id();
			$sql_profile = "INSERT INTO affiliate_account SET user_id = '" . $user_id . "', balance = 0.00, last_modified = NOW()";
			mysql_query($sql_profile);
			sendEmail($userEmailTxt, 'Send With Style - Affiliate Program Joining', "<b>Dear " . $fName_txt . ' ' . $lName_txt . ",</b><br><br>We welcome you to Send With Style Affiliate program. This will allow you to market your own affiliate link to our website on different portals or email campaigns. This will let you make more and more money on each registration , impressions, sale. Further you could visit details on <a href='http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?p=affiliate'>our affiliate page</a>.<br><br>Your account is ready to use please login here to access your affiliate account:<a href='http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?p=affiliate&action=login'>http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?p=affiliate&action=login</a><br><br>For any further queries please feel free to contact Send With Style support team.<br><br>Thanks!<br>Send With Style Team");
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function login_affiliate($post) {
	extract($post);
	if ( filter_var( $userEmailTxt, FILTER_VALIDATE_EMAIL ) ) {
		$sql = "
			SELECT * FROM register_users WHERE 
			email = '" . mysql_real_escape_string($userEmailTxt) . "' AND 
			`password`= MD5('" . mysql_real_escape_string($userPswdTxt) . "') AND 
			is_affiliate='1'
		";
		$res = mysql_query($sql);
		if (mysql_num_rows($res) > 0) {
			session_destroy();
	
			session_start();
			$row = mysql_fetch_array($res);
			$_SESSION['aff_user_id'] = $row['id'];
			$_SESSION['aff_email'] = $row['email'];
			$_SESSION['aff_name'] = $row['u_name'];
	
			return true;
		} else
			return false;
	} else {
		return false;
	}
}

function update_affiliate_account($post) {
	extract($post);
	
	if ( empty($password) === FALSE ) {
		$sql = "
			UPDATE register_users SET 
			u_name = '" . mysql_real_escape_string($fname) . "', 
			`password` = md5('" . mysql_real_escape_string($password) . "'),
			contact_phone = '" . mysql_real_escape_string($contact_phone) . "', 
			contact_address = '" . mysql_real_escape_string($address) . "',  
			city= '" . mysql_real_escape_string($city) . "', 
			country = '" . mysql_real_escape_string($country) . "'
			WHERE email = '{$user_email}'
			";
	} else {
		$sql = "
			UPDATE register_users SET 
			u_name = '" . mysql_real_escape_string($fname) . "', 
			contact_phone = '" . mysql_real_escape_string($contact_phone) . "', 
			contact_address = '" . mysql_real_escape_string($address) . "',  
			city= '" . mysql_real_escape_string($city) . "', 
			country = '" . mysql_real_escape_string($country) . "'
			WHERE email = '{$user_email}'
			";
	}
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function validate_affiliate_login() {

}


function add_favorite($encoded_local_relative_url) {
	$sql = "
		INSERT INTO customer_favorites SET 
		customer_id='" . $_SESSION['user_id'] . "', 
		favorite_item_url='" . $encoded_local_relative_url . "', 
		date_added = NOW()";
	if (mysql_query($sql))
		return true;
	else
		return false;
}

function get_favorites() {
	$cards = TBL_CARDS;
	$fav = "customer_favorites";
	$sql = "
		SELECT $fav.*, $cards.card_title, $cards.card_id, $cards.cat_id  
		FROM $fav
		INNER JOIN $cards ON $fav.favorite_item_url = $cards.card_id 
		WHERE customer_id = '{$_SESSION['user_id']}'
	";
	$favorites = mysql_query($sql) or die("get_favorites<br/>$sql</br>" . mysql_error());
	if (is_resource($favorites) && mysql_num_rows($favorites)) {
		return $favorites;
	} else {
		return FALSE;
	}
}