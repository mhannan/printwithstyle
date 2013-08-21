<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['wed']['step5'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['wed']['step4'] = $_REQUEST;
}

if ( !isset($_SESSION['wed']['step5'] ) ) {
	$_SESSION['wed']['step5'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['wed']['step5'], $_SESSION['wed']['step4'], $_REQUEST );

$card_bg_name = $row['card_bg_path'];
if ( $card_bg_name ) {
	$img = BLANK_CARDS . "$card_bg_name";
	list($card_width, $card_height, $type, $attr) = getimagesize($img);
	$PanWidth = "width:{$card_width}px;";
	$PanHeight = "height:{$card_height}px;";
}

/* set left right widths */
if ( $card_width > 453 ) { // imaeg is wider then the left width 
	$left_width = $card_width."px";
	$right_width = (931 - $card_width)."px"; 
} else {
	$left_width = "453px";
	$right_width = "478px";
}

/* set variables here */
//var_dump($_REQUEST);
extract($_REQUEST);
$card_settings = unserialize( $row['card_settings'] );	
$price = explode( "||", $qty_price );
$_envelop = explode('|', $envelop);

/* generate create card url params */
$card_url = generate_web_card_url();
		
?>
<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img src="<?php echo siteURL;?>images/mailing.png" />
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
		<?php
		
		?>
		
		<div class="detail_left_smallgeading" style="clear:both;">Invitation</div>
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo siteURL . "create_wed_card.php?$card_url"; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		</div> <!-- page_workArea -->
		<!--color_swatch-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right" style="width: <?php echo $right_width; ?>">
		
	<form name="frm_step5" id="frm_step5" method="post">
		<input type="hidden" name="item_id"value="<?php echo $item_id;?>" />
		<input type="hidden" id="step" name="step" value="step6" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $paper_type;?>" />
		<input type="hidden" name="qty_price"value="<?php echo $qty_price;?>" />
		<input type="hidden" name="hosting_type" value="<?php echo $hosting_type; ?>" />
		<input type="hidden" name="<?php echo $_REQUEST['hosting_type']; ?>" value="<?php echo $_REQUEST[$_REQUEST['hosting_type']]; ?>" />
		<input type="hidden" name="total_price" id="hd_total_price" value="<?php echo $total_price;?>" />
		<input type="hidden" name="total_envelope" id="hd_total_envelope" value="<?php echo $total_envelope; ?>" />
		<input type="hidden" name="total_x_envelope" id="hd_total_x_envelope" value="<?php echo $total_x_envelope; ?>" />
		<input type="hidden" name="envelop" value="<?php echo $envelop; ?>" />
		<input type="hidden" name="x_envelop" value="<?php echo $x_envelop; ?>" />
		<input type="hidden" name="guest_ids" value="<?php echo $guest_ids;?>" id="guest_ids" />
		<input type="hidden" name="total_guest_ids" value="<?php echo $total_guest_ids;?>" id="total_guest_ids" />
		
		
		<input type="hidden" name="special_instructions" value="<?php echo $special_instructions; ?>" />
		
		
		<input type='hidden' name='texts[]' value="<?php echo stripslashes($texts[0]);?>" />
		<input type='hidden' name='texts[]' value="<?php echo stripslashes($texts[1]);?>" />
		<input type='hidden' name='texts[]' value="<?php echo stripslashes($texts[2]);?>" />
		
		<input type='hidden' name='main[font]' value='<?php echo $main['font'];?>' />
		<input type='hidden' name='main[size]' value='<?php echo $main['size'];?>' />
		<input type='hidden' name='main[color]' value='<?php echo $main['color'];?>' />
		<input type='hidden' name='main[align]' value='<?php echo $main['align'];?>' />
		
		<input type='hidden' name='couples[font]' value='<?php echo $couples['font'];?>' />
		<input type='hidden' name='couples[size]' value='<?php echo $couples['size'];?>' />
		<input type='hidden' name='couples[color]' value='<?php echo $couples['color'];?>' />
		<input type='hidden' name='couples[align]' value='<?php echo $couples['align'];?>' />
		
		<input type='hidden' name="w" value="<?php echo $w; ?>" />
		<input type='hidden' name="h" value="<?php echo $h; ?>" />
		
		<div class="detail_page_innerheading">
			Mailing Options
		</div>
		<div class="detrail_page_desc">
			<p>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="send_me" id="send" <?php echo isset( $mail_option ) && $mail_option == 'send_me' ? 'checked="checked"' : !isset( $mail_option ) ? 'checked="checked"' : NULL;?> />
				<label for="send">Send my cards to me (Blank envelopes included.)</label>
				<br/>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="address_for_me" id="addrees" <?php echo isset( $mail_option ) && $mail_option == 'address_for_me' ? 'checked="checked"' : NULL;?> />
				<label for="addrees">Address the envelopes for me (I'll assemble and mail out my cards.)</label>
				<br/>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="mail_for_me" id="mail"  <?php echo isset( $mail_option ) && $mail_option == 'mail_for_me' ? 'checked="checked"' : NULL;?> />
				<label for="mail">Mail out my cards for me (Address, Stamp and send to my recipients.)</label> 
				
			</p>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$("div.dv_address").hide();
					$("div.dv_mail").hide();

					$(".rbo_mail_options").live ('change', function() {
						var _id = $(this).attr('id'); 
						if ( _id == 'send' ) {
							$("div.dv_address").hide();
							$("div.dv_mail").hide();
							$("#guest_ids").val('');
							$("#total_guest_ids").val('');
							$("#total_guests_selected").hide();
						} else if ( _id == 'addrees' ) {
							$("div.dv_address").show();
							$("div.dv_mail").hide();
							$("#guest_ids").val(<?php echo isset($guest_ids) ? $guest_ids : 0;?>);
							$("#total_guest_ids").val(<?php echo isset($total_guest_ids) ? $total_guest_ids : 0;?>);
							$("#total_guests_selected").show();
						} else if ( _id == 'mail' ) {
							$("div.dv_address").hide();
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
					
					
					$(".personalized_btn").live ('click', function() {
						var guests_selected = false;
						$(".rbo_mail_options").each( function() {
							var _id = $(this).attr('id');
							var _checked = $(this).is(':checked'); 
							if ( _id == 'send' && _checked ) {
								guests_selected = true;
							} else if ( _id == 'addrees' && _checked ) {
								if ( $("#add_return").is(":checked")  ) {
									guests_selected = true;	
								} else  if ( $("#total_guest_ids").val() > 0 ) {
									guests_selected = true;
								}
							} else if ( _id == 'mail' && _checked ) {
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
					
					$(".personalized_btn_back").live ('click', function() {
						$("#previous").val('1');
						$("#step").val('step3');
					});
					
					 checkIf_returnAddressOnly_selected();
					
					 $('input[type=radio]').click(function(e){
									checkIf_returnAddressOnly_selected();
									//e.preventDefault();
				 	});
					
				});
				// called in order to HID 'add addresses now' block
				function checkIf_returnAddressOnly_selected()
				{
								if($('#addrees').is(':checked') )							// 'address envelopes for me' if checked 
								{
												var address_printingType = $('#add_return:checked').val();
												//alert(address_printingType);
												if(address_printingType=="return")
												{
																$('span#selectAddresses, #total_guests_selected').hide();
																$('span#selectReturnAddresses').show();
												}
												else
													{
																$('span#selectAddresses, #total_guests_selected').show();
																$('span#selectReturnAddresses').hide();
													}
								}
				}
				
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
				
				
			</script>
		</div>
		
		<div class="detrail_page_desc dv_address">
			<br/><br/><strong>$ <?php echo ADDRESS_ENVELOPE_COST;?> per envelope</strong><br/>
			<input type="radio" name="mail_option_addresses" value="both" id="add_both" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'both' ? 'checked="checked"' : !isset( $mail_option_addresses ) ? 'checked="checked"' : NULL;?> />
			<label for="add_both">Recipient Address and Return Address</label>
			<br/>
			<input type="radio" name="mail_option_addresses" value="return" id="add_return" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'return' ? 'checked="checked"' : NULL;?>  />
			<label for="add_return">Return Address Only</label>
			<br/>
			<input type="radio" name="mail_option_addresses" value="recipient" id="add_recipient" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'recipient' ? 'checked="checked"' : NULL;?> />
			<label for="add_recipient">Recipients Address only</label>
			<br/><br/>
			<span id="selectAddresses">
								Please add your addresses before continuing<br/>
								<a href="address-book.php?item_id=<?php echo $item_id;?>&qty=<?php echo $price[1]; ?>&KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox" title="Select Guests">Add Addresses now</a>
			</span>					
			<span id="selectReturnAddresses" style="display:none">
							Please add return addresses before continuing<br/>
							<a href="address-book.php?item_id=<?php echo $item_id;?>&qty=<?php echo $price[1]; ?>&KeepThis=true&showReturnAddressOnly=true&TB_iframe=true&height=500&width=700" class="thickbox" title="Address Book">Add Return Addresses now</a>
			</span>
		</div>
		<div class="detrail_page_desc dv_mail">
			<br/><br/><strong>$ <?php echo MAIL_ENVELOPE_COST;?> per envelope</strong><br/>
			<small>Includes the cost of Postage</small><br/>
			Please add your addresses before continuing<br/>
			<a href="address-book.php?item_id=<?php echo $item_id;?>&qty=<?php echo $price[1]; ?>&KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox" title="Select Guests">Add Addresses now</a>
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
			</div>
		</div>
	</form>
	</div><!--detail_right-->

</div><!--body_internal_wrapp-->
