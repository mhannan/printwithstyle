<?php
//include("lib/func.common.php");
include ("lib/func.user.orders.php");
$user_id = $_SESSION['user_id'];
$res = $objDb -> SelectTable(USERS, "*", "id='$user_id'");
$row = mysql_fetch_array($res);
$msg = $_GET['msg'];
error_reporting(1);
?>
<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
<div class="body_internal_wrapper">
	<?php 
				$profile_pic_path = "images/no-photo.jpg";
				if($row['profile_pic_path'] !='')
								$profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];
				
				include("leftsection_member.php")
	?>
	<div class="body_right">
		<!--body_right-->
		<div class="home_wedng_inv_wrapp">
			<!--home_invitatins_wrapp-->
			<?php
				if ($msg == "succ") {
					if (isset($_GET['str']))
						echo "<div class='alert_success'><div>" . base64_decode($_GET['str']) . "</div></div>";
					else
						echo "<div class='alert_success'><div>Guest added saved successfully.</div></div>";
				} elseif ($msg == 'err') {
					if (isset($_GET['str']))
						echo "<div class='alert_success'><div>" . base64_decode($_GET['str']) . "</div></div>";
					else
						echo "<div class='alert_success'><div>Unable to add guest.</div></div>";
				}
			?>
			<table border="0" cellpadding="4" cellspacing="1" width="100%" bgcolor="#eee" class="listing_tbl" style="margin-top:10px">
				<tr>
					<th>Sr#</th>
					<th>Billing / Shipping Information</th>
					<th>Total Price</th>
					<th>Order Date</th>
					<th>Order Status</th>
					<th>&nbsp;</th>
				</tr>
				<?php
					$res = get_customer_orders( $_SESSION['user_id'] );
					if ( $res ) {
						$i= 1;
						while( $row = mysql_fetch_object( $res ) ) {
							/* geneate popup div contents */
							$dv = "<div id='{$i}_dv_order' style='display:none; visiblity:hidden'><p><table width='500px' cellpadding='4' cellspacing='1' >";
							$orders = explode( '{order}', $row->order_details); // multiple order details
							foreach($orders as $order ) { // loop through each order to generate its div to be shown via thickbox popup
								//var_dump($order);
								$extras = explode( '{|}', $order );
								//var_dump($extras);
								list(
									$paper_name,
									$card_title,
									$quantity_price,
									$card, 
									$mail_option,
									$data
									) = $extras;
									
								$qty = explode( '||', $quantity_price);
								/* For guests collection read related to this card */
								$object4guests = (object)unserialize($row->data);
								$guests_ids = $object4guests->guest_ids; //$objOrder->get_guests_ids( $item->item_id, $row->id_customer );
								if ( $guests_ids ) 
									{
												$guest_count = explode(",", $guests_ids);
												$guest_count = count($guest_count);
									} 
								else 
													$guest_count = '0';
								
								if ( $guests_ids ) 
									{
																include_once('admin/lib/func.orders.php');
																$guests = $objOrder->get_guests_ids( $guests_ids, NULL, FALSE );
																if ( $guests ) 
																{
																				$guest_names = "Address to Print <a href='guest-list.php?a={$card_title}&id={$row->ID_ORDER_DETAIL}'>(download csv)</a><br/>";
																				while ( $guest = mysql_fetch_object( $guests ) ) 
																								$guest_names .= $objOrder->generate_guest_address($guest, $guest_names);
																}
																$guest_names = "<div style='height: 150px; overflow: auto; border: 1px solid #ccc;'>{$guest_names}</div>";
								} 
								else 
																$guest_names = '';
								
								
								/* // end of guest collection */
								
								$data = unserialize( $row->data );  //echo '<pre>'; print_r($data); echo '</pre>';
								$quantity = $qty[1];
								$price = $qty[2];
								$total_price = $price;
								/* envelopes */
								$envelope_price = $data['total_envelope'];
								$x_envelope_price = $data['total_x_envelope'];
								$x_envelop_count = $data['x_envelop']; 
								$x_envelope_singleEnvPrice = $x_envelope_price/$x_envelop_count;
								// 0 => envelope_image, 1 => per envelope_cost
								$envelop = explode( "|", $data['envelop'] );
								$envelop_img = ENVELOPES . $envelop[0];
								$envelop_price = $envelop[1];
								/* shipping method and price */ 
								$shipping = explode( "|", $data['shipping_price'] );  // actually wrong column(in db - 'billingphone') is being used to hold shipment data
								$shipping_method = $shipping[0];
								$shipping_cost = $shipping[1];
								
								/* mail option */
								$totalGuests = $data['total_guest_ids'];
								$mail_option = ""; $handling_or_postage_string = ""; $handling_or_postage_charges = '0.00';
								switch ($data['mail_option'] ) {
									case 'send_me': {
										$mail_option = "Mailed to you.<br/>";
										break;
									}
									case 'address_for_me': {
										switch ( $data['mail_option_addresses'] ) {
											case 'both': {
												$add = "Print Both Address and ";
																																																				// calculation for handing+printing+postage (if any)
												$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$totalGuests;			// postage calculation to(selected) guests
												$handling_or_postage_string = $totalGuests." Guests x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
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
												$add = "Print Recipients Address only and ";
												$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$totalGuests;			// postage calculation to(selected) guests
												$handling_or_postage_string = $totalGuests." Guests x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
												break;
											}
										}
										$mail_option = "$add mailed to you.<br/>";
										break;
									}
									case 'mail_for_me': {
										$mail_option = "Addressed and Mailed to your guests.<br/>";
										$handling_or_postage_charges = MAIL_ENVELOPE_COST*$totalGuests;			// postage calculation to(selected) guests
										$handling_or_postage_string = $totalGuests." Guests x $".MAIL_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
										break;
									}
									case 'with_wed': {
										$mail_option = "Deliver with Wedding Card<br/>";
										break;
									}
									
									case 'response_for_me': {
										$mail_option = "Print return address and Mailed to you.<br/>";
										$handling_or_postage_charges = ADDRESS_ENVELOPE_COST*$quantity;			// postage calculation to(selected) guests
										$handling_or_postage_string = $quantity." Cards x $".ADDRESS_ENVELOPE_COST." = $".number_format($handling_or_postage_charges,2);
										break;
									}
								}
								
								/* generate the options string one by one */
								if (  $data['mail_option'] == 'with_wed' ) {
		
								} else if ( !$envelop_price ) {
													if($row->cat_id=='4'||$row->cat_id=='5'||$row->cat_id=='6')
																$options = "Envelopes: N/A";
												else
																$options = "Envelopes: included";
								} else if ( $envelop_price > 0 ) {
									$total_envelopes = (float)$envelop_price * (float)$quantity;
									$options = "Envelopes : &#36; {$envelop_price} x {$quantity} = &#36; ".number_format($total_envelopes,2);
									$total_price = (float)$total_price + (float)$total_envelopes;
								}
								
								if ( $x_envelope_price ) {
									$_perenvelope = $envelop_price > 0 ? $envelop_price : (float)$envelop_price;
									#$_perenvelope = $envelop_price > 0 ? $envelop_price : (float)ONE_ENVELOPE_COST;
								
									$total_x_envelopes = $x_envelope_singleEnvPrice * (float)$x_envelop_count;
									$options .= "<br/>Extra Envelopes : {$x_envelop_count} x &#36; {$x_envelope_singleEnvPrice} = &#36; ". number_format($total_x_envelopes,2);
									$total_price = (float)$total_price + (float)$total_x_envelopes;
								}
								
								$options .='<br><i>'. $mail_option.'</i><br>'
																				. $handling_or_postage_string;
								$total_price = (float)$total_price + (float)$shipping_cost; 
								$img = CUSTOMER_CARDS_VIEW . $card;
								
								/* shippment info (if set) */
								$shipment_data = explode('|',$row->billing_phone);		// actually wrong column(in db) is being used to hold shipment data
								$shipmentCharges = $shipment_data[1];
								$shipmentMethod = $shipment_data[0];
								
								/* finding/locating if discount OR saletesTax applied */
								$salesTax = $row->tax_applied;
								$couponDiscountApplied = '0.00';
								$totalPrice_remainingDifference = $row->total_price-$total_price-$handling_or_postage_charges-$shipmentCharges-$salesTax;
								
								if($totalPrice_remainingDifference < 0)	// if its comming that GrandTotal is smaller than what is being calculated as per our accounts book then it means couponDiscount was applied
												$couponDiscountApplied = number_format($totalPrice_remainingDifference,2);
								
								$dv .= "
								<tr valign='top'>
									<td><b>ORDER DETAILS:</b>
												  <div style='text-align:center'>
																				<a href='{$img}' target='_blank' ><img src='{$img}' style='width: 200px' /> <br><br><img src='images/zoom.png' border='0'></a>
																				<!--<img src='{$img}' style='width: 200px' />--></div>
									</td>
									<td style='padding-left: 20px;'>
												<table border='0' cellpadding='4' cellspacing='1' id='order_detail_popup_view_tbl'>
																<!-- <tr>
																				<td>Price</td><td> &#36;".$price."</td></tr> -->
																<tr>								
																				<td>Card Title</td><td>".$card_title."</td></tr>
																<tr>								
																				<td>Paper</td><td>".$paper_name."</td></tr>
																<tr>								
																				<td>Quantity</td><td>". $quantity." cards</td></tr>
																<tr>								
																				<td>Cards Price</td><td>$". number_format($price,2)."</td></tr>
																<tr>								
																				<td colspan='2'>".$options."<br>".$guest_names."</td></tr>
																<tr>								
																				<td><b>Gross Total</b></td><td> &#36;".number_format(($total_price+$handling_or_postage_charges) , 2)."</td></tr>
																<tr><td>Coupon Discount</td><td>- $".str_replace('-','',$couponDiscountApplied)."</td></tr>								
																".($shipmentCharges >0?'<tr><td>Shipping Charges</td><td>$'.$shipmentCharges.'&nbsp;&nbsp; <i>('.$shipmentMethod.')</i></td></tr>':'')."
																<tr><td>Sales Tax</td><td>$".$salesTax."</td></tr>
																<tr><td style='background-color:#eee'><b>Net Total</b></td><td style='background-color:#eee'><b>$".($row->total_price)."</b></td></tr>
													</table>
									</td>
								</tr>
								";
								
							}
							$dv .= "</table><p></div>";
							
							/* generate billing & shipping if exists */
							$billing = @unserialize($row->billing);
							if ( $billing ) {
								if ( !empty( $billing ) ) {
												$same_shipping_as_billing = (strcmp($row->billing, $row->shipping)? '1':'0');
									$shipping = @unserialize($row->shipping);
									$bill_ship = "<table><tr>
									<td>
									<strong>Billing</strong><br/>
									Name : {$billing['name']}<br/>
									Address : {$billing['address']}<br/>
									City : {$billing['city']}<br/>
									State : {$billing['state']}<br/>
									Zip : {$billing['zip']}<br/>
									Country : {$billing['country']}
									</td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td>
									<strong>Shipping</strong><br/>
									Name : ".($same_shipping_as_billing=='1'?$billing['name']: $shipping['name'])."<br/>
									Address : ".($same_shipping_as_billing=='1'?$billing['address']: $shipping['address'])."<br/>
									City : ".($same_shipping_as_billing=='1'?$billing['city']: $shipping['city'])."<br/>
									State : ".($same_shipping_as_billing=='1'?$billing['state']: $shipping['state'])."<br/>
									Zip : ".($same_shipping_as_billing=='1'?$billing['zip']: $shipping['zip'])."<br/>
									Country : ".($same_shipping_as_billing=='1'?$billing['country']: $shipping['country'])."
									</td>
									
									</tr></table>
									";
								}
							} else {
								$bill_ship = "Mailed to your guests";
							}
							
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $bill_ship;?></td>
							<td>$<?php echo $row->total_price;?></td>
							<td><?php echo date('dM-Y', strtotime($row->order_date)); ?></td>
							<td><i><?php echo ($row->status=='Paid'?'<span style="color:green">Paid</span>':$row->status); ?></i></td>
							<td>
								<?php echo $dv;?>
								<a class="thickbox" href="#TB_inline?height=255&width=600&inlineId=<?php echo $i;?>_dv_order">Details</a>
							</td>
						</tr>
						<?php
						$i++;
						} // while closing 
					} else {
						echo '<tr><td colspan="6" align="center">No record found.</td>';
					}
					?>
			</table>
		</div><!--home_invitatins_wrapp-->
	</div><!--body_right-->
</div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
