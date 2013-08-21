<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['step4'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['step3'] = $_REQUEST;
}

if ( !isset($_SESSION['step4'] ) ) {
	$_SESSION['step4'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['step4'], $_SESSION['step3'], $_REQUEST );
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
		$field_name_ids = explode( "|", $wedding_wordings[$hosting_type][3] );
		$fc = $_REQUEST[$hosting_type] == "Casual" ? 0 : 1;
		$total_fields = $wedding_wordings[$hosting_type][2];
		$sample_text = $wedding_wordings[$hosting_type][$fc];
		$field_name_ids = explode( "|", $wedding_wordings[$hosting_type][3] );
		$wordings = $wedding_wordings[$hosting_type][$fc];
		
		$wordings = explode( '<!--dss-->', $wordings );
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
		?>
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
				$box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$drag_box1['font_size']}px; line-height: {$drag_box1['line_height']}px; color: #{$drag_box1['font_color']}; text-align: {$drag_box1['text_alignment_style']}; ";
			}
			/* drag box two */
			if ( $drag_box2 ) {
				$dimension = explode( '_', $drag_box2['content_container_dimension'] );
				$position = explode( '_', $drag_box2['content_container_position'] );
				$box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$drag_box2['font_size']}px; line-height: {$drag_box2['line_height']}px; color: #{$drag_box2['font_color']}; text-align: {$drag_box2['text_alignment_style']}; ";
			}
			/* drag box three */
			if ( $drag_box3 ) {
				$dimension = explode( '_', $drag_box3['content_container_dimension'] );
				$position = explode( '_', $drag_box3['content_container_position'] );
				$box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$drag_box3['font_size']}px; line-height: {$drag_box3['line_height']}px; color: #{$drag_box3['font_color']}; text-align: {$drag_box3['text_alignment_style']}; ";
			}
		}
		?>
			<div class="card_content_holder_mobile" id="b1" style="<?php echo $box[0]; ?> position: absolute; float: left;"><?php echo $sample_text[0] ?></div>
			<div class="card_content_holder_mobile" id="b2" style="<?php echo $box[1]; ?> position: absolute; float: left;"><?php echo $sample_text[1] ?></div>
			<div class="card_content_holder_mobile" id="b3" style="<?php echo $box[2]; ?> position: absolute; float: left;"><?php echo $sample_text[2] ?></div>
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
	<div class="detail_right">
		
	<form name="frm_step4" id="frm_step4" method="post">
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step5" />
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
				Click on the text areas of the card to open the text boxes below, or click directly into the boxes below to make changes
			</p>
			<style type="text/css">
				.card_content_holder_mobile {
					/*background-color: #efefef;*/
					
					border-radius: 4px;
					text-align: center;	
					white-space: pre;
					-moz-user-select: -moz-none;
					-khtml-user-select: none;
					-webkit-user-select: none;
					-ms-user-select: none;
					user-select: none;
				}
				.card_content_holder_mobile:hover {
					border: 1px solid #dadada;
					cursor: pointer;
				}
				
				div.detrail_page_desc div {
					border: 1px solid #efefef; 
					clear: both;
				    float: left;
				    width: 478px;
				    overflow: hidden;
				}
				
				div.detrail_page_desc div textarea {
					float: left;
				    height: 175px;
				    padding: 2px;
				    width: 350px;
				}
				div.detrail_page_desc div p.settings {
					float: left;
				    padding: 0;
				    margin: 0;
				    width: 450px;
				    display:none;
				}
				
				div.detrail_page_desc div .smallDD {
					border: 1px solid #E0B0EA;
				    border-radius: 2px;
				    float: left;
				    height: 23px;
				    margin-right: 20px;
				    padding: 2px;
				    width: 105px;
				}
				
			</style>
		</div>
		
		<div class="detrail_page_desc">
			<?php
			$total_boxes = count($card_settings);
			for ( $i = 0; $i < $total_boxes; $i++ ) {
				$name_id = "e_box[{$i}]";
				$txt = $sample_text[$i];
				$txt = nl2br($txt);
				$txt = str_replace(array( '\r', '\n', '\t', '<br/>' ), '', $txt); // replace newline, carriage return, tab 
				$txt = trim(strip_tags($txt)); // strip tags as html tags are showing within the textarea
				
				/* get font styles for this box */
				$font_items = $card_settings[$i]['font_items'];
				$sql = "
				SELECT font_id, font_label FROM " . TBL_FONTS . "
				WHERE font_id IN ( " . implode(', ', $font_items ) . " ) 
				";
				$fonts = mysql_query($sql) or die ( "Get Font for Box</br>$sql<br/>" . mysql_error() );
				$font_dd = '';
				if ( mysql_num_rows( $fonts ) ) {
					$font_dd = "<select name='font_style[{$i}]' id='font_style{$i}' class='box_fonts smallDD'>";
					while ($font = mysql_fetch_object( $fonts ) ) {
						$sel = isset( $font_style ) && $font_style[$i] == $font->font_label ? ' selected="selected" ' : NULL;
						$font_dd .= "<option value='$font->font_label' $sel style='font-family: $font->font_label;'>$font->font_label</option>";
					}
					$font_dd .= "</select>";
				} else {
					$font_dd = '';
				}
				
				/* generate size dropdown */
				$max_size = $card_settings[$i]['font_size'];
				$size_dd = '';
				if ( $max_size ) {
					$min_size = (int)$max_size - 5;
					$size_dd = "<select name='font_size[{$i}]' id='font_size{$i}' class='box_sizes smallDD'>";
					$preiouvsly_selected = FALSE;
					for($s = $min_size; $s <= $max_size; $s++ ) {
						if ( ( isset( $font_size ) && $font_size[$i] == "{$s}px" ) || $s == $max_size && !$preiouvsly_selected ) {
							$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
						} else {
							$sel = '';
						}
						$size_dd .= "<option $sel value='{$s}px'>$s</option>";
					}
					$size_dd .= '</select>';
				} else {
					$size_dd = '';	
				}
				
				/* generate alignment dropdown */
				$cur_align = $card_settings[$i]['text_alignment_style'];
				$preiouvsly_selected = FALSE;
				$align_dd = "<select name='font_align[{$i}]' id='font_align{$i}' class='box_align smallDD'>";
				
				if ( ( isset( $font_align ) && $font_align[$i] == 'right' ) && !$preiouvsly_selected ) {
					$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
				} else {
					$sel = '';
				}
				//$sel = $cur_align == 'right' ? ' selected="selected" ' : NULL;
				$align_dd .= "<option value='right' $sel >Right</option>";
				
				if ( ( isset( $font_align ) && $font_align[$i] == 'left' ) && !$preiouvsly_selected ) {
					$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
				} else {
					$sel = '';
				}
				
				//$sel = $cur_align == 'left' ? ' selected="selected" ' : NULL;
				$align_dd .= "<option value='left' $sel>Left</option>";
				
				
				if ( ( isset( $font_align ) && $font_align[$i] == 'center' ) && !$preiouvsly_selected ) {
					$sel = ' selected="selected" '; $preiouvsly_selected = TRUE;
				} else {
					$sel = '';
				}
				
				//$sel = $cur_align == 'center' ? ' selected="selected" ' : NULL;
				$align_dd .= "<option value='center' $sel>Center</option>";
				
				$align_dd .= "</select>";
				
				?>
				<div class="edit_boxes">
					<p class="settings">
					<?php echo $font_dd . $size_dd . $align_dd; ?>
					</p>
					<textarea name="<?php echo $name_id;?>" id="<?php echo $name_id;?>" class="display_box" rel="b<?php echo ($i + 1);?>"><?php echo $txt;?></textarea>
				</div>
				<?php
				//var_dump($card_settings[$i]);
			}
			?>
		</div>
		<script type="text/javascript">
			var validation = null;
			jQuery(document).ready(function($){
				$(".personalized_btn").live ('click', function() {
					return true;
				});
				$(".personalized_btn_back").live ('click', function() {
					$("#previous").val('1');
					$("#step").val('step3');
				});
				
				/* attach focus event on textarea to display settings */
				$("div.edit_boxes textarea").live ('focus', function() {
					$("p.settings").not($(this).parent().find('p.settings')).hide();
					$(this).parent().find('p.settings').show();
					
					/* highlight the relative display box */
					$(".card_content_holder_mobile").css ({'border' : "none"});
					var _id = $(this).attr('rel');
					$("#"+_id).css ({'border' : "1px solid #efefef"});
				});
				
				/* attach change text event on textarea to update the display box text */
				$("div.edit_boxes textarea").live ('change', function() {
					var _new_txt = $(this).val() || $(this).text() || $(this).html();
					
					var _id = $(this).attr('rel');
					$("#"+_id).css ({'line-height' : "20px"});
					$("#"+_id).text( _new_txt );
				});
				
				/* attach event on click event of the display box to show its settings */
				$(".card_content_holder_mobile").live ('click', function() {
					var _rel = $(this).attr('id');
					$("div.edit_boxes textarea[rel='"+_rel+"']").focus();
				});
				
				$("div.detrail_page_desc div").live ('mouseout', function() {
					//$("p.settings").hide();
				});
				
				/* update the font-family of textarea as well as relative display box */
				$(".box_fonts").live ('change', function() {
					var $ele = $(this).parent().parent().find('textarea'); 
					$ele.css( { 'font-family' : $(this).val() } );
					var _id = $ele.attr('rel');
					$("#"+_id).css( { 'font-family' : $(this).val() } );
				});
				
				$(".box_fonts").each( function() {
					var $ele = $(this).parent().parent().find('textarea'); 
					$ele.css( { 'font-family' : $(this).val() } );
					var _id = $ele.attr('rel');
					$("#"+_id).css( { 'font-family' : $(this).val() } );
				});
				
				/* update the font-size of textarea as well as relative display box */
				$(".box_sizes").live ('change', function() {
					var $ele = $(this).parent().parent().find('textarea'); 
					$ele.css( { 'font-size' : $(this).val() } );
					var _id = $ele.attr('rel');
					$("#"+_id).css( { 'font-size' : $(this).val() } );
				});
				
				$(".box_sizes").each ( function() {
					var $ele = $(this).parent().parent().find('textarea'); 
					$ele.css( { 'font-size' : $(this).val() } );
					var _id = $ele.attr('rel');
					$("#"+_id).css( { 'font-size' : $(this).val() } );
				});
				
				/* update the text-align of textarea as well as relative display box */
				$(".box_align").live ('change', function() {
					var $ele = $(this).parent().parent().find('textarea'); 
					$ele.css( { 'text-align' : $(this).val() } );
					var _id = $ele.attr('rel');
					$("#"+_id).css( { 'text-align' : $(this).val() } );
				});
				
				/* update the text-align of textarea as well as relative display box on page load */
				$(".box_align").each( function() {
					var $ele = $(this).parent().parent().find('textarea'); 
					$ele.css( { 'text-align' : $(this).val() } );
					var _id = $ele.attr('rel');
					$("#"+_id).css( { 'text-align' : $(this).val() } );
				});
				
			});
			
		</script>

		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Select Envelope"/>
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
