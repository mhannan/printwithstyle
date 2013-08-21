<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['step7'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['step6'] = $_REQUEST;
}

if ( !isset($_SESSION['step7'] ) ) {
	$_SESSION['step7'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['step7'], $_SESSION['step6'], $_REQUEST );
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
		<input type="hidden" name="guest_ids" value="<?php echo $guest_ids; ?>" id="guest_ids" />
		<input type="hidden" name="mail_option" value="<?php echo $mail_option; ?>"/>
		
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
			Shipping Options
		</div>
		<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
		<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
		<div class="detrail_page_desc">
			<p>
				<?php
				$mail_prices = 0;
				$total_guests = 0;
				switch ( $mail_option ) {
					case "send_me": {
						echo "
						You are having the invitations boxed and mailed to a single address.<br/>						
						Click HERE to change shipping option if you would like Send With Style to assemble, address, stamp, and mail out your invitations directly to your guests.
						";
						break;
					}
					case "address_for_me": {
						echo "
						You selected to print your guests’ Names and Addresses on Envelopes:<br/>
						(Show  a Button that says either “Add Addresses” or “Edit Addresses” (if addresses have already been entered)
						";
						if ( $guest_ids ) {
							echo '<a href="'. siteURL .'address-book.php?KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox">Edit Addresses</a>';
						} else {
							echo '<a href="'. siteURL .'address-book.php?KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox">Add Addresses</a>';
						}
						break;
					}
					case "mail_for_me": {
						echo "
						Your invitations will be mailed directly to your guests. Our staff will print the envelopes, assemble the invitations, seal, stamp, and mail out your invitations.<br/><br/>
						You selected to print your guests’ Names and Addresses on Envelopes:<br/>
						";
						
						if ( $guest_ids ) {
							echo '<a href="'. siteURL .'address-book.php?KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox">Edit Addresses</a>';
						} else {
							echo '<a href="'. siteURL .'address-book.php?KeepThis=true&TB_iframe=true&height=500&width=700" class="thickbox">Add Addresses</a>';
						}
						
						echo "<br/>The following items will be included in each invitation that is mailed to your guests:<br/>";
						echo "<ul>";
						echo "<li>Wedding invitation</li>";
						echo "</ul>";
						break;
					}
				}
				?>
			</p>
			<script type="text/javascript">
				/* called from thickbox address-box */
				function set_guests( val, count ) {
					$("#guest_ids").val(val);
					tb_remove();
				}
				/* called from thickbox address-box */
				function get_guests() {
					return $("#guest_ids").val().trim();
				}
				
				jQuery(document).ready(function($){
					$(".personalized_btn_back").live ('click', function() {
						$("#previous").val('1');
						$("#step").val('step6');
					});
				});
				
			</script>
		</div>
		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Checkout"/>
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
