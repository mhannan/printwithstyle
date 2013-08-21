<div class="body_left">
	<div class="left_navigation">
		<div class="left_nav_heading">
			Our Services
		</div>
		<ul id="left_menu">
			<li>
				<a href="index.php?p=products&cid=1">Wedding Invitations</a>
			</li>
			<li>
				<a href="index.php?p=products&cid=2">Save the Date Cards</a>
			</li>
			<li>
				<a href="index.php?p=products&cid=7">Thank You Cards</a>
			</li>
		</ul>
	</div><!--left_navigation-->
	<?php
	$sql = "SELECT card_id, cat_id, card_thumbnail_path, card_sample_path FROM cards WHERE card_id = (
		SELECT id_card FROM order_detail GROUP BY id_card ORDER BY COUNT( id_card ) DESC LIMIT 1)
	";
	//$top = mysql_query($sql);
	//if ( is_resource($top) && mysql_num_rows(($top))) {
	if ( 1==2 ) {
		$topper = mysql_fetch_object($top);
		$url = get_card_url($topper->cat_id, $topper->card_id);
		$img_path = !empty($topper->card_thumbnail_path) ? $topper->card_thumbnail_path : $topper->card_sample_path;
	?>
	<div class="top_selling_wrapp">
		<div class="top_selling_heading">
			Top Selling Invitation
		</div>
		<div class="top_selling_container">
			<div class="topselling_product">
				<img src="<?php echo SAMPLE_CARDS . $img_path; ?>" style="width: 200px;"/>
			</div>
			<div class="top_selling_product_info">
				Vision Of Love
				<br />
				<span>Weddig Invitation
					<br />
					<?php
					$sql = "
						SELECT DISTINCT quantity, price 
						FROM cards_and_papertype_relation_with_pricing 
						WHERE 
							card_id={$topper->card_id} AND 
							quantity IS NOT NULL AND 
							price IS NOT NULL AND 
							quantity > 1 
						ORDER BY quantity DESC
						LIMIT 1
					";
					$lowest = mysql_query($sql); 
					if ( is_resource($lowest) && mysql_num_fields($lowest)) {
						$lowest_price = mysql_fetch_object($lowest);
						if ( $lowest_price->price != '' ) {
							echo 'As low as $' . $lowest_price->price;
						}
					}
					?></span>
			</div>
		</div>
	</div><!--top_selling-->
	<?php } ?>
	<div class="news_letter_wrapp">
		<div class="newsletter_heading">
			Newsletter Signup
		</div>
		<div class="newsletter_text">
			Receive special discounts, wedding tips, and more!
		</div>
		<script type="text/javascript" src="https://forms.aweber.com/form/84/1155661284.js"></script>
	</div>
	<div class="news_letter_bottom"></div>
</div><!--body_left-->