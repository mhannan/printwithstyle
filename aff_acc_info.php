<?php 
	include("lib/func.common.php");
	
	
	$user_id = $_SESSION['aff_user_id'];
	$res=$objDb->SelectTable(USERS,"*","id='$user_id'");
	$row=mysql_fetch_array($res);
	
	$username=$row['u_name'];
	$password=$row['password'];
	$email=$row['email'];
	$r_type=$row['r_type'];
	$contact_name=$row['contact_name'];
	$contact_phone=$row['contact_phone'];
	$contact_address=$row['contact_address'];
	$designation=$row['designation'];
	$city=$row['city'];
	$country=$row['country'];
	$region=$row['region'];

        $profile_pic_path = "images/no-photo.jpg";
        if($row['profile_pic_path'] !='')
            $profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];



 
?>    

<div class="body_internal_wrapper">
<?php include("leftsection_affiliate.php") ?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
<?php 

 if($_REQUEST['msg'] == "succ")
 {
	echo "<div class='alert_success'><div>Information saved successfully.</div></div>";
 }
?>

<!-- ****************** EDITABLE ACCOUNT FORM ******************** -->


     <div class="newcontact_information"  id='account_editable_info_block'><!--Contact Informaton-->
           <div class="newodd-contact-main">
               Update Your Account
            </div>

                <form name="register" id="register" action="do_update_aff_account.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="task" value="updateaccount">
                            <div class="neweven-contact">
                              <div class="newtitle-contact">Name </div>
                              <div class="newvalue-contact"><input name="fname" id="fname" type="text" class="tscompany_inputfield required" value="<?php echo $username ?>" /></div>
                            </div>
                             <div class="neweven-contact" style="display:none">
                              <div class="newtitle-contact">Email </div>
                              <div class="newvalue-contact"><input name="user_email" id="user_email" type="text" class="tscompany_inputfield required" value="<?php echo $email ?>" /></div>
                            </div>
                             <div class="neweven-contact">
                              <div class="newtitle-contact">New Password <span style="font-size:10px">(leave empty to keep current password)</span></div>
                              <div class="newvalue-contact"><input name="password" id="password" type="password" class="tscompany_inputfield" value="" /></div>
                            </div>

                            <div class="neweven-contact">
                              <div class="newtitle-contact">Contact Phones
                              </div><div class="newvalue-contact"><input name="contact_phone" id="contact_phone" type="text" class="tscompany_inputfield" value="<?php echo $contact_phone ?>" /></div>
                            </div>
                            <div class="neweven-contact">
                              <div class="newtitle-contact">Contact Address </div>
                              <div class="newvalue-contact"><input name="address" id="address" type="text" class="tscompany_inputfield" value="<?php echo $contact_address ?>" /></div>
                            </div>

                            <div class="newodd-contact">
                              <div class="newtitle-contact1">City</div>
                              <div class="newvalue-contact1"><input name="city" id="city" type="text" class="tscompany_inputfield" value="<?php echo $city ?>" /></div>
                            </div>
                            <div class="neweven-contact">
                              <div class="newtitle-contact">Country </div><div class="newvalue-contact"><?php echo getCountries_selectList('country','country', $country); ?></div>
                            </div>

                            

                            <div class="neweven-contact">
                              <div class="newtitle-contact"> </div>
                              <div class="newvalue-contact"><input name="submit" type="submit" class="tscompany_inputbtn_save" value="" /></div>
                            </div>
                            <div style="clear:both"></div>
                </form>

         <div style="clear:both"></div>
      </div>

      <div style="clear:both"></div>

      </div><!--home_invitatins_wrapp--> 
    </div><!--body_right--> 
  </div><!--body_internal_wrapp--> <div style="clear:both"></div>

