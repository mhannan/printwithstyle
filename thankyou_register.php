<div class="body_internal_wrapper">
<?php include("leftsection1.php") ;
      include("lib/func.common.php");
?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
 
     <div class="newcontact_information"><!--Contact Informaton-->
           <div class="newodd-contact-main" style="float:none">
               Registration Completed
            </div>
			<div style="margin:10px; padding:20px 0px;">
				Thankyou for registering with us your registration has been completed successfully and your account is ready to use. Please <a href="index.php?p=login">click here</a> to login and access your account.<br /><br />
				If you have any queries please feel free to <a href="index.php?p=contact">contact</a> us.
			</div>        
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
    $(document).ready(function($){
        $('#popup_dialog_register_benefit').modal({
                close: true,
                            minWidth: 400,
                            minHeight: 200,
                            //overlayCss: {backgroundColor:"#000"},
                            containerCss: {backgroundColor:"#EAEDDC", minHeight:200, minWidth: 400}
            });
    });
</script>
