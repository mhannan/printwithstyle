<?php
class cls_orders {
	private $tbl_orders = "orders";
	private $tbl_order_details = "order_detail";
	private $tbl_cards = "cards";
	private $tbl_categories = "categories";
	private $tbl_paper_type = "paper_types";
	private $tbl_customer = "register_users";
	private $tbl_guests_id = "temp_guest_ids";
	private $tbl_customer_guests = "customer_guests";
	
	public function get_all($id = NULL) {
		$sql = "
		SELECT
			$this->tbl_orders.*,
			$this->tbl_customer.u_name AS 'customer_name', 
			$this->tbl_customer.return_address,
			$this->tbl_customer.email as 'customer_email'
		FROM $this->tbl_orders
		
		INNER JOIN $this->tbl_customer ON $this->tbl_customer.id = $this->tbl_orders.id_customer
		WHERE 1 = 1 ";
		
		$sql .= !is_null($id) ? " AND $this->tbl_orders.id = $id " : NULL;
		
		$sql .= " GROUP BY $this->tbl_orders.id
		ORDER BY $this->tbl_orders.order_date DESC
		";

		$table = mysql_query( $sql ) or die ( "get all orders</br>$sql" . mysql_error() );
		if ( mysql_num_rows( $table ) ) {
			return $table;
		} else {
			return FALSE;
		}
	} // get_all
	
	public function order_status( $id, $status = NULL ) {
		if ( is_null( $status ) ) { // get call 
			$sql = "SELECT status FROM $this->tbl_orders WHERE id = $id";
			$status = mysql_query($sql) or die ( "get status <br/>$sql<br/>" . mysql_error() );
			if ( mysql_num_rows( $status ) ) {
				return mysql_result($status, 0, 'status');
			} else {
				return 'Pending';
			}
		} else { // set call
			$sql = "UPDATE $this->tbl_orders SET status = '$status' WHERE id = $id";
			if ( mysql_unbuffered_query($sql) or die ( "set status <br/>$sql<br/>" . mysql_error() ) ) {
				/* send an email to client */
				return TRUE;	
			} else {
				return FALSE;
			}
		}
	}
	public function get_single( $id ) {
		$sql = "
		SELECT
			$this->tbl_orders.*,
			$this->tbl_order_details.id AS 'id_order_detail',
			CONCAT( $this->tbl_paper_type.paper_name, '(', $this->tbl_paper_type.paper_color_name , '-', $this->tbl_paper_type.paper_weight , ')' ) AS 'paper_name',
			CONCAT( $this->tbl_cards.card_title, ' : ', $this->tbl_cards.card_code ) AS 'card_title',
			$this->tbl_cards.cat_id,
			$this->tbl_categories.cat_title,
			$this->tbl_cards.card_sample_path,
			$this->tbl_order_details.quantity_price,
			$this->tbl_order_details.card,
			$this->tbl_order_details.mail_option,
			$this->tbl_order_details.data,
			$this->tbl_order_details.is_sample,
			$this->tbl_customer.u_name,
			$this->tbl_customer.email
		FROM $this->tbl_order_details
		
		INNER JOIN $this->tbl_orders ON $this->tbl_orders.id = $this->tbl_order_details.id_order
		INNER JOIN $this->tbl_cards ON $this->tbl_cards.card_id = $this->tbl_order_details.id_card
		INNER JOIN $this->tbl_categories ON $this->tbl_cards.cat_id = $this->tbl_categories.cat_id
		INNER JOIN $this->tbl_paper_type ON $this->tbl_paper_type.paper_id = $this->tbl_order_details.paper_type
		INNER JOIN $this->tbl_customer ON $this->tbl_customer.id = $this->tbl_orders.id_customer
		
		WHERE $this->tbl_order_details.id_order = $id
		ORDER BY $this->tbl_order_details.dated DESC
		";
		
		$table = mysql_query( $sql ) or die ( "get_single order<br/>$sql" . mysql_error() );
		if ( mysql_num_rows( $table ) ) {
			return $table;
		} else {
			return FALSE;
		} 
	} // get_single 
	
	public function get_main_order_details( $delimeted_string ) {
		$extras = explode( '{|}', $delimeted_string );
		list($data['paper_name'], $data['card_title'], $data['quantity_price'], $data['card'], $data['mail_option'], $data['data']) = $extras;
		return $data;
	}
	
	public function update( $id, $values ) {
		$cols = array();
		
		foreach( $values as $key => $val ) {
			$cols[] = "{$key} = '{$val}'";
		}
		
		$cols = implode( ', ',  $cols );
		$sql = "UPDATE {$this->tbl_orders} SET {$cols} WHERE id = {$id}";
		mysql_unbuffered_query( $sql ) or die ( " update <br/> $sql<br/>" . mysql_error() );
	}
	
	public function get_mailing_option( $option, $optional_address, $guests_ids, $shipping_address ,$quantity ='') {
		$address = $this->generate_shipping_address_string( $shipping_address );
		$mail_option = $add = ''; $handling_or_postage_string = ""; $handling_or_postage_charges = '0.00';
		
		switch ( $option ) {
			case 'send_me': {
				$mail_option = "Mailed to {$address}.<br/>";
				break;
			}
			case 'address_for_me': {
				switch ( $optional_address ) {
					case 'both': {
						$add = "Print {$guests_ids} Recipient(s) Address and Return Address and ";
																																														// calculation for handing+printing+postage (if any)
								$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$guests_ids;			// postage calculation to(selected) guests
								$handling_or_postage_string = $guests_ids." Guests x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
						break;
					}
					case 'return': {
						$add = "Print Return Address Only and ";
						$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$quantity;			// postage calculation to(selected) guests
						$handling_or_postage_string = $quantity." Cards x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
						break;
					}
					case 'return_response': {
												$add = "Print Return Address Only and ";
												$handling_or_postage_charges = RESPONSE_ADDRESS_ENVELOPE_COST*$quantity;			// postage calculation to(selected) guests
												$handling_or_postage_string = $quantity." Cards x $".RESPONSE_ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
												break;
											}
					case 'recipient': {
						$add = "Print {$guests_ids} Recipient(s) Address only and ";
						$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$guests_ids;			// postage calculation to(selected) guests
						$handling_or_postage_string = $guests_ids." Guests x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
						break;
					}
				}
				$mail_option = "$add mailed to {$address}.<br/>";
				break;
			}
			case 'mail_for_me': {
				$mail_option = "Addressed and Mailed to {$guests_ids} guest(s).<br/>";
				$handling_or_postage_charges = MAIL_ENVELOPE_COST*$guests_ids;			// postage calculation to(selected) guests
				$handling_or_postage_string = $guests_ids." Guests x $".MAIL_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
				break;
			}
			case 'with_wed': {
				$mail_option = "Deliver with Wedding Card";
				break;
			}
			
			case 'response_for_me': {
				$mail_option = "Print return address and Mailed to $address.<br/>";
				$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$quantity;			// postage calculation to(selected) guests
				$handling_or_postage_string = $quantity." Cards x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
				break;
			}
		
		}
		
		// temporary storing charges in SESSION as this function is being used in multiple places so we could not make enough changes in this and other places
		$_SESSION['handling_or_postage_charges']=$handling_or_postage_charges;
		return $mail_option.'<br>'.$handling_or_postage_string;
	}
	
	private function generate_shipping_address_string( $serailized ) {
		$shipping = @unserialize($serailized);
		if ( $shipping ) {
			return "<br/>
			{$shipping['name']},
			{$shipping['address']} {$shipping['city']},
			{$shipping['state']}, {$shipping['zip']},
			{$shipping['country']}";
		}
	}
	
	public function get_guests_ids( $id_card, $id_customer, $count_only = TRUE ) {
		if ( $count_only ) {
			$sql = "SELECT guest_ids FROM $this->tbl_guests_id WHERE id_customer = {$id_customer} AND id_card = {$id_card}";
			$table = mysql_query( $sql ) or die ( "get_guests_ids<br/>$sql<br/>" . mysql_error() );
			if ( mysql_num_rows( $table ) ) {
				return mysql_result($table, 0, 'guest_ids');
			} else {
				return (int)'0';
			}
		} else {
			$sql = "SELECT guest_name, recipient_address FROM $this->tbl_customer_guests WHERE guest_id IN ( $id_card )";
			
			$table = mysql_query( $sql ) or die ( "get_guests_ids names <br/>$sql<br/>" . mysql_error() );
			if ( mysql_num_rows( $table ) ) {
				return $table;
			} else {
				return FALSE;
			}
		}
	}
	
	
																								// $cat_id : is optional; with this we check for direction, multiPurpose, accomodation card whether if the card type if one of these then envelop option will not be included
	public function get_envelope_data( $serialize, $quantity,$cat_id='' ) {				
		
		if ( isset($serialize->total_x_envelope)) {
			$x_envelope_price = $serialize->total_x_envelope;
		}
		if ( isset($serialize->x_envelop)) {
			$x_envelop_count = $serialize->x_envelop;
		}
		
		$x_envelop_singleEnv_price = round(@($x_envelope_price/$x_envelop_count),2);
		// 0 => envelope_image, 1 => per envelope_cost
		$envelop = explode( "|", $serialize->envelop );
		$envelop_img = ENVELOPES . $envelop[0];
		$envelop_price = $envelop[1];
		
		$enveloper_option = "<img src='{$envelop_img}' style='width: 150px;' /><br/>";
		if ( !$envelop_price ) { 
								if($cat_id=='4'||$cat_id=='5'||$cat_id=='6')
												$enveloper_option = "Envelopes: N/A";
								else
												$enveloper_option .= "included";
		} else {
			$total_x_envelopes = (float)ONE_ENVELOPE_COST * (float)$x_envelop_count;
			$total_envelopes = (float)$envelop_price * (float)$quantity;
			$enveloper_option .= "&#36; {$envelop_price} x {$quantity} = &#36; ".number_format($total_envelopes,2);
		}
		
		if ( isset($x_envelope_price) && $x_envelope_price > 0 ) {
			//$total_x_envelopes = (float)$envelop_price * (float)$x_envelop_count;
			$enveloper_option .= "<br/>Extra {$x_envelop_count} x &#36; " . $x_envelop_singleEnv_price . " = &#36; ".number_format($x_envelope_price,2);
		}
		return $enveloper_option;
	}
	
	public function generate_guest_address($guest, $str) {
		$address = (object)unserialize( $guest->recipient_address );
		$str = "
		Name : {$guest->guest_name}<br/>
		{$address->_address}, {$address->_city}, {$address->_state}, {$address->_zip}, {$address->_country}<br/>		
		";
		return $str;
	}
}
/* create a class object to be used in the files */
$objOrder = new cls_orders();
