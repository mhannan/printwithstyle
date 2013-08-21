<?php
//var_dump($_REQUEST);
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION[$cat_id]['step3'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION[$cat_id]['step2'] = $_REQUEST;
}

if ( !isset($_SESSION[$cat_id]['step3'] ) ) {
	$_SESSION[$cat_id]['step3'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION[$cat_id]['step3'], $_SESSION[$cat_id]['step2'], $_REQUEST );
//var_dump($_REQUEST);
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

/* get the wording style specific to category */
if ( $row['cat_id'] == "6" || $row['cat_id'] == "4" ) {
	$total_fields = $enclosure_card[1];
	$field_name_ids = explode( "|", $enclosure_card[2] );
	$wordings = $enclosure_card[0];
	$date_type = NULL;
} else if ( $row['cat_id'] == "5" ) {
	$total_fields = $accommodation_cart[1];
	$field_name_ids = explode( "|", $accommodation_cart[2] );
	$wordings = $accommodation_cart[0];
	$date_type = "5";
} else if ( $row['cat_id'] == "3" ) {
	$total_fields = $response_card[1];
	$field_name_ids = explode( "|", $response_card[2] );
	$wordings = $response_card[0];
	$date_type = "9";
} else if ( $row['cat_id'] == "2" ) {
	$total_fields = $save_the_date[1];
	$field_name_ids = explode( "|", $save_the_date[2] );
	$wordings = $save_the_date[0];
	$date_type = "2";
} else {
	$fc = $_REQUEST[$hosting_type] == "Formal" ? 0 : 1;
	$total_fields = $wedding_wordings[$hosting_type][2];
	$field_name_ids = explode( "|", $wedding_wordings[$hosting_type][3] );
	$wordings = $wedding_wordings[$hosting_type][$fc];
	$date_type = NULL;
}

if ( !isset( $e_box ) || ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) ) {
	//$wordings = explode( '<!--dss-->', $wordings );
	$sample_text = $wordings;
	foreach( $field_name_ids as $col ) {
		if ( $col == 'T' || $col == 'D' || $col == 'A' || $col == 'RD' ) {
			if ( $col == 'D' || $col == 'RD' ) {
				$col = 'date';
			} else if ( $col == 'T' ) {
				$col = 'time';
			} else {
				continue;	
			}
		}
		replace_sample_with_dynamic( $sample_text, $col, $_REQUEST[$col], $date_type );
	}
	$sample_text = explode('<!--dss-->', $sample_text );
} else {
	foreach($e_box as $eb) {
		$sample_text[] = $eb;
	}
}

/*
$sample_text = $wordings;
foreach( $field_name_ids as $col ) {
	if ( $col == 'T' || $col == 'D' || $col == 'A' ) {
		if ( $col == 'D' ) {
			$col = 'date';
		} else if ( $col == 'T' ) {
			$col = 'time';
		} else {
			continue;	
		}
	}
	replace_sample_with_dynamic( $sample_text, $col, $_REQUEST[$col], $date_type );
}
$sample_text = explode('<!--dss-->', $sample_text );
*/

$card_settings = unserialize( $row['card_settings'] );
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
		<img src="<?php echo ($row['cat_id'] == '4' || $row['cat_id'] == '5' || $row['cat_id'] == '6' ? siteURL.'images/preview_1__no-env.png' : siteURL.'images/preview_1.png');?>" />
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

		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo $img; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		<?php
		//var_dump($sample_text); 
		if ( count( $card_settings ) ) {
			$total_box = count($card_settings);
			for($b = 1; $b <= $total_box; $b++ ) {
				$box = $card_settings[$b-1];
				
				$default_dimension = isset( $dimension[$b-1] ) ? $dimension[$b-1] : $box['content_container_dimension'];
				$default_position = isset( $position[$b-1] ) ? $position[$b-1] : $box['content_container_position'];
				
				$dimensions = explode( '_', $default_dimension );
				$positions = explode( '_', $default_position );

				$css = "width: {$dimensions[0]}px; height: {$dimensions[1]}px; left: {$positions[0]}px; top: {$positions[1]}px;";
				$path = "w={$dimensions[0]}&h={$dimensions[1]}&s={$box['font_size']}&lh={$box['line_height']}&c={$box['font_color'][0]}&a={$box['text_alignment_style']}&f=arial&t=".urlencode(strip_tags($sample_text[$b]));
				$param = "background-image: url('" . siteURL . "create_image.php?$path');";
				$id = "b{$b}";
				?>
				<div class="card_content_holder_mobile" id="<?php echo $id;?>" style="<?php echo $css . ' ; ' . $param; ?> ;background-repeat: no-repeat; position: absolute; float: left;"></div>
				<?php
			}
		}
		?>
		</div> <!-- page_workArea -->
		<!--color_swatch-->
		<div class="color_swatch">

			<!-- <img src="images/color_swatch.png" /> -->

		</div><!--color_swatch-->

		<!--zoom_option-->
		<div class="zoomer_wrapp" style="display:none; visibility: hidden;">
			<a href="uploads/blank_cards/<?php echo $row['card_bg_path']; ?>" id="card_large_preview"><span><img src="images/zoom.png" /></span> Zoom in</a>
		</div><!--zoom_option-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right" style="width: <?php echo $right_width; ?>">
		
	<form name="frm_step3" id="frm_step3" method="post">
		<?php
		foreach($_REQUEST as $key => $val ) {
			if ( $key == 'step') {
				echo "<input type='hidden' id='step' name='step' value='step33' />\n";
			} else {
				if ( is_array( $val ) ) {
					foreach ($val as $k => $v) {
						echo "<input type='hidden' name='{$key}[]' value='{$v}' />\n";
					}
				} else {
					echo "<input type='hidden' id='{$key}' name='{$key}' value='{$val}' />\n";
				}
			}
		}
		/*
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step33" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price"value="<?php echo $_REQUEST['qty_price'];?>" />
		 */
		 ?>
		<div class="detail_page_innerheading">
			Personalize Your Card
		</div>
		<div class="detrail_page_desc">
			<p>
				Click on the text areas of the card to open the text boxes below, or click directly into the boxes below to make changes
			</p>
			<?php
			if ( $row['cat_id'] == 3 ){
				echo "<em><strong>If you have any special instructions for the layout of your card, please enter them on the next page, and one of our designers will follow up with you.</strong></em>";
			}
			?> 
		</div>
		
		<div class="detrail_page_desc">
			<?php
				require ('editor-php.php');
				require ('editor-js.php');
			?>
		</div>
		
		

		<div class="personalized_btn_wrapp">
			<input name="" type="submit" class="personalized_btn" value="Continue"/>
			<input name="" type="submit"  class="personalized_btn_back" value="Previous"/>
			<div class="personalized_txt">
				<?php $price = explode( "||", $_REQUEST['qty_price'] );
				echo "Your Price : <b>$ {$price[2]}</b><br/>";
				echo "Quantity: <b>{$price[1]}</b>";
				?>
			</div>
		</div>
	</form>
	</div><!--detail_right-->

</div><!--body_internal_wrapp-->

<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".personalized_btn").live ('click', function() {
			
		});
		
		$(".personalized_btn_back").live ('click', function() {
			$("#previous").val('1');
			$("#step").val('step2');
		});
	});
</script>
