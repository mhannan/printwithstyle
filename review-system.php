<?php
function generate_rating_images($rating) {
	$str = "";
	for($i = 1; $i <= 5; $i++ ) {
		$src = $i <= $rating ? 'star_on' : 'star_of';
		$str .= "<img src='images/{$src}.png'>";
	}
	return $str;
}
?>
<div class="reviiew_hide_wrapp">
	<img src="images/review_expand_img.png" style="cursor:pointer" />
</div>
<div class="reviews_block">
	<div style="padding-left:30px; padding-right:50px">
		<table border="0" cellpadding="3" cellspacing="0" width="100%" style="border-bottom:1px dashed #fff">
			<?php
			$sql = "
			SELECT 
				reviews.*,
				register_users.u_name 
			FROM reviews 
			INNER JOIN register_users ON register_users.id = reviews.id_customer
			WHERE 
				reviews.id_card = {$_REQUEST['item_id']} 
			ORDER BY reviews.rating DESC
			";
			$ratings = mysql_query($sql); 
			if ( is_resource( $ratings ) && mysql_num_rows( $ratings ) ) {
				while ($review = mysql_fetch_object( $ratings ) ) {
					?>
					<tr>
						<td width="50%">
							<b><?php echo $review->u_name; ?></b>
							<br>
							<?php echo date( 'd M, Y', strtotime( $review->datetime ) );?>
						</td>
						<td align="right">
							<b>Rating:</b>
							<?php echo generate_rating_images($review->rating);?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-bottom:1px dotted #aaa; color:#666"><?php echo $review->review; ?></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
		<?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL" ){ ?>
		<table border="0" cellpadding="3" cellspacing="0" width="100%" style=" margin-top: 50px" id="tbl_review">
			<tr>
				<td colspan="2" style="color:#666">
					<h3>Write Review:</h3>
					<textarea id="review" name="review" style="width:800px; height:80px"></textarea>
				</td>
			</tr>
			<tr>
				<td width="10%">
					<img src="images/star_on.png"> <b>Rating:</b>
				</td>
				<td align="left">
					<style>label {padding-right: 20px;}</style>
					<input type="radio" id="r1" name="rating" value="1">
					<label for="r1">1</label>
					
					<input type="radio" id="r2" name="rating" value="2">
					<label for="r2">2</label>
					
					<input type="radio" id="r3" name="rating" value="3">
					<label for="r3">3</label>
					
					<input type="radio" id="r4" name="rating" value="4">
					<label for="r4">4</label>
					
					<input type="radio" id="r5" name="rating" value="5" checked="checked">
					<label for="r5">5</label>
					<style>label {padding-right: auto;}</style>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td align="right" style="padding-right:50px">
					<button id="btnReview" name="submit" style="border:none; background:none"><img src="images/btn_post.png"></button>
				</td>
			</tr>
		</table>
		<?php } else {
			$cur_url = end(explode('/', $_SERVER['REQUEST_URI']));
			$return_url = base64_encode($cur_url);//aW5kZXgucGhwP3A9dGVzdGltb25pYWxz
			echo "<a href='index.php?p=login&return_url=$return_url'>Login to add Review</a>";
			?>
		<?php } ?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$("#btnReview").live ('click', function() {
					if ( $("#review").val() == '' ) {
						alert("Provide your review please.");
						return false; 
					}
					
					$.post(
						'process-ajax.php',
						{
							call : 'save_review',
							id_card : '<?php echo $_REQUEST['item_id']; ?>',
							review : $("#review").val(),
							rating : $('input:radio[name=rating]:checked').val(),
							id_customer : '<?php echo $_SESSION['user_id']; ?>'
						},
						function (ret) {
							if ( ret == 'added' ) {
								alert("You review is submitted. Will be available shortly.");
								$("#tbl_review").remove();
							} else {
								alert(ret);
							}
						}
					);
				});
			});
		</script>
	</div>
</div>