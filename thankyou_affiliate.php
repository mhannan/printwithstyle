<div class="body_internal_wrapper">
<?php include("leftsection1.php") ;
      include("lib/func.common.php");
?>

<script language="javascript" type="text/javascript">
    $(document).ready(function(e){

        //$('#affiliate_login').hide();
        $('#loginRecovery').hide();
        //$('#affiliate_register').hide();



        $('#forgotPswd').click(function(e){
            $('#loginRecovery').toggle('slow');
        });
    });
</script>

    
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
 
     <div class="newcontact_information"><!--Contact Informaton-->
           <div class="newodd-contact-main" style="float:none">
               Registration Completed
            </div>
			<div style="margin:10px; padding:20px 0px;">
				Thank you for submitting your application to join the Send With Style affiliate program.  <br /><br />
				If you have any queries please feel free to <a href="index.php?p=contact">contact</a> us.<br/><br/>
                                One of our representatives will contact you via email to get more details about your website and to give you additional information about becoming a Send With Style affiliate. Please log in below to access your account
			</div>


                        <table border="0" id="affiliate_login" cellpadding="0" cellspacing="0" style="background-image:url(images/comment_post_reply_middle_bg.jpg); background-repeat:repeat-y; " width="100%">
                                <tr><td style="background-image:url(images/comment_post_reply_bg.jpg); background-repeat: no-repeat; background-position:top left; padding:20px 15px 0px 15px;">

                                       <form name="affiliate_loginForm" id="affiliate_loginForm" action="do_aff_login.php" method="post">

                                        <div ><h3 style="color:#3C9CC3; text-shadow:-1px -1px 0 #FFFFFF; border-bottom:1px dashed #ccc">Affiliate Login</h3></div>
                                        <div style="margin:20px 80px; padding:20px; background-color:#f4f6e8; border:1px solid #ccc">
                                            <table border="0" cellpadding="6" cellspacing="1">
                                                <tr><td>User Email</td><td><input type="text" name="userEmailTxt" id="userEmailTxt"></td></tr>
                                                <tr><td>Password</td>
                                                    <td><input type="password" name="userPswdTxt" id="userPswdTxt">
                                                        <div style="float:right; margin-left:80px;"><a href="javascript:;" id="forgotPswd">Forgot password?</a></div>
                                                    </td></tr>
                                            </table>
                                        </div>
                                        <div align="right" style="margin-right:100px;"><button style="border:none; background:none" name="submit" id="submit"><img src="images/btn_login_blue.png"/></button></div>
                                       </form>


                                        <div id="loginRecovery">

                                                <h3 style="color:#3C9CC3; text-shadow:-1px -1px 0 #FFFFFF; border-bottom:1px dashed #ccc; margin-top:30px">Recover Password</h3>
                                                <div style="padding:10px 30px">
                                                    <div id="recoveryStatus" style="margin:10px 0px;"></div>
                                                    <div style="width:100px; float:left">Email :</div>
                                                    <div style=" float:left"><input type="text" name="recoveryEmail" id="recoveryEmail"></div>
                                                    <div style="margin-left:30px;float:left"><a href="javascript:;" onclick="sendRecoveredPswdEmail()"><img src="images/btn_send_blue.png"/></a></div>
                                                    <div style="clear:both"></div>
                                                </div>



                                        </div>

                                    </td></tr>
                                <tr><td style="background-image:url(images/comment_post_reply_bottom.jpg); background-repeat:no-repeat; height:11px"></td></tr>
                            </table>

       </div>
      </div><!--home_invitatins_wrapp-->
    </div><!--body_right-->
  </div><!--body_internal_wrapp-->
</div><!--body_conetnt-->

<div id="popup_dialog_register_benefit" style="display:none; font-size:13px; line-height: 20px">
    <h3 style="color:#29748C; padding-left:0px">Welcome!</h3>
            Thanks for creating an account. By creating an account you can save your customized designs, easily place orders, and get notified of special offers.
</div>

<script language="javascript">
   /* $(document).ready(function($){
        $('#popup_dialog_register_benefit').modal({
                close: true,
                            minWidth: 400,
                            minHeight: 200,
                            //overlayCss: {backgroundColor:"#000"},
                            containerCss: {backgroundColor:"#EAEDDC", minHeight:200, minWidth: 400}
            });
    });*/
</script>
