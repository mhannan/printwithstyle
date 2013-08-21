<div class="body_internal_wrapper">
	<?php include("leftsection1.php");
      include("lib/func.page.php"); ?>


	<script language="javascript" type="text/javascript">
    $(document).ready(function(e){

        //$('#affiliate_login').hide();
        $('#loginRecovery').hide();
        //$('#affiliate_register').hide();

        
        $('#aff_login').click(function(e){
            $('#affiliate_login').toggle('slow');
            $('#affiliate_register').hide();
        });


        $('#forgotPswd').click(function(e){
            $('#loginRecovery').toggle('slow');
        });

        $('#aff_join').click(function(e){
            $('#affiliate_register').toggle('slow');
            $('#affiliate_login').hide();
        });


    });

    function sendRecoveredPswdEmail()
        {
            if($('#recoveryEmail').val() != '')
             {
                 $('#recoveryEmail').css('border','1px solid #ccc');
                  $.ajax({
                          type: "POST",
                          data: "email="+$('#recoveryEmail').val(),
                          url : 'ajax_processor/_recover_pswd.php',

                         success:function( msg ){	// in MSG full images HTML will be returned only need to disply that in target area
                                    $('#recoveryStatus').html(msg);
                                    alert(msg);
                               }
                  });
             }
            else
                $('#recoveryEmail').css('border','1px solid red');
        }
</script>


	<div class="body_right">
		<!--body_right-->

		<div class="home_wedng_inv_wrapp">
			<!--home_invitatins_wrapp-->
			<div class="home_wedng_inv_heading">
				<?php echo 'Affiliate Program'; ?>
			</div>

			<?php
			$content = getPage_content_by_slug($_GET['p']);

			echo "<div style='margin:10px 0px'>".$content."</div>";
			?>


			<div style="margin-top: 30px">
				<div style="float: left">
					<img src="images/btn_join_affiliate.png" id="aff_join"
						style="cursor: pointer" alt="" />
				</div>
				<div style="float: right">
					<img src="images/btn_login_affiliate.png" id="aff_login"
						style="cursor: pointer" alt="" />
				</div>
				<div style="clear: both"></div>
			</div>




			<?php

			if(isset($_GET['msg']) && $_GET['msg']  == "succ")
			{
				if(isset($_GET['str']))
					echo "<div class='alert_success'><div>".base64_decode($_GET['str'])."</div></div>";

			}
			elseif(isset($_GET['msg']) && $_GET['msg'] == 'err')
			{
				if(isset($_GET['str']))
					echo "<div class='alert_err'><div>".base64_decode($_GET['str'])."</div></div>";

			}


			?>

			<!-- ######################################################################### -->
			<!-- Affiliate Login -->

			<table border="0" id="affiliate_login" cellpadding="0"
				cellspacing="0"
				style="
                                background-image: url('images/comment_post_reply_middle_bg.jpg'); 
                                background-repeat: repeat-y; 
                                <?php echo (isset($_GET['action']) && $_GET['action'] == 'login') ? 'display: block;' : 'display: none;'; ?>
                                " width="735px">
				<tr>
					<td
						style='background-image: url(images/comment_post_reply_bg.jpg); background-repeat: no-repeat; background-position: top left; padding: 20px 15px 0px 15px;'>

						<form name="affiliate_loginForm" id="affiliate_loginForm" autocomplete="off"
							action="do_aff_login.php" method="post" style="width: 705px">

							<div>
								<h3
									style="color: #3C9CC3; text-shadow: -1px -1px 0 #FFFFFF; border-bottom: 1px dashed #ccc">Affiliate
									Login</h3>
							</div>
							<div
								style="margin: 20px 80px; padding: 20px; background-color: #f4f6e8; border: 1px solid #ccc">
								<table border="0" cellpadding="6" cellspacing="1">
									<tr>
										<td>User Email</td>
										<td><input type="text" name="userEmailTxt" id="userEmailTxt">
										</td>
									</tr>
									<tr>
										<td>Password</td>
										<td><input type="password" name="userPswdTxt" id="userPswdTxt">
											<div style="float: right; margin-left: 80px;">
												<a href="javascript:;" id="forgotPswd">Forgot password?</a>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<div align="right" style="margin-right: 100px;">
								<button style="border: none; background: none" name="submit"
									id="submit">
									<img src="images/btn_login_blue.png" alt="" />
								</button>
							</div>
						</form>


						<div id="loginRecovery">

							<h3
								style="color: #3C9CC3; text-shadow: -1px -1px 0 #FFFFFF; border-bottom: 1px dashed #ccc; margin-top: 30px">Recover
								Password</h3>
							<div style="padding: 10px 30px">
								<div id="recoveryStatus" style="margin: 10px 0px;"></div>
								<div style="width: 100px; float: left">Email :</div>
								<div style="float: left">
									<input type="text" name="recoveryEmail" id="recoveryEmail">
								</div>
								<div style="margin-left: 30px; float: left">
									<a href="javascript:;" onclick="sendRecoveredPswdEmail()"><img
										src="images/btn_send_blue.png" alt="" />
									</a>
								</div>
								<div style="clear: both"></div>
							</div>



						</div>

					</td>
				</tr>
				<tr>
					<td
						style='background-image: url(images/comment_post_reply_bottom.jpg); background-repeat: no-repeat; height: 11px'></td>
				</tr>
			</table>


			<!-- ######################################################################### -->
			<!-- Affiliate Register -->



			<table border="0" id="affiliate_register" cellpadding="0"
				cellspacing="0"
				style="background-image: url(images/comment_post_reply_middle_bg.jpg); background-repeat: repeat-y; &amp; amp; lt; ? php if(isset($_GET['action']) &amp;amp; amp; &amp; amp; amp; $ _GET ['action']=='reg') echo '; display: block '; else echo '; display: none';"
				width="735px">
				<tr>
					<td
						style='background-image: url(images/comment_post_reply_bg.jpg); background-repeat: no-repeat; background-position: top left; padding: 20px 15px 0px 15px;'>

						<form name="affiliate_registerForm" id="affiliate_registerForm" autocomplete="off"
							action="do_aff_register.php" method="post" style="width: 705px">

							<div>
								<h3
									style="color: #3C9CC3; text-shadow: -1px -1px 0 #FFFFFF; border-bottom: 1px dashed #ccc">Join
									Our Affiliate Program</h3>
							</div>
							<div
								style="margin: 20px 80px; padding: 20px; background-color: #f4f6e8; border: 1px solid #ccc">
								<table border="0" cellpadding="6" cellspacing="1">
									<tr>
										<td>First Name</td>
										<td><input type="text" name="fName_txt" id="fName_txt">
										</td>
									</tr>
									<tr>
										<td>Last Name</td>
										<td><input type="text" name="lName_txt" id="lName_txt">
										</td>
									</tr>
									<tr>
										<td>User Email</td>
										<td><input type="text" name="userEmailTxt" id="userEmailTxt">
										</td>
									</tr>
									<tr>
										<td>Password</td>
										<td><input type="password" name="password" id="password">
										</td>
									</tr>
									<tr>
										<td>Retype Password</td>
										<td><input type="password" name="userPswdConfirmTxt"
											id="userPswdConfirmTxt">
										</td>
									</tr>
								</table>
							</div>
							<div align="right" style="margin-right: 100px;">
								<button style="border: none; background: none" name="submit"
									id="submit">
									<img src="images/btn_join_blue.png" alt="" />
								</button>
							</div>
						</form>


					</td>
				</tr>
				<tr>
					<td
						style='background-image: url(images/comment_post_reply_bottom.jpg); background-repeat: no-repeat; height: 11px'></td>
				</tr>
			</table>


		</div>
		<!--home_invitatins_wrapp-->

	</div>
	<!--body_right-->
</div>
<!--body_internal_wrapp-->
<div></div>
<!--body_conetnt-->
<!--bottom_advertisment-->
<div
	class="btm_advertise_wrapper">
	<!--advertisment-->
	<div class="advertisment">
		<a href="index.php?p=affiliate"><img src="images/btm_advertise.png"
			border="0" alt="" /> </a>
	</div>
	<!--advertisment-->
	<!--advertisment-->
	<div class="advertisment2">
		<a href="index.php?p=be_designer"><img border="0"
			src="images/btm_advertise2.png" alt=""> </a>
	</div>
	<!--advertisment-->
</div>
<!--bottom_advertisment-->
