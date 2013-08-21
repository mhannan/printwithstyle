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
				if ($card_bg_name != "")
					echo '<div align="right"><input class="button" type="submit" value="Save Pane Setting & Active Card" /></div>';
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
					
					?>
					<input type="hidden" name="content_container_dimension[1]" id="content_container1_dimension" value="<?php echo isset($card_settings[0]['content_container_dimension']) ? $card_settings[0]['content_container_dimension'] : NULL;?>" >
					<input type="hidden" name="content_container_position[1]" id="content_container1_position" value="<?php echo isset($card_settings[0]['content_container_position']) ? $card_settings[0]['content_container_position'] : NULL;?>" >
					<input type="hidden" name="content_container_dimension[2]" id="content_container2_dimension" value="<?php echo isset($card_settings[1]['content_container_dimension']) ? $card_settings[1]['content_container_dimension'] : NULL;?>" >
					<input type="hidden" name="content_container_position[2]" id="content_container2_position" value="<?php echo isset($card_settings[1]['content_container_position']) ? $card_settings[1]['content_container_position'] : NULL;?>" >
					
					<input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">
					<input type="hidden" name="card_id" value="<?php echo $_REQUEST['card_id']; ?>">
					
					<?php
					if ($cat_id == '1' || $cat_id == '3') {       // for wedding Card we need 3rd hidden block also to save diemension/size
					?>
						<input type="hidden" name="content_container_dimension[3]" id="content_container3_dimension" value="<?php echo isset($card_settings[2]['content_container_dimension']) ? $card_settings[2]['content_container_dimension'] : NULL;?>" >
						<input type="hidden" name="content_container_position[3]" id="content_container3_position" value="<?php echo isset($card_settings[2]['content_container_position']) ? $card_settings[2]['content_container_position'] : NULL;?>" >
					<?php
						$blockCounter = 3;
					}
					else
						// if category id is not 1 / 3 for non-wedding card then set counter block to 2 as for other cards we only need two blocks
						$blockCounter = 2;
					?>
					
					<input type="hidden" name="blocksCounter" value="<?php echo $blockCounter; ?>" id="blocksCounter">

					<div id="page_workArea"  style="overflow:hidden; position: relative; float:left; background-image:url('<?php echo BLANK_CARDS . $card_bg_name; ?>'); <?php echo $PanWidth . $PanHeight; ?> ">

						<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
						<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-ui.js"></script>
						<!-- color picker includes -->
						<link rel="stylesheet" href="<?php echo JS_PATH;?>colorpicker/css/colorpicker.css" type="text/css" />
						<script type="text/javascript" src="<?php echo JS_PATH;?>colorpicker/js/colorpicker.js"></script>

						<?php
						if ($cat_id == '1' || $cat_id == '3') {       // for wedding Card
						
							if ( count( $card_settings ) ) {
								$drag_box1 = $card_settings[0];
								$drag_box2 = $card_settings[1];
								$drag_box3 = $card_settings[2];
								/* drag box one*/
								$dimension = explode( '_', $drag_box1['content_container_dimension'] );
								$position = explode( '_', $drag_box1['content_container_position'] );
								$box_1 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px;";
								/* drag box two */
								$dimension = explode( '_', $drag_box2['content_container_dimension'] );
								$position = explode( '_', $drag_box2['content_container_position'] );
								$box_2 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px;";
								/* drag box three */
								$dimension = explode( '_', $drag_box3['content_container_dimension'] );
								$position = explode( '_', $drag_box3['content_container_position'] );
								$box_3 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px;";
								
							} else {
								
								$box_1 = $box_2 = $box_3 = $box_style;
							}
						?>
							<div class="card_content_holder_mobile" id="b1" onclick="showOptionPanel('b1')" style="<?php echo $box_1; ?> position: relative; float: left;">
								<span>INTRO<br>CONTENT BLOCK</span>
							</div>
							<div class="card_content_holder_mobile" id="b2" onclick="showOptionPanel('b2')" style="<?php echo $box_2; ?> position: relative; float: left;">
								<span>MIDDLE<br>CONTENT BLOCK</span>
							</div>
							<div class="card_content_holder_mobile" id="b3" onclick="showOptionPanel('b3')" style="<?php echo $box_3; ?> position: relative; float: left;">
								<span>FOOTER<br>CONTENT BLOCK</span>
							</div>
						<?php
						} else {
							if ( count( $card_settings ) ) {
								$drag_box1 = $card_settings[0];
								$drag_box2 = $card_settings[1];
								/* drag box one*/
								$dimension = explode( '_', $drag_box1['content_container_dimension'] );
								$position = explode( '_', $drag_box1['content_container_position'] );
								$box_1 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px;";
								/* drag box two */
								$dimension = explode( '_', $drag_box2['content_container_dimension'] );
								$position = explode( '_', $drag_box2['content_container_position'] );
								$box_2 = "width: {$dimension[0]}px; height: {$dimension[1]}px; left: {$position[0]}px; top: {$position[1]}px;";
								
							} else {
								
								$box_1 = $box_2 = $box_style;
							}
							
						?>
							<div class="card_content_holder_mobile" id="b1" onclick="showOptionPanel('b1')" style="<?php echo $box_1; ?>position: relative; float: left;">
								<span>TEXT<br>CONTENT<br>BLOCK</span>
							</div>
							<div class="card_content_holder_mobile" id="b2" onclick="showOptionPanel('b2')" style="<?php echo $box_2; ?>position: relative; float: left;">
								<span>TEXT<br>CONTENT<br>BLOCK</span>
							</div>
						<?php
						}
						?>
						<script language="javascript">
							$(document).ready(function(){
								$('.card_content_holder_mobile')
									.draggable({ 
										snap:true, 
										snapTolerance:10, 
										containment: 'parent', 
										stop: function (event, ui) {
											//console.log(event);
											//console.log(ui);
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
									},
									onBeforeShow: function () {
										$(this).ColorPickerSetColor(this.value);
									},
									onChange: function (hsb, hex, rgb) {
										$(this).ColorPickerSetColor(hex);
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
								if(blockSelected_id == 'b2')
									$('#block2OptionPanel').show();
								if(blockSelected_id == 'b3')
									$('#block3OptionPanel').show();
							}
						</script>
					</div>
					<?php
						$displayProperty = "";
						for ($i = 1; $i <= $blockCounter; $i++) {
							$b = $i - 1;
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
	
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Line Height/Spacing:</legend>
										<input type="text" name="line_height[<?php echo $i; ?>]" id="b<?php echo $i; ?>_line_height" value="<?php echo isset($card_settings[$b]['line_height']) ? $card_settings[$b]['line_height'] : NULL;?>">&nbsp;px
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Font Size:</legend>
										<input type="text" name="font_size[<?php echo $i; ?>]" id="b<?php echo $i; ?>_font_size" value="<?php echo isset($card_settings[$b]['font_size']) ? $card_settings[$b]['font_size'] : NULL;?>">&nbsp;px
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Font Style:</legend>
										<div style="height:150px; overflow:scroll">
											<?php echo generate_fonts_HTML_element('font_items['.$i.'][]', 'b1' . $i . '_font_items', 'checkbox', isset( $card_settings[$b]['font_items'] ) ? $card_settings[$b]['font_items'] : NULL ); ?>
										</div>
									</fieldset>
									<fieldset style="padding-bottom:10px; border-bottom: dotted 1px #ccc; ">
										<legend>Font Color:</legend>
										<input type="text" class="txt_font_color" name="font_color[<?php echo $i; ?>]" id="b<?php echo $i; ?>_font_color" value="<?php echo isset($card_settings[$b]['font_color']) ? $card_settings[$b]['font_color'] : NULL;?>">
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
