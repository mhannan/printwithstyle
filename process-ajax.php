<?php
include 'config/config.php';
extract($_REQUEST);
if ( !isset( $call ) || empty( $call ) ) {
	die('ALLAH-O-AKBAR');
}

switch( $call ) {
	case "save_new_recipient": {
		$data['_name'] = $_name;
		$data['_address'] = $_address;
		$data['_city'] = $_city;
		$data['_state'] = $_state;
		$data['_zip'] = $_zip;
		$data['_country'] = $_country;
		$return_address_col = mysql_escape_string( serialize($data) );
		$sql = "
		INSERT INTO " . TBL_GUESTS . " SET 
			guest_name = '$_name',
			recipient_address = '$return_address_col', 
			customer_id = {$_SESSION['user_id']}
		";
		$objDb->select_table_join($sql);
		$guest_id = mysql_insert_id();
		echo "
		<div class='recipient_row_new'>
			<span>
				<input type='checkbox' value='{$guest_id}' name='guests[]' class='chk_guests' />
			</span>
			<label>$_name&nbsp;&nbsp;:&nbsp;&nbsp;
			{$data['_address']}, {$data['_city']} {$data['_state']} {$data['_zip']} {$data['_country']}</label>
		</div>
		";
		break;
	}
	case 'save_return_address' : {
		$data['return_name'] = $return_name;
		$data['return_address'] = $return_address;
		$data['return_city'] = $return_city;
		$data['return_state'] = $return_state;
		$data['return_zip'] = $return_zip;
		$data['return_country'] = $return_country;
		$return_address_col = mysql_escape_string( serialize($data) );
		$sql = " UPDATE " . USERS . " SET return_address = '$return_address_col' WHERE id = {$_SESSION['user_id']}";
		$objDb->select_table_join($sql);
		break;
	}
	
	case 'display_uploaded_photos' : {
		$html = "";
		$counter = 0;
		foreach( $_SESSION['photos'] as $p ) {
			$p = get_thumbnail_name($p, 200);
			$path = UPLOAD_PATH . $p;
			if ( file_exists( $path ) ) {
				$src = PHOTOS_PATH . $p . "?" . time();
				$html .= "
					<img src='{$src}' alt='{$p}' style='width: 50px; float: left; margin-right: 10px;' class='my_photos' />
				";
			} else {
				unset( $_SESSION['photos'][$counter] );
			}
			$counter++;
		}
		echo $html;
		break;
	}
	case 'delete_uploaded_photos': {
		$filename = UPLOAD_PATH . $_SESSION['photos'][$photo];
		if ( file_exists( $filename ) ) {
			unlink( $filename );
			$large = get_thumbnail_name($filename);
			@unlink( $large );
			$thumb = get_thumbnail_name($filename, 1);
			@unlink( $thumb );
			
			unset($_SESSION['photos'][$photo]);
		}
		break;
	}
	
	case 'save_item_guests': {
		$data['guest_ids'] = $guests_id;
		$data['id_customer'] = $_SESSION['user_id'];
		$data['id_card'] = $item_id;
		save_guest_ids($data);
		break;
	}
	
	case 'validate_coupon_code' : {
		$coupon_code = trim( $coupon_code ) ;
		if ( !empty( $coupon_code ) && $coupon_code != 'Apply Coupon Code' )
			include 'admin/lib/func.coupon.php';
			$objCoupon->code = $coupon_code;
			if ( $objCoupon->set_code() ) {
				if ( !$objCoupon->is_active ) {
					echo 'The provided coupon code expired.';
				} else {
					$discountValue_per_percentage = (float)$grand_total * (  (int)$objCoupon->price / 100 );					// coupon_price has %age of discount allowed
					echo number_format( (float)$grand_total - (float)$discountValue_per_percentage , 2 ); 
				}
				
			} else {
				echo'The coupon code you provide is invalid.';
			}
			
			//print_r($_REQUEST);
		break;
	}
	
	case 'delete_cart_item' : {
		include 'lib/func.cart.php';
		error_reporting(1);
		extract($_REQUEST);
		delete_cart_item($id);
		$image = CUSTOMER_CARDS . $card_image;
		if ( file_exists( $image ) ){
			
			/* send an email alert to admin on deletion of the cart item */
			$from_name = ADMIN_FROM;
			$from_email = ORDER_EMAIL;
			$admin_email = ADMIN_EMAIL;
			
			$subject = "Send With Style: Abandoned Cart Item";
			$boundary1 = md5("designsoftstudios");
			$boundary2 = md5("dsswebdesign");
			
			$attachments = "";//add_mail_attachment( $image, $boundary1);
			$msg = '';
$headers = <<<HEADERS
From: $from_name <$from_email>
Bcc: sobish@designsoftstudios.com
MIME-Version: 1.0
Content-Type: multipart/mixed;
    boundary="$boundary1"
HEADERS;
$message = <<<MESSAGE
This is a multi-part message in MIME format.

--$boundary1
Content-Type: multipart/alternative;
    boundary="$boundary2"

--$boundary2
Content-Type: text/plain;
    charset="windows-1256"
Content-Transfer-Encoding: quoted-printable

$msg
--$boundary2
Content-Type: text/html;
    charset="windows-1256"
Content-Transfer-Encoding: 7bit

$msg

--$boundary2--

$attachments
--$boundary1--
MESSAGE;

			//mail($admin_email, $subject, $message, $headers );

			/* delete file */
			unlink($image);
			 
		}
		break;
	}

	case 'sample_request': {
		$obj_sample = new table_class('sample_requests');
		$obj_sample->id_card = $id_card;
		$obj_sample->id_customer = $id_customer;
		$obj_sample->sent = '0';
		if ( $obj_sample->populate('AND') ) { // if id_card and id_customer already exists  
			echo 'already requested';
		} else {
			if ( $obj_sample->insert() ) { // true on insert 
				echo 'saved';
			} else {
				echo 'error';
			}
		}
		unset($obj_sample);
		break;
	}
	
	case 'sample_card_sent': {
		$obj_sample = new table_class('sample_requests');
		$obj_sample->id = $id;
		$obj_sample->sent = '1';
		if ( $obj_sample->populate('AND') ) { // if id_card and id_customer already exists  
			echo 'already sent';
		} else {
			if ( $obj_sample->update() ) { // true on insert 
				echo 'sent';
			} else {
				echo 'error';
			}
		}
		unset($obj_sample);
		break;
	}
	
	case 'add_to_favorite': {
		/* check whether user have it as favorites */
		$obj_sample = new table_class('customer_favorites');
		$obj_sample->favorite_item_url = $item_id;
		$obj_sample->customer_id = $id_customer;
		if ( $obj_sample->populate('AND') ) { // if id_card and id_customer already exists  
			echo 'already added';
		} else {
			if ( $obj_sample->insert() ) { // true on insert 
				echo 'added';
			} else {
				echo 'error';
			}
		}
		unset($obj_sample);
		break;
	}
	case 'delete_from_favorite': {
		/* check whether user have it as favorites */
		$obj_sample = new table_class('customer_favorites');
		$obj_sample->favorit_id = $item_id;
		$obj_sample->customer_id = $id_customer;
		$obj_sample->delete();
		unset($obj_sample);
		break;
	}
	
	case 'save_review' : {
		$obj_sample = new table_class('reviews');
		$obj_sample->id_card = $id_card;
		$obj_sample->rating = $rating;
		$obj_sample->id_customer = $id_customer;
		$obj_sample->review = $review;
		if ( $obj_sample->insert() ) { // true on insert 
			echo 'added';
		} else {
			echo 'error';
		}
		break;
	}
}
