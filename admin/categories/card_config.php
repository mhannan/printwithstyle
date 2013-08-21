<?php
require ('include/gatekeeper.php');
$_SESSION['urlselected'] = 'categories';
require ('../header.php');
require_once ("../lib/func.common.php");
require_once ("../lib/func.paper.php");
require_once ("../lib/func.categories.card.php");

if (isset($_REQUEST['card_id']))
	$cardSet = getCard_info($_REQUEST['card_id']);
$row = mysql_fetch_array( $cardSet );

$cat_id = $row['cat_id'];


$card_settings = !empty( $row['card_settings'] ) ? unserialize( $row['card_settings'] ) : array();

/* default settings for dragables boxes */
$dragable_block_width = '100';
$dragable_block_height = '100';
$dragable_block_top = '20';
$dragable_block_left = '20';
$box_style = "width: {$dragable_block_width}px; height: {$dragable_block_height}px; left: {$dragable_block_left}px; top: {$dragable_block_top}px;";

$card_sizeArr = explode('-', $row['card_size']);
// 0:33 inch  , 1: 44 inch
$card_width = explode(' ', $card_sizeArr[0]);
$card_width = $card_width[0];
$card_height = explode(' ', $card_sizeArr[1]);
$card_height = $card_height[0];
$card_bg_name = $row['card_bg_path'];

?>

<script type="text/javascript">
	function validateForm() {
		return true;
	}
</script>

<div id="main-content">
	

	<!-- Main Content Section with everything -->
	<div class="tab-content">
		<div class="content-box-header">
			<h3><span style='color:#666'><?php echo $row['cat_title']; ?>&raquo;</span><?php echo $row['card_title']; ?></h3>
		</div>
		<div class="content-box-content" style="border:1px solid #ccc">
			

			<!-- End .clear -->

			<form action="do_saveconfig_card.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data" onsubmit="return validateForm();">
				<div style="margin-top:10px">
					<h3>Card Pane Setup</h3>
				</div>
				<?php
				// ONLY DISPLAY *SAVE* BUTTON IF CARD IMAGE IS NOT BLANK/ EMPTY
				if ($card_bg_name != "") {
					if ( $row['cat_id'] == "1" ) {
						$url = siteURL . "detail.php?item_id={$row['card_id']}";
					} else if ( $row['cat_id'] == '7' ) {
						$url = siteURL ."custom.php?item_id={$row['card_id']}";
					} else {
						$url = siteURL ."customize.php?item_id={$row['card_id']}";
					}
						
					echo "<div align='right'>
						<input class='button' type='submit' value='Save Pane Setting & Active Card' />
						<a href='{$url}' target='_blank'>Preview</a>
						</div>";
				}
				?>
				<div style="padding:10px">
					<?php
					if ($card_bg_name == "")
						echo "<div style='text-align:center;padding:10px;color:red; border:1px dashed red'> <b>Card Image Missing!</b> Please upload card image first from Card-Edit option</div>";
					//echo "<br><img style='border:1px solid #666; margin-top:3px;' src='../../uploads/blank_cards/".$card_bg_name."' >";
					//else
					if ( $card_bg_name ) {
						$img = BLANK_CARDS . "$card_bg_name";
						list($card_width, $card_height, $type, $attr) = getimagesize($img);
						
						$PanWidth = "width:{$card_width}px;";
						$PanHeight = "height:{$card_height}px;";
						
					} else {
						$PanWidth = 'width:' . ($card_width * 100 + 20) . 'px;';
						$PanHeight = 'height:' . ($card_height * 100) . 'px;';
					}
					
					
					
					/* set the variables here */
					if ( count( $card_settings ) ) {
						$total_cs = count( $card_settings );
						for($c = 1; $c <= $total_cs; $c++ ) {
							$cs = $card_settings[$c-1];
							$dimension = explode( '_', $cs['content_container_dimension'] );
							$position = explode( '_', $cs['content_container_position'] );
							$drag_box[] = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px;";
							$hidden_fields[$c]['_dimension'] = $cs['content_container_dimension'];
							$hidden_fields[$c]['_position'] = $cs['content_container_position'];
						}
					} else { // new card
						for ($default = 1; $default <= 10; $default++ ) {
							$drag_box[] = $box_style;
							$hidden_fields[$default]['_dimension'] = "";
							$hidden_fields[$default]['_position'] = "";
						}
					}
					?>
					<input type="hidden" name="content_container_dimension[1]" id="content_container1_dimension" value="<?php echo $hidden_fields[1]['_dimension'];?>" >
					<input type="hidden" name="content_container_position[1]" id="content_container1_position" value="<?php echo $hidden_fields[1]['_position'];?>" >
					<input type="hidden" name="content_container_dimension[2]" id="content_container2_dimension" value="<?php echo $hidden_fields[2]['_dimension'];?>" >
					<input type="hidden" name="content_container_position[2]" id="content_container2_position" value="<?php echo $hidden_fields[2]['_position'];?>" >
					
					<input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">
					<input type="hidden" name="card_id" value="<?php echo $_REQUEST['card_id']; ?>">
					
					<?php
					
					if ($cat_id == '1' ) { // for wedding Card we need 3rd hidden block also to save diemension/size
						$blockCounter = 2; 
					} else if ( $cat_id == '3' ) {
						$blockCounter = 10;
					} else if ( $cat_id == '2' ) {	// client need '3' textual block and for picture card '1' additional photo block 
						 $blockCounter = 3;												// Original requirement was to have '2' textual blocks and '1' textual block
						 if($row['have_photo'] == "1")
										$blockCounter = 4;
						
					} else if ( $cat_id == '7' ) {
						$blockCounter = 3;
					} else {
						$blockCounter = 2;
					}
					
					/* set extra hidden fields if required */
					for ( $eh = 3; $eh <= $blockCounter; $eh++ ) 
					{
								$d_name = "content_container_dimension[{$eh}]";
								$d_id = "content_container{$eh}_dimension";
								$p_name = "content_container_position[{$eh}]";
								$p_id = "content_container{$eh}_position";
								$_dimensions = isset( $hidden_fields[$eh]['_dimension'] ) ? $hidden_fields[$eh]['_dimension'] : NULL;
								$_positions = isset( $hidden_fields[$eh]['_position'] ) ? $hidden_fields[$eh]['_position'] : NULL;
								?>
								<input type="hidden" name="<?php echo $d_name; ?>" id="<?php echo $d_id; ?>" value="<?php echo $_dimensions;?>" >
								<input type="hidden" name="<?php echo $p_name; ?>" id="<?php echo $p_id; ?>" value="<?php echo $_positions;?>" >
								<?php
					}
					
					
					?>
					
					<input type="hidden" name="blocksCounter" value="<?php echo $blockCounter; ?>" id="blocksCounter">

					<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo BLANK_CARDS . $card_bg_name; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">

						<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
						<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-ui.js"></script>
						<!-- color picker includes -->
						<link rel="stylesheet" href="<?php echo JS_PATH;?>colorpicker/css/colorpicker.css" type="text/css" />
						<script type="text/javascript" src="<?php echo JS_PATH;?>colorpicker/js/colorpicker.js"></script>
						
						<div class="card_content_holder_mobile" id="b1" onclick="showOptionPanel('b1')" style="<?php echo $drag_box[0]; ?> position: relative; float: left;">1st Block</div>
						<div class="card_content_holder_mobile" id="b2" onclick="showOptionPanel('b2')" style="<?php echo $drag_box[1]; ?> position: relative; float: left;">2nd Block</div>
						<?php
						
						/* generate other drag boxes if required */
						for ($dv_box = 3; $dv_box <= $blockCounter; $dv_box++ ) 
						{
												$dv_id = "b{$dv_box}";
												if ( $dv_box == 3 ) 
													{
																				if ( $cat_id == '7' && $row['have_photo'] == "1") 
																				{			
																								$txt = 'Photo Block';
																				} 
																				else 
																								$txt = '3rd Block';
												} 
											elseif ( $dv_box == 4 ) 
												{
																			if ( $cat_id =='2' && $row['have_photo'] == "1") 
																				{			// for saveTheDate card the '4th' block will be Picture block
																								$txt = 'Photo Block';
																				} 
																				else 
																								$txt = '4th Block';
												} 
											elseif ( $dv_box == 5 ) 
												{
																			$txt = '5th Block';	
												} 
											elseif ( $dv_box == 6 ) 
																$txt = '6th Block';	
											elseif ( $dv_box == 7 ) 
																$txt = '7th Block';
											else if ($dv_box == 8 )
																$txt = '8th Block';
											else if ($dv_box == 9 ) 
																$txt = '9th Block';
											else if ($dv_box == 10 ) 
																$txt = '10th Block';

																$style_box = isset( $drag_box[$dv_box-1] ) ? $drag_box[$dv_box-1] : $box_style;
												?>
																<div class="card_content_holder_mobile" id="<?php echo $dv_id;?>" onclick="showOptionPanel('<?php echo $dv_id;?>')" style="<?php echo $style_box; ?> position: relative; float: left;"><?php echo $txt;?></div>
						<?php
						}
						?>
																
						
						<script language="javascript">
							$(document).ready(function(){
								$('.card_content_holder_mobile')
									.draggable({ 
										 
										containment: 'parent', 
										stop: function (event, ui) {
											var id = $(this).attr('id').replace('b', '');
											/* set current height width in case he didn't resize the box */
											var contentBlock_width = $(this).css('width').replace('px', '');
											var contentBlock_height = $(this).css('height').replace('px', '');
											$('#content_container' + id + '_dimension').val(contentBlock_width + '_' + contentBlock_height);
											/* update position of the box to hidden field */
											$('#content_container' + id + '_position').val(ui.position.left + '_' + ui.position.top);
											
										}
									})
									.resizable({ 
										maxWidth: <?php echo (int)$card_width - 12; ?>, 
										maxHeight: <?php echo $card_height; ?>,
										stop: function (event, ui) {
											var id = $(this).attr('id').replace('b', '');
											/* update size of the box to hidden field */
											$('#content_container' + id + '_dimension').val(ui.size.width + '_' + ui.size.height);
										}
									});
								$("#page_workArea").droppable();
								$('.card_content_holder_mobile').trigger('dragstop');
								
								
								/* color picker js code */
								$('.txt_font_color').ColorPicker({
									onSubmit: function(hsb, hex, rgb, el) {
										$(el).val(hex);
										$(el).ColorPickerHide();
										$(el).next('span').css({'background-color' : "#" + hex});
									},
									onBeforeShow: function () {
										$(this).ColorPickerSetColor(this.value);
									},
									onChange: function (hsb, hex, rgb, el) {
										$(this).ColorPickerSetColor(hex);
										$(el).next('span').css({'background-color' : "#" + hex});
										$(el).val(hex);
									}
								})
								.bind('keyup', function(){
									console.log(this);
									$(this).ColorPickerSetColor(this.value);
								});
							});
							
							function showOptionPanel(blockSelected_id) {
								$('.blockOptionPanel').hide();
								// hide all options panels
								$('.blockOptionPanel').css({'color': 'black'});
								
								$(".card_content_holder_mobile").css({'color' : 'black'})
								
								$('#' + blockSelected_id).css({'color': 'green'});
								
								if(blockSelected_id == 'b1')
									$('#block1OptionPanel').show();
								else if(blockSelected_id == 'b2')
									$('#block2OptionPanel').show();
								else if(blockSelected_id == 'b3')
									$('#block3OptionPanel').show();
								else if(blockSelected_id == 'b4')
									$('#block4OptionPanel').show();
								else if(blockSelected_id == 'b5')
									$('#block5OptionPanel').show();
								else if(blockSelected_id == 'b6')
									$('#block6OptionPanel').show();
								else if(blockSelected_id == 'b7')
									$('#block7OptionPanel').show();
								else if(blockSelected_id == 'b8')
									$('#block8OptionPanel').show();
								else if(blockSelected_id == 'b9')
									$('#block9OptionPanel').show();
								else if(blockSelected_id == 'b10')
									$('#block10OptionPanel').show();
							}
						</script>
					</div>
					<?php
						$displayProperty = "";
						for ($i = 1; $i <= $blockCounter; $i++) {
							$b = $i - 1;
							
							//var_dump($card_settings[$b]['defaults']);
					?>
							<div style="float:left; margin-left:20px;  border:1px solid #ccc; <?php echo $displayProperty; ?>" class="blockOptionPanel" id="block<?php echo $i; ?>OptionPanel">
								<div style="width:270px; height:30px; padding:10px 0px 0px 5px; background-image: url('../resources/images/t_bg.jpg'); background-repeat:repeat-x; ">
									<b>Options Panel <span style="color:#aaa">(
										<?php
										if ($i == 1)
											echo '1st Block';
										elseif ($i == 2)
											echo '2nd Block';
										elseif ($i == 3)
											echo '3rd Block';
										elseif ($i == 4)
											echo '4th Block';
										elseif ($i == 5)
											echo '5th Block';
										elseif ($i == 6)
											echo '6th Block';
										elseif ($i == 7)
											echo '7th Block';
										elseif ($i == 8)
											echo '8th Block';
										?>
									)</span></b>
								</div>
								<div style="padding:10px">
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc;">
										<legend>Text Alignment:</legend>
										<input type="radio" name="text_alignment_style[<?php echo $i; ?>]" id="b<?php echo $i; ?>_align_l" value="left" <?php echo isset($card_settings[$b]['text_alignment_style']) && $card_settings[$b]['text_alignment_style'] == 'left' ? ' checked="checked" ' : NULL;?> >Left&nbsp;&nbsp;&nbsp;
										<input type="radio" name="text_alignment_style[<?php echo $i; ?>]" id="b<?php echo $i; ?>_align_c" value="center" <?php echo isset($card_settings[$b]['text_alignment_style']) && $card_settings[$b]['text_alignment_style'] == 'center' ? ' checked="checked" ' : NULL;?>>Center&nbsp;&nbsp;&nbsp;
										<input type="radio" name="text_alignment_style[<?php echo $i; ?>]" id="b<?php echo $i; ?>_align_r" value="right" <?php echo isset($card_settings[$b]['text_alignment_style']) && $card_settings[$b]['text_alignment_style'] == 'right' ? ' checked="checked" ' : NULL;?>>Right&nbsp;&nbsp;&nbsp; 
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc;">
										<legend>Default Text Alignment:</legend>
										<?php $default_text_align = isset($card_settings[$b]['defaults']['align']) ? $card_settings[$b]['defaults']['align'] : NULL;
										$dta = "defaults[{$i}][align]";
										 ?> 
										<select name="<?php echo $dta; ?>">
											<option value='left' <?php echo $default_text_align == 'left' ? ' selected="selected" ' : NULL;?> >Left</option>
											<option value='center' <?php echo $default_text_align == 'center' ? ' selected="selected" ' : NULL;?>>Center</option>
											<option value='right' <?php echo $default_text_align == 'right' ? ' selected="selected" ' : NULL;?>>Right</option>
										</select>
									</fieldset>
	
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; display:none;">
										<legend>Line Height/Spacing:</legend>
										<input type="text" name="line_height[<?php echo $i; ?>]" id="b<?php echo $i; ?>_line_height" value="<?php echo isset($card_settings[$b]['line_height']) ? $card_settings[$b]['line_height'] : NULL;?>">&nbsp;px
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Font Size:</legend>
										<input type="text" name="font_size[<?php echo $i; ?>]" id="b<?php echo $i; ?>_font_size" value="<?php echo isset($card_settings[$b]['font_size']) ? $card_settings[$b]['font_size'] : NULL;?>" style="width: 50px;">&nbsp;px
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Default Font Size:</legend>
										<input type="text" name="defaults[<?php echo $i;?>][size]" value="<?php echo isset($card_settings[$b]['defaults']['size']) ? $card_settings[$b]['defaults']['size'] : NULL;?>" style="width: 50px;">&nbsp;px
									</fieldset>
									
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Font Style:</legend>
										<div style="height:150px; overflow:scroll">
											<?php echo generate_fonts_HTML_element('font_items['.$i.'][]', 'b1' . $i . '_font_items', 'checkbox', isset( $card_settings[$b]['font_items'] ) ? $card_settings[$b]['font_items'] : 'ALL' ); ?>
										</div>
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Default Font Style:</legend>
											<?php echo generate_fonts_HTML_element("defaults[{$i}][style]", '', 'dropdown', isset( $card_settings[$b]['defaults']['style'] ) ? $card_settings[$b]['defaults']['style'] : 'ALL' ); ?>
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<?php $val = isset($card_settings[$b]['font_color'][0]) ? $card_settings[$b]['font_color'][0] : NULL; ?>
										<legend>Font Color Option One:</legend>
										<input type="text" class="txt_font_color" name="font_color[<?php echo $i; ?>][]" id="b<?php echo $i; ?>_font_color" value="<?php echo $val;?>">
										<span style="float: left; margin-right: 5px; width: 25px; height: 25px; background-color: #<?php echo $val;?>"></span><br/><br/>
										
										<?php $val = isset($card_settings[$b]['font_color'][1]) ? $card_settings[$b]['font_color'][1] : NULL; ?>
										<legend>Font Color Option Two:</legend>
										<input type="text" class="txt_font_color" name="font_color[<?php echo $i; ?>][]" id="b<?php echo $i; ?>_font_color" value="<?php echo $val;?>">
										<span style="float: left; margin-right: 5px; width: 25px; height: 25px; background-color: #<?php echo $val;?>"></span><br/><br/>
										
										<?php $val = isset($card_settings[$b]['font_color'][2]) ? $card_settings[$b]['font_color'][2] : NULL; ?>
										<legend>Font Color Option Three:</legend>
										<input type="text" class="txt_font_color" name="font_color[<?php echo $i; ?>][]" id="b<?php echo $i; ?>_font_color" value="<?php echo $val;?>">
										<span style="float: left; margin-right: 5px; width: 25px; height: 25px; background-color: #<?php echo $val;?>"></span>
										
										
										<?php $val = isset($card_settings[$b]['defaults']['color']) ? $card_settings[$b]['defaults']['color'] : NULL; ?>
										<legend>Default Font Color:</legend>
										<input type="text" class="txt_font_color" name="defaults[<?php echo $i;?>][color]" value="<?php echo $val;?>">
										<span style="float: left; margin-right: 5px; width: 25px; height: 25px; background-color: #<?php echo $val;?>"></span>
									</fieldset>
								</div>
							</div>
						<?php
						$displayProperty = 'display:none;';
						// on page load only display the first option panel
						}
						?>
						<div style="clear:both"  ></div>
				</div>
			</form>
			<?php
if (isset($_GET['okmsg'])) {
?>
<div class="notification success png_bg">
	<a href="#" class="close"><img src="<?php echo siteURL ?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
	<div>
		<?php echo base64_decode($_GET['okmsg']); ?>
	</div>
</div>
<?php
}
if (isset($_GET['errmsg'])) {
?>
<div class="notification error png_bg">
	<a href="#" class="close"><img src="<?php echo siteURL ?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
	<div>
		<?php echo base64_decode($_GET['errmsg']); ?>
	</div>
</div>
<?php } ?>

		<h3> Card Configuration </h3>

			<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
				<tr>
					<td style="padding:4px" width="30%"><b>Card Title </b>
					<input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">
					<input type="hidden" name="card_id" value="<?php echo $row['card_id']; ?>">
					</td>
					<td style="padding:4px" width="60%"><?php echo $row['card_title']; ?></td>
				</tr>
				<tr>
					<td style="padding:4px" width="30%"><b>Card Code</b></td>
					<td style="padding:4px" width="60%"><?php echo $row['card_code']; ?></td>
				</tr>
				<tr>
					<td style="padding:4px"><b>Card Dimension</b></td>
					<td style="padding:4px">Width: <u><?php echo $card_width; ?>inch</u> &nbsp;&nbsp;&nbsp;&nbsp; Height: <u><?php echo $card_height; ?>inch</u></td>
				</tr>
				<tr>
					<td colspan="2" style="border:1px dashed #ccc"><?php
					$card_papers_set = getCardPapers($row['card_id']);
					// returns all relations with GroupBy Claus over paper_type_id , as there could be multiple relations with same CardID and papertypeID but different quantity and price
					if (mysql_num_rows($card_papers_set) > 0) {
						while ($row = mysql_fetch_array($card_papers_set)) {
							echo "
							<div style='float:left; border:1px solid #999; margin-right:8px; margin-bottom:8px'>
    	                        <table border='0' cellspacing='0' width='200px' style='width:300px'>
                                	<tr>
                                    	<td align='center' style='padding:6px;border-bottom:1px solid #fff; text-align:center;background-image:url(../resources/images/t_bg.jpg)'><b>" . $row['paper_name'] . "</b><br>( " . $row['paper_color_name'] . " - " . $row['paper_weight'] . " )</td>
                                    </tr>
                                    <tr>
                                    	<td style='padding:6px'>
                                        	<form method='post' action='do_add_priceperquantity.php'>
                                            	<fieldset style='border:none; padding:4px'>
                                                	<legend>Setup Price per Quantity</legend>
                                                    <div style='margin-bottom:3px'>Quantity : <input type='text' name='quantity_txt' id='quantity_txt' style='width:80px'></div>
                                                    <div style='margin-bottom:3px'>@ Price : $ <input type='text' name='quantity_price' id='quantity_price' style='width:70px'>
                                                    <div style='margin-right:13px; text-align:right; float:right ' align='right'><input type='submit' name='submit' class='button' value=' Add '></div></div>
                                                    <input type='hidden' name='card_id' value='" . $row['card_id'] . "'> <input type='hidden' name='paper_type_id' value='" . $row['paper_id'] . "'>
                                                </fieldset>
                                           	</form>
										</td>
                                    </tr>
                                    <tr>
                                    	<td style='padding:0px'>
                                    		<table border='0' cellpadding='2' cellspacing='0'>
                                    			<tr style='background-color:#666'>
                                    				<td style='padding:3px;color:#fff'><b>Sr#</b></td>
                                    				<td style='padding:3px;color:#fff'><b>Quantity</b></td>
                                    				<td style='padding:3px;color:#fff'><b>Price</b></td>
                                    				<td width='10%'></td>
                                				</tr>";

												$rates_res = card_paper_relation_prices_per_quantities($row['card_id'], $row['paper_id']);
												$j = 1;
												while ($rate_row = mysql_fetch_array($rates_res)) {
													echo "
													<tr>
														<td style='border-right:1px dashed #ccc'>" . $j . "</td>
														<td>" . $rate_row['quantity'] . "</td><td>$" . $rate_row['price'] . "</td>
														<td><a href='do_del_priceperquantity.php?card_id=" . $_GET['card_id'] . "&item_id=" . $rate_row['card_paper_relation_id'] . "' title='Delete'  onclick=\"return confirm('Are you sure to delete?')\"><img src='" . siteURL . "admin/resources/images/icons/cross.png' alt='Delete' /></a></td>
													</tr>";
												$j++;
												}
												if ($j == 1)
													echo "
													<tr>
														<td style='text-align:center; color:red' align='center' colspan='3'>(No Price Plan Setup)</td>
                                                    </tr>";
											echo "</table>
										</td>
									</tr>
								</table>
							</div>";
						}
						echo '<div style="clear:both"></div>';
					} else
						echo "<div style='border:1px dashed red; padding:4px; color:red' align='center'>Card paper type allocation missing. Please setup paper types from Card-Edit view.</div>";
					?></td>
				</tr>
			</table>
		</div>	
	</div>
</div>
<script type="text/javascript">
	function validate_user() {
		var flag = true;

		if($('#fullname').val() == "") {
			$('#fullname').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#fullname').css('border', '1px solid #d8d9db');

		if($('#username').val() == "") {
			$('#username').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#username').css('border', '1px solid #d8d9db');

		if($('#password').val() == "") {
			$('#password').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#password').css('border', '1px solid #d8d9db');

		if($('#email').val() == "") {
			$('#email').css('border', '1px solid #FF1111');
			flag = false;
		} else
			$('#emai').css('border', '1px solid #d8d9db');

		return flag;
	}
</script>
</body>
</html>
