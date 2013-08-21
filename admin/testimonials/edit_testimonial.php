<?php
require('include/gatekeeper.php');
require('../header.php');
require_once("../lib/func.testimonial.php");
	   
       if(isset($_REQUEST['testimonial_id']))
	   $testimonialSet =  getTestimonial_info($_REQUEST['testimonial_id']);
           $row = mysql_fetch_array($testimonialSet);// print_r($bankAccountRec);
           
?>

<script type="text/javascript">

  $(function() {
		$( "#start_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#end_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});

</script>

<div id="main-content">
<!-- Main Content Section with everything -->
<div class="tab-content">

    <div class="content-box-header">
        <h3> Edit Testimonial </h3>

    </div>
  	
    <div class="content-box-content">
 
      <h3> Author : <span style="color:#999"><?php echo $row['u_name']; ?></span> </h3>
      <form action="do_edit_testimonial.php" method="post" name="manage_account" id="myform" enctype="multipart/form-data">

                <table border="0" cellpadding="4" cellspacing="4" width="100%" style="padding:4px">
                      <tr>
                             <td style="padding:4px;vertical-align:top; text-align:center" width="30%">Testimonial <input type="hidden" name="testimonial_id" value="<?php echo $_GET['testimonial_id']; ?>"></td>
                             <td style="padding:4px" width="60%"> <textarea class="text-input small-input required" id="txtField" name="testimonial_text" style="width:450px !important; height: 100px"  ><?php echo $row['testimonial']; ?></textarea></td>
                      </tr>
                      

                      <!--<tr>
                        <td style="padding:4px">Select Card Background</td>
                        <td style="padding:4px"><input class="text-input small-input required" type="file" id="txtField" name="card_bg"  /></td>
                      </tr> -->


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
