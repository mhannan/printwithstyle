<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['step6'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['step5'] = $_REQUEST;
}

if ( !isset($_SESSION['step6'] ) ) {
	$_SESSION['step6'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['step6'], $_SESSION['step5'], $_REQUEST );
?>
<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img src="images/process_step_menu.png" />
	</div>
	<!--detail_page_heading-->
	<div class="detail_page_heading">
		<?php echo $row['cat_title'] . ' : ' . $row['card_title']; ?>
	</div><!--detail_page_heading-->
	<!--detail_left-->
	<div class="detailpage_left">
		<div class="detail_left_smallgeading">
			<?php echo $row['card_code'] . ' - ' . $row['card_title']; ?>
		</div>
		<!--detail_big_img-->
		<?php
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
		?>
		
		<div class="detail_left_smallgeading" style="clear:both;">Envelope</div>
		<div id="card_envelop"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo ENVELOPES . $_envelop[0] ; ?>'); background-repeat: no-repeat; width: 450px; height: 337px;">
		</div>
		<div class="detail_left_smallgeading" style="clear:both;">Invitation</div>
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo siteURL . 'create_card.php'; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		</div> <!-- page_workArea -->
		<!--color_swatch-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right">
		
	<form name="frm_step6" id="frm_step6" method="post">
		<input type="hidden" name="item_id"value="<?php echo $item_id;?>" />
		<input type="hidden" id="step" name="step" value="step7" />
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
		<input type="hidden" name="guest_ids" value="0" id="guest_ids" />
		
		<?php
		$total_boxes = count( $e_box );
		for( $l = 0; $l < $total_boxes; $l++ ) {
			echo "<input type='hidden' name='e_box[]' value='{$e_box[$l]}' />";
			echo "<input type='hidden' name='font_style[]' value='{$font_style[$l]}' />";
			echo "<input type='hidden' name='font_size[]' value='{$font_size[$l]}' />";
			echo "<input type='hidden' name='font_align[]' value='{$font_align[$l]}' />";
		}
		?>
		
		<div class="detail_page_innerheading">
			Mailing Options
		</div>
		<div class="detrail_page_desc">
			<p>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="send_me" id="send" <?php echo isset( $mail_option ) && $mail_option == 'send_me' ? 'checked="checked"' : !isset( $mail_option ) ? 'checked="checked"' : NULL;?> />
				<label for="send">Send My cards to me</label> <em>(Blank envelopes includes.)</em>
				<br/>
				
				<input type="radio" class="rbo_mail_options" name="mail_option" value="address_for_me" id="addrees" <?php echo isset( $mail_option ) && $mail_option == 'address_for_me' ? 'checked="checked"' : NULL;?> />
				<label for="addrees">Address my Envelopes for me</label> <em>(I'll sign and mail my cards.)</em>
				<br/>
				<input type="radio" class="rbo_mail_options" name="mail_option" value="mail_for_me" id="mail"  <?php echo isset( $mail_option ) && $mail_option == 'mail_for_me' ? 'checked="checked"' : NULL;?> />
				<label for="mail">Mail my cards for me</label> <em>(Address, Stamp and send to my recepients.)</em> 
				
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
						} else if ( _id == 'addrees' ) {
							$("div.dv_address").show();
							$("div.dv_mail").hide();
						} else if ( _id == 'mail' ) {
							$("div.dv_address").hide();
							$("div.dv_mail").show();
						}
					});
					
					$(".rbo_mail_options").each( function() {
						var _id = $(this).attr('id');
						var _checked = $(this).is(':checked'); 
						if ( _id == 'send' && _checked ) {
							$("div.dv_address").hide();
							$("div.dv_mail").hide();
						} else if ( _id == 'addrees' && _checked ) {
							$("div.dv_address").show();
							$("div.dv_mail").hide();
						} else if ( _id == 'mail' && _checked ) {
							$("div.dv_address").hide();
							$("div.dv_mail").show();
						}
					});
					
					
					$(".personalized_btn").live ('click', function() {
						//alert($("#guest_ids").val(val).trim()); return false;
					});
					
					$(".personalized_btn_back").live ('click', function() {
						$("#previous").val('1');
						$("#step").val('step5');
					});
					
				});
				
				/* called from thickbox address-box */
				function set_guests( val, count ) {
					$("#guest_ids").val(val);
					tb_remove();
				}
				
				/* called from thickbox address-box */
				function get_guests() {
					return $("#guest_ids").val().trim();
				}
				
				
			</script>
		</div>
		<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
		<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
		<div class="detrail_page_desc dv_address">
			<br/><br/><strong>$ 0.39 per envelope</strong><br/>
			<input type="radio" name="mail_option_addresses" value="both" id="add_both" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'both' ? 'checked="checked"' : !isset( $mail_option_addresses ) ? 'checked="checked"' : NULL;?> />
			<label for="add_both">Both Address</label>
			<br/>
			<input type="radio" name="mail_option_addresses" value="return" id="add_return" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'return' ? 'checked="checked"' : NULL;?>  />
			<label for="add_return">Return Address Only</label>
			<br/>
			<input type="radio" name="mail_option_addresses" value="recipient" id="add_recipient" <?php echo isset( $mail_option_addresses ) && $mail_option_addresses == 'recipient' ? 'checked="checked"' : NULL;?> />
			<label for="add_recipient">Recipients Address only</label>
			<br/><br/>
			
			Add Addresses <a href="<?php echo siteURL;?>address-book.php?KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox">now</a> or at checkout
		</div>
		<div class="detrail_page_desc dv_mail">
			<br/><br/><strong>$ 0.55 per envelope</strong><br/>
			<small>plus the cost of postages</small><br/>
			Add Addresses <a href="<?php echo siteURL;?>address-book.php?KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox">now</a> or at checkout
		</div>
		
		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Shipping Options"/>
			<input name="" type="submit"  class="personalized_btn_back" value="Previous"/>
			<div class="personalized_txt">
				<?php 
				echo "Your Price : $ {$price[2]}<br/>";
				echo "Quantity: {$price[1]}<br/>";
				$envelop_price = (float)$_envelop[1] * (float)$price[1];
				if ( $total_envelope ) {
					echo "Evenlope Price @ $ {$_envelop[1]} x {$price[1]} = $ " . (float)$_envelop[1] * (float)$price[1] . "<br/>";
				} else {
					echo "Envelope (included)<br/>";
				}
				
				if ( $total_x_envelope ) {
					$x_envelope_price = (float)0.15 * (float)$x_envelop;
					echo "Extra Envelops @ $ 0.15 x {$x_envelop} = $ " . (float)0.15 * (float)$x_envelop . "<br/>";
				} else {
					$x_envelope_price = 0;
				}
				
				$total_price = (float)$price[2] + (float)$envelop_price + (float)$x_envelope_price;
				?>
				Total Price: $ <?php echo $total_price; ?></span>
			</div>
		</div>
	</form>
	</div><!--detail_right-->

</div><!--body_internal_wrapp-->
