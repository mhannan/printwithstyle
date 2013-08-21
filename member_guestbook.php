<?php 
	//include("lib/func.common.php");
        
        include("lib/func.user.guest.php");
	
	
	$user_id = $_SESSION['user_id'];
	$res=$objDb->SelectTable(USERS,"*","id='$user_id'");
	$row=mysql_fetch_array($res);

        $msg = $_GET['msg'];
	if(isset($_POST) && $_POST['guestName'] != '')
        {
            if(save_guest($_POST, $objDb))
            {
                header('Location: index.php?p=member_guestbook&msg=succ'); exit();
            }
            else
            {
                header('Location: index.php?p=member_guestbook&msg=err'); exit();
            }
               
        }

?>    

<div class="body_internal_wrapper">
<?php 
				$profile_pic_path = "images/no-photo.jpg";
				if($row['profile_pic_path'] !='')
								$profile_pic_path = "uploads/customer_profile_pics/".$row['profile_pic_path'];
								
				include("leftsection_member.php") 
?>
   <div class="body_right"><!--body_right-->
     <div class="home_wedng_inv_wrapp"><!--home_invitatins_wrapp-->
<?php 

 if($msg  == "succ")
 {
     if(isset($_GET['str']))
         echo "<div class='alert_success'><div>".base64_decode($_GET['str'])."</div></div>";
     else
 	echo "<div class='alert_success'><div>Guest added saved successfully.</div></div>";
 }
  elseif($msg == 'err')
  {
      if(isset($_GET['str']))
          echo "<div class='alert_success'><div>".base64_decode($_GET['str'])."</div></div>";
      else
        echo "<div class='alert_success'><div>Unable to add guest.</div></div>";
  }
  

?>

<script language="javascript">
 function load_edit(row_id)
 {
								$('#guestName').val( $('#name_'+row_id).html() );
        $('#guestAddr').val( $('#addr_'+row_id).html() );
        $('#guestCity').val( $('#city_'+row_id).html() );
        $('#guestState').val( $('#state_'+row_id).html() );
        $('#guestZip').val( $('#zip_'+row_id).html() );
        $('#guestCountry').val( $('#country_'+row_id).html() );
								$('#guest_id').val( $('#guestID_'+row_id).val() );
	
        $('#reset_btn').show();
 }

 function reset_form()
 {
     $('#guestName').fadeOut(200).val('').fadeIn(200);
     $('#guestAddr').fadeOut(200).val('').fadeIn(200);
     $('#guestCity').fadeOut(200).val('').fadeIn(200);
     $('#guestState').fadeOut(200).val('').fadeIn(200);
     $('#guestZip').fadeOut(200).val('').fadeIn(200);
     $('#guestCountry').fadeOut(200).val('').fadeIn(200);
     $('#guest_id').val('0').fadeOut(200).fadeIn(200);
     $('#reset_btn').fadeOut(200);
 }

</script>

        <a id="frm" name="frm">&nbsp;</a>
         <form method="post" action="" name="guestForm">
            <div class="newcontact_information" id='account_info_block'><!--Contact Informaton-->
               <div class="newodd-contact-main">
                    <div  style="width:150px"> My Guest Book </div>
                </div>


                <div class="neweven-contact">
                  <div class="newtitle-contact">Guest Name </div>
                  <div class="newvalue-contact"><input name="guestName" id="guestName" type="text" class="tscompany_inputfield required" value="" /></div>
                </div>
                 <div class="neweven-contact">
                  <div class="newtitle-contact">Address </div>
                  <div class="newvalue-contact"><input name="guestAddr" id="guestAddr" type="text" class="tscompany_inputfield required" value="" /></div>
                </div>

                <div class="neweven-contact">
                  <div class="newtitle-contact">City
                  </div><div class="newvalue-contact"><input name="guestCity" id="guestCity" type="text" class="tscompany_inputfield required" value="" /></div>
                </div>
                <div class="neweven-contact">
                  <div class="newtitle-contact">State
                  </div><div class="newvalue-contact"><input name="guestState" id="guestState" type="text" class="tscompany_inputfield required" value="" /></div>
                </div>
                <div class="neweven-contact">
                  <div class="newtitle-contact">Zip Code
                  </div><div class="newvalue-contact"><input name="guestZip" id="guestZip" type="text" class="tscompany_inputfield required" value="" /></div>
                </div>
                <div class="neweven-contact">
                  <div class="newtitle-contact">Country
                  </div><div class="newvalue-contact"><input name="guestCountry" id="guestCountry" type="text" class="tscompany_inputfield required" value="" /></div>
                </div>
                <div class="neweven-contact">
                  <div class="newtitle-contact"> <input type="hidden" id="guest_id" name="guest_id" value="0"> </div>
                  <div class="newvalue-contact"><input name="submit" type="submit" class="tscompany_inputbtn_save" value="" />
                        <input style="display:none" id="reset_btn" name="reset" type="button" class="tscompany_inputbtn_cancel" value="" onclick="reset_form()" />
                    </div>
                </div>
           </div>
         </form>

		<!-- ****************** Contacts Listing FORM ******************** -->
			<table border="0" cellpadding="4" cellspacing="1" width="100%" bgcolor="#eee" class="listing_tbl" style="margin-top:10px">
				<tr>
					<th>Sr#</th> 
					<th >Guest Name</th> 
					<th >Mailing Address</th> 
					<th >City</th> 
					<th >State</th> 
					<th >Zip</th> 
					<th >Country</th> <th ></th>
				</tr>
                                <?php
                                    $res = getCustomer_guests($_SESSION['user_id'], $objDb);
                                    $i= 1;
                                    while($row = mysql_fetch_array($res))
                                    {
																																								$objArray = unserialize($row['recipient_address']);
                                ?>
				<tr>
					<td><?php echo $i; ?> <input type="hidden" id="guestID_<?php echo $i; ?>" value="<?php echo $row['guest_id']; ?>"></td>
                                        <td id="name_<?php echo $i; ?>"><?php echo $objArray['_name']; ?></td>
                                        <td id="addr_<?php echo $i; ?>"><?php echo $objArray['_address']; ?></td>
                                        <td id="city_<?php echo $i; ?>"><?php echo $objArray['_city']; ?></td>
                                        <td id="state_<?php echo $i; ?>"><?php echo $objArray['_state']; ?></td>
                                        <td id="zip_<?php echo $i; ?>"><?php echo $objArray['_zip']; ?></td>
                                        <td id="country_<?php echo $i; ?>"><?php echo $objArray['_country']; ?></td>
                                        <td width="8%"><a href="#frm" onclick="load_edit('<?php echo $i; ?>');"><img src="images/icons/pencil.png" border="0"/></a>&nbsp;
                                            <a href="index.php?p=do_del_guest&gid=<?php echo $row['guest_id']; ?>" onclick="return confirm('Are you sure to delete?')" ><img src="images/icons/cross_circle.png" border="0" /></a>
                                        </td>
				</tr>
                                <?php
                                     $i++;
                                    }
                                    if($i==1)
                                        echo '<tr><td colspan="5" align="center">No record found.</td>'
                                ?>
			</table>

     
      </div><!--home_invitatins_wrapp-->
    </div><!--body_right-->
  </div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
