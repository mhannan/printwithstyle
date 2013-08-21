<?php
require ('include/gatekeeper.php');
$_SESSION['urlselected'] = 'oders';
require ('../header.php');
require_once ("../lib/func.orders.php");

if (!checkPermission($_SESSION['admin_id'], 'view_orders', 'admin')) {
	$errmsg = base64_encode('You are not allowed to view that Page');
	echo "<script> window.location = '../index.php?errmsg=$errmsg';</script>";
	exit ;
}

extract($_REQUEST);
if ( !isset( $id ) && empty( $id ) ) {
	$url = siteURL . "/admin/orders/"; 
	echo "<meta http-equiv='Refresh' content='0; URL=$url' />";
}

/* update card reviewed by admin */
$values['admin_reviewed'] = '1';
$objOrder->update( $id, $values );
?>

<!-- that's IT-->	 
<div id="main-content"> <!-- Main Content Section with everything --> 
	<div class="content-box"><!-- Start Content Box --> 
		<div class="content-box-header">
			<h3>Order Details</h3>
			<ul class="content-box-tabs">
				<li><a class="default-tab">Order Detail</a></li>
			</ul>
			<div class="clear:both"></div>
		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab">
				<table>
					<thead>
						
						<tr>
							<th>Card Detail</th>
							<th>Mail Option</th>
							<th>Envelope Detail</th>
							<th>Customer Card</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$table = $objOrder->get_single($id);
						if ( $table ) {
							$billing = $shipping = $ship_method = $ship_price = $customerNameEmail ="";		// customemr Name email is to check who placed the order
							$order_total = $actual_total = 0;
							while ($row = mysql_fetch_object( $table ) ) {
								//echo "<pre>"; print_r($row); echo "</pre>";
								$customerNameEmail = $row->u_name.' ('.$row->email.')';
								$actual_total = $row->total_price;
								$_billing = isset($row->billing) ? unserialize($row->billing) : FALSE;
								$billing = $shipping = "";
								if ( $_billing ) {
									$billing = "Name: {$_billing['name']}<br/>";
									$billing .= "Address: {$_billing['address']}<br/>";
									$billing .= "City: {$_billing['city']}<br/>";
									$billing .= "State: {$_billing['state']}<br/>";
									$billing .= "Zip: {$_billing['zip']}<br/>";
									$billing .= "Country: {$_billing['country']}<br/>";
									$billing .= "Phone #: {$_billing['phone']}";
								}
								
								$_shipping = isset($row->shipping) ? unserialize($row->shipping) : FALSE;
								if ( $_shipping ) {
									$shipping = "Name: {$_shipping['name']}<br/>";
									$shipping .= "Address: {$_shipping['address']}<br/>";
									$shipping .= "City: {$_shipping['city']}<br/>";
									$shipping .= "State: {$_shipping['state']}<br/>";
									$shipping .= "Zip: {$_shipping['zip']}<br/>";
									$shipping .= "Country: {$_shipping['country']}<br/>";
									$shipping .= "Phone #: {$_shipping['phone']}";
								}
								
								$salesTax = $row->tax_applied;
								$shipping_method = explode( "|", $row->billing_phone );
								$ship_method = $shipping_method[0];
								$ship_price = $shipping_method[1];
								/* main details */
								$quantity_price = explode( '||', $row->quantity_price);
								$card_img = CUSTOMER_CARDS_VIEW . $row->card;
								/* extra details */
								$item = (object)unserialize($row->data);
								//var_dump($item);
								$guests_ids = $item->guest_ids; //$objOrder->get_guests_ids( $item->item_id, $row->id_customer );
								if ( $guests_ids ) {
									$guest_count = explode(",", $guests_ids);
									$guest_count = count($guest_count);
								} else {
									$guest_count = '0';
								}
								
								if ( $guests_ids ) {
									$guests = $objOrder->get_guests_ids( $guests_ids, NULL, FALSE );
									if ( $guests ) {
										$guest_names = "Address to Print <a href='guest-list.php?a={$row->card_title}&id={$row->id_order_detail}'>(download csv)</a><br/>";
										while ( $guest = mysql_fetch_object( $guests ) ) {
											$guest_names .= $objOrder->generate_guest_address($guest, $guest_names);
										}
									}
									
									$guest_names = "<div style='height: 150px; overflow: auto; border: 1px solid #ccc;'>{$guest_names}</div>";
								} else {
									$guest_names = '';
								}
								/* mailing option */
								$mail_option = $objOrder->get_mailing_option($row->mail_option, $item->mail_option_addresses, $guest_count, $row->shipping,$quantity_price[1] );
								$handling_or_postage_charges = $_SESSION['handling_or_postage_charges'];				// this session varialbe is created & assigned value inside above function. as above function used in multiple places so to avoide any big changes we did shortcut
								/* envelope options */
								
								$envelope_option = $objOrder->get_envelope_data( $item, $quantity_price[1],$row->cat_id );
								
								
								if ( isset($item->total_x_envelope)) {
									$x_envelope_price = $item->total_x_envelope;
								}
								if ( isset($item->x_envelop)) {
									$x_envelop_count = $item->x_envelop;
								}
								
								$envelop = explode( "|", $item->envelop );
								$envelop_price = $envelop[1];
								
								$total_envelopes = (float)$envelop_price * (float)$quantity_price[1];
								$total_x_envelopes = (float)$envelop_price * (float)$x_envelop_count;
								
								/* add shipping total */
								//$shipping_cost = explode("|", $row->billing_phone);
								$subtotal = (float)$quantity_price[2] + (float)$total_envelopes + $x_envelope_price; //(float)$total_x_envelopes;
								/* calculate tax */
								//$tax_amount = (float)$row->total_price - (float)$subtotal; 
								$order_total += (float)$subtotal;
								
								$special_instructions = isset($item->special_instructions) ? "Special Instructions: <strong>$item->special_instructions</strong>" : NULL;
								echo "
								<tr>
									<td style='vertical-align: top;'>
										<strong style='color:#29748C'>(".(substr($row->cat_title, -1) == 's'?substr($row->cat_title, 0, -1):$row->cat_title).")</strong><br/>		
										Card Title: <strong>{$row->card_title}</strong><br/>
										Paper Type: <strong>{$row->paper_name}</strong><br/>
										Quantity Ordered: <strong>{$quantity_price[1]}</strong><br/>
										Card Price: &#36; <strong>{$quantity_price[2]}</strong><br/>
										Sub Total: &#36; <strong>{$subtotal}</strong><br/>
										$special_instructions
									</td>
									<td style='vertical-align: top;'>
										{$mail_option}<br/>
										$guest_names
									</td>
									<td style='vertical-align: top;'>
										{$envelope_option}
									</td>
									<td style='vertical-align: top;'>
										<a href='{$card_img}' target='_blank'>
										<img src='{$card_img}' style='width: 150px' />
										</a>
									</td>
									<td style='vertical-align: top;'>&nbsp;</td>
								</tr>
								";
							}

							$order_status = $objOrder->order_status( $id );
							
							
							//echo 'fTotal='.$actual_total.'<br>cardsTotal='.$order_total.'<br>ship='.$ship_price.'<br>handling/printing='.$handling_or_postage_charges;
							/* finding/locating if discount OR saletesTax applied */
								 $couponDiscountApplied = '0.00';
								$totalPrice_remainingDifference = $actual_total - ($order_total + $ship_price+$handling_or_postage_charges+$salesTax); //$row->total_price-$total_price-$handling_or_postage_charges-$shipmentCharges;
								if($totalPrice_remainingDifference < 0)	// if its comming that GrandTotal is smaller than what is being calculated as per our accounts book then it means couponDiscount was applied
												$couponDiscountApplied = number_format($totalPrice_remainingDifference,2);
								
							?>
							<tr>
								<td>Shipping Address:</td><td colspan="4"><?php echo $shipping; ?></td>
							</tr>
							<tr>
								<td>Billing Address:</td><td colspan="4"><?php echo $billing; ?></td>
							</tr>
							<tr>
								<td>Customer Name/ Email:</td><td colspan="4"><?php echo $customerNameEmail; ?></td>
							</tr>
							
							<tr>
								<td><b>Order Sub Total</b></td><td colspan="4"><b>&#36; <?php echo ($order_total+$handling_or_postage_charges); ?></b></td>
							</tr>
							<tr>
								<td><b>Coupon Discount</b></td><td colspan="4"><b>- &#36; <?php echo str_replace('-','',$couponDiscountApplied); ?></b></td>
							</tr>
							<tr>
								<td>Shipping Method</td><td colspan="4"><?php echo $ship_method; ?></td>
							</tr>
							<tr>
								<td>Shipping Price</td><td colspan="4">&#36; <?php echo $ship_price; ?></td>
							</tr>
							<tr>
								<td>Tax Amount</td><td colspan="4">&#36; <?php echo $salesTax; ?></td>
							</tr>
							<tr>
								<td><b>Order Total</b></td><td colspan="4"><b>&#36; <?php echo $actual_total; ?></b></td>
							</tr>
							<tr>
							<td colspan="5">
								<form action="process.php" method="post">
									<input type="hidden" name="call" value="update_status" />
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<select id="status" name="status">
									<option value="Pending" <?php echo $order_status == 'Pending' ? 'selected="selected" ' : NULL; ?>>Pending</option>
									<option value="Paid"<?php echo $order_status == 'Paid' ? 'selected="selected" ' : NULL; ?>>Paid</option>
									<option value="Shipped"<?php echo $order_status == 'Shipped' ? 'selected="selected" ' : NULL; ?>>Shipped</option>
									<option value="Delivered"<?php echo $order_status == 'Delivered' ? 'selected="selected" ' : NULL; ?>>Delivered</option>
									<option value="Canceled"<?php echo $order_status == 'Canceled' ? 'selected="selected" ' : NULL; ?>>Canceled</option>
								</select>&nbsp;
								<input type="submit" value="Update Status" name="btnUpdateStatus" />
								</form>
							</td>
						</tr>
						<?php
						} else { // if empty table  
							echo "<tr><td colspan='5'>No Order found.</td></tr>";
						}
						?>
						
					</tbody>
						
				</table>
			</div> <!-- End #tab1 -->
		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->
	<div class="clear"></div>
	<div id="footer"></div>
</div>
</div>
</body>
</html>