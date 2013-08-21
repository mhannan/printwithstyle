<?php
if ( isset( $_REQUEST['previous'] ) && $_REQUEST['previous'] ) {
	$_REQUEST = $_SESSION['wed']['step2'];
} else {
	$_SESSION['wed']['step1'] = $_REQUEST;
}
/* merge both requests */
$_REQUEST = array_merge( $_SESSION['wed']['step1'], $_REQUEST );

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

<div class="body_internal_wrapper">
	<div class="process_step_wrapp">
		<img src="<?php echo siteURL;?>images/who.png" />
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
		<div class="detail_big_img_wrapp" style="width: <?php echo $left_width; ?>">
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
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$(".personalized_btn_back").live ('click', function() {
					$("#previous").val('1');
					$("#step").val('step1');
				});
				
				$(".personalized_btn").live ('click', function() {
					var is_valid = false; 
					var _wording_key = '';
					
					$("ul.ul_main li ol li input").each( function(){
						if ( $(this).is(':checked') ) {
							_wording_key = $(this).attr('value');
							is_valid = true;
						} 
					});
					
					if ( is_valid ) {
						
						if ( $("input:radio[name="+_wording_key+"]").is(":checked") ) {
							return true;
						} else {
							alert("Select your wording style please.");
							return false;
						}
						
					} else {
						alert("Select your wording type please.");
						return false;
					}
				});
			});
		</script>
	<form name="frm_step2" id="frm_step2" autocomplete="off" method="post">
		<input type="hidden" name="item_id"value="<?php echo $_REQUEST['item_id'];?>" />
		<input type="hidden" id="step" name="step" value="step3" />
		<input type="hidden" id="previous" name="previous" value="0" />
		<input type="hidden" name="paper_type"value="<?php echo $_REQUEST['paper_type'];?>" />
		<input type="hidden" name="qty_price"value="<?php echo $_REQUEST['qty_price'];?>" />
		<div class="detail_page_innerheading">
			First, Let Me Know Who is Hosting
		</div>
		<div class="detrail_page_desc">
			<p>
				The hosting scenario for your wedding will help me determine the etiquette, wording and layout of your text.
			</p>
			<style type="text/css">
				ul.ul_main {
					clear: both;
					float: left;
					list-style: none; 
					padding: 5px;
					margin: 5px;
					margin-bottom: 10px;
				}
				
				ul.ul_main li {
					cursor: pointer;
					width: 300px;
				}
				
				ul.ul_main li:hover {
					color: #B860D2;
				}
				
				ul.ul_main li.active {
					float: left;
					color: #B860D2;
				}
				
				ul.ul_main li ol {
					clear: both;
				    display: none;
				    float: left;
				    list-style: none outside none;
				    margin: 2px;
				    padding-left: 25px;
				}
				
				ul.ul_main li ol li {
					clear: both;
					float: left;
					color: #717171;
				}
				
				ul.ul_main li ol li:hover {
					color: #B860D2;
				}
				
				div.wedding_wordings {
				    padding: 10px;
				    width: auto;
				    display:none;
				}
				
				div.wedding_wordings label {
					float: left; 
					clear: both;
				}
				div.wedding_wordings p {
					border: 1px solid #797979;
				    border-radius: 4px 4px 4px 4px;
				    clear: both;
				    display: block;
				    float: left;
				    margin: 0;
				    padding: 10px;
				    width: 300px;
				}
				div.wedding_wordings h1 {
				    font-size: 16px;
					margin: 0;
					padding: 0;
				}
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$("ul.ul_main li").live ('click', function() {
						if ( $(this).parent().attr('class') == 'ul_main' ) {
							$("ul.ul_main li").removeClass('active');
							$(this).addClass('active');
							
							$("ul.ul_main li > ol").hide();
							$(this).find('ol').show();
						}
					});
					
					$("ol.ul_sub li > input").each (function() {
						
						if ( $(this).is(":checked") ) {
							var $w_li_parent = $(this).parent().parent().parent(); 
							/* add class to main wording li*/
							$("ul.ul_main li").removeClass('active');
							$w_li_parent.addClass('active');
							/* show to main wording ol */
							$("ul.ul_main li > ol").hide();
							$w_li_parent.find('ol').show();
							/* show wording style */
							var _wording_id = "#" + $(this).parent().attr('rel');
							$("div.wedding_wordings").hide();
							
							//$("div.wedding_wordings").find('input').each(function() {
								//$(this).prop('checked', false);
							//});
							
							$(_wording_id).show();
						} 
					});
					
					$("ol.ul_sub li > input ").live ('click', function() {
						var _wording_id = "#" + $(this).parent().attr('rel');
						$("div.wedding_wordings").hide();
						
						$("div.wedding_wordings").find('input').each(function() {
							$(this).prop('checked', false);
						});
						
						$(_wording_id).show();
					});
					
					
				});
			</script>
			<?php extract($_REQUEST); ?>
			<ul class="ul_main">
				<li class='active'>Couple and Parents Hosting
					<ol class="ul_sub">
						<li rel="couples_parents_names">
							<input type="radio" id="one" name="hosting_type" value="couples_parents_names" <?php echo isset( $hosting_type ) && $hosting_type == "couples_parents_names" ? 'checked="checked"' : NULL;?>  />
							<label for="one">Couples' and Parents' Names</label>
						</li>
						<li rel="couples_names_only">
							<input type="radio" id="two" name="hosting_type" value="couples_names_only" <?php echo isset( $hosting_type ) && $hosting_type == "couples_names_only" ? 'checked="checked"' : NULL;?> />
							<label for="two">Couples' Names Only</label>
						</li>
					</ol>
				</li>
				<li>Bride's and Groom's Parents Hosting 
					<ol class="ul_sub">
						<li rel="bride_groom_standard">
							<input type="radio" id="three" name="hosting_type" value="bride_groom_standard" <?php echo isset( $hosting_type ) && $hosting_type == "bride_groom_standard" ? 'checked="checked"' : NULL;?> />
							<label for="three">Standard</label>
						</li>
						<li rel="bride_groom_4set">
							<input type="radio" id="four" name="hosting_type" value="bride_groom_4set" <?php echo isset( $hosting_type ) && $hosting_type == "bride_groom_4set" ? 'checked="checked"' : NULL;?> />
							<label for="four">4 Sets of Parents</label>
						</li>
					</ol>
				</li>
				<li>Bride's Parents Hosting 
					<ol class="ul_sub">
						<li rel="bride_parent_standard">
							<input type="radio" id="five" name="hosting_type" value="bride_parent_standard" <?php echo isset( $hosting_type ) && $hosting_type == "bride_parent_standard" ? 'checked="checked"' : NULL;?> />
							<label for="five">Standard</label>
						</li>
						<li rel="bride_parent_2set">
							<input type="radio" id="six" name="hosting_type" value="bride_parent_2set" <?php echo isset( $hosting_type ) && $hosting_type == "bride_parent_2set" ? 'checked="checked"' : NULL;?> />
							<label for="six">2 sets of Parents</label>
						</li>
					</ol>
				</li>
				<li>Groom's Parents Hosting 
					<ol class="ul_sub">
						<li rel="groom_parent_standard">
							<input type="radio" id="seven" name="hosting_type" value="groom_parent_standard" <?php echo isset( $hosting_type ) && $hosting_type == "groom_parent_standard" ? 'checked="checked"' : NULL;?> />
							<label for="seven">Standard</label>
						</li>
						<li rel="groom_parent_2set">
							<input type="radio" id="eight" name="hosting_type" value="groom_parent_2set" <?php echo isset( $hosting_type ) && $hosting_type == "groom_parent_2set" ? 'checked="checked"' : NULL;?> />
							<label for="eight">2 sets of Parents</label>
						</li>
					</ol>
				</li>
				<li>Couple Hosting
					<ol class="ul_sub">
						<li rel="couple_hosting_standard">
							<input type="radio" id="nine" name="hosting_type" value="couple_hosting_standard" <?php echo isset( $hosting_type ) && $hosting_type == "couple_hosting_standard" ? 'checked="checked"' : NULL;?> />
							<label for="nine">Standard</label>
						</li>
					</ol>
				</li>
			</ul>
		</div>
		
		<div class="detrail_page_desc">
			<?php
			
			foreach($wedding_wordings as $key => $val ) {
				$i = 0;
				?>
				<div class="wedding_wordings" id="<?php echo $key;?>">
					<?php
					foreach( $val as $v ) {
						if ( $i > 1 ) {
							continue;
						} 
						$v = nl2br(trim($v));
						$style = isset($hosting_type) && $key == $hosting_type ? $_REQUEST[$hosting_type] : NULL;
						$h1 = $i == 0 ? 'Formal' : 'Casual';
						$sel = !is_null($style) && $style == $h1 ? ' checked="checked" ' : NULL;
						$id = "{$key}_rbo_{$i}";
						echo "
						<label for='$id'>
							<h1>$h1
							<input type='radio' id='$id' name='$key' value='$h1' $sel />
							</h1>
							<p>$v</p>
						</label><br/><br/><br/>
						";
						$i++;
					}
				?>
				</div>
				<?php
			}
			 
			?>
		</div>

		<div class="personalized_btn_wrapp">
			<input name="" type="submit" class="personalized_btn" value="Continue"/>
			<input name="" type="submit" class="personalized_btn_back" value="Previous"/>
			
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
