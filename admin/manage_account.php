<?php
require('include/gatekeeper.php');
$_SESSION['urlselected'] = '';
require('header.php');
require_once('lib/func.common.php');

$admin_info_rec = userInfo_rec();   // if no ID passed, will return SESSION user info

if(isset($_POST['submit']))
{
    $return_data = update_admin($_POST);
    if($return_data[0] == '0')
        $errmsg = $return_data[1];  // index[0] contains value 0/1 for failure or success, and index[1] contains string
    else
        $okmsg = $return_data[1];
}
?>
 
<div class="clear"></div>
<!-- End .clear -->
<?php
    if(isset($_GET['okmsg']))
    {
?>
    <div class="notification success png_bg"> <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
      <div> <?php echo base64_decode($_GET['okmsg']);?> </div>
    </div>
<?php			
    }
    elseif(isset($okmsg) && $okmsg != "")
    {
   ?>
    <div class="notification success png_bg"> <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
      <div> <?php echo base64_decode($okmsg);?> </div>
    </div>
<?php
    }

    if(isset($_GET['errmsg']))
    {
?>
    <div class="notification error png_bg"> <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
      <div> <?php echo base64_decode($_GET['errmsg']);?> </div>
    </div>
<?php			
    }
 elseif(isset($errmsg) && $errmsg != "")
 {
 ?>
    <div class="notification error png_bg"> <a href="#" class="close"><img src="<?php echo siteURL?>admin/resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
      <div> <?php echo base64_decode($errmsg);?> </div>
    </div>
<?php
 }
?>
<br />
<br />
<div class="content-box" style="margin-left:50px; margin-right:50px">
  <!-- Start Content Box -->
  <div class="content-box-header">
    <h3>Manage Account </h3>
    <div class="clear"></div>
  </div>
  <!-- End .content-box-header -->
  <div class="content-box-content">
    <form action="" method="post" name="manage_account" id="manage_account" onsubmit="return validate_admin()">
		
		<table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
		  <tr>
		  	 <td style="padding:4px">First Name <input type="hidden" name="admin_id" value="<?php echo $admin_info_rec['user_id']; ?>"></td>
			 <td style="padding:4px"> <input class="text-input small-input" type="text" id="firstname" name="firstname" value="<?php echo $admin_info_rec['first_name']; ?>" /></td>
		  </tr>
                  <tr>
		  	 <td style="padding:4px">Last Name</td>
			 <td style="padding:4px"> <input class="text-input small-input" type="text" id="lastname" name="lastname" value="<?php echo $admin_info_rec['last_name']; ?>" /></td>
		  </tr>
		  
		  <tr>
		  	 <td style="padding:4px">Email</td>
			 <td style="padding:4px"><input class="text-input small-input" type="text" id="email" name="email" value="<?php echo $admin_info_rec['user_email']; ?>"/></td>
		  </tr>
		  <tr>
		  	 <td style="padding:4px">Phone No.</td>
			 <td style="padding:4px"><input class="text-input small-input" type="text" id="phone_no" name="phone_no" value="<?php echo $admin_info_rec['user_phone']?>"/></td>
		  </tr>
		  <tr>
		  	 <td style="padding:4px">Mobile No.</td>
			 <td style="padding:4px"><input class="text-input small-input" type="text" id="mobile" name="mobile" value="<?php echo $admin_info_rec['user_mobile']?>"/></td>
		  </tr>
		  <tr>
		  	 <td style="padding:4px">Country</td>
			 <td style="padding:4px">
                             <?php echo getCountries_selectList('countryTxt', 'countryTxt', $admin_info_rec['user_country']); // display drop down country with saved country id ?>
                         </td>
		  </tr>
		  <tr>
		  	 <td style="padding:4px">State</td>
			 <td style="padding:4px"><input class="text-input small-input" type="text" id="state" name="state" value="<?php echo $admin_info_rec['state']?>"/></td>
		  </tr>
		  <tr>
		  	 <td style="padding:4px">City</td>
			 <td style="padding:4px"><input class="text-input small-input" type="text" id="city" name="city" value="<?php echo $admin_info_rec['user_city']?>"/></td>
		  </tr>
		  <tr>
		  	 <td style="padding:4px">Address</td>
			 <td style="padding:4px"><input class="text-input large-input" type="text" id="address" name="address" value="<?php echo $admin_info_rec['user_address']?>" style="width:50% ! important"/></td>
		  </tr>
                 <tr>
		  	 <td style="padding:4px">Change Password</td>
			 <td style="padding:4px"><input type="checkbox" id="change_pw" name="change_pw" onchange="show_this(this);"/></tr>
		  <tr>
              <tr id="_pw" style="display:none">
                 <td style="padding:4px">Password</td>
                 <td style="padding:4px"><input class="text-input small-input" type="password" id="admin_password" name="admin_password" /></td>
              </tr>
              <tr id="_cpw" style="display:none">
                <td style="padding:4px">Confirm Password</td>
                <td style="padding:4px"><input class="text-input small-input" type="password" id="admin_cpassword" name="admin_cpassword" /></td>
              </tr>
          
             <tr><td></td> <td>&nbsp;<br /><input class="button" name="submit" type="submit" value="Submit" /></td></tr>
	</table>
        
      <!-- End .clear -->
    </form>
  </div>
  <!-- End .content-box-content -->
</div>
<!-- End .content-box -->
<!-- End .content-box -->
<!-- End .content-box -->
<div class="clear"></div>
<!-- Start Notifications -->
<!-- End Notifications -->
<div id="footer"> <small>
  <!-- Remove this notice or replace it with whatever you want -->
  </small> </div>
<!-- End #footer -->
</div>
<!-- End #main-content -->
</div>
</body><!-- Download From www.exet.tk-->
</html>