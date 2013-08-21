<?php
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
if ( $row['have_photo'] == '1' ) {
	$total_fields = $thankyou_card[1];
	$field_name_ids = explode( "|", $thankyou_card[2] );
	$wordings = $thankyou_card[0];
} else {
	$total_fields = $thankyou_card_no_photo[1];
	$field_name_ids = explode( "|", $thankyou_card_no_photo[2] );
	$wordings = $thankyou_card_no_photo[0];
}

if ( !isset( $e_box ) || ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) ) {
	//$wordings = explode( '<!--dss-->', $wordings );
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
} else {
	foreach($e_box as $eb) {
		$sample_text[] = $eb;
	}
}

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
<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
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

		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo $img; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		<?php
		//var_dump($sample_text); 
		if ( count( $card_settings ) ) {
			$total_box = count($card_settings);
			for($b = 1; $b <= $total_box; $b++ ) {
				$box = $card_settings[$b-1];
				$dimensionss = explode( '_', $box['content_container_dimension'] );
				$positionss = explode( '_', $box['content_container_position'] );
				$css = "width: {$dimensionss[0]}px; height: {$dimensionss[1]}px; left: {$positionss[0]}px; top: {$positionss[1]}px; color: #{$box['font_color']}";
				$path = "w={$dimensionss[0]}&h={$dimensionss[1]}&s={$box['font_size']}&lh={$box['line_height']}&c={$box['font_color']}&a={$box['text_alignment_style']}&f=arial&t=".urlencode(strip_tags($sample_text[$b]));
				$param = "background-image: url('" . siteURL . "create_image.php?$path');";
				$id = "b{$b}";
				$_w_ =  $dimensionss[0];
				$_h_ = $dimensionss[1];
				if ( $b > 2 && $row['have_photo'] == '1') {
					$url = siteURL . "custom-photo.php?w={$_w_}&h={$_h_}&card_w={$card_width}&card_h={$card_height}&KeepThis=true&TB_iframe=true&height=600&width=800&modal=true";
				?>
				<div class="card_content_holder_mobile my_display_photos" id="<?php echo $id;?>" style="<?php echo $css; ?>; position: absolute; float: left;">
					<a id="u_photo" href="<?php echo $url;?>" class="thickbox">Upload photo here</a> 
				</div>
				<?php
				} else {
				?>
				<div class="card_content_holder_mobile" id="<?php echo $id;?>" style="<?php echo $css . ' ; ' . $param; ?> ;background-repeat: no-repeat; position: absolute; float: left;"></div>
				<?php
				}
			}
		}
		?>
		</div> <!-- page_workArea -->
		<!--color_swatch-->
		<div class="photos_watch">
			
		</div><!--color_swatch-->
		<a id="a_r_photos" style="display:none;" href="<?php echo $url;?>" class="thickbox">Click here to add or edit photos</a><br/>
		<small id="add_msg" style="display:none;">Double click on photo to add to card</small>

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
		?>
		<input type="hidden" name="item_id" value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step33" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price" value="<?php echo $_REQUEST['qty_price'];?>" />
		<input type="hidden" name="up" id="uploaded_photo" value="<?php echo $up; ?>" />
		<?php 
		 */
		 ?> 
		 <input type="hidden" name="up" id="uploaded_photo" value="<?php echo $up; ?>" />
		<div class="detail_page_innerheading">
			Personalize Your Card
		</div>
		<div class="detrail_page_desc">
			<p>
				Click on the text areas of the card to open the text boxes below, or click directly into the boxes below to make changes
			</p>
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
			return true;
		});
		$(".personalized_btn_back").live ('click', function() {
			$("#previous").val('1');
			$("#step").val('step2');
		});

<?php if ( $row['have_photo'] == '1' ) : ?>		
		$("img.my_photos").live ('click', function() {
			var _src = $(this).attr('src');
			$("#uploaded_photo").val(_src);
			var _url = "url('" + _src + "')";
			$("div.my_display_photos").css( 
				{
					'background-image' : _url,
					'background-repeat': 'no-repeat'
				}
			);
		});
		
		if ( $("#uploaded_photo").val() != '' ) {
			var _url = "url('" + $("#uploaded_photo").val() + "')";
			$("div.my_display_photos").css( 
				{
					'background-image' : _url,
					'background-repeat': 'no-repeat'	
				}
			);
		}
		
		<?php endif; ?>
	});
	
	<?php if ( $row['have_photo'] == '1' ) : ?>		
	function update_photo_strip() {
		/* call the ajax and set the photo strip below the image */
		$("div.photos_watch").html('');
		$.post(
			"<?php echo siteURL . "process-ajax.php";?>",
			{
				call : 'display_uploaded_photos'
			},
			function (ret) {
				if ( ret != '' ) {
					$("div.photos_watch").html(ret);
					$("#a_r_photos").show();
					$("#add_msg").show();
					$("#u_photo").hide();
					tb_remove();
				}
			}
		);
	}
	setTimeout(update_photo_strip, 1000);
<?php endif; ?>
			
</script>
