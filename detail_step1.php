<?php
if ( !isset( $_SESSION['wed']['step1'] ) ) {
	$_SESSION['wed']['step1'] = $_REQUEST;
}
$_REQUEST = $_SESSION['wed']['step1'];

$card_bg_name = $row['card_sample_path'];
if ( $card_bg_name ) {
	$img = SAMPLE_CARDS . "$card_bg_name";
	list( $card_width, $card_height, $type, $attr ) = getimagesize($img);
}
/* set left right widths */
if ( $card_width > 453 ) { // imaeg is wider then the left width 
	$left_width = $card_width."px";
	$right_width = (931 - $card_width)."px"; 
} else {
	$left_width = "453px";
	$right_width = "478px";
}

?>

<!--body_internal_wrapp-->
<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img width="440" src="<?php echo siteURL;?>images/quantity.png" />
	</div>
	<!--detail_page_heading-->
	<div class="detail_page_heading">
		<?php echo $row['cat_title'] . ' : ' . $row['card_title']; ?>
	</div><!--detail_page_heading-->
	<!--detail_left-->
	<div class="detailpage_left" style="width: <?php echo $left_width;?>">
		<div class="detail_left_smallgeading">
			<?php echo $row['card_code'] . ' - ' . $row['card_title']; ?>
		</div>
		<!--detail_big_img-->
		<div class="detail_big_img_wrapp" style="width: <?php echo $left_width;?>">
			<a href="uploads/sample_cards/<?php echo $row['card_sample_path']; ?>" id="card_large_preview">
				<img src="uploads/sample_cards/<?php echo $row['card_sample_path']; ?>" border="0" />
			</a>
		</div><!--detail_big_img-->

		<!--color_swatch-->
		<div class="color_swatch">

			<!-- <img src="images/color_swatch.png" /> -->

		</div><!--color_swatch-->

		<!--zoom_option-->
		<div class="zoomer_wrapp">
			<a href="uploads/sample_cards/<?php echo $row['card_sample_path']; ?>" id="card_large_preview"><span><img src="images/zoom.png" /></span> Zoom in</a>
		</div><!--zoom_option-->

	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right" style="width: <?php echo $right_width;?>">

		<div class="fav_wrapp" style="width: <?php echo ((int)$right_width/2)-30; ?>px!important;">
			Save to favorites
		</div>
		<div class="mailfrnd_wrapp" style="width: <?php echo ((int)$right_width/2)-30; ?>px!important;">
			Email to friend
		</div>

		<div class="detail_page_innerheading" style="width: <?php echo $right_width; ?>">
			Get Started with this design
		</div>
		<div class="detrail_page_desc" style="width: <?php echo $right_width; ?>">
			<?php echo $row['card_description']; ?>
		</div>
		
		<?php 
		extract($_REQUEST);
		$card_paper_sets = get_card_paper_sets( $row['card_id'] );
		$options_paper_types = '';
		$dv_qty_prices = '';
		$total_rows = mysql_num_rows($card_paper_sets);
		$counter = 0;
		if ( mysql_num_rows( $card_paper_sets ) ) {
			
			$cur_paper_name = $last_paper_name = '';
			
			while ($paper = mysql_fetch_object( $card_paper_sets ) ) {
				
				$cur_paper_name = $paper->paper_name;
				
				$per_unit = number_format(round($paper->price/$paper->quantity, 2), 2);
				
				if ( empty($last_paper_name) && $cur_paper_name == $paper->paper_name ) {
					$last_paper_name = $cur_paper_name;
					$name = $paper->paper_name . ' ( ' . $paper->paper_color_name . ' - ' . $paper->paper_weight . ' )';
					$sel = isset($paper_type) && $paper_type == $paper->paper_id ? ' selected="selected" ' : NULL;
					$options_paper_types .= "<option value='$paper->paper_id' $sel>$name</option>";
					$dv_qty_prices .= "<textarea id='qp_$paper->paper_id' style='display:none; visibility:hidden;'>";
					$val = "{$paper->card_paper_relation_id}||{$paper->quantity}||{$paper->price}";
					$sel = isset($qty_price) && $qty_price == $val ? ' selected="selected" ' : NULL;
					$dv_qty_prices .= "<option value='$val' $sel>{$paper->quantity} Cards ( &#36;{$per_unit} each ) &#36;{$paper->price}</option>";
				} else if ( $last_paper_name == $cur_paper_name ) {
					$val = "{$paper->card_paper_relation_id}||{$paper->quantity}||{$paper->price}";
					$sel = isset($qty_price) && $qty_price == $val ? ' selected="selected" ' : NULL;
					
					$dv_qty_prices .= "<option value='$val' $sel>{$paper->quantity} Cards ( &#36;{$per_unit} each ) &#36;{$paper->price}</option>";
				} else if ( !empty( $last_paper_name ) && $cur_paper_name == $paper->paper_name ) {
					$last_paper_name = $cur_paper_name;
					$name = $paper->paper_name . ' ( ' . $paper->paper_color_name . ' - ' . $paper->paper_weight . ' )';
					$sel = isset($paper_type) && $paper_type == $paper->paper_id ? ' selected="selected" ' : NULL;
					$options_paper_types .= "<option value='$paper->paper_id' $sel>$name</option>";
					$dv_qty_prices .= "<textarea id='qp_$paper->paper_id' style='display:none; visibility:hidden;'>";
					$val = "{$paper->card_paper_relation_id}||{$paper->quantity}||{$paper->price}";
					$sel = isset($qty_price) && $qty_price == $val ? ' selected="selected" ' : NULL;
					$dv_qty_prices .= "<option value='$val' $sel>{$paper->quantity} Cards ( &#36;{$per_unit} each ) &#36;{$paper->price}</option>";
				}
				$counter++;
				if ( $counter == $total_rows ) { // close the textarea for the last row
					$dv_qty_prices .= "</textarea>";
				}
				
				

			}
		} else {
			
		}
		echo $dv_qty_prices;
		?>
		
		<form action="detail.php" method="post">
			<input type="hidden" name="item_id" value="<?php echo $row['card_id'];?>" />
			<input type="hidden" name="step" value="step2" />
		
		
		<div class="detail_form_wrapp" style="width: <?php echo $right_width; ?>; margin-top:10px">
			<label>Paper Type:</label>
			<select name="paper_type" id="paper_type" style="width: 65%;">
				<?php echo $options_paper_types; ?>
			</select> <!-- type dropdown -->
		</div>
		<div class="detail_form_wrapp"  style="width: <?php echo $right_width; ?>; margin-top:10px">
			<label>Quantity:</label>
			<select name='qty_price' id="qty_price" style="width: 65%;">
			
			</select>
		</div>
		
		<script type="text/javascript">
			jQuery(document).ready(function($){
				
				$("#paper_type").live ('change', function() {
					var _id = $("#paper_type").val();
					var _options = $("#qp_"+_id+"").val();
					$("#qty_price").html(_options);
					$("#qty_price").trigger('change');
				});
				$("#paper_type").trigger('change');
				
				$("#qty_price").live ('change', function() {
					var _sel_price = $("#qty_price").val().split('||');
					var _price = "Your Price : $ " + _sel_price[2];
					_price += "<br/>Your Quantity: " + _sel_price[1];
					$(".personalized_txt").html(_price);
				});
				$("#qty_price").trigger('change');
			});
		</script>

		

		<div class="detail_page_innerheading" style="width: <?php echo $right_width; ?>; margin-top:30px; display:none;">
			Matching Items
		</div>

		<div class="matching_item_wrapp" style="width: <?php echo $right_width; ?>; display:none; ">

			<?php
			$res = getMatchingCards_byCatId( $row['card_id'], "dss-skip" );
			$i =0;
			while( $matching_card = mysql_fetch_array( $res ) ) {
				$url = get_card_url($matching_card['cat_id'], $matching_card['card_id']);
			?>
			<!--matching_post-->
			<div class="matching_item_post">

				<div class="matching_item_img">
					<a href="<?php echo $url; ?>"><img src="uploads/sample_cards/<?php echo $matching_card['card_sample_path']; ?>" border="0" style="height:100px; width: 110px;" /></a>
				</div>
				<div class="matching_item_name">
					<?php echo $matching_card['card_title']; ?>
				</div>
				<div class="matching_item_btn">
					<a href="<?php echo $url; ?>"><img src="images/pick_quantity_btn.png" border="0" /></a>
				</div>
			</div><!--matching_post-->
			<?php
			$i++;
			}
			if($i == 1)
				echo "<div style='margin:10px 0px' align='center'>No matching item found</div>";
			?>
		</div>
		<div class="personalized_btn_wrapp">
			
			<input name="" type="submit"  class="personalized_btn" value="Continue"/>
			<?php
			if ( isset( $row['content_area_of_card'] ) && $row['content_area_of_card'] == "1" ) {
				echo "<a href='".siteURL."sample-order.php?item_id={$row[card_id]}&KeepThis=true&TB_iframe=true&height=500&width=700' class='thickbox'>Order Sample</a>";
			}
			?>
			<div class="personalized_txt"></div>
		</div>
		</form>
	</div><!--detail_right-->
</div><!--body_internal_wrapp-->

