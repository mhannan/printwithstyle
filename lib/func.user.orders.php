<?php
function getCustomer_orders($customer_id, $objDb) {
	$res = $objDb -> SelectTable('customer_orders', '*', 'user_id="' . $customer_id . '"', 'order_id DESC');
	return $res;
}

function cancel_order($gid, $customer_id, $objDb) {
	$res = $objDb->DeleteTable('customer_guests', 'guest_id= "' . $gid . '" AND customer_id="' . $customer_id . '"');
	return $res;
}


function get_customer_orders( $id_user = NULL ) {
	$tbl_orders = TBL_ORDER;
	$tbl_order_details = TBL_ORDER_DETAILS;
	$tbl_cards = TBL_CARDS;
	$tbl_paper_type = TBL_PAPER_TYPE;
	
	
	$id_user = is_null( $id_user ) ? " 1 = 1 " : " $tbl_orders.id_customer = $id_user ";
	$sql = "
	SELECT
		$tbl_orders.id AS 'ID_ORDER',
		$tbl_orders.*,
	 $tbl_order_details.id AS 'ID_ORDER_DETAIL',
		GROUP_CONCAT(
			CONCAT( $tbl_paper_type.paper_name, '(', $tbl_paper_type.paper_color_name , '-', $tbl_paper_type.paper_weight , ')' ), '{|}',
			CONCAT( $tbl_cards.card_title, ' : ', $tbl_cards.card_code ), '{|}',
			$tbl_order_details.quantity_price, '{|}',
			$tbl_order_details.card, '{|}',
			$tbl_order_details.mail_option
			SEPARATOR '{order}'
		) AS 'order_details', $tbl_cards.cat_id AS cat_id,
		$tbl_order_details.data
	FROM $tbl_orders
	
	INNER JOIN $tbl_order_details ON $tbl_order_details.id_order = $tbl_orders.id 
	INNER JOIN $tbl_cards ON $tbl_cards.card_id = $tbl_order_details.id_card
	INNER JOIN $tbl_paper_type ON $tbl_paper_type.paper_id = $tbl_order_details.paper_type
	
	WHERE  $id_user
	GROUP BY $tbl_orders.id
	ORDER BY $tbl_orders.order_date DESC
	";
	$orders = mysql_query($sql) or die ( "get_my_orders</br>$sql" . mysql_error() );
	if ( mysql_num_rows( $orders ) ) {
		return $orders;
	} else {
		return FALSE;
	}
}