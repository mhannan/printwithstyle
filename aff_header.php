<?php //error_reporting(0);
	//include('config/config.php');
include ('lib/func.cart.php');
include_once('lib/func.user.php');
include_once('lib/func.user.affiliate.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send With Style</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() 
{
	$("#changep").click(function () {
		
	$(".changediv").toggle();
	});


}); 
</script>





<!-- *************** GrayModel Box Lib ***************** -->
<link type='text/css' href='css/model_popup_box.css' rel='stylesheet' media='screen' />
<!-- IE6 "fix" for the close png image -->
<!--[if lt IE 7]>
<link type='text/css' href='css/model_popup_box_ie.css' rel='stylesheet' media='screen' />
<![endif]-->
<script type="text/javascript" src="js/model_box_popup/jquery.simplemodal.js"></script>
<script type="text/javascript" src="js/model_box_popup/basic.js"></script>
<!-- *************** // GrayModel Box Lib ************** -->







 <script type="text/javascript">
		$(document).ready(function() {
			$("#register").validate({
				submitHandler:function(form) {
					SubmittingForm();
				},
				rules: {
					fname: "required",
					Password: "required",
					//contact_name: "required",
					//contact_phone: "required",
					//address: "required",
					// simple rule, converted to {required:true}
					email: {				// compound rule
						required: true,
						email: true
					},
					url: {
						url: true
					},
					comment: {
						required: true
					}
				},
				messages: {
					comment: "Please enter a comment."
				}
			});
		});

		jQuery.validator.addMethod(
			"selectNone",
			function(value, element) {
				if (element.value == "none")
				{
					return false;
				}
				else return true;
			},
			"Please select an option."
		);

		$(document).ready(function() {
			$("#login").validate({
				submitHandler:function(form) {
					SubmittingForm();
				},
				rules: {
					username: "required",
					password: "required",
					sport: {
						selectNone: true
					}
				}
			});

                        // event page popup form - for users submitting their design
                        $("#eventForm").validate({
				submitHandler:function(form) {
					SubmittingForm();
				},
				rules: {
					fNameTxt: "required",
					lNameTxt: "required",
                                        emailTxt: "required",
                                        designFile: "required",
					sport: {
						selectNone: true
					}
				}
			});
                        //-----------------------------------------------------------
                        // blogPost reply pageform -
                        $("#replyForm").validate({
				submitHandler:function(form) {
					SubmittingForm();
				},
				rules: {
					blogPostReplyTxt: "required"
				}
			});

                        // affiliate login page -
                        $("#affiliate_loginForm").validate({
				submitHandler:function(form) {
					SubmittingForm();
				},
				rules: {
					userEmailTxt: "required",
                                        userPswdTxt: "required"
				}
			});
                        // affiliate password Recovery form
                       $("#affiliate_registerForm").validate({
				submitHandler:function(form) {
					SubmittingForm();
				},
				rules: {
					fName_txt: "required",
                                        lName_txt: "required",
                                        userEmailTxt: "required",

                                        password: {
                                                     required: true,
                                                     minlength: 5
                                                 },
                                        userPswdConfirmTxt: {
                                                     required: true,
                                                     minlength: 5,
                                                     equalTo: "#password"
                                                 }
				}
			});
                        //-----------------------------------------------------------


                        $('.fieldBgTextLabel').click(function(){
                                            $('.fieldBgTextLabel').css('color','#333');
                                            if($('.fieldBgTextLabel').val() == 'Enter Keywords')
                                                     $('.fieldBgTextLabel').val('');
                                     });
                        $('.fieldBgTextLabel').blur(function(){
                                            if($('.fieldBgTextLabel').val() == '')
                                            {
                                                     $('.fieldBgTextLabel').val('Enter Keywords') ;
                                                     $('.fieldBgTextLabel').css('color','#aaa');
                                            }
                                    });

		});
</script>

<script type="text/javascript" src="js/ddsmoothmenu.js">

    /***********************************************
    * Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
    * This notice MUST stay intact for legal use
    * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
    ***********************************************/

</script>

<script type="text/javascript">

    ddsmoothmenu.init({
            mainmenuid: "smoothmenu1", //menu DIV id
            orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
            classname: 'ddsmoothmenu', //class added to menu's outer DIV
            //customtheme: ["#1c5a80", "#18374a"],
            contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
    })

    ddsmoothmenu.init({
            mainmenuid: "smoothmenu2", //Menu DIV id
            orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
            classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
            //customtheme: ["#804000", "#482400"],
            contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
    })

</script>





</head>
<body>
<div class="main_wrapp">
	<div class="top_wrapp">
   		<div class="logo_wrapp">
       		<a href="index.php"><img src="images/logo.png" /></a>
         </div><!--logo_Wrapp-->
         <div class="top_right_options">
                <div class="top_links_wrapp">
                    <div class="home_icon">
                            <a href="index.php"><img src="images/home_icon.png" border="0" /></a>
                    </div>
                    <div class="home_icon">
                            <a href="index.php?p=contact"><img src="images/mail_icon.png" border='0'/></a>
                    </div>
                    <div class="top_phn_num">Toll Free: (866) 594-1226</div>
                </div>
                <div class="top_links_wrapp">
                    <div class="home_icon">
                   <?php if( isset($_SESSION['aff_user_id']) && $_SESSION['aff_user_id'] != "NULL" ){?>
                            <a href="index.php?p=aff_dashboard">Dashboard</a>
                    <?php }else{ ?>
                    		<a href="index.php?p=register">Join Today</a>
                    <?php } ?>
                            
                    </div>
                    <div class="seconglevel">
                   <?php if( isset($_SESSION['aff_user_id']) && $_SESSION['aff_user_id'] != "NULL" ){?>
                            <a href="logout.php">Logout</a>
                    <?php }else{ ?>
                    		<a href="index.php?p=login">Sign In</a>
                    <?php } ?>
                    </div>
                </div>
                <div class="top_links_wrapp">
                    <div class="top_cart_text">
                       Now in your cart <strong><a href="<?php echo siteURL;?>cart.php"><?php echo get_cart_count();?> items</a></strong>
                    </div>
                </div>
                <?php if( isset($_SESSION['aff_user_id']) && $_SESSION['aff_user_id'] != "NULL" ){?>
                 <div class="top_links_wrapp2">
                    <div class="top_welcome_text">
                       Welcome  <strong style="color:#4EB3D1"> <a href="index.php?p=aff_dashboard"><?php echo $_SESSION['aff_name']; ?></a></strong>
                    </div>
                </div>
                <?php } ?>
                </div>      <!--top_right-->
               
         <div class="navigation_wrapp">
             <div id="smoothmenu1" class="ddsmoothmenu" style="float:left; width:770px">
                <ul id="menu">
                    <li><a href="index.php"><span><img src="images/home_icon2.png" /></span></a></li>
                    <li><a href="index.php?p=products&cid=1">Wedding Invitations </a>
                    <ul>
                        <li><a href="index.php?p=products&cid=1">Wedding Invitations</a></li>
                        <li style="border-top:1px dashed #E6E9D4"><a href="index.php?p=products&cid=3">Response Cards</a></li>
                        <li style="border-top:1px dashed #E6E9D4"><a href="index.php?p=products&cid=4">Direction Cards</a></li>
                        <li style="border-top:1px dashed #E6E9D4"><a href="index.php?p=products&cid=5">Accommodation Cards</a></li>
                        <li style="border-top:1px dashed #E6E9D4"><a href="index.php?p=products&cid=6">Multi-Purpose Enclosure Cards</a></li>
                    </ul></li>
                    <li><a href="index.php?p=products&cid=2">Save the Date </a></li>
                    <li><a href="index.php?p=products&cid=7">Thank You Cards </a></li>
                    <li><a href="index.php?p=how_it_works"> How it Works</a></li>
                    <li><a href="index.php?p=aboutus">About Us</a></li>
                </ul><!--menu-->
             </div>


                <form action="index.php?p=search" method="post" name="myForm">
                    <div class="top_search_wrapp">
                        <div class="search_bg"><input name="search_field" type="text" class="search_field fieldBgTextLabel" value="Enter Keywords" /></div>
                          <input name="submit" type="submit" class="search_btn" value="" />
                    </div><!--top_search-->
                </form>

        </div><!--navigatin_wrapp-->
   </div><!--top_wrapp-->
        <div class="body_content_wrapp">

                    <?php if(isset($_GET['p']) && ($_GET['p']=='be_designer'))
                            echo '';
                          elseif(isset($_GET['p']) && ($_GET['p']=='aff_dashboard' || $_GET['p']=='aff_activitylog'|| $_GET['p']=='aff_acc_info'))
                              echo '<div class="top_shop_strip" style="background-image:url(images/icons/affiliate.png); background-repeat:no-repeat; background-position:left;">
                                                <div class="shop_strip_text" style="padding-left:80px"><a href="index.php?p=aff_dashboard">Affiliate Section</a></div></div>';
                          else
                               echo '<div class="top_shop_strip">
                                                <div class="shop_strip_text">Unlimited Access to Thousands of Designs!</div></div>';
                          
                		//<!-- <div class="shop_btn"><a href='index.php'><img src="images/shop_now_btn.png" border="0" /></a></div> -->
                //</div> <!--top_shop_strip-->
                    ?>