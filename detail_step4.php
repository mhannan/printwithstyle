<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['wed']['step4'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['wed']['step3'] = $_REQUEST;
}

if ( !isset($_SESSION['wed']['step4'] ) ) {
	$_SESSION['wed']['step4'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['wed']['step4'], $_SESSION['wed']['step3'], $_REQUEST );

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
$field_name_ids = explode( "|", $wedding_wordings[$hosting_type][3] );
$fc = $_REQUEST[$hosting_type] == "Formal" ? 0 : 1;
$total_fields = $wedding_wordings[$hosting_type][2];
$sample_text = $wedding_wordings[$hosting_type][$fc];
$field_name_ids = explode( "|", $wedding_wordings[$hosting_type][3] );
$wordings = $wedding_wordings[$hosting_type][$fc];


if ( !isset( $e_box ) || ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) ) {
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
		replace_sample_with_dynamic( $sample_text, $col, $_REQUEST[$col], $fc );
	}
	$sample_text = explode('<!--dss-->', $sample_text );
} else {
	$sample_text = array();
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
	replace_sample_with_dynamic( $sample_text, $col, $_REQUEST[$col], $fc );
}

$sample_text = explode('<!--dss-->', $sample_text );
$card_settings = unserialize( $row['card_settings'] );	
*/	
	//var_dump($sample_text);	
?>
<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img src="<?php echo siteURL;?>images/preview.png" />
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
		
		$card_settings = unserialize( $row['card_settings'] );
		if ( count( $card_settings ) ) {
			
			$total_boxes = count($card_settings);
			
			//for($i = 0; $i < $total_boxes; $i++ ) {
				$dbox = $card_settings[0];
				$dimensionss = explode( '_', $dbox['content_container_dimension'] );
				$positionss = explode( '_', $dbox['content_container_position'] );
				$box_style = "width: {$dimensionss[0]}px; height: {$dimensionss[1]}px; left: {$positionss[0]}px; top: {$positionss[1]}px;";
				?>
				<div class="card_content_holder_mobile" id="b<?php echo $i+1; ?>" style="<?php echo $box_style . ' ; '; ?> ;background-repeat: no-repeat; position: absolute; float: left;"></div>
				<?php
			//}
		}
		
		?>
		</div> <!-- page_workArea -->
		<!--color_swatch-->
		<div class="color_swatch">
		</div><!--color_swatch-->

		<!--zoom_option-->
		<div class="zoomer_wrapp" style="display:none; visibility: hidden;">
			<a href="uploads/blank_cards/<?php echo $row['card_bg_path']; ?>" id="card_large_preview"><span><img src="images/zoom.png" /></span> Zoom in</a>
		</div><!--zoom_option-->
	</div><!--detail_left-->

	<!--detail_right-->
	<div class="detail_right" style="width: <?php echo $right_width; ?>">
		
	<form name="frm_step4" id="frm_step4" method="post">
		<input type="hidden" name="item_id" value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step44" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price"value="<?php echo $_REQUEST['qty_price'];?>" />
		<input type="hidden" name="hosting_type" value="<?php echo $_REQUEST['hosting_type']; ?>" />
		<input type="hidden" name="<?php echo $_REQUEST['hosting_type']; ?>" value="<?php echo $_REQUEST[$_REQUEST['hosting_type']]; ?>" />
		<div class="detail_page_innerheading">
			Personalize Your Card
		</div>
		<div class="detrail_page_desc">
			<p>
				Select the fonts you want for the main wording of the invitation and for the couple's names.
			</p>
		</div>
		
		<div class="detrail_page_desc">
			<?php
				require ('editor-wed-php.php');
				require ('editor-wed-js.php');
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
			return true;
		});
		$(".personalized_btn_back").live ('click', function() {
			$("#previous").val('1');
			$("#step").val('step3');
		});
	});
</script>
