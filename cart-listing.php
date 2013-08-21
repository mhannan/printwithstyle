<table width="705" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th width="201">Product Image</th>
			<th width="248">Product Name</th>
			<th width="375">Options</th>
			<th width="155">Sub Total</th>
			<!--<th>&nbsp;</th>-->
		</tr>
	</thead>
	<tbody>
<?php //error_reporting(1);
$grand_total = 0;
$tax_products = array();
while ($item = mysql_fetch_object($cart) ) {
	$matching_ids[] = $item->id_card;
	$extras = unserialize( $item->data ) ;
	$is_sample = FALSE;
	if ( $item->is_sample == '1' ) {
		$img = SAMPLE_CARDS . $item->card_sample_path;
		$is_sample = TRUE;
	} else {
		$img = CUSTOMER_CARDS_VIEW . $item->card;
	}
	
	/* 0 => ID, 1 => Quantity, 2 => Price*/
	$qty_price = explode( '||', $item->quantity_price );
	/* card quantity + price */
	$quantity = $qty_price[1];
	$price = $qty_price[2];
	$total_price = $price;
	/* envelopes */
	$envelope_price = $extras['total_envelope'];
	$x_envelope_price = $extras['total_x_envelope'];
	$x_envelop_count = $extras['x_envelop'];
	// 0 => envelope_image, 1 => per envelope_cost
	$envelop = explode( "|", $extras['envelop'] );
	//print_r($envelop[1]);
	$envelop_img = ENVELOPES . $envelop[0];
	$envelop_price = $envelop[1];
	
	/* shipping method and price */
	$shipping = explode( "|", $extras['shipping_price'] );
	$shipping_method = $shipping[0];
	$shipping_cost = $shipping[1];
	$mailed_for_me_price = 0;
	
	/* tax calculation */
	$tax_price = $price;
	
	/* total guests */
	$guests_ids = $extras['guest_ids'];
	$gdiv = '';
	if ( $guests_ids ) {
		$guests_ids = explode(",", $guests_ids);
		$guests_ids = count($guests_ids);
		/* generate guest list */
		$sql = "SELECT guest_name, recipient_address FROM " . TBL_GUESTS . " WHERE guest_id IN ( {$extras['guest_ids']} )";
		
		$table = mysql_query( $sql );
		if ( mysql_num_rows( $table ) ) {
			$gdiv = "
			<br/><a href='#TB_inline?height=400&width=600&inlineId=gdv_{$item->id_card}' title='{$item->card_title}' class='thickbox' style='text-decoration: underline; font-size: 12px; font-weight: bold;'>View Guests</a>
			<div id='gdv_{$item->id_card}' style='display:none;'>
			<table border='0' cellspacing='0' cellpadding='0' class='guest_table'>
				<tr><th style='width:50px;'>Sr. No.</th><th>Name</th><th>Address</th></tr>
			";
			$g_counter = 1;
			
			while ( $grow = mysql_fetch_object( $table ) ) {
				$address = (object)unserialize( $grow->recipient_address );
				$_country = empty($address->_country) ? "" : ", {$address->_country}";
				$gdiv .= "
				<tr><td>$g_counter</td>
				<td>{$grow->guest_name}</td>
				<td>{$address->_address}, {$address->_city}, {$address->_state}, {$address->_zip}{$_country}</td></tr>";
				
				$g_counter++;
			}
			$gdiv .= "
			</table>
			</div>";
		}
		
	}
	$mail_option = "";
	$address_envelop_pricing = "0";
	//$display_bill_ship = FALSE;
	//echo $extras['mail_option_addresses'];
	
	switch ($extras['mail_option'] ) {
		case 'send_me': {
			$mail_option = "Mailed to you.<br/>";
			$display_bill_ship = TRUE;
			break;
		}
		case 'address_for_me': {
			switch ( $extras['mail_option_addresses'] ) {
				case 'both': {
					//$address_envelop_pricing = number_format($guests_ids*ADDRESS_ENVELOPE_COST,2);			
					$add = $guests_ids."Guests x $".ADDRESS_ENVELOPE_COST." = $".$address_envelop_pricing." <br>Print {$guests_ids} Recipient(s) Address and Return Address and ";
					$add = "Print {$guests_ids} Recipient(s) Address and Return Address and ";
					break;
				}
				case 'return': {
					$address_envelop_pricing = number_format($quantity*ADDRESS_ENVELOPE_COST,2);
					$add = $quantity." x $".ADDRESS_ENVELOPE_COST." = $".$address_envelop_pricing." <br>Print Return Address Only and ";
					break;
				}
				case 'return_response': {							// Response card 'return address print' option selected
					$address_envelop_pricing = number_format($quantity*RESPONSE_ADDRESS_ENVELOPE_COST,2);
					$add = $quantity." x $".RESPONSE_ADDRESS_ENVELOPE_COST." = $".$address_envelop_pricing." <br>Print Return Address Only and ";
					break;
				}
				case 'recipient': {
					//$address_envelop_pricing = number_format($guests_ids*ADDRESS_ENVELOPE_COST,2);
					//$add = $guests_ids."Guests x $".ADDRESS_ENVELOPE_COST." = $".$address_envelop_pricing." <br>Print {$guests_ids} Recipient(s) Address only and ";
					$add = "Print {$guests_ids} Recipient(s) Address only and ";
					break;
				}
			}
			
			$mail_option = "$add mailed to you.";
			$display_bill_ship = TRUE;
			
			// concatinate VIEW GUEST only if PRINT-type is not 'return address only'
			if($extras['mail_option_addresses'] !="return")
					$mail_option .= $gdiv;
			
			/* add address for me price to total price */
			if ( $guests_ids > 0 && $extras['mail_option_addresses'] !="return") {
				$guest_qty = $guests_ids; // $quantity   
				$mailed_for_me_price = (float)$guest_qty * (float)ADDRESS_ENVELOPE_COST;
				$mail_option .= "<br/> $guest_qty x &#36;" . ADDRESS_ENVELOPE_COST . " = &#36;" . $mailed_for_me_price;
				$total_price = (float)$total_price + (float)$mailed_for_me_price;
			}
			
			break;
		}
		case 'mail_for_me': {
			$mail_option = "Addressed and Mailed to your {$guests_ids} guest(s).<br/>";
			/* check for total guests selected and quantity */
			if ( (float)$guests_ids < (float)$quantity ) {
				$display_bill_ship = TRUE;
			}
			
			/* add mailed for me price to total price */
			if ( $guests_ids > 0 ) {
				$guest_qty = $guests_ids; // $quantity 
				$mailed_for_me_price = (float)$guest_qty * (float)MAIL_ENVELOPE_COST;
				$mail_option .= "<br/> $guest_qty x &#36;" . MAIL_ENVELOPE_COST . " = &#36;" . $mailed_for_me_price;
				$total_price = (float)$total_price + (float)$mailed_for_me_price;
				$mail_option .= $gdiv;
			}
			break;
		}
		case 'with_wed': {
			$mail_option = "Deliver with Wedding Card";
			break;
		}
		
		case 'response_for_me': {
				$address_envelop_pricing = number_format($quantity*ADDRESS_ENVELOPE_COST,2);
			 $mail_option = $quantity." x $".ADDRESS_ENVELOPE_COST." = $".$address_envelop_pricing." <br>Print return address and Mailed to me.<br/>";
			
			# response cards are not directly sent to guests. it only has retun address over it so Quanity*cards
			/*
			if ( $guests_ids > 0 ) { 
				$guest_qty = $guests_ids; // $quantity 
				$mailed_for_me_price = (float)$guest_qty * (float)RESPONSE_ADDRESS_ENVELOPE_COST;
				$mail_option .= "<br/> $guest_qty x &#36;" . RESPONSE_ADDRESS_ENVELOPE_COST . " = &#36;" . $mailed_for_me_price;
				$total_price = (float)$total_price + (float)$mailed_for_me_price;
			}*/
			break;
		}
		case 'address_and_stamp_for_me': {
				$address_envelop_pricing = number_format($quantity*ADDRESS_STAMP_COST,2);
			 $mail_option = $quantity." x $".ADDRESS_STAMP_COST." = $".$address_envelop_pricing." <br>Print return address, Stamp it and mail along wedding invitations.<br/>";
 			break;
		} 
	}
	
	/* generate the options string one by one */
	$options = '';
	//print_r($envelope_price);
	/*
	if (  $extras['mail_option'] == 'with_wed' ) {
		
	} else*/ if ( !$envelop_price ) 
					{
								if($item->cat_id=='4'||$item->cat_id=='5'||$item->cat_id=='6')
												$options = "<div class='product_options_wrapp'>Envelopes<br/> <span>N/A</span></div>";
								else
												$options = "<div class='product_options_wrapp'>Envelopes<br/> <span>included</span></div>";
								
	  } else if ( $envelop_price > 0 ) {
		$total_envelopes = (float)$envelop_price * (float)$quantity;
		$options = "<div class='product_options_wrapp'>Envelopes<br/> <span>&#36;{$envelop_price} x {$quantity} = &#36;{$total_envelopes}</span></div>";
		$total_price = (float)$total_price + (float)$total_envelopes;
		/* tax calculation */
		$tax_price = (float)$tax_price + (float)$total_envelopes; 
	}
	
	// in case PRINT ADDRESS option used then include its cost as well
	
	if($address_envelop_pricing >0)
	{
					$total_price = (float)$total_price + (float)$address_envelop_pricing;
					$tax_price = (float)$tax_price + (float)$address_envelop_pricing;
	}
	
	if ( $x_envelope_price ) {
		$_perenvelope = $envelop_price > 0 ? $envelop_price : (float)ONE_ENVELOPE_COST;
	
		$total_x_envelopes = $_perenvelope * (float)$x_envelop_count;
		$options .= "<div class='product_options_wrapp'>Extra Envelopes<br/> <span>{$x_envelop_count} x &#36;{$_perenvelope} = &#36;{$total_x_envelopes}</span></div>";
		$total_price = (float)$total_price + (float)$total_x_envelopes;
		/* tax calculation */
		$tax_price = (float)$tax_price + (float)$total_x_envelopes;
	}
	
	$options .= "<div class='product_options_wrapp'>Mailing Option<br/> <span>$mail_option</span></div>";;
	/* sample card settings */
	$options = $is_sample ? "Sample" : $options;
	$display_bill_ship = $is_sample ? TRUE : $display_bill_ship;
	
	$grand_total += (float)$total_price;
	echo "
	<tr class='{$item->id}'>
		<td rowspan='5' align='center'>
		<a href='{$img}' class='thickbox'><img src='{$img}' style='width: 220px;' /></a><br/>
		<input type='button' style='float:none!important;' class='delete btn_normal' id='{$item->id}' rel='{$item->card}' value='Remove' />
		</td>
		<td  align='center' valign='top'>{$item->card_title}<br/>{$item->paper_name}</td>
		<td rowspan='5' valign='top' >
			<div style='width:340px;height:auto; margin:auto;'>
				$options
			</div>
		</td>
		<td rowspan='5'  align='center' valign='top'>&#36;{$total_price}</td>
	</tr>
	<tr class='{$item->id}'>
		<th  align='center' valign='top'>Basic Total</th>
	</tr>
	<tr class='{$item->id}'>
		<td  align='center' valign='top'>&#36;{$price}</td>
	</tr>
	<tr class='{$item->id}'>
		<th  align='center' valign='top'>Quantity</th>
	</tr>
	<tr class='{$item->id}'>
		<td  align='center' valign='top'>{$quantity}</td>
	</tr>
	";
	
	$product = Array();
	$product['productid'] = $item->id_card;
	$product['price'] = (float)$tax_price;
	$product['qty'] = 1;
	$product['tic'] = "00000";
	$products[] = $product;
	
}
?>
<?php if ( $no_checkout ) : // matching items  ?>
<tr>
	<td colspan="4">
		<?php
		$res = getMatchingCards(  implode(",", $matching_ids )  );
		if (mysql_num_rows( $res ) ) :
			echo "<br /><span style='font-weight: normal!important; font-family: \"Century Gothic\"!important; color: #29748C!important; font-size: 22px!important;'>Matching Items: Select an item to begin customizing</span><br/>
			<br />";
			$counter = 0;
			while( $matching_card = mysql_fetch_array( $res ) ) { //echo '<pre>'; print_r($matching_card); echo'</pre>';
				$url = get_card_url($matching_card['cat_id'], $matching_card['card_id']);
				$img_path = !empty($matching_card['card_thumbnail_path']) ? $matching_card['card_thumbnail_path'] : $matching_card['card_sample_path'];
				$counter++;
				$img = SAMPLE_CARDS . $img_path;
				list($card_width, $card_height) = getimagesize($img);
				$cur_width = $card_width <= 200 ? 200 : 280;
			?>
			<!--matching_post-->
			<div class="matching_item_post" style="width:auto">
				<div class="matching_item_img" style="width:auto">
					<a href="<?php echo $url; ?>"><img src="<?php echo SAMPLE_CARDS . $img_path; ?>" border="0" style="width: <?php //echo $cur_width; ?>px;" /></a>
				</div>
				<div class="matching_item_name">
							<?php echo $matching_card['card_title']; ?>
							<div align="center" style="font-weight:normal"> <?php echo $matching_card['cat_title']; ?></div>
							<div align="center" style="font-weight:normal">
											<?php
																$lowestUnit_price = getCard_unitLowestPrice($matching_card['card_id'], $objDb);
																if ($lowestUnit_price)
																echo 'As low as $' . number_format($lowestUnit_price,2);
																?></div>
				</div>
				<div class="matching_item_btn">
					<a href="<?php echo $url; ?>"><img src="images/pick_quantity_btn.png" border="0" /></a>
				</div>
			</div><!--matching_post-->
			
			
			<?php
			if ( $counter % 3 == 0 ) { echo '<div style="clear:both;"></div>';}
			} // while
		endif; 
		?>
	</td>
</tr>
<?php endif; ?>
<tr>
	<td colspan="4">
		<div class="shopping_totalwrapp">
			<div class="total_subtoal_wrapp">
				
				<?php
				if ( isset( $coupon_used ) && (boolean)$coupon_used ) {
					$grand_total_text = '<strike>&#36;' . number_format( $grand_total, 2 ) . '</strike>';
					$coupon_result_div = 'display:block;';
					echo "<input type='hidden' name='coupone_price' id='coupone_price' value='{$coupone_price}' />";
					echo "<input type='hidden' name='coupon_used' id='coupon_used' value='{$coupon_used}' />";
				} else {
					$grand_total_text = '&#36;' . number_format( $grand_total, 2 );
					$coupon_result_div = 'display:none;';
				}
				?>
				<!-- <img src="images/ups-logo.png" style="width: 40px; float: left;" /> -->
				<img src="images/ssl-verisign.jpg" style="width: 80px; float: left;margin-top:14px" />
				<!-- (c) 2005, 2012. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal" style="float:left;margin:0px 0px 10px 15px"> <script type="text/javascript" language="javascript">var ANS_customer_id="9bc1ea43-5d99-4676-9f7c-58d5d63999c4";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payments</a> </div> 
				<div style="clear:both"></div>
				
				<br/>
				Order Total <label id='grand_total'><?php echo $grand_total_text;?></label><br/>
				<div id="coupon_result" style='<?php echo $coupon_result_div; ?> '>
					Discounted Price <label id='coupon_price'>&#36;<?php echo isset( $coupone_price ) ? number_format($coupone_price, 2) : NULL; ?></label>
				</div>
				
				<?php if ( !$no_checkout && !isset( $coupon_used ) ) : ?>
				<input type="text" name="coupon_code" id="coupon_code" value="Enter Coupon Code" 
				onfocus="this.value == 'Enter Coupon Code' ? this.value = '' : this.value = this.value;"
				onblur="this.value == '' ? this.value = 'Enter Coupon Code' : this.value = this.value;" />
				<a id="btnCoupon" style="    clear: both;color: #2C5D98;cursor: pointer;float: left;margin-bottom: 12px;margin-left: 5px;" >Apply</a>
				<input type="hidden" name="coupon_used" id="coupon_used" value="<?php echo isset( $coupon_used ) ? $coupon_used : '0'; ?>" />
				<input type="hidden" name="coupone_price" id="coupone_price" value="<?php echo isset( $coupone_price ) ? $coupone_price : '0'; ?>" />
				
				
				<script type="text/javascript">
					jQuery(document).ready(function($){
						$("#btnCoupon").live ('click', function() {
							coupon_code = $("#coupon_code").val();
							if ( coupon_code == '' || coupon_code == 'Enter Coupon Code' ){
								alert("provided valid coupon code");
								return false; 
							}
							
							/* check the coupon code and its value */
							$.post(
								'<?php echo siteURL . 'process-ajax.php'; ?>',
								{
									call : 'validate_coupon_code',
									coupon_code : coupon_code,
									grand_total : '<?php echo $grand_total; ?>'
								},
								function( ret ){
									if ( isNaN( ret ) ) {
										//alert(ret);
										$("div#coupon_result").hide();
										$("#coupone_used").val('0');
										$("#coupone_price").val('0');
										$("#grand_total").html('&#36;<?php echo number_format( $grand_total, 2 );?>');
									} else {
										$("div#coupon_result").show();
										$("#coupon_price").html("&#36;" + ret );						// we here are setting discounted price other words discounted grandTotal (received in 'ret') ; just element ID is not correct that creating confusion:)
										$("#grand_total").html('<strike>&#36;<?php echo number_format( $grand_total, 2 );?></strike>');
										$("#coupon_used").val(coupon_code);
										$("#coupone_price").val(ret);
									}
								}
							);
						});
					});
				</script>
				<?php endif; ?>
			<?php if ( $no_checkout ) : ?>
				<div class="total_subtoal_wrapp_cartbtn">
			<?php
				if ( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != 'NULL' )  {
					$url = "payment-process.php";
				} else {
					$url = "index.php?p=login";
				}
				?>
				<a href="<?php echo $url; ?>"><img src="images/proceedchecout_btn.png" /></a>
				</div>
			<?php elseif ( $display_bill_ship ): ?>
				<table style="float:left; width: 100%;">
					<tr>
						<td>
							Shipping Method for items being delivered to you:<br/> 
							<?php
							get_shipping_by_price($grand_total, isset($shipping_price) ? $shipping_price : NULL);
							?>
						</td>
					</tr>
				</table>
			<?php endif; 
			
			if(isset($shipping_price))
							$shipping_charges = explode("|", $shipping_price);
			?>
			<?php if ( $calculate_tax ) :
			include 'tax-cloud/func.taxcloud.php';	
			$destination = new Address();
			$destination->setAddress1($ship['address']);
			$destination->setAddress2("");
			$destination->setCity($ship['city']);
			$destination->setState($ship['state']); // Two character state abbreviation
			$destination->setZip5($ship['zip']);
			$destination->setZip4('');
			$err = Array();
			$verifiedAddress = func_taxcloud_verify_address($destination, $err);
			
			if ( count($err) ) {
				#print_r($err);
							//$grand_total = (float)$grand_total + (float)$shipping_charges[1];		//// SHIPMENT CHARGES ARE ALREADY BEING ADDED ON CHECKOUT WHILE MAKING PAYMENT SO WE DONT' NEED TO HERE
							if(isset($coupone_price) && $coupone_price > 0)
								 echo 'Grand Total: <label>&#36;'. number_format(($coupone_price+$shipping_charges[1]), 2).'</label>';
							else
								 echo 'Grand Total: <label>&#36;'. number_format(($grand_total+$shipping_charges[1]), 2).'</label>';
								echo '<div style="margin:8px 0px;border:1px dashed red;color:red;padding:4px;font-size:9px;background-color:#FDF4DE">Warning: OOops. looks invalid billing/shipping information  (especially the mailing address).<br>Ignore this if you are sure with your information  </div>';
			} else {
				
				$shipping_charges = explode("|", $shipping_price);
				$origin = new Address();
				$origin->setAddress1(TAX_CLOUD_ADDRESS_ONE);
				$origin->setAddress2(TAX_CLOUD_ADDRESS_TWO);
				$origin->setCity(TAX_CLOUD_CITY);
				$origin->setState(TAX_CLOUD_STATE);
				$origin->setZip5(TAX_CLOUD_ZIP5);
				$origin->setZip4(TAX_CLOUD_ZIP4);
				$shipping = isset($shipping_charges[1]) && $shipping_charges[1] > 0 ? $shipping_charges[1] : 5; // minimum '5' shipping charges should be set (required by TaxCloud API)
				$errMsg = Array();
				//print_r($products);
				$taxes = func_taxcloud_lookup_tax($_SESSION['user_id'], $products, $origin, $verifiedAddress, $shipping, $errMsg);
				
				if ( count($errMsg) ) {
					//print_r($errMsg);
				} 
				else if ( (float)$taxes > 0 ) 
								{
								
											$grand_total = (float)$grand_total + (float)$taxes; // + (float)$shipping;				// including shipping charges also in grand total
												if(isset($coupone_price) && $coupone_price > 0)	// if coupon Discount used to apply
												{
																// Tax has been computed on original order amount - so FIRST we need to find discount %age applied and then apply that %age discount on TAX also
																$percentage_ofCouponDiscountWas = round(($coupone_price*100)/($grand_total-$taxes));			// rounding coupon discount %age to i.e. 30, 44%... also deduct TAX from PRICE that is already included

																// Apply this discount %age to the Tax also now
																$taxDiscount = ($taxes*$percentage_ofCouponDiscountWas)/100;
																$discountedTaxAmount = $taxes - $taxDiscount;
																$taxes = $discountedTaxAmount;						// REPLACE orignal amount calculated TAX by coupon applied discounted tax (need by client)
																								
																echo 'Tax Amount: <label>&#36;'.number_format($taxes, 2).'</label><br/><br/>
																				Grand Total: <label>&#36;'. number_format(($coupone_price+$shipping+$taxes), 2).'</label> ';
												}
												else{
																echo 'Tax Amount: <label>&#36;'.number_format($taxes, 2).'</label><br/><br/>
																				Grand Total: <label>&#36;'. number_format(($grand_total+$shipping), 2).'</label> ';
												}
					?>
					
					<?php
				}
				 else {				// else if Taxe value is '0'
								//$grand_total = (float)$grand_total + (float)$shipping;	 //// SHIPMENT CHARGES ARE ALREADY BEING ADDED ON CHECKOUT WHILE MAKING PAYMENT SO WE DONT' NEED TO HERE
									if(isset($coupone_price) && $coupone_price > 0)
												echo 'Grand Total: <label>&#36;'. number_format(($coupone_price+$shipping), 2).'</label>';
									else
												echo 'Grand Total: <label>&#36;'. number_format(($grand_total+$shipping), 2).'</label>';
								}
								
			}
			
			endif; 
			
			
					
					
			?>
			</div>
		</div>
	</td>
</tr>
</tbody>
</table>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".delete").live ('click', function() {
			if ( !confirm("Are you sure to remove this item? ") ){
				return false;
			}
			$rows = $(this).parent().parent().parent().find('tr.'+$(this).prop('id'));
			$.post(
				'process-ajax.php',
				{
					call : 'delete_cart_item',
					id : $(this).prop('id'),
					card_image :  $(this).prop('rel')
				},
				function(ret){
					$rows.each(function() {
						$(this).fadeOut('slow');
					});
					self.location.href = "<?php echo siteURL . 'cart.php';?>";
				}
			);
		});
	});
</script>
<?php $display_bill_ship = TRUE; ?>