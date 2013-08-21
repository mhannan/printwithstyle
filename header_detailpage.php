<?php
include ('config/config.php');
include ('lib/func.products.php');
include ('lib/func.cart.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Send With Style</title>
		<meta http-equiv="Access-Control-Allow-Origin" content="*">
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<script src="js/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		<script type="text/javascript" src="<?php echo siteURL . "js/thickbox-compress.js";?>"></script>
		<link href="<?php echo siteURL . "css/thickbox.css";?>" rel="stylesheet" type="text/css" />
		
		
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function($) {
				$("#changep").click(function() {
					$(".changediv").toggle();
				});

				$("a#card_large_preview").fancybox();

				$('.reviews_block').hide();
				var review_images = new Array();
				review_images[0] = "images/review_expand_img.png";
				review_images[1] = "images/review_close_img.png";
				$('.reviiew_hide_wrapp').click(function() {
					
					$('.reviews_block').toggle();
					
					/* check the review button image*/
					var img_src = $(this).find('img').attr('src');
					if ( img_src == review_images[0] ) {
						$(this).find('img').attr('src', review_images[1]);
					} else if ( img_src = review_images[1] ) {
						$(this).find('img').attr('src', review_images[0]);
					}
				})
				
				/* attach email to friend popup here */
				$("div.mailfrnd_wrapp").css({'cursor' : 'pointer'});
				$("div.mailfrnd_wrapp").live ('click', function() {
					var item_id = "<?php echo $_REQUEST['item_id']; ?>";
					tb_show("Email to Friend", "<?php echo siteURL; ?>/email-to-friend.php?item_id="+item_id+"&KeepThis=true&TB_iframe=true&width=800&height=500&modal=true", null);
				});
				
				$("div.fav_wrapp").css({'cursor' : 'pointer'});
				$("div.fav_wrapp").live ('click', function() {
					<?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL" ){ ?>
					$.post(
						'<?php echo siteURL; ?>process-ajax.php',
						{
							call : 'add_to_favorite',
							item_id : "<?php echo $_REQUEST['item_id']; ?>",
							id_customer : "<?php echo $_SESSION['user_id'];?>"
						},
						function(ret) {
							alert(ret);
						}
					);
					<?php } else { ?>
						self.location.href =  "<?php echo siteURL;?>?p=login";
					<?php } ?>
				});
			});

		</script>
		<script type="text/javascript">
		
			jQuery(document).ready(function($) {
				
				$("#register").validate({
					submitHandler : function(form) {
						SubmittingForm();
					},
					rules : {
						fname : "required",
						Password : "required",
						contact_name : "required",
						contact_phone : "required",
						address : "required",
						// simple rule, converted to {required:true}
						email : {// compound rule
							required : true,
							email : true
						},
						url : {
							url : true
						},
						comment : {
							required : true
						}
					},
					messages : {
						comment : "Please enter a comment."
					}
				});
				
			});

			jQuery.validator.addMethod("selectNone", function(value, element) {
				if(element.value == "none") {
					return false;
				} else
					return true;
			}, "Please select an option.");

			$(document).ready(function() {
				$("#login").validate({
					submitHandler : function(form) {
						SubmittingForm();
					},
					rules : {
						username : "required",
						password : "required",
						sport : {
							selectNone : true
						}
					}
				});

				$('.fieldBgTextLabel').click(function() {
					$('.fieldBgTextLabel').css('color', '#333');
					if($('.fieldBgTextLabel').val() == 'Enter Keywords')
						$('.fieldBgTextLabel').val('');
				});
				$('.fieldBgTextLabel').blur(function() {
					if($('.fieldBgTextLabel').val() == '') {
						$('.fieldBgTextLabel').val('Enter Keywords');
						$('.fieldBgTextLabel').css('color', '#aaa');
					}
				});

			});

		</script>
	</head>
	<body style="background:url('images/bg4.jpg');">
		<div class="main_wrapp">
			<div class="top_wrapp_detailpage">
				<div class="logo_wrapp">
					<a href="index.php"><img src="images/weddingprintingsdotcom.png" /></a>
				</div><!--logo_Wrapp-->
				<div class="top_right_options">
					<div class="top_links_wrapp">
						<div class="home_icon">
							<a href="index.php"><img src="images/home_icon.png" border="0" /></a>
						</div>
						<div class="home_icon">
							<a href="index.php?p=contact"><img src="images/mail_icon.png" border='0'/></a>
						</div>
						<div class="top_phn_num"></div>
					</div>
					<div class="top_links_wrapp">
						<div class="home_icon">
							<?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL" ){ ?>
							<a href="index.php?p=update_account">My Account</a>
							<?php }else{ ?>
							<a href="index.php?p=register">Join Today</a>
							<?php } ?>
						</div>
						<div class="seconglevel">
							<?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL" ){ ?>
							<a href="index.php?p=logout">Logout</a>
							<?php }else{ ?>
							<a href="index.php?p=login">Sign In</a>
							<?php } ?>
						</div>
					</div>
					<div class="top_links_wrapp">
						<div class="top_cart_text" style="float:right">
							Now in your cart <strong><a href="<?php echo siteURL;?>cart.php"><?php echo get_cart_count();?> items</a></strong>
						</div>
					</div>
					<?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] != "NULL" ){ ?>
					<div class="top_links_wrapp2">
						<div class="top_welcome_text">
							Welcome <strong style="color:#4EB3D1"> <a href="index.php?p=update_account"><?php echo $_SESSION['userName']; ?></a></strong>
						</div>
					</div>
					<?php } ?>
				</div>
				<!--top_right-->

			</div><!--top_wrapp-->