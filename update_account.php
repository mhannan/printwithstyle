<?php 
	include("lib/func.common.php");
	$user_id = $_SESSION['user_id'];
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
<?php include("leftsection_member.php") ?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
<?php 

 if($_REQUEST['msg'] == "succ")
 {
	echo "<div class='alert_success'><div>Information saved successfully.</div></div>";
 }
?>

<script language="javascript">
 function showblock(element_id)
 {
 	$('#'+element_id).show();
	$('#account_info_block').hide();
 }
</script>


	<div class="newcontact_information" id='account_info_block'><!--Contact Informaton-->
           <div class="newodd-contact-main">
              	<div  style="float:left; width:150px"> My Account </div>
				<div style="float:left;  margin-top:3px">
					<a href="javascript:showblock('account_editable_info_block');" onclick="showblock('account_editable_info_block')">
						<img src="images/icons/pencil.png" border='0'/></a></div>
				<div style="float:right; margin-right:20px"><!-- <a href='index.php?p=member_orders' class="link_12">0 - New Orders</a>--></div>
				<div style="clear:both"></div>
            </div>
			
        
            <div class="neweven-contact">
              <div class="newtitle-contact">Name </div>
              <div class="newvalue-contact"><?php echo $username ?></div>
            </div>
             <div class="neweven-contact">
              <div class="newtitle-contact">Email </div>
              <div class="newvalue-contact"><?php echo $email ?></div>
            </div>
            
            <div class="neweven-contact">
              <div class="newtitle-contact">Contact Phones 
              </div><div class="newvalue-contact"><?php echo $contact_phone ?></div>
            </div>
            <div class="neweven-contact">
              <div class="newtitle-contact">Address </div>
              <div class="newvalue-contact"><?php echo $contact_address.', '.$city.','.getCountryTitle_byId($country); ?></div>
            </div>

            
       </div>


<!-- ****************** EDITABLE ACCOUNT FORM ******************** -->


     <div class="newcontact_information" style="display:none" id='account_editable_info_block'><!--Contact Informaton-->
           <div class="newodd-contact-main">
               Update Your Account
            </div>
<form name="register" id="register" action="lib/func.updateaccount.php" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="task" value="updateaccount">          
            <div class="neweven-contact">
              <div class="newtitle-contact">Name </div>
              <div class="newvalue-contact"><input name="fname" id="fname" type="text" class="tscompany_inputfield required" value="<?php echo $username ?>" /></div>
            </div>
             <div class="neweven-contact">
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

            <div class="neweven-contact" style="height:auto">
              <div class="newtitle-contact">Profile Photo </div>
              <div class="newvalue-contact"><input name="profile_pic" id="profile_pic" type="file" >
                            <span style="font-size:10px">(leave empty to keep older unchanged)</span>
                            <div style="margin-top:8px">
                                <img src="<?php echo $profile_pic_path;?>" width="<?php
                                                                                        list($width, $height, $type, $attr)= getimagesize($profile_pic_path);

                                                                                        //specify what percentage you are resizing to
                                                                                        /*$percent_resizing = 80;

                                                                                        $new_width = round((($percent_resizing/100)*$width));
                                                                                        $new_height = round((($percent_resizing/100)*$height));*/
                                                                                        if($width>140)
                                                                                            echo "140px";
                                                                                        else
                                                                                            echo $width."px";
                                                                                    ?>" style="padding:3px; border:1px solid #ccc"></div>
              </div>
            </div>
            
            <div class="neweven-contact">
              <div class="newtitle-contact"> </div>
              <div class="newvalue-contact"><input name="submit" type="submit" class="tscompany_inputbtn_save" value="" /></div>
            </div>
</form>            
       </div>
      </div><!--home_invitatins_wrapp-->
    </div><!--body_right-->
  </div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
