<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['wed']['step6'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['wed']['step5'] = $_REQUEST;
}

if ( !isset($_SESSION['wed']['step6'] ) ) {
	$_SESSION['wed']['step6'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['wed']['step6'], $_SESSION['wed']['step5'], $_REQUEST );
?>
<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img src="<?php echo siteURL;?>images/envelope.png" />
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
			
		} else {
			$PanWidth = 'width:' . ($card_width * 100 + 20) . 'px;';
			$PanHeight = 'height:' . ($card_height * 100) . 'px;';
		}
		/* set variables here */
		//var_dump($_REQUEST);
		extract($_REQUEST);
		$card_settings = unserialize( $row['card_settings'] );	
		$price = explode( "||", $qty_price );
		
		
		
		/* generate create card url params */
		$card_url = generate_web_card_url();
		?>
		
		<div class="detail_left_smallgeading" style="clear:both;">Envelope</div>
		<div id="card_envelop"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo ENVELOPES . "white.jpg" ; ?>'); background-repeat: no-repeat; width: 450px; height: 337px;">
		</div>
		<div class="detail_left_smallgeading" style="clear:both;">Invitation</div>
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo siteURL . "create_wed_card.php?$card_url"; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		</div> <!-- page_workArea -->
		<!--color_swatch-->
		<div class="zoomer_wrapp" style="display: none; visibility: hidden;">
			<a href="<?php echo siteURL . 'create_card.php'; ?>" id="card_large_preview"><span><img src="images/zoom.png" /></span> Zoom in</a>
		</div>
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right">
		
	<form name="frm_step6" id="frm_step6" method="post"  action="add_to_cart.php">
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
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
		<input type="hidden" name="guest_ids" value="<?php echo $guest_ids;?>" id="guest_ids" />
		<input type="hidden" name="total_guest_ids" value="<?php echo $total_guest_ids;?>" id="total_guest_ids" />
		<input type="hidden" name="mail_option" value="<?php echo $mail_option; ?>"/>
		<input type="hidden" name="mail_option_addresses" value="<?php echo $mail_option_addresses; ?>"/>
		
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
			Envelope Options
		</div>
		<div class="detrail_page_desc">
			<p>
				Envelope options are listed below. Any additional cost, if applicable, is denoted on a per envelope basis. 
			</p>
			<select id="envelop" name="envelop">
				<?php echo get_card_envelopes( isset( $envelop ) ? $envelop : NULL ); ?>
			</select>
			
		</div>
		
		<?php
		if ($mail_option == 'mail_for_me' ) : 
			$hide_extra_envelopes = "style='display:none;'";
			else: 
			$hide_extra_envelopes = NULL;
			endif;
		?>
		<div class="detail_page_innerheading" <?php echo $hide_extra_envelopes;?>>
			Extra Envelopes
		</div>
		<div class="detrail_page_desc" <?php echo $hide_extra_envelopes;?>>
			<p>
				You can order extra mailing envelopes in case you make a mistake addressing your cards.  
			</p>
			<p>Extra Envelopes at $<?php echo ONE_ENVELOPE_COST;?> each = $<span id="x_evn_price"></span></p>
			<select id="x_envelop" name="x_envelop">
			<?php
			for( $x = 0; $x <= 50; $x+=5 ) {
				
				
				$sel = isset( $x_envelop ) && $x_envelop == $x ? ' selected="selected" ' : NULL;
				
				echo "<option value='{$x}' $sel>{$x}</option>";
			}
			?>
			</select>
			
		</div>
		<script type="text/javascript">
			var validation = null;
			jQuery(document).ready(function($){
				$(".personalized_btn").live ('click', function() {
					return true;
				});
				
				$(".personalized_btn_back").live ('click', function() {
					$("#previous").val('1');
					$("#step").val('step5');
					$("#frm_step6").attr("action", '<?php echo siteURL;?>detail.php');
				});
				
				$("#envelop").live ('change', function() {
					
					var _val = $("#envelop").val().split('|');
					var _url = "url('<?php echo ENVELOPES;?>" + _val[0] + "')";
					var _total_qty = "<?php echo (int)$price[1];?>";
					var _total_price = parseFloat("<?php echo (int)$price[2];?>");
					
					$("#card_envelop").css( {'background-image' : _url });
					
					if ( _val[1] > 0 ) {
						var _envelope_price = parseFloat( _val[1] ) * parseFloat( _total_qty ); 
						$("#hd_total_envelope").val(_envelope_price);
					} else {
						$("#hd_total_envelope").val('0');
						var _envelope_price = "0 (included)";
					}
					$("#evenlope_price").html(_envelope_price);
					$("#x_envelop").trigger('change');
				});
				
				$("#envelop").trigger('change');
				
				$("#x_envelop").live('change', function() {
					var _x_total = parseFloat( $(this).val() ) * parseFloat(<?php echo ONE_ENVELOPE_COST;?>);
					var _env_total = parseFloat( $("#hd_total_envelope").val() );
					var _total = parseFloat("<?php echo (float)$price[2];?>");
					var _tot_env_x = parseFloat( _env_total ) + parseFloat( _total );
					if ( _x_total > 0 ) {
						$("#hd_total_x_envelope").val( _x_total );
						_tot_env_x = parseFloat( _tot_env_x ) + parseFloat( _x_total );
						$("#evenlope_x_price").html("Extra Envelopes: <b>$ " + _x_total + "</b> <br/>").show();
					} else {
						$("#hd_total_x_envelope").val('0');
						$("#evenlope_x_price").html("").hide();
						
					}
					$("#evenlope_price_total").html(_tot_env_x.toFixed(2));
					$("#x_evn_price").html(_x_total);
				});
				
				$("#x_envelop").trigger('change');
			});
			
		</script>

		<div class="personalized_btn_wrapp">
			<input name="" type="submit" class="personalized_btn" value="Continue"/>
			<input name="" type="submit"  class="personalized_btn_back" value="Previous"/>
			<div class="personalized_txt">
				<?php 
				echo "Your Price : <b>$ {$price[2]}</b><br/>";
				echo "Quantity: <b>{$price[1]}</b><br/>";
				if($_REQUEST['mail_option']!="address_for_me" && $_REQUEST['return'] !="return")								// if PrintingType is not 'addresForMe'AND'return' then let it display guests selected count
				{
					 	echo $total_guest_ids ? "{$total_guest_ids} guest(s) selected<br/>" : NULL;
				}
				?>
				Envelope Price: <b>$</b> <span id="evenlope_price" style="font-weight:bold"></span><br/>
				<span id="evenlope_x_price" style="display:block; margin:5px 0px"></span>
				<!-- Total Price: <b>$</b> <span id="evenlope_price_total" style="font-weight:bold"></span> -->
			</div>
		</div>
	</form>
	</div><!--detail_right-->

</div><!--body_internal_wrapp-->
