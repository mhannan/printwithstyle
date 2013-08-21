<?php
//include("lib/func.common.php");
include ("lib/func.user.orders.php");
include ("lib/func.user.php");
$user_id = $_SESSION['user_id'];
$res = $objDb -> SelectTable(USERS, "*", "id='$user_id'");
$row = mysql_fetch_array($res);
$msg = $_GET['msg'];
?>
<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
<div class="body_internal_wrapper">
	<?php 
	$profile_pic_path = "images/no-photo.jpg";
 if($row['profile_pic_path'] !='')
				$profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];
	
	include("leftsection_member.php")
	?>
	<div class="body_right">
		<!--body_right-->
		<div class="home_wedng_inv_wrapp">
			<!--home_invitatins_wrapp-->
			<table border="0" cellpadding="4" cellspacing="1" width="100%" bgcolor="#eee" class="listing_tbl" style="margin-top:10px">
				<tr>
					<th style='width: 50px;'>Sr#</th>
					<th>Title</th>
					<th style='width: 100px;'>Action</th>
				</tr>
				<?php
					$res = get_favorites();
					if ( $res ) {
						$i= 1;
						while( $row = mysql_fetch_object( $res ) ) {
							$url = get_card_url($row->cat_id, $row->card_id);
							echo "
							<tr>
								<td>{$i}</td>
								<td>{$row->card_title}</td>
								<td>
									<a href='{$url}'>[View]</a>&nbsp;
									<a href='#delete' class='delete' id='{$row->favorit_id}'>[Delete]</a>
								</td>
							</tr>
							";
						$i++;
						} // while closing 
					} else {
						echo "<tr><td colspan='3' align='center'>You don't have any favorite.</td>";
					}
					?>
					<script type='text/javascript'>
						jQuery(document).ready(function($){
							$("a.delete").live ('click', function() {
								if ( confirm("Are you sure to delete?") ) {
									$(this).parent().parent().fadeOut();
									$.post(
										'process-ajax.php',
										{
											call : 'delete_from_favorite',
											item_id : this.id,
											id_customer : "<?php echo $_SESSION['user_id']; ?>" 
										}
									);
								}
							});
						});
					</script>
			</table>
		</div><!--home_invitatins_wrapp-->
	</div><!--body_right-->
</div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
