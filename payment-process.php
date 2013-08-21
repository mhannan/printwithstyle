<?php
include 'config/config.php';
include 'header.php';
?>
<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
<div class="body_internal_wrapper">
	
	<div class="body_left" style="float: left; width: 100%;">
		<div class="addons_cart_table">
			<form action="payment-review.php" method="post" name="frm_payment" id="frm_payment">
			<ul class="acc" id="acc">
				<li>
					<h3>Order Summary</h3>
					<div class="acc-content">
					<?php
					$cart = get_cart();
					if ( $cart ) {
						$no_checkout = FALSE;
						include 'cart-listing.php';
					} else {
						/* redirect user to home page if cart is empty */
						?>
						<meta http-equiv='Refresh' content='0; URL=<?php echo siteURL;?>' />
						<?php
						exit;
					}
					?>
					</div>
				</li>
				<?php if ( $display_bill_ship ) : ?>
				<li>
					<h3>Billing / Shipping Information</h3>
					<div class="acc-content">
						<div id="billing" class="bill_ship">
							<h4>Billing Information:</h4>
							<p>
								<label for="bill_name">Name:</label>
								<input type="text" name="bill[name]" id="bill_name" />
							</p>
							<p>
								<label for="bill_address">Address:</label>
								<input type="text" name="bill[address]" id="bill_address" />
							</p>
							<p>
								<label for="bill_city">City:</label>
								<input type="text" name="bill[city]" id="bill_city" />
							</p>
							<p>
								<label for="bill_state">State:</label>
								<input type="text" name="bill[state]" id="bill_state" />
							</p>
							<p>
								<label for="bill_zip">Zip:</label>
								<input type="text" name="bill[zip]" id="bill_zip" />
							</p>
							<p>
								<label for="bill_country">Country:</label>
								<input type="text" name="bill[country]" id="bill_country" />
							</p>
							<p>
								<label for="bill_phone">Phone:</label>
								<input type="text" name="bill[phone]" id="bill_phone" />
							</p>
						</div>
						<div id="shipping" class="bill_ship">
							<h4 style="width: 200px; ">Shipping Information:</h4>
							
							<input type="checkbox" style="float: left; width: auto; margin: 5px;" value="1" id="chk_bill_ship" name="chk_bill_ship" />
							<label for="chk_bill_ship" style="float: left; width: auto; margin: 5px; clear: none;">Same as Billing</label> 
							<p>
								<label for="ship_name">Name:</label>
								<input type="text" name="ship[name]" id="ship_name" />
							</p>
							<p>
								<label for="ship_address">Address:</label>
								<input type="text" name="ship[address]" id="ship_address" />
							</p>
							<p>
								<label for="ship_city">City:</label>
								<input type="text" name="ship[city]" id="ship_city" />
							</p>
							<p>
								<label for="ship_state">State:</label>
								<input type="text" name="ship[state]" id="ship_state" />
							</p>
							<p>
								<label for="ship_zip">Zip:</label>
								<input type="text" name="ship[zip]" id="ship_zip" />
							</p>
							<p>
								<label for="ship_country">Country:</label>
								<input type="text" name="ship[country]" id="ship_country" />
							</p>
							<p>
								<label for="ship_phone">Phone:</label>
								<input type="text" name="ship[phone]" id="ship_phone" />
							</p>
						</div>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function($){
							$("#chk_bill_ship").live ('change', function() {
								if ( $(this).is(":checked") ) {
									$("#ship_name").val( $("#bill_name").val().trim() );
									$("#ship_address").val( $("#bill_address").val().trim() );
									$("#ship_city").val( $("#bill_city").val().trim() );
									$("#ship_state").val( $("#bill_state").val().trim() );
									$("#ship_zip").val( $("#bill_zip").val().trim() );
									$("#ship_country").val( $("#bill_country").val().trim() );
									$("#ship_phone").val( $("#bill_phone").val().trim() );
								} else {
									$("#ship_name").val('');
									$("#ship_address").val('');
									$("#ship_city").val('');
									$("#ship_state").val('');
									$("#ship_zip").val('');
									$("#ship_country").val('');
									$("#ship_phone").val('');
								}
							})
						});
					</script>
				</li>
				<?php endif; ?>
				<li>
					<h3>Payment Information</h3>
					<div class="acc-content">
							
							<p>
								<label for="_name">Name on Card:</label>
								<input type="text" name="_name" id="_name" />
							</p>
							<p>
								<label for="_cc">Credit Card Number:</label>
								<input type="text" name="_cc" id="_cc" />
							</p>
							<p>
								<label for="_m">Expiration Month:</label>
								<select name="_m" id="_m">
									<?php
									for($y = 1; $y <= 12; $y++) {
										$y = strlen($y) == 1 ? "0{$y}" : $y;
										echo "<option value='$y'>$y</option>";
									}
									?>
								</select>
							</p>
							<p>
								<label for="_y">Expiration Year:</label>
								<select name="_y" id="_y">
									<?php
									$cur_year = date('Y');
									$to_year = $cur_year + 5;
									for($y = $cur_year; $y <= $to_year; $y++) {
										echo "<option value='$y'>$y</option>";
									}
									?>
								</select>
							</p>
							<p class="error" style="float: left; clear: both;"></p>
							<p>
								<input type="hidden" name="price" value="<?php echo $grand_total; ?>" />
								<input type="submit" id="btnProcess" name="btnProcess" class="btn_normal" value="Review Order" style="font-size: 10px!important;" />
							</p>
							
							<script type="text/javascript">
								jQuery(document).ready(function($) {
									$("h3").live ('click', function() {
										$(this).next().slideToggle();
									});
			
									$("#btnProcess").click( function() {
										$(".error").css({'color' : '#CD0A0A'})
										$("p.error").html(' ');
										if ( $("#_name").val().trim() == '' ) {
											$("p.error").html('Provide name please.');
											$("#_name").focus();
											return false;
										} else if ( $("#_cc").val().trim() == '' ) {
											$("p.error").html('Provide credit card number please.');
											$("#_cc").focus();
											return false;
										}
									});
								});
							</script>
					</div>
				</li>
			</ul>
			</form>
		</div>
	</div>
</div>
<?php
include 'footer.php';
