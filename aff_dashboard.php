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




	<div class="newcontact_information" id='account_info_block'><!--Contact Informaton-->
           <div class="newodd-contact-main">
              	<div  style="float:left; width:150px"> My Account </div>
				<!--<div style="float:left;  margin-top:3px">
					<a href="javascript:showblock('account_editable_info_block');" onclick="showblock('account_editable_info_block')">
						<img src="images/icons/pencil.png" border='0'/></a></div> -->
				<div style="float:right; margin-right:20px"><a class="link_12">Current Earning Balance: $<?php echo get_current_commission_balance($_SESSION['aff_user_id']); ?> </a></div>
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

            <div style="clear:both"></div>
       </div>
       

         <div style="float:left; width:250px; margin-top:10px">
                 <!-- ##############Latest Visits############### -->
                 <table border="0" cellpadding="4" cellspacing="1" bgcolor="#eee" width="250px">
                     <tr>
                         <td style="color:#29748C; background-color:#eee; font-size:18px" colspan="2"> Latest Visits</td>
                     </tr>
                     <tr>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Activity Time</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor IP</b></td>
                         <!--<td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor Location</b></td>-->
                     </tr>

                     <?php
                        $vRSet = getLatestVisits_byAffiliatID($_SESSION['aff_user_id'],'5');
                        $i=1;
                        while($vRow = mysql_fetch_array($vRSet))
                        {
                            echo '<td style="background-color:#fff;">'.date('d M-Y',strtotime($vRow['activity_time'])).'</td>
                                  <td style="background-color:#fff;">'.$vRow['visitor_ip'].'</td>
                                ';
                        }
                        if($i==1)
                            echo '<td style="background-color:#fff;" colspan="2">(No record found)</td>';
                     ?>
                     
                 </table>
         </div>
         <div style="float:right; width:460px; margin-top:10px">
                 <!-- ##############Latest Registrations############### -->
                 <table border="0" cellpadding="4" cellspacing="1" bgcolor="#eee" width="460px">
                     <tr>
                         <td style="color:#29748C; background-color:#eee; font-size:18px" colspan="4"> Latest Registrations</td>
                     </tr>
                     <tr>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Activity Time</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor IP</b></td>
                         <!--<td style="color:#29748C; background-color:#f5f5f5;"><b>Visitor Location</b></td>-->
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Name</b></td>
                         <td style="color:#29748C; background-color:#f5f5f5;"><b>Email</b></td>
                     </tr>
                     
                     <?php
                        $vRSet = getLatestRegistered_byAffiliatID($_SESSION['aff_user_id'],'5');
                        $i=1;
                        while($vRow = mysql_fetch_array($vRSet))
                        {
                            echo '<td style="background-color:#fff;">'.date('d M-Y',strtotime($vRow['activity_time'])).'</td>
                                  <td style="background-color:#fff;">'.$vRow['visitor_ip'].'</td>
                                  <td style="background-color:#fff;">'.$vRow['u_name'].'</td>
                                  <td style="background-color:#fff;">'.$vRow['email'].'</td>
                                ';
                        }
                        if($i==1)
                            echo '<td style="background-color:#fff;" colspan="4">(No record found)</td>';
                     ?>
                     
                 </table>
         </div>
         <div style="clear:both"></div>



         <div style="width:740px; margin-top:10px">
                 <!-- ##############Latest Registrations############### -->
                 <table border="0" cellpadding="4" cellspacing="1" bgcolor="#eee" width="740px">
                     <tr>
                         <td style="color:#29748C; background-color:#eee; font-size:18px" colspan="2"> Affiliate Code</td>
                     </tr>
                     <tr>
                         <td style="background-color:#fff;" colspan="2">You can use the various marketing material provided below in your website or blog that will generate traffic to the Send With Style website. Users who click and visit the site will add an activity to your affiliate log, and any purchases that they make will generate earnings in your affiliate account.</td>
                     </tr>
                     
                     <tr>
                         <td style="background-color:#fff;" >
                                 <div align="center" style="color:#0b559b"><b>Send With Style</b></div></td>
                         <td style="background-color:#fff;" >
                                <b>Code:</b><br><textarea style="width:220px; height:70px"><a href="http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?af_id=<?php echo base64_encode($_SESSION['aff_user_id'])?>">Send With Style</a></textarea></td>
                     </tr>
                     <tr>
                         <td style="background-color:#fff;" >
                                 <div align="center" style="color:#0b559b"><b>Send With Style</b> (custom invitation mailed for you)</div></td>
                         <td style="background-color:#fff;" >        <b>Code:</b><br><textarea style="width:220px; height:70px"><a href="http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?af_id=<?php echo base64_encode($_SESSION['aff_user_id'])?>"><b>Send With Style</b> (custom invitation mailed for you)</a></textarea>
                         </td></tr>
                     <tr>
                          <td style="background-color:#fff;" ><div align="center"><img src="images/logo2.png"/></div></td>
                          <td style="background-color:#fff;" ><b>Code:</b><br><textarea style="width:220px; height:70px"><a href="http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?af_id=<?php echo base64_encode($_SESSION['aff_user_id'])?>"><img src="http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/images/logo2.png"></a></textarea></td>
                          
                    </tr>
                             

                         
                     
                     <?php
                        $bRSet = getAffiliate_banner();
                        $i=1;
                        while($bRow = mysql_fetch_array($bRSet))
                        {
                            echo '<tr>
                                    <td style="background-color:#fff;" width="500px"><img src="uploads/affiliate_banners/'.$bRow['banner_path'].'"></td>
                                    <td style="background-color:#fff;" width="240px"><b>Code:</b><br>
                                                        <textarea style="width:220px; height:80px"><a href="http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/index.php?af_id='.base64_encode($_SESSION['aff_user_id']).'"><img src="http://www.designsoftstudios.net/demo22/custom_projects/invitation_card/uploads/affiliate_banners/'.$bRow['banner_path'].'"></a></textarea></td>
                                  </tr>
                                ';
                            $i++;
                        }
                        if($i==1)
                            echo '<td style="background-color:#fff;" >(No record found)</td>';
                     ?>

                 </table>
         </div>


      </div><!--home_invitatins_wrapp--> 
    </div><!--body_right--> 
  </div><!--body_internal_wrapp--> <div style="clear:both"></div>

