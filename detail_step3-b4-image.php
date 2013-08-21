<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['step3'];
} else if ( isset( $_REQUEST['previous'] ) && !$_REQUEST['previous'] ) {
	/* update session step with updated request for previous step*/
	$_SESSION['step2'] = $_REQUEST;
}

if ( !isset($_SESSION['step3'] ) ) {
	$_SESSION['step3'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION['step3'], $_SESSION['step2'], $_REQUEST );
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
		extract($_REQUEST);
		$fc = $_REQUEST[$hosting_type] == "Casual" ? 0 : 1;
		$total_fields = $wedding_wordings[$hosting_type][2];
		$field_name_ids = explode( "|", $wedding_wordings[$hosting_type][3] );
		$wordings = $wedding_wordings[$hosting_type][$fc];
		
		$wordings = explode( '<!--dss-->', $wordings );
		$card_settings = unserialize( $row['card_settings'] );	
		?>
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo $img; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">
		<?php 
		
		if ( count( $card_settings ) ) {
			$drag_box1 = isset($card_settings[0]) ? $card_settings[0] : NULL;
			$drag_box2 = isset($card_settings[1]) ? $card_settings[1] : NULL;
			$drag_box3 = isset($card_settings[2]) ? $card_settings[2] : NULL;
			/* drag box one*/
			if ( $drag_box1 ) {
				$dimension = explode( '_', $drag_box1['content_container_dimension'] );
				$position = explode( '_', $drag_box1['content_container_position'] );
				$box_1 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$drag_box1['font_size']}px; line-height: {$drag_box1['line_height']}px; color: #{$drag_box1['font_color']}; text-align: {$drag_box1['text_alignment_style']}; ";
			}
			/* drag box two */
			if ( $drag_box2 ) {
				$dimension = explode( '_', $drag_box2['content_container_dimension'] );
				$position = explode( '_', $drag_box2['content_container_position'] );
				$box_2 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$drag_box2['font_size']}px; line-height: {$drag_box2['line_height']}px; color: #{$drag_box2['font_color']}; text-align: {$drag_box2['text_alignment_style']}; ";
			}
			/* drag box three */
			if ( $drag_box3 ) {
				$dimension = explode( '_', $drag_box3['content_container_dimension'] );
				$position = explode( '_', $drag_box3['content_container_position'] );
				$box_3 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px; font-size: {$drag_box3['font_size']}px; line-height: {$drag_box3['line_height']}px; color: #{$drag_box3['font_color']}; text-align: {$drag_box3['text_alignment_style']}; ";
			}
		}
		?>
			<div class="card_content_holder_mobile" id="b1" style="<?php echo $box_1; ?> position: absolute; float: left;">
				<?php echo $wordings[0] ?>
			</div>
			<div class="card_content_holder_mobile" id="b2" style="<?php echo $box_2; ?> position: absolute; float: left;">
				<?php echo $wordings[1] ?>
			</div>
			<div class="card_content_holder_mobile" id="b3" style="<?php echo $box_3; ?> position: absolute; float: left;">
				<?php echo $wordings[2] ?>
			</div>
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
		
	<form name="frm_step3" id="frm_step3" method="post">
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step4" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price"value="<?php echo $_REQUEST['qty_price'];?>" />
		<input type="hidden" name="hosting_type" value="<?php echo $_REQUEST['hosting_type']; ?>" />
		<input type="hidden" name="<?php echo $_REQUEST['hosting_type']; ?>" value="<?php echo $_REQUEST[$_REQUEST['hosting_type']]; ?>" />
		<div class="detail_page_innerheading">
			Tell me Who, Where and When
		</div>
		<div class="detrail_page_desc">
			<p>
				Enter the details you would like to include on your cards. We will use your information to generate an online preview of your personalized design.
			</p>
			<style type="text/css">
				.card_content_holder_mobile {
					/*background-color: #efefef;*/
					
					border-radius: 4px;
					text-align: center;	
					white-space: pre;
				}
				.card_content_holder_mobile:hover {
					border: 1px solid #dadada;
					cursor: pointer;
				}
				
				div.detrail_page_desc p input {
					border: 1px solid #E0B0EA;
					border-radius: 2px;
					clear: both;
				    float: left;
				    height: 20px;
				    padding: 2px;
				    width: 350px;
				}
				
				div.detrail_page_desc p .smallDD {
					border: 1px solid #E0B0EA;
				    border-radius: 2px;
				    float: left;
				    height: 23px;
				    margin-right: 20px;
				    padding: 2px;
				    width: 105px;
				}
				
				div.detrail_page_desc p textarea {
					border: 1px solid #E0B0EA;
					border-radius: 2px;
					float: left;
				    height: 75px;
				    padding: 2px;
				    width: 350px;
				}
				
				div.detrail_page_desc p label {
					clear: both;
				    float: left;
				    width: 478px;
				}
			</style>
		</div>
		
		<div class="detrail_page_desc">
			<?php
			$js_validation = '';
			for ($i = 0; $i < $total_fields; $i++ ) {
				$name_id = $field_name_ids[$i];
				$name_lbl = get_name_by_code_wordings($name_id);
				$val = '';
				?>
				<p>
					<label for="<?php echo $name_id;?>"><?php echo $name_lbl;?></label>
				<?php
				if ( $name_id == 'D' ) {
					
				?>
					<select name="date[m]" class="smallDD">
					<?php
					/* month */
					for( $m = 1; $m <= 12; $m++ ) {
						if ( isset( $_REQUEST['date']['m'] ) && $_REQUEST['date']['m'] == $m ) {
							$val = 'selected="selected"';
						} else {
							$val = '';
						}
						echo "<option value='$m' $val>" . get_month_name_by_number( $m ) . "</option>";
					}
					?>
					</select>
					<select name="date[d]" class="smallDD">
					<?php
					/* date */
					for( $d = 1; $d <= 31; $d++ ) {
						if ( isset( $_REQUEST['date']['d'] ) && $_REQUEST['date']['d'] == $d ) {
							$val = 'selected="selected"';
						} else {
							$val = '';
						}
						echo "<option value='$d' $val>$d</option>";
					}
					?>
					</select>
					<select name="date[y]" class="smallDD">
					<?php
					/* year */
					$cur_year = date('Y');
					$to_year = (int)$cur_year + 5;
					for( $y = $cur_year; $y <= $to_year; $y++ ) {
						if ( isset( $_REQUEST['date']['y'] ) && $_REQUEST['date']['y'] == $y ) {
							$val =  'selected="selected"';
						} else {
							$val = '';
						}
						echo "<option value='$y' $val >$y</option>";
					}
					?>
					</select>
				<?php
				} else if ( $name_id == 'T' ) {
				?>
					<select name="time[h]" class="smallDD">
					<?php
					/* hours */
					for( $h = 1; $h <= 12; $h++ ) {
						$h = strlen( $h ) == 1 ? "0".$h : $h;
						if ( isset( $_REQUEST['time']['h'] ) && $_REQUEST['time']['h'] == $h ) {
							$val =  'selected="selected"';
						} else {
							$val = '';
						}
												
						echo "<option value='$h' $val>$h</option>";
					}
					?>
					</select>
					<select name="time[m]" class="smallDD">
					<?php
					/* minutes */
					for( $h = 0; $h <= 59; $h+=30 ) {
						$h = strlen( $h ) == 1 ? "0".$h : $h;
						if ( isset( $_REQUEST['time']['m'] ) && $_REQUEST['time']['m'] == $h ) {
							$val =  'selected="selected"';
						} else {
							$val = '';
						}
						echo "<option value='$h' $val >$h</option>";
					}
					?>
					</select>
					<select name="time[ampm]" class="smallDD">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
					</select>
				<?php
				} else if ( $name_id == 'A1' || $name_id == 'A2' ) {
					if ( isset( $_REQUEST[$name_id] ) ) {
						$val = $_REQUEST[$name_id];
					}
				?>
					<textarea name="<?php echo $name_id;?>" id="<?php echo $name_id;?>"><?php echo $val; ?></textarea>
				<?php
				} else {
					if ( isset( $_REQUEST[$name_id] ) ) {
						$val = $_REQUEST[$name_id];
					}
				?>
					<input type="text" name="<?php echo $name_id;?>" id="<?php echo $name_id;?>" value="<?php echo $val; ?>" />
				<?php
				}
				?>
				</p>
				<?php
				
				
				/* javascript validation: leave date and time */
				if ( $name_id != 'D' && $name_id != 'T' ) {
					$js_validation .= "
					//if ( $('#$name_id').val().trim() == '' || $('#$name_id').text().trim() || $('#$name_id').html().trim() ) {
					if ( $('#$name_id').val().trim() == '' ) {
						alert(\"Missing: $name_lbl\");
						$('#$name_id').focus();
						return false;
					}
					";
				}
			}
			
			?>
		</div>
		<script type="text/javascript">
			var validation = null;
			jQuery(document).ready(function($){
				$(".personalized_btn").live ('click', function() {
					<?php echo $js_validation; ?>
					
					
					return true;
				});
				
				$(".personalized_btn_back").live ('click', function() {
					$("#previous").val('1');
					$("#step").val('step2');
				});
			});
		</script>

		<div class="personalized_btn_wrapp">
			<input name="" type="submit"  class="personalized_btn" value="Customize"/>
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
