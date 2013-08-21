<div class="body_internal_wrapper">
<?php include("leftsection1.php") ;
	  include("lib/func.common.php");
?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
<?php 
if($_REQUEST['msg'] == "errr")
{
	echo "<span class='err'>Confirm Password is mismatch.</span>";
}
else if($_REQUEST['msg'] == "alr1")
{
	echo "<span class='err'>Username Already Exists.Try Again.</span>";
}
else if($_REQUEST['msg'] == "alr2")
{
	echo "<span class='err'>Email Already Exists.Try Again.</span>";
}
else if($_REQUEST['msg'] == "succ")
{
	echo "<span class='succ'>Registration has been Completed Successfully.</span>";
}

?>
     <div class="newcontact_information"><!--Contact Informaton-->
           <div class="newodd-contact-main">
               Register With Us
            </div>
<form name="register" id="register" action="lib/func.register.php" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="task" value="customer_register">          
            <div class="neweven-contact">
              <div class="newtitle-contact">Name </div>
              <div class="newvalue-contact"><input name="fname" id="fname" type="text" class="tscompany_inputfield required" /></div>
            </div>
             <div class="neweven-contact">
              <div class="newtitle-contact">Email </div>
              <div class="newvalue-contact"><input name="user_email" id="user_email" type="text" class="tscompany_inputfield required" /></div>
            </div>
             <div class="neweven-contact">
              <div class="newtitle-contact">Password </div>
              <div class="newvalue-contact"><input name="password" id="password" type="password" class="tscompany_inputfield required" /></div>
            </div>
             <div class="neweven-contact">
              <div class="newtitle-contact">Confirm Password </div>
              <div class="newvalue-contact"><input name="c_password" id="c_password" type="password" class="tscompany_inputfield required" /></div>
            </div>
            <div style="display:none" id="remove_by_client">
                        <div class="newodd-contact">
                          <div class="newtitle-contact1">Representative Type</div>
                          <div class="newvalue-contact1"><input name="r_type" id="r_type" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="neweven-contact">
                          <div class="newtitle-contact">Contact Name </div>
                          <div class="newvalue-contact"><input name="contact_name" id="contact_name" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="neweven-contact">
                          <div class="newtitle-contact">Contact Phones
                          </div><div class="newvalue-contact"><input name="contact_phone" id="contact_phone" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="neweven-contact">
                          <div class="newtitle-contact">Contact Address </div>
                          <div class="newvalue-contact"><input name="address" id="address" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="newodd-contact">
                          <div class="newtitle-contact1">Designation/ Roles </div>
                          <div class="newvalue-contact1"><input name="role" id="role" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="newodd-contact">
                          <div class="newtitle-contact1">City</div>
                          <div class="newvalue-contact1"><input name="city" id="city" type="text" class="tscompany_inputfield" /></div>
                        </div>
                        <div class="neweven-contact">
                          <div class="newtitle-contact">Country </div><div class="newvalue-contact"><?php echo getCountries_selectList('country','country'); ?> </div>
                        </div>
                        <div class="newodd-contact">
                          <div class="newtitle-contact1">Region</div>
                          <div class="newvalue-contact1"><input name="region" id="region" type="text" class="tscompany_inputfield" /></div>
                        </div>
            </div>

            <div class="neweven-contact">
              <div class="newtitle-contact"> </div>
              <div class="newvalue-contact"><input name="submit" type="submit" class="tscompany_inputbtn2" value="" /></div>
            </div>
            
</form>            
       </div>
      </div><!--home_invitatins_wrapp-->
    </div><!--body_right-->
  </div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
