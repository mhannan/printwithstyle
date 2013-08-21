<?php
include 'config/config.php';
include 'lib/func.cart.php';
include 'admin/lib/func.coupon.php';
include 'admin/lib/func.orders.php';
include 'tax-cloud/func.taxcloud.php';

extract( $_REQUEST );

if ( 1 == 1 ) { // local testing  
	/* check for coupon code */
	if ( isset( $coupon_used ) ) {
		$price = $coupone_price;
	}

	$ship_price = explode('|', $shipping_price);
	$ship_price = $ship_price[1];
	$total_price = (float)$price + (float)$ship_price;

	update_cart_customer_id();
	/* copy current cart items to orders and order details table */
	$param['price'] = $total_price;
	$bill = isset($bill) ? $bill : "";
	$param['billing'] = serialize($bill);
	$ship = isset($ship) ? $ship : "";
	$param['shipping'] = serialize($ship);
	$param['phone'] = $shipping_price;
	
	$id_order = copy_cart_to_orders( $param );
	empty_cart();
	
	/* update coupon status */
	if ( isset( $coupon_used ) && (boolean)$coupon_used ) {
		$objCoupon->code = $coupon_used;
		$objCoupon->set_code();
		$objCoupon->is_active = '0';
		$objCoupon->use_date = 'NOW()';
		$objCoupon->update();
	}
	
	/* make it authorized at tax cloud */
	$err = Array();
	$authorize = func_taxcloud_authorized_with_capture($_SESSION['session_id'], $err);
	//$err = Array();
	//$captured = func_taxcloud_capture($_SESSION['session_id'], $err);
	session_regenerate_id(TRUE);
	$_SESSION['session_id'] = session_id();
	/* send email to admin / customer */
	
	if ( $id_order ) {
		send_order_email($objOrder, $id_order);
	}
	echo 'yes';
	exit;
}
	
 
require BASE_PATH . 'payment_gateway/authorize/shared/AuthorizeNetRequest.php';
require BASE_PATH . 'payment_gateway/authorize/shared/AuthorizeNetTypes.php';
require BASE_PATH . 'payment_gateway/authorize/shared/AuthorizeNetXMLResponse.php';
require BASE_PATH . 'payment_gateway/authorize/shared/AuthorizeNetResponse.php';
require BASE_PATH . 'payment_gateway/authorize/AuthorizeNetAIM.php';
if ( class_exists( "SoapClient" ) ) {
    require BASE_PATH . 'payment_gateway/authorize/AuthorizeNetSOAP.php';
}
$sale = new AuthorizeNetAIM(AIM_LOGIN_ID, AIM_TRANSACTION_KEY);

/* check for coupon code */
if ( isset( $coupon_used ) ) {
				if(isset($taxes))
								$price = (float)$coupone_price+(float)$taxes;
				else
								$price = $coupone_price;
}
	
/* add shipping price to total card price */
$ship_price = explode('|', $shipping_price);
$ship_price = $ship_price[1];
$total_price = (float)$price + (float)$ship_price;

$sale->amount = $total_price;
$sale->card_num = $_cc;
$sale->exp_date = "$_m/$_y";
 
$response = $sale->authorizeAndCapture();  
if ( $response->approved ) { // live 
	/* update cart to customer id  and redirect him to his orders page */
	update_cart_customer_id();
	/* copy current cart items to orders and order details table */
	$param['price'] = $total_price;
	$bill = isset($bill) ? $bill : "";
	$param['billing'] = serialize($bill);
	$ship = isset($ship) ? $ship : "";
	$param['shipping'] = serialize($ship);
	$param['phone'] = $shipping_price;
	$param['tax_applied'] = (isset($taxes)?$taxes:'0.00');
	$id_order = copy_cart_to_orders( $param );
	empty_cart();
	
	
	/* update coupon status */
	if ( isset( $coupon_used ) && (boolean)$coupon_used ) {
		$objCoupon->code = $coupon_used;
		$objCoupon->set_code();
		$objCoupon->is_active = '0';
		$objCoupon->use_date = 'NOW()';
		$objCoupon->update();
	}
	
	/* send email to admin / customer */
	if ( $id_order ) {
		send_order_email($objOrder, $id_order);
	}
	
	/* make it authorized at tax cloud */
	$err = Array();
	$authorize = func_taxcloud_authorized_with_capture($_SESSION['session_id'], $err);
	$err = Array();
	$captured = func_taxcloud_capture($_SESSION['session_id'], $err);
	session_regenerate_id(TRUE);
	$_SESSION['session_id'] = session_id();
	if ( isset( $ajax ) ) {
		echo 'yes';
	} else {
		$url = siteURL . "index.php?p=member_orders";
		echo "<meta http-equiv='Refresh' content='0; URL=$url' />";
	}
} else {
	echo $response->response_reason_text;	
}




