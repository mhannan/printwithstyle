<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['step5'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['step4'] = $_REQUEST;
}

if ( !isset($_SESSION['step5'] ) ) {
	$_SESSION['step5'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['step5'], $_SESSION['step4'], $_REQUEST );
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
			
		} else {
			$PanWidth = 'width:' . ($card_width * 100 + 20) . 'px;';
			$PanHeight = 'height:' . ($card_height * 100) . 'px;';
		}
		/* set variables here */
		//var_dump($_REQUEST);
		extract($_REQUEST);
		$card_settings = unserialize( $row['card_settings'] );	
		$price = explode( "||", $qty_price );
		?>
		<style type="text/css">
			.card_content_holder_mobile {
				/*background-color: #efefef;*/
				border-radius: 4px;
				white-space: pre;
				line-height: 20px;
				-moz-user-select: -moz-none;
				-khtml-user-select: none;
				-webkit-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}
		</style>
		<div class="detail_left_smallgeading" style="clear:both;">Envelope</div>
		<div id="card_envelop"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo ENVELOPES . "white.jpg" ; ?>'); background-repeat: no-repeat; width: 450px; height: 337px;">
		</div>
		<div class="detail_left_smallgeading" style="clear:both;">Invitation</div>
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo $img; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		<?php 
		$card_settings = unserialize( $row['card_settings'] );
		if ( count( $card_settings ) ) {
			$drag_box1 = isset($card_settings[0]) ? $card_settings[0] : NULL;
			$drag_box2 = isset($card_settings[1]) ? $card_settings[1] : NULL;
			$drag_box3 = isset($card_settings[2]) ? $card_settings[2] : NULL;
			/* drag box one*/
			if ( $drag_box1 ) {
				$dimension = explode( '_', $drag_box1['content_container_dimension'] );
				$position = explode( '_', $drag_box1['content_container_position'] );
				$box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$font_size[0]}px; line-height: 15px; color: #{$drag_box1['font_color']}; text-align: {$font_align[0]}; font-family: {$font_style[0]}; ";
			}
			/* drag box two */
			if ( $drag_box2 ) {
				$dimension = explode( '_', $drag_box2['content_container_dimension'] );
				$position = explode( '_', $drag_box2['content_container_position'] );
				$box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$font_size[0]}px; line-height: 15px; color: #{$drag_box2['font_color']}; text-align: {$font_align[1]}; font-family: {$font_style[1]}; ";
			}
			/* drag box three */
			if ( $drag_box3 ) {
				$dimension = explode( '_', $drag_box3['content_container_dimension'] );
				$position = explode( '_', $drag_box3['content_container_position'] );
				$box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$font_size[0]}px; line-height: 15px; color: #{$drag_box3['font_color']}; text-align: {$font_align[2]}; font-family: {$font_style[2]}; ";
			}
		}
		?>
			<div class="card_content_holder_mobile" id="b1" style="<?php echo $box[0]; ?> position: absolute; float: left;"><?php echo $e_box[0] ?></div>
			<div class="card_content_holder_mobile" id="b2" style="<?php echo $box[1]; ?> position: absolute; float: left;"><?php echo $e_box[1] ?></div>
			<div class="card_content_holder_mobile" id="b3" style="<?php echo $box[2]; ?> position: absolute; float: left;"><?php echo $e_box[2] ?></div>
		</div> <!-- page_workArea -->
		<!--color_swatch-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right">
		
	<form name="frm_step5" id="frm_step5" method="post">
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step6" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price"value="<?php echo $_REQUEST['qty_price'];?>" />
		<input type="hidden" name="hosting_type" value="<?php echo $_REQUEST['hosting_type']; ?>" />
		<input type="hidden" name="<?php echo $_REQUEST['hosting_type']; ?>" value="<?php echo $_REQUEST[$_REQUEST['hosting_type']]; ?>" />
		<input type="hidden" name="total_price" id="hd_total_price" value="<?php echo (int)$price[2];?>" />
		<input type="hidden" name="total_envelope" id="hd_total_envelope" value="0" />
		<input type="hidden" name="total_x_envelope" id="hd_total_x_envelope" value="0" />
		<?php
		$total_boxes = count($_REQUEST['e_box']);
		for( $l = 0; $l < $total_boxes; $l++ ) {
			echo "<input type='hidden' name='e_box[]' value='{$_REQUEST['e_box'][$l]}' />";
			echo "<input type='hidden' name='font_style[]' value='{$_REQUEST['font_style'][$l]}' />";
			echo "<input type='hidden' name='font_size[]' value='{$_REQUEST['font_size'][$l]}' />";
			echo "<input type='hidden' name='font_align[]' value='{$_REQUEST['font_align'][$l]}' />";
		}
		
		//var_dump($_REQUEST);
		?>
		
		
		<div class="detail_page_innerheading">
			Envelope Options
		</div>
		<div class="detrail_page_desc">
			<p>
				Envelope options are listed below. Any additional cost, if applicable is denoted on a per envelope basis. 
			</p>
			<select id="envelop" name="envelop">
				<option value="white.jpg|0.00" <?php echo isset( $envelop ) && $envelop == "white.jpg|0.00" ? ' selected="selected" ' : NULL; ?>>White (included)</option>
				<option value="white-black-linen.jpg|0.20" <?php echo isset( $envelop ) && $envelop == "white-black-linen.jpg|0.20" ? ' selected="selected" ' : NULL; ?>>White Black Linen ($ 0.20)</option>
				<option value="white-platinum-shimmer.jpg|0.30" <?php echo isset( $envelop ) && $envelop == "white-platinum-shimmer.jpg|0.30" ? ' selected="selected" ' : NULL; ?>>White Platinum Shimmer ($ 0.30)</option>
				<option value="white-dark-mocha-matte.jpg|0.40" <?php echo isset( $envelop ) && $envelop == "white-dark-mocha-matte.jpg|0.40" ? ' selected="selected" ' : NULL; ?>>White Dark Mocha Matte ($ 0.40)</option>
				<option value="white-spring-shimmer.jpg|0.50" <?php echo isset( $envelop ) && $envelop == "white-spring-shimmer.jpg|0.50" ? ' selected="selected" ' : NULL; ?>>White Spring Shimmer ($ 0.50)</option>
			</select>
			
		</div>
		
		<div class="detail_page_innerheading">
			Extra Envelops
		</div>
		<div class="detrail_page_desc">
			<p>
				You can order extra mailing envelopes in case you make a mistake addressing your cards. Quantity below will include inner envelopes if you selected them.  
			</p>
			<p>Extra Envelope at $0.15 each = $<span id="x_evn_price"></span></p>
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
					$("#step").val('step4');
				});
				
				$("#envelop").live ('change', function() {
					
					var _val = $("#envelop").val().trim().split('|');
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
					var _x_total = parseFloat( $(this).val().trim() ) * 0.15;
					var _env_total = parseFloat( $("#hd_total_envelope").val().trim() );
					var _total = parseFloat("<?php echo (int)$price[2];?>");
					var _tot_env_x = parseFloat( _env_total ) + parseFloat( _total );
					if ( _x_total > 0 ) {
						$("#hd_total_x_envelope").val( _x_total );
						_tot_env_x = parseFloat( _tot_env_x ) + parseFloat( _x_total );
						$("#evenlope_x_price").html("Extra Envelop(s) Charges: <b>$ " + _x_total + "</b> <br/>").show();
					} else {
						$("#hd_total_x_envelope").val('0');
						$("#evenlope_x_price").html("").hide();
						
					}
					$("#evenlope_price_total").html(_tot_env_x);
					$("#x_evn_price").html(_x_total);
				});
				
				$("#x_envelop").trigger('change');
			});
			
		</script>

		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Mailing Options"/>
			<input name="" type="submit"  class="personalized_btn_back" value="Previous"/>
			<div class="personalized_txt">
				<?php 
				echo "Your Price : <b>$ {$price[2]}</b><br/>";
				echo "Quantity: <b>{$price[1]}</b><br/>";
				?>
				Envelope Price: <b>$</b> <span id="evenlope_price" style="font-weight:bold"></span><br/>
				<span id="evenlope_x_price" style="display:block;margin:5px 0px"></span>
				Total Price: <b>$</b> <span id="evenlope_price_total" style="font-weight:bold"></span>
			</div>
		</div>
	</form>
	</div><!--detail_right-->

</div><!--body_internal_wrapp-->
