<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION[$cat_id]['step2'];
} else {
	/* update session step with updated request for previous step*/
	$_SESSION[$cat_id]['step1'] = $_REQUEST;
}

if ( !isset($_SESSION[$cat_id]['step2'] ) ) {
	$_SESSION[$cat_id]['step2'] = array();
}
/* merge array current, previous and next */
$_REQUEST = array_merge( $_SESSION[$cat_id]['step2'], $_SESSION[$cat_id]['step1'], $_REQUEST );

$card_bg_name = $row['card_sample_path'];
if ( $card_bg_name ) {
	$img = SAMPLE_CARDS . "$card_bg_name";
	list($card_width, $card_height, $type, $attr) = getimagesize($img);
	
	$PanWidth = "width:{$card_width}px;";
	$PanHeight = "height:{$card_height}px;";
	
}

/* set variables here */
extract($_REQUEST);
/* get the wording style specific to category */
#echo '<pre>'; print_r($_REQUEST); echo '</pre>';

/*
if ( $row['have_photo'] == '1' ) {
	$total_fields = $save_the_date[1];
	$field_name_ids = explode( "|", $save_the_date[2] );
	$wordings = $save_the_date[0];
} else {
	$total_fields = $save_the_date[1];
	$field_name_ids = explode( "|", $save_the_date[2] );
	$wordings = $save_the_date[0];
}
*/
// '$save_the_date' wording array will be used for PHOTO/withoutPhoto card as textually there is no difference, hence commented above setion
	$total_fields = $save_the_date[1];
	$field_name_ids = explode( "|", $save_the_date[2] );
	$wordings = $save_the_date[0];
	
	
	
$wordings = explode( '<!--dss-->', $wordings );

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
		<img src="<?php echo siteURL;?>images/where_when_1.png" />
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
		
		<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo $img; ?>'); <?php echo $PanWidth . $PanHeight; ?> "></div> <!-- page_workArea -->
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
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step3" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price"value="<?php echo $_REQUEST['qty_price'];?>" />
		<div class="detail_page_innerheading">
			Add details to your card
		</div>
		<div class="detrail_page_desc">
			<p>
				Enter the details you would like to include on your cards. We will use your information to generate an online preview of your personalized design.
			</p>
			<style type="text/css">
				.card_content_holder_mobile {
					/*background-color: #efefef;*/
					border: 1px solid transparent;
					border-radius: 4px;
					text-align: center;	
					white-space: pre;
				}
				
				div.detrail_page_desc p input {
					border: 1px solid #E0B0EA;
					border-radius: 2px;
					clear: both;
				    float: left;
				    height: 20px;
				    padding: 2px;
				    width: 320px;
				}
				
				div.detrail_page_desc p .smallDD {
					border: 1px solid #E0B0EA;
				    border-radius: 2px;
				    float: left;
				    height: 23px;
				    margin-right: 5px;
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
				} /*else if ( $name_id == 'A1' || $name_id == 'A2' ) {
					if ( isset( $_REQUEST[$name_id] ) ) {
						$val = $_REQUEST[$name_id];
					}
				?>
					<textarea name="<?php echo $name_id;?>" id="<?php echo $name_id;?>"><?php echo $val; ?></textarea>
				<?php
				} */else {
					if ( isset( $_REQUEST[$name_id] ) ) {
						$val = $_REQUEST[$name_id];
					}
				?>
					<input type="text" name="<?php echo $name_id;?>" id="<?php echo $name_id;?>" value="<?php echo ($name_id=='AND'?'&':$val); ?>" <?php echo ($name_id=='AND'?'style="display:none"':''); // because we do not need to display 'AND' text field as that managed automatically and written automatically to the card on next step'?> />
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
					$("#step").val('step1');
				});
			});
		</script>

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
