<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION[$cat_id]['step4'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION[$cat_id]['step3'] = $_REQUEST;
}

if ( !isset($_SESSION[$cat_id]['step4'] ) ) {
	$_SESSION[$cat_id]['step4'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION[$cat_id]['step4'], $_SESSION[$cat_id]['step3'], $_REQUEST );

$card_bg_name = $row['card_bg_path'];
if ( $card_bg_name ) {
	$img = BLANK_CARDS . "$card_bg_name";
	list($card_width, $card_height, $type, $attr) = getimagesize($img);
	
	$PanWidth = "width:{$card_width}px;";
	$PanHeight = "height:{$card_height}px;";
	
}
/* set variables here */
//var_dump($_REQUEST);
extract($_REQUEST);
$card_settings = unserialize( $row['card_settings'] );	
$price = explode( "||", $qty_price );
$_envelop = explode('|', $envelop);

/* generate create card url params */
$card_url = generate_card_url();

/* set left right widths */
if ( $card_width > 453 ) { // imaeg is wider then the left width 
	$left_width = $card_width."px";
	$right_width = (931 - $card_width)."px"; 
} else {
	$left_width = "453px";
	$right_width = "478px";
}
?>
<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img src="<?php echo siteURL;?>images/mailing_1.png" />
	</div>
	<!--detail_page_heading-->
	<div class="detail_page_heading">
		<?php echo $row['cat_title'] . ' : ' . $row['card_title']; ?>
	</div><!--detail_page_heading-->
	<!--detail_left-->
	<div class="detailpage_left" style="width: <?php echo $left_width; ?>">
		<div class="detail_left_smallgeading">
			<?php echo $row['card_code'] . ' - ' . $row['card_title']; ?>
		</div>
		<!--detail_big_img-->
		
		
		<div class="detail_left_smallgeading" style="clear:both;">Invitation</div>
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo siteURL . "create_card.php?$card_url"; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		</div> <!-- page_workArea -->
		<!--color_swatch-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right" style="width: <?php echo $right_width; ?>">
		
	<form name="frm_step4" id="frm_step4" method="post">
		<?php
		foreach($_REQUEST as $key => $val ) {
			if ( $key == 'guest_ids' || $key == 'total_guest_ids' ) {continue;}
			if ( $key == 'step') {
				echo "<input type='hidden' id='step' name='step' value='step5' />\n";
			} else {
				if ( is_array( $val ) ) {
					foreach ($val as $k => $v) {
						$v = stripslashes($v);
						echo "<input type='hidden' name='{$key}[]' value=\"{$v}\" />\n";
					}
				} else {
					echo "<input type='hidden' id='{$key}' name='{$key}' value='{$val}' />\n";
				}
			}
		}
		?>
		<input type="hidden" name="guest_ids" value="<?php echo $guest_ids;?>" id="guest_ids" />
		<input type="hidden" name="total_guest_ids" value="<?php echo $total_guest_ids;?>" id="total_guest_ids" />
		<div class="detail_page_innerheading">
			Response Card Envelope Options
		</div>
		<div class="detrail_page_desc">
			<p>
			Response card envelopes are not printed with the guests’ addresses. Because these cards are mailed back to the bride after the guests RSVP, the address where the bride wants all of the response cards delivered should be placed on the envelopes.
			</p>
			<p> 
			Also, response card envelopes are typically pre-stamped so the guest does not have to pay postage to mail back the response card. At your request, Send With Style can do all this work for you.<br/><br/>
			</p>
			<p>

				<input type="radio" class="rbo_mail_options" name="mail_option" value="send_me" id="send" <?php echo isset( $mail_option ) && $mail_option == 'send_me' ? 'checked="checked"' : !isset( $mail_option ) ? 'checked="checked"' : NULL;?> />
				<label for="send">Leave envelopes blank (I’ll write out the return addresses later)</label>
				<br/>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="address_for_me" id="addrees" <?php echo isset( $mail_option ) && $mail_option == 'address_for_me' ? 'checked="checked"' : NULL;?> />
				<label for="addrees2">Address the envelopes for me (Response card envelopes are printed with the address specified, which is the same as the return address) ($<?php echo RESPONSE_ADDRESS_ENVELOPE_COST;?>/card)</label>
				<br/>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="address_and_stamp_for_me" id="mail"  <?php echo isset( $mail_option ) && $mail_option == 'address_and_stamp_for_me' ? 'checked="checked"' : NULL;?> />
				<label for="mail">Address and stamp the envelopes for me (This option recommended if wedding invitations are being mailed out directly to your guests).($<?php echo ADDRESS_STAMP_COST; ?>/card includes postage)</label> 
				
			</p>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$("div.dv_address").hide();
					$("div.dv_mail").hide();

					$(".rbo_mail_options").live ('change', function() {
						var _id = $(this).attr('id');
						$("div.dv_address").hide();
						$("div.dv_mail").hide(); 
						if ( _id == 'send' ) {
							
							$("#guest_ids").val('');
							$("#total_guest_ids").val('');
							$("#total_guests_selected").hide();
						} else if ( _id == 'addrees' ) {
							$("div.dv_address").show();
							$("#guest_ids").val(<?php echo isset($guest_ids) ? $guest_ids : 0;?>);
							$("#total_guest_ids").val(<?php echo isset($total_guest_ids) ? $total_guest_ids : 0;?>);
							$("#total_guests_selected").show();
						} else if ( _id == 'mail' ) {
							$("div.dv_mail").show();
							$("#guest_ids").val(<?php echo isset($guest_ids) ? $guest_ids : 0;?>);
							$("#total_guest_ids").val(<?php echo isset($total_guest_ids) ? $total_guest_ids : 0;?>);
							$("#total_guests_selected").show();
						}
					});
					
					$(".rbo_mail_options").each( function() {
						var _id = $(this).attr('id');
						var _checked = $(this).is(':checked'); 
						if ( _id == 'send' && _checked ) {
							$("div.dv_address").hide();
							$("div.dv_mail").hide();
							$("#guest_ids").val('');
							$("#total_guests_selected").hide();
							$("#total_guest_ids").val('');
						} else if ( _id == 'addrees' && _checked ) {
							$("div.dv_address").show();
							$("div.dv_mail").hide();
							$("#guest_ids").val(<?php echo isset($guest_ids) ? $guest_ids : 0;?>);
							$("#total_guest_ids").val(<?php echo isset($total_guest_ids) ? $total_guest_ids : 0;?>);
							$("#total_guests_selected").show();
						} else if ( _id == 'mail' && _checked ) {
							$("div.dv_address").hide();
							$("div.dv_mail").show();
							$("#guest_ids").val(<?php echo isset($guest_ids) ? $guest_ids : 0;?>);
							$("#total_guest_ids").val(<?php echo isset($total_guest_ids) ? $total_guest_ids : 0;?>);
							$("#total_guests_selected").show();
						}
					});
					
				/*	
					$(".personalized_btn").live ('click', function() {
						var guests_selected = false;
						$(".rbo_mail_options").each( function() {
							var _id = $(this).attr('id');
							var _checked = $(this).is(':checked'); 
							if ( _id == 'send' && _checked ) {
								guests_selected = true;
							} else if ( _id == 'addrees' && _checked ) {					// if customer choosed to PRINT-return-address only (then make sure the return address is entered
								guests_selected = true;	
							} else if ( _id == 'mail' && _checked ) {				    // if customer choosed to PRINT-return-address+pastPostageStemp (then make sure the return address is entered
								if ( $("#total_guest_ids").val() > 0 ) {
									guests_selected = true;	
								}
							}
						});
						if ( guests_selected ) {
							return true;
						} else {
							alert("<?php echo ADD_ADDRESSES_ALERT; ?>");
							return false;
						}
					});
					*/
				
					$(".personalized_btn").live ('click', function() {
							var returningFlag = true;
						 var envelopOptionSelected = false;
						 $(".rbo_mail_options").each( function() {
												var _id = $(this).attr('id');
												var _checked = $(this).is(':checked'); 
												
												if(_checked)
																envelopOptionSelected = true;			// marking & saving that one of envelop option selected
												
												if ( _id == 'addrees' && _checked ) {					// if customer choosed to PRINT-return-address only (then make sure the return address is entered
																if($('#isReturnAddressSet').val()!='1')
																				{
																								alert('Please provide your "return" address for printing on envelops'); 
																								returningFlag = false;
																				}
																				
												} else if ( _id == 'mail' && _checked ) {				    // if customer choosed to PRINT-return-address+pastPostageStemp (then make sure the return address is entered
																if($('#isReturnAddressSet').val()!='1')
																				{
																								alert('Please provide your "return" address for printing on envelops');
																								returningFlag = false;
																				}
												}
												
												
						 });
						
						 // finally check if NON of envelopOption selected then show alert
					 	if(envelopOptionSelected==false)
										{
														alert('Please select envelop printing option');
														returningFlag = false;
										}
								//alert(returningFlag); 
								return returningFlag;
				});
					
					
					$(".personalized_btn_back").live ('click', function() {
						$("#previous").val('1');
						$("#step").val('step3');
					});
					
				});
				
				/* called from thickbox address-box */
				function set_guests( val, count ) {
					jQuery("#guest_ids").val(val);
					jQuery("#total_guest_ids").val(count);
					jQuery("#total_guests_selected").html(count +" guest(s) selected");
					
				}
				
				/* called from thickbox address-box */
				function get_guests() {
					return jQuery("#guest_ids").val();
				}
				
				/* called from thickbox address-box */
				function set_returnAddressFlag(){ 
								$('#isReturnAddressSet').val('1'); 
				}
				
				
				
			</script>
		</div>
		<div class="detrail_page_desc dv_address">
			<br/><br/><strong>$ <?php echo RESPONSE_ADDRESS_ENVELOPE_COST;?> per envelope</strong><br/>
			<!-- <input type="radio" name="mail_option_addresses" value="both" id="add_both" < ?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'both' ? 'checked="checked"' : !isset( $mail_option_addresses ) ? 'checked="checked"' : NULL;?> />
			<label for="add_both">Address where Response Cards will be received</label>
			 <br/>-->
			<input type="radio" name="mail_option_addresses" value="return_response" id="add_return" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'return_response' ? 'checked="checked"' : !isset( $mail_option_addresses ) ? 'checked="checked"' : NULL;?>  />
			<label for="add_return">Return Address Only</label>
			<!-- <br/>
			<input type="radio" name="mail_option_addresses" value="recipient" id="add_recipient" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'recipient' ? 'checked="checked"' : NULL;?> />
			<label for="add_recipient">Recipients Address only</label>
			<br/><br/> -->
			<br/>
			Please add your return address before continuing<br/>
			<a href="address-book.php?item_id=<?php echo $item_id;?>&qty=<?php echo $price[1]; ?>&KeepThis=true&showReturnAddressOnly=true&TB_iframe=true&height=500&width=700" class="thickbox" title="Select Guests">Add Return Address now</a>
			<br/>All purchased response cards will have the envelopes addressed
		</div>
		<div class="detrail_page_desc dv_mail">
			<br/><br/><strong>$ <?php echo ADDRESS_STAMP_COST; //MAIL_ENVELOPE_COST;?> per envelope</strong><br/>
			<small>Includes the cost of Postage</small><br/>
			Please add your return address before continuing<br/>
			<a href="address-book.php?item_id=<?php echo $item_id;?>&qty=<?php echo $price[1]; ?>&KeepThis=true&showReturnAddressOnly=true&TB_iframe=true&height=500&width=700" class="thickbox" title="Select Guests">Add Return Address now</a>
			<br/>All purchased response cards will have the envelopes addressed
		</div>
		
		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Continue"/>
			<input name="" type="submit"  class="personalized_btn_back" value="Previous"/>
			<div class="personalized_txt">
				<?php 
				echo "Your Price : <b>$ {$price[2]}</b><br/>";
				echo "Quantity: <b>{$price[1]}</b><br/>";
				echo $total_guest_ids ? "<span id='total_guests_selected'>{$total_guest_ids} guest(s) selected</span>" : '<span id="total_guests_selected"></span>';
				?>
							<input type="hidden" name="isReturnAddressSet" id="isReturnAddressSet" value="0">
			</div>
		</div>
	</form>
	</div><!--detail_right-->

</div><!--body_internal_wrapp-->
