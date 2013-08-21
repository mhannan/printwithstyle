<?php
include 'config/config.php';
include 'lib/func.cart.php';
extract($_REQUEST);


$shipping_price = explode("|", $shipping_price);

$cart['id_customer'] = $_SESSION['user_id'];
$cart['ip'] = $_SESSION['ip'];
$cart['session_id'] = $_SESSION['session_id'];
$cart['id_card'] = $item_id;
$cart['paper_type'] = $paper_type;
$cart['quantity_price'] = $qty_price;
$cart['data'] = $_REQUEST;
$cart['mail_option'] = $mail_option;
$cart['shipping_method'] = isset($shipping_price[0]) ? $shipping_price[0] : NULL;
$cart['shipping_price'] = isset($shipping_price[1]) ? $shipping_price[1] : NULL;
$cart['card'] = date('Ynjhis') . ".png" ;

/* generate create card url params */
if ( isset( $w ) && isset( $h ) ) {
	$card_url = generate_web_card_url();
	$url = siteURL . "create_wed_card.php?1=1&add_to_cart={$cart['card']}&$card_url";
	
} else {
	$card_url = generate_card_url();
	$url = siteURL . "create_card.php?1=1&add_to_cart={$cart['card']}&$card_url";
}
echo "<img src='$url' style='display:none; visibility: hidden;' />";
add_to_cart($cart);
echo "<meta http-equiv='Refresh' content='0; URL=cart.php' />";
