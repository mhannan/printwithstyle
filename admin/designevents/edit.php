<?php
require('include/gatekeeper.php');
require('../header.php');
//require_once('../lib/func.common.php');
require_once("../lib/func.customer.packages.php");
	   
       if(isset($_REQUEST['package_id']))
	   $packageSet =  getPackage_info($_REQUEST['package_id']);
           $packageRec = mysql_fetch_array($packageSet);// print_r($bankAccountRec);
?>

<script type="text/javascript">

 /* <-- To Do --> */

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Manage Packages</h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Edit Package Detail </h3>
       <form action="do_edit_package.php" method="post" name="manage_account" id="myform">

                <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                  <tr>
                         <td style="padding:4px">Package Title <input type="hidden" name="packageID" value="<?php echo $packageRec['package_id']; ?>"/></td>
                         <td style="padding:4px"> <input class="text-input small-input required" type="text" id="txtField" name="packageTitle" value="<?php echo $packageRec['package_title']; ?>"/></td>
                  </tr>

                  <tr>
                    <td style="padding:4px">Description</td>
                    <td style="padding:4px"><input class="text-input small-input required" type="text" id="txtField" name="description"  value="<?php echo $packageRec['package_description']; ?>" /></td>
                  </tr>
                  <tr>
                     <td style="padding:4px">Price</td>
                     <td style="padding:4px"> $ <input  style="width:100px !important" class="text-input small-input required number" type="text" id="numberField" name="price"   value="<?php echo $packageRec['package_price']; ?>"/></td>
                  </tr>
                  <tr>
                      <td style="padding:4px">Pages/ Album</td>
                      <td style="padding:4px"><input class="text-input small-input required digit" type="text" id="digitField" name="pages_per_album"  value="<?php echo $packageRec['pages_per_album']; ?>" /></td>
                  </tr>
                  <tr>
                         <td style="padding:4px">Allowed Total Albums</td>
                         <td style="padding:4px"><input class="text-input small-input required digit" type="text" id="digitField" name="allowed_albums"  value="<?php echo $packageRec['package_albums']; ?>" /></td>
                  </tr>
                  <tr>
                         <td style="padding:4px">Other Features</td>
                         <td style="padding:4px"><input type="checkbox" value="1" <?php if($packageRec['is_album_editable']=='1') echo "Checked='checked'"; ?> name="albumEditable"> Allow to Edit Album Pages
                                                <input type="checkbox" value="1" <?php if($packageRec['has_shareable_url']=='1') echo "Checked='checked'"; ?> name="shareableURL"> Generate Shareable URL <span class="gray10">(i.e. http://www.mykeepsake.com/albumbook/2)</span>
                         </td>
                  </tr>
                  <tr>
                         <td style="padding:4px; background-color:#e6db55">Charges for Extra Album</td>
                         <td style="padding:4px; background-color:#e6db55"> <?php if($packageRec['could_buy_extra_album'] !='1')
                                                            $val = '';
                                                          else
                                                            $val = $packageRec['package_extra_album_charges'];
                                                   ?>
                             
                             $ <input  style="width:100px !important" class="text-input small-input number" type="text" id="numberField" name="extraAlbumCharges"  value="<?php echo $val; ?>" />
                                                <br><span class="gray10">(Leave empty if you don't want to give this feature, put '0' to allow this feature for free)</span></td>
                  </tr>
                  <tr>
                         <td style="padding:4px; background-color:#e6db55">Charges for Extra Page</td>
                         <td style="padding:4px; background-color:#e6db55"> <?php if($packageRec['could_buy_extra_page'] !='1')
                                                            $val = '';
                                                          else
                                                            $val = $packageRec['package_extra_page_charges'];
                                                   ?>

                             $ <input  style="width:100px !important" class="text-input small-input number" type="text" id="numberField" name="extraAlbumCharges"  value="<?php echo $val; ?>" />
                                                <br><span class="gray10">(Leave empty if you don't want to give this feature, put '0' to allow this feature for free)</span></td>
                  </tr>


                  <tr><td></td> <td>&nbsp;<br /><input class="button" type="submit" value="Submit" /></td></tr>
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
