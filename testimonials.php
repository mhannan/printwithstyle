<div class="body_internal_wrapper">
<?php
	include ("leftsection1.php");
	include ("lib/func.testimonial.php");
	$referer = trim($_SERVER['HTTP_REFERER']);
?>

 <script language="javascript">
	function Validate(frm) {
		var flag = true;
		if ($('#testimonialTxt').val() == '') {
			$('#testimonialTxt').css('border', '1px solid red');
			flag = false;
		} else
			$('#testimonialTxt').css('border', '1px solid #ccc');

		return flag;
	}
	<?php
	
	if ( strpos( $referer, 'aW5kZXgucGhwP3A9dGVzdGltb25pYWxz' ) ) {
		?>
		jQuery(document).ready(function($) {
			$('.popup_post_testimonial').trigger('click');
		});
		<?php
	}
	?>
 </script>
 	<div class="body_right"><!--body_right-->
 		<div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
 			<?php
 			if (isset($_GET['msg']) && $_GET['msg'] == "succ") {
				if (isset($_GET['str']))
					echo "<div class='alert_success'><div>" . base64_decode($_GET['str']) . "</div></div>";

			} elseif (isset($_GET['msg']) && $_GET['msg'] == 'err') {
				if (isset($_GET['str']))
					echo "<div class='alert_success'><div>" . base64_decode($_GET['str']) . "</div></div>";
			}
			?>
			<div class="home_wedng_inv_heading">Testimonials
				<div style="float:right;padding-right:10px">
					<a <?php
					if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL")
						echo 'href="javascript:;" class="popup_post_testimonial"';
					else
						echo "href='index.php?p=login&return_url=" . base64_encode('index.php?p=testimonials') . "'";?>>
					<img src="images/btn_testimonial.png" border="0"></a>
				</div>
			</div>
			<?php
			$res = getTestimonials($objDb);
			$i =1;
			if( mysql_num_rows($res) > 0 ) {
				while($row = mysql_fetch_array($res))
				{
					$profile_pic_path = "images/no-photo.jpg";
					if($row['profile_pic_path'] !='')
					$profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];
				?>
				<div class="testimonial_wrapp" style="width:100%; ;margin-bottom:10px;background-image:url(images/icon_qoute_start_blue.png); background-repeat:no-repeat; background-position: top left; padding-left:28px">
					<div class="testimonail_content" style="width:90%">
						<div style="float:left; margin-right:8px"><img border="0" src="<?php echo $profile_pic_path; ?>" width="100px" style="padding:3px; border:1px solid #ccc"></div>
						<div style="float:left; width:550px">
							<strong><?php echo $row['u_name'] == '' ? 'Guest' : $row['u_name'];?></strong>
							<span><?php echo date('d M-Y', strtotime($row['date_posted'])); ?></span>
							<p><?php echo stripslashes($row['testimonial']); ?> </p>
						</div>
					</div>
				</div>
				<?php
				$i++;
				}
			}
			if($i==1)
				echo "<div style='margin:10px 0px'>No testimonials posted yet.</div>";
			?>
		</div>
		<div id="testimonial_post_modal_content" style="display:none">
			<form name="testimonialForm" id="testimonialForm" action="do_save_testimonial.php" method="post" onSubmit="return Validate(this);">
				<div><b>Write Up Your Testimonial</b></div>
				<div style="margin-top:8px; height:150px;padding-left:30px; background-image:url(images/icon_qoute_start_blue.png); background-repeat:no-repeat;background-position:top left"><textarea id="testimonialTxt" name="testimonialTxt" style="width:450px; height:150px"></textarea></div>
				<div style="font-size:10px; margin-top:10px;">**Note: The testimonial will be reviewed by administrator before posting.</div>
				<div align="right"><button style="border:none; background:none;cursor:pointer"><img src="images/btn_submit.png"></button></div>
			</form>
		</div>
	</div><!--body_right-->
</div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
<!--bottom_advertisment-->
<div class="btm_advertise_wrapper">
<!--advertisment-->
<div class="advertisment">
        <a href="index.php?p=affiliate"><img src="images/btm_advertise.png" border="0" /></a>
</div><!--advertisment-->
<!--advertisment-->
<div class="advertisment2">
        <a href="index.php?p=be_designer"><img border="0" src="images/btm_advertise2.png"></a>
</div><!--advertisment-->
</div><!--bottom_advertisment-->