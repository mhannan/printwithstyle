<div class="body_internal_wrapper">
<?php include("leftsection1.php") ;
	  include("lib/func.common.php");
?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
<?php 
 $alert_msg = "";
 if(isset($_POST) && $_POST['msg_txt']!= "")
	{
		$res = $objDb->SelectTable('admin', 'user_email',  "user_id = '1'");
		$rec = mysql_fetch_array($res);
		
		$to = $rec['user_email'];
		$subject = '';
		$msg = 'You have received following Message through site ContactUs Form:\n--------------------------------------------\nVisitor Name: '.$_POST["name"].'\nEmail: '.$_POST["user_email"].'\nMessage:\n'.$_POST['msg_txt'];
		$from = '';
		
		mail($to, 'Visitor Message - SendWithStyle Contact Form', $msg, 'from:'.$_POST["user_email"]);
		$alert_msg = "Thank you for contacting us. Your email has been sent successfully, and our support team will reply back to you shortly.";
	}
	
 if($alert_msg != "")
	{
		echo "<div class='alert_success'><div>".$alert_msg."</div></div>";
	}

?>
     <div class="newcontact_information"><!--Contact Informaton-->
           <div class="newodd-contact-main" style="float:none">
               Contact Us
            </div>
<form name="register" id="register" action="" method="post" enctype="multipart/form-data"> 
          
            <div class="neweven-contact">
              <div class="newtitle-contact">Name </div>
              <div class="newvalue-contact"><input name="name" id="name" type="text" class="tscompany_inputfield required" /></div>
            </div>
             <div class="neweven-contact">
              <div class="newtitle-contact" >Email </div>
              <div class="newvalue-contact"><input name="user_email" id="user_email" type="text" class="tscompany_inputfield required" /></div>
            </div>
             <div class="neweven-contact" style="height:auto">
              <div class="newtitle-contact" style="float:none; height:auto; width:auto">Message <br />
			  	<textarea name='msg_txt' id="msg_txt" class="tscompany_inputfield required" style="width:560px; height:200px; border:1px solid #D0D0D0; background-color:#F6F6F6; float:none"></textarea>
				
				<div align="right" style="width:560px; margin:15px 5px">
					<input name="submit" type="submit" class="tscompany_inputbtn_send" value="" /></div>
			  </div>
              
            </div>
            <div style="clear:both"></div>
            
            
</form>

         <div style="margin:10px 0px 0px 20px; background-image:url(images/icons/telephone_call_contact.png); padding-left:20px; background-repeat:no-repeat; background-position:left; height:20px; "><h2>Direct Contact:</h2></div>
         <div class="newtitle-contact" style="padding-left:25px">Phone</div>
         <div class="newvalue-contact"><?php $admin_info =  getAdminProfile_phone();  echo $admin_info['user_phone']; ?></div>
         <div style="clear:both"></div>

       </div>
      </div><!--home_invitatins_wrapp-->
    </div><!--body_right-->
  </div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
