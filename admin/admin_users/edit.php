<?php
require('include/gatekeeper.php');
$_SESSION['urlselected'] = "";
require('../header.php');
require_once('../lib/func.common.php');
require_once('../lib/func.user.php');
	   
       if(isset($_REQUEST['user_id']))
	   $userRs = getAdmin_users($_REQUEST['user_id']);
           $userRec = mysql_fetch_array($userRs);
?>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

  <div class="content-box-header">
    <h3>Manage Users</h3>
   
  </div>
  	
  <div class="content-box-content">
 
  <h3> Edit User </h3>
  <form action="do_edit_user.php" method="post" name="manage_account" id="manage_account" onsubmit="return validate_user()">
    <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
      <tr>
        <td style="padding:4px">First Name</td>
        <td style="padding:4px"><input class="text-input small-input" type="text" id="firstname" name="firstname" value="<?php echo $userRec['first_name']?>" /></td>
      </tr>
      <tr>
        <td style="padding:4px">Last Name</td>
        <td style="padding:4px"><input class="text-input small-input" type="text" id="lastname" name="lastname" value="<?php echo $userRec['last_name']?>" /></td>
      </tr>
      <tr>
        <td style="padding:4px; width:300px">Password</td>
        <td style="padding:4px"><input class="text-input small-input" type="password" id="password" name="admin_password" value="<?php echo $userRec['user_password']?>" />
            <div style="margin-left:15px; width: 150px; display:inline"><input type="checkbox" name="change_pw" id="change_pw"> Change Password
        </td>
      </tr>
      <tr>
        <td style="padding:4px">Email</td>
        <td style="padding:4px"><input class="text-input small-input" type="text" id="email" name="email" value="<?php echo $userRec['user_email']?>"/></td>
      </tr>
      <tr>
        <td style="padding:4px">Phone No.</td>
        <td style="padding:4px"><input class="text-input small-input" type="text" id="phone_no" name="phone_no" value="<?php echo $userRec['user_phone']?>"/></td>
      </tr>
      <tr>
        <td style="padding:4px">Mobile No.</td>
        <td style="padding:4px"><input class="text-input small-input" type="text" id="mobile" name="mobile" value="<?php echo $userRec['user_mobile']?>"/></td>
      </tr>
       <tr>
        <td style="padding:4px">Country</td>
        <td style="padding:4px"><?php echo getCountries_selectList('countryTxt', 'countryTxt', $userRec['user_country']); // display drop down country with saved country id ?></td>
      </tr>
      <tr>
        <td style="padding:4px">City</td>
        <td style="padding:4px"><input class="text-input small-input" type="text" id="city" name="city" value="<?php echo $userRec['user_city']?>"/></td>
      </tr>
      <tr>
        <td style="padding:4px">Address</td>
        <td style="padding:4px"><input class="text-input large-input" type="text" id="address" name="address" value="<?php echo $userRec['user_address']?>" style="width:50% ! important"/></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;<br />
         <input type="hidden" name="admin_id" value="<?php echo $_REQUEST['user_id']?>">
          <input class="button" type="submit" value="Submit" /></td>
      </tr>
    </table>
    
    <!-- End .clear -->
  </form>
</div>
</div>
</div>
 <script type="text/javascript">

function validate_user()
{
	var flag = true;
	
	if($('#fullname').val() =="")
	 {
		$('#fullname').css('border', '1px solid #FF1111');
		flag = false;
	 }
	else
		$('#fullname').css('border', '1px solid #d8d9db');
		
	if($('#username').val() =="")
	 {
		$('#username').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#username').css('border', '1px solid #d8d9db');
		
	if($('#password').val() =="")
	 {
		$('#password').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#password').css('border', '1px solid #d8d9db');
		
	if($('#email').val() =="")
	 {
		$('#email').css('border', '1px solid #FF1111');
		flag = false;
	 }
	 else
		$('#emai').css('border', '1px solid #d8d9db');
		
	 

	return flag;
}
 
</script>
</body>
</html>
