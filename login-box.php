<?php
include 'config/config.php';
extract($_REQUEST);

if ( isset( $_SESSION['user_id'] ) && ( $_SESSION['user_id'] != 'NULL' ) ) {
    header( "Location: " . siteURL . "address-book.php?item_id={$item_id}&qty={$qty}" );
    exit;
}
$msg = '';
if ( isset( $btn_forgot ) ) {
	if ( !filter_var( $_email, FILTER_VALIDATE_EMAIL ) ) {
		$msg = "Invalid email address";
	} else {
		include_once ('lib/func.user.php');
		if ( recoverPswd($_email) ) {
			$msg = "Recover passwrod instructions are send to : '{$_email}'";
		} else {
			$msg = "Sorry, the email is not found in our record.";
		}
	}
}
else if ( isset( $btn_login ) ) { 
	
	if ( !filter_var( $_email, FILTER_VALIDATE_EMAIL ) ) {
		$msg = "Invalid email address";
	} else { 
		$sql = "email = '{$_email}' AND password = MD5('{$_password}')";
		$return = $objDb->SelectTable( USERS, "*", "$sql" );
		if ( mysql_num_rows( $return ) ) { 
			$row = mysql_fetch_array( $return );
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['userName'] = $row['u_name'];
			$_SESSION['email'] = $row['email'];
			if ( isset( $sample_order ) && $sample_order == 'yes' ) { 
				header( "Location: " . siteURL . "sample-order.php?item_id={$item_id}&qty={$qty}" );
			} else { 
				header( "Location: " . siteURL . "address-book.php?item_id={$item_id}&qty={$qty}" );
			}
			exit;
		} else {
			$msg = "Invalid email / password.";
		}
	}
} else if ( isset( $btnRegister ) )  {
	if ( !filter_var( $_email, FILTER_VALIDATE_EMAIL ) ) {
		$msg = "Invalid email address";
	} else {
		$sql = "email = '{$_email}'";
		$return = $objDb->SelectTable( USERS, "email", "$sql" );
		if ( mysql_num_rows( $return ) ) { // email exists 
			$msg = "Sorry, this email is already registered with us.";
		} else {
			$sql = "
			INSERT INTO " . USERS . " SET
			u_name = '$_name',  
			email = '$_email', 
			password = md5('$_password2')
			";
			mysql_query($sql) or die ( "Unable to register. <br/>$sql<br/>" . mysql_error() );
			$_SESSION['user_id'] = mysql_insert_id();
			$_SESSION['userName'] = $_name;
			$_SESSION['email'] = $_email;
			if ( isset( $sample_order ) && $sample_order == 'yes' ) {
				header( "Location: " . siteURL . "sample-order.php?item_id={$item_id}&qty={$qty}" );
			} else {
				header( "Location: " . siteURL . "address-book.php?item_id={$item_id}&qty={$qty}" );
			}
			exit;
		}
	}
}
?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>
<?php echo isset($msg) && !empty($msg) ? "<p style='font-color:red; text-align: center; border: 1px solid red;'>{$msg}</p>" : NULL; ?>
<div class="login_content_wrapp">
	<div class="news_user_Wrapp">
		<form action="" method="post" autocomplete="off">
			<input type="hidden" name="item_id" value="<?php echo $item_id;?>" />
			<input type="hidden" name="qty" value="<?php echo $qty;?>" />
			<input type="hidden" name="sample_order" value="<?php if(isset($sample_order) && $sample_order !="") echo 'yes'; else echo NULL; ?>" />
			<div class="news_heading">Returning Customer</div>
			<table width="320" border="0" align="center" cellpadding="0" cellspacing="0" class="returning_user_Wrapp_tbl">
				<tr>
					<td>Email Address:</td>
				</tr>
				<tr>
					<td><input type="text" name="_email" id="_email" class="login_input_field" /></td>
				</tr>
				<tr>
					<td>Password:</td>
				</tr>
				<tr>
					<td><input type="password" name="_password" id="_password" class="login_input_field" /></td>
				</tr>
				<tr>
					<td><input type="submit" value="Login" name="btn_login" id="btn_login" class="btn_normal" /></td>
				</tr>
			</table>
			
		</form>
		<a style="cursor: pointer; margin-left: 20px;" id="a_forgot">Forgot Password?</a>
		<div class="news_user_Wrapp" id='dv_forgot' style='display:none;'>
			<form action="" method="post" autocomplete="off">
			<input type="hidden" name="item_id" value="<?php echo $item_id;?>" />
			<input type="hidden" name="qty" value="<?php echo $qty;?>" />
			<input type="hidden" name="sample_order" value="<?php if(isset($sample_order) && $sample_order !="") echo 'yes'; else echo NULL; ?>" />
			<table border="0" align="center" cellpadding="0" cellspacing="0" class="returning_user_Wrapp_tbl">
				<tr>
					<td>Email Address:</td>
				</tr>
				<tr>
					<td><input type="text" name="_email" id="_email" class="login_input_field" /></td>
				</tr>
				<tr>
					<td><input type="submit" value="Send" name="btn_forgot" id="btn_forgot" class="btn_normal" /></td>
				</tr>
			</table>
			
			</form>
		</div>
	</div> <!-- returning_user_Wrapp -->
	

<script type="text/javascript">
	jQuery(document).ready(function($){
		
		$("a#a_forgot").live ('click', function() {
			$("div#dv_forgot").toggle();
		});
		
		$("#btn_add_recipient").live ('click', function() {
			if ( $("#_name").val() == '' ) {
				alert("provide name please.")
				$("#_name").focus();
				return;
			} else if ( $("#_address").val() == '' ) {
				alert("provide address please.")
				$("#_address").focus();
				return;
			} else if ( $("#_city").val() == '' ) {
				alert("provide city please.")
				$("#_city").focus();
				return;
			} else if ( $("#_state").val() == '' ) {
				alert("provide state please.")
				$("#_state").focus();
				return;
			} else if ( $("#_zip").val() == '' ) {
				alert("provide zip please.")
				$("#_zip").focus();
				return;
			} else if ( $("#_country").val() == '' ) {
				alert("provide country please.")
				$("#_country").focus();
				return;
			}
			
			dataString = $("form#frm_new").serializeArray();
			$.ajax({
			  type: "POST",
			  url: "<?php echo siteURL;?>process-ajax.php",
			  data: dataString,
			  success: function(ret) {
			  	alert(ret);
			  }
			});
		});
	
		$("#btn_login").live ('click', function() {
			if ( $("#_email").val() == '' ) {
				alert("provide email please.")
				$("#_email").focus();
				return false;
			} else if ( $("#_password").val() == '' ) {
				alert("provide password please.")
				$("#_password").focus();
				return false;
			}
			return true;
		});
	});
</script>


<div class="returning_user_Wrapp">
	<form action="" method="post" autocomplete="off">
		<input type="hidden" name="item_id" value="<?php echo $item_id;?>" />
		<input type="hidden" name="qty" value="<?php echo $qty;?>" />
		<input type="hidden" name="sample_order" value="<?php if(isset($sample_order) && $sample_order !="") echo 'yes'; else echo NULL; ?>" />
		<div class="news_heading">New Customer</div>
		<div class="login_desc">Creating your own account is free of charge, no monthly fees.</div>
		<table width="320" border="0" align="center" cellpadding="0" cellspacing="0" class="returning_user_Wrapp_tbl">
			<tr>
				<td>Name:</td>
			</tr>
			<tr>
				<td><input type="text" id="_reg_name" name="_name" class="login_input_field" /></td>
			</tr>
			<tr>
				<td>Email Address:</td>
			</tr>
			<tr>
				<td><input type="text" id="_reg_email" name="_email" class="login_input_field" /></td>
			</tr>
			<tr>
				<td>Password:</td>
			</tr>
			<tr>
				<td><input type="password" id="_reg_password" name="_password" class="login_input_field" /></td>
			</tr>
			<tr>
				<td>Confirm Password:</td>
			</tr>
			<tr>
				<td><input type="password" id="_reg_password2" name="_password2" class="login_input_field" /></td>
			</tr>
			<tr>
				<td><input type="submit" value="Register" id="btnRegister" name="btnRegister"  class="btn_normal"/></td>
			</tr>
		</table>
		
	</form>
</div><!--news_user_Wrapp-->

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#btnRegister").click (function() {
			if ( $("#_reg_name").val() == '' ) {
				alert("Provide name please.");
				$("#_reg_name").focus();
				return false;
			} else if ( $("#_reg_email").val() == '' ) {
				alert("Provide email please.");
				$("#_reg_email").focus();
				return false;
			} else if ( $("#_reg_password").val() == '' ) {
				alert("Provide password please.");
				$("#_reg_password").focus();
				return false;
			} else if ( $("#_reg_password2").val() == '' ) {
				alert("Provide confirm password please.");
				$("#_reg_password2").focus();
				return false;
			} else if ( $("#_reg_password").val() != $("#_reg_password2").val() ) {
				alert("Provided passwords mismatch.");
				$("#_reg_password").focus();
				return false;
			} else {
				return true;
			}
		});
	});
</script>
</div> <!-- login_content_wrapp -->