<?php
require('include/gatekeeper.php');
require('../header.php');
require_once("../lib/func.banner.php");

	   
       if(isset($_REQUEST['banner_id']))
       {
	   $banner_res =  getBanner($_REQUEST['banner_id']);
           $row = mysql_fetch_array($banner_res);
       }

?>

<script type="text/javascript">

 /* <-- To Do --> */

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3>Edit Banner</h3>

    </div>
  	
    <div class="content-box-content">
 
     
                             <form action="do_edit_banner.php" method="post" name="manage_account" enctype="multipart/form-data" id="manage_account" >

                                    <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                                      <tr>
                                             <td style="padding:4px">Banner Title <input type="hidden" name="banner_id"  value="<?php echo $row['affiliate_banner_id']; ?>"> </td>
                                             <td style="padding:4px"> <input class="text-input small-input" type="text" id="banner_title" name="banner_title" value="<?php echo $row['banner_title']; ?>"  /></td>
                                      </tr>

                                      <tr>
                                        <td style="padding:4px">Banner</td>
                                        <td style="padding:4px"><input  type="file" id="banner_file" name="banner_file"  /> <span style="font-size:10px; color:#666">(Leave blank to keep old file unchanged)</span>
                                            <?php if($row['banner_path'] != "")
                                                     {
                                                        echo "<input type='hidden' name='old_banner_filename' value='".$row['banner_path']."'>";
                                                        echo "<br><img src='../../uploads/affiliate_banners/".$row['banner_path']."' height='100px' style='border:1px solid #666'>";
                                                     }
                                               ?>
                                            <br>

                                        </td>
                                     </tr>
                                     <tr>
                                         <td style="padding:4px">Banner Size</td>
                                         <td style="padding:4px; line-height: 32px">
                                                                 Width: &nbsp;<input style="width:60px !important" class="text-input small-input" type="text" name="banner_width"  value="<?php echo $row['banner_width_px']; ?>"> PX<br>
                                                                 Height: <input style="width:60px !important" class="text-input small-input" type="text" name="banner_height" value="<?php echo $row['banner_width_px']; ?>"> PX</td>
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
