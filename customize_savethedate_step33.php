<?php
$_SESSION[$cat_id]['step3'] = $_REQUEST;

$card_bg_name = $row['card_bg_path'];
if ( $card_bg_name ) {
	$img = BLANK_CARDS . "$card_bg_name";
	list($card_width, $card_height, $type, $attr) = getimagesize($img);
	$PanWidth = "width:{$card_width}px;";
	$PanHeight = "height:{$card_height}px;";
}
/* set variables here */
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
		<img src="<?php echo siteURL;?>images/preview_1.png" />
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
		
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo siteURL . "create_card.php?$card_url"; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		</div> <!-- page_workArea -->
		<!--color_swatch-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right" style="width: <?php echo $right_width; ?>">
		
	<form name="frm_step4" id="frm_step4" method="post">
		<?php
		foreach($_REQUEST as $key => $val ) {
			if ( $key == 'rbo_verify') { continue; }
			if ( $key == 'step') {
				echo "<input type='hidden' id='step' name='step' value='step4' />\n";
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
		/*
		<input type="hidden" name="item_id" value="<?php echo $item_id;?>" />
		<input type="hidden" id="step" name="step" value="step4" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type" value="<?php echo $paper_type;?>" />
		<input type="hidden" name="qty_price" value="<?php echo $qty_price;?>" />
		<input type="hidden" name="total_price" id="hd_total_price" value="<?php echo $total_price;?>" />
		
		<?php
		$total_boxes = count( $e_box );
		for( $l = 0; $l < $total_boxes; $l++ ) {
			$ebox = $e_box[$l];
			echo "<input type='hidden' name='e_box[]' value='{$ebox}' />";
			echo "<input type='hidden' name='font_style[]' value='{$font_style[$l]}' />";
			echo "<input type='hidden' name='font_size[]' value='{$font_size[$l]}' />";
			echo "<input type='hidden' name='font_align[]' value='{$font_align[$l]}' />";
			echo "<input type='hidden' name='font_color[]' value='{$font_color[$l]}' />";
			echo "<input type='hidden' name='line_height[]' value='{$line_height[$l]}' />";
			echo "<input type='hidden' name='dimension[]' value='{$dimension[$l]}' />";
			echo "<input type='hidden' name='position[]' value='{$position[$l]}' />";
			unset($ebox);
		}
		
		if ( isset( $up ) ) {
			echo "<input type='hidden' name='up' value='{$up}' />";
		}
		*/
		?>
		
		<div class="detail_page_innerheading">
			Verify
		</div>
		<div class="detrail_page_desc">
			<p>
				<input type="radio" class="rbo_verify" name="rbo_verify" value="1" id="rbo_verify" />
				<label for="rbo_verify">By checking this box, I verify that all information on the card is correct and ready to be printed.</label>
			</p>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$(".personalized_btn").live ('click', function() {
						if ( $("#rbo_verify").is(':checked') == false ) {
							alert("Verify the information.")
							return false;
						}
					});
					
					$(".personalized_btn_back").live ('click', function() {
						$("#previous").val('1');
						$("#step").val('step3');
					});
					
				});
			</script>
		</div>
		
		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Continue"/>
			<input name="" type="submit"  class="personalized_btn_back" value="Previous"/>
			<div class="personalized_txt">
				<?php 
				echo "Your Price : <b>$ {$price[2]}</b><br/>";
				echo "Quantity: <b>{$price[1]}</b><br/>";
				?>
			</div>
		</div>
		<div class="detail_page_innerheading" style='width: auto;'>Special Instructions&nbsp;</div>
		<div class="detail_page_innerheading" style='width: auto; font-size: 14px;'> (Optional)</div>
		<div class="detrail_page_desc">
			<p>If you have any additional requests regarding the text, layout, or envelope printing options, please enter them here.</p>
			<textarea name='special_instructions' style='width: 90%; height: 60px;'></textarea>
		</div>
	</form>
	</div><!--detail_right-->
</div><!--body_internal_wrapp-->
