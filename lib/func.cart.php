<?php
function add_to_cart($arr) {

				//echo '<pre>'; print_r($arr); echo '</pre>';
	$arr['data'] = serialize($arr['data']);
	$columns = implode(', ', array_keys($arr));
	$values = '"' . implode('" , "', $arr) . '"';

	foreach ($arr as $key => $val) {
		$data[] = $key . " = '" . mysql_real_escape_string($val) . "'";
	}

	$data = implode(",", $data);

	$sql = "INSERT INTO " . TBL_CART . " SET $data";

	mysql_query($sql) or die("add to cart<br/>$sql" . mysql_error());

}

function item_exists($id_card) {
	$sql = "
		SELECT id FROM " . TBL_CART . " 
		WHERE id_card = {$id_card} AND
		( 
			id_customer = {$_SESSION['user_id']} 
		OR (
			ip = '{$_SESSION['ip']}' OR session_id = '{$_SESSION['session_id']}' 
			)
		)";
	$exists = mysql_query($sql) or die("item exists <br/>$sql<br/> " . mysql_error());

	if (mysql_num_rows($exists)) {
		return mysql_fetch_object($exists);
	} else {
		return FALSE;
	}
}

function get_cart() {
	$tbl = TBL_CART;
	$tbl_cards = TBL_CARDS;
	$tbl_paper_type = TBL_PAPER_TYPE;

	$sql = "
	SELECT 
		$tbl.*, 
		CONCAT( $tbl_paper_type.paper_name, '(', $tbl_paper_type.paper_color_name , '-', $tbl_paper_type.paper_weight , ')' ) AS 'paper_name',
		CONCAT( $tbl_cards.card_title, ' : ', $tbl_cards.card_code ) AS card_title, $tbl_cards.cat_id AS cat_id,
		$tbl_cards.card_sample_path
	FROM $tbl
	INNER JOIN $tbl_cards ON $tbl_cards.card_id = $tbl.id_card
	INNER JOIN $tbl_paper_type ON $tbl_paper_type.paper_id = $tbl.paper_type
	
	
	WHERE 1=1 AND 
	( 
		id_customer = {$_SESSION['user_id']} 
	OR (
		ip = '{$_SESSION['ip']}' OR session_id = '{$_SESSION['session_id']}' 
		)
	)
	";

	$cart = mysql_query($sql) or die("get cart<br/>$sql</br>" . mysql_error());
	if (mysql_num_rows($cart)) {
		return $cart;
	} else {
		return FALSE;
	}
}

function get_cart_count() {
	$sql = "
	SELECT count(id) AS total_items FROM " . TBL_CART . "
	WHERE 1 = 1 AND 
	( 
		id_customer = {$_SESSION['user_id']} 
	OR (
		ip = '{$_SESSION['ip']}' OR session_id = '{$_SESSION['session_id']}' 
		)
	)
	";

	$total = mysql_query($sql) or die("get_cart_count<br/>$sql</br>" . mysql_error());
	if (mysql_num_rows($total)) {
		return mysql_result($total, 0, 'total_items');
		//return $total->total_items;
	} else {
		return '0';
	}
}

function update_cart_customer_id() {
	$sql = "UPDATE " . TBL_CART . " SET 
	id_customer = {$_SESSION['user_id']} 
	WHERE
	ip = '{$_SESSION['ip']}' OR session_id = '{$_SESSION['session_id']}'
	";
	mysql_unbuffered_query($sql) or die("update_cart_customer_id<br/>$sql<br/>" . mysql_error());
}

function copy_cart_to_orders($param) {
	/* add to main order list */
	$sql = "
		INSERT INTO  " . TBL_ORDER . " SET 
		id_customer = {$_SESSION['user_id']},
		total_price = {$param['price']},
		billing = '{$param['billing']}',
		shipping = '{$param['shipping']}',
		billing_phone = '{$param['phone']}',
		tax_applied = '{$param['tax_applied']}',
		status = 'Paid'
	";
	mysql_query($sql) or die("copy_cart_to_order Main Order<br/>$sql<br/>" . mysql_error());
	$id_order = mysql_insert_id();
	/* add order_details */
	$sql = "
		INSERT INTO " . TBL_ORDER_DETAILS . " (id_order, id_card, paper_type, quantity_price, data, card, mail_option, is_sample)
		SELECT $id_order, id_card, paper_type, quantity_price, data, card, mail_option, is_sample FROM " . TBL_CART . " WHERE id_customer = {$_SESSION['user_id']} 
	";
	mysql_unbuffered_query($sql) or die("copy_cart_to_order Order Details<br/>$sql<br/>" . mysql_error());

	return (int)$id_order;
}

function empty_cart() {
	$sql = "DELETE FROM " . TBL_CART . " WHERE id_customer = {$_SESSION['user_id']}";
	mysql_unbuffered_query($sql) or die("empty_cart<br/>$sql<br/>" . mysql_error());
}

function delete_cart_item($id) {
	$sql = "DELETE FROM " . TBL_CART . " WHERE id = {$id}";
	mysql_unbuffered_query($sql) or die("delete_cart_item<br/>$sql<br/>" . mysql_error());
}