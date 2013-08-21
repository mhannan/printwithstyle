<?php

class table_class {
	private $table = "";
	private $data = array();
	
	public function __construct($table_name) {
		$this->table = $table_name;
	}
	
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function __get($name) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		} else {
			return NULL;
		}
	}
	
	public function get_all() {
		$sql = "SELECT {$this->table}.* FROM {$this->table}";
		
		$table = mysql_query( $sql ) or die ( "get all </br>$sql" . mysql_error() );
		if ( mysql_num_rows( $table ) ) {
			return $table;
		} else {
			return FALSE;
		}
	}
	
	public function insert() {
		$sql = "INSERT INTO {$this->table} SET " . $this->column_values();
		if ( mysql_unbuffered_query($sql) or die (__METHOD__ . "<br/>$sql</br>" . mysql_error() ) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function update() {
		$sql = "UPDATE {$this->table} SET " . $this->column_values() . " WHERE id = {$this->id}";
		if ( mysql_unbuffered_query($sql) or die (__METHOD__ . "<br/>$sql</br>" . mysql_error() ) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function delete() {
		$sql = "DELETE FROM {$this->table} WHERE " . $this->where_column();
		echo $sql;
		if ( mysql_unbuffered_query($sql) or die (__METHOD__ . "<br/>$sql</br>" . mysql_error() ) ) {
			return TRUE;
		} else {
			return FALSE;
		} 
	}
	
	private function column_values() {
		$col_val = array();
		foreach( $this->data as $column => $value ) {
			if ( is_numeric($column) === FALSE && is_integer($column) === FALSE ) {
				if ( $value == 'NOW()' || is_numeric( $value ) || is_integer( $value ) || $value == 'NULL' ) {
					$col_val[] = "{$column} = {$value}";
				} else if( empty( $value ) ) { // TODO: Check whether column allow NULL or not
					$col_val[] = "{$column} = NULL";
				} else {
					$col_val[] = "{$column} = '{$value}'";
				}
			}
		}
		return (string)implode( ', ', $col_val );
	}
	
	private function where_column($operator = 'AND') {
		$col_val = array();
		foreach( $this->data as $column => $value ) {
			
			if ( is_numeric($column) === FALSE && is_integer($column) === FALSE ) {
				if ( $value == 'NOW()' || is_numeric( $value ) || is_integer( $value )) {
					$col_val[] = "{$column} = {$value}";
				} else if(  $value == 'NULL'  ) {
					$col_val[] = "{$column} is {$value}";
				}
				 else {
					$col_val[] = "{$column} = '{$value}'";
				}
			}
		}
		return (string)implode( " {$operator} ", $col_val );
	}
	
	public function populate($operator = 'AND', $all = FALSE) {
		$sql = "SELECT * FROM {$this->table} WHERE " . $this->where_column($operator);
		$table = mysql_query($sql) or die (__METHOD__ . "<br/>$sql</br>" . mysql_error() );
		if ( mysql_num_rows($table) ) {
			if ( $all ) {
				$this->data = mysql_fetch_array($table);
			} else {
				$populated = mysql_fetch_array($table);
				$temp = array();
				foreach($this->data as $k => $v ) {
					$temp->$k = $populated[$k];
				}
				$this->data = array_merge($this->data, $temp);
				unset($populated);
				unset($temp);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

function add_mail_attachment($filename, $boundary1) {
	$file = $filename;
	$file_size = filesize($file);
	$handle = fopen($file, "r");
	$content = fread($handle, $file_size);
	fclose($handle);
	$content = chunk_split(base64_encode($content));
	
	$name = basename( $filename );
	/*
	$header = "\r\n"."--{$uid}"."\r\n";
	$header .= "Content-Type: application/octet-stream; name=\"{$name}\""."\r\n";
	$header .= "Content-Transfer-Encoding: base64"."\r\n";
	$header .= "Content-Disposition: attachment; filename=\"{$name}\""."\r\n";
	$header .= $content."\r\n";
	*/
	return <<<ATTACHMENT
--$boundary1
Content-Type: application/octet-stream;
    name="$name"
Content-Transfer-Encoding: base64
Content-Disposition: attachment;
    filename="$name"

$content

ATTACHMENT;
	return $header;
}

function send_order_email( $objOrder, $id_order ) {
	
	$boundary1 = md5("designsoftstudios");
	$boundary2 = md5("dsswebdesign");
	$subject = "Send With Style: New Order";
	
	$main_order = $objOrder->get_all($id_order);
	$order_details = $objOrder->get_single($id_order);
	
	/* main order details */
	$to = "";
	$customer_name = "";
	$attachments = "";

			$row = mysql_fetch_object( $main_order ); 
			$shipping_method = explode( "|", $row->billing_phone );
			$to = $row->customer_email;
			$customer_name = $row->customer_name;
			$order_date = $row->order_date;
			$order_status = $row->status;
			
	$order_total = $salesTax = $ship_price = $actual_total = 0;
	/* order details */
	$order_details_message = "<b>ORDER DETAILS</b>";
	
	while ($row = mysql_fetch_object( $order_details ) ) {
		$quantity_price = explode( '||', $row->quantity_price);
		if ( $row->is_sample == '1' ) {
			$card_img = SAMPLE_CARDS . $row->card_sample_path;
		} else {
			$card_img = CUSTOMER_CARDS_VIEW . $row->card;
		}
		
		
		$item = (object)unserialize($row->data);
		if ( $row->is_sample == '1' ) {
			$guests_ids = FALSE;
		} else {
			$guests_ids = $item->guest_ids;
		}
		
		if ( $guests_ids ) {
			$guest_count = explode( "," , $guests_ids);
			$guest_count = count( $guest_count );
		
			$guests = $objOrder->get_guests_ids( $guests_ids, NULL, FALSE );
			if ( $guests ) {
				$guest_names = '<br/>Address to Print<br/>';
				while ( $guest = mysql_fetch_object( $guests ) ) {
					$guest_names .= $objOrder->generate_guest_address($guest, $guest_names);
				}
			}
		} else {
			$guest_names = '';
		}
		/* mailing option */
		$mail_option = $objOrder->get_mailing_option($row->mail_option, $item->mail_option_addresses, $guest_count, $row->shipping, $quantity_price[1] );
		$handling_or_postage_charges = $_SESSION['handling_or_postage_charges'];				// this session varialbe is created & assigned value inside above function. as above function used in multiple places so to avoide any big changes we did shortcut
		
		
			// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Gross/sub total calculation & tax etc^^^^^^^^^^^^^^^^
		$salesTax = $row->tax_applied;
		$ship_price = $shipping_method[1];
		$actual_total = $row->total_price;
		
			if ( isset($item->total_x_envelope)) 
									$x_envelope_price = $item->total_x_envelope;
								
			if ( isset($item->x_envelop)) 
									$x_envelop_count = $item->x_envelop;
								
								
			$envelop = explode( "|", $item->envelop );
			$envelop_price = $envelop[1];
								
		$total_envelopes = (float)$envelop_price * (float)$quantity_price[1];
										
		$subtotal = (float)$quantity_price[2] + (float)$total_envelopes + $x_envelope_price;
		$order_total += (float)$subtotal;
		// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
		
		
		/* envelope options */
		$envelope_option = $objOrder->get_envelope_data( $item, $quantity_price[1] );
		$order_details_message .= "
		<table border='0' cellpadding='4' cellspacing='1' style='background-color:#ddd'>
		<tr>
			<td style='vertical-align: top;background-color:#fff'>
				<strong style='color:#29748C'>(".(substr($row->cat_title, -1) == 's'?substr($row->cat_title, 0, -1):$row->cat_title).")</strong><br/>		
				<b>Card Title:</b> ({$row->card_title})<br/>
				<b>Paper Type:</b> ({$row->paper_name})<br/>
				<b>Quantity:</b> ({$quantity_price[1]} cards)<br/>
				<b>Cards Price:</b> (&#36; {$quantity_price[2]})
			</td>
			<td style='vertical-align: top;background-color:#fff'>
				{$mail_option}
				<br><i>".$guest_names."</i>
			</td>
			<td style='vertical-align: top;background-color:#fff'>
				{$envelope_option}
			</td>
			<td style='vertical-align: top;background-color:#fff'>
				<a href='{$card_img}' target='_blank'>
				<img src='{$card_img}' style='width: 150px' />
				</a>
			</td>
			<td style='vertical-align: top;background-color:#fff'>
			&nbsp;</td>
		</tr></table>
		";
		
		if ( $row->is_sample == '1' ) {
			$attachments .= add_mail_attachment( SAMPLE_CARDS_BASE . $row->card_sample_path, $boundary1);
		} else {
			$attachments .= add_mail_attachment( CUSTOMER_CARDS . $row->card, $boundary1);
		}
		
	} // end of orderDetail items list loop

	
	
	// Coupon Discount Calculation
								$couponDiscountApplied = '0.00';
								$totalPrice_remainingDifference = $actual_total - ($order_total + $ship_price+$handling_or_postage_charges+$salesTax); //$row->total_price-$total_price-$handling_or_postage_charges-$shipmentCharges;
								if($totalPrice_remainingDifference < 0)	// if its comming that GrandTotal is smaller than what is being calculated as per our accounts book then it means couponDiscount was applied
												$couponDiscountApplied = number_format($totalPrice_remainingDifference,2);
								
								$main_order_message = "<br><br><b>ORDER</b>
																																				<table cellpadding='4' cellspacing='1' style='background-color:#ccc'>
																																				<thead>
																																				<tr>
																																								<th style='background-color:#ddd'>Order Date</th>
																																								<th style='background-color:#ddd'>Customer Name</th>

																																								<th style='background-color:#ddd'>Order Gross Total</th>
																																								<th style='background-color:#ddd'>Coupon Discount</th>
																																								<th style='background-color:#ddd'>Tax</th>
																																								<th style='background-color:#ddd'>Shippping Method / Price</th>
																																								<th style='background-color:#ddd'>Order Amount</th>
																																								<th style='background-color:#ddd'>Order Status</th>
																																				</tr>
																																				</thead>
																																				<tbody>
																																				";
								$main_order_message .= "<tr>
																																<td style='background-color:#fff'>".date('d M-Y', strtotime($order_date))."</td>
																																<td style='background-color:#fff'>{$customer_name}</td>
																																<td style='background-color:#fff'>&#36; ".($order_total + $handling_or_postage_charges)."</td>
																																				
																																<td style='background-color:#fff'>&#36; ".str_replace('-','',$couponDiscountApplied)."</td>
																																<td style='background-color:#fff'>&#36; ".number_format($salesTax,2)."</td>


																																<td style='background-color:#fff'>{$shipping_method[0]} / &#36; {$shipping_method[1]}</td>
																																<td style='background-color:#fff'>&#36; ".number_format($actual_total,2)."</td>
																																<td style='background-color:#fff'>{$order_status}</td>
																												</tr>
																												";
		$main_order_message .= "	</tbody>
																										</table>	";
	

$msg = "Dear {$customer_name}<br/>Thank you for ordering your invitations from SendWithStyle. Your order has been placed successfully and is being processed. Our designers will follow up with you if they have any questions about your order. Your invitation previews are attached to this email. If you have any questions please feel free to contact us at sales@sendwithstyle.com or 720-263-7363.<br/>";
$msg .= $main_order_message . "<br/><br/><br/>";
$msg .= $order_details_message;
$msg .= "<br/><br/><br/>Please find ordered invitations below attached.  If you are having cards addressed or mailed out, the guest list can be reviewed under My Orders in your account.";

$from_name = ADMIN_FROM;
$from_email = ORDER_EMAIL;
$admin_email = ADMIN_EMAIL;
$headers = <<<HEADERS
From: $from_name <$from_email>
Cc: $admin_email
Bcc: hannan@designsoftstudios.com, alexmay@hotmail.com
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

$TextMessage
--$boundary2
Content-Type: text/html;
    charset="windows-1256"
Content-Transfer-Encoding: 7bit

$msg

--$boundary2--

$attachments
--$boundary1--
MESSAGE;

	if ( mail($to, $subject, $message, $headers ) ) {
		return TRUE;
	} else {
		return FALSE;
	}
		
	
}

function get_month_name_by_number( $m, $d = NULL ) {
	if ( is_null( $d ) ) {
		return date( 'F', strtotime( "2012-$m-28" ) );
	} else {
		return date( 'l', strtotime( $d ) );
	}
}

function day_to_words( $day ){
	switch ($day) {
		case '1' : { return 'First'; break; }
		case '2' : { return 'Second'; break; }
		case '3' : { return 'Third'; break; }
		case '4' : { return 'Fourth'; break; }
		case '5' : { return 'Fifth'; break; }
		case '6' : { return 'Sixth'; break; }
		case '7' : { return 'Seventh'; break; }
		case '8' : { return 'Eighth'; break; }
		case '9' : { return 'Ninth'; break; }
		case '10' : { return 'Tenth'; break; }
		case '11' : { return 'Eleventh'; break; }
		case '12' : { return 'Twelfth'; break; }
		case '13' : { return 'Thirteenth'; break; }
		case '14' : { return 'Fourteenth'; break; }
		case '15' : { return 'Fifteenth'; break; }
		case '16' : { return 'Sixteenth'; break; }
		case '17' : { return 'Seventeenth'; break; }
		case '18' : { return 'Eighteenth'; break; }
		case '19' : { return 'Nineteenth'; break; }
		case '20' : { return 'Twentieth'; break; }
		case '21' : { return 'Twenty First'; break; }
		case '22' : { return 'Twenty Second'; break; }
		case '23' : { return 'Twenty Third'; break; }
		case '24' : { return 'Twenty Fourth'; break; }
		case '25' : { return 'Twenty Fifth'; break; }
		case '26' : { return 'Twenty Sixth'; break; }
		case '27' : { return 'Twenty Seventh'; break; }
		case '28' : { return 'Twenty Eighth'; break; }
		case '29' : { return 'Twenty Ninth'; break; }
		case '30' : { return 'Thirtieth'; break; }
		case '31' : { return 'Thirty First'; break; }
	}
}

function validate_email( $email ) {
	 return filter_var( $email, FILTER_VALIDATE_EMAIL );
}

function get_card_url( $cat_id, $card_id ) {
	$url = "";
	if ( $cat_id == "1" ) {
		$url = "detail.php?item_id={$card_id}";
	} else if ( $cat_id == '2' ) {
		$url = "customize_savethedate.php?item_id={$card_id}";
	} else if ( $cat_id == '7' ) {
		$url = "custom.php?item_id={$card_id}";
	} else {
		$url = "customize.php?item_id={$card_id}";
	}
	return $url;
}
function pixel_to_points($px) {
	
	$pp = array(
		8 => "0.5",
		9 => "0.55",
		10 => "0.625",
		11 => "0.7",
		12 => "0.75",
		13 => "0.8",
		14 => "0.875",
		15 => "0.95",
		16 => "1",
		17 => "1.05",
		18 => "1.125",
		19 => "1.2",
		20 => "1.25",
		21 => "1.3",
		22 => "1.35",
		23 => "1.45",
		24 => "1.5",
		25 => "1.55",
		26 => "1.6",
		27 => "1.65",
		28 => "1.7",
		29 => "1.8",
		30 => "1.85",
		31 => "1.9",
		32 => "2",
		33 => "2.1",
		34 => "2.15",
		35 => "2.2",
		36 => "2.25",
		37 => "2.3",
		38 => "2.35",
		39 => "2.4",
		40 => "2.45",
		41 => "2.5",
		42 => "2.55",
		45 => "2.75",
		48 => "3"
	);
	return isset($pp[$px]) ? $pp[$px] : $pp[12];
	
	return $px * 72/96;
	
}
function get_card_envelopes( $selected = NULL ) {
	$sql = "SELECT * FROM " . TBL_ENVELOPES . " ORDER BY envelop_id ASC";
	$envelopes = mysql_query($sql) or die ( " get_card_envelopes <br/>$sql</br>" . mysql_error() );
	
	if ( mysql_num_rows( $envelopes ) ) {
		while ($envelop = mysql_fetch_object( $envelopes ) ) {
			$val = "{$envelop->envelop_picture}|{$envelop->envelop_price_per_card}";
			$price = $envelop->envelop_price_per_card > 0 ? "&#36; " . $envelop->envelop_price_per_card : 'included';
			$txt = "{$envelop->envelop_title} ( $price )";
			echo "<option value='$val'>$txt</option>";
		}
	}
}
function save_guest_ids( $data ) {
	/* check for existing */
	
	$sql = "SELECT id FROM " . TBL_TEMP_GUESTS_IDS . " WHERE id_customer = {$data['id_customer']} AND id_card = {$data['id_card']}";
	$exists = mysql_query( $sql ) or die ( "save_guest_ids {exists} <br/>$sql<br/>" . mysql_error() );
	
	if ( mysql_num_rows( $exists ) ) { // update 
		$sql = "UPDATE " . TBL_TEMP_GUESTS_IDS . " SET guest_ids = '{$data['guest_ids']}' WHERE id_customer = {$data['id_customer']} AND id_card = {$data['id_card']}";
	} else { // insert 
		$sql = "INSERT INTO " . TBL_TEMP_GUESTS_IDS . " SET guest_ids = '{$data['guest_ids']}', id_card = {$data['id_card']}, id_customer = {$data['id_customer']}";
	}
	
	mysql_unbuffered_query($sql) or die ( "save_guest_ids <br/>$sql</br>" . mysql_error() );
}

function get_guests_ids( $guest_ids ) {
	$sql = "SELECT guest_name, recipient_address FROM " . TBL_GUESTS . " WHERE guest_id IN ( {$guest_ids} )";
	$exists = mysql_query( $sql ) or die ( "get_guests_ids<br/>$sql<br/>" . mysql_error() );
	if ( mysql_num_rows( $exists ) ) {
		return mysql_result($exists, 0, 'guest_ids');
	} else {
		return (int)'0';
	}
}
function generate_card_url() {
	$required_keys = array( 
		"e_box", 
		"font_style", 
		"font_size", 
		"font_align", 
		"lh", 
		"item_id", 
		"up", 
		"font_color", 
		"line_height",
		"dimension",
		"position"
	);
	foreach( $_REQUEST as $key=>$val ) {
		if ( ! in_array($key, $required_keys ) ) {
			continue;
		}
		if ( is_array( $val ) ) {
			foreach($val as $v) {
				if ( $key == 'font_style') {
					$v = explode( '|', $v );
					$v = $v[0];
				} else {
					$v = $v;
				}
				$card_url[] = "{$key}[]=" . rawurlencode($v);
			}
			
		} else if ( $key == 'item_id' || $key == 'up' ) {
			if ( $key == 'up' ) {
				$val = explode("?", $val);
				$val = $val[0];
			}
			$card_url[] = "$key=" . rawurlencode($val);
		}
	}
	$card_url = implode('&', $card_url);
	$card_url = str_replace('\\', '', $card_url);
	return $card_url;
}

function generate_web_card_url() {
	$required_keys = array( 
		"texts", 
		"main", 
		"couples", 
		"item_id",
		'w',
		'h'
	);
	foreach( $_REQUEST as $key=>$val ) {
		if ( ! in_array($key, $required_keys ) ) {
			continue;
		}
		if ( is_array( $val ) ) {
			foreach($val as $v) {
				$card_url[] = "{$key}[]=" . rawurlencode($v);
			}
			
		} else {
			$card_url[] = "$key=" . rawurlencode($val);
		}
	}
	$card_url = implode('&', $card_url);
	$card_url = str_replace('\\', '', $card_url);
	return $card_url;
}

function get_thumbnail_name($filename = NULL, $w = NULL, $h = NULL) {
	
	if ( is_null($w) ) {
		return str_replace( ".", "-original.", $filename );
	} else if ( is_null( $h ) ) {
		return str_replace( ".", "-thumbnail.", $filename );
	} else {
		return str_replace( ".", "-{$w}x{$h}.", $filename );
	}
	
	
}
function upload_file( $file, $id = NULL, $w, $h, $card_w, $card_h ) {
	if ( !is_array( $file ) ) {
		return (string)'';
	}
	$allowed_images = array( 'jpg', 'jpeg', 'gif', 'png', 'bmp' );
	$name = $file['name'];
	$tmp_name = $file['tmp_name'];
	$basename = basename( $name );
	$ext = strtolower( end( explode( '.', $basename ) ) );
	if ( in_array($ext, $allowed_images ) ) {
		$filename = generate_friendly_name($name); //$name; //generate_permalink(str_replace(".{$ext}", "", $name ) );
		$filedest = UPLOAD_PATH . $filename; // . ".{$ext}";
		if ( move_uploaded_file( $tmp_name , $filedest ) ) {

			list( $width, $height ) = getimagesize( $filedest );
			
			$copyfile = get_thumbnail_name($filedest, $w);
			generate_thumbnail($filedest, $copyfile, round($width*0.5), round($height*0.5));
			
			/*
			$copyfile = get_thumbnail_name($filedest, round($width*1.5), round($height*1.5));
			generate_thumbnail($filedest, $copyfile, round($width*1.5), round($height*1.5));
			
			$copyfile = get_thumbnail_name($filedest, round($width*0.5), round($height*0.5));
			generate_thumbnail($filedest, $copyfile, round($width*0.5), round($height*0.5));
			*/
			$copyfile = get_thumbnail_name($filedest, round($width*0.2), round($height*0.2));
			generate_thumbnail($filedest, $copyfile, round($width*0.2), round($height*0.2));
			
			$copyfile = get_thumbnail_name($filedest);
			//generate_thumbnail($filedest, $copyfile, round($width*0.8), round($height*0.8));
			copy($filedest, $copyfile);

			
			return $filename;
		} else {
			return (string)'';
		}
	} else {
		return (string)'';
	}
}

function generate_thumbnail($img, $thumbnail, $newwidth, $newheight ) {
	
	$ext = strtolower( end( explode( '.', $img ) ) );
	if ($ext == 'jpg' || $ext == 'jpeg' ) {
		$source = imagecreatefromjpeg( $img );
	} else if ( $ext == 'png' ) {
		$source = imagecreatefrompng( $img );
	} else if ( $ext == 'gif' ) {
		$source = imagecreatefromgif( $img );
	} else {
		die('wrong type');
	}
		
	
	list( $width, $height ) = getimagesize( $img );
	
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	
	if ($ext == 'jpg' || $ext == 'jpeg' ) {
		imagejpeg($thumb, $thumbnail);
	} else if ( $ext == 'png' ) {
		imagepng($thumb, $thumbnail);
	} else if ( $ext == 'gif' ) {
		imagegif($thumb, $thumbnail);
	} 
	imagedestroy($thumb);
}

function fileDownloader($filePath)
{
	if (file_exists($filePath)) 
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($filePath));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		ob_clean();
		flush();
		readfile($filePath);
		exit;
	}
	
	
	
}

function generate_permalink( $title ) {
	
	$title = strip_tags($title);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	if (function_exists('mb_strtolower')) {
		$title = mb_strtolower($title, 'UTF-8');
	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '-', $title);

	// nbsp, ndash and mdash
	$title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );
	// iexcl and iquest
	$title = str_replace( array( '%c2%a1', '%c2%bf' ), '', $title );
	// angle quotes
	$title = str_replace( array( '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba' ), '', $title );
	// curly quotes
	$title = str_replace( array( '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d' ), '', $title );
	// copy, reg, deg, hellip and trade
	$title = str_replace( array( '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2' ), '', $title );


	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}

function generate_friendly_name($str, $separator = 'dash', $lowercase = FALSE) {
	if ($separator == 'dash') {
		$search		= '_';
		$replace	= '-';
	} else {
		$search		= '-';
		$replace	= '_';
	}

	$trans = array(
		'&\#\d+?;' => '',
		'&\S+?;' => '',
		'\s+' => $replace,
		'[^a-z0-9\-\._]' => '',
		$replace.'+' => $replace,
		$replace.'$' => $replace,
		'^'.$replace => $replace,
		'\.+$' => ''
	);

	$str = strip_tags($str);

	foreach ($trans as $key => $val) {
		$str = preg_replace("#".$key."#i", $val, $str);
	}

	if ($lowercase === TRUE) {
		$str = strtolower($str);
	}
	return trim(stripslashes($str));
}


/*
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
exit;


	
	
}*/











function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
	$diff    =    $uts['end'] - $uts['start'];
	
	if( $days=intval((floor($diff/86400))) )
		$diff = $diff % 86400;
	if( $hours=intval((floor($diff/3600))) )
		$diff = $diff % 3600;
	if( $minutes=intval((floor($diff/60))) )
		$diff = $diff % 60;
	$diff    =    intval( $diff );            
	return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
}

function DownloadFile($strFilePath)
{

	$strContents = file_get_contents(realpath($strFilePath));
	if (strpos($strFilePath,"\\") > -1 )
		$strFileName = substr($strFilePath,strrpos($strFilePath,"\\")+1);
	else
		$strFileName = substr($strFilePath,strrpos($strFilePath,"/")+1);

	header('Content-Type: application/octet-stream');
	header("Content-Disposition: attachment; filename=\"${strFileName}\"");
	echo $strContents;
}
function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
{

	/*
	$interval can be:
	yyyy - Number of full years
	q - Number of full quarters
	m - Number of full months
	y - Difference between day numbers
	(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33".
                 The datediff is "-32".)
	d - Number of full days
	w - Number of full weekdays
	ww - Number of full weeks
	h - Number of full hours
	n - Number of full minutes
	s - Number of full seconds (default)
	*/

	if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds

	switch($interval) {
		case 'yyyy': // Number of full years
		$years_difference = floor($difference / 31536000);
		if (mktime(date("H", $datefrom),
                              date("i", $datefrom),
                              date("s", $datefrom),
                              date("n", $datefrom),
                              date("j", $datefrom),
                              date("Y", $datefrom)+$years_difference) > $dateto) {

		$years_difference--;
		}
		if (mktime(date("H", $dateto),
                              date("i", $dateto),
                              date("s", $dateto),
                              date("n", $dateto),
                              date("j", $dateto),
                              date("Y", $dateto)-($years_difference+1)) > $datefrom) {

		$years_difference++;
		}
		$datediff = $years_difference;
		break;

		case "q": // Number of full quarters
		$quarters_difference = floor($difference / 8035200);
		while (mktime(date("H", $datefrom),
                                   date("i", $datefrom),
                                   date("s", $datefrom),
                                   date("n", $datefrom)+($quarters_difference*3),
                                   date("j", $dateto),
                                   date("Y", $datefrom)) < $dateto) {

		$months_difference++;
		}
		$quarters_difference--;
		$datediff = $quarters_difference;
		break;

		

		case "ww": // Number of full weeks
		$datediff = floor($difference / 604800);
		break;

		case "h": // Number of full hours
		$datediff = floor($difference / 3600);
		break;

		case "n": // Number of full minutes
		$datediff = floor($difference / 60);
		break;

		default: // Number of full seconds (default)
		$datediff = $difference;
		break;
	}

	return $datediff;
}
